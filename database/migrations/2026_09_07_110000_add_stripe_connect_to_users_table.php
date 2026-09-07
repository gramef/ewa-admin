<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds Stripe Connect fields to the users table.
 *
 * - stripe_connect_id: Stripe Express connected account ID (e.g. acct_123)
 * - stripe_connect_onboarded: Whether vendor has completed Stripe onboarding and linked bank account
 */
class AddStripeConnectToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'stripe_connect_id')) {
                $table->string('stripe_connect_id')->nullable()->after('stripe_id');
            }
            if (!Schema::hasColumn('users', 'stripe_connect_onboarded')) {
                $table->boolean('stripe_connect_onboarded')->default(false)->after('stripe_connect_id');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'stripe_connect_onboarded')) {
                $table->dropColumn('stripe_connect_onboarded');
            }
            if (Schema::hasColumn('users', 'stripe_connect_id')) {
                $table->dropColumn('stripe_connect_id');
            }
        });
    }
}
