<?php

namespace App\Livewire\RequisicionCurso;

use Livewire\Component;
use App\Models\RequisicionCurso;
use Illuminate\Support\Facades\DB;

class AutorizarComponent extends Component
{
    public $requisicion, $solicitante, $participantes;
    public $observaciones;
    protected $rules = [
        'observaciones' => 'required|max:500',
    ];
    protected $messages = [
        'observaciones.required' => 'Debe escribir una respuesta.',
        'observaciones.max' => 'La respuesta debe tener máximo 500 letras',
    ];

    public function render()
    {
        return view('livewire.requisicion-curso.autorizar-component');
    }
    public function mount($id)
    {
        $this->requisicion = RequisicionCurso::with('participantes')->findOrFail($id);
        $this->solicitante = $this->requisicion->participantes()->wherePivot('rol', 'solicitante')->first();
        $this->participantes = $this->requisicion->participantes;
    }
public function respuesta($respuesta)
    {
        $this->validate();
        try {
            DB::beginTransaction();
            if ($respuesta == 'aceptado') {

                $this->requisicion->status()->transitionTo('Aceptada por dirección general', ['observaciones' => $this->observaciones]);
            }
            if ($respuesta == 'rechazado') {
                $this->requisicion->status()->transitionTo('Rechazada por dirección general', ['observaciones' => $this->observaciones]);
            }
            DB::afterCommit(function () {
                flash()->addSuccess('Se ha enviado la respuesta.', 'Solicitud');
                return redirect()->route('dg.requisiciones.curso.index');
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            flash()->addError('ha ocurrido un problema.', 'Solicitud');
        }
    }

}
