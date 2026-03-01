<?php
/*
 * File name: EProviderAddressFactory.php
 * Last modified: 2024.04.11 at 15:19:20
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2024
 */

namespace Database\Factories;

use App\Models\Address;
use App\Models\EProvider;
use App\Models\EProviderAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class EProviderAddressFactory
 * @package Database\Factories
 */
class EProviderAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EProviderAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address_id' => Address::all()->random()->id,
            'e_provider_id' => EProvider::all()->random()->id
        ];
    }
}
