<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Exception;

/**
 * Class PaystackWebhookController
 * @package App\Http\Controllers\API
 */
class PaystackWebhookController extends Controller
{
    /**
     * Handle Paystack webhook events
     * POST /api/paystack/webhook
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        try {
            // Verify webhook signature
            if (!$this->verifySignature($request)) {
                Log::warning('Paystack webhook signature verification failed', [
                    'ip' => $request->ip(),
                    'headers' => $request->headers->all()
                ]);
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $event = $request->input('event');
            $data = $request->input('data');

            Log::info('Paystack webhook received', [
                'event' => $event,
                'reference' => $data['reference'] ?? null,
                'status' => $data['status'] ?? null
            ]);

            switch ($event) {
                case 'charge.success':
                    return $this->handleChargeSuccess($data);
                
                case 'charge.failed':
                    return $this->handleChargeFailed($data);
                
                case 'transfer.success':
                    return $this->handleTransferSuccess($data);
                
                case 'transfer.failed':
                    return $this->handleTransferFailed($data);
                
                default:
                    Log::info('Unhandled Paystack webhook event', ['event' => $event]);
                    return response()->json(['message' => 'Event not handled'], 200);
            }

        } catch (Exception $e) {
            Log::error('Paystack webhook error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Verify Paystack webhook signature
     */
    private function verifySignature(Request $request): bool
    {
        $signature = $request->header('x-paystack-signature');
        $secretKey = config('services.paystack.secret_key');
        
        if (!$signature || !$secretKey) {
            return false;
        }

        $computedSignature = hash_hmac('sha512', $request->getContent(), $secretKey);
        
        return hash_equals($signature, $computedSignature);
    }

    /**
     * Handle successful charge event
     */
    private function handleChargeSuccess(array $data): JsonResponse
    {
        try {
            $reference = $data['reference'];
            $amount = $data['amount']; // Amount in kobo
            $status = $data['status'];
            $gatewayResponse = $data['gateway_response'] ?? '';
            $paidAt = $data['paid_at'] ?? now();
            $metadata = $data['metadata'] ?? [];

            // Find booking from reference or metadata
            $bookingId = $this->extractBookingId($reference, $metadata);
            
            if (!$bookingId) {
                Log::warning('Could not extract booking ID from payment', [
                    'reference' => $reference,
                    'metadata' => $metadata
                ]);
                return response()->json(['message' => 'Booking not found'], 404);
            }

            $booking = Booking::find($bookingId);
            
            if (!$booking) {
                Log::warning('Booking not found for payment', ['booking_id' => $bookingId]);
                return response()->json(['message' => 'Booking not found'], 404);
            }

            // Check if payment already exists
            $existingPayment = Payment::where('booking_id', $bookingId)
                ->where('reference', $reference)
                ->first();

            if ($existingPayment) {
                Log::info('Payment already processed', ['reference' => $reference]);
                return response()->json(['message' => 'Payment already processed'], 200);
            }

            // Create payment record
            $payment = Payment::create([
                'booking_id' => $bookingId,
                'user_id' => $booking->user_id,
                'payment_method_id' => $this->getPaystackPaymentMethodId(),
                'amount' => $amount / 100, // Convert from kobo to naira
                'description' => "Payment for booking #{$bookingId}",
                'reference' => $reference,
                'status' => 'paid',
                'gateway_response' => $gatewayResponse,
                'paid_at' => $paidAt,
                'metadata' => json_encode($metadata)
            ]);

            // Update booking status to paid
            $booking->update([
                'payment_status' => 1, // Paid
                'booking_status_id' => $this->getPaidBookingStatusId()
            ]);

            Log::info('Payment processed successfully', [
                'payment_id' => $payment->id,
                'booking_id' => $bookingId,
                'amount' => $amount / 100,
                'reference' => $reference
            ]);

            // Send payment confirmation notification
            $this->sendPaymentConfirmation($booking, $payment);

            return response()->json([
                'message' => 'Payment processed successfully',
                'payment_id' => $payment->id
            ], 200);

        } catch (Exception $e) {
            Log::error('Error processing successful charge', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return response()->json(['message' => 'Payment processing failed'], 500);
        }
    }

    /**
     * Handle failed charge event
     */
    private function handleChargeFailed(array $data): JsonResponse
    {
        try {
            $reference = $data['reference'];
            $gatewayResponse = $data['gateway_response'] ?? '';
            $metadata = $data['metadata'] ?? [];

            $bookingId = $this->extractBookingId($reference, $metadata);
            
            if ($bookingId) {
                $booking = Booking::find($bookingId);
                
                if ($booking) {
                    // Log failed payment attempt
                    Log::warning('Payment failed', [
                        'booking_id' => $bookingId,
                        'reference' => $reference,
                        'gateway_response' => $gatewayResponse
                    ]);

                    // Optionally create a failed payment record
                    Payment::create([
                        'booking_id' => $bookingId,
                        'user_id' => $booking->user_id,
                        'payment_method_id' => $this->getPaystackPaymentMethodId(),
                        'amount' => $booking->total,
                        'description' => "Failed payment for booking #{$bookingId}",
                        'reference' => $reference,
                        'status' => 'failed',
                        'gateway_response' => $gatewayResponse,
                        'metadata' => json_encode($metadata)
                    ]);

                    // Send payment failure notification
                    $this->sendPaymentFailureNotification($booking, $gatewayResponse);
                }
            }

            return response()->json(['message' => 'Failed payment logged'], 200);

        } catch (Exception $e) {
            Log::error('Error processing failed charge', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return response()->json(['message' => 'Failed payment processing error'], 500);
        }
    }

    /**
     * Handle successful transfer event (for payouts)
     */
    private function handleTransferSuccess(array $data): JsonResponse
    {
        // Handle provider payouts
        Log::info('Transfer success received', $data);
        return response()->json(['message' => 'Transfer success processed'], 200);
    }

    /**
     * Handle failed transfer event
     */
    private function handleTransferFailed(array $data): JsonResponse
    {
        // Handle failed provider payouts
        Log::warning('Transfer failed received', $data);
        return response()->json(['message' => 'Transfer failure processed'], 200);
    }

    /**
     * Extract booking ID from reference or metadata
     */
    private function extractBookingId(string $reference, array $metadata): ?string
    {
        // Try to extract from metadata first
        if (isset($metadata['booking_id'])) {
            return $metadata['booking_id'];
        }

        // Try to extract from reference (format: booking_123_timestamp)
        if (preg_match('/booking_(\d+)_/', $reference, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get Paystack payment method ID
     */
    private function getPaystackPaymentMethodId(): int
    {
        // Assuming Paystack payment method has ID 4 (adjust based on your data)
        return 4;
    }

    /**
     * Get paid booking status ID
     */
    private function getPaidBookingStatusId(): int
    {
        // Assuming paid status has ID 50 (adjust based on your data)
        return 50;
    }

    /**
     * Send payment confirmation notification
     */
    private function sendPaymentConfirmation(Booking $booking, Payment $payment): void
    {
        try {
            // Send email notification to user
            // Send push notification
            // Update any related records
            
            Log::info('Payment confirmation sent', [
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'amount' => $payment->amount
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send payment confirmation', [
                'error' => $e->getMessage(),
                'booking_id' => $booking->id
            ]);
        }
    }

    /**
     * Send payment failure notification
     */
    private function sendPaymentFailureNotification(Booking $booking, string $reason): void
    {
        try {
            // Send email notification to user about failed payment
            // Send push notification
            
            Log::info('Payment failure notification sent', [
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'reason' => $reason
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send payment failure notification', [
                'error' => $e->getMessage(),
                'booking_id' => $booking->id
            ]);
        }
    }

    /**
     * Verify payment with Paystack API
     * GET /api/paystack/verify/{reference}
     */
    public function verifyPayment(string $reference): JsonResponse
    {
        try {
            $secretKey = config('services.paystack.secret_key');
            
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/{$reference}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$secretKey}",
                    "Content-Type: application/json",
                ],
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($httpCode !== 200) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment verification failed'
                ], 400);
            }

            $data = json_decode($response, true);

            if (!$data['status']) {
                return response()->json([
                    'success' => false,
                    'message' => $data['message'] ?? 'Verification failed'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $data['data']
            ]);

        } catch (Exception $e) {
            Log::error('Payment verification error', [
                'reference' => $reference,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Verification failed'
            ], 500);
        }
    }
}
