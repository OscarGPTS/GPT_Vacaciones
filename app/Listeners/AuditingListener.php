<?php

namespace App\Listeners;

use OwenIt\Auditing\Events\Audited;
use OwenIt\Auditing\Events\Auditing;

class AuditingListener
{
    /**
     * Create the Auditing event listener.
     */
    public function __construct()
    {
        // ...
    }

    /**
     * Handle the Auditing event.
     *
     * @param \OwenIt\Auditing\Events\Auditing $event
     * @return void
     */
    public function handle(Audited  $event)
    {
        if (config('app.env') == 'production') {
            // Get latest Audit
            $audit = $event->model->audits()->latest()->first();
            // Enviar notificaciones por Slack
            logger()->channel('slack')->info('Cambios', [
                'model' => $audit->getMetadata(),
                'cambios' => $audit->getModified()
            ]);
        }
    }
}
