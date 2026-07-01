<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Subscription\Models\EProviderSubscription;
use App\Notifications\SubscriptionExpiryNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessSubscriptionExpiry extends Command
{
    protected $signature = 'subscriptions:process-expiry';

    protected $description = 'Check subscription expiry dates and send reminders (7-day, 1-day) and expire past-due subscriptions';

    public function handle()
    {
        $this->info('Processing subscription expiry checks...');

        $now = Carbon::now();
        $processed = 0;

        // ── 1. Expire subscriptions that are past their expiry date ──
        $expired = EProviderSubscription::where('active', true)
            ->where('expires_at', '<', $now)
            ->get();

        foreach ($expired as $sub) {
            $sub->update(['active' => false]);

            $owner = $this->getOwner($sub);
            if ($owner) {
                $owner->notify(new SubscriptionExpiryNotification($sub, 'expired'));
                $this->line("  ✗ Expired: Provider #{$sub->e_provider_id} — notified user #{$owner->id}");
            }
            $processed++;
        }

        $this->info("  Expired {$expired->count()} subscriptions");

        // ── 2. Send 1-day warning (expires tomorrow) ──
        $expiringTomorrow = EProviderSubscription::where('active', true)
            ->whereBetween('expires_at', [
                $now->copy()->addHours(23),
                $now->copy()->addHours(25),
            ])
            ->get();

        foreach ($expiringTomorrow as $sub) {
            $owner = $this->getOwner($sub);
            if ($owner && !$this->alreadyNotified($owner, $sub, 'subscription_urgent')) {
                $owner->notify(new SubscriptionExpiryNotification($sub, 'warning_1d'));
                $this->line("  ⚠ 1-day warning: Provider #{$sub->e_provider_id}");
                $processed++;
            }
        }

        $this->info("  1-day warnings: {$expiringTomorrow->count()} subscriptions");

        // ── 3. Send 7-day warning ──
        $expiringWeek = EProviderSubscription::where('active', true)
            ->whereBetween('expires_at', [
                $now->copy()->addDays(6)->addHours(23),
                $now->copy()->addDays(7)->addHours(1),
            ])
            ->get();

        foreach ($expiringWeek as $sub) {
            $owner = $this->getOwner($sub);
            if ($owner && !$this->alreadyNotified($owner, $sub, 'subscription_warning')) {
                $owner->notify(new SubscriptionExpiryNotification($sub, 'warning_7d'));
                $this->line("  ℹ 7-day warning: Provider #{$sub->e_provider_id}");
                $processed++;
            }
        }

        $this->info("  7-day warnings: {$expiringWeek->count()} subscriptions");
        $this->info("Total processed: {$processed}");

        Log::info("subscriptions:process-expiry completed. Processed: {$processed}");

        return Command::SUCCESS;
    }

    /**
     * Get the user who owns the provider for this subscription.
     */
    private function getOwner(EProviderSubscription $sub): ?User
    {
        $provider = $sub->eProvider;
        if (!$provider) return null;

        return $provider->users()->first();
    }

    /**
     * Check if we've already sent a notification of this type in the last 24h
     * to prevent duplicate notifications.
     */
    private function alreadyNotified(User $user, EProviderSubscription $sub, string $type): bool
    {
        return $user->notifications()
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->whereJsonContains('data->type', $type)
            ->whereJsonContains('data->subscription_id', $sub->id)
            ->exists();
    }
}
