<?php

namespace App\Notifications;

use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Sent when a vendor's KYC (Know Your Customer) verification is approved or rejected.
 */
class KycStatusNotification extends Notification
{
    use Queueable;

    public string $status;   // 'approved' or 'rejected'
    public ?string $reason;  // Rejection reason (if rejected)

    public function __construct(string $status, ?string $reason = null)
    {
        $this->status = $status;
        $this->reason = $reason;
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
        $appName = setting('app_name', 'EWA');

        if ($this->status === 'approved') {
            return (new MailMessage)
                ->subject("✅ Identity Verified — You're approved! | {$appName}")
                ->greeting("Congratulations, {$notifiable->name}!")
                ->line("Your identity verification has been **approved**. You can now start receiving bookings and accepting clients on {$appName}.")
                ->line("Make sure to complete your profile and list your services to start earning.")
                ->action('Go to Dashboard', url('/'))
                ->salutation("Welcome aboard!\nThe {$appName} Team");
        }

        return (new MailMessage)
            ->subject("Identity Verification Update | {$appName}")
            ->greeting("Hi {$notifiable->name},")
            ->line("Unfortunately, we were unable to verify your identity at this time.")
            ->line($this->reason ? "**Reason:** {$this->reason}" : "Please ensure your documents are clear and match the information provided.")
            ->line("You can re-submit your verification documents from the app.")
            ->action('Re-submit Verification', url('/'))
            ->salutation("If you need help, contact support@ewaofficialapp.com\nThe {$appName} Team");
    }

    public function toFcm($notifiable): FcmMessage
    {
        $message = new FcmMessage();
        $title = $this->status === 'approved'
            ? '✅ Identity Verified!'
            : '⚠️ Verification Update';
        $body = $this->status === 'approved'
            ? 'Your identity has been verified. You can now accept bookings!'
            : 'Your identity verification needs attention. Please check your profile.';

        $notification = ['title' => $title, 'body' => $body];
        $data = [
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'id' => 'App\\Notifications\\KycStatusNotification',
            'status' => $this->status,
        ];
        $message->content($notification)->data($data)->priority(FcmMessage::PRIORITY_HIGH);

        if ($to = $notifiable->routeNotificationFor('fcm', $this)) {
            $message->to($to);
        }
        return $message;
    }

    public function toArray(mixed $notifiable): array
    {
        return [
            'title'  => $this->status === 'approved' ? '✅ Identity Verified!' : '⚠️ Verification Update',
            'message' => $this->status === 'approved'
                ? 'Your identity has been verified. You can now accept bookings!'
                : 'Your identity verification needs attention.' . ($this->reason ? " Reason: {$this->reason}" : ''),
            'type'   => 'kyc_' . $this->status,
        ];
    }
}
