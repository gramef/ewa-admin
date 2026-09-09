<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Events\BookingChangedEvent;
use App\Notifications\StatusChangedBooking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class AutoReleaseCompletedBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:auto-release-completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-complete bookings awaiting client confirmation for >24 hours and release earnings to vendor';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cutoff = Carbon::now()->subHours(24);

        // Status 5 = Ready / Awaiting Client Confirmation
        $bookings = Booking::where('booking_status_id', 5)
            ->where('updated_at', '<=', $cutoff)
            ->get();

        $count = 0;

        foreach ($bookings as $booking) {
            try {
                // Update status to 6 (Done)
                $booking->booking_status_id = 6;
                $booking->save();

                // Recalculate provider earnings & wallet
                if ($booking->e_provider) {
                    event(new BookingChangedEvent($booking->e_provider));
                }

                // Notify client and provider
                if ($booking->user) {
                    Notification::send([$booking->user], new StatusChangedBooking($booking));
                }
                if ($booking->e_provider && $booking->e_provider->users) {
                    Notification::send($booking->e_provider->users, new StatusChangedBooking($booking));
                }

                $count++;
                Log::info("Booking #{$booking->id} auto-released to Done after 24 hours.");
                $this->info("Booking #{$booking->id} auto-released to Done.");

            } catch (\Exception $e) {
                Log::error("Failed to auto-release booking #{$booking->id}: " . $e->getMessage());
                $this->error("Failed for booking #{$booking->id}: " . $e->getMessage());
            }
        }

        $this->info("Completed. {$count} bookings auto-released.");
        return 0;
    }
}
