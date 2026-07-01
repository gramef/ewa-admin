<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * Send subscription expiry notifications to vendors.
 *
 * Notifications sent:
 * - 7 days before free trial/subscription ends
 * - 3 days before subscription payment is due
 * - On the day of expiry
 *
 * Schedule: Run daily via `php artisan schedule:run`
 */
class SendSubscriptionNotifications extends Command
{
    protected $signature = 'ewa:subscription-notifications';
    protected $description = 'Send expiry notifications to vendors with expiring subscriptions';

    public function handle()
    {
        $this->info('Checking subscription expiry notifications...');

        if (!class_exists('\Modules\Subscription\Models\EProviderSubscription')) {
            $this->warn('Subscription module not available. Skipping.');
            return 0;
        }

        $model = '\Modules\Subscription\Models\EProviderSubscription';
        $now = Carbon::now();
        $notified = 0;

        // 7-day warning
        $sevenDays = $now->copy()->addDays(7)->format('Y-m-d');
        $expiring7 = $model::whereDate('expires_at', $sevenDays)
            ->with('eProvider.users')
            ->get();

        foreach ($expiring7 as $sub) {
            $this->sendNotification($sub, '7_day_warning');
            $notified++;
        }

        // 3-day warning
        $threeDays = $now->copy()->addDays(3)->format('Y-m-d');
        $expiring3 = $model::whereDate('expires_at', $threeDays)
            ->with('eProvider.users')
            ->get();

        foreach ($expiring3 as $sub) {
            $this->sendNotification($sub, '3_day_warning');
            $notified++;
        }

        // Day-of expiry
        $today = $now->format('Y-m-d');
        $expiringToday = $model::whereDate('expires_at', $today)
            ->with('eProvider.users')
            ->get();

        foreach ($expiringToday as $sub) {
            $this->sendNotification($sub, 'expired');
            $notified++;
        }

        $this->info("Sent {$notified} subscription notifications.");
        Log::info("ewa:subscription-notifications sent {$notified} notifications");

        return 0;
    }

    private function sendNotification($subscription, $type)
    {
        $provider = $subscription->eProvider;
        if (!$provider) return;

        $user = $provider->users()->first();
        if (!$user) return;
        $email = $user->email;
        $providerName = is_array($provider->name) ? ($provider->name['en'] ?? 'Vendor') : ($provider->name ?? 'Vendor');
        $expiryDate = Carbon::parse($subscription->expires_at)->format('d M Y');

        $subjects = [
            '7_day_warning' => "EWA: Your subscription expires in 7 days",
            '3_day_warning' => "EWA: Your subscription expires in 3 days — action required",
            'expired' => "EWA: Your subscription has expired today",
        ];

        $messages = [
            '7_day_warning' => "Your EWA vendor subscription for \"{$providerName}\" will expire on {$expiryDate}. Please ensure your payment method is up to date to continue receiving bookings.",
            '3_day_warning' => "Your EWA vendor subscription for \"{$providerName}\" expires in just 3 days ({$expiryDate}). After expiry, your services will be hidden from clients. Renew now to avoid any disruption.",
            'expired' => "Your EWA vendor subscription for \"{$providerName}\" has expired today. Your services are now hidden from clients. Please renew your subscription to continue receiving bookings.",
        ];

        $subject = $subjects[$type] ?? 'EWA Subscription Update';
        $body = $messages[$type] ?? '';

        try {
            Mail::raw($body, function ($mail) use ($email, $subject) {
                $mail->to($email)
                    ->subject($subject)
                    ->from(config('mail.from.address', 'support@ewaofficialapp.com'), 'EWA Hair Platform');
            });

            Log::info("Subscription notification ({$type}) sent to {$email} for provider #{$provider->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send subscription notification to {$email}: " . $e->getMessage());
        }
    }
}
