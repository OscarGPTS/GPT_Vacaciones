<?php

namespace App\Mail\RequisicionPersonal;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Revision extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;

    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('perfil.requisiciones_personal.email.revision')
            ->from('info@satechenergy.com', 'RRHH - Requisición de personal')
            ->subject('Nueva requisición de personal');
    }
}
