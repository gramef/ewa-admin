<?php

namespace App\Observers;

use App\Models\EProvider;
use Modules\Subscription\Models\EProviderSubscription;
use Modules\Subscription\Models\SubscriptionPackage;
use Illuminate\Support\Facades\Log;

class EProviderObserver
{
    /**
     * Right-to-work gate: a provider may not be marked "accepted" (approved to
     * take bookings) until their KYC / right-to-work check is verified.
     * Runs before save, so it blocks the admin edit form, the API and tinker in
     * one place. Already-accepted providers are grandfathered (only a 0→1
     * transition is gated).
     */
    public function updating(EProvider $eProvider): void
    {
        if ($eProvider->isDirty('accepted') && $eProvider->accepted) {
            $kyc = $eProvider->kyc_status ?? 'not_submitted';
            if ($kyc !== 'verified') {
                // Revert the approval so it is not persisted.
                $eProvider->accepted = false;
                Log::warning("EProviderObserver: blocked approval of provider #{$eProvider->id} — KYC not verified (status: {$kyc}).");
                try {
                    if (function_exists('session') && app()->bound('session')) {
                        session()->flash('error', "Cannot approve \"{$eProvider->name}\": KYC / right-to-work not verified (status: {$kyc}). Verify KYC first.");
                    }
                } catch (\Throwable $e) {
                    // no session (API/CLI) — the log + reverted flag are enough
                }
            }
        }
    }

    /**
     * When a provider is updated, check if they were just accepted.
     * If so, auto-start a free trial subscription.
     */
    public function updated(EProvider $eProvider): void
    {
        // Only act when 'accepted' was just changed to true
        if ($eProvider->wasChanged('accepted') && $eProvider->accepted) {
            $this->autoStartTrial($eProvider);
        }
    }

    /**
     * Automatically start a free trial for a newly accepted provider.
     */
    private function autoStartTrial(EProvider $eProvider): void
    {
        try {
            // Check if provider already has any subscription (trial or paid)
            $existingSub = EProviderSubscription::where('e_provider_id', $eProvider->id)->first();
            if ($existingSub) {
                Log::info("EProviderObserver: Provider #{$eProvider->id} already has a subscription, skipping auto-trial.");
                return;
            }

            // Find the free trial package
            $trialPackage = SubscriptionPackage::where('is_free_trial', true)
                ->where('enabled', true)
                ->first();

            if (!$trialPackage) {
                Log::warning("EProviderObserver: No free trial package found. Cannot auto-start trial for provider #{$eProvider->id}.");
                return;
            }

            // Create the trial subscription
            $subscription = EProviderSubscription::create([
                'e_provider_id' => $eProvider->id,
                'subscription_package_id' => $trialPackage->id,
                'starts_at' => now(),
                'expires_at' => now()->addDays($trialPackage->trial_duration_in_days),
                'active' => true,
                'is_trial' => true,
                'notes' => 'Auto-started on approval — ' . $trialPackage->name,
            ]);

            Log::info("EProviderObserver: Auto-started trial for provider #{$eProvider->id}, subscription #{$subscription->id}, expires {$subscription->expires_at}");
        } catch (\Exception $e) {
            Log::error("EProviderObserver: Failed to auto-start trial for provider #{$eProvider->id}: " . $e->getMessage());
        }
    }
}
