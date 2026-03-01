<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class E2ETestSeeder extends Seeder
{
    /**
     * Comprehensive E2E Test Data Seeder
     * Creates all necessary data for end-to-end testing of the EWA Hair App
     */
    public function run()
    {
        $this->command->info('🚀 Starting E2E Test Data Seeding...');

        // 1. Create Test Users
        $this->seedUsers();

        // 2. Create Categories
        $this->seedCategories();

        // 3. Create Provider Types
        $this->seedProviderTypes();

        // 4. Create Providers (Salons/Stylists)
        $this->seedProviders();

        // 5. Create Services
        $this->seedServices();

        // 6. Create Stories
        $this->seedStories();

        // 7. Create Style Quiz
        $this->seedStyleQuiz();

        // 8. Create Sample Bookings
        $this->seedBookings();

        $this->command->info('✅ E2E Test Data Seeding Complete!');
    }

    private function seedUsers()
    {
        $this->command->info('Creating test users...');

        $users = [
            [
                'id' => 100,
                'name' => 'Test Customer',
                'email' => 'test@test.com',
                'password' => Hash::make('password123'),
                'phone_number' => '+1234567890',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 101,
                'name' => 'Keisha Williams',
                'email' => 'stylist@test.com',
                'password' => Hash::make('password123'),
                'phone_number' => '+1234567891',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 102,
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => Hash::make('password123'),
                'phone_number' => '+1234567892',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(['id' => $user['id']], $user);
        }

        // Assign roles
        DB::table('model_has_roles')->updateOrInsert(
            ['role_id' => 3, 'model_type' => 'App\\Models\\User', 'model_id' => 100],
            ['role_id' => 3, 'model_type' => 'App\\Models\\User', 'model_id' => 100]
        );
        DB::table('model_has_roles')->updateOrInsert(
            ['role_id' => 4, 'model_type' => 'App\\Models\\User', 'model_id' => 101],
            ['role_id' => 4, 'model_type' => 'App\\Models\\User', 'model_id' => 101]
        );
        DB::table('model_has_roles')->updateOrInsert(
            ['role_id' => 1, 'model_type' => 'App\\Models\\User', 'model_id' => 102],
            ['role_id' => 1, 'model_type' => 'App\\Models\\User', 'model_id' => 102]
        );
    }

    private function seedCategories()
    {
        $this->command->info('Creating categories...');

        $categories = [
            ['id' => 10, 'name' => 'Braids', 'color' => '#E94560', 'order' => 1, 'featured' => true],
            ['id' => 11, 'name' => 'Locs', 'color' => '#9B59B6', 'order' => 2, 'featured' => true],
            ['id' => 12, 'name' => 'Weaves & Extensions', 'color' => '#3498DB', 'order' => 3, 'featured' => true],
            ['id' => 13, 'name' => 'Natural Hair', 'color' => '#27AE60', 'order' => 4, 'featured' => true],
            ['id' => 14, 'name' => 'Twists', 'color' => '#F39C12', 'order' => 5, 'featured' => false],
            ['id' => 15, 'name' => 'Cornrows', 'color' => '#1ABC9C', 'order' => 6, 'featured' => false],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['id' => $category['id']],
                array_merge($category, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    private function seedProviderTypes()
    {
        $this->command->info('Creating provider types...');

        $types = [
            ['id' => 10, 'name' => 'Premium Salon', 'commission' => 15, 'disabled' => false],
            ['id' => 11, 'name' => 'Independent Stylist', 'commission' => 10, 'disabled' => false],
            ['id' => 12, 'name' => 'Home Stylist', 'commission' => 5, 'disabled' => false],
        ];

        foreach ($types as $type) {
            DB::table('e_provider_types')->updateOrInsert(
                ['id' => $type['id']],
                array_merge($type, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    private function seedProviders()
    {
        $this->command->info('Creating providers...');

        $baseUrl = env('APP_URL', 'http://127.0.0.1:8000');

        $providers = [
            [
                'id' => 10,
                'name' => 'Crown & Glory Braiding Studio',
                'e_provider_type_id' => 10,
                'description' => 'Premier African braiding salon specializing in protective styles. 10+ years experience.',
                'phone_number' => '+1-555-0101',
                'mobile_number' => '+1-555-0102',
                'availability_range' => 25,
                'available' => true,
                'featured' => true,
                'accepted' => true,
                'latitude' => 40.7128,
                'longitude' => -74.0060,
            ],
            [
                'id' => 11,
                'name' => 'Natural Roots Hair Care',
                'e_provider_type_id' => 10,
                'description' => 'Specializing in natural hair care, locs, and healthy hair journeys.',
                'phone_number' => '+1-555-0201',
                'mobile_number' => '+1-555-0202',
                'availability_range' => 30,
                'available' => true,
                'featured' => true,
                'accepted' => true,
                'latitude' => 40.7580,
                'longitude' => -73.9855,
            ],
            [
                'id' => 12,
                'name' => 'Keisha\'s Mobile Styling',
                'e_provider_type_id' => 12,
                'description' => 'Convenient mobile hair styling. I come to you! Braids, twists, and more.',
                'phone_number' => '+1-555-0301',
                'mobile_number' => '+1-555-0302',
                'availability_range' => 50,
                'available' => true,
                'featured' => false,
                'accepted' => true,
                'latitude' => 40.6892,
                'longitude' => -74.0445,
            ],
        ];

        foreach ($providers as $provider) {
            DB::table('e_providers')->updateOrInsert(
                ['id' => $provider['id']],
                array_merge($provider, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // Link providers to users
        DB::table('e_provider_users')->updateOrInsert(
            ['user_id' => 101, 'e_provider_id' => 12],
            ['user_id' => 101, 'e_provider_id' => 12]
        );
    }

    private function seedServices()
    {
        $this->command->info('Creating services...');

        $baseUrl = env('APP_URL', 'http://127.0.0.1:8000');

        $services = [
            // Braiding Services
            [
                'id' => 100,
                'name' => 'Box Braids - Medium',
                'price' => 150.00,
                'discount_price' => 135.00,
                'price_unit' => 'fixed',
                'duration' => '4-6 hours',
                'description' => 'Classic medium-sized box braids. Includes hair consultation and styling.',
                'featured' => true,
                'e_provider_id' => 10,
            ],
            [
                'id' => 101,
                'name' => 'Knotless Braids',
                'price' => 200.00,
                'discount_price' => null,
                'price_unit' => 'fixed',
                'duration' => '5-7 hours',
                'description' => 'Tension-free knotless braids for a natural look and comfortable wear.',
                'featured' => true,
                'e_provider_id' => 10,
            ],
            [
                'id' => 102,
                'name' => 'Cornrows - Full Head',
                'price' => 80.00,
                'discount_price' => 70.00,
                'price_unit' => 'fixed',
                'duration' => '2-3 hours',
                'description' => 'Traditional straight-back cornrows or custom patterns.',
                'featured' => false,
                'e_provider_id' => 10,
            ],
            // Locs Services
            [
                'id' => 103,
                'name' => 'Loc Maintenance',
                'price' => 75.00,
                'discount_price' => null,
                'price_unit' => 'fixed',
                'duration' => '2-3 hours',
                'description' => 'Retwist, palm roll, and style your existing locs.',
                'featured' => true,
                'e_provider_id' => 11,
            ],
            [
                'id' => 104,
                'name' => 'Loc Installation',
                'price' => 300.00,
                'discount_price' => 275.00,
                'price_unit' => 'fixed',
                'duration' => '6-8 hours',
                'description' => 'Start your loc journey with professional installation.',
                'featured' => true,
                'e_provider_id' => 11,
            ],
            // Natural Hair Services
            [
                'id' => 105,
                'name' => 'Twist Out',
                'price' => 65.00,
                'discount_price' => null,
                'price_unit' => 'fixed',
                'duration' => '1-2 hours',
                'description' => 'Beautiful defined curls with two-strand twist technique.',
                'featured' => false,
                'e_provider_id' => 11,
            ],
            [
                'id' => 106,
                'name' => 'Wash & Style',
                'price' => 55.00,
                'discount_price' => null,
                'price_unit' => 'fixed',
                'duration' => '1-2 hours',
                'description' => 'Deep cleanse, condition, and style for natural hair.',
                'featured' => false,
                'e_provider_id' => 11,
            ],
            // Mobile Stylist Services
            [
                'id' => 107,
                'name' => 'Passion Twists',
                'price' => 180.00,
                'discount_price' => 160.00,
                'price_unit' => 'fixed',
                'duration' => '4-5 hours',
                'description' => 'Trendy passion twists with bohemian curly ends. Mobile service available!',
                'featured' => true,
                'e_provider_id' => 12,
            ],
            [
                'id' => 108,
                'name' => 'Sew-In Weave',
                'price' => 175.00,
                'discount_price' => null,
                'price_unit' => 'fixed',
                'duration' => '3-4 hours',
                'description' => 'Full sew-in weave installation. Hair not included.',
                'featured' => true,
                'e_provider_id' => 12,
            ],
            [
                'id' => 109,
                'name' => 'Frontal Install',
                'price' => 250.00,
                'discount_price' => 225.00,
                'price_unit' => 'fixed',
                'duration' => '2-3 hours',
                'description' => 'Lace frontal wig installation with custom styling.',
                'featured' => true,
                'e_provider_id' => 12,
            ],
        ];

        foreach ($services as $service) {
            DB::table('e_services')->updateOrInsert(
                ['id' => $service['id']],
                array_merge($service, [
                    'enable_booking' => true,
                    'available' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }

        // Link services to categories
        $categoryLinks = [
            ['e_service_id' => 100, 'category_id' => 10], // Box Braids -> Braids
            ['e_service_id' => 101, 'category_id' => 10], // Knotless -> Braids
            ['e_service_id' => 102, 'category_id' => 15], // Cornrows -> Cornrows
            ['e_service_id' => 103, 'category_id' => 11], // Loc Maintenance -> Locs
            ['e_service_id' => 104, 'category_id' => 11], // Loc Install -> Locs
            ['e_service_id' => 105, 'category_id' => 13], // Twist Out -> Natural
            ['e_service_id' => 106, 'category_id' => 13], // Wash & Style -> Natural
            ['e_service_id' => 107, 'category_id' => 14], // Passion Twists -> Twists
            ['e_service_id' => 108, 'category_id' => 12], // Sew-In -> Weaves
            ['e_service_id' => 109, 'category_id' => 12], // Frontal -> Weaves
        ];

        foreach ($categoryLinks as $link) {
            DB::table('e_service_categories')->updateOrInsert($link, $link);
        }
    }

    private function seedStories()
    {
        $this->command->info('Creating stories...');

        $baseUrl = env('APP_URL', 'http://127.0.0.1:8000');

        $stories = [
            [
                'id' => 10,
                'e_provider_id' => 10,
                'media_url' => $baseUrl . '/storage/services/braids.png',
                'media_type' => 'image',
                'expires_at' => Carbon::now()->addDays(1),
                'views_count' => 45,
            ],
            [
                'id' => 11,
                'e_provider_id' => 11,
                'media_url' => $baseUrl . '/storage/services/locs.png',
                'media_type' => 'image',
                'expires_at' => Carbon::now()->addDays(1),
                'views_count' => 32,
            ],
            [
                'id' => 12,
                'e_provider_id' => 12,
                'media_url' => $baseUrl . '/storage/services/twists.png',
                'media_type' => 'image',
                'expires_at' => Carbon::now()->addDays(1),
                'views_count' => 28,
            ],
        ];

        foreach ($stories as $story) {
            DB::table('stories')->updateOrInsert(
                ['id' => $story['id']],
                array_merge($story, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    private function seedStyleQuiz()
    {
        $this->command->info('Creating style quiz...');

        $questions = [
            [
                'id' => 10,
                'question' => 'How much time do you want to spend on daily hair maintenance?',
                'order' => 1,
            ],
            [
                'id' => 11,
                'question' => 'What is your hair texture?',
                'order' => 2,
            ],
            [
                'id' => 12,
                'question' => 'How long do you want your protective style to last?',
                'order' => 3,
            ],
            [
                'id' => 13,
                'question' => 'What is your budget range?',
                'order' => 4,
            ],
        ];

        foreach ($questions as $q) {
            DB::table('style_quiz_questions')->updateOrInsert(
                ['id' => $q['id']],
                array_merge($q, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        $options = [
            // Question 1 options
            ['id' => 100, 'question_id' => 10, 'option_text' => 'Less than 10 minutes', 'recommendation_tags' => 'low-maintenance,locs,braids'],
            ['id' => 101, 'question_id' => 10, 'option_text' => '10-30 minutes', 'recommendation_tags' => 'twists,natural'],
            ['id' => 102, 'question_id' => 10, 'option_text' => '30+ minutes', 'recommendation_tags' => 'weaves,natural,styling'],
            // Question 2 options
            ['id' => 103, 'question_id' => 11, 'option_text' => 'Type 3 (Curly)', 'recommendation_tags' => 'curly,twist-out,wash-go'],
            ['id' => 104, 'question_id' => 11, 'option_text' => 'Type 4 (Coily)', 'recommendation_tags' => 'protective,braids,locs,twists'],
            ['id' => 105, 'question_id' => 11, 'option_text' => 'Relaxed/Straight', 'recommendation_tags' => 'weaves,extensions,silk-press'],
            // Question 3 options
            ['id' => 106, 'question_id' => 12, 'option_text' => '1-2 weeks', 'recommendation_tags' => 'twist-out,wash-style,temporary'],
            ['id' => 107, 'question_id' => 12, 'option_text' => '4-6 weeks', 'recommendation_tags' => 'braids,twists,cornrows'],
            ['id' => 108, 'question_id' => 12, 'option_text' => '2+ months', 'recommendation_tags' => 'locs,long-term'],
            // Question 4 options
            ['id' => 109, 'question_id' => 13, 'option_text' => 'Under $100', 'recommendation_tags' => 'budget,cornrows,twist-out'],
            ['id' => 110, 'question_id' => 13, 'option_text' => '$100 - $200', 'recommendation_tags' => 'mid-range,braids,twists'],
            ['id' => 111, 'question_id' => 13, 'option_text' => '$200+', 'recommendation_tags' => 'premium,locs,knotless,weaves'],
        ];

        foreach ($options as $opt) {
            DB::table('style_quiz_options')->updateOrInsert(
                ['id' => $opt['id']],
                array_merge($opt, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    private function seedBookings()
    {
        $this->command->info('Creating sample bookings...');

        // Get or create booking statuses
        $statuses = DB::table('booking_statuses')->pluck('id', 'status')->toArray();

        $bookings = [
            [
                'id' => 100,
                'e_service_id' => 100, // Box Braids
                'e_provider_id' => 10,
                'user_id' => 100, // Test Customer
                'booking_status_id' => $statuses['Received'] ?? 1,
                'quantity' => 1,
                'booking_at' => Carbon::now()->addDays(2)->setTime(10, 0),
                'start_at' => Carbon::now()->addDays(2)->setTime(10, 0),
                'ends_at' => Carbon::now()->addDays(2)->setTime(16, 0),
            ],
            [
                'id' => 101,
                'e_service_id' => 107, // Passion Twists
                'e_provider_id' => 12,
                'user_id' => 100,
                'booking_status_id' => $statuses['Accepted'] ?? 2,
                'quantity' => 1,
                'booking_at' => Carbon::now()->addDays(5)->setTime(14, 0),
                'start_at' => Carbon::now()->addDays(5)->setTime(14, 0),
                'ends_at' => Carbon::now()->addDays(5)->setTime(19, 0),
            ],
            [
                'id' => 102,
                'e_service_id' => 103, // Loc Maintenance
                'e_provider_id' => 11,
                'user_id' => 100,
                'booking_status_id' => $statuses['Done'] ?? 5,
                'quantity' => 1,
                'booking_at' => Carbon::now()->subDays(3)->setTime(11, 0),
                'start_at' => Carbon::now()->subDays(3)->setTime(11, 0),
                'ends_at' => Carbon::now()->subDays(3)->setTime(14, 0),
            ],
        ];

        foreach ($bookings as $booking) {
            DB::table('bookings')->updateOrInsert(
                ['id' => $booking['id']],
                array_merge($booking, [
                    'cancel' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
    }
}
