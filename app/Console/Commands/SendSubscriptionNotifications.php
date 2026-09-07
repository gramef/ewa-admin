<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * Send subscription and trial expiry notifications to vendors.
 *
 * Notifications sent:
 * - 7 days before trial/subscription ends
 * - 3 days before trial/subscription ends
 * - 1 day before trial/subscription ends (final reminder + cancel option)
 * - On the day of expiry
 *
 * Schedule: Run daily at 09:00 via `php artisan schedule:run`
 */
class SendSubscriptionNotifications extends Command
{
    protected $signature = 'ewa:subscription-notifications';
    protected $description = 'Send expiry/trial-end notifications to vendors with expiring subscriptions';

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

        // Define notification windows (days before expiry)
        $windows = [7, 3, 1, 0];

        foreach ($windows as $daysAhead) {
            $targetDate = $now->copy()->addDays($daysAhead)->format('Y-m-d');
            $subscriptions = $model::whereDate('expires_at', $targetDate)
                ->where('active', true)
                ->with(['eProvider.users', 'subscriptionPackage'])
                ->get();

            foreach ($subscriptions as $sub) {
                $type = $this->getNotificationType($daysAhead, $sub);
                $this->sendNotification($sub, $type, $daysAhead);
                $notified++;
            }
        }

        $this->info("Sent {$notified} subscription notifications.");
        Log::info("ewa:subscription-notifications sent {$notified} notifications");

        return 0;
    }

    /**
     * Determine the notification type based on days remaining and subscription type.
     */
    private function getNotificationType(int $daysAhead, $subscription): string
    {
        $isTrial = $subscription->is_trial ?? false;

        if ($daysAhead === 7) {
            return $isTrial ? 'trial_7_day' : '7_day_warning';
        } elseif ($daysAhead === 3) {
            return $isTrial ? 'trial_3_day' : '3_day_warning';
        } elseif ($daysAhead === 1) {
            return $isTrial ? 'trial_1_day' : '1_day_warning';
        } else {
            return $isTrial ? 'trial_expired' : 'expired';
        }
    }

    private function sendNotification($subscription, $type, $daysAhead)
    {
        $provider = $subscription->eProvider;
        if (!$provider) return;

        $user = $provider->users()->first();
        if (!$user) return;

        $email = $user->email;
        if (empty($email)) return;

        $providerName = is_array($provider->name)
            ? ($provider->name['en'] ?? 'Vendor')
            : ($provider->name ?? 'Vendor');
        $expiryDate = Carbon::parse($subscription->expires_at)->format('d M Y');
        $userName = $user->name ?? 'there';
        $packageName = optional($subscription->subscriptionPackage)->name ?? 'your plan';

        $emailData = $this->getEmailContent($type, $userName, $providerName, $expiryDate, $packageName, $daysAhead);

        try {
            Mail::send([], [], function ($mail) use ($email, $emailData) {
                $mail->to($email)
                    ->subject($emailData['subject'])
                    ->from(config('mail.from.address', 'support@ewaofficialapp.com'), 'EWA Hair Platform')
                    ->html($this->buildHtmlEmail($emailData));
            });

            Log::info("Subscription notification ({$type}) sent to {$email} for provider #{$provider->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send subscription notification to {$email}: " . $e->getMessage());
        }
    }

    /**
     * Get email subject and body content for each notification type.
     */
    private function getEmailContent(string $type, string $userName, string $providerName, string $expiryDate, string $packageName, int $daysAhead): array
    {
        $data = [
            // ── Trial-specific notifications ──
            'trial_7_day' => [
                'subject' => "Your free trial ends in 7 days — here's what happens next",
                'heading' => 'Your free trial ends soon',
                'body' => "Hi {$userName},\n\nYour 2-month free trial for \"{$providerName}\" on EWA ends on **{$expiryDate}**.\n\nAfter your trial ends, your **{$packageName}** subscription will begin automatically and your saved card will be charged.\n\n**Don't want to continue?** You can cancel anytime before {$expiryDate} from your Vendor Dashboard → Subscriptions, and you won't be charged a penny.",
                'cta_text' => 'Manage Subscription',
                'cta_url' => config('app.url', 'https://ewaofficialapp.com'),
                'footer_note' => 'If you cancel, your services will be hidden from clients after your trial ends.',
            ],
            'trial_3_day' => [
                'subject' => "3 days left on your free trial — cancel now if you don't want to be charged",
                'heading' => 'Your free trial ends in 3 days',
                'body' => "Hi {$userName},\n\nJust a heads up — your free trial for \"{$providerName}\" ends on **{$expiryDate}**.\n\nAfter that, you'll be charged for the **{$packageName}** plan. If you've been getting bookings and building your client base, great — the subscription keeps everything running.\n\n**Want to cancel?** No problem. Cancel before {$expiryDate} and you won't be charged. Go to Vendor Dashboard → Subscriptions.",
                'cta_text' => 'Review My Subscription',
                'cta_url' => config('app.url', 'https://ewaofficialapp.com'),
                'footer_note' => 'You can always re-subscribe later, but your listing will be paused until you do.',
            ],
            'trial_1_day' => [
                'subject' => "⚠️ Final reminder: Your free trial ends tomorrow",
                'heading' => 'Last chance to cancel',
                'body' => "Hi {$userName},\n\nThis is your final reminder. Your free trial for \"{$providerName}\" ends **tomorrow ({$expiryDate})**.\n\nAfter tomorrow, your **{$packageName}** subscription will start and your card will be charged automatically.\n\n**To cancel:** Go to your Vendor Dashboard → Subscriptions → Cancel before midnight tonight.",
                'cta_text' => 'Cancel or Continue',
                'cta_url' => config('app.url', 'https://ewaofficialapp.com'),
                'footer_note' => 'If you want to keep your listing live and keep receiving bookings, no action is needed — your subscription will start automatically.',
            ],
            'trial_expired' => [
                'subject' => "Your free trial has ended — your subscription is now active",
                'heading' => 'Your subscription is active! 🎉',
                'body' => "Hi {$userName},\n\nYour free trial for \"{$providerName}\" has ended and your **{$packageName}** subscription is now active.\n\nYour listing is live, your clients can still find you, and everything is working as normal. Your card has been charged for this billing period.\n\nThank you for being part of EWA!",
                'cta_text' => 'Go to Dashboard',
                'cta_url' => config('app.url', 'https://ewaofficialapp.com'),
                'footer_note' => 'You can manage your subscription or upgrade your plan anytime from Settings.',
            ],

            // ── Paid subscription notifications ──
            '7_day_warning' => [
                'subject' => "EWA: Your {$packageName} subscription renews in 7 days",
                'heading' => 'Subscription renewal reminder',
                'body' => "Hi {$userName},\n\nYour **{$packageName}** subscription for \"{$providerName}\" will renew on **{$expiryDate}**. Please ensure your payment method is up to date to avoid any disruption to your listing.",
                'cta_text' => 'Manage Subscription',
                'cta_url' => config('app.url', 'https://ewaofficialapp.com'),
                'footer_note' => 'If you cancel before renewal, your listing will be hidden from clients.',
            ],
            '3_day_warning' => [
                'subject' => "EWA: Your subscription renews in 3 days",
                'heading' => 'Your subscription renews in 3 days',
                'body' => "Hi {$userName},\n\nYour **{$packageName}** subscription for \"{$providerName}\" renews on **{$expiryDate}**. If you'd like to change or cancel your plan, please do so before the renewal date.",
                'cta_text' => 'Review Subscription',
                'cta_url' => config('app.url', 'https://ewaofficialapp.com'),
                'footer_note' => null,
            ],
            '1_day_warning' => [
                'subject' => "EWA: Your subscription renews tomorrow",
                'heading' => 'Subscription renews tomorrow',
                'body' => "Hi {$userName},\n\nYour **{$packageName}** subscription for \"{$providerName}\" renews **tomorrow ({$expiryDate})**. Your saved payment method will be charged automatically.",
                'cta_text' => 'Manage Payment',
                'cta_url' => config('app.url', 'https://ewaofficialapp.com'),
                'footer_note' => 'To cancel, go to Vendor Dashboard → Subscriptions before midnight.',
            ],
            'expired' => [
                'subject' => "EWA: Your subscription has expired — your listing is now hidden",
                'heading' => 'Your subscription has expired',
                'body' => "Hi {$userName},\n\nYour **{$packageName}** subscription for \"{$providerName}\" has expired. Your services are now **hidden from clients** and you will not receive new bookings.\n\nTo get back online, please renew your subscription from the EWA Vendor app.",
                'cta_text' => 'Renew Now',
                'cta_url' => config('app.url', 'https://ewaofficialapp.com'),
                'footer_note' => 'Existing confirmed bookings are not affected.',
            ],
        ];

        return $data[$type] ?? [
            'subject' => 'EWA Subscription Update',
            'heading' => 'Subscription Update',
            'body' => "Hi {$userName}, your subscription status has changed. Please check your dashboard.",
            'cta_text' => 'Go to Dashboard',
            'cta_url' => config('app.url', 'https://ewaofficialapp.com'),
            'footer_note' => null,
        ];
    }

    /**
     * Build a simple, clean HTML email.
     */
    private function buildHtmlEmail(array $data): string
    {
        $heading = e($data['heading']);
        $body = nl2br(e($data['body']));
        // Re-enable bold markers after escaping
        $body = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $body);
        $ctaText = e($data['cta_text']);
        $ctaUrl = e($data['cta_url']);
        $footerNote = isset($data['footer_note']) ? '<p style="color:#999;font-size:13px;margin-top:20px;">' . e($data['footer_note']) . '</p>' : '';

        return <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background-color:#f5f5f5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
  <div style="max-width:560px;margin:40px auto;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
    <!-- Header -->
    <div style="background:#1a1a2e;padding:28px 32px;">
      <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:600;">{$heading}</h1>
    </div>
    <!-- Body -->
    <div style="padding:32px;">
      <div style="color:#333;font-size:15px;line-height:1.7;">
        {$body}
      </div>
      <!-- CTA Button -->
      <div style="text-align:center;margin:32px 0 16px;">
        <a href="{$ctaUrl}" style="display:inline-block;padding:14px 36px;background:#e91e63;color:#ffffff;text-decoration:none;border-radius:8px;font-weight:600;font-size:15px;">{$ctaText}</a>
      </div>
      {$footerNote}
    </div>
    <!-- Footer -->
    <div style="background:#fafafa;padding:20px 32px;border-top:1px solid #eee;">
      <p style="margin:0;color:#999;font-size:12px;">
        EWA Hair Platform — Built for stylists, by stylists.<br>
        <a href="mailto:support@ewaofficialapp.com" style="color:#e91e63;text-decoration:none;">support@ewaofficialapp.com</a>
      </p>
    </div>
  </div>
</body>
</html>
HTML;
    }
}
