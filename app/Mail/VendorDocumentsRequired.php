<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorDocumentsRequired extends Mailable
{
    use Queueable, SerializesModels;

    public string $vendorName;
    public string $vendorPwaUrl;
    public string $additionalNotes;

    public function __construct(string $vendorName, string $vendorPwaUrl, string $additionalNotes = '')
    {
        $this->vendorName = $vendorName;
        $this->vendorPwaUrl = $vendorPwaUrl;
        $this->additionalNotes = $additionalNotes;
    }

    public function build()
    {
        return $this->subject('Action Required — Complete Your EWA Application')
            ->from(config('mail.from.address', 'support@ewaofficialapp.com'), 'EWA Hair Platform')
            ->view('emails.vendor.documents-required');
    }
}
