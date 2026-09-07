<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Update all subscription packages to use 60-day trial periods.
 *
 * Business rule: Platform offers a unified 60-day (2-month) free trial
 * on all vendor subscription plans. Previously some packages used 90-day
 * or 30-day values.
 */
class UpdateTrialDurationTo60Days extends Migration
{
    public function up()
    {
        // 1. Update the Free Trial package: 90 → 60 days
        DB::table('subscription_packages')
            ->where('is_free_trial', true)
            ->update([
                'duration_in_days'        => 60,
                'trial_duration_in_days'  => 60,
                'description'             => DB::raw("REPLACE(description, '3 months', '2 months')"),
            ]);

        // 2. Update ALL paid packages to have a 60-day trial period
        //    (Starter, Professional, Enterprise)
        DB::table('subscription_packages')
            ->where('is_free_trial', false)
            ->update([
                'trial_duration_in_days' => 60,
            ]);

        // 3. Change the schema default for future packages
        if (Schema::hasColumn('subscription_packages', 'trial_duration_in_days')) {
            DB::statement('ALTER TABLE subscription_packages ALTER COLUMN trial_duration_in_days SET DEFAULT 60');
        }
    }

    public function down()
    {
        // Revert Free Trial back to 90 days
        DB::table('subscription_packages')
            ->where('is_free_trial', true)
            ->update([
                'duration_in_days'        => 90,
                'trial_duration_in_days'  => 90,
                'description'             => DB::raw("REPLACE(description, '2 months', '3 months')"),
            ]);

        // Revert paid packages to no trial
        DB::table('subscription_packages')
            ->where('is_free_trial', false)
            ->update([
                'trial_duration_in_days' => 0,
            ]);

        if (Schema::hasColumn('subscription_packages', 'trial_duration_in_days')) {
            DB::statement('ALTER TABLE subscription_packages ALTER COLUMN trial_duration_in_days SET DEFAULT 90');
        }
    }
}
