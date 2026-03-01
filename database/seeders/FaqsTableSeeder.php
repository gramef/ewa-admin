<?php
/*
 * File name: FaqsTableSeeder.php
 * Last modified: 2021.03.01 at 21:56:10
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */


namespace Database\Seeders;
use App\Models\Faq;

use DB;
use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('faqs')->delete();
        Faq::factory()->count(30)->create();
    }
}
