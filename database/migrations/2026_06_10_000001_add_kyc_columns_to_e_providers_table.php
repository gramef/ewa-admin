<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the KYC / right-to-work columns to e_providers.
 *
 * These columns were previously added by a hand-run SQL script
 * (fix_kyc_migration.sh) directly on the production server, which meant any
 * fresh deploy or local environment was missing them — causing a 500 / SQL
 * "unknown column" error on POST /api/kyc/submit. This migration makes the
 * schema reproducible via `php artisan migrate`. Each column is guarded so it
 * is safe to run on the production DB where the columns may already exist.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('e_providers', function (Blueprint $table) {
            if (!Schema::hasColumn('e_providers', 'kyc_status')) {
                $table->string('kyc_status', 20)->default('not_submitted')->after('accepted');
            }
            if (!Schema::hasColumn('e_providers', 'kyc_id_type')) {
                $table->string('kyc_id_type', 50)->nullable()->after('kyc_status');
            }
            if (!Schema::hasColumn('e_providers', 'kyc_id_document')) {
                $table->string('kyc_id_document', 500)->nullable()->after('kyc_id_type');
            }
            if (!Schema::hasColumn('e_providers', 'kyc_rtw_document')) {
                $table->string('kyc_rtw_document', 500)->nullable()->after('kyc_id_document');
            }
            if (!Schema::hasColumn('e_providers', 'kyc_rejection_reason')) {
                $table->text('kyc_rejection_reason')->nullable()->after('kyc_rtw_document');
            }
            if (!Schema::hasColumn('e_providers', 'kyc_submitted_at')) {
                $table->timestamp('kyc_submitted_at')->nullable()->after('kyc_rejection_reason');
            }
            if (!Schema::hasColumn('e_providers', 'kyc_reviewed_at')) {
                $table->timestamp('kyc_reviewed_at')->nullable()->after('kyc_submitted_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('e_providers', function (Blueprint $table) {
            foreach ([
                'kyc_status',
                'kyc_id_type',
                'kyc_id_document',
                'kyc_rtw_document',
                'kyc_rejection_reason',
                'kyc_submitted_at',
                'kyc_reviewed_at',
            ] as $column) {
                if (Schema::hasColumn('e_providers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
