<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;

class ReservationCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->subject('Your Reservation is Completed')
                    ->view('emails.reservation-completed')
                    ->with([
                        'reservation' => $this->reservation,
                        'receiptLink' => route('receipt.view', ['id' => $this->reservation->id]), // Generate receipt link
                    ]);
    }
}
