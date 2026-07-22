<?php

namespace App\Console\Commands;

use App\Mail\VendorDayThreeCheckIn;
use App\Models\EProvider;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Send Day 3 check-in emails to vendors who were approved 3 days ago.
 *
 * Per the Vendor Onboarding SOP v2 (Section 6):
 * "Day 3 check-in: Has the vendor updated their profile since approval?
 *  Have they set availability hours? Have they added all intended services?
 *  Send check-in message if profile appears incomplete."
 *
 * Schedule: Run daily via `php artisan schedule:run`
 */
class SendVendorCheckIns extends Command
{
    protected $signature = 'ewa:vendor-check-ins';
    protected $description = 'Send Day 3 check-in emails to recently approved vendors';

    public function handle(): int
    {
        $this->info('Checking for Day 3 vendor check-ins...');

        $vendorPwaUrl = config('app.vendor_pwa_url', 'https://ewa-vendor-pwa.vercel.app');
        $sent = 0;

        // Find providers approved exactly 3 days ago
        $threeDaysAgo = Carbon::now()->subDays(3)->format('Y-m-d');

        $providers = EProvider::where('kyc_status', 'verified')
            ->whereDate('kyc_reviewed_at', $threeDaysAgo)
            ->get();

        foreach ($providers as $provider) {
            $user = $provider->users()->first();
            if (!$user || !$user->email) {
                $this->warn("  Skipping provider #{$provider->id}: no linked user or email");
                continue;
            }

            $vendorName = is_array($user->name) ? ($user->name['en'] ?? 'there') : ($user->name ?? 'there');

            try {
                Mail::to($user->email)->send(new VendorDayThreeCheckIn($vendorName, $vendorPwaUrl));
                $this->info("  ✓ Day 3 check-in sent to {$user->email} (provider #{$provider->id})");
                $sent++;
            } catch (\Exception $e) {
                $this->error("  ✗ Failed for {$user->email}: " . $e->getMessage());
                Log::error("Day 3 check-in failed for provider #{$provider->id}: " . $e->getMessage());
            }
        }

        $this->info("Done. {$sent} check-in emails sent.");
        Log::info("ewa:vendor-check-ins sent {$sent} Day 3 check-in emails");

        return self::SUCCESS;
    }
}
