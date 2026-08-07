<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('e_providers', function (Blueprint $table) {
            $table->string('persona_inquiry_id')->nullable()->after('kyc_rtw_method');
            $table->string('persona_status')->nullable()->after('persona_inquiry_id');
            $table->json('persona_fields')->nullable()->after('persona_status');
        });
    }

    public function down(): void
    {
        Schema::table('e_providers', function (Blueprint $table) {
            $table->dropColumn(['persona_inquiry_id', 'persona_status', 'persona_fields']);
        });
    }
};
