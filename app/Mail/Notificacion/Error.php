<?php

namespace App\Mail\Notificacion;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Error extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('errors.email.error')
            ->from('info@satechenergy.com', 'RRHH - Notificacion')
            ->subject('Ocurrio un error');
    }
}
