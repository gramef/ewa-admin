<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;

/**
 * Calculates time-based cancellation fees using tiered policy windows.
 *
 * Industry standard (UK hair/beauty):
 *   > 48h before = Free
 *   24-48h before = 50% fee
 *   < 24h / no-show = 100% fee
 */
class CancellationService
{
    /**
     * Calculate the cancellation fee for a booking.
     *
     * @param Booking $booking
     * @param string  $cancelledBy  'customer' or 'vendor'
     * @return array{fee_percent: int, fee_amount: float, label: string, is_free: bool, hours_remaining: float, subtotal: float}
     */
    public static function calculate(Booking $booking, string $cancelledBy = 'customer'): array
    {
        $subtotal = $booking->getSubtotal();

        // Vendor-initiated cancellations are always free for the customer
        if ($cancelledBy === 'vendor' && config('cancellation.vendor_cancel_free', true)) {
            return [
                'fee_percent'     => 0,
                'fee_amount'      => 0,
                'label'           => 'Cancelled by stylist — no charge',
                'is_free'         => true,
                'hours_remaining' => self::hoursUntilBooking($booking),
                'subtotal'        => $subtotal,
            ];
        }

        $hoursRemaining = self::hoursUntilBooking($booking);
        $windows = config('cancellation.windows', []);

        // Sort windows descending by threshold_hours (most generous first)
        usort($windows, fn($a, $b) => $b['threshold_hours'] <=> $a['threshold_hours']);

        // Walk windows: find the FIRST window where hours_remaining < threshold
        // (i.e., customer is cancelling within that window)
        $matchedWindow = end($windows); // Default to strictest

        foreach ($windows as $window) {
            if ($hoursRemaining >= $window['threshold_hours']) {
                $matchedWindow = $window;
                break;
            }
        }

        $feePercent = $matchedWindow['fee_percent'] ?? 0;
        $feeAmount = round($subtotal * ($feePercent / 100), 2);

        return [
            'fee_percent'     => $feePercent,
            'fee_amount'      => $feeAmount,
            'label'           => $matchedWindow['label'] ?? 'Cancellation fee',
            'is_free'         => $feePercent === 0,
            'hours_remaining' => round($hoursRemaining, 1),
            'subtotal'        => $subtotal,
        ];
    }

    /**
     * Calculate hours remaining until the booking starts.
     */
    private static function hoursUntilBooking(Booking $booking): float
    {
        $bookingAt = $booking->booking_at;

        if (is_string($bookingAt)) {
            $bookingAt = Carbon::parse($bookingAt);
        }

        if (!$bookingAt) {
            return 0; // No booking time = treat as last-minute
        }

        $now = Carbon::now();
        $diffHours = $now->diffInMinutes($bookingAt, false) / 60;

        // If booking time has already passed, return 0 (no-show territory)
        return max($diffHours, 0);
    }

    /**
     * Get a human-readable description of the cancellation policy.
     */
    public static function getPolicyDescription(): array
    {
        $windows = config('cancellation.windows', []);
        usort($windows, fn($a, $b) => $b['threshold_hours'] <=> $a['threshold_hours']);

        return array_map(function ($w) {
            $hours = $w['threshold_hours'];
            $fee = $w['fee_percent'];

            if ($fee === 0) {
                $desc = "Free cancellation if cancelled more than {$hours} hours before your appointment";
            } elseif ($hours === 0) {
                $desc = "{$fee}% fee for last-minute cancellations or no-shows";
            } else {
                $desc = "{$fee}% fee if cancelled within {$hours} hours of your appointment";
            }

            return [
                'threshold_hours' => $hours,
                'fee_percent'     => $fee,
                'label'           => $w['label'],
                'description'     => $desc,
            ];
        }, $windows);
    }
}
