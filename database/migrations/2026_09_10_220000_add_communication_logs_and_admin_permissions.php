<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permissions = [
            'admin.communication-logs.index',
            'admin.communication-logs.show',
            'admin.platform-health.index',
            'admin.notifications.index',
            'admin.push.create',
            'admin.push.send',
            'admin.kyc.index',
            'admin.kyc.show',
            'admin.kyc.document',
            'admin.kyc.approve',
            'admin.kyc.reject',
            'admin.kyc.requestDocuments',
            'referralPackages.index',
            'referralPackages.create',
            'referralPackages.store',
            'referralPackages.show',
            'referralPackages.edit',
            'referralPackages.update',
            'referralPackages.destroy',
            'referralPackages.toggle',
        ];

        // Find Admin role (default id 2)
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id') ?? 2;

        foreach ($permissions as $permName) {
            $existing = DB::table('permissions')->where('name', $permName)->first();

            if (!$existing) {
                $permId = DB::table('permissions')->insertGetId([
                    'name' => $permName,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $permId = $existing->id;
            }

            $assigned = DB::table('role_has_permissions')
                ->where('permission_id', $permId)
                ->where('role_id', $adminRoleId)
                ->exists();

            if (!$assigned) {
                DB::table('role_has_permissions')->insert([
                    'permission_id' => $permId,
                    'role_id' => $adminRoleId,
                ]);
            }
        }

        // Clear Spatie permission cache
        try {
            app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
        } catch (\Throwable $e) {
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissions = [
            'admin.communication-logs.index',
            'admin.communication-logs.show',
            'referralPackages.index',
            'referralPackages.create',
            'referralPackages.store',
            'referralPackages.show',
            'referralPackages.edit',
            'referralPackages.update',
            'referralPackages.destroy',
            'referralPackages.toggle',
        ];

        $permIds = DB::table('permissions')->whereIn('name', $permissions)->pluck('id');
        DB::table('role_has_permissions')->whereIn('permission_id', $permIds)->delete();
        DB::table('permissions')->whereIn('id', $permIds)->delete();

        try {
            app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
        } catch (\Throwable $e) {
        }
    }
};
