<?php
/**
 * File name: PaymentMethodFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\PaymentMethod;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class PaymentMethodFactory
 * @package Database\Factories
 */
class PaymentMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(48),
            'description' => $this->faker->sentence(5),
            'route' => $this->faker->randomElement(['/PayPal', '/RazorPay', '/CashOnDelivery', '/Strip']),
            'order' => $this->faker->numberBetween(1, 10),
            'default' => $this->faker->boolean(),
            'enabled' => $this->faker->boolean(),
        ];
    }

    /**
     * Define a state for 'name_more_127_char'.
     *
     * @return array<string, mixed>
     */
    public function name_more_127_char(): array
    {
        return [
            'name' => $this->faker->paragraph(20),
        ];
    }

    /**
     * Define a state for 'description_more_127_char'.
     *
     * @return array<string, mixed>
     */
    public function description_more_127_char(): array
    {
        return [
            'description' => $this->faker->paragraph(20),
        ];
    }

    /**
     * Define a state for 'route_more_127_char'.
     *
     * @return array<string, mixed>
     */
    public function route_more_127_char(): array
    {
        return [
            'route' => $this->faker->paragraph(20),
        ];
    }

    /**
     * Define a state for 'order_negative'.
     *
     * @return array<string, mixed>
     */
    public function order_negative(): array
    {
        return [
            'order' => -1,
        ];
    }
}
