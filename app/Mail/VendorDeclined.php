<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorDeclined extends Mailable
{
    use Queueable, SerializesModels;

    public string $vendorName;
    public string $reason;

    public function __construct(string $vendorName, string $reason = '')
    {
        $this->vendorName = $vendorName;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('EWA Application Update')
            ->from(config('mail.from.address', 'support@ewaofficialapp.com'), 'EWA Hair Platform')
            ->view('emails.vendor.declined');
    }
}
