<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddKycPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'admin.kyc.index',
            'admin.kyc.show',
            'admin.kyc.document',
            'admin.kyc.approve',
            'admin.kyc.reject',
            'admin.kyc.requestDocuments',
        ];

        // Find or fallback to Admin role (id=2)
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

            // Assign to admin role if not already assigned
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions = [
            'admin.kyc.index',
            'admin.kyc.show',
            'admin.kyc.document',
            'admin.kyc.approve',
            'admin.kyc.reject',
            'admin.kyc.requestDocuments',
        ];

        $permIds = DB::table('permissions')->whereIn('name', $permissions)->pluck('id');

        DB::table('role_has_permissions')->whereIn('permission_id', $permIds)->delete();
        DB::table('permissions')->whereIn('name', $permissions)->delete();
    }
}
