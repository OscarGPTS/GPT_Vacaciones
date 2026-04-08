<?php

namespace App\Livewire\RequisicionCurso;

use Livewire\Component;
use App\Models\RequisicionCurso;
use Illuminate\Support\Facades\DB;

class RevisarGerenteComponent extends Component
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


    public function mount($id)
    {
        $this->requisicion = RequisicionCurso::with('participantes')->findOrFail($id);
        $this->solicitante = $this->requisicion->participantes()->wherePivot('rol', 'solicitante')->first();
        $this->participantes = $this->requisicion->participantes;
    }
    public function render()
    {
        return view('livewire.requisicion-curso.revisar-gerente-component');
    }
    public function respuesta($respuesta)
    {
        $this->validate();
        try {
            DB::beginTransaction();

            if ($respuesta == 'aceptado') {
                $this->requisicion->status()->transitionTo('En revisión por dirección general', ['observaciones' => $this->observaciones]);
            }
            if ($respuesta == 'rechazado') {
                $this->requisicion->status()->transitionTo('Rechazada por gerente', ['observaciones' => $this->observaciones]);
            }
            DB::afterCommit(function () {
                flash()->addSuccess('Se ha enviado la respuesta.', 'Solicitud');
                return redirect()->route('gerente.requisiciones.curso.indexGerente');
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            flash()->addError('ha ocurrido un problema.', 'Solicitud');
        }
    }
}
