<?php
/*
 * File name: SubscriptionPackageController.php
 * Author: EWA Platform
 */

namespace Modules\Subscription\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Subscription\Models\EProviderSubscription;
use Modules\Subscription\Models\SubscriptionPackage;

/**
 * Class SubscriptionPackageController
 * @package Modules\Subscription\Http\Controllers\Admin
 */
class SubscriptionPackageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List all subscription packages.
     * GET /api/admin/subscription-packages
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = SubscriptionPackage::query();

            // Optional filter by enabled status
            if ($request->has('enabled')) {
                $query->where('enabled', $request->boolean('enabled'));
            }

            $packages = $query->orderBy('sort_order')
                ->orderBy('price')
                ->get();

            // Append active subscribers count
            $packages->each(function ($package) {
                $package->active_subscribers_count = $package->activeSubscribersCount;
            });
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($packages->toArray(), 'Subscription packages retrieved successfully');
    }

    /**
     * Store a new subscription package.
     * POST /api/admin/subscription-packages
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:127',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'duration_in_days' => 'required|integer|min:1',
                'is_free_trial' => 'boolean',
                'trial_duration_in_days' => 'integer|min:1',
                'max_services' => 'integer',
                'max_bookings_per_month' => 'integer',
                'commission_percentage' => 'numeric|min:0|max:100',
                'featured_priority' => 'boolean',
                'enabled' => 'boolean',
                'sort_order' => 'integer|min:0',
            ]);

            // Only allow one free trial package
            if (!empty($validated['is_free_trial'])) {
                $existingTrial = SubscriptionPackage::where('is_free_trial', true)->first();
                if ($existingTrial) {
                    return $this->sendError('A free trial package already exists. Please edit the existing one.');
                }
            }

            $package = SubscriptionPackage::create($validated);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($package->toArray(), 'Subscription package created successfully');
    }

    /**
     * Update an existing subscription package.
     * PUT /api/admin/subscription-packages/{id}
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        try {
            $package = SubscriptionPackage::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:127',
                'description' => 'nullable|string',
                'price' => 'sometimes|required|numeric|min:0',
                'duration_in_days' => 'sometimes|required|integer|min:1',
                'is_free_trial' => 'boolean',
                'trial_duration_in_days' => 'integer|min:1',
                'max_services' => 'integer',
                'max_bookings_per_month' => 'integer',
                'commission_percentage' => 'numeric|min:0|max:100',
                'featured_priority' => 'boolean',
                'enabled' => 'boolean',
                'sort_order' => 'integer|min:0',
            ]);

            // Only allow one free trial package
            if (!empty($validated['is_free_trial']) && !$package->is_free_trial) {
                $existingTrial = SubscriptionPackage::where('is_free_trial', true)
                    ->where('id', '!=', $id)
                    ->first();
                if ($existingTrial) {
                    return $this->sendError('A free trial package already exists. Please edit the existing one.');
                }
            }

            $package->update($validated);
            $package->refresh();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($package->toArray(), 'Subscription package updated successfully');
    }

    /**
     * Delete a subscription package.
     * DELETE /api/admin/subscription-packages/{id}
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $package = SubscriptionPackage::findOrFail($id);

            // Prevent deleting packages with active subscriptions
            $activeCount = EProviderSubscription::where('subscription_package_id', $id)
                ->where('active', true)
                ->where('expires_at', '>', now())
                ->count();

            if ($activeCount > 0) {
                return $this->sendError(
                    "Cannot delete this package. {$activeCount} provider(s) have active subscriptions on it. Disable it instead."
                );
            }

            $package->delete();
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($package->toArray(), 'Subscription package deleted successfully');
    }

    /**
     * Get subscription statistics for admin dashboard.
     * GET /api/admin/subscription-packages/stats
     *
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        try {
            $totalActive = EProviderSubscription::where('active', true)
                ->where('expires_at', '>', now())
                ->count();

            $totalTrials = EProviderSubscription::where('is_trial', true)
                ->where('active', true)
                ->where('expires_at', '>', now())
                ->count();

            $totalExpired = EProviderSubscription::where('expires_at', '<=', now())
                ->count();

            $totalRevenue = EProviderSubscription::join('subscription_packages', 'subscription_packages.id', '=', 'e_provider_subscriptions.subscription_package_id')
                ->where('e_provider_subscriptions.is_trial', false)
                ->sum('subscription_packages.price');

            // Per-package breakdown
            $packages = SubscriptionPackage::withCount([
                'eProviderSubscriptions as active_subscriptions_count' => function ($query) {
                    $query->where('active', true)->where('expires_at', '>', now());
                },
                'eProviderSubscriptions as total_subscriptions_count',
            ])->orderBy('sort_order')->get();

            $data = [
                'total_active_subscriptions' => $totalActive,
                'total_active_trials' => $totalTrials,
                'total_expired' => $totalExpired,
                'total_revenue' => round($totalRevenue, 2),
                'packages' => $packages->toArray(),
            ];
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($data, 'Subscription statistics retrieved successfully');
    }
}
