<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StyleRideDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            EProviderTypesTableSeeder::class,
            EProvidersTableSeeder::class,
            EServicesTableSeeder::class,
            BookingsTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            SettingsTableSeeder::class,
        ]);
    }
}

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        DB::table('users')->insert([
            'name' => 'StyleRide Admin',
            'email' => 'admin@styleride.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'api_token' => Str::random(60),
            'phone_number' => '+1234567890',
            'phone_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Sample customers
        $customers = [
            ['name' => 'Aisha Johnson', 'email' => 'aisha@email.com', 'phone' => '+1234567891'],
            ['name' => 'Marcus Williams', 'email' => 'marcus@email.com', 'phone' => '+1234567892'],
            ['name' => 'Zoe Thompson', 'email' => 'zoe@email.com', 'phone' => '+1234567893'],
            ['name' => 'Jordan Davis', 'email' => 'jordan@email.com', 'phone' => '+1234567894'],
            ['name' => 'Taylor Brown', 'email' => 'taylor@email.com', 'phone' => '+1234567895'],
        ];

        foreach ($customers as $customer) {
            DB::table('users')->insert([
                'name' => $customer['name'],
                'email' => $customer['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'api_token' => Str::random(60),
                'phone_number' => $customer['phone'],
                'phone_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Sample hair stylists (vendors)
        $stylists = [
            ['name' => 'Keisha Beauty', 'email' => 'keisha@styleride.com', 'phone' => '+1234567801'],
            ['name' => 'Marcus Cuts', 'email' => 'marcus@styleride.com', 'phone' => '+1234567802'],
            ['name' => 'Zara Styles', 'email' => 'zara@styleride.com', 'phone' => '+1234567803'],
            ['name' => 'DJ Braids', 'email' => 'dj@styleride.com', 'phone' => '+1234567804'],
            ['name' => 'Nia Naturals', 'email' => 'nia@styleride.com', 'phone' => '+1234567805'],
        ];

        foreach ($stylists as $stylist) {
            DB::table('users')->insert([
                'name' => $stylist['name'],
                'email' => $stylist['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('stylist123'),
                'api_token' => Str::random(60),
                'phone_number' => $stylist['phone'],
                'phone_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Braids & Twists', 'description' => 'All types of braiding and twisting services', 'color' => '#8B4513', 'order' => 1],
            ['name' => 'Natural Hair Care', 'description' => 'Natural hair treatments and styling', 'color' => '#228B22', 'order' => 2],
            ['name' => 'Locs & Dreads', 'description' => 'Dreadlock maintenance and styling', 'color' => '#4B0082', 'order' => 3],
            ['name' => 'Weaves & Extensions', 'description' => 'Hair extension and weave services', 'color' => '#FF1493', 'order' => 4],
            ['name' => 'Chemical Treatments', 'description' => 'Relaxers, perms, and color treatments', 'color' => '#FF6347', 'order' => 5],
            ['name' => 'Kids Hair Care', 'description' => 'Specialized services for children', 'color' => '#FFB6C1', 'order' => 6],
            ['name' => 'Men\'s Grooming', 'description' => 'Haircuts and grooming for men', 'color' => '#4169E1', 'order' => 7],
            ['name' => 'Special Occasions', 'description' => 'Weddings, proms, and special events', 'color' => '#FFD700', 'order' => 8],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'color' => $category['color'],
                'order' => $category['order'],
                'featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

class EProviderTypesTableSeeder extends Seeder
{
    public function run()
    {
        $providerTypes = [
            ['name' => 'Salon', 'commission' => 10.0, 'disabled' => 0],
            ['name' => 'Freelancer', 'commission' => 15.0, 'disabled' => 0],
            ['name' => 'Barbershop', 'commission' => 8.0, 'disabled' => 0],
            ['name' => 'Mobile Stylist', 'commission' => 12.0, 'disabled' => 0],
        ];
        
        foreach ($providerTypes as $type) {
            DB::table('e_provider_types')->insert([
                'name' => $type['name'],
                'commission' => $type['commission'],
                'disabled' => $type['disabled'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

class EProvidersTableSeeder extends Seeder
{
    public function run()
    {
        $providers = [
            ['name' => 'Keisha Beauty Studio', 'description' => 'Premium natural hair care and braiding', 'phone_number' => '+1234567801', 'mobile_number' => '+1234567801', 'e_provider_type_id' => 1],
            ['name' => 'Marcus Cuts & Styles', 'description' => 'Men\'s grooming and unisex styling', 'phone_number' => '+1234567802', 'mobile_number' => '+1234567802', 'e_provider_type_id' => 3],
            ['name' => 'Zara\'s Braiding Palace', 'description' => 'Expert braiding and weaving services', 'phone_number' => '+1234567803', 'mobile_number' => '+1234567803', 'e_provider_type_id' => 1],
            ['name' => 'DJ\'s Loc Studio', 'description' => 'Dreadlock specialist and natural care', 'phone_number' => '+1234567804', 'mobile_number' => '+1234567804', 'e_provider_type_id' => 2],
            ['name' => 'Nia\'s Natural Haven', 'description' => 'Organic hair care and styling', 'phone_number' => '+1234567805', 'mobile_number' => '+1234567805', 'e_provider_type_id' => 4],
        ];

        foreach ($providers as $provider) {
            DB::table('e_providers')->insert([
                'name' => $provider['name'],
                'description' => $provider['description'],
                'phone_number' => $provider['phone_number'],
                'mobile_number' => $provider['mobile_number'],
                'e_provider_type_id' => $provider['e_provider_type_id'],
                'availability_range' => 25,
                'available' => 1,
                'featured' => 1,
                'accepted' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

class EServicesTableSeeder extends Seeder
{
    public function run()
    {
        $services = [
            // Braids & Twists
            ['name' => 'Box Braids', 'description' => 'Classic box braids, any size', 'duration' => 240, 'price' => 150, 'category_id' => 1],
            ['name' => 'Cornrows', 'description' => 'Straight back or creative patterns', 'duration' => 90, 'price' => 65, 'category_id' => 1],
            ['name' => 'Senegalese Twists', 'description' => 'Two-strand twists with premium hair', 'duration' => 180, 'price' => 180, 'category_id' => 1],
            ['name' => 'Ghana Braids', 'description' => 'Feed-in braids with extensions', 'duration' => 120, 'price' => 95, 'category_id' => 1],
            ['name' => 'Fulani Braids', 'description' => 'Traditional Fulani style with beads', 'duration' => 150, 'price' => 120, 'category_id' => 1],
            
            // Natural Hair Care
            ['name' => 'Wash & Go', 'description' => 'Cleansing, conditioning, and styling', 'duration' => 60, 'price' => 45, 'category_id' => 2],
            ['name' => 'Deep Conditioning', 'description' => 'Intensive moisture treatment', 'duration' => 90, 'price' => 55, 'category_id' => 2],
            ['name' => 'Blowout & Style', 'description' => 'Professional blowout with styling', 'duration' => 75, 'price' => 70, 'category_id' => 2],
            ['name' => 'Twist Out', 'description' => 'Defined twist-out style', 'duration' => 120, 'price' => 85, 'category_id' => 2],
            ['name' => 'Bantu Knots', 'description' => 'Traditional Bantu knot style', 'duration' => 90, 'price' => 75, 'category_id' => 2],
            
            // Locs & Dreads
            ['name' => 'Loc Retwist', 'description' => 'Maintenance and retwisting', 'duration' => 90, 'price' => 65, 'category_id' => 3],
            ['name' => 'Loc Start-up', 'description' => 'New loc installation', 'duration' => 180, 'price' => 150, 'category_id' => 3],
            ['name' => 'Loc Style', 'description' => 'Creative loc styling', 'duration' => 60, 'price' => 40, 'category_id' => 3],
            ['name' => 'Loc Deep Clean', 'description' => 'Thorough cleansing treatment', 'duration' => 120, 'price' => 85, 'category_id' => 3],
            
            // Weaves & Extensions
            ['name' => 'Sew-in Weave', 'description' => 'Full sew-in with closure', 'duration' => 180, 'price' => 200, 'category_id' => 4],
            ['name' => 'Quick Weave', 'description' => 'Glue-in quick weave', 'duration' => 90, 'price' => 95, 'category_id' => 4],
            ['name' => 'Lace Front Install', 'description' => 'Professional lace front application', 'duration' => 120, 'price' => 150, 'category_id' => 4],
            ['name' => 'Weave Maintenance', 'description' => 'Tightening and styling', 'duration' => 60, 'price' => 55, 'category_id' => 4],
            
            // Chemical Treatments
            ['name' => 'Relaxer Touch-up', 'description' => 'New growth relaxer', 'duration' => 90, 'price' => 85, 'category_id' => 5],
            ['name' => 'Color Treatment', 'description' => 'Single process color', 'duration' => 120, 'price' => 95, 'category_id' => 5],
            ['name' => 'Highlights', 'description' => 'Foil highlights', 'duration' => 150, 'price' => 120, 'category_id' => 5],
            ['name' => 'Keratin Treatment', 'description' => 'Smoothing treatment', 'duration' => 180, 'price' => 250, 'category_id' => 5],
            
            // Kids Hair Care
            ['name' => 'Kids Braids', 'description' => 'Age-appropriate braiding', 'duration' => 60, 'price' => 35, 'category_id' => 6],
            ['name' => 'Kids Wash & Style', 'description' => 'Gentle wash and simple style', 'duration' => 45, 'price' => 25, 'category_id' => 6],
            ['name' => 'Kids Cornrows', 'description' => 'Simple cornrow styles', 'duration' => 30, 'price' => 20, 'category_id' => 6],
            
            // Men's Grooming
            ['name' => 'Men\'s Haircut', 'description' => 'Professional men\'s haircut', 'duration' => 30, 'price' => 25, 'category_id' => 7],
            ['name' => 'Beard Trim', 'description' => 'Beard maintenance and shaping', 'duration' => 20, 'price' => 15, 'category_id' => 7],
            ['name' => 'Line-up', 'description' => 'Hairline and beard line-up', 'duration' => 15, 'price' => 12, 'category_id' => 7],
            ['name' => 'Men\'s Braids', 'description' => 'Men\'s cornrows or singles', 'duration' => 45, 'price' => 35, 'category_id' => 7],
            
            // Special Occasions
            ['name' => 'Wedding Updo', 'description' => 'Bridal or special event updo', 'duration' => 120, 'price' => 150, 'category_id' => 8],
            ['name' => 'Prom Style', 'description' => 'Special occasion styling', 'duration' => 90, 'price' => 95, 'category_id' => 8],
            ['name' => 'Photoshoot Styling', 'description' => 'Camera-ready styling', 'duration' => 120, 'price' => 125, 'category_id' => 8],
        ];

        $serviceIds = [];
        foreach ($services as $index => $service) {
            $serviceId = DB::table('e_services')->insertGetId([
                'name' => $service['name'],
                'description' => $service['description'],
                'duration' => $service['duration'],
                'price' => $service['price'],
                'price_unit' => 'fixed',
                'quantity_unit' => 'service',
                'available' => 1,
                'featured' => rand(0, 1),
                'e_provider_id' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Create relationship in pivot table
            DB::table('e_service_categories')->insert([
                'e_service_id' => $serviceId,
                'category_id' => $service['category_id'],
            ]);
        }
    }
}

class BookingsTableSeeder extends Seeder
{
    public function run()
    {
        // Sample bookings for demonstration
        $bookings = [
            ['user_id' => 2, 'e_provider_id' => 1, 'e_service_id' => 1, 'booking_date' => now()->addDays(2), 'duration' => 240, 'price' => 150, 'status' => 'confirmed'],
            ['user_id' => 3, 'e_provider_id' => 2, 'e_service_id' => 16, 'booking_date' => now()->addDays(1), 'duration' => 30, 'price' => 25, 'status' => 'confirmed'],
            ['user_id' => 4, 'e_provider_id' => 3, 'e_service_id' => 4, 'booking_date' => now()->addDays(3), 'duration' => 120, 'price' => 95, 'status' => 'pending'],
        ];

        foreach ($bookings as $booking) {
            DB::table('bookings')->insert([
                'user_id' => $booking['user_id'],
                'e_provider_id' => $booking['e_provider_id'],
                'e_service_id' => $booking['e_service_id'],
                'booking_date' => $booking['booking_date'],
                'duration' => $booking['duration'],
                'price' => $booking['price'],
                'status' => $booking['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

class PaymentMethodsTableSeeder extends Seeder
{
    public function run()
    {
        $methods = [
            ['name' => 'Cash', 'description' => 'Pay with cash', 'route' => 'cash', 'order' => 1, 'default' => 1],
            ['name' => 'Credit Card', 'description' => 'Pay with credit card', 'route' => 'stripe', 'order' => 2, 'default' => 0],
            ['name' => 'PayPal', 'description' => 'Pay with PayPal', 'route' => 'paypal', 'order' => 3, 'default' => 0],
            ['name' => 'Apple Pay', 'description' => 'Pay with Apple Pay', 'route' => 'apple_pay', 'order' => 4, 'default' => 0],
        ];

        foreach ($methods as $method) {
            DB::table('payment_methods')->insert([
                'name' => $method['name'],
                'description' => $method['description'],
                'route' => $method['route'],
                'order' => $method['order'],
                'default' => $method['default'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'app_name', 'value' => 'StyleRide'],
            ['key' => 'app_short_description', 'value' => 'Uber for Hair - Book professional stylists on-demand'],
            ['key' => 'main_color', 'value' => '#FF6B6B'],
            ['key' => 'main_dark_color', 'value' => '#FF5252'],
            ['key' => 'second_color', 'value' => '#4ECDC4'],
            ['key' => 'second_dark_color', 'value' => '#26A69A'],
            ['key' => 'accent_color', 'value' => '#FFE66D'],
            ['key' => 'accent_dark_color', 'value' => '#FFC107'],
            ['key' => 'scaffold_color', 'value' => '#FFFFFF'],
            ['key' => 'scaffold_dark_color', 'value' => '#121212'],
            ['key' => 'default_currency', 'value' => '$'],
            ['key' => 'default_tax', 'value' => '8'],
            ['key' => 'distance_unit', 'value' => 'mi'],
            ['key' => 'enable_stripe', 'value' => '1'],
            ['key' => 'enable_paypal', 'value' => '1'],
            ['key' => 'enable_otp', 'value' => '1'],
            ['key' => 'enable_version', 'value' => '1'],
            ['key' => 'app_version', 'value' => '2.0.0'],
            ['key' => 'modules', 'value' => '["Subscription","Shop","Reviews"]'],
            ['key' => 'default_country_code', 'value' => 'US'],
            ['key' => 'mobile_language', 'value' => 'en'],
            ['key' => 'currency_right', 'value' => '0'],
            ['key' => 'default_currency_decimal_digits', 'value' => '2'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}