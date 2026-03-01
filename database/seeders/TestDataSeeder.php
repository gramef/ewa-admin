<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // Create Style Quiz Questions
        $question1Id = DB::table('style_quiz_questions')->insertGetId([
            'question_text' => 'What is your hair texture?',
            'type' => 'single_choice',
            'order' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $question2Id = DB::table('style_quiz_questions')->insertGetId([
            'question_text' => 'What style are you looking for?',
            'type' => 'single_choice',
            'order' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Create Quiz Options for Question 1
        DB::table('style_quiz_options')->insert([
            [
                'style_quiz_question_id' => $question1Id,
                'option_text' => '4C Kinky',
                'image_url' => null,
                'related_categories' => '1,2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'style_quiz_question_id' => $question1Id,
                'option_text' => '3B/3C Curly',
                'image_url' => null,
                'related_categories' => '2,3',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'style_quiz_question_id' => $question1Id,
                'option_text' => 'Relaxed/Straight',
                'image_url' => null,
                'related_categories' => '4,5',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Create Quiz Options for Question 2
        DB::table('style_quiz_options')->insert([
            [
                'style_quiz_question_id' => $question2Id,
                'option_text' => 'Braids and Twists',
                'image_url' => null,
                'related_categories' => '1,2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'style_quiz_question_id' => $question2Id,
                'option_text' => 'Natural / Afro Styles',
                'image_url' => null,
                'related_categories' => '3,6',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'style_quiz_question_id' => $question2Id,
                'option_text' => 'Weave and Extensions',
                'image_url' => null,
                'related_categories' => '4,5',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Create Sample Stories (assuming e_provider_id 1 exists)
        DB::table('stories')->insert([
            [
                'e_provider_id' => 1,
                'media_url' => 'https://picsum.photos/400/600?random=1',
                'media_type' => 'image',
                'expires_at' => Carbon::now()->addHours(24),
                'views_count' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'e_provider_id' => 1,
                'media_url' => 'https://picsum.photos/400/600?random=2',
                'media_type' => 'image',
                'expires_at' => Carbon::now()->addHours(22),
                'views_count' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $this->command->info('Test data seeded successfully!');
    }
}