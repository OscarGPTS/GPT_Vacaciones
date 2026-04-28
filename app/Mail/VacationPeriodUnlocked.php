<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\VacationsAvailable;

class VacationPeriodUnlocked extends Mailable
{
    use Queueable, SerializesModels;

    public User $employee;
    public VacationsAvailable $period;
    public string $cutoffDate;
    public string $dateEnd;
    public int $periodYear;
    public int $periodYearEnd;
    public float $daysAvailable;

    public function __construct(User $employee, VacationsAvailable $period)
    {
        $this->employee      = $employee;
        $this->period        = $period;
        $this->dateEnd       = \Carbon\Carbon::parse($period->date_end)->format('d/m/Y');
        $this->cutoffDate    = (!empty($period->cutoff_date)
            ? \Carbon\Carbon::parse($period->cutoff_date)
            : \Carbon\Carbon::parse($period->date_end)->addMonths(15)
        )->format('d/m/Y');
        $this->periodYear    = \Carbon\Carbon::parse($period->date_end)->year;
        $this->periodYearEnd = $this->periodYear + 1;
        $this->daysAvailable = (float) $period->days_availables;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Tus días de vacaciones ya están disponibles! — Período ' . $this->periodYear . '-' . $this->periodYearEnd,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.vacations.period-unlocked',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
