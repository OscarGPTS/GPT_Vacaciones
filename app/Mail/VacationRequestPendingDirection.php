<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VacationRequestPendingDirection extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $daysCount;
    public $manager;

    /**
     * Create a new message instance.
     */
    public function __construct(User $employee, int $daysCount, User $manager)
    {
        $this->employee = $employee;
        $this->daysCount = $daysCount;
        $this->manager = $manager;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva Solicitud de Vacaciones Pendiente de Aprobación (Dirección)',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.vacations.request-pending-direction',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
