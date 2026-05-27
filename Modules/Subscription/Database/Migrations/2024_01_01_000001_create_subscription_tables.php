<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 127);
            $table->text('description')->nullable();
            $table->double('price', 8, 2)->default(0);
            $table->integer('duration_in_days')->default(30);
            $table->boolean('is_free_trial')->default(false);
            $table->integer('trial_duration_in_days')->default(90);
            $table->integer('max_services')->default(-1);
            $table->integer('max_bookings_per_month')->default(-1);
            $table->double('commission_percentage', 5, 2)->default(0);
            $table->boolean('featured_priority')->default(false);
            $table->boolean('enabled')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('e_provider_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('e_provider_id')->unsigned();
            $table->integer('subscription_package_id')->unsigned();
            $table->dateTime('starts_at');
            $table->dateTime('expires_at');
            $table->boolean('active')->default(true);
            $table->boolean('is_trial')->default(false);
            $table->integer('payment_id')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('e_provider_id')
                ->references('id')->on('e_providers')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('subscription_package_id')
                ->references('id')->on('subscription_packages')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('payment_id')
                ->references('id')->on('payments')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_provider_subscriptions');
        Schema::dropIfExists('subscription_packages');
    }
}
