<?php
/*
 * File name: web.php
 * Subscription Module Web Routes
 * Author: EWA Platform
 */

use Illuminate\Support\Facades\Route;
use Modules\Subscription\Http\Controllers\Admin\SubscriptionPackageWebController;
use Modules\Subscription\Http\Controllers\Admin\EProviderSubscriptionWebController;

/*
|--------------------------------------------------------------------------
| Subscription Module Web Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the SubscriptionServiceProvider within the
| "web" middleware group and handle the admin panel Blade/DataTable views.
|
*/

Route::middleware('auth')->group(function () {

    // Subscription Packages — full CRUD
    Route::resource('subscriptionPackages', SubscriptionPackageWebController::class)->except([
        'show',
    ]);

    // Provider Subscriptions — read-only list + cancel + extend
    Route::resource('eProviderSubscriptions', EProviderSubscriptionWebController::class)->only([
        'index', 'destroy',
    ]);
    Route::get('eProviderSubscriptions/{id}/extend', [EProviderSubscriptionWebController::class, 'extend'])
        ->name('eProviderSubscriptions.extend');
});
