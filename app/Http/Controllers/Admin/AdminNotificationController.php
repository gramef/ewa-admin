<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EProvider;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Admin Notification Centre
 * Centralised view of platform activity
 */
class AdminNotificationController extends Controller
{
    public function index()
    {
        // New vendor applications (pending approval)
        $pendingVendors = EProvider::where('accepted', 0)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Recent bookings (last 7 days)
        $recentBookings = Booking::with(['user', 'eProvider'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Failed payments (if any)
        $failedPayments = Payment::where('payment_status_id', '!=', 2) // Not paid
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->with(['user', 'booking'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // KYC pending reviews
        $pendingKyc = EProvider::where('kyc_status', 'pending')
            ->with('user')
            ->orderBy('kyc_submitted_at', 'desc')
            ->get();

        // Subscription alerts (expiring within 7 days)
        $expiringSubscriptions = [];
        if (class_exists('\Modules\Subscription\Models\EProviderSubscription')) {
            $expiringSubscriptions = \Modules\Subscription\Models\EProviderSubscription::where('expires_at', '<=', Carbon::now()->addDays(7))
                ->where('expires_at', '>', Carbon::now())
                ->with('eProvider')
                ->get();
        }

        // Platform stats
        $stats = [
            'total_vendors' => EProvider::count(),
            'active_vendors' => EProvider::where('accepted', 1)->count(),
            'total_users' => User::count(),
            'bookings_today' => Booking::whereDate('created_at', Carbon::today())->count(),
            'bookings_week' => Booking::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'revenue_month' => Payment::where('payment_status_id', 2)
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->sum('amount'),
        ];

        return view('dashboard.notifications', compact(
            'pendingVendors', 'recentBookings', 'failedPayments',
            'pendingKyc', 'expiringSubscriptions', 'stats'
        ));
    }
}
