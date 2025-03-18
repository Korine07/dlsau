<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;

class BookingConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        $receiptLink = route('receipt.view', ['id' => $this->reservation->id]);

        return $this->subject('Your Reservation is Confirmed')
                    ->view('emails.booking-confirmed')
                    ->with([
                        'reservation' => $this->reservation,
                        'receiptLink' => $receiptLink,
                    ]);
    }
}
