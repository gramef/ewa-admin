<?php
/*
 * File name: EProviderUserFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\EProvider;
use App\Models\EProviderUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class EProviderUserFactory
 * @package Database\Factories
 */
class EProviderUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EProviderUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement([2, 4, 6]),
            'e_provider_id' => EProvider::all()->random()->id
        ];
    }
}
