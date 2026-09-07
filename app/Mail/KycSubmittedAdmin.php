<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to admin users when a vendor submits KYC
 * or when Persona verification completes.
 */
class KycSubmittedAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public string $vendorName;
    public string $vendorEmail;
    public int $providerId;
    public string $verificationMethod;
    public string $adminPanelUrl;

    public function __construct(
        string $vendorName,
        string $vendorEmail,
        int $providerId,
        string $verificationMethod = 'persona'
    ) {
        $this->vendorName = $vendorName;
        $this->vendorEmail = $vendorEmail;
        $this->providerId = $providerId;
        $this->verificationMethod = $verificationMethod;
        $this->adminPanelUrl = config('app.url', 'https://ewa-admin.com') . '/admin/kyc';
    }

    public function build()
    {
        return $this->subject("🔔 New KYC Submission — {$this->vendorName}")
            ->from(config('mail.from.address', 'support@ewaofficialapp.com'), 'EWA Hair Platform')
            ->view('emails.admin.kyc-submitted');
    }
}
