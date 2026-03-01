<?php
/**
 * File name: FaqFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\Faq;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class FaqFactory
 * @package Database\Factories
 */
class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ensure we select an existing FAQ category ID to avoid foreign key failures on SQLite
        // Use the query builder to avoid static analysis complaints about ::query()
        $categoryId = \Illuminate\Support\Facades\DB::table('faq_categories')->inRandomOrder()->value('id');
        if (!$categoryId) {
            // fallback to 1 if no category exists yet (e.g., when seeding out of order)
            $categoryId = 1;
        }
        return [
            'question' => $this->faker->text(100),
            'answer' => $this->faker->realText(),
            'faq_category_id' => $categoryId,
        ];
    }
}
