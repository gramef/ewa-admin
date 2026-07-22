<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Send booking reminders every 15 minutes
        $schedule->command('bookings:send-reminders')->everyFifteenMinutes();

        // Process subscription expiry checks daily at 8 AM
        $schedule->command('subscriptions:process-expiry')->dailyAt('08:00');

        // Send subscription expiry notifications daily at 9 AM (A02)
        $schedule->command('ewa:subscription-notifications')->dailyAt('09:00');

        // Send Day 3 check-in emails to recently approved vendors (SOP Section 6)
        $schedule->command('ewa:vendor-check-ins')->dailyAt('10:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
