<?php

namespace App\Livewire\RequisicionPersonal;

use App\Models\Job;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use App\Models\RequisicionPersonal;
use Illuminate\Support\Facades\Auth;


class Create extends Component
{
    use Actions;
    public $puestos, $puesto;

    public RequisicionPersonal $rq;

    public $conocimientos = [''],
        $competencias = [''],
        $actividades = [''];

    protected $rules = [
        'rq.tipo_personal' => 'required',
        'rq.motivo' => 'required',
        'rq.horario' => 'required',
        'rq.personas_requeridas' => 'required',
        'rq.grado_escolar' => 'required',
        'rq.experiencia_years' => 'required',
        'rq.trabajo_campo' => 'nullable',
        'rq.trato_clientes' => 'nullable',
        'rq.manejo_personal' => 'nullable',
        'rq.licencia_conducir' => 'nullable',
        'rq.licencia_tipo' => 'required_if:rq.licencia_conducir,true',

        'rq.conocimientos.*' => 'required_if:rq.motivo,Nueva creación',
        'rq.competencias.*' => 'required_if:rq.motivo,Nueva creación',
        'rq.actividades.*' => 'required_if:rq.motivo,Nueva creación',

        'rq.puesto_solicitado' => 'required_unless:rq.motivo,Nueva creación',
        'rq.puesto_nuevo' => 'required_if:rq.motivo,Nueva creación',
        'rq.solicitante_id' => 'required'
    ];

    protected $messages = [];

    public function mount()
    {
        $this->rq = new RequisicionPersonal();
        $this->puestos = Job::with(['departamento', 'departamento.area'])
            ->get();
        $this->rq->solicitante_id = Auth::user()->id;
    }

    public function render()
    {
        return view('livewire.requisicion-personal.create');
    }

    public function addRow($array)
    {
        if ($array == 'conocimientos') {
            $this->conocimientos[] = '';
        }
        if ($array == 'competencias') {
            $this->competencias[] = '';
        }
        if ($array == 'actividades') {
            $this->actividades[] = '';
        }
    }
    public function removeRow($array, $index)
    {
        if ($array == 'conocimientos') {
            unset($this->conocimientos[$index]);
            $this->conocimientos = array_values($this->conocimientos);
        }
        if ($array == 'competencias') {
            unset($this->competencias[$index]);
            $this->competencias = array_values($this->competencias);
        }
        if ($array == 'actividades') {
            unset($this->actividades[$index]);
            $this->actividades = array_values($this->actividades);
        }
    }

    public function guardar()
    {
        $this->validate();
        if ($this->rq->motivo == 'Nueva creación') {
            $this->rq->conocimientos = $this->conocimientos;
            $this->rq->competencias = $this->competencias;
            $this->rq->actividades = $this->actividades;
            $this->rq->puesto_solicitado = null;
        } else {

            $this->rq->puesto_nuevo = null;
            $this->rq->conocimientos = null;
            $this->rq->competencias = null;
            $this->rq->actividades = null;
        }

        try {
            DB::beginTransaction();
            $this->rq->save();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Solicitud',
                    $description = 'Se ha enviado la solicitud'
                );
                $jefe = $this->rq->solicitante->jefe->id;
                if ($jefe !== 106) {
                    $this->rq->status()->transitionTo('en revisión por jefe directo');
                } else {
                    $this->rq->status()->transitionTo('en revisión por dirección general');
                }
                return redirect()->route('perfil.requisiciones.personal.index');
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
