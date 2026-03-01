<?php
/*
 * File name: FaqCategoriesTableSeeder.php
 * Last modified: 2021.03.01 at 21:56:10
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */


namespace Database\Seeders;
use App\Models\FaqCategory;
use DB;
use Illuminate\Database\Seeder;

class FaqCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('faq_categories')->delete();
        FaqCategory::factory()->count(5)->create();
    }
}
