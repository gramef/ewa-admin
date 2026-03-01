<?php
/*
 * File name: EProviderAddressesTableSeeder.php
 * Last modified: 2021.04.20 at 11:19:32
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */


namespace Database\Seeders;
use App\Models\EProviderAddress;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Seeder;

class EProviderAddressesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
        DB::table('e_provider_addresses')->truncate();
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        try {
            EProviderAddress::factory()->count(10)->create();
        } catch (Exception $e) {
        }
        try {
            EProviderAddress::factory()->count(10)->create();
        } catch (Exception $e) {
        }
        try {
            EProviderAddress::factory()->count(10)->create();
        } catch (Exception $e) {
        }
    }
}
