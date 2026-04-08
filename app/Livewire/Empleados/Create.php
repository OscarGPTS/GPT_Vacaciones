<?php

namespace App\Livewire\Empleados;

use Exception;
use App\Models\Job;
use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\RazonSocial;
use Illuminate\Support\Str;
use App\Models\PersonalData;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Services\Rrhh\UserSaveService;

class Create extends Component
{
    use WithFileUploads;
    use Actions;

    public $empleado, $personalData;

    public $view = 'create', $puestos, $puestoId, $puesto, $razonSocial, $empleados;
    public function mount()
    {

        if ($this->view == 'create') {
            $this->empleado = new User();
            $this->empleado->active = 1;
            $this->personalData = new PersonalData();
        } else {
            $this->empleado = User::with(['job', 'jefe', 'razonSocial', 'personalData'])->find($this->empleado);
            $this->puestoId = $this->empleado->job_id;
            $this->personalData = $this->empleado->personalData;
            $this->updatedPuestoId();
        }
        $this->puestos = Job::all();
        $this->razonSocial = RazonSocial::all();
        $this->empleados = User::all();
    }

    protected function  rules()
    {
        $reglas = [
            'empleado.last_name' => 'required',
            'empleado.first_name' => 'required',
            'empleado.business_name_id' => 'required',
            'empleado.admission' => 'required',
            'puestoId' => 'required',
            'empleado.boss_id' => 'required',
            'empleado.email' => 'nullable',
            'empleado.phone' => 'nullable',
            'empleado.active' => 'required',
            'empleado.escolaridad' => 'nullable',
            'empleado.escolaridad_nombre' => 'nullable',
            'empleado.cedula' => 'nullable',
            'empleado.libreta_mar' => 'nullable',

            'personalData.birthday' => 'required',
            'personalData.curp' => 'required',
            'personalData.rfc' => 'nullable',
            'personalData.nss' => 'required',
            'personalData.personal_mail' => 'nullable',
            'personalData.personal_phone' => 'nullable',
            'personalData.user_id' => 'nullable',
        ];
        if ($this->view == 'create') {
            $regla = ['empleado.id' => 'required|unique:App\Models\User,id'];
            $reglas = array_merge($reglas, $regla);
        }


        return $reglas;
    }

    protected $messages = [
        'empleado_id.required' => 'Debe ingresar un numero de empleado',
        'empleado_id.unique' => 'El numero de empleado ingresado ya existe',
        'empleado.curp.required' => 'Este campo no puede estar vacío',
        'empleado.nss.required' => 'Este campo no puede estar vacío',
        'empleado.last_name.required' => 'Este campo no puede estar vacío',
        'empleado.first_name.required' => 'Este campo no puede estar vacío',
        'empleado.business_name_id.required' => 'Este campo no puede estar vacío',
        'empleado.admission.required' => 'Este campo no puede estar vacío',
        'puestoId.required' => 'Este campo no puede estar vacío',
        'empleado.boss_id.required' => 'Este campo no puede estar vacío',
    ];
    public function render()
    {
        return view('livewire.empleados.create');
    }

    public function guardar()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            if ($this->empleado->escolaridad !== 'Licenciatura') {
                $this->empleado->cedula = '';
                $this->empleado->escolaridad_nombre = '';
            }
            $this->empleado->uuid = Str::uuid();
            $this->empleado->job_id = $this->puestoId;
            $this->empleado->save();
            $this->personalData->user_id = $this->empleado->id;
            $this->personalData->save();
            DB::afterCommit(function () {
                $userService = new UserSaveService($this->empleado);
                $userService->sincronizarTodo();
                if ($this->view == 'create') {
                    return $this->redirect(route('empleados.index'));
                } else {
                    $this->notification()->success(
                        $title = 'Empleado',
                        $description = 'Información guardada'
                    );
                }
            });
            DB::commit();
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            DB::rollback();
        }
    }
    public function updatedPuestoId()
    {
        $this->puesto = Job::with('departamento', 'departamento.area')->find($this->puestoId);
    }
}
