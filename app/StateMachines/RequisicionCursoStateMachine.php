<?php

namespace App\StateMachines;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Services\Perfil\RqCursoService;
use App\Mail\RequisicionCurso\Notificacion;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class RequisicionCursoStateMachine extends StateMachine
{
    // nivel maximo 4
    // nivel 1 : solicitante
    // nivel 2 : jefe directo
    // nivel 3 : gerente
    // nivel 4 : DG

    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            'Creación de solicitud' => ['En revisión por jefe directo', 'En revisión por gerente', 'En revisión por dirección general'],
            'En revisión por jefe directo' => ['En revisión por gerente', 'Rechazada por jefe directo'],
            'En revisión por gerente' => ['En revisión por dirección general', 'Rechazada por gerente'],
            'En revisión por dirección general' => ['Rechazada por dirección general', 'Aceptada por dirección general'],
            'Aceptada por dirección general' => ['Cerrada']
        ];
    }

    public function defaultState(): ?string
    {
        return 'Creación de solicitud';
    }


    public function afterTransitionHooks(): array
    {
        return [
            'En revisión por jefe directo' => [
                function ($to, $model) {
                    // Informacion del email
                    $solicitante = $model->participantes()->wherePivot('rol', 'solicitante')->first();

                    $rqService = new RqCursoService($solicitante, $model);
                    $user = $rqService->getJefeDirecto();
                    $data = [
                        'status' => 'En revisión por jefe directo',
                        'folio' => $model->id,
                        'user' => [
                            'nombre' => $user->nombre(),
                            'email' => $user->email,
                        ],
                        'solicitante' => $solicitante->nombre(),

                        'curso' => $model->nombre
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                }
            ],
            'En revisión por gerente' => [
                function ($to, $model) {
                    // Informacion del email
                    $solicitante = $model->participantes()->wherePivot('rol', 'solicitante')->first();
                    $rqService = new RqCursoService($solicitante, $model);
                    $user = $rqService->getGerente();
                    $data = [
                        'status' => 'En revisión por gerente',
                        'folio' => $model->id,
                        'user' => [
                            'nombre' => $user->nombre(),
                            'email' => $user->email,
                        ],
                        'solicitante' => $solicitante->nombre(),

                        'curso' => $model->nombre
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                }
            ],
            'En revisión por dirección general' => [
                function ($to, $model) {
                    // Informacion del email
                    $solicitante = $model->participantes()->wherePivot('rol', 'solicitante')->first();
                    $user = User::find(106);
                    $data = [
                        'status' => 'En revisión por dirección general',
                        'folio' => $model->id,
                        'user' => [
                            'nombre' => $user->nombre(),
                            'email' => $user->email,
                        ],
                        'solicitante' => $solicitante->nombre(),

                        'curso' => $model->nombre
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                }
            ],
            'Rechazada por jefe directo' => [
                function ($to, $model) {
                    // Informacion del email
                    $solicitante = $model->participantes()->wherePivot('rol', 'solicitante')->first();
                    $data = [
                        'status' => 'Rechazada por jefe directo',
                        'folio' => $model->id,
                        'user' => [
                            'nombre' => $solicitante->nombre(),
                            'email' => $solicitante->email,
                        ],
                        'solicitante' => $solicitante->nombre(),

                        'curso' => $model->nombre
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                }
            ],
            'Rechazada por gerente' => [
                function ($to, $model) {
                    // Informacion del email
                    $solicitante = $model->participantes()->wherePivot('rol', 'solicitante')->first();
                    $data = [
                        'status' => 'Rechazada por gerente',
                        'folio' => $model->id,
                        'user' => [
                            'nombre' => $solicitante->nombre(),
                            'email' => $solicitante->email,
                        ],
                        'solicitante' => $solicitante->nombre(),

                        'curso' => $model->nombre
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                }
            ],
            'Rechazada por dirección general' => [
                function ($to, $model) {
                    // Informacion del email
                    $solicitante = $model->participantes()->wherePivot('rol', 'solicitante')->first();
                    $data = [
                        'status' => 'Rechazada por dirección general',
                        'folio' => $model->id,
                        'user' => [
                            'nombre' => $solicitante->nombre(),
                            'email' => $solicitante->email,
                        ],
                        'solicitante' => $solicitante->nombre(),

                        'curso' => $model->nombre
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                }
            ],
            'Aceptada por dirección general' => [
                function ($to, $model) {
                    // Informacion del email
                    $solicitante = $model->participantes()->wherePivot('rol', 'solicitante')->first();
                    $data = [
                        'status' => 'Aceptada por dirección general',
                        'folio' => $model->id,
                        'user' => [
                            'nombre' => $solicitante->nombre(),
                            'email' => $solicitante->email,
                        ],
                        'solicitante' => $solicitante->nombre(),

                        'curso' => $model->nombre
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                }
            ],
        ];
    }
}
