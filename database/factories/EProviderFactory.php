<?php
/*
 * File name: EProviderFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\EProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class EProviderFactory
 * @package Database\Factories
 */
class EProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                    'Gardner Construction', 'Concrete', 'Masonry', 'House', 'Care Services', 'Security',
                    'Dentists', 'Epoxy Coating', 'Glass', 'Painting', 'Roofing', 'Sewer Cleaning', 'Architect'
                ]) . " " . $this->faker->company,
            'description' => $this->faker->text,
            'e_provider_type_id' => $this->faker->numberBetween(2, 3),
            'phone_number' => $this->faker->phoneNumber,
            'mobile_number' => $this->faker->phoneNumber,
            'availability_range' => $this->faker->randomFloat(2, 6000, 15000),
            'available' => $this->faker->boolean(95),
            'featured' => $this->faker->boolean(40),
            'accepted' => $this->faker->boolean(95),
        ];
    }
}
