<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Migration: Align subscription packages with the official EWA Pricing Document (v1.1).
 *
 * Tier 1 — Essential:    £19.99/mo, 60-day trial, max 5 services, unlimited bookings, 0% commission
 * Tier 2 — Professional: £34.99/mo, 60-day trial, max 15 services, unlimited bookings, 0% commission, priority placement
 * Tier 3 — Elite:        £54.99/mo, 60-day trial, unlimited services, unlimited bookings, 0% commission, top visibility
 * Pure Free Trial:       £0, 60-day trial, max 5 services, unlimited bookings, 0% commission
 *
 * Core Rule: 0% commission on all bookings across all tiers ("No commission charged per booking").
 */
class AlignSubscriptionPackagesWithPricingDoc extends Migration
{
    public function up()
    {
        // 1. Update Free Trial package
        DB::table('subscription_packages')
            ->where('is_free_trial', true)
            ->update([
                'name' => 'Free Trial',
                'description' => 'Try EWA free for 2 months. Essential plan with up to 5 services, unlimited bookings, and 0% commission.',
                'price' => 0,
                'duration_in_days' => 60,
                'trial_duration_in_days' => 60,
                'max_services' => 5,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 0,
                'featured_priority' => false,
                'enabled' => true,
                'sort_order' => 0,
            ]);

        // 2. Update Starter -> Essential (£19.99/mo, 5 services, 0% commission)
        $starterExists = DB::table('subscription_packages')
            ->where('name', 'Starter')
            ->orWhere('name', 'Essential')
            ->exists();

        if ($starterExists) {
            DB::table('subscription_packages')
                ->where(function ($query) {
                    $query->where('name', 'Starter')
                          ->orWhere('name', 'Essential');
                })
                ->update([
                    'name' => 'Essential',
                    'description' => 'For new and part-time stylists. List up to 5 services with standard search visibility and zero commission.',
                    'price' => 19.99,
                    'duration_in_days' => 30,
                    'trial_duration_in_days' => 60,
                    'is_free_trial' => false,
                    'max_services' => 5,
                    'max_bookings_per_month' => -1,
                    'commission_percentage' => 0,
                    'featured_priority' => false,
                    'enabled' => true,
                    'sort_order' => 1,
                    'stripe_price_id' => null,
                ]);
        } else {
            DB::table('subscription_packages')->insert([
                'name' => 'Essential',
                'description' => 'For new and part-time stylists. List up to 5 services with standard search visibility and zero commission.',
                'price' => 19.99,
                'duration_in_days' => 30,
                'trial_duration_in_days' => 60,
                'is_free_trial' => false,
                'max_services' => 5,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 0,
                'featured_priority' => false,
                'enabled' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Update Professional (£34.99/mo, 15 services, 0% commission, priority placement)
        $proExists = DB::table('subscription_packages')
            ->where('name', 'Professional')
            ->exists();

        if ($proExists) {
            DB::table('subscription_packages')
                ->where('name', 'Professional')
                ->update([
                    'name' => 'Professional',
                    'description' => 'For growing stylists building a client base. Up to 15 services, priority placement, Pro badge, and promotional tools.',
                    'price' => 34.99,
                    'duration_in_days' => 30,
                    'trial_duration_in_days' => 60,
                    'is_free_trial' => false,
                    'max_services' => 15,
                    'max_bookings_per_month' => -1,
                    'commission_percentage' => 0,
                    'featured_priority' => true,
                    'enabled' => true,
                    'sort_order' => 2,
                    'stripe_price_id' => null,
                ]);
        } else {
            DB::table('subscription_packages')->insert([
                'name' => 'Professional',
                'description' => 'For growing stylists building a client base. Up to 15 services, priority placement, Pro badge, and promotional tools.',
                'price' => 34.99,
                'duration_in_days' => 30,
                'trial_duration_in_days' => 60,
                'is_free_trial' => false,
                'max_services' => 15,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 0,
                'featured_priority' => true,
                'enabled' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Update Enterprise -> Elite (£54.99/mo, unlimited services, 0% commission)
        $eliteExists = DB::table('subscription_packages')
            ->where('name', 'Enterprise')
            ->orWhere('name', 'Elite')
            ->exists();

        if ($eliteExists) {
            DB::table('subscription_packages')
                ->where(function ($query) {
                    $query->where('name', 'Enterprise')
                          ->orWhere('name', 'Elite');
                })
                ->update([
                    'name' => 'Elite',
                    'description' => 'For high-volume stylists and salon operators. Unlimited services, top visibility, Elite badge, and 1 included featured service.',
                    'price' => 54.99,
                    'duration_in_days' => 30,
                    'trial_duration_in_days' => 60,
                    'is_free_trial' => false,
                    'max_services' => -1,
                    'max_bookings_per_month' => -1,
                    'commission_percentage' => 0,
                    'featured_priority' => true,
                    'enabled' => true,
                    'sort_order' => 3,
                    'stripe_price_id' => null,
                ]);
        } else {
            DB::table('subscription_packages')->insert([
                'name' => 'Elite',
                'description' => 'For high-volume stylists and salon operators. Unlimited services, top visibility, Elite badge, and 1 included featured service.',
                'price' => 54.99,
                'duration_in_days' => 30,
                'trial_duration_in_days' => 60,
                'is_free_trial' => false,
                'max_services' => -1,
                'max_bookings_per_month' => -1,
                'commission_percentage' => 0,
                'featured_priority' => true,
                'enabled' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        DB::table('subscription_packages')
            ->where('name', 'Essential')
            ->update([
                'name' => 'Starter',
                'price' => 9.99,
                'max_services' => 10,
                'commission_percentage' => 10,
            ]);

        DB::table('subscription_packages')
            ->where('name', 'Professional')
            ->update([
                'price' => 19.99,
                'max_services' => -1,
                'commission_percentage' => 5,
            ]);

        DB::table('subscription_packages')
            ->where('name', 'Elite')
            ->update([
                'name' => 'Enterprise',
                'price' => 39.99,
                'commission_percentage' => 3,
            ]);
    }
}
