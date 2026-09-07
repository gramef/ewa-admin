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
                'description' => 'Try EWA free for 2 months. Essential plan with up to 5 services, unlimited bookings, and 0% commission.',
                'price' => 0,
                'duration_in_days' => 60,
                'is_free_trial' => true,
                'trial_duration_in_days' => 60,
                'max_services' => 5,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 0,
                'featured_priority' => false,
                'enabled' => true,
                'sort_order' => 0,
            ],
            [
                'name' => 'Essential',
                'description' => 'For new and part-time stylists. List up to 5 services with standard search visibility and zero commission.',
                'price' => 19.99,
                'duration_in_days' => 30,
                'is_free_trial' => false,
                'trial_duration_in_days' => 60,
                'max_services' => 5,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 0,
                'featured_priority' => false,
                'enabled' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional',
                'description' => 'For growing stylists building a client base. Up to 15 services, priority placement, Pro badge, and promotional tools.',
                'price' => 34.99,
                'duration_in_days' => 30,
                'is_free_trial' => false,
                'trial_duration_in_days' => 60,
                'max_services' => 15,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 0,
                'featured_priority' => true,
                'enabled' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Elite',
                'description' => 'For high-volume stylists and salon operators. Unlimited services, top visibility, Elite badge, and 1 included featured service.',
                'price' => 54.99,
                'duration_in_days' => 30,
                'is_free_trial' => false,
                'trial_duration_in_days' => 60,
                'max_services' => -1,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 0,
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
