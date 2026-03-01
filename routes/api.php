<?php
/*
 * File name: api.php
 * Last modified: 2022.07.16 at 11:40:24
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('provider')->group(function () {
    Route::post('login', 'API\EProvider\UserAPIController@login');
    Route::post('register', 'API\EProvider\UserAPIController@register');
    Route::post('social/{provider}/login', 'API\\SocialAuthAPIController@login');
    Route::post('send_reset_link_email', 'API\UserAPIController@sendResetLinkEmail');
    Route::get('user', 'API\EProvider\UserAPIController@user');
    Route::get('logout', 'API\EProvider\UserAPIController@logout');
    Route::get('settings', 'API\EProvider\UserAPIController@settings');
    Route::get('translations', 'API\TranslationAPIController@translations');
    Route::get('supported_locales', 'API\TranslationAPIController@supportedLocales');
    Route::middleware('auth:api')->group(function () {
        Route::resource('e_providers', 'API\EProvider\EProviderAPIController')->only(['index', 'show']);
        Route::get('e_services', 'API\EProvider\EServiceAPIController@index');
        Route::resource('availability_hours', 'API\AvailabilityHourAPIController')->only(['store', 'update', 'destroy']);
        Route::resource('awards', 'API\AwardAPIController')->only(['store', 'update', 'destroy']);
        Route::resource('experiences', 'API\ExperienceAPIController')->only(['store', 'update', 'destroy']);
        Route::get('e_provider_types', 'API\EProviderTypeAPIController@index');
        Route::get('taxes', 'API\EProvider\TaxAPIController@index');
        Route::get('employees', 'API\EProvider\UserAPIController@employees');

        // Onboarding routes
        Route::post('onboarding/business', 'API\EProvider\OnboardingAPIController@business');
        Route::post('onboarding/address', 'API\EProvider\OnboardingAPIController@address');
        Route::post('onboarding/availability', 'API\EProvider\OnboardingAPIController@availability');
        Route::post('onboarding/complete', 'API\EProvider\OnboardingAPIController@complete');
        Route::get('onboarding/status', 'API\EProvider\OnboardingAPIController@status');
    });
});


Route::post('login', 'API\UserAPIController@login');
Route::post('register', 'API\UserAPIController@register');
Route::post('social/{provider}/login', 'API\\SocialAuthAPIController@login');
Route::post('send_reset_link_email', 'API\UserAPIController@sendResetLinkEmail');
Route::get('user', 'API\UserAPIController@user');
Route::get('logout', 'API\UserAPIController@logout');
Route::get('settings', 'API\UserAPIController@settings');
Route::get('translations', 'API\TranslationAPIController@translations');
Route::get('supported_locales', 'API\TranslationAPIController@supportedLocales');
Route::get('modules', 'API\ModuleAPIController@index');

Route::resource('e_providers', 'API\EProviderAPIController')->only(['index', 'show']);
Route::resource('availability_hours', 'API\AvailabilityHourAPIController')->only(['index', 'show']);
Route::resource('awards', 'API\AwardAPIController')->only(['index', 'show']);
Route::resource('experiences', 'API\ExperienceAPIController')->only(['index', 'show']);

Route::resource('faq_categories', 'API\FaqCategoryAPIController');
Route::resource('faqs', 'API\FaqAPIController');
Route::resource('custom_pages', 'API\CustomPageAPIController');

Route::resource('categories', 'API\CategoryAPIController');

Route::resource('e_services', 'API\EServiceAPIController');
Route::resource('galleries', 'API\GalleryAPIController');
Route::get('e_service_reviews/{id}', 'API\EServiceReviewAPIController@show');
Route::get('e_service_reviews', 'API\EServiceReviewAPIController@index');

Route::resource('currencies', 'API\CurrencyAPIController');
Route::resource('slides', 'API\SlideAPIController')->except([
    'show'
]);
Route::resource('booking_statuses', 'API\BookingStatusAPIController')->except([
    'show'
]);
Route::resource('option_groups', 'API\OptionGroupAPIController');
Route::resource('options', 'API\OptionAPIController');

Route::get('stories', 'API\StoryAPIController@index');
Route::get('stories/{id}', 'API\StoryAPIController@show');
Route::post('stories', 'API\StoryAPIController@store')->middleware('auth:api');

Route::get('style_quiz', 'API\StyleQuizAPIController@index');

// Public Shop Routes
Route::prefix('shop')->group(function () {
    Route::get('products', 'API\ProductAPIController@index');
    Route::get('products/{id}', 'API\ProductAPIController@show');
    Route::get('products/featured', 'API\ProductAPIController@featured');
    Route::get('products/popular', 'API\ProductAPIController@popular');
    Route::get('products/search', 'API\ProductAPIController@search');
});

Route::middleware('auth:api')->group(function () {
    Route::group(['middleware' => ['role:provider']], function () {
        Route::prefix('provider')->group(function () {
            Route::post('users/{user}', 'API\UserAPIController@update');
            Route::get('dashboard', 'API\DashboardAPIController@provider');
            Route::resource('notifications', 'API\NotificationAPIController');
            Route::put('payments/{id}', 'API\PaymentAPIController@update')->name('payments.update');

            // Product Management Routes
            Route::get('products', 'API\EProvider\ProductAPIController@index');
            Route::post('products', 'API\EProvider\ProductAPIController@store');
            Route::get('products/{id}', 'API\EProvider\ProductAPIController@show');
            Route::put('products/{id}', 'API\EProvider\ProductAPIController@update');
            Route::delete('products/{id}', 'API\EProvider\ProductAPIController@destroy');
            Route::get('product-analytics', 'API\EProvider\ProductAPIController@analytics');

            // Order Management Routes
            Route::get('orders', 'API\EProvider\OrderAPIController@index');
            Route::get('orders/{id}', 'API\EProvider\OrderAPIController@show');
            Route::put('orders/{id}/status', 'API\EProvider\OrderAPIController@updateStatus');
            Route::get('order-analytics', 'API\EProvider\OrderAPIController@analytics');
            Route::get('order-statuses', 'API\EProvider\OrderAPIController@getStatusOptions');
        });
    });
    Route::resource('e_providers', 'API\EProviderAPIController')->only([
        'store',
        'update',
        'destroy'
    ]);
    Route::post('uploads/store', 'API\UploadAPIController@store');
    Route::post('uploads/clear', 'API\UploadAPIController@clear');
    Route::post('users/{user}', 'API\UserAPIController@update');
    Route::delete('users', 'API\UserAPIController@destroy');

    Route::get('payments/byMonth', 'API\PaymentAPIController@byMonth')->name('payments.byMonth');
    Route::post('payments/wallets/{id}', 'API\PaymentAPIController@wallets')->name('payments.wallets');
    Route::post('payments/cash', 'API\PaymentAPIController@cash')->name('payments.cash');
    // Payment listing and details for authenticated users
    Route::get('payments', 'API\PaymentAPIController@index')->name('payments.index');
    Route::get('payments/{id}', 'API\PaymentAPIController@show')->name('payments.show');
    Route::post('payments/stripe/create-payment-intent', 'StripeController@createPaymentIntent');
    Route::get('payments/stripe/pay-booking', 'StripeController@PayBooking');
    Route::resource('payment_methods', 'API\PaymentMethodAPIController')->only([
        'index'
    ]);
    Route::post('e_service_reviews', 'API\EServiceReviewAPIController@store')->name('e_service_reviews.store');


    Route::resource('favorites', 'API\FavoriteAPIController');
    Route::resource('addresses', 'API\AddressAPIController');

    Route::get('notifications/count', 'API\NotificationAPIController@count');
    Route::resource('notifications', 'API\NotificationAPIController');
    Route::resource('bookings', 'API\BookingAPIController');

    Route::resource('earnings', 'API\EarningAPIController');

    Route::resource('e_provider_payouts', 'API\EProviderPayoutAPIController');

    Route::resource('coupons', 'API\CouponAPIController')->except([
        'show'
    ]);
    Route::resource('wallets', 'API\WalletAPIController')->except([
        'show',
        'create',
        'edit'
    ]);
    Route::get('wallet_transactions', 'API\WalletTransactionAPIController@index')->name('wallet_transactions.index');

    Route::post('providers/location/', 'API\EProviderLocationAPIController@updateLocation');

    Route::get('providers/location/{e_provider_id}/{booking_id}', 'API\EProviderLocationAPIController@getLocation');
});

/*
|--------------------------------------------------------------------------
| Payment Webhook Routes
|--------------------------------------------------------------------------
*/
Route::post('paystack/webhook', [App\Http\Controllers\API\PaystackWebhookController::class, 'handleWebhook']);
Route::get('paystack/verify/{reference}', [App\Http\Controllers\API\PaystackWebhookController::class, 'verifyPayment']);

/*
|--------------------------------------------------------------------------
| Payment Analytics Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:api', 'cache.response:30'])->group(function () {
    Route::get('analytics/payments/overview', [App\Http\Controllers\API\PaymentAnalyticsController::class, 'getOverview']);
    Route::get('analytics/payments/daily-revenue', [App\Http\Controllers\API\PaymentAnalyticsController::class, 'getDailyRevenue']);
    Route::get('analytics/payments/status-distribution', [App\Http\Controllers\API\PaymentAnalyticsController::class, 'getPaymentStatusDistribution']);
    Route::get('analytics/payments/top-services', [App\Http\Controllers\API\PaymentAnalyticsController::class, 'getTopServicesByRevenue']);
    Route::get('analytics/payments/recent-transactions', [App\Http\Controllers\API\PaymentAnalyticsController::class, 'getRecentTransactions']);
    Route::get('analytics/payments/trends', [App\Http\Controllers\API\PaymentAnalyticsController::class, 'getPaymentTrends']);
});
