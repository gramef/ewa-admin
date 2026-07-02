<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EProvider;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * Platform Health Dashboard
 * System status, Stripe connection, email service, and error flags
 */
class PlatformHealthController extends Controller
{
    public function index()
    {
        $health = [];

        // 1. Stripe connection status
        $stripeKey = setting('stripe_key', config('services.stripe.key', env('STRIPE_KEY')));
        $stripeSecret = setting('stripe_secret', config('services.stripe.secret', env('STRIPE_SECRET')));
        $health['stripe'] = [
            'status' => (!empty($stripeKey) && !empty($stripeSecret)) ? 'operational' : 'failed',
            'message' => (!empty($stripeKey) && !empty($stripeSecret))
                ? 'Stripe API keys configured'
                : 'Stripe API keys are MISSING — card payments will fail',
        ];

        // 2. Email service status
        $mailDriver = config('mail.default', config('mail.driver'));
        $mailHost = config('mail.mailers.smtp.host', '');
        $health['email'] = [
            'status' => !empty($mailHost) ? 'operational' : 'degraded',
            'message' => !empty($mailHost)
                ? "Mail configured via {$mailDriver} ({$mailHost})"
                : 'Mail host not configured — emails will not send',
        ];

        // 3. Last successful payment
        $lastPayment = Payment::where('payment_status_id', 2)
            ->orderBy('created_at', 'desc')
            ->first();
        $health['last_payment'] = [
            'status' => $lastPayment ? 'operational' : 'degraded',
            'message' => $lastPayment
                ? 'Last payment: £' . number_format($lastPayment->amount, 2) . ' on ' . $lastPayment->created_at->format('d M Y H:i')
                : 'No successful payments recorded yet',
        ];

        // 4. Database connection
        try {
            DB::connection()->getPdo();
            $health['database'] = [
                'status' => 'operational',
                'message' => 'Connected to ' . config('database.default') . ' database',
            ];
        } catch (\Exception $e) {
            $health['database'] = [
                'status' => 'failed',
                'message' => 'Database connection failed: ' . $e->getMessage(),
            ];
        }

        // 5. Storage
        $storagePath = storage_path('app');
        $health['storage'] = [
            'status' => is_writable($storagePath) ? 'operational' : 'failed',
            'message' => is_writable($storagePath)
                ? 'Storage writable (' . $this->formatBytes(disk_free_space($storagePath)) . ' free)'
                : 'Storage directory is not writable',
        ];

        // 6. Subscription module
        $subModuleActive = \Module::has('Subscription') && \Module::isEnabled('Subscription');
        $health['subscriptions'] = [
            'status' => $subModuleActive ? 'operational' : 'degraded',
            'message' => $subModuleActive
                ? 'Subscription module active'
                : 'Subscription module not enabled',
        ];

        // 7. Quick stats
        $stats = [
            'total_providers' => EProvider::count(),
            'active_providers' => EProvider::where('accepted', 1)->count(),
            'total_users' => User::count(),
            'total_bookings' => Booking::count(),
            'bookings_today' => Booking::whereDate('created_at', Carbon::today())->count(),
            'total_revenue' => Payment::where('payment_status_id', 2)->sum('amount'),
            'pending_kyc' => $this->safePendingKycCount(),
        ];

        return view('dashboard.platform_health', compact('health', 'stats'));
    }

    private function safePendingKycCount(): int
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasColumn('e_providers', 'kyc_status')) {
                return EProvider::where('kyc_status', 'pending')->count();
            }
        } catch (\Exception $e) {}
        return 0;
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
