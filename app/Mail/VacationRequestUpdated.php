<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestVacations;
use App\Models\User;

class VacationRequestUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $employee;
    public $editedBy;
    public $daysCount;
    public $editedBySelf;

    /**
     * @param RequestVacations $request   La solicitud actualizada (con requestDays ya guardados)
     * @param User             $editedBy  Quién hizo la edición
     */
    public function __construct(RequestVacations $request, User $editedBy)
    {
        $this->request      = $request;
        $this->employee     = $request->user;
        $this->editedBy     = $editedBy;
        $this->daysCount    = $request->requestDays->count();
        $this->editedBySelf = $editedBy->id === $request->user_id;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de Vacaciones Actualizada - ' . $this->employee->first_name . ' ' . $this->employee->last_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.vacations.request-updated',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
