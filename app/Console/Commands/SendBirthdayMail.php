<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\Birthday;
use App\Models\PersonalData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class SendBirthdayMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send_birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de correo de cumpleaños de los colaboradores';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usersBirthday = [];
        $mes = date("m");
        $dia = date("d");

        $result = PersonalData::with(['user'])
            ->whereMonth('birthday', $mes)
            ->whereDay('birthday', $dia)
            ->whereHas('user', function ($query) {
                $query->where('active', 1)
                    ->whereNot('email', '');
            })
            ->get();
        if ($result->isEmpty()) {
            $this->info('sin cumpleaños para el dia de hoy');
            return true;
        }
        foreach ($result as $data) {
            $usersBirthday[] = [
                'nombre' => $data->user->nombre(),
                'email' => $data->user->email,
                'url' => URL::temporarySignedRoute(
                    'birthday.show',
                    now()->addDays(5),
                    ['id' => $data->user->id]
                ),
            ];
        }
        $this->table(
            ['nombre', 'url'],
            $usersBirthday
        );
        foreach ($usersBirthday as $user) {
            try {
                Mail::to($user['email'])
                    ->bcc(['recursoshumanos@gptservices.com', 'ahernandezm@gptservices.com'])
                    ->send(new Birthday($user));
                $this->info('se envio correo');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }
}
