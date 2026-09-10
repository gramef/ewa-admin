<?php
/*
 * File name: CustomPagesTableSeeder.php
 * Last modified: 2021.03.02 at 14:35:42
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class CustomPagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('custom_pages')->delete();

        DB::table('custom_pages')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title' => json_encode(['en' => 'Privacy Policy']),
                    'content' => json_encode(['en' => '<h1>EWA Privacy Policy & Data Retention Policy</h1><p>EWA is committed to protecting your personal data under the UK GDPR and Data Protection Act 2018. For our complete Data Retention and Account Deletion Policy, please visit <a href="https://ewaofficialapp.com/data-deletion.html">ewaofficialapp.com/data-deletion.html</a> or review the legal menu in your profile.</p><h2>Data Retention Schedule</h2><p>Account data is retained for the active lifetime of your account. Financial and transaction records are retained for 6 years in accordance with UK HMRC statutory accounting rules (Section 12B Taxes Management Act 1970). In-app chat messages are retained for 12 months for dispute resolution.</p><h2>Account & Data Deletion</h2><p>You may permanently delete your account at any time in the app under Profile → Delete Account, or by emailing support@ewaofficialapp.com.</p>']),
                    'published' => 1,
                    'created_at' => '2021-02-24 11:53:21',
                    'updated_at' => now(),
                ),
            1 =>
                array(
                    'id' => 2,
                    'title' => json_encode(['en' => 'Terms & Conditions']),
                    'content' => json_encode(['en' => '<h1>EWA Platform Terms & Conditions</h1><p>These Terms & Conditions constitute a legally binding agreement governing the EWA platform. For full terms, visit <a href="https://ewaofficialapp.com/terms.html">ewaofficialapp.com/terms.html</a>.</p><h2>EWA Vendor Terms of Service</h2><p>Vendors operate on EWA as independent contractors with full schedule and pricing autonomy. All vendors must complete identity verification (KYC) and hold legal right to work in the UK. Stylists must strictly adhere to tool sanitization, safety standards, and manufacturer patch tests (24-48 hrs prior). EWA provides a 30-day free trial upon approval with 0% platform commission on qualifying tiers. Offline cash bookings or platform circumvention are strictly prohibited.</p>']),
                    'published' => 1,
                    'created_at' => '2021-02-24 13:20:06',
                    'updated_at' => now(),
                ),
        ));


    }
}
