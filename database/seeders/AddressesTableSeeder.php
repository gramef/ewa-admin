<?php
/*
 * File name: AddressesTableSeeder.php
 * Last modified: 2021.02.01 at 21:46:26
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */


namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
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
        DB::table('addresses')->truncate();
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }


        Address::factory()->count(20)->create();

    }
}
