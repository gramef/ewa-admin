<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CommunicationLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommunicationLogAPIController extends Controller
{
    /**
     * Store a new communication intent log (e.g. phone call clicked)
     * POST /api/communications/log
     */
    public function log(Request $request): JsonResponse
    {
        $input = $request->validate([
            'booking_id' => 'nullable|integer',
            'e_provider_id' => 'nullable|integer',
            'receiver_id' => 'nullable|integer',
            'type' => 'nullable|string|max:32',
            'caller_role' => 'nullable|string|max:32',
            'phone_dialed' => 'nullable|string|max:32',
            'note' => 'nullable|string|max:500',
            'metadata' => 'nullable|array',
        ]);

        $callerId = auth('api')->check() ? auth('api')->id() : (auth()->check() ? auth()->id() : null);
        $input['caller_id'] = $callerId;
        $input['type'] = $input['type'] ?? 'phone_call';
        $input['caller_role'] = $input['caller_role'] ?? 'client';
        $input['status'] = 'initiated';

        // Auto-fill relations from booking if provided
        if (!empty($input['booking_id'])) {
            $booking = Booking::with(['user', 'e_provider'])->find($input['booking_id']);
            if ($booking) {
                if (empty($input['e_provider_id']) && $booking->e_provider_id) {
                    $input['e_provider_id'] = $booking->e_provider_id;
                }
                if (empty($input['receiver_id'])) {
                    // If client called, receiver is provider user; if vendor called, receiver is client
                    if ($input['caller_role'] === 'client' && $booking->e_provider && $booking->e_provider->users->first()) {
                        $input['receiver_id'] = $booking->e_provider->users->first()->id;
                    } elseif ($input['caller_role'] === 'vendor') {
                        $input['receiver_id'] = $booking->user_id;
                    }
                }
            }
        }

        $log = CommunicationLog::create($input);

        return $this->sendResponse($log, 'Communication log recorded successfully');
    }

    /**
     * Get communication logs for a specific booking
     * GET /api/communications/booking/{bookingId}
     */
    public function getBookingLogs(int $bookingId): JsonResponse
    {
        $logs = CommunicationLog::with(['caller', 'receiver', 'eProvider'])
            ->where('booking_id', $bookingId)
            ->latest()
            ->get();

        return $this->sendResponse($logs, 'Booking communication logs retrieved');
    }
}
