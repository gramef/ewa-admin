<?php
/*
 * File name: SubscriptionPackageSeeder.php
 * Author: EWA Platform
 */

namespace Modules\Subscription\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Subscription\Models\SubscriptionPackage;

class SubscriptionPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubscriptionPackage::query()->delete();

        $packages = [
            [
                'name' => 'Free Trial',
                'description' => 'Try EWA free for 3 months. Get started with up to 5 services and 0% commission.',
                'price' => 0,
                'duration_in_days' => 90,
                'is_free_trial' => true,
                'trial_duration_in_days' => 90,
                'max_services' => 5,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 0,
                'featured_priority' => false,
                'enabled' => true,
                'sort_order' => 0,
            ],
            [
                'name' => 'Starter',
                'description' => 'Perfect for new stylists getting started. List up to 10 services with a small commission.',
                'price' => 9.99,
                'duration_in_days' => 30,
                'is_free_trial' => false,
                'trial_duration_in_days' => 0,
                'max_services' => 10,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 10,
                'featured_priority' => false,
                'enabled' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional',
                'description' => 'For established stylists who want unlimited services and featured placement.',
                'price' => 19.99,
                'duration_in_days' => 30,
                'is_free_trial' => false,
                'trial_duration_in_days' => 0,
                'max_services' => -1,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 5,
                'featured_priority' => true,
                'enabled' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Premium plan for high-volume salons. Unlimited everything with the lowest commission rate.',
                'price' => 39.99,
                'duration_in_days' => 30,
                'is_free_trial' => false,
                'trial_duration_in_days' => 0,
                'max_services' => -1,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 3,
                'featured_priority' => true,
                'enabled' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($packages as $package) {
            SubscriptionPackage::create($package);
        }
    }
}
