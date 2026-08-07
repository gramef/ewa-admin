<?php

namespace App\Notifications;

use App\Models\Booking;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelledNotification extends Notification
{
    use Queueable;

    public Booking $booking;
    public array $cancellation;

    /**
     * @param Booking $booking
     * @param array   $cancellation  Output from CancellationService::calculate()
     */
    public function __construct(Booking $booking, array $cancellation = [])
    {
        $this->booking = $booking;
        $this->cancellation = $cancellation;
    }

    public function via(mixed $notifiable): array
    {
        $types = ['database'];
        if (setting('enable_notifications', false)) {
            $types[] = 'fcm';
        }
        if (setting('enable_email_notifications', false)) {
            $types[] = 'mail';
        }
        return $types;
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $booking = $this->booking;
        $c = $this->cancellation;
        $serviceName = is_object($booking->e_service) ? ($booking->e_service->name ?? 'Service') : 'Service';
        $providerName = is_object($booking->e_provider) ? ($booking->e_provider->name ?? 'Stylist') : 'Stylist';

        $subject = "Booking #{$booking->id} Cancelled";
        if (!empty($c['fee_amount']) && $c['fee_amount'] > 0) {
            $subject .= " — Cancellation Fee Applied";
        }
        $subject .= " | " . setting('app_name', 'EWA');

        return (new MailMessage)
            ->markdown('notifications::booking_cancelled', [
                'booking'      => $booking,
                'cancellation' => $c,
                'serviceName'  => $serviceName,
                'providerName' => $providerName,
            ])
            ->subject($subject);
    }

    public function toFcm($notifiable): FcmMessage
    {
        $message = new FcmMessage();
        $c = $this->cancellation;
        $feeInfo = (!empty($c['fee_amount']) && $c['fee_amount'] > 0)
            ? " — £" . number_format($c['fee_amount'], 2) . " cancellation fee"
            : " — no charge";

        $notification = [
            'title' => 'Booking Cancelled',
            'body'  => "Booking #{$this->booking->id} has been cancelled{$feeInfo}",
        ];
        $data = [
            'icon'         => $this->getEServiceMediaUrl(),
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'id'           => 'App\\Notifications\\BookingCancelledNotification',
            'status'       => 'done',
            'bookingId'    => (string) $this->booking->id,
        ];
        $message->content($notification)->data($data)->priority(FcmMessage::PRIORITY_HIGH);

        if ($to = $notifiable->routeNotificationFor('fcm', $this)) {
            $message->to($to);
        }
        return $message;
    }

    private function getEServiceMediaUrl(): string
    {
        if (is_object($this->booking->e_service) && $this->booking->e_service->hasMedia('image')) {
            return $this->booking->e_service->getFirstMediaUrl('image', 'thumb');
        }
        return asset('images/image_default.png');
    }

    public function toArray(mixed $notifiable): array
    {
        return [
            'booking_id'       => $this->booking->id,
            'booking_status'   => 'Cancelled',
            'e_service_name'   => $this->booking->e_service->name ?? '',
            'e_provider_name'  => $this->booking->e_provider->name ?? '',
            'cancellation_fee' => $this->cancellation['fee_amount'] ?? 0,
            'fee_label'        => $this->cancellation['label'] ?? '',
        ];
    }
}
