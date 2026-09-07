<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Add vendor payout configuration settings.
 *
 * Adds:
 * - vendor_payout_mode: 'manual' or 'stripe_connect'
 * - stripe_connect_enabled: boolean flag
 *
 * Admin can toggle between manual (admin reviews and pays manually)
 * and Stripe Connect (automated payouts to vendor bank accounts).
 */
class AddVendorPayoutSettings extends Migration
{
    public function up()
    {
        // Add payout mode setting
        // Uses the app_settings table which stores key-value pairs
        DB::table('app_settings')->updateOrInsert(
            ['key' => 'vendor_payout_mode'],
            ['value' => json_encode('manual')]
        );

        DB::table('app_settings')->updateOrInsert(
            ['key' => 'stripe_connect_client_id'],
            ['value' => json_encode('')]
        );

        DB::table('app_settings')->updateOrInsert(
            ['key' => 'stripe_connect_webhook_secret'],
            ['value' => json_encode('')]
        );
    }

    public function down()
    {
        DB::table('app_settings')->where('key', 'vendor_payout_mode')->delete();
        DB::table('app_settings')->where('key', 'stripe_connect_client_id')->delete();
        DB::table('app_settings')->where('key', 'stripe_connect_webhook_secret')->delete();
    }
}
