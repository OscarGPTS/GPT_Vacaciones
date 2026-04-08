<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestVacations;

class VacationRequestApprovedByDirection extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $employee;
    public $daysCount;

    /**
     * Create a new message instance.
     */
    public function __construct(RequestVacations $request)
    {
        $this->request = $request;
        $this->employee = $request->user;
        $this->daysCount = $request->requestDays->count();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de Vacaciones Aprobada por Dirección',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.vacations.request-approved-by-direction',
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
