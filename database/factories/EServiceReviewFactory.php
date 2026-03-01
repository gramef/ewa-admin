<?php
/*
 * File name: EServiceReviewFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\EService;
use App\Models\EServiceReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class EServiceReviewFactory
 * @package Database\Factories
 */
class EServiceReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EServiceReview::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review' => $this->faker->realText(100),
            'rate' => $this->faker->numberBetween(1, 5),
            'user_id' => User::role('customer')->get()->random()->id,
            'e_service_id' => EService::all()->random()->id,
        ];
    }
}
