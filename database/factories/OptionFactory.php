<?php
/**
 * File name: OptionFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\EService;
use App\Models\Option;
use App\Models\OptionGroup;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class OptionFactory
 * @package Database\Factories
 */
class OptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Option::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['10m²', '20m', '30m²', '40m']),
            'description' => $this->faker->sentence(4),
            'price' => $this->faker->randomFloat(2, 10, 50),
            'e_service_id' => EService::all()->random()->id,
            'option_group_id' => OptionGroup::all()->random()->id,
        ];
    }
}
