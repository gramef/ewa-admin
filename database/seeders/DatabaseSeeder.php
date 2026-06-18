<?php
/*
 * File name: DatabaseSeeder.php
 * Last modified: 2021.09.16 at 12:29:38
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // --- Essential reference / system data (safe to seed in every environment) ---
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);

        $this->call(CustomFieldsTableSeeder::class);
        $this->call(CustomFieldValuesTableSeeder::class);
        $this->call(AppSettingsTableSeeder::class);
        $this->call(EProviderTypesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(FaqCategoriesTableSeeder::class);
        $this->call(BookingStatusesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(OptionGroupsTableSeeder::class);

        $this->call(CustomPagesTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(PaymentStatusesTableSeeder::class);
        $this->call(TaxesTableSeeder::class);
        $this->call(FaqsTableSeeder::class);

        // --- Demo / sample data (vendors, services, reviews, bookings, etc.) ---
        // NEVER seed demo data into production. This is what put the "Knotless/Box
        // Braids" demo services and fake reviews onto live vendor accounts.
        // Opt in explicitly with SEED_DEMO_DATA=true (local/staging only).
        $seedDemo = filter_var(env('SEED_DEMO_DATA', false), FILTER_VALIDATE_BOOLEAN);
        if (app()->environment('production') && !$seedDemo) {
            $this->command->warn('Skipping demo data seeders in production. Set SEED_DEMO_DATA=true to override.');
            return;
        }
        if (!$seedDemo) {
            $this->command->warn('Demo data seeders skipped. Set SEED_DEMO_DATA=true to seed sample vendors/services/reviews.');
            return;
        }

        $this->call(EProvidersTableSeeder::class);
        $this->call(EServicesTableSeeder::class);
        $this->call(GalleriesTableSeeder::class);
        $this->call(EServiceReviewsTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(BookingsTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
        $this->call(AwardsTableSeeder::class);
        $this->call(AvailabilityHoursTableSeeder::class);
        $this->call(ExperiencesTableSeeder::class);

        $this->call(MediaTableSeeder::class);
        $this->call(UploadsTableSeeder::class);
        $this->call(EarningsTableSeeder::class);
        $this->call(EProvidersPayoutsTableSeeder::class);
        $this->call(EProviderAddressesTableSeeder::class);
        $this->call(EServiceCategoriesTableSeeder::class);
        $this->call(SlidesTableSeeder::class);
        $this->call(WalletsTableSeeder::class);
        $this->call(WalletTransactionsTableSeeder::class);

    }
}
