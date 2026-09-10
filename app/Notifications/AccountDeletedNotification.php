<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Sent to a user immediately upon account deletion confirmation.
 * Complies with UK GDPR right-to-erasure and statutory retention disclosure.
 */
class AccountDeletedNotification extends Notification
{
    use Queueable;

    public string $userName;
    public string $userEmail;

    public function __construct(User $user)
    {
        $this->userName = $user->name ?? 'there';
        $this->userEmail = $user->email ?? '';
    }

    public function via(mixed $notifiable): array
    {
        // Account deletion confirmation is always sent via mail if an email exists
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $appName = setting('app_name', 'EWA');

        return (new MailMessage)
            ->subject("Account Deletion Confirmation | {$appName}")
            ->greeting("Hello {$this->userName},")
            ->line("This email confirms that your **{$appName}** account and associated personal profile have been deleted in accordance with your request.")
            ->line("### What was removed:")
            ->line("• Personal profile details and contact information")
            ->line("• Saved addresses, favorites, and service reviews")
            ->line("• Authentication credentials and active session tokens")
            ->line("### Data Retention Policy (UK GDPR & HMRC Compliance):")
            ->line("Under UK law (HMRC statutory accounting regulations), financial transaction records, invoices, and booking payment histories must be retained in an encrypted archive for **7 years** for statutory auditing and tax purposes. These records are strictly restricted and cannot be used for marketing or commercial purposes.")
            ->line("If you did not request this deletion or have questions regarding your data, please contact our Data Protection Officer immediately at **support@ewaofficialapp.com**.")
            ->salutation("Sincerely,\nThe {$appName} Team");
    }

    public function toArray(mixed $notifiable): array
    {
        return [
            'title'   => 'Account Deleted',
            'message' => 'Your account has been deleted.',
            'type'    => 'account_deleted',
        ];
    }
}
