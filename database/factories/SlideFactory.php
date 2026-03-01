<?php
/**
 * File name: SlideFactory.php
 * Last modified: 2024.04.11 at 15:30:12
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\EProvider;
use App\Models\EService;
use App\Models\Slide;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class SlideFactory
 * @package Database\Factories
 */
class SlideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Slide::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eService = $this->faker->boolean;
        return [
            'order' => $this->faker->numberBetween(0, 5),
            'text' => $this->faker->sentence(4),
            'button' => $this->faker->randomElement(['Discover It', 'Book Now', 'Get Discount']),
            'text_position' => $this->faker->randomElement(['start', 'end', 'center']),
            'text_color' => '#25d366',
            'button_color' => '#25d366',
            'background_color' => '#ccccdd',
            'indicator_color' => '#25d366',
            'image_fit' => 'cover',
            'e_service_id' => $eService ? EService::all()->random()->id : null,
            'e_provider_id' => !$eService ? EProvider::all()->random()->id : null,
            'enabled' => $this->faker->boolean,
        ];
    }
}
