<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Notifications\BookingReminderNotification;
use Carbon\Carbon;

class SendBookingReminders extends Command
{
    protected $signature = 'bookings:send-reminders';
    protected $description = 'Send push notification reminders for upcoming bookings';

    public function handle()
    {
        // Find bookings happening in the next hour
        // booking_status_id: 1=Pending, 2=Accepted, 3=In Progress, 4=Done, 5=Cancelled
        $upcomingBookings = Booking::where('booking_at', '>=', Carbon::now())
            ->where('booking_at', '<=', Carbon::now()->addHour())
            ->whereIn('booking_status_id', [1, 2]) // Pending or Accepted
            ->with(['user', 'e_service', 'e_provider'])
            ->get();

        $count = 0;
        foreach ($upcomingBookings as $booking) {
            if ($booking->user) {
                // Check if we already sent a reminder (via notifications table)
                $alreadySent = $booking->user->notifications()
                    ->where('data->booking_id', $booking->id)
                    ->where('data->type', 'booking_reminder')
                    ->where('created_at', '>=', Carbon::now()->subHours(2))
                    ->exists();

                if ($alreadySent) {
                    $this->info("Already reminded for booking #{$booking->id}, skipping.");
                    continue;
                }

                try {
                    $booking->user->notify(new BookingReminderNotification($booking));
                    $count++;
                    $this->info("Reminder sent for booking #{$booking->id}");
                } catch (\Exception $e) {
                    $this->error("Failed for booking #{$booking->id}: " . $e->getMessage());
                }
            }
        }

        $this->info("Done. {$count} reminders sent.");
        return 0;
    }
}
