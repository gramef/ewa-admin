<?php

namespace Modules\Subscription\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EProvider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Subscription\Models\EProviderSubscription;
use Modules\Subscription\Models\SubscriptionPackage;
use Stripe\Checkout\Session as StripeCheckoutSession;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Customer;
use Stripe\Price;
use Stripe\Product;
use Stripe\Subscription;

/**
 * Handles Stripe Checkout Sessions for subscription trials and payments.
 *
 * Flow:
 * 1. Vendor clicks "Start 30-Day Free Trial" on Starter plan
 * 2. Frontend calls POST /api/provider/subscription/create-checkout-session
 * 3. Backend creates a Stripe Checkout Session with trial_period_days
 * 4. Frontend redirects vendor to Stripe Checkout URL
 * 5. After card entry, Stripe webhook fires → we activate the local subscription
 * 6. After trial ends, Stripe auto-charges the card
 */
class StripeSubscriptionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Stripe::setApiKey(setting('stripe_secret', config('services.stripe.secret', env('STRIPE_SECRET'))));
    }

    /**
     * Create a Stripe Checkout Session for a subscription with optional trial.
     * POST /api/provider/subscription/create-checkout-session
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createCheckoutSession(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'subscription_package_id' => 'required|exists:subscription_packages,id',
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

            // Get or create Stripe Price for this package
            $stripePriceId = $this->getOrCreateStripePrice($package);

            // Get or create Stripe Customer for this user
            $stripeCustomer = $this->getOrCreateStripeCustomer($user, $eProvider);

            // Build Checkout Session params
            $sessionParams = [
                'customer' => $stripeCustomer->id,
                'mode' => 'subscription',
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => $stripePriceId,
                    'quantity' => 1,
                ]],
                'success_url' => $request->input('success_url',
                    rtrim(config('app.vendor_pwa_url', 'https://ewa-vendor-pwa.vercel.app'), '/') . '/#/subscriptions?session_id={CHECKOUT_SESSION_ID}&status=success'
                ),
                'cancel_url' => $request->input('cancel_url',
                    rtrim(config('app.vendor_pwa_url', 'https://ewa-vendor-pwa.vercel.app'), '/') . '/#/subscriptions?status=cancelled'
                ),
                'metadata' => [
                    'e_provider_id' => $eProvider->id,
                    'user_id' => $user->id,
                    'subscription_package_id' => $package->id,
                    'package_name' => $package->name,
                ],
            ];

            // Add trial period if the package has one
            $trialDays = $package->is_free_trial
                ? ($package->trial_duration_in_days ?: $package->duration_in_days)
                : ($package->trial_duration_in_days ?: 0);

            if ($trialDays > 0) {
                $hasUsedTrial = EProviderSubscription::hasUsedTrial($eProvider->id, $user->id);

                if ($hasUsedTrial) {
                    return $this->sendError('Free trial has already been used for this provider');
                }

                $sessionParams['subscription_data'] = [
                    'trial_period_days' => $trialDays,
                    'metadata' => $sessionParams['metadata'],
                ];
            }

            $session = StripeCheckoutSession::create($sessionParams);

            Log::info("Stripe Checkout Session created for provider #{$eProvider->id}: {$session->id}");

            return $this->sendResponse([
                'checkout_url' => $session->url,
                'session_id' => $session->id,
            ], 'Checkout session created');

        } catch (Exception $e) {
            Log::error('Stripe Checkout Session creation failed: ' . $e->getMessage());
            return $this->sendError('Failed to create checkout session: ' . $e->getMessage());
        }
    }

    /**
     * Verify a completed Stripe Checkout Session and activate the subscription.
     * POST /api/provider/subscription/verify-checkout
     */
    public function verifyCheckout(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'session_id' => 'required|string',
            ]);

            $session = StripeCheckoutSession::retrieve([
                'id' => $request->session_id,
                'expand' => ['subscription', 'subscription.plan'],
            ]);

            if ($session->payment_status !== 'paid' && $session->status !== 'complete') {
                // For trials, status is 'complete' even without payment
                if (!($session->status === 'complete')) {
                    return $this->sendError('Payment not completed');
                }
            }

            $metadata = $session->metadata;
            $eProviderId = $metadata->e_provider_id;
            $packageId = $metadata->subscription_package_id;

            $package = SubscriptionPackage::findOrFail($packageId);
            $subscription = $session->subscription;

            // Check if we already processed this session
            $existing = EProviderSubscription::where('stripe_subscription_id', $subscription->id)->first();
            if ($existing) {
                return $this->sendResponse($existing->toArray(), 'Subscription already active');
            }

            // Deactivate any existing active subscriptions
            EProviderSubscription::where('e_provider_id', $eProviderId)
                ->where('active', true)
                ->update(['active' => false]);

            // Determine trial vs paid
            $isTrial = $subscription->status === 'trialing';
            $trialDays = $package->trial_duration_in_days ?: 0;
            $durationDays = $isTrial ? $trialDays : $package->duration_in_days;

            // Create local subscription record
            $localSub = EProviderSubscription::create([
                'e_provider_id' => $eProviderId,
                'subscription_package_id' => $packageId,
                'starts_at' => now(),
                'expires_at' => now()->addDays($durationDays),
                'active' => true,
                'is_trial' => $isTrial,
                'stripe_subscription_id' => $subscription->id,
                'stripe_customer_id' => $session->customer,
                'notes' => $isTrial
                    ? "Free trial started via Stripe - {$package->name}"
                    : "Subscribed via Stripe - {$package->name}",
            ]);

            $localSub->load('subscriptionPackage');

            Log::info("Subscription activated for provider #{$eProviderId}: " . ($isTrial ? 'Trial' : 'Paid'));

            return $this->sendResponse($localSub->toArray(), 'Subscription activated successfully');

        } catch (Exception $e) {
            Log::error('Stripe checkout verification failed: ' . $e->getMessage());
            return $this->sendError('Failed to verify checkout: ' . $e->getMessage());
        }
    }

    /**
     * Handle Stripe webhooks for subscription lifecycle events.
     * POST /api/stripe/subscription-webhook
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = setting('stripe_webhook_secret', env('STRIPE_WEBHOOK_SECRET'));

        try {
            if ($webhookSecret) {
                $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
            } else {
                $data = json_decode($payload, true);
                $event = (object) $data;
                $event->type = $data['type'] ?? '';
                $event->data = (object) ['object' => (object) ($data['data']['object'] ?? [])];
            }
        } catch (Exception $e) {
            Log::error('Stripe webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $object = $event->data->object;

        switch ($event->type) {
            case 'customer.subscription.updated':
                $this->handleSubscriptionUpdated($object);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionCancelled($object);
                break;

            case 'invoice.payment_succeeded':
                $this->handlePaymentSucceeded($object);
                break;

            case 'invoice.payment_failed':
                $this->handlePaymentFailed($object);
                break;

            case 'customer.subscription.trial_will_end':
                Log::info('Stripe: Trial ending soon for subscription ' . ($object->id ?? 'unknown'));
                break;
        }

        return response()->json(['status' => 'ok']);
    }

    // ─── Webhook event handlers ────────────────────────────────────

    private function handleSubscriptionUpdated($subscription): void
    {
        $localSub = EProviderSubscription::where('stripe_subscription_id', $subscription->id)->first();
        if (!$localSub) return;

        // Trial ended → now active paid subscription
        if ($subscription->status === 'active' && $localSub->is_trial) {
            $package = $localSub->subscriptionPackage;
            $localSub->update([
                'is_trial' => false,
                'starts_at' => now(),
                'expires_at' => now()->addDays($package->duration_in_days ?? 30),
                'notes' => ($localSub->notes ? $localSub->notes . ' | ' : '') .
                    'Trial converted to paid on ' . now()->toDateTimeString(),
            ]);
            Log::info("Subscription #{$localSub->id} converted from trial to paid");
        }
    }

    private function handleSubscriptionCancelled($subscription): void
    {
        $localSub = EProviderSubscription::where('stripe_subscription_id', $subscription->id)->first();
        if (!$localSub) return;

        $localSub->update([
            'active' => false,
            'notes' => ($localSub->notes ? $localSub->notes . ' | ' : '') .
                'Cancelled by Stripe on ' . now()->toDateTimeString(),
        ]);
        Log::info("Subscription #{$localSub->id} cancelled via Stripe webhook");
    }

    private function handlePaymentSucceeded($invoice): void
    {
        $subId = $invoice->subscription ?? null;
        if (!$subId) return;

        $localSub = EProviderSubscription::where('stripe_subscription_id', $subId)->first();
        if (!$localSub) return;

        // Renewal payment — extend the subscription
        $package = $localSub->subscriptionPackage;
        $localSub->update([
            'active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addDays($package->duration_in_days ?? 30),
            'notes' => ($localSub->notes ? $localSub->notes . ' | ' : '') .
                'Payment succeeded on ' . now()->toDateTimeString(),
        ]);
        Log::info("Payment succeeded for subscription #{$localSub->id}");
    }

    private function handlePaymentFailed($invoice): void
    {
        $subId = $invoice->subscription ?? null;
        if (!$subId) return;

        $localSub = EProviderSubscription::where('stripe_subscription_id', $subId)->first();
        if (!$localSub) return;

        Log::warning("Payment failed for subscription #{$localSub->id}");
    }

    // ─── Helpers ───────────────────────────────────────────────────

    /**
     * Get or create a Stripe Price for a subscription package.
     */
    private function getOrCreateStripePrice(SubscriptionPackage $package): string
    {
        // If we already have a Stripe Price ID stored, use it
        if ($package->stripe_price_id) {
            return $package->stripe_price_id;
        }

        // Create a Stripe Product
        $product = Product::create([
            'name' => 'EWA - ' . $package->name,
            'description' => $package->description ?: $package->name,
        ]);

        // Create a recurring Price
        $currencyCode = strtolower(setting('default_currency_code', 'GBP'));
        $price = Price::create([
            'product' => $product->id,
            'unit_amount' => (int) round($package->price * 100), // Stripe uses cents
            'currency' => $currencyCode,
            'recurring' => [
                'interval' => 'month',
                'interval_count' => 1,
            ],
        ]);

        // Save the Stripe Price ID
        $package->update(['stripe_price_id' => $price->id]);

        return $price->id;
    }

    /**
     * Get or create a Stripe Customer for the user.
     */
    private function getOrCreateStripeCustomer($user, $eProvider): Customer
    {
        // Check if we have an existing customer ID
        $existingSub = EProviderSubscription::where('e_provider_id', $eProvider->id)
            ->whereNotNull('stripe_customer_id')
            ->first();

        if ($existingSub && $existingSub->stripe_customer_id) {
            try {
                return Customer::retrieve($existingSub->stripe_customer_id);
            } catch (Exception $e) {
                // Customer may have been deleted, create a new one
            }
        }

        return Customer::create([
            'email' => $user->email,
            'name' => $user->name,
            'metadata' => [
                'user_id' => $user->id,
                'e_provider_id' => $eProvider->id,
                'provider_name' => $eProvider->name,
            ],
        ]);
    }

    /**
     * Get the EProvider associated with the authenticated user.
     */
    private function getProviderForUser($user): ?EProvider
    {
        if (!$user) return null;
        return EProvider::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->first();
    }
}
