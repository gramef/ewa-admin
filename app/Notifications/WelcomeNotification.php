<?php

namespace App\Notifications;

use App\Models\User;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Sent to a user immediately after registration.
 */
class WelcomeNotification extends Notification
{
    use Queueable;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via(mixed $notifiable): array
    {
        $types = ['database'];
        if (setting('enable_email_notifications', false)) {
            $types[] = 'mail';
        }
        return $types;
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $appName = setting('app_name', 'EWA');

        return (new MailMessage)
            ->subject("Welcome to {$appName}! 🎉")
            ->greeting("Hi {$this->user->name},")
            ->line("Welcome to {$appName}! We're excited to have you on board.")
            ->line("Whether you're here to book a professional hair styling service or manage your beauty business, we've got you covered.")
            ->action('Get Started', url('/'))
            ->line("If you have any questions, feel free to reach out to our support team at support@ewaofficialapp.com.")
            ->salutation("Best,\nThe {$appName} Team");
    }

    public function toArray(mixed $notifiable): array
    {
        return [
            'title'   => 'Welcome to ' . setting('app_name', 'EWA') . '!',
            'message' => 'Your account has been created successfully.',
            'type'    => 'welcome',
        ];
    }
}
