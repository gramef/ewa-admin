<?php
/*
 * File name: api.php
 * Author: EWA Platform
 */

use Illuminate\Support\Facades\Route;
use Modules\Subscription\Http\Controllers\SubscriptionAPIController;
use Modules\Subscription\Http\Controllers\SubscriptionCompatAPIController;
use Modules\Subscription\Http\Controllers\StripeSubscriptionController;
use Modules\Subscription\Http\Controllers\Admin\SubscriptionPackageController;

/*
|--------------------------------------------------------------------------
| Subscription Module API Routes
|--------------------------------------------------------------------------
|
| Routes are loaded by the SubscriptionServiceProvider and automatically
| prefixed by the RouteServiceProvider api prefix (/api).
|
*/

Route::prefix('api')->group(function () {

    // Public — list available subscription packages (new-style URL)
    Route::get('subscription-packages', [SubscriptionAPIController::class, 'packages']);

    // Backward-compatible: Flutter app calls this URL pattern
    Route::get('subscription/subscription_packages', [SubscriptionCompatAPIController::class, 'packages']);

    Route::middleware('auth:api')->group(function () {

        // ── New-style vendor subscription management ───────────────
        Route::prefix('provider/subscription')->group(function () {
            Route::get('status', [SubscriptionAPIController::class, 'status']);
            Route::post('subscribe', [SubscriptionAPIController::class, 'subscribe']);
            Route::post('start-trial', [SubscriptionAPIController::class, 'startTrial']);
            Route::post('cancel', [SubscriptionAPIController::class, 'cancel']);
            // Stripe Checkout for trial/paid subscriptions
            Route::post('create-checkout-session', [StripeSubscriptionController::class, 'createCheckoutSession']);
            Route::post('verify-checkout', [StripeSubscriptionController::class, 'verifyCheckout']);
            // Stripe Native Payment Sheet for mobile app
            Route::post('init-payment-sheet', [StripeSubscriptionController::class, 'initPaymentSheet']);
            Route::post('confirm-payment-sheet', [StripeSubscriptionController::class, 'confirmPaymentSheet']);
        });

        // ── Backward-compatible: Flutter app endpoints ─────────────
        Route::prefix('subscription')->group(function () {
            // Cash payment subscription
            Route::post('e_provider_subscriptions/cash', [SubscriptionCompatAPIController::class, 'cashSubscription']);
            // Wallet payment subscription
            Route::post('e_provider_subscriptions/wallet', [SubscriptionCompatAPIController::class, 'walletSubscription']);
            // Subscription history for vendor
            Route::get('e_provider_subscriptions', [SubscriptionCompatAPIController::class, 'subscriptions']);
        });

        // ── Admin subscription package management ──────────────────
        Route::prefix('admin/subscription-packages')->middleware('role:admin')->group(function () {
            Route::get('stats', [SubscriptionPackageController::class, 'stats']);
            Route::get('/', [SubscriptionPackageController::class, 'index']);
            Route::post('/', [SubscriptionPackageController::class, 'store']);
            Route::put('{id}', [SubscriptionPackageController::class, 'update']);
            Route::delete('{id}', [SubscriptionPackageController::class, 'destroy']);
        });
    });

    // Stripe Subscription Webhook (no auth required)
    Route::post('stripe/subscription-webhook', [StripeSubscriptionController::class, 'handleWebhook']);
});

