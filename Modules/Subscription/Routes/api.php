<?php
/*
 * File name: api.php
 * Author: EWA Platform
 */

use Illuminate\Support\Facades\Route;
use Modules\Subscription\Http\Controllers\SubscriptionAPIController;
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

    // Public — list available subscription packages
    Route::get('subscription-packages', [SubscriptionAPIController::class, 'packages']);

    Route::middleware('auth:api')->group(function () {

        // Vendor subscription management
        Route::prefix('provider/subscription')->group(function () {
            Route::get('status', [SubscriptionAPIController::class, 'status']);
            Route::post('subscribe', [SubscriptionAPIController::class, 'subscribe']);
            Route::post('start-trial', [SubscriptionAPIController::class, 'startTrial']);
            Route::post('cancel', [SubscriptionAPIController::class, 'cancel']);
        });

        // Admin subscription package management
        Route::prefix('admin/subscription-packages')->middleware('role:admin')->group(function () {
            Route::get('stats', [SubscriptionPackageController::class, 'stats']);
            Route::get('/', [SubscriptionPackageController::class, 'index']);
            Route::post('/', [SubscriptionPackageController::class, 'store']);
            Route::put('{id}', [SubscriptionPackageController::class, 'update']);
            Route::delete('{id}', [SubscriptionPackageController::class, 'destroy']);
        });
    });
});
