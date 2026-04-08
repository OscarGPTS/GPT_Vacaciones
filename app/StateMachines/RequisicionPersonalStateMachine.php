<?php

namespace App\StateMachines;

use Illuminate\Support\Facades\Mail;
use App\Mail\RequisicionPersonal\Notificacion;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class RequisicionPersonalStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            'creación de solicitud' => ['en revisión por jefe directo', 'en revisión por dirección general'],
            'en revisión por jefe directo' => ['en revisión por dirección general', 'rechazada por jefe directo'],
            'en revisión por dirección general' => ['en reclutamiento', 'rechazada por dirección general'],
            'en reclutamiento' => ['finalizada']
        ];
    }

    public function defaultState(): ?string
    {
        return 'creación de solicitud';
    }
    public function afterTransitionHooks(): array
    {
        return [
            'en revisión por jefe directo' => [
                function ($from, $model) {
                    // Informacion del email
                    $data = [
                        'status' => 'Para revisión por jefe directo',
                        'folio' => $model->folio(),
                        'user' => [
                            'nombre' => $model->solicitante->jefe->nombre(),
                            'email' => $model->solicitante->jefe->email,
                        ],
                        'solicitante' => $model->solicitante->nombre(),
                        'puesto' => $model->motivo == 'Nueva creación' ? $model->puesto_nuevo : $model->puesto->name,
                        'personas' => $model->personas_requeridas,
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                },
            ],
            'en revisión por dirección general' => [
                function ($from, $model) {
                    // Informacion del email
                    $data = [
                        'status' => 'Para revisión por dirección general',
                        'folio' => $model->folio(),
                        'user' => [
                            'nombre' => 'Denise Marisol Reyes Ramírez',
                            'email' => 'dmreyesr@gptservices.com',
                        ],
                        'solicitante' => $model->solicitante->nombre(),
                        'puesto' => $model->motivo == 'Nueva creación' ? $model->puesto_nuevo : $model->puesto->name,
                        'personas' => $model->personas_requeridas,
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                },
            ],
            'rechazada por jefe directo' => [
                function ($from, $model) {
                    // Informacion del email
                    $data = [
                        'status' => 'Rechazada por jefe directo',
                        'folio' => $model->folio(),
                        'user' => [
                            'nombre' => $model->solicitante->nombre(),
                            'email' => $model->solicitante->email,
                        ],
                        'solicitante' => $model->solicitante->nombre(),
                        'puesto' => $model->motivo == 'Nueva creación' ? $model->puesto_nuevo : $model->puesto->name,
                        'personas' => $model->personas_requeridas,
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                },
            ],
            'en reclutamiento' => [
                function ($from, $model) {
                    // Informacion del email
                    $data = [
                        'status' => 'Aceptada por dirección general',
                        'folio' => $model->folio(),
                        'user' => [
                            'nombre' => 'Departamento de RRHH',
                            'email' => 'recursoshumanos@gptservices.com',
                        ],
                        'solicitante' => $model->solicitante->nombre(),
                        'puesto' => $model->motivo == 'Nueva creación' ? $model->puesto_nuevo : $model->puesto->name,
                        'personas' => $model->personas_requeridas,
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->send(new Notificacion($data));
                },
            ],
            'rechazada por dirección general' => [
                function ($from, $model) {
                    $data = [
                        'status' => 'Rechazada por dirección general',
                        'folio' => $model->folio(),
                        'user' => [
                            'nombre' => $model->solicitante->nombre(),
                            'email' => $model->solicitante->email,
                        ],
                        'solicitante' => $model->solicitante->nombre(),
                        'puesto' => $model->motivo == 'Nueva creación' ? $model->puesto_nuevo : $model->puesto->name,
                        'personas' => $model->personas_requeridas,
                    ];
                    //    Enviar notificacion
                    Mail::to($data['user']['email'])
                        ->bcc('recursoshumanos@gptservices.com')
                        ->send(new Notificacion($data));
                },
            ],
        ];
    }
}
