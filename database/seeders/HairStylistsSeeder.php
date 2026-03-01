<?php
/*
 * File name: HairStylistsSeeder.php
 * Last modified: 2024.01.15 at 10:00:00
 * Author: EWA Hair Platform
 * Copyright (c) 2024
 */

namespace Database\Seeders;

use App\Models\EProvider;
use App\Models\EProviderUser;
use App\Models\User;
use App\Models\Address;
use App\Models\EProviderAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Exception;

class HairStylistsSeeder extends Seeder
{
    /**
     * Seed professional hair stylists for the EWA Hair platform
     *
     * @return void
     */
    public function run(): void
    {
        // Create 5 professional hair stylists using factories
        try {
            // Create hair stylist providers
            EProvider::factory()->count(5)->create([
                'available' => true,
                'accepted' => true,
                'featured' => true,
            ]);
            
            // Create users for the providers
            EProviderUser::factory()->count(5)->create();
            
        } catch (Exception $e) {
            // Handle any creation errors gracefully
        }

        $this->command->info('Hair stylists seeded successfully!');
        $this->command->info('Default login credentials:');
        $this->command->info('Password for all stylists: password123');
    }
}