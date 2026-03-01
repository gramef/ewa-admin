<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingReminderNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $serviceName = $this->booking->e_service->name ?? 'your service';
        $time = $this->booking->booking_at ? $this->booking->booking_at->format('g:i A') : 'soon';

        return [
            'title' => 'Booking Reminder',
            'body' => "Your appointment for {$serviceName} is at {$time}. Get ready!",
            'booking_id' => $this->booking->id,
            'type' => 'booking_reminder',
            'icon' => 'calendar_month',
        ];
    }
}
