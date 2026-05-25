<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestVacations;
use App\Models\User;

class VacationRequestCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $employee;
    public $cancelledBy;
    public $creator;
    public $daysCount;

    public function __construct(RequestVacations $request, User $cancelledBy)
    {
        $this->request = $request;
        $this->employee = $request->user;
        $this->cancelledBy = $cancelledBy;
        $this->creator = $request->created_by_user_id
            ? User::find($request->created_by_user_id)
            : null;
        $this->daysCount = $request->requestDays->count();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de Vacaciones Cancelada - ' . $this->employee->first_name . ' ' . $this->employee->last_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.vacations.request-cancelled',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
