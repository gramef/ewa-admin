<?php
/*
 * File name: OptionsTableSeeder.php
 * Last modified: 2021.03.01 at 21:57:23
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */


namespace Database\Seeders;
use App\Models\Option;
use DB;
use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->delete();
        Option::factory()->count(100)->create();
    }
}
