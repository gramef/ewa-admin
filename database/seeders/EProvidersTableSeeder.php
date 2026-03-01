<?php
/*
 * File name: EProvidersTableSeeder.php
 * Last modified: 2021.03.02 at 11:28:53
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */


namespace Database\Seeders;
use App\Models\EProvider;
use App\Models\EProviderUser;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Seeder;

class EProvidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run(): void
    {


        if (DB::getDriverName() === 'mysql') {
            if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
        }
        DB::table('e_providers')->truncate();
        if (DB::getDriverName() === 'mysql') {
            if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        }

        EProvider::factory()->count(18)->create();
        try {
            EProviderUser::factory()->count(10)->create();
        } catch (Exception $e) {
        }
        try {
            EProviderUser::factory()->count(10)->create();
        } catch (Exception $e) {
        }
        try {
            EProviderUser::factory()->count(10)->create();
        } catch (Exception $e) {
        }

    }
}
