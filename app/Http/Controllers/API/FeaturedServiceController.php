<?php
/**
 * FeaturedServiceController
 * Handles Stripe payment for featuring a service.
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class FeaturedServiceController extends Controller
{
    /**
     * Get the featured service price from admin settings.
     * GET /api/featured/price
     */
    public function getPrice(): JsonResponse
    {
        $price = (float) setting('featured_service_price', 9.99);
        $currency = setting('default_currency_code', 'gbp');
        $duration = (int) setting('featured_service_duration_days', 30);

        $isElite = false;
        $freeBoostAvailable = false;

        $user = auth('api')->user() ?? auth()->user();
        if ($user && class_exists('\Nwidart\Modules\Facades\Module') && \Nwidart\Modules\Facades\Module::isActivated('Subscription')) {
            $provider = $user->eProviders()->first();
            if ($provider) {
                $activeSub = \Modules\Subscription\Models\EProviderSubscription::where('e_provider_id', $provider->id)
                    ->valid()
                    ->with('subscriptionPackage')
                    ->first();
                $pkgName = strtolower($activeSub && $activeSub->subscriptionPackage ? $activeSub->subscriptionPackage->name : '');
                if (strpos($pkgName, 'elite') !== false || strpos($pkgName, 'enterprise') !== false) {
                    $isElite = true;
                    $activeFeaturedCount = EService::where('e_provider_id', $provider->id)->where('featured', true)->count();
                    $freeBoostAvailable = ($activeFeaturedCount === 0);
                }
            }
        }

        return $this->sendResponse([
            'price' => $price,
            'currency' => $currency,
            'duration_days' => $duration,
            'display_price' => '£' . number_format($price, 2),
            'description' => "Feature your service for {$duration} days",
            'is_elite' => $isElite,
            'free_boost_available' => $freeBoostAvailable,
        ], 'Featured price retrieved');
    }

    /**
     * Activate 1 included free monthly featured boost for Elite subscribers.
     * POST /api/featured/activate-tier-boost
     */
    public function activateTierBoost(Request $request): JsonResponse
    {
        $request->validate([
            'e_service_id' => 'required|exists:e_services,id',
        ]);

        $user = auth('api')->user() ?? auth()->user();
        if (!$user) {
            return $this->sendError('Unauthenticated', 401);
        }

        $service = EService::findOrFail($request->e_service_id);

        $provider = $user->eProviders()->where('e_providers.id', $service->e_provider_id)->first();
        if (!$provider) {
            return $this->sendError('You do not own this service');
        }

        if ($service->featured) {
            return $this->sendError('This service is already featured');
        }

        // Check if provider has an active Elite tier subscription
        $isElite = false;
        if (class_exists('\Nwidart\Modules\Facades\Module') && \Nwidart\Modules\Facades\Module::isActivated('Subscription')) {
            $activeSub = \Modules\Subscription\Models\EProviderSubscription::where('e_provider_id', $provider->id)
                ->valid()
                ->with('subscriptionPackage')
                ->first();
            $pkgName = strtolower($activeSub && $activeSub->subscriptionPackage ? $activeSub->subscriptionPackage->name : '');
            if (strpos($pkgName, 'elite') !== false || strpos($pkgName, 'enterprise') !== false) {
                $isElite = true;
            }
        }

        if (!$isElite) {
            return $this->sendError('Free monthly boosts are exclusively included in the Elite tier plan.');
        }

        // Check if vendor already has an active featured service boosted
        $activeFeaturedCount = EService::where('e_provider_id', $provider->id)->where('featured', true)->count();
        if ($activeFeaturedCount >= 1) {
            return $this->sendError('Your Elite tier includes 1 featured service boost at a time. You already have an active featured service.');
        }

        $duration = (int) setting('featured_service_duration_days', 30);
        $service->featured = true;
        $service->save();

        Log::info("Service #{$service->id} featured via Elite Plan included boost by provider #{$provider->id}");

        return $this->sendResponse([
            'featured' => true,
            'service_id' => $service->id,
            'service_name' => $service->name,
            'expires_info' => "Featured for {$duration} days via Elite Plan boost",
        ], '🌟 Service featured successfully using your Elite plan monthly boost!');
    }

    /**
     * Create a Stripe PaymentIntent for featuring a service.
     * POST /api/featured/create-intent
     */
    public function createIntent(Request $request): JsonResponse
    {
        $request->validate([
            'e_service_id' => 'required|exists:e_services,id',
        ]);

        $user = auth()->user();
        $service = EService::findOrFail($request->e_service_id);

        // Verify vendor owns this service
        $providerIds = $user->eProviders()->pluck('e_providers.id')->toArray();
        if (!in_array($service->e_provider_id, $providerIds)) {
            return $this->sendError('You do not own this service');
        }

        if ($service->featured) {
            return $this->sendError('This service is already featured');
        }

        $price = (float) setting('featured_service_price', 9.99);
        $currency = setting('default_currency_code', 'gbp');

        $stripeSecret = setting('stripe_secret') ?: config('services.stripe.secret') ?: env('STRIPE_SECRET');
        if (empty($stripeSecret)) {
            return $this->sendError('Payment system not configured', 500);
        }

        try {
            Stripe::setApiKey($stripeSecret);

            $intent = PaymentIntent::create([
                'amount' => (int) ($price * 100), // Stripe uses pence/cents
                'currency' => $currency,
                'metadata' => [
                    'type' => 'featured_service',
                    'e_service_id' => $service->id,
                    'e_service_name' => $service->name,
                    'user_id' => $user->id,
                    'vendor_name' => $user->name,
                ],
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            Log::info("Featured intent created: service #{$service->id}, amount £{$price}", [
                'intent_id' => $intent->id,
                'user_id' => $user->id,
            ]);

            return $this->sendResponse([
                'client_secret' => $intent->client_secret,
                'intent_id' => $intent->id,
                'amount' => $price,
                'currency' => $currency,
            ], 'Payment intent created');

        } catch (\Exception $e) {
            Log::error("Featured intent failed: " . $e->getMessage());
            return $this->sendError('Payment setup failed: ' . $e->getMessage());
        }
    }

    /**
     * Confirm featured payment and activate featured status.
     * POST /api/featured/confirm
     */
    public function confirm(Request $request): JsonResponse
    {
        $request->validate([
            'e_service_id' => 'required|exists:e_services,id',
            'payment_intent_id' => 'required|string',
        ]);

        $user = auth()->user();
        $service = EService::findOrFail($request->e_service_id);

        // Verify ownership
        $providerIds = $user->eProviders()->pluck('e_providers.id')->toArray();
        if (!in_array($service->e_provider_id, $providerIds)) {
            return $this->sendError('You do not own this service');
        }

        $stripeSecret = setting('stripe_secret') ?: config('services.stripe.secret') ?: env('STRIPE_SECRET');
        if (empty($stripeSecret)) {
            return $this->sendError('Payment system not configured', 500);
        }

        try {
            Stripe::setApiKey($stripeSecret);
            $intent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($intent->status !== 'succeeded') {
                return $this->sendError('Payment has not been completed. Status: ' . $intent->status);
            }

            // Verify this intent is for this service
            if (($intent->metadata->e_service_id ?? '') != $service->id) {
                return $this->sendError('Payment does not match this service');
            }

            // Activate featured status
            $duration = (int) setting('featured_service_duration_days', 30);
            $service->featured = true;
            $service->save();

            Log::info("Service #{$service->id} featured via Stripe payment {$intent->id}");

            return $this->sendResponse([
                'featured' => true,
                'service_id' => $service->id,
                'service_name' => $service->name,
                'expires_info' => "Featured for {$duration} days",
            ], 'Service is now featured! 🌟');

        } catch (\Exception $e) {
            Log::error("Featured confirm failed: " . $e->getMessage());
            return $this->sendError('Could not verify payment: ' . $e->getMessage());
        }
    }
}
