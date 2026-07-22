<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorDayThreeCheckIn extends Mailable
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
        return $this->subject('Getting Set Up on EWA — We Are Here to Help')
            ->from(config('mail.from.address', 'support@ewaofficialapp.com'), 'EWA Hair Platform')
            ->view('emails.vendor.day-three-checkin');
    }
}
