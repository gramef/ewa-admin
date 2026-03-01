<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateToV300 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('e_provider_payouts')) {
            Schema::table('e_provider_payouts', function (Blueprint $table) {
                $table->string('full_name', 255)->nullable();
                $table->string('bank_name', 255)->nullable();
                $table->string('account_number', 255)->nullable();
                $table->string('iban', 34)->nullable();
                $table->string('sort_code', 11)->nullable();
                $table->string('receipt_pdf')->nullable();
                $table->boolean('paid')->default(false);
            });
        }

        if (Schema::hasTable('earnings')) {
            Schema::table('earnings', function (Blueprint $table) {
                $table->double('payout', 10, 2)->default(0);

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

    }
}
