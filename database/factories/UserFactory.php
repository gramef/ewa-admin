<?php
/**
 * File name: UserFactory.php
 * Last modified: 2024.04.11 at 15:35:22
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class UserFactory
 * @package Database\Factories
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Default password hashing
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user should be in a registered state.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function registered(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->name,
                'password' => bcrypt('123456'), // Default password for registration
            ];
        });
    }

    /**
     * Indicate that the user should be in a logged in state.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function loggedIn(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'password' => bcrypt('123456'), // Default password for login
            ];
        });
    }
}
