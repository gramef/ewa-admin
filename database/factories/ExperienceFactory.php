<?php
/*
 * File name: ExperienceFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\EProvider;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ExperienceFactory
 * @package Database\Factories
 */
class ExperienceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Experience::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(127),
            'description' => $this->faker->realText(),
            'e_provider_id' => EProvider::all()->random()->id
        ];
    }

    /**
     * State for title more than 127 characters.
     *
     * @return Factory
     */
    public function title_more_127_char(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => $this->faker->paragraph(20),
            ];
        });
    }

    /**
     * State for non-existent e_provider_id.
     *
     * @return Factory
     */
    public function not_exist_e_provider_id(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'e_provider_id' => 500000, // not exist id
            ];
        });
    }
}
