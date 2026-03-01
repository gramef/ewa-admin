<?php
/*
 * File name: AvailabilityHourFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\AvailabilityHour;
use App\Models\EProvider;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class AvailabilityHourFactory
 * @package Database\Factories
 */
class AvailabilityHourFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AvailabilityHour::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day' => Str::lower($this->faker->randomElement(Carbon::getDays())),
            'start_at' => str_pad($this->faker->numberBetween(2, 12), 2, '0', STR_PAD_LEFT) . ":00",
            'end_at' => $this->faker->numberBetween(13, 23) . ":00",
            'data' => $this->faker->text(50),
            'e_provider_id' => EProvider::all()->random()->id
        ];
    }

    /**
     * Define a state with a day more than 16 characters.
     *
     * @return Factory
     */
    public function day_more_16_char(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'day' => $this->faker->paragraph(3),
            ];
        });
    }

    /**
     * Define a state where the end time is less than the start time.
     *
     * @return Factory
     */
    public function end_at_lest_start_at(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => $this->faker->numberBetween(16, 21) . ":20",
                'end_at' => $this->faker->numberBetween(10, 13) . ":30",
            ];
        });
    }

    /**
     * Define a state with a non-existent e_provider_id.
     *
     * @return Factory
     */
    public function not_exist_e_provider_id(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'e_provider_id' => 500000, // non-existent id
            ];
        });
    }
}
