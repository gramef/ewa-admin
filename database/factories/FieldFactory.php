<?php
/**
 * File name: FieldFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\Field;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class FieldFactory
 * @package Database\Factories
 */
class FieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Field::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = ['Grocery', 'Pharmacy', 'Restaurant', 'Store', 'Electronics', 'Furniture'];
        return [
            'name' => $this->faker->randomElement($names),
            'description' => $this->faker->sentences(5, true),
        ];
    }
}
