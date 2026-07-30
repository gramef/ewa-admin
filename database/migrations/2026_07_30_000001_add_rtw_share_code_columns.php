<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add UK Share Code columns for Right-to-Work verification.
 * Vendors provide their GOV.UK share code + DOB instead of uploading RTW documents.
 * This eliminates GDPR risk of storing sensitive immigration documents.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('e_providers', function (Blueprint $table) {
            if (!Schema::hasColumn('e_providers', 'kyc_rtw_share_code')) {
                $table->string('kyc_rtw_share_code', 20)->nullable()->after('kyc_rtw_document');
            }
            if (!Schema::hasColumn('e_providers', 'kyc_rtw_dob')) {
                $table->date('kyc_rtw_dob')->nullable()->after('kyc_rtw_share_code');
            }
            if (!Schema::hasColumn('e_providers', 'kyc_rtw_method')) {
                // 'share_code' or 'document' — tracks which method the vendor used
                $table->string('kyc_rtw_method', 20)->default('document')->after('kyc_rtw_dob');
            }
        });
    }

    public function down(): void
    {
        Schema::table('e_providers', function (Blueprint $table) {
            foreach (['kyc_rtw_share_code', 'kyc_rtw_dob', 'kyc_rtw_method'] as $column) {
                if (Schema::hasColumn('e_providers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
