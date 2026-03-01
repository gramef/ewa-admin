<?php
/**
 * File name: PaymentStatusFactory.php
 * Last modified: 2024.04.11 at 15:25:40
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\PaymentStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class PaymentStatusFactory
 * @package Database\Factories
 */
class PaymentStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->text(48),
            'order' => $this->faker->numberBetween(1, 10)
        ];
    }

    /**
     * Define a state for 'status_more_127_char'.
     *
     * @return array<string, mixed>
     */
    public function status_more_127_char(): array
    {
        return [
            'status' => $this->faker->paragraph(20),
        ];
    }
}
