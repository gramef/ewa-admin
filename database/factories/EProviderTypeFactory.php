<?php
/*
 * File name: EProviderTypeFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\EProviderType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class EProviderTypeFactory
 * @package Database\Factories
 */
class EProviderTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EProviderType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(48),
            'commission' => $this->faker->randomFloat(2, 5, 50),
            'disabled' => $this->faker->boolean(),
        ];
    }

    /**
     * Define a state with a name more than 127 characters.
     *
     * @return Factory
     */
    public function name_more_127_char(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->paragraph(20),
            ];
        });
    }

    /**
     * Define a state with a commission more than 100.
     *
     * @return Factory
     */
    public function commission_more_100(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'commission' => 101,
            ];
        });
    }

    /**
     * Define a state with a commission less than 0.
     *
     * @return Factory
     */
    public function commission_less_0(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'commission' => -1,
            ];
        });
    }
}
