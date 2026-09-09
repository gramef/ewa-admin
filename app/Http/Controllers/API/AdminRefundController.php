<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Refund;
use Stripe\Stripe;

/**
 * Admin-only controller for issuing refunds via Stripe.
 *
 * Routes (require admin auth):
 *   POST /api/admin/refund          — Issue full or partial refund
 *   GET  /api/admin/refund/preview  — Preview refund amount before issuing
 */
class AdminRefundController extends Controller
{
    /**
     * Preview the refundable amount for a booking.
     *
     * GET /api/admin/refund/preview?booking_id=123
     */
    public function preview(Request $request): JsonResponse
    {
        $request->validate(['booking_id' => 'required|exists:bookings,id']);

        $booking = Booking::with('payment')->find($request->booking_id);

        if (!$booking || !$booking->payment) {
            return $this->sendError('No payment found for this booking');
        }

        $payment = $booking->payment;
        $maxRefundable = $payment->amount ?? 0;

        // Check if already refunded
        if (($payment->payment_status_id ?? 0) == 3) {
            return $this->sendError('This booking has already been refunded');
        }

        return $this->sendResponse([
            'booking_id'     => $booking->id,
            'payment_id'     => $payment->id,
            'payment_amount' => $maxRefundable,
            'currency'       => setting('default_currency_code', 'gbp'),
            'payment_method' => $payment->paymentMethod->name ?? 'Unknown',
            'can_refund'     => $maxRefundable > 0,
        ], 'Refund preview');
    }

    /**
     * Issue a full or partial refund for a booking payment.
     *
     * POST /api/admin/refund
     * {
     *   "booking_id": 123,
     *   "amount": 50.00,        // Optional — omit for full refund
     *   "reason": "Customer request"
     * }
     */
    public function issueRefund(Request $request): JsonResponse
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount'     => 'nullable|numeric|min:0.50',
            'reason'     => 'nullable|string|max:500',
        ]);

        // Verify admin role
        $user = auth()->user();
        if (!$user || !$user->hasRole('admin')) {
            return $this->sendError('Unauthorized — admin access required', 403);
        }

        $booking = Booking::with('payment')->find($request->booking_id);

        if (!$booking || !$booking->payment) {
            return $this->sendError('No payment found for this booking');
        }

        $payment = $booking->payment;

        if (($payment->payment_status_id ?? 0) == 3) {
            return $this->sendError('This booking has already been refunded');
        }

        // Determine refund amount
        $maxRefundable = (float) ($payment->amount ?? 0);
        $refundAmount = $request->amount ? min((float) $request->amount, $maxRefundable) : $maxRefundable;

        if ($refundAmount <= 0) {
            return $this->sendError('Invalid refund amount');
        }

        // Only process Stripe refund if payment was made via Stripe (payment_method_id = 7)
        if (($payment->payment_method_id ?? 0) == 7) {
            try {
                $stripeSecret = setting('stripe_secret');
                if (empty($stripeSecret)) {
                    return $this->sendError('Stripe is not configured');
                }

                Stripe::setApiKey($stripeSecret);

                // Find the PaymentIntent ID from payment description or metadata
                $intentId = $this->extractPaymentIntentId($payment);

                if (!$intentId) {
                    return $this->sendError('Could not find Stripe PaymentIntent for this payment. Manual refund required via Stripe Dashboard.');
                }

                $refund = Refund::create([
                    'payment_intent' => $intentId,
                    'amount'         => (int) ($refundAmount * 100), // Stripe uses pence
                    'reason'         => 'requested_by_customer',
                    'metadata'       => [
                        'booking_id'  => $booking->id,
                        'refunded_by' => $user->id,
                        'reason'      => $request->reason ?? 'Admin-initiated refund',
                    ],
                ]);

                Log::info('Stripe refund issued', [
                    'refund_id'    => $refund->id,
                    'booking_id'   => $booking->id,
                    'amount'       => $refundAmount,
                    'admin_id'     => $user->id,
                ]);

            } catch (\Stripe\Exception\ApiErrorException $e) {
                Log::error('Stripe refund failed: ' . $e->getMessage());
                return $this->sendError('Stripe refund failed: ' . $e->getMessage());
            }
        }

        // Update payment status to refunded
        $isPartial = $refundAmount < $maxRefundable;
        $payment->update([
            'payment_status_id' => 3, // Refunded
            'description'       => ($isPartial ? 'Partial refund' : 'Full refund')
                . ' — £' . number_format($refundAmount, 2)
                . ($request->reason ? ' (' . $request->reason . ')' : ''),
        ]);

        Log::info("Admin refund completed", [
            'booking_id'    => $booking->id,
            'amount'        => $refundAmount,
            'type'          => $isPartial ? 'partial' : 'full',
            'admin_user_id' => $user->id,
        ]);

        return $this->sendResponse([
            'booking_id'      => $booking->id,
            'refund_amount'   => $refundAmount,
            'type'            => $isPartial ? 'partial' : 'full',
            'payment_status'  => 'refunded',
            'stripe_refund_id' => $refund->id ?? null,
        ], '£' . number_format($refundAmount, 2) . ' refund processed successfully');
    }

    /**
     * Extract Stripe PaymentIntent ID from payment records.
     */
    private function extractPaymentIntentId(Payment $payment): ?string
    {
        $desc = $payment->description ?? '';

        // Check if description contains a PaymentIntent ID
        if (preg_match('/pi_[A-Za-z0-9]+/', $desc, $matches)) {
            return $matches[0];
        }

        // Fallback: Try to find via Stripe API using booking metadata
        // This requires searching recent PaymentIntents — expensive but last resort
        return null;
    }
}
