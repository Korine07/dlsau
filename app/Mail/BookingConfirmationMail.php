<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation; // ✅ Correctly define the property

    public function __construct($reservation)
    {
        $this->reservation = $reservation; // ✅ Assign variable correctly
    }

    public function build()
    {
        return $this->from('noreply@example.com', 'OSFR')
                    ->subject('Your Booking Confirmation')
                    ->view('emails.booking_confirmation')
                    ->with(['reservation' => $this->reservation]); // ✅ Pass correctly
    }
}

