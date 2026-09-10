<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Referral Packages table
        if (!Schema::hasTable('referral_packages')) {
            Schema::create('referral_packages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('target_role', 32)->default('client'); // client, vendor, all
                $table->string('reward_type', 32)->default('fixed_discount'); // fixed_discount, percentage_discount, wallet_credit, commission_reduction
                $table->decimal('referrer_reward_value', 8, 2)->default(10.00);
                $table->decimal('referee_reward_value', 8, 2)->default(5.00);
                $table->decimal('min_booking_amount', 8, 2)->default(0.00);
                $table->unsignedInteger('required_completed_bookings')->default(1);
                $table->text('description')->nullable();
                $table->boolean('enabled')->default(true);
                $table->dateTime('starts_at')->nullable();
                $table->dateTime('expires_at')->nullable();
                $table->timestamps();
            });
        }

        // 2. User Referrals tracking table
        if (!Schema::hasTable('user_referrals')) {
            Schema::create('user_referrals', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('referrer_id');
                $table->unsignedBigInteger('referee_id');
                $table->unsignedBigInteger('referral_package_id')->nullable();
                $table->string('referral_code', 32);
                $table->string('status', 32)->default('pending'); // pending, qualified, rewarded, cancelled
                $table->unsignedBigInteger('qualifying_booking_id')->nullable();
                $table->unsignedBigInteger('referrer_coupon_id')->nullable();
                $table->unsignedBigInteger('referee_coupon_id')->nullable();
                $table->dateTime('rewarded_at')->nullable();
                $table->timestamps();

                $table->index('referrer_id');
                $table->index('referee_id');
                $table->index('referral_code');
                $table->index('status');
            });
        }

        // 3. Add referral_code to users table if missing
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'referral_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('referral_code', 32)->nullable()->unique()->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_referrals');
        Schema::dropIfExists('referral_packages');

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'referral_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('referral_code');
            });
        }
    }
};
