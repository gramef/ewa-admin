<?php
/*
 * File name: SubscriptionCompatAPIController.php
 * Author: EWA Platform
 *
 * Backward-compatible API controller that maps old-style
 * Flutter app endpoint calls to the new subscription system.
 */

namespace Modules\Subscription\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EProvider;
use App\Models\Payment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Subscription\Models\EProviderSubscription;
use Modules\Subscription\Models\SubscriptionPackage;

/**
 * Class SubscriptionCompatAPIController
 *
 * Provides backward-compatible endpoints matching the URL patterns
 * expected by the EWA-Hair-Vendors Flutter app.
 */
class SubscriptionCompatAPIController extends Controller
{
    /**
     * List subscription packages (old-style URL).
     * GET /api/subscription/subscription_packages
     *
     * The Flutter app sends: orderBy, sortedBy as query params.
     */
    public function packages(Request $request): JsonResponse
    {
        try {
            $query = SubscriptionPackage::where('enabled', true);

            // Support the InfyOm-style orderBy/sortedBy params from the app
            $orderBy = $request->get('orderBy', 'sort_order');
            $sortedBy = $request->get('sortedBy', 'asc');
            $query->orderBy($orderBy, $sortedBy);

            $packages = $query->get();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($packages->toArray(), 'Subscription packages retrieved successfully');
    }

    /**
     * Create a subscription via cash payment.
     * POST /api/subscription/e_provider_subscriptions/cash
     *
     * The Flutter app sends JSON with:
     * - e_provider_id
     * - subscription_package_id
     * - starts_at, expires_at, active
     */
    public function cashSubscription(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $data = $request->all();

            $eProviderId = $data['e_provider_id'] ?? null;
            $packageId = $data['subscription_package_id'] ?? null;

            if (!$eProviderId || !$packageId) {
                return $this->sendError('e_provider_id and subscription_package_id are required');
            }

            $package = SubscriptionPackage::findOrFail($packageId);

            if ($package->is_free_trial || $package->price <= 0) {
                if (EProviderSubscription::hasUsedTrial((int)$eProviderId, $user->id ?? null)) {
                    return $this->sendError('Free trial has already been used for this account');
                }
            }

            // Deactivate existing active subscriptions
            EProviderSubscription::where('e_provider_id', $eProviderId)
                ->where('active', true)
                ->update(['active' => false]);

            // Create a cash payment record
            $payment = Payment::create([
                'amount' => $package->price,
                'description' => 'Subscription: ' . $package->name,
                'user_id' => $user->id ?? null,
                'payment_method_id' => $this->getCashPaymentMethodId(),
                'payment_status_id' => $this->getPaidStatusId(),
            ]);

            $duration = ($package->is_free_trial ? ($package->trial_duration_in_days ?: $package->duration_in_days) : $package->duration_in_days);

            // Create the subscription
            $subscription = EProviderSubscription::create([
                'e_provider_id' => $eProviderId,
                'subscription_package_id' => $packageId,
                'starts_at' => now(),
                'expires_at' => now()->addDays($duration),
                'active' => true,
                'is_trial' => (bool)($package->is_free_trial || $package->price <= 0),
                'payment_id' => $payment->id,
                'notes' => 'Subscribed via cash - ' . $package->name,
            ]);

            $subscription->load('eProvider', 'subscriptionPackage', 'payment', 'payment.paymentMethod');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($subscription->toArray(), 'Subscription created successfully');
    }

    /**
     * Create a subscription via wallet payment.
     * POST /api/subscription/e_provider_subscriptions/wallet
     */
    public function walletSubscription(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $data = $request->all();

            $eProviderId = $data['e_provider_id'] ?? null;
            $packageId = $data['subscription_package_id'] ?? null;
            $walletId = $request->get('wallet_id');

            if (!$eProviderId || !$packageId) {
                return $this->sendError('e_provider_id and subscription_package_id are required');
            }

            $package = SubscriptionPackage::findOrFail($packageId);

            if ($package->is_free_trial || $package->price <= 0) {
                if (EProviderSubscription::hasUsedTrial((int)$eProviderId, $user->id ?? null)) {
                    return $this->sendError('Free trial has already been used for this account');
                }
            }

            // Deactivate existing active subscriptions
            EProviderSubscription::where('e_provider_id', $eProviderId)
                ->where('active', true)
                ->update(['active' => false]);

            // Create a wallet payment record
            $payment = Payment::create([
                'amount' => $package->price,
                'description' => 'Subscription (wallet): ' . $package->name,
                'user_id' => $user->id ?? null,
                'payment_method_id' => $this->getWalletPaymentMethodId(),
                'payment_status_id' => $this->getPaidStatusId(),
            ]);

            // Deduct from wallet if applicable
            if ($walletId) {
                $wallet = \App\Models\Wallet::find($walletId);
                if ($wallet && $wallet->balance >= $package->price) {
                    $wallet->balance -= $package->price;
                    $wallet->save();
                }
            }

            $duration = ($package->is_free_trial ? ($package->trial_duration_in_days ?: $package->duration_in_days) : $package->duration_in_days);

            // Create the subscription
            $subscription = EProviderSubscription::create([
                'e_provider_id' => $eProviderId,
                'subscription_package_id' => $packageId,
                'starts_at' => now(),
                'expires_at' => now()->addDays($duration),
                'active' => true,
                'is_trial' => (bool)($package->is_free_trial || $package->price <= 0),
                'payment_id' => $payment->id,
                'notes' => 'Subscribed via wallet - ' . $package->name,
            ]);

            $subscription->load('eProvider', 'subscriptionPackage', 'payment', 'payment.paymentMethod');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($subscription->toArray(), 'Subscription created successfully');
    }

    /**
     * Get subscription history for the authenticated vendor.
     * GET /api/subscription/e_provider_subscriptions
     *
     * The Flutter app sends: with, orderBy, sortedBy, api_token
     */
    public function subscriptions(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $eProvider = EProvider::whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            })->first();

            if (!$eProvider) {
                return $this->sendResponse([], 'No provider found');
            }

            $query = EProviderSubscription::where('e_provider_id', $eProvider->id);

            // Support eager loading from 'with' param
            $with = $request->get('with', '');
            if ($with) {
                $relations = explode(';', $with);
                $query->with($relations);
            }

            $orderBy = $request->get('orderBy', 'updated_at');
            $sortedBy = $request->get('sortedBy', 'desc');
            $query->orderBy($orderBy, $sortedBy);

            $subscriptions = $query->get();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($subscriptions->toArray(), 'Provider subscriptions retrieved successfully');
    }

    /**
     * Get cash payment method ID.
     */
    private function getCashPaymentMethodId(): ?int
    {
        $method = \App\Models\PaymentMethod::where('route', '/Cash')->orWhere('name', 'Cash')->first();
        return $method->id ?? null;
    }

    /**
     * Get wallet payment method ID.
     */
    private function getWalletPaymentMethodId(): ?int
    {
        $method = \App\Models\PaymentMethod::where('route', '/Wallet')->orWhere('name', 'Wallet')->first();
        return $method->id ?? null;
    }

    /**
     * Get "Paid" payment status ID.
     */
    private function getPaidStatusId(): ?int
    {
        $status = \App\Models\PaymentStatus::where('status', 'Paid')->first();
        return $status->id ?? null;
    }
}
