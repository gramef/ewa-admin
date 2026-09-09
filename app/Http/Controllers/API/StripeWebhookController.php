<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

/**
 * Handles incoming Stripe webhooks for:
 * - charge.dispute.created  → Mark payment as disputed, hold vendor payout
 * - charge.dispute.closed   → Update dispute outcome, deduct if lost
 * - charge.refunded         → Record refund against booking payment
 * - payment_intent.payment_failed → Log failure
 *
 * Webhook endpoint: POST /api/stripe/webhook
 * Must be excluded from CSRF verification in VerifyCsrfToken middleware.
 */
class StripeWebhookController extends Controller
{
    /**
     * Handle incoming Stripe webhook event.
     */
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        // Verify webhook signature if secret is configured
        if ($webhookSecret) {
            try {
                $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
            } catch (SignatureVerificationException $e) {
                Log::warning('Stripe webhook signature verification failed', [
                    'error' => $e->getMessage(),
                ]);
                return response()->json(['error' => 'Invalid signature'], 400);
            } catch (\Exception $e) {
                Log::error('Stripe webhook parse error', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Webhook parse error'], 400);
            }
        } else {
            // No webhook secret configured — parse raw payload (development only)
            $event = json_decode($payload);
            if (!$event || !isset($event->type)) {
                return response()->json(['error' => 'Invalid payload'], 400);
            }
            Log::warning('Stripe webhook received without signature verification — configure STRIPE_WEBHOOK_SECRET for production');
        }

        Log::info('Stripe webhook received', [
            'type' => $event->type,
            'id'   => $event->id ?? 'unknown',
        ]);

        switch ($event->type) {
            case 'charge.dispute.created':
                return $this->handleDisputeCreated($event->data->object);

            case 'charge.dispute.closed':
                return $this->handleDisputeClosed($event->data->object);

            case 'charge.refunded':
                return $this->handleChargeRefunded($event->data->object);

            case 'payment_intent.payment_failed':
                return $this->handlePaymentFailed($event->data->object);

            default:
                Log::info('Unhandled Stripe webhook event: ' . $event->type);
                return response()->json(['status' => 'ignored']);
        }
    }

    /**
     * Handle charge.dispute.created — customer filed a chargeback.
     */
    private function handleDisputeCreated($dispute): JsonResponse
    {
        $chargeId = $dispute->charge ?? null;
        $amount = ($dispute->amount ?? 0) / 100;
        $reason = $dispute->reason ?? 'unknown';

        Log::warning('🚨 Stripe dispute created', [
            'dispute_id' => $dispute->id,
            'charge_id'  => $chargeId,
            'amount'     => $amount,
            'reason'     => $reason,
            'status'     => $dispute->status ?? 'unknown',
        ]);

        // Try to find the associated booking via payment intent metadata
        $bookingId = $dispute->metadata->booking_id ?? null;
        if (!$bookingId && isset($dispute->payment_intent)) {
            $payment = Payment::where('description', 'LIKE', '%' . $dispute->payment_intent . '%')->first();
            if ($payment) {
                $booking = Booking::where('payment_id', $payment->id)->first();
                $bookingId = $booking->id ?? null;
            }
        }

        if ($bookingId) {
            $booking = Booking::find($bookingId);
            if ($booking) {
                $booking->dispute_status = 'open';
                $booking->dispute_id = $dispute->id;
                $booking->dispute_reason = $reason;
                $booking->disputed_at = now();
                $booking->save();

                Log::info("Booking #{$bookingId} marked as disputed");
            }
        }

        return response()->json(['status' => 'dispute_logged']);
    }

    /**
     * Handle charge.dispute.closed — dispute resolved (won or lost).
     */
    private function handleDisputeClosed($dispute): JsonResponse
    {
        $status = $dispute->status ?? 'unknown';

        Log::info('Stripe dispute closed', [
            'dispute_id' => $dispute->id,
            'status'     => $status,
        ]);

        $bookingId = $dispute->metadata->booking_id ?? null;
        if ($bookingId) {
            $booking = Booking::find($bookingId);
            if ($booking) {
                $booking->dispute_status = $status === 'won' ? 'won' : 'lost';
                $booking->save();

                if ($status === 'lost') {
                    $this->deductDisputeFromVendor($booking, ($dispute->amount ?? 0) / 100);
                }
            }
        }

        return response()->json(['status' => 'dispute_closed_logged']);
    }

    /**
     * Handle charge.refunded — a refund was issued.
     */
    private function handleChargeRefunded($charge): JsonResponse
    {
        $refundedAmount = ($charge->amount_refunded ?? 0) / 100;
        $bookingId = $charge->metadata->booking_id ?? null;

        Log::info('Stripe charge refunded', [
            'charge_id'       => $charge->id,
            'refunded_amount' => $refundedAmount,
            'booking_id'      => $bookingId,
        ]);

        if ($bookingId) {
            $booking = Booking::find($bookingId);
            if ($booking && $booking->payment) {
                $booking->payment->update([
                    'payment_status_id' => 3, // Refunded
                    'description'       => 'Refunded — £' . number_format($refundedAmount, 2),
                ]);
            }
        }

        return response()->json(['status' => 'refund_logged']);
    }

    /**
     * Handle payment_intent.payment_failed — card declined or error.
     */
    private function handlePaymentFailed($paymentIntent): JsonResponse
    {
        $bookingId = $paymentIntent->metadata->booking_id ?? null;
        $errorMessage = $paymentIntent->last_payment_error->message ?? 'Unknown error';

        Log::warning('Stripe payment failed', [
            'intent_id'  => $paymentIntent->id,
            'booking_id' => $bookingId,
            'error'      => $errorMessage,
        ]);

        return response()->json(['status' => 'failure_logged']);
    }

    /**
     * Deduct lost dispute amount from vendor's wallet.
     */
    private function deductDisputeFromVendor(Booking $booking, float $amount): void
    {
        $provider = $booking->eProvider;
        if (!$provider) return;

        $ownerUser = $provider->users()->first();
        if (!$ownerUser) return;

        $wallet = Wallet::where('user_id', $ownerUser->id)->where('enabled', true)->first();
        if (!$wallet) return;

        try {
            DB::beginTransaction();

            $wallet->balance -= $amount;
            $wallet->save();

            WalletTransaction::create([
                'wallet_id'   => $wallet->id,
                'amount'      => -$amount,
                'description' => "Dispute lost — Booking #{$booking->id} (chargeback deduction)",
                'action'      => 'debit',
            ]);

            DB::commit();

            Log::info("Vendor wallet debited £{$amount} for lost dispute on Booking #{$booking->id}");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to deduct dispute amount from vendor wallet: " . $e->getMessage());
        }
    }
}
