<?php

namespace App\Console\Commands;

use Imagick;
use App\Models\User;
use App\Mail\Aniversario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Spatie\PdfToImage\Pdf as ImgToPDF;
use Illuminate\Support\Facades\Storage;

class SendAnniversaryMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send_anniversary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de correo para el personal que cumple aniversario';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $imagenes = [
            1 =>  asset('aniversario/plantilla-2/numeros/1.png'),
            2 =>  asset('aniversario/plantilla-2/numeros/2.png'),
            3 =>  asset('aniversario/plantilla-2/numeros/3.png'),
            4 =>  asset('aniversario/plantilla-2/numeros/4.png'),
            5 =>  asset('aniversario/plantilla-2/numeros/5.png'),
            6 =>  asset('aniversario/plantilla-2/numeros/6.png'),
            7 =>  asset('aniversario/plantilla-2/numeros/7.png'),
            8 =>  asset('aniversario/plantilla-2/numeros/8.png'),
            9 =>  asset('aniversario/plantilla-2/numeros/9.png'),
            10 =>  asset('aniversario/plantilla-2/numeros/10.png'),
            11 =>  asset('aniversario/plantilla-2/numeros/11.png'),
            12 =>  asset('aniversario/plantilla-2/numeros/12.png'),
            13 =>  asset('aniversario/plantilla-2/numeros/13.png'),
            14 =>  asset('aniversario/plantilla-2/numeros/14.png'),
            15 =>  asset('aniversario/plantilla-2/numeros/15.png'),
            16 =>  asset('aniversario/plantilla-2/numeros/16.png'),
            17 =>  asset('aniversario/plantilla-2/numeros/17.png'),
            18 =>  asset('aniversario/plantilla-2/numeros/18.png'),
            19 =>  asset('aniversario/plantilla-2/numeros/19.png'),
            20 =>  asset('aniversario/plantilla-2/numeros/20.png'),


        ];
        $usersAniversario = [];
        $year = date('Y');
        $mes = date("m");
        $dia = date("d");

        $users = User::with(['job', 'job.departamento'])
            ->whereYear('admission', '!=', $year)
            ->whereMonth('admission', $mes)
            ->where('active', 1)
            ->whereDay('admission', $dia)
            ->whereNot('email', '')
            ->get();

        if ($users->isEmpty()) {
            $this->info('sin aniversarios para el dia de hoy');
            return true;
        }
        foreach ($users as $user) {
            $usersAniversario[] = [
                'id' => $user->id,
                'nombre' => $user->nombre(),
                'avatar' => asset("aniversario/plantilla-2/colaboradores/{$user->id}.png"),
                'email' => $user->email,
                'departamento' => $user->job->departamento->name,
                'numero' => $imagenes[$user->admission->age],
                'cantidad' => $user->admission->age,
            ];
        }

        logger()->channel('slack')->info('Cron aniversario', [
            $usersAniversario
        ]);
        foreach ($usersAniversario as $empleado) {
            try {
                $avatar = Image::make($empleado['avatar']);
                $avatar->resize(660, 660, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            } catch (\Exception $e) {
                $this->error('avatar');
                $this->error($e->getMessage());
                return;
            }

            try {
                $numero = Image::make($empleado['numero']);
                $numero->resize(530, 530, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            } catch (\Exception $e) {
                $this->error('numero');
                $this->error($e->getMessage());
                return;
            }

            try {
                $img  =  Image::make('public/aniversario/plantilla-2/template-2.png');
                $img->insert($avatar, '', 135, 304);
                $img->insert($numero, '', 1370, 370);
                $img->text($empleado['nombre'], 1030, 920, function ($font) {
                    $font->file('public/fonts/poppins/Poppins-SemiBold.ttf');
                    $font->size(38);
                    $font->color('#000000');
                });
            } catch (\Exception $e) {
                $this->error('merge plantilla y foto de colaborador');
                $this->error($e->getMessage());
                return;
            }

            try {
                Storage::disk('tmp')->put("{$empleado['id']}.png", $img->encode('png'));
            } catch (\Exception $e) {
                $this->error('almacenar imagen');
                $this->error($e->getMessage());
                return;
            }

            try {
                Mail::to($empleado['email'])
                    ->bcc(['recursoshumanos@gptservices.com', 'ahernandezm@gptservices.com'])
                    ->send(new Aniversario($empleado['id']));
                // Mail::to('ahernandezm@gptservices.com')
                //     ->send(new Aniversario($empleado['id']));
                $this->info('se envio correo de aniversario');
            } catch (\Exception $e) {
                $this->error('envio de correo');
                $this->error($e->getMessage());
                return;
            }
        }
    }
}
