<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Migration: Align provider types with the 0% commission subscription model.
 * In EWA's subscription model, stylists keep 100% of their booking revenue.
 * Setting e_provider_types.commission to 100.0 ensures that any legacy fallback
 * calculation allocates 100% to the provider and 0% to the admin.
 */
class SetProviderTypesZeroCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('e_provider_types')) {
            DB::table('e_provider_types')->update([
                'commission' => 100.0,
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('e_provider_types')) {
            DB::table('e_provider_types')->where('name', 'LIKE', '%Salon%')->update(['commission' => 80.0]);
            DB::table('e_provider_types')->where('name', 'LIKE', '%Mobile%')->update(['commission' => 75.0]);
            DB::table('e_provider_types')->where('name', 'LIKE', '%Home%')->update(['commission' => 70.0]);
            DB::table('e_provider_types')->where('name', 'LIKE', '%Barber%')->update(['commission' => 80.0]);
        }
    }
}
