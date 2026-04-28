<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\VacationsAvailable;
use App\Mail\VacationPeriodUnlocked;

class NotifyVacationPeriodUnlocked extends Command
{
    protected $signature   = 'vacation:notify-period-unlocked';
    protected $description = 'Notifica a los usuarios cuyo período de vacaciones se habilitó hoy (date_end = hoy)';

    public function handle(): int
    {
        $today = \Carbon\Carbon::today()->toDateString();

        $periods = VacationsAvailable::with('user')
            ->where('date_end', $today)
            ->where('status', 'actual')
            ->where('is_historical', false)
            ->get();

        if ($periods->isEmpty()) {
            $this->info('Sin períodos de vacaciones habilitados hoy.');
            return self::SUCCESS;
        }

        $notified = 0;

        foreach ($periods as $period) {
            $user = $period->user;

            if (!$user || !$user->email || !$user->active) {
                $this->warn("Período ID {$period->id}: usuario sin correo o inactivo, omitido.");
                continue;
            }

            try {
                Mail::to($user->email)
                    ->bcc(['recursoshumanos@gptservices.com'])
                    ->send(new VacationPeriodUnlocked($user, $period));

                $this->info("Correo enviado a {$user->email} — Período {$period->period} ({$today})");
                $notified++;
            } catch (\Exception $e) {
                $this->error("Error enviando a {$user->email}: {$e->getMessage()}");
            }
        }

        logger()->channel('slack')->info('vacation:notify-period-unlocked', [
            'fecha'      => $today,
            'notificados'=> $notified,
        ]);

        $this->info("Total notificados: {$notified}");
        return self::SUCCESS;
    }
}
