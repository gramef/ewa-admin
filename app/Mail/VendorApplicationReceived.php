<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public string $vendorName;

    public function __construct(string $vendorName)
    {
        $this->vendorName = $vendorName;
    }

    public function build()
    {
        return $this->subject('Your EWA Application Has Been Received')
            ->from(config('mail.from.address', 'support@ewaofficialapp.com'), 'EWA Hair Platform')
            ->view('emails.vendor.application-received');
    }
}
