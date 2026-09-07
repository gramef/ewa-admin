<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Ensure provider types default to 100% provider payout (0% platform commission on bookings).
 * EWA revenue model is subscription-based.
 */
class SetDefaultProviderTypeCommission extends Migration
{
    public function up()
    {
        if (Schema::hasTable('e_provider_types')) {
            DB::table('e_provider_types')
                ->where('commission', '<', 100)
                ->update(['commission' => 100]);
        }
    }

    public function down()
    {
        // No-op
    }
}
