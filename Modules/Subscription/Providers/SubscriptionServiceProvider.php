<?php
/*
 * File name: SubscriptionServiceProvider.php
 * Author: EWA Platform
 */

namespace Modules\Subscription\Providers;

use Illuminate\Support\ServiceProvider;

class SubscriptionServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(module_path('Subscription', 'Database/Migrations'));
        $this->loadRoutesFrom(module_path('Subscription', 'Routes/api.php'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }
}
