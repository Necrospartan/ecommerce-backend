<?php

namespace App\Mail\Reservation;

use App\Models\Media;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Reservation $reservation;
    public User $user;
    public Media $media;
    public function __construct(Reservation $reservation)
    {
        $this->onQueue('emails');
        $this->reservation = $reservation;
        $this->user = $reservation->user;
        $this->media = $reservation->media;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmacion de la reservación',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.reservationConfirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
