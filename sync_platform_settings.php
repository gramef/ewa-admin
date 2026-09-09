<?php
/**
 * Script to verify and sync EWA platform settings in database:
 * - Enables email notifications
 * - Sets default sender email to support@ewaofficial.co.uk
 * - Clears config and application caches
 *
 * Usage: php sync_platform_settings.php
 */
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;

echo "=== Syncing EWA Platform Settings ===\n";

try {
    setting([
        'enable_email_notifications' => '1',
        'mail_from_address'          => 'support@ewaofficial.co.uk',
        'mail_from_name'             => 'EWA Hair Platform',
        'mail_username'              => 'support@ewaofficial.co.uk',
        'app_name'                   => 'EWA Hair Platform',
    ])->save();

    echo "✓ Enabled email notifications in app settings\n";
    echo "✓ Set sender address to support@ewaofficial.co.uk\n";
    echo "✓ Set app name to EWA Hair Platform\n";

    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    echo "✓ Configuration and application caches cleared\n";

    echo "===========================================\n";
    echo "  ✅ Platform settings synced successfully!\n";
    echo "===========================================\n";
} catch (\Exception $e) {
    echo "Error syncing settings: " . $e->getMessage() . "\n";
    exit(1);
}
