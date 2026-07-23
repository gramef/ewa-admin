<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session as StripeCheckoutSession;
use Stripe\Stripe;

/**
 * Handles wallet top-up via Stripe Checkout Sessions.
 *
 * Flow:
 * 1. Client selects top-up amount
 * 2. POST /api/wallet/topup/create-session → creates Stripe Checkout Session
 * 3. Client redirects to Stripe Checkout
 * 4. After payment, client calls POST /api/wallet/topup/verify → credits wallet
 */
class WalletTopUpController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->initStripe();
    }

    private function initStripe()
    {
        $key = setting('stripe_secret') ?: (config('services.stripe.secret') ?: env('STRIPE_SECRET'));
        if (!empty($key)) {
            Stripe::setApiKey($key);
        }
    }

    /**
     * Create a Stripe Checkout Session for wallet top-up.
     * POST /api/wallet/topup/create-session
     */
    public function createSession(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:5|max:500',
            ]);

            $user = auth()->user();
            if (!$user) {
                return $this->sendError('Unauthorized', 401);
            }

            // Get or create wallet for user
            $wallet = Wallet::where('user_id', $user->id)->where('enabled', 1)->first();
            if (!$wallet) {
                $wallet = Wallet::create([
                    'name' => $user->name . "'s Wallet",
                    'balance' => 0,
                    'user_id' => $user->id,
                    'enabled' => 1,
                ]);
            }

            $amount = round($request->amount, 2);
            $currencyCode = strtolower(setting('default_currency_code', 'GBP'));

            $session = StripeCheckoutSession::create([
                'payment_method_types' => ['card'],
                'mode' => 'payment',
                'line_items' => [[
                    'price_data' => [
                        'currency' => $currencyCode,
                        'product_data' => [
                            'name' => 'EWA Wallet Top-Up',
                            'description' => "Add {$currencyCode} {$amount} to your EWA wallet",
                        ],
                        'unit_amount' => (int) round($amount * 100),
                    ],
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'wallet_id' => $wallet->id,
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'type' => 'wallet_topup',
                ],
                'success_url' => $request->input('success_url',
                    rtrim(config('app.client_pwa_url', 'https://ewa-client-pwa.vercel.app'), '/') . '/#/wallet?session_id={CHECKOUT_SESSION_ID}&status=success'
                ),
                'cancel_url' => $request->input('cancel_url',
                    rtrim(config('app.client_pwa_url', 'https://ewa-client-pwa.vercel.app'), '/') . '/#/wallet?status=cancelled'
                ),
            ]);

            Log::info("Wallet top-up checkout session created for user #{$user->id}: {$session->id}, amount: {$amount}");

            return $this->sendResponse([
                'checkout_url' => $session->url,
                'session_id' => $session->id,
            ], 'Checkout session created');

        } catch (Exception $e) {
            Log::error('Wallet top-up session creation failed: ' . $e->getMessage());
            return $this->sendError('Failed to create checkout: ' . $e->getMessage());
        }
    }

    /**
     * Verify a completed Stripe Checkout Session and credit the wallet.
     * POST /api/wallet/topup/verify
     */
    public function verify(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'session_id' => 'required|string',
            ]);

            $session = StripeCheckoutSession::retrieve($request->session_id);

            if ($session->payment_status !== 'paid') {
                return $this->sendError('Payment not completed');
            }

            $metadata = $session->metadata;
            $walletId = $metadata->wallet_id;
            $userId = $metadata->user_id;
            $amount = (float) $metadata->amount;

            // Verify user owns this wallet
            $user = auth()->user();
            if (!$user) {
                return $this->sendError('Unauthorized. Please log in again.', 401);
            }
            if ($user->id != $userId) {
                return $this->sendError('Unauthorized for this wallet', 403);
            }

            // Check if already processed (idempotency)
            $stripeRef = 'stripe:' . $session->id;
            $existing = WalletTransaction::where('wallet_id', $walletId)
                ->where('description', 'LIKE', '%' . $session->id . '%')
                ->first();
            if ($existing) {
                $wallet = Wallet::find($walletId);
                return $this->sendResponse([
                    'balance' => $wallet->balance ?? 0,
                    'amount_added' => $amount,
                ], 'Top-up already processed');
            }

            // Credit the wallet
            DB::transaction(function () use ($walletId, $amount, $session, $userId) {
                $wallet = Wallet::lockForUpdate()->findOrFail($walletId);
                $wallet->balance += $amount;
                $wallet->save();

                // Create transaction record
                WalletTransaction::create([
                    'amount' => $amount,
                    'description' => 'Wallet Top-Up via Stripe (ref:' . $session->id . ')',
                    'action' => 'credit',
                    'wallet_id' => $walletId,
                    'user_id' => $userId,
                ]);
            });

            $wallet = Wallet::find($walletId);
            Log::info("Wallet #{$walletId} credited with {$amount} for user #{$userId}");

            return $this->sendResponse([
                'balance' => $wallet->balance,
                'amount_added' => $amount,
            ], 'Wallet topped up successfully');

        } catch (Exception $e) {
            Log::error('Wallet top-up verification failed: ' . $e->getMessage());
            return $this->sendError('Failed to verify top-up: ' . $e->getMessage());
        }
    }
}
