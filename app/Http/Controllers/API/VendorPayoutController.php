<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Handles vendor payout operations with support for both manual
 * and Stripe Connect modes.
 *
 * Admin can toggle payout mode via app_settings:
 *   - 'manual': Admin manually processes bank transfers
 *   - 'stripe_connect': Automated payouts via Stripe Connect
 *
 * Vendor flow:
 *   1. Vendor links their bank account (via Stripe Connect onboarding or manual entry)
 *   2. Vendor requests withdrawal from wallet
 *   3. System processes payout based on the configured mode
 */
class VendorPayoutController extends Controller
{
    /**
     * Get the current payout configuration for the vendor.
     * Returns payout mode, whether the vendor has linked their bank, etc.
     *
     * GET /api/vendor/payout/status
     */
    public function status(Request $request): JsonResponse
    {
        $user = auth()->user();
        $payoutMode = $this->getPayoutMode();

        $data = [
            'payout_mode' => $payoutMode,
            'has_stripe_connect' => !empty($user->stripe_connect_id),
            'stripe_onboarding_complete' => $user->stripe_connect_onboarded ?? false,
            'can_withdraw' => $this->canWithdraw($user, $payoutMode),
        ];

        return $this->sendResponse($data, 'Payout status retrieved');
    }

    /**
     * Create a Stripe Connect onboarding link for the vendor.
     * The vendor opens this URL to set up their bank account with Stripe.
     *
     * POST /api/vendor/payout/stripe-connect/onboard
     */
    public function createConnectOnboardingLink(Request $request): JsonResponse
    {
        $user = auth()->user();
        $payoutMode = $this->getPayoutMode();

        if ($payoutMode !== 'stripe_connect') {
            return $this->sendError('Stripe Connect is not enabled. Contact support to set up bank transfers.');
        }

        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

            // Create or retrieve the connected account
            if (empty($user->stripe_connect_id)) {
                $account = $stripe->accounts->create([
                    'type' => 'express',
                    'country' => 'GB',
                    'email' => $user->email,
                    'capabilities' => [
                        'transfers' => ['requested' => true],
                    ],
                    'business_type' => 'individual',
                    'metadata' => [
                        'ewa_user_id' => $user->id,
                    ],
                ]);

                $user->stripe_connect_id = $account->id;
                $user->save();
            }

            // Create an onboarding link
            $accountLink = $stripe->accountLinks->create([
                'account' => $user->stripe_connect_id,
                'refresh_url' => config('app.url') . '/api/vendor/payout/stripe-connect/refresh',
                'return_url' => config('app.url') . '/api/vendor/payout/stripe-connect/return',
                'type' => 'account_onboarding',
            ]);

            return $this->sendResponse([
                'onboarding_url' => $accountLink->url,
            ], 'Stripe Connect onboarding link created');

        } catch (\Exception $e) {
            Log::error('Stripe Connect onboarding failed: ' . $e->getMessage());
            return $this->sendError('Failed to create bank account setup. Please try again.');
        }
    }

    /**
     * Check if Stripe Connect onboarding is complete for the vendor.
     *
     * GET /api/vendor/payout/stripe-connect/check
     */
    public function checkConnectStatus(Request $request): JsonResponse
    {
        $user = auth()->user();

        if (empty($user->stripe_connect_id)) {
            return $this->sendResponse([
                'onboarded' => false,
                'message' => 'No Stripe account linked yet',
            ], 'Not onboarded');
        }

        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            $account = $stripe->accounts->retrieve($user->stripe_connect_id);

            $isOnboarded = $account->charges_enabled && $account->payouts_enabled;

            if ($isOnboarded && !($user->stripe_connect_onboarded ?? false)) {
                $user->stripe_connect_onboarded = true;
                $user->save();
            }

            return $this->sendResponse([
                'onboarded' => $isOnboarded,
                'charges_enabled' => $account->charges_enabled,
                'payouts_enabled' => $account->payouts_enabled,
            ], $isOnboarded ? 'Bank account fully set up' : 'Onboarding incomplete');

        } catch (\Exception $e) {
            Log::error('Stripe Connect status check failed: ' . $e->getMessage());
            return $this->sendError('Failed to check bank account status');
        }
    }

    /**
     * Request a withdrawal from vendor wallet.
     * Processes via Stripe Connect (automated) or Manual (creates a pending request).
     *
     * POST /api/vendor/payout/withdraw
     */
    public function withdraw(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'wallet_id' => 'required|exists:wallets,id',
        ]);

        $user = auth()->user();
        $payoutMode = $this->getPayoutMode();
        $amount = (float) $request->amount;

        // Verify wallet ownership
        $wallet = Wallet::where('id', $request->wallet_id)
            ->where('user_id', $user->id)
            ->where('enabled', true)
            ->first();

        if (!$wallet) {
            return $this->sendError('Wallet not found or not accessible');
        }

        if ($wallet->balance < $amount) {
            return $this->sendError('Insufficient balance. Available: £' . number_format($wallet->balance, 2));
        }

        // ── Payout Hold Period (7 days) ──
        // Funds received in the last 7 days are held for chargeback protection.
        $holdDays = (int) setting('vendor_payout_hold_days', 7);
        if ($holdDays > 0) {
            $heldAmount = WalletTransaction::where('wallet_id', $wallet->id)
                ->where('action', 'credit')
                ->where('created_at', '>=', now()->subDays($holdDays))
                ->sum('amount');

            $availableBalance = max(0, $wallet->balance - abs($heldAmount));

            if ($amount > $availableBalance) {
                $heldFormatted = number_format(abs($heldAmount), 2);
                $availableFormatted = number_format($availableBalance, 2);
                return $this->sendError(
                    "£{$heldFormatted} of your balance is held for {$holdDays} days (chargeback protection). " .
                    "Available for withdrawal now: £{$availableFormatted}"
                );
            }
        }

        try {
            DB::beginTransaction();

            if ($payoutMode === 'stripe_connect') {
                return $this->processStripeConnectPayout($user, $wallet, $amount);
            } else {
                return $this->processManualPayout($user, $wallet, $amount, $request->notes ?? '');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Withdrawal failed: " . $e->getMessage());
            return $this->sendError('Withdrawal request failed. Please try again.');
        }
    }

    /**
     * Process payout via Stripe Connect (automated bank transfer).
     */
    private function processStripeConnectPayout($user, $wallet, float $amount): JsonResponse
    {
        if (empty($user->stripe_connect_id)) {
            DB::rollBack();
            return $this->sendError('Please set up your bank account first before requesting a withdrawal.');
        }

        if (!($user->stripe_connect_onboarded ?? false)) {
            DB::rollBack();
            return $this->sendError('Your bank account setup is incomplete. Please complete the onboarding process.');
        }

        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

            // Create a transfer to the connected account
            $transfer = $stripe->transfers->create([
                'amount' => (int) ($amount * 100), // Stripe uses pence
                'currency' => 'gbp',
                'destination' => $user->stripe_connect_id,
                'description' => 'EWA vendor payout - Wallet #' . $wallet->id,
                'metadata' => [
                    'ewa_user_id' => $user->id,
                    'ewa_wallet_id' => $wallet->id,
                ],
            ]);

            // Deduct from wallet
            $wallet->balance -= $amount;
            $wallet->save();

            // Record transaction
            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'amount' => -$amount,
                'description' => 'Withdrawal (Stripe Connect) — Transfer ID: ' . $transfer->id,
                'action' => 'debit',
            ]);

            DB::commit();

            Log::info("Stripe Connect payout: user #{$user->id}, £{$amount}, transfer {$transfer->id}");

            return $this->sendResponse([
                'transaction_id' => $transaction->id,
                'transfer_id' => $transfer->id,
                'amount' => $amount,
                'new_balance' => $wallet->balance,
                'status' => 'processing',
                'estimated_arrival' => 'Within 2-3 business days',
            ], 'Withdrawal submitted. Funds will arrive in your bank within 2-3 business days.');

        } catch (\Stripe\Exception\ApiErrorException $e) {
            DB::rollBack();
            Log::error("Stripe Connect transfer failed: " . $e->getMessage());
            return $this->sendError('Bank transfer failed: ' . $e->getMessage());
        }
    }

    /**
     * Process manual payout (admin will handle bank transfer offline).
     */
    private function processManualPayout($user, $wallet, float $amount, string $notes): JsonResponse
    {
        // Deduct from wallet
        $wallet->balance -= $amount;
        $wallet->save();

        // Record transaction with 'pending_manual' status
        $transaction = WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => -$amount,
            'description' => 'Withdrawal request (manual)' . ($notes ? ': ' . $notes : ''),
            'action' => 'debit',
        ]);

        DB::commit();

        Log::info("Manual payout requested: user #{$user->id}, wallet #{$wallet->id}, amount £{$amount}");

        return $this->sendResponse([
            'transaction_id' => $transaction->id,
            'amount' => $amount,
            'new_balance' => $wallet->balance,
            'status' => 'pending',
            'estimated_arrival' => 'Within 3-5 business days (processed by EWA admin)',
        ], 'Withdrawal request submitted. Our team will process your payment within 3-5 business days.');
    }

    /**
     * Get the configured payout mode from app settings.
     */
    private function getPayoutMode(): string
    {
        $mode = setting('vendor_payout_mode', 'manual');
        // The setting() helper may return a JSON-encoded string
        if (is_string($mode) && in_array($mode, ['"manual"', '"stripe_connect"'])) {
            $mode = json_decode($mode) ?? 'manual';
        }
        return in_array($mode, ['manual', 'stripe_connect']) ? $mode : 'manual';
    }

    /**
     * Check if a vendor can withdraw.
     */
    private function canWithdraw($user, string $payoutMode): bool
    {
        if ($payoutMode === 'stripe_connect') {
            return !empty($user->stripe_connect_id) && ($user->stripe_connect_onboarded ?? false);
        }
        return true; // Manual mode always allows withdrawal requests
    }
}
