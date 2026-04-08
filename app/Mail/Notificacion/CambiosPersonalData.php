<?php

namespace App\Mail\Notificacion;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CambiosPersonalData extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     */ public function __construct($data)
    {
        $this->data = $data;
    }

    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->view('empleados.personal_data.mail_template')
            ->to('recursoshumanos@gptservices.com')
            ->from('info@satechenergy.com', 'RRHH')
            ->subject('Cambios en datos personales');
    }
}
