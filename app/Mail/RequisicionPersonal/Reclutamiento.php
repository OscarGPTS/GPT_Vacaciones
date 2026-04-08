<?php

namespace App\Mail\RequisicionPersonal;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reclutamiento extends Mailable
{
    use Queueable, SerializesModels;
    public $requisicion;

    public function __construct($requisicion)
    {
        $this->requisicion = $requisicion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('perfil.requisiciones_personal.email.reclutar')
        ->from('info@satechenergy.com', 'RRHH - Requisición de personal')
        ->subject('Nueva requisición de personal para reclutar');
    }
}
