<?php

// Script to fix all seeders for SQLite compatibility
$seedersPath = __DIR__ . '/database/seeders/';
$files = [
    'AwardsTableSeeder.php',
    'AppSettingsTableSeeder.php',
    'AvailabilityHoursTableSeeder.php',
    'EProvidersTableSeeder.php',
    'EProviderAddressesTableSeeder.php',
    'EServiceCategoriesTableSeeder.php',
    'ExperiencesTableSeeder.php'
];

foreach ($files as $file) {
    $filePath = $seedersPath . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        
        // Fix DB import
        $content = str_replace('use DB;', 'use Illuminate\\Support\\Facades\\DB;', $content);
        
        // Fix FOREIGN_KEY_CHECKS for SQLite compatibility
        $content = str_replace(
            "DB::statement('SET FOREIGN_KEY_CHECKS=0;');",
            "if (DB::getDriverName() === 'mysql') {\n            DB::statement('SET FOREIGN_KEY_CHECKS=0;');\n        }",
            $content
        );
        
        $content = str_replace(
            "DB::statement('SET FOREIGN_KEY_CHECKS=1;');",
            "if (DB::getDriverName() === 'mysql') {\n            DB::statement('SET FOREIGN_KEY_CHECKS=1;');\n        }",
            $content
        );
        
        file_put_contents($filePath, $content);
        echo "Fixed: $file\n";
    }
}

echo "All seeders fixed for SQLite compatibility!\n";