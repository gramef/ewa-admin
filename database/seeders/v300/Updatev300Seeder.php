<?php

namespace Database\Seeders\v300;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Updatev300Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(
            array(
                array(
                    'id' => 224,
                    'name' => 'eProviderPayouts.edit',
                    'guard_name' => 'web',
                    'created_at' => '2021-01-30 11:23:08',
                    'updated_at' => '2021-01-30 11:23:08',
                ),
                array(
                    'id' => 225,
                    'name' => 'eProviderPayouts.update',
                    'guard_name' => 'web',
                    'created_at' => '2021-01-30 11:23:08',
                    'updated_at' => '2021-01-30 11:23:08',
                ),
            )

        );

        DB::table('role_has_permissions')->insert(array(
                array(
                    'permission_id' => 225,
                    'role_id' => 3,
                ),
                array(
                    'permission_id' => 225,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 224,
                    'role_id' => 3,
                ),
                array(
                    'permission_id' => 224,
                    'role_id' => 2,
                ),
        )

        );
    }
}
