<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorApproved extends Mailable
{
    use Queueable, SerializesModels;

    public string $vendorName;
    public string $vendorPwaUrl;

    public function __construct(string $vendorName, string $vendorPwaUrl)
    {
        $this->vendorName = $vendorName;
        $this->vendorPwaUrl = $vendorPwaUrl;
    }

    public function build()
    {
        return $this->subject('Welcome to EWA — You Are Now Live')
            ->from(config('mail.from.address', 'support@ewaofficialapp.com'), 'EWA Hair Platform')
            ->view('emails.vendor.approved');
    }
}
