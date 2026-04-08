<?php

namespace App\Livewire\RequisicionPersonal;

use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;


class Autorizar extends Component
{
    use Actions;
    public $motivo;
    public  $requisicion;

    protected $rules = [
        'motivo' => 'required|max:255',
    ];
    protected $messages = [
        'motivo.required' => 'Debe escribir una respuesta.',
        'motivo.max' => 'La respuesta debe tener máximo 255 letras',
    ];

    public function render()
    {
        return view('livewire.requisicion-personal.autorizar');
    }

    public function respuesta($respuesta)
    {
        $this->validate();
        try {
            DB::beginTransaction();
            if ($respuesta == 'aceptar') {
                $this->requisicion->status()->transitionTo('en reclutamiento', ['motivo' => $this->motivo]);
            }
            if ($respuesta == 'rechazar') {
                $this->requisicion->status()->transitionTo('rechazada por dirección general', ['motivo' => $this->motivo]);
            }
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Solicitud',
                    $description = 'Se ha enviado la respuesta'
                );
                return redirect()->route('perfil.requisiciones.personal.autorizar.index');
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Solicitud',
                $description = 'ha ocurrido un problema'
            );
        }
    }
}
