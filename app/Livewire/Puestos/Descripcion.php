<?php

namespace App\Livewire\Puestos;

use Exception;
use App\Models\Job;
use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Departamento;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;


class Descripcion extends Component
{
    use WithFileUploads;
    use Actions;
    public $users;
    public $errors;
    public Job $puesto;
    public $departamentos, $puestos;

    public $firmaElaboro, $userElaboro, $firmaReviso, $userReviso, $firmaAutorizo, $userAutorizo;
    public $imgElaboro, $imgReviso, $imgAutorizo;
    public $conocimientos;
    // Reglas
    protected  $rules = [
        'puesto.name' => 'nullabled',
        'puesto.departamento.area.name' => 'nullabled',
        'puesto.depto_id' => 'nullabled',
        'puesto.objetivo' => 'nullabled',
        'puesto.responsabilidad.*' => 'nullabled',
        'puesto.responsabilidad.*.nombre' => 'nullabled',
        'puesto.responsabilidad.*.tipo' => 'nullabled',
        'puesto.responsabilidad.*.compartida_con' => 'nullabled',
        'puesto.funciones.*' => 'nullabled',
        'puesto.clasificacion' => 'nullabled',
        'puesto.relaciones_internas.*.depto' => 'nullabled',
        'puesto.relaciones_internas.*.actividad' => 'nullabled',
        'puesto.relaciones_externas.*.empresa' => 'nullabled',
        'puesto.relaciones_externas.*.motivo' => 'nullabled',
        'puesto.personal_cargo.*.puesto' => 'nullabled',
        'puesto.personal_cargo.*.actividad' => 'nullabled',
        'puesto.plan_contingencia.reemplaza' => 'nullabled',
        'puesto.plan_contingencia.reemplazo' => 'nullabled',
        'puesto.desarrollo.a' => 'nullabled',
        'puesto.desarrollo.b' => 'nullabled',
        'puesto.ambiente.lugar_trabajo' => 'nullabled',
        'puesto.ambiente.horario_trabajo' => 'nullabled',
        'puesto.ambiente.tiempo_comida' => 'nullabled',
        'puesto.ambiente.lunes' => 'nullabled',
        'puesto.ambiente.martes' => 'nullabled',
        'puesto.ambiente.miercoles' => 'nullabled',
        'puesto.ambiente.jueves' => 'nullabled',
        'puesto.ambiente.viernes' => 'nullabled',
        'puesto.ambiente.sabado' => 'nullabled',
        'puesto.ambiente.domingo' => 'nullabled',
        'puesto.requisitos.edad' => 'nullabled',
        'puesto.requisitos.genero' => 'nullabled',
        'puesto.requisitos.educacion' => 'nullabled',
        'puesto.requisitos.experiencia' => 'nullabled',
        'puesto.requisitos.tipo_experiencia' => 'nullabled',
        'puesto.requisitos.cursos' => 'nullabled',
        'puesto.requisitos.herramientas' => 'nullabled',
        'puesto.requisitos.maquinaria' => 'nullabled',
        'puesto.requisitos.condiciones_especiales' => 'nullabled',
        'conocimientos.*.descripcion' => 'nullabled',
        'puesto.responsabilidad_sgi' => 'nullabled',
    ];
    protected  $messages = [
        'puesto.name.required' => 'Este campo no puede estar vacio',
        'puesto.departamento.area.name.required' => 'Este campo no puede estar vacio',
        'puesto.depto_id.required' => 'Este campo no puede estar vacio',
        'puesto.objetivo.required' => 'Este campo no puede estar vacio',
        'puesto.responsabilidad.*.required' => 'Este campo no puede estar vacio',
        'puesto.responsabilidad.*.nombre.required' => 'Este campo no puede estar vacio',
        'puesto.responsabilidad.*.tipo.required' => 'Este campo no puede estar vacio',
        'puesto.responsabilidad.*.compartida_con.required' => 'Este campo no puede estar vacio',
        'puesto.funciones.*.required' => 'Este campo no puede estar vacio',
        'puesto.clasificacion.required' => 'Este campo no puede estar vacio',
        'puesto.relaciones_internas.*.depto.required' => 'Este campo no puede estar vacio',
        'puesto.relaciones_internas.*.actividad.required' => 'Este campo no puede estar vacio',
        'puesto.relaciones_externas.*.empresa.required' => 'Este campo no puede estar vacio',
        'puesto.relaciones_externas.*.motivo.required' => 'Este campo no puede estar vacio',
        'puesto.personal_cargo.*.puesto.required' => 'Este campo no puede estar vacio',
        'puesto.personal_cargo.*.actividad.required' => 'Este campo no puede estar vacio',
        'puesto.plan_contingencia.reemplaza.required' => 'Este campo no puede estar vacio',
        'puesto.plan_contingencia.reemplazo.required' => 'Este campo no puede estar vacio',
        'puesto.desarrollo.a.required' => 'Este campo no puede estar vacio',
        'puesto.desarrollo.b.required' => 'Este campo no puede estar vacio',
        'puesto.ambiente.lugar_trabajo.required' => 'Este campo no puede estar vacio',
        'puesto.ambiente.horario_trabajo.required' => 'Este campo no puede estar vacio',
        'puesto.ambiente.tiempo_comida.required' => 'Este campo no puede estar vacio',
        'puesto.requisitos.edad.required' => 'Este campo no puede estar vacio',
        'puesto.requisitos.genero.required' => 'Este campo no puede estar vacio',
        'puesto.requisitos.educacion.required' => 'Este campo no puede estar vacio',
        'puesto.requisitos.experiencia.required' => 'Este campo no puede estar vacio',
        'puesto.requisitos.tipo_experiencia.required' => 'Este campo no puede estar vacio',
        'puesto.requisitos.cursos.required' => 'Este campo no puede estar vacio',
        'puesto.requisitos.herramientas.required' => 'Este campo no puede estar vacio',
        'puesto.requisitos.maquinaria.required' => 'Este campo no puede estar vacio',
        'puesto.requisitos.condiciones_especiales.required' => 'Este campo no puede estar vacio',
        'puesto.requisitos.conocimiento.*.required' => 'Este campo no puede estar vacio',


        'puesto.responsabilidad_sgi.required' => 'Este campo no puede estar vacio',
        'firmaElaboro.required' => 'Este campo no puede estar vacio',
        'userElaboro.required' => 'Este campo no puede estar vacio',
    ];

    public function mount(Job $puesto)
    {
        $this->users = User::all();
        $this->puesto->load(['departamento.area', 'conocimiento']);
        if (blank($this->puesto->responsabilidad)) {
            $this->puesto->responsabilidad = [['nombre' => '', 'tipo' => 'total', 'compartida_con' => '']];
        }
        if (empty($this->puesto->relaciones_internas)) {
            $this->puesto->relaciones_internas = [['depto' => '', 'actividad' => '']];
        }
        if (empty($this->puesto->personal_cargo)) {
            $this->puesto->personal_cargo = [['puesto' => '', 'actividad' => '']];
        }
        if (blank($puesto->plan_contingencia)) {
            $this->puesto->plan_contingencia = ['reemplaza' => '', 'reemplazo' => ''];
        }
        if (blank($puesto->desarrollo)) {
            $this->puesto->desarrollo = ['a' => '', 'b' => ''];
        }
        if (blank($puesto->ambiente)) {
            $this->puesto->ambiente = ['lugar_trabajo' => '', 'horario_trabajo' => '', 'tiempo_comida' => ''];
        }
        if (blank($puesto->requisitos)) {
            $this->puesto->requisitos = ['edad' => '', 'genero' => '', 'educacion' => '', 'experiencia' => '', 'tipo_experiencia' => '', 'cursos' => '', 'herramientas' => '', 'maquinaria' => '', 'condiciones_especiales' => ''];
        }

        $this->conocimientos = $this->puesto->conocimiento;

        $this->puesto->responsabilidad_sgi = 'Conocer y cumplir los lineamientos de los sistemas de gestión, así como las políticas, procedimientos, formatos, etc., referentes a la actividad, a fin de contribuir a la mejora continua.';
        if ($this->puesto->conocimiento->isEmpty()) {
            $this->crearConicimientos();
        }
        $this->departamentos = Departamento::with('area')->get();
        $this->puesto = $puesto;
        if (empty($this->puesto->ambiente)) {
            $this->puesto->ambiente = [];
        }
        if (empty($this->puesto->requisitos)) {
            $this->puesto->requisitos = [];
        }
        $this->puestos = Job::all();
        $this->obtenerImgs();
    }
    public function render()
    {
        return view('livewire.puestos.descripcion');
    }


    public function updatedPuestoArea()
    {
        $this->puesto->departamento = '';
    }
    public function nuevaResponsabilidad()
    {
        if (empty($this->puesto->responsabilidad)) {
            $this->puesto->responsabilidad = [['nombre' => '', 'tipo' => 'total', 'compartida_con' => '']];
        } else {
            $array = $this->puesto->responsabilidad;
            array_push($array, ['nombre' => '', 'tipo' => 'total', 'compartida_con' => '']);
            $this->puesto->responsabilidad = $array;
        }
    }
    public function borrarResponsabilidad($index)
    {
        $array = $this->puesto->responsabilidad;
        unset($array[$index]);
        $this->puesto->responsabilidad = array_values($array);
    }

    public function nuevaFuncion()
    {
        if (empty($this->puesto->funciones)) {
            $this->puesto->funciones = [''];
        } else {
            $this->puesto->funciones =  array_merge($this->puesto->funciones, ['']);
        }
    }
    public function nuevaRelacionInterna()
    {
        if (empty($this->puesto->relaciones_internas)) {
            $this->puesto->relaciones_internas = [['depto' => '', 'actividad' => '']];
        } else {
            $array = $this->puesto->relaciones_internas;
            array_push($array, ['depto' => '', 'actividad' => '']);
            $this->puesto->relaciones_internas = $array;
        }
    }
    public function nuevaRelacionExterna()
    {
        if (empty($this->puesto->relaciones_externas)) {
            $this->puesto->relaciones_externas = [['empresa' => '', 'motivo' => '']];
        } else {
            $array = $this->puesto->relaciones_externas;
            array_push($array, ['empresa' => '', 'motivo' => '']);
            $this->puesto->relaciones_externas = $array;
        }
    }
    public function nuevoPersonal()
    {
        if (empty($this->puesto->personal_cargo)) {
            $this->puesto->personal_cargo = [['puesto' => '', 'actividad' => '']];
        } else {
            $array = $this->puesto->personal_cargo;
            array_push($array, ['puesto' => '', 'actividad' => '']);
            $this->puesto->personal_cargo = $array;
        }
    }
    public function borrarFuncion($index)
    {
        $funciones = $this->puesto->funciones;
        unset($funciones[$index]);
        $this->puesto->funciones = array_values($funciones);
    }
    public function borrarRelacionInterna($index)
    {
        $array = $this->puesto->relaciones_internas;
        unset($array[$index]);
        $this->puesto->relaciones_internas = array_values($array);
    }
    public function borrarRelacionExterna($index)
    {
        $array = $this->puesto->relaciones_externas;
        unset($array[$index]);
        $this->puesto->relaciones_externas = array_values($array);
    }
    public function borrarPersonal($index)
    {
        $array = $this->puesto->personal_cargo;
        unset($array[$index]);
        $this->puesto->personal_cargo = array_values($array);
    }
    public function guardar_1_1()
    {
        $this->validate([
            'puesto.name' => 'required',
            'puesto.depto_id' => 'required',
        ]);

        $this->guardar();
    }
    public function guardar_1_2()
    {
        $this->validate([
            'puesto.objetivo' => 'required',
        ]);
        $this->guardar();
    }
    public function guardar_1_3()
    {
        $this->validate([
            'puesto.responsabilidad.*.nombre' => 'required',
            'puesto.responsabilidad.*.tipo' => 'required',
            'puesto.responsabilidad.*.compartida_con' => 'required_if:puesto.responsabilidad.*.tipo,compartida',
            'puesto.funciones.*' => 'required',
        ]);
        $this->guardar();
    }
    public function guardar_1_4()
    {
        $this->validate([
            'puesto.clasificacion' => 'required',
        ]);
        $this->guardar();
    }
    public function guardar_1_5()
    {
        $this->validate([
            'puesto.relaciones_internas.*.depto' => 'required',
            'puesto.relaciones_internas.*.actividad' => 'required',
        ]);
        $this->guardar();
    }
    public function guardar_1_6()
    {
        $this->validate([
            'puesto.relaciones_externas.*.empresa' => 'required',
            'puesto.relaciones_externas.*.motivo' => 'required',
        ]);
        $this->guardar();
    }
    public function guardar_1_7()
    {
        $this->validate([
            'puesto.personal_cargo.*.puesto' => 'required',
            'puesto.personal_cargo.*.actividad' => 'required',
        ]);
        $this->guardar();
    }
    public function guardar_1_8()
    {
        $this->guardar();
    }
    public function guardar_1_9()
    {
        $this->guardar();
    }
    public function guardar_2_0()
    {
        $this->validate([
            'puesto.ambiente.lugar_trabajo' => 'required',
            'puesto.ambiente.horario_trabajo' => 'required',
            'puesto.ambiente.tiempo_comida' => 'required',
        ]);
        $this->guardar();
    }
    public function guardar_2_1()
    {
        $this->validate([
            'puesto.requisitos.edad' => 'required',
            'puesto.requisitos.genero' => 'required',
            'puesto.requisitos.educacion' => 'required',
            'puesto.requisitos.experiencia' => 'required',
            'puesto.requisitos.tipo_experiencia' => 'required',
            'puesto.requisitos.cursos' => 'required',
            'puesto.requisitos.herramientas' => 'required',
            'puesto.requisitos.maquinaria' => 'required',
            'puesto.requisitos.condiciones_especiales' => 'required',
            'conocimientos.*.descripcion' => 'required',
        ]);


        try {
            DB::beginTransaction();
            $this->conocimientos->each(fn ($conocimiento) => $conocimiento->save());
            DB::commit();
            DB::afterCommit(function () {
                $this->guardar();
            });
        } catch (Exception $e) {
            DB::rollBack();
            $this->notification()->error(
                $title = 'Puesto',
                $description = 'Ocurrio un error al guardar la información'
            );
            logger()->error($e->getMessage());
        }
    }
    public function guardar_2_3()
    {
        $this->validate([
            'puesto.responsabilidad_sgi' => 'required',
        ]);
        $this->guardar();
    }

    public function guardar()
    {
        try {
            DB::beginTransaction();
            $this->puesto->save();
            DB::commit();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Puesto',
                    $description = 'Información guardada con éxito'
                );
                $this->puesto->load('departamento.area');
            });
        } catch (Exception $e) {
            DB::rollBack();
            $this->notification()->error(
                $title = 'Puesto',
                $description = 'Ocurrio un error al guardar la información'
            );
            logger()->error($e->getMessage());
        }
    }

    public function obtenerImgs()
    {
        $this->imgElaboro = $this->puesto->getMedia('firma-elaboro-descriptivo-puesto');
        $this->imgReviso = $this->puesto->getMedia('firma-reviso-descriptivo-puesto');
        $this->imgAutorizo = $this->puesto->getMedia('firma-autorizo-descriptivo-puesto');
    }
    public function guardarFirmaElaboro()
    {
        $this->validate([
            'userElaboro' => 'required',
            'firmaElaboro' => 'required|image|mimes:jpg,png,jpeg',
        ]);

        $user = $this->users->firstWhere('id', $this->userElaboro);
        try {
            DB::beginTransaction();
            $this->puesto
                ->addMedia($this->firmaElaboro->getRealPath())
                ->usingName($user->nombre())
                ->withCustomProperties(['nombre' => $user->nombre(), 'area' => $user->job->departamento->area->name])
                ->toMediaCollection('firma-elaboro-descriptivo-puesto', 'firmas');
            DB::commit();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Puesto',
                    $description = 'Firma guardada con éxito'
                );
                return redirect(request()->header('Referer'));
            });
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification()->error(
                $title = 'Puesto',
                $description = 'Ocurrio un error al guardar la información'
            );
            logger()->error($e->getMessage());
            $this->firmaElaboro->delete();
            throw $e;
        }
    }
    public function guardarFirmaReviso()
    {
        $this->validate([
            'userReviso' => 'required',
            'firmaReviso' => 'required|image|mimes:jpg,png,jpeg',
        ]);

        $user = $this->users->firstWhere('id', $this->userReviso);
        try {
            DB::beginTransaction();
            $this->puesto
                ->addMedia($this->firmaReviso->getRealPath())
                ->usingName($user->nombre())
                ->withCustomProperties(['nombre' => $user->nombre(), 'area' => $user->job->departamento->area->name])
                ->toMediaCollection('firma-reviso-descriptivo-puesto', 'firmas');
            DB::commit();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Puesto',
                    $description = 'Firma guardada con éxito'
                );
            });
            $this->obtenerImgs();

            // $this->reset(['nombre', 'file']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification()->error(
                $title = 'Puesto',
                $description = 'Ocurrio un error al guardar la información'
            );
            logger()->error($e->getMessage());
            $this->firmaReviso->delete();
            throw $e;
        }
    }
    public function guardarFirmaAutorizo()
    {
        $this->validate([
            'userAutorizo' => 'required',
            'firmaAutorizo' => 'required|image|mimes:jpg,png,jpeg',
        ]);

        $user = $this->users->firstWhere('id', $this->userAutorizo);
        try {
            DB::beginTransaction();
            $this->puesto
                ->addMedia($this->firmaAutorizo->getRealPath())
                ->usingName($user->nombre())
                ->withCustomProperties(['nombre' => $user->nombre(), 'area' => $user->job->departamento->area->name])
                ->toMediaCollection('firma-autorizo-descriptivo-puesto', 'firmas');
            DB::commit();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Puesto',
                    $description = 'Firma guardada con éxito'
                );
            });

            $this->obtenerImgs();
            // $this->reset(['nombre', 'file']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification()->error(
                $title = 'Puesto',
                $description = 'Ocurrio un error al guardar la información'
            );
            logger()->error($e->getMessage());
            $this->firmaAutorizo->delete();
            throw $e;
        }
    }

    public function crearConicimientos()
    {
        $this->puesto->conocimiento()->createMany([
            ['descripcion' => 'Sin llenar'],
            ['descripcion' => 'Sin llenar'],
            ['descripcion' => 'Sin llenar'],
            ['descripcion' => 'Sin llenar'],
            ['descripcion' => 'Sin llenar'],
            ['descripcion' => 'Sin llenar'],
            ['descripcion' => 'Sin llenar'],
            ['descripcion' => 'Sin llenar'],
        ]);
    }
}
