<?php
/*
 * File name: EProviderTypesTableSeeder.php
 * Last modified: 2021.03.02 at 14:35:42
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class EProviderTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('e_provider_types')->delete();

        DB::table('e_provider_types')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'Hair Salon',
                    'commission' => 80.0,
                    'disabled' => 0,
                    'created_at' => '2024-01-01 00:00:00',
                    'updated_at' => '2024-01-01 00:00:00',
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'Mobile Stylist',
                    'commission' => 75.0,
                    'disabled' => 0,
                    'created_at' => '2024-01-01 00:00:00',
                    'updated_at' => '2024-01-01 00:00:00',
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => 'Home-Based Stylist',
                    'commission' => 70.0,
                    'disabled' => 0,
                    'created_at' => '2024-01-01 00:00:00',
                    'updated_at' => '2024-01-01 00:00:00',
                ),
            3 =>
                array(
                    'id' => 4,
                    'name' => 'Barbershop',
                    'commission' => 80.0,
                    'disabled' => 0,
                    'created_at' => '2024-01-01 00:00:00',
                    'updated_at' => '2024-01-01 00:00:00',
                ),
        ));


    }
}
