<?php
/*
 * File name: EServiceFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\EProvider;
use App\Models\EService;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class EServiceFactory
 * @package Database\Factories
 */
class EServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            'Natural Hair Wash & Condition',
            'Protective Styling - Box Braids',
            'Silk Press & Flat Iron',
            'Twist Out Styling',
            'Loc Maintenance & Retwist',
            'Cornrow Braiding',
            'Deep Conditioning Treatment',
            'Hair Relaxer Application',
            'Bantu Knot Styling',
            'Wash & Go Styling',
            'Senegalese Twist Installation',
            'Hair Trim & Shape Up',
            'Hot Oil Treatment',
            'Goddess Braids',
            'Flexi Rod Set',
            'Perm Rod Set',
            'Hair Color & Highlights',
            'Keratin Treatment',
            'Weave Installation',
            'Wig Styling & Customization',
            'Scalp Treatment',
            'Bridal Hair Styling',
            'Crochet Braids',
            'Faux Locs Installation'
        ];

        $price = $this->faker->randomFloat(2, 10, 50);
        $discountPrice = $price - $this->faker->randomFloat(2, 1, 10);

        return [
            'name' => $this->faker->randomElement($services),
            'price' => $price,
            'discount_price' => $this->faker->randomElement([$discountPrice, 0]),
            'price_unit' => $this->faker->randomElement(['hourly', 'fixed']),
            'description' => $this->faker->text,
            'duration' => $this->faker->numberBetween(1, 5) . ":00",
            'featured' => $this->faker->boolean,
            'enable_booking' => $this->faker->boolean,
            'available' => $this->faker->boolean,
            'e_provider_id' => EProvider::all()->random()->id
        ];
    }
}
