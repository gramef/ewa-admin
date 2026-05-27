<?php
/**
 * Seed E-Provider Types — RUN ONCE, then DELETE!
 */
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: application/json');
header('Cache-Control: no-cache');

$types = [
    ['name' => '{"en":"Independent Stylist"}', 'commission' => 0, 'disabled' => 0, 'order' => 1],
    ['name' => '{"en":"Mobile Hairdresser"}', 'commission' => 0, 'disabled' => 0, 'order' => 2],
    ['name' => '{"en":"Salon / Studio"}', 'commission' => 0, 'disabled' => 0, 'order' => 3],
    ['name' => '{"en":"Barbershop"}', 'commission' => 0, 'disabled' => 0, 'order' => 4],
];

$results = [];

foreach ($types as $type) {
    $existing = DB::table('e_provider_types')
        ->where('name', $type['name'])
        ->first();

    if ($existing) {
        // Ensure it's enabled
        DB::table('e_provider_types')
            ->where('id', $existing->id)
            ->update(['disabled' => 0]);
        $results[] = ['name' => $type['name'], 'status' => 'already exists (enabled)', 'id' => $existing->id];
    } else {
        $id = DB::table('e_provider_types')->insertGetId(array_merge($type, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));
        $results[] = ['name' => $type['name'], 'status' => 'CREATED', 'id' => $id];
    }
}

// Verify
$all = DB::table('e_provider_types')->where('disabled', 0)->get();

echo json_encode([
    'status' => 'SUCCESS',
    'seeded' => $results,
    'total_enabled' => count($all),
    'all_types' => $all,
    'message' => 'DELETE this file immediately!'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
