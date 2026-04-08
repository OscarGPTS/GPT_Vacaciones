<?php

namespace App\Mail;

use App\Models\RequestVacations;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VacationRequestApprovedByManager extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $employee;
    public $manager;
    public $daysCount;

    /**
     * Create a new message instance.
     */
    public function __construct(RequestVacations $request)
    {
        $this->request = $request;
        $this->employee = $request->user;
        $this->manager = $request->directManager;
        $this->daysCount = $request->requestDays->count();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Tu Jefe Aprobó tu Solicitud de Vacaciones',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.vacations.request-approved-by-manager',
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
