<?php
/*
 * File name: SubscriptionAPIController.php
 * Author: EWA Platform
 */

namespace Modules\Subscription\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EProvider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Subscription\Models\EProviderSubscription;
use Modules\Subscription\Models\SubscriptionPackage;

/**
 * Class SubscriptionAPIController
 * @package Modules\Subscription\Http\Controllers
 */
class SubscriptionAPIController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List all available (enabled) subscription packages.
     * GET /api/subscription-packages
     *
     * @return JsonResponse
     */
    public function packages(): JsonResponse
    {
        try {
            $packages = SubscriptionPackage::where('enabled', true)
                ->orderBy('sort_order')
                ->orderBy('price')
                ->get();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($packages->toArray(), 'Subscription packages retrieved successfully');
    }

    /**
     * Get the current provider's subscription status.
     * GET /api/provider/subscription/status
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function status(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $eProvider = $this->getProviderForUser($user);

            if (!$eProvider) {
                return $this->sendError('No provider profile found for this user');
            }

            // Get the active subscription with package details
            $activeSubscription = EProviderSubscription::with('subscriptionPackage')
                ->where('e_provider_id', $eProvider->id)
                ->valid()
                ->orderBy('expires_at', 'desc')
                ->first();

            // Get subscription history
            $history = EProviderSubscription::with('subscriptionPackage')
                ->where('e_provider_id', $eProvider->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            // Check if provider has ever used a trial
            $hasUsedTrial = EProviderSubscription::where('e_provider_id', $eProvider->id)
                ->where('is_trial', true)
                ->exists();

            $data = [
                'has_valid_subscription' => !is_null($activeSubscription),
                'active_subscription' => $activeSubscription ? $activeSubscription->toArray() : null,
                'has_used_trial' => $hasUsedTrial,
                'history' => $history->toArray(),
            ];
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($data, 'Subscription status retrieved successfully');
    }

    /**
     * Subscribe to a package.
     * POST /api/provider/subscription/subscribe
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribe(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'subscription_package_id' => 'required|exists:subscription_packages,id',
                'payment_id' => 'nullable|exists:payments,id',
            ]);

            $user = auth()->user();
            $eProvider = $this->getProviderForUser($user);

            if (!$eProvider) {
                return $this->sendError('No provider profile found for this user');
            }

            $package = SubscriptionPackage::findOrFail($request->subscription_package_id);

            if (!$package->enabled) {
                return $this->sendError('This subscription package is not available');
            }

            if ($package->is_free_trial) {
                return $this->sendError('Use the start-trial endpoint for free trial packages');
            }

            // Deactivate any existing active subscriptions
            EProviderSubscription::where('e_provider_id', $eProvider->id)
                ->where('active', true)
                ->update(['active' => false]);

            // Create the new subscription
            $subscription = EProviderSubscription::create([
                'e_provider_id' => $eProvider->id,
                'subscription_package_id' => $package->id,
                'starts_at' => now(),
                'expires_at' => now()->addDays($package->duration_in_days),
                'active' => true,
                'is_trial' => false,
                'payment_id' => $request->payment_id,
                'notes' => 'Subscribed to ' . $package->name,
            ]);

            $subscription->load('subscriptionPackage');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($subscription->toArray(), 'Subscription created successfully');
    }

    /**
     * Start a free trial.
     * POST /api/provider/subscription/start-trial
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function startTrial(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $eProvider = $this->getProviderForUser($user);

            if (!$eProvider) {
                return $this->sendError('No provider profile found for this user');
            }

            // Check if provider has already used a trial
            $hasUsedTrial = EProviderSubscription::where('e_provider_id', $eProvider->id)
                ->where('is_trial', true)
                ->exists();

            if ($hasUsedTrial) {
                return $this->sendError('Free trial has already been used for this provider');
            }

            // Find the free trial package
            $trialPackage = SubscriptionPackage::where('is_free_trial', true)
                ->where('enabled', true)
                ->first();

            if (!$trialPackage) {
                return $this->sendError('No free trial package is currently available');
            }

            // Deactivate any existing active subscriptions
            EProviderSubscription::where('e_provider_id', $eProvider->id)
                ->where('active', true)
                ->update(['active' => false]);

            // Create the trial subscription
            $subscription = EProviderSubscription::create([
                'e_provider_id' => $eProvider->id,
                'subscription_package_id' => $trialPackage->id,
                'starts_at' => now(),
                'expires_at' => now()->addDays($trialPackage->trial_duration_in_days),
                'active' => true,
                'is_trial' => true,
                'notes' => 'Free trial started - ' . $trialPackage->name,
            ]);

            $subscription->load('subscriptionPackage');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($subscription->toArray(), 'Free trial started successfully');
    }

    /**
     * Cancel the active subscription.
     * POST /api/provider/subscription/cancel
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function cancel(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $eProvider = $this->getProviderForUser($user);

            if (!$eProvider) {
                return $this->sendError('No provider profile found for this user');
            }

            $activeSubscription = EProviderSubscription::where('e_provider_id', $eProvider->id)
                ->valid()
                ->first();

            if (!$activeSubscription) {
                return $this->sendError('No active subscription found');
            }

            $activeSubscription->update([
                'active' => false,
                'notes' => ($activeSubscription->notes ? $activeSubscription->notes . ' | ' : '') . 'Cancelled on ' . now()->toDateTimeString(),
            ]);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($activeSubscription->toArray(), 'Subscription cancelled successfully');
    }

    /**
     * Get the EProvider associated with the authenticated user.
     *
     * @param $user
     * @return EProvider|null
     */
    private function getProviderForUser($user): ?EProvider
    {
        if (!$user) {
            return null;
        }
        return EProvider::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->first();
    }
}
