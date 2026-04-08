<?php

namespace App\Livewire\RequisicionCurso;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\RequisicionCurso;
use App\Services\Perfil\RqCursoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreateComponent extends Component
{
    use WithFileUploads;

    public $users, $cotizacion = 'No', $cotizacionFile, $temarioFile;
    public $nombreCurso, $tipoCapacitacion, $justificacion, $motivo, $beneficio, $comentarios, $participantes = [];
    protected function rules()
    {
        if ($this->cotizacion == 'Si') {
            return  [
                'nombreCurso' => 'required',
                'tipoCapacitacion' => 'required',
                'justificacion' => 'required',
                'motivo' => 'required',
                'beneficio' => 'required',
                'comentarios' => 'required',
                'cotizacion' => 'required',
                'participantes' => 'nullable',
                'cotizacionFile' => 'file|mimes:pdf|max:1000',
                'temarioFile' => 'file|mimes:pdf|max:1000'
            ];
        } else {
            return  [
                'nombreCurso' => 'required',
                'tipoCapacitacion' => 'required',
                'justificacion' => 'required',
                'cotizacion' => 'required',
                'motivo' => 'required',
                'beneficio' => 'required',
                'comentarios' => 'required',
                'participantes' => 'nullable',
            ];
        }
    }
    protected $messages =  [
        'nombreCurso.required' => 'Este campo no puede estar vacío',
        'tipoCapacitacion.required' => 'Este campo no puede estar vacío',
        'justificacion.required' => 'Este campo no puede estar vacío',
        'motivo.required' => 'Este campo no puede estar vacío',
        'beneficio.required' => 'Este campo no puede estar vacío',
        'comentarios.required' => 'Este campo no puede estar vacío',
        'cotizacion.required' => 'Debe seleccionar una opción',
        'cotizacionFile.mimes' => 'El archivo debe ser PDF',
        'temarioFile.mimes' => 'El archivo debe ser PDF',
        'cotizacionFile.file' => 'Debe cargar una cotización',
        'cotizacionFile.max' => 'El archivo no puede superar 1 MB',
        'temarioFile.file' => 'Debe cargar un temario',
        'temarioFile.max' => 'El archivo no puede superar 1 MB',
    ];
    public function mount()
    {
        $this->users = User::where('active', 1)->get()->except(Auth::id());
    }
    public function render()
    {
        return view('livewire.requisicion-curso.create-component');
    }
    public function guardar()
    {

        $this->validate();
        try {
            DB::beginTransaction();
            $rq = RequisicionCurso::create([
                'nombre' => $this->nombreCurso,
                'tipo_capacitacion' => $this->tipoCapacitacion,
                'justificacion' => $this->justificacion,
                'motivo' => $this->motivo,
                'beneficio' => $this->beneficio,
                'comentarios' => $this->comentarios,
            ]);
            if ($this->cotizacion == 'Si') {
                // guardar los PDF de la cotizacion y temario
                $rq
                    ->addMedia($this->cotizacionFile->getRealPath())
                    ->toMediaCollection('cotizacion');
                $rq
                    ->addMedia($this->temarioFile->getRealPath())
                    ->toMediaCollection('temario');
            }

            if (filled($this->participantes)) {
                $rq->participantes()->attach($this->participantes);
            }
            $rq->participantes()->attach(Auth::user()->id, ['rol' => 'solicitante']);
            DB::afterCommit(function () use ($rq) {
                // Se debe enviqr notificacion al siguiente
                // app('flasher')->addSuccess('Your account has been re-activated.');

                $rqService = new RqCursoService(Auth::user(), $rq);
                $rqService->notificacionNuevaRq();
                return redirect()->route('requisiciones.curso.index');
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
