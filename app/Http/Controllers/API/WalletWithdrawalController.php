<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletWithdrawalController extends Controller
{
    /**
     * Request a withdrawal from wallet.
     * POST /api/wallet/withdraw
     */
    public function requestWithdrawal(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'wallet_id' => 'required|exists:wallets,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();
        $wallet = \App\Models\Wallet::where('id', $request->wallet_id)
            ->where('user_id', $user->id)
            ->where('enabled', true)
            ->first();

        if (!$wallet) {
            return $this->sendError('Wallet not found or not accessible');
        }

        $amount = (float) $request->amount;

        if ($wallet->balance < $amount) {
            return $this->sendError('Insufficient balance. Available: £' . number_format($wallet->balance, 2));
        }

        // ── Payout Hold Period (configurable, default 0 for instant availability) ──
        $holdDays = (int) setting('vendor_payout_hold_days', 0);
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

            // Deduct from wallet
            $wallet->balance -= $amount;
            $wallet->save();

            // Create wallet transaction record
            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'amount' => -$amount, // negative = debit
                'description' => 'Withdrawal request' . ($request->notes ? ': ' . $request->notes : ''),
                'action' => 'debit',
            ]);

            DB::commit();

            Log::info("Withdrawal requested: user #{$user->id}, wallet #{$wallet->id}, amount £{$amount}");

            return $this->sendResponse([
                'transaction_id' => $transaction->id,
                'amount' => $amount,
                'new_balance' => $wallet->balance,
            ], 'Withdrawal request submitted. You will receive your funds within 3-5 business days.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Withdrawal failed: " . $e->getMessage());
            return $this->sendError('Withdrawal request failed. Please try again.');
        }
    }

    /**
     * Get withdrawal history.
     * GET /api/wallet/transactions
     */
    public function transactions(Request $request): JsonResponse
    {
        $user = auth()->user();
        $walletIds = \App\Models\Wallet::where('user_id', $user->id)->pluck('id');

        $transactions = WalletTransaction::whereIn('wallet_id', $walletIds)
            ->orderBy('created_at', 'desc')
            ->limit($request->get('limit', 20))
            ->get();

        return $this->sendResponse($transactions->toArray(), 'Transactions retrieved successfully');
    }
}
