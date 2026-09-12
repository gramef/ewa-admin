<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to admin users (and admin@ewaofficialapp.com)
 * whenever a new vendor business request / onboarding is submitted.
 */
class NewProviderRequestAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public string $providerName;
    public string $providerType;
    public string $ownerName;
    public string $ownerEmail;
    public string $phoneNumber;
    public string $packageName;
    public string $address;
    public int $providerId;
    public string $adminPanelUrl;

    public function __construct(
        string $providerName,
        string $providerType,
        string $ownerName,
        string $ownerEmail,
        string $phoneNumber,
        string $packageName = 'Free Trial (30 Days)',
        string $address = 'N/A',
        int $providerId = 0
    ) {
        $this->providerName = $providerName;
        $this->providerType = $providerType;
        $this->ownerName = $ownerName;
        $this->ownerEmail = $ownerEmail;
        $this->phoneNumber = $phoneNumber;
        $this->packageName = $packageName;
        $this->address = $address;
        $this->providerId = $providerId;
        $this->adminPanelUrl = url('requestedEProviders');
    }

    public function build()
    {
        return $this->subject("🔔 New Vendor Request: {$this->providerName}")
            ->from(config('mail.from.address', 'support@ewaofficialapp.com'), config('app.name', 'EWA Hair Platform'))
            ->markdown('emails.admin.provider-request');
    }
}
