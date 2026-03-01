<?php
/*
 * File name: EServicesTableSeeder.php
 * Last modified: 2021.03.01 at 21:22:30
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */


namespace Database\Seeders;
use App\Models\EService;
use DB;
use Illuminate\Database\Seeder;

class EServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('e_services')->delete();
        EService::factory()->count(40)->create();
    }
}
