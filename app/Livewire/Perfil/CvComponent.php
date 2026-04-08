<?php

namespace App\Livewire\Perfil;

use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use App\Models\CvExperiencia;
use Illuminate\Support\Facades\DB;
use App\Models\CvHistorialServicio;
use App\Models\CvCursoCertificacion;
use App\Models\CvCursoSoldadura;
use Illuminate\Support\Facades\Auth;

class CvComponent extends Component
{
    use Actions;
    use WithPagination;
    public $otroCv = false, $editRrhh = false;
    public $user, $cv, $itemExperiencia, $itemCurso, $itemHistorial, $itemCursoSoldadura, $formato;
    public $experienciaModal = false, $cursoModalInterno = false, $cursoModalExterno = false, $historialServicioModal = false, $cursoModalSoldadura = false;
    public $cursosInternos, $cursosExternos, $cursosSoldadura;
    public $users_soldadura = [14, 26, 89, 99, 131,299,318];

    protected $rules = [
        'itemExperiencia.fecha_inicio' => 'nullable',
        'itemExperiencia.fecha_final' => 'nullable',
        'itemExperiencia.actualmente_laborando' => 'nullable',
        'itemExperiencia.puesto' => 'nullable',

        'itemCurso.nombre' => 'nullable',
        'itemCurso.tipo' => 'nullable',
        'itemCurso.year' => 'nullable',

        'itemCursoSoldadura.nombre' => 'nullable',
        'itemCursoSoldadura.proceso' => 'nullable',
        'itemCursoSoldadura.wps' => 'nullable',
        'itemCursoSoldadura.desde' => 'nullable',
        'itemCursoSoldadura.hasta' => 'nullable',

        'itemHistorial.cliente' => 'nullable',
        'itemHistorial.year' => 'nullable',
        'itemHistorial.ubicacion' => 'nullable',
        'itemHistorial.cabezal' => 'nullable',
        'itemHistorial.ramal' => 'nullable',
        'itemHistorial.clase' => 'nullable',
        'itemHistorial.servicio' => 'nullable',
        'itemHistorial.alcance' => 'nullable',
        'itemHistorial.mes' => 'nullable',
    ];
    public function mount()
    {
        if (!$this->otroCv && !$this->editRrhh) {
            $this->user = Auth::user();
        }
        $this->user->load(['cvExperiencia' => fn ($query) => $query->orderBy('fecha_inicio', 'desc'), 'cvHistorialServicio' => fn ($query) => $query->orderBy('year', 'desc')->orderBy('created_at', 'desc'), 'cvCursoCertificacion', 'cvCursoSoldadura']);

        $this->cursosInternos = $this->user->cvCursoCertificacion->where('tipo', 'interno')->sortByDesc('year');

        $this->cursosExternos = $this->user->cvCursoCertificacion->where('tipo', 'externo');
        $this->cursosSoldadura = $this->user->cvCursoSoldadura;



        $this->formato = $this->user->cvFormatoTipo();
        $this->itemExperiencia = new CvExperiencia();
        $this->itemExperiencia->actualmente_laborando = false;

        $this->itemCurso = new CvCursoCertificacion();
        $this->itemCursoSoldadura = new CvCursoSoldadura();
        if ($this->editRrhh) {
            $this->itemCurso->tipo = 'interno';
            $this->user->load(['cvCursoCertificacion' => function ($query) {
                $query->where('tipo', 'interno');
            }]);
        } else {
            $this->itemCurso->tipo = 'externo';
            $this->user->load(['cvCursoCertificacion' => function ($query) {
                $query->where('tipo', 'externo');
            }]);
        }

        $this->itemHistorial = new CvHistorialServicio();
    }
    public function render()
    {
        return view('livewire.perfil.cv-component');
    }
    public function guardarExperiencia()
    {
        $this->validate([
            'itemExperiencia.fecha_inicio' => 'required',
            'itemExperiencia.fecha_final' => 'required_if:itemExperiencia.actualmente_laborando,false',
            'itemExperiencia.puesto' => 'required',
        ]);

        if ($this->itemExperiencia->actualmente_laborando) {
            $this->itemExperiencia->fecha_final = null;
        }
        try {
            DB::beginTransaction();
            $this->user->CvExperiencia()->updateOrCreate(['id' => $this->itemExperiencia->id], $this->itemExperiencia->toArray());
            DB::afterCommit(function () {
                $this->experienciaModal = false;
                $this->notification()->success(
                    $title = 'Experiencia',
                    $description = 'Se agregó información'
                );
                $this->itemExperiencia = new CvExperiencia();
                $this->itemExperiencia->actualmente_laborando = false;
                $this->user->load(['cvExperiencia' => fn ($query) => $query->orderBy('fecha_inicio', 'desc')
                    ->orderBy('created_at', 'asc')]);
            });
            DB::commit();
        } catch (\Exception $e) {
            $this->experienciaModal = false;
            $this->notification()->error(
                $title = 'Experiencia',
                $description = 'Ocurrió un error al guardar la información'
            );
            DB::rollBack();
        }
    }
    public function borrarExperiencia($id)
    {
        try {
            DB::beginTransaction();
            CvExperiencia::destroy($id);
            DB::afterCommit(function () {
                $this->experienciaModal = false;
                $this->notification()->success(
                    $title = 'Experiencia',
                    $description = 'Se elimino la información'
                );
                $this->user->load(['cvExperiencia' => fn ($query) => $query->orderBy('fecha_inicio', 'desc')
                    ->orderBy('created_at', 'asc')]);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function editarExperiencia($id)
    {
        $this->itemExperiencia = CvExperiencia::find($id);
        $this->experienciaModal = true;
    }

    public function crearCursoExterno()
    {
        $this->cursoModalExterno = true;
        $this->itemCurso->tipo = 'externo';
    }
    public function guardarCursoExterno()
    {
        $this->validate([
            'itemCurso.nombre' => 'required',
            'itemCurso.tipo' => 'required',
            'itemCurso.year' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $this->user->cvCursoCertificacion()->updateOrCreate(['id' => $this->itemCurso->id], $this->itemCurso->toArray());
            DB::afterCommit(function () {
                $this->cursoModalExterno = false;
                $this->notification()->success(
                    $title = 'Cursos / Certificaciones',
                    $description = 'Se agregó información'
                );
                $this->user->load(['cvCursoCertificacion']);
                $this->cursosExternos = $this->user->cvCursoCertificacion->where('tipo', 'externo');
                $this->itemCurso = new CvCursoCertificacion();
            });
            DB::commit();
        } catch (\Exception $e) {
            $this->cursoModalExterno = false;
            $this->notification()->error(
                $title = 'Cursos / Certificaciones',
                $description = 'Ocurrió un error al guardar la información'
            );
            logger()->error($e->getMessage());
            DB::rollBack();
        }
    }
    public function borrarCursoExterno($id)
    {
        try {
            DB::beginTransaction();
            CvCursoCertificacion::destroy($id);
            DB::afterCommit(function () {
                $this->cursoModalExterno = false;
                $this->notification()->success(
                    $title = 'Cursos / Certificaciones',
                    $description = 'Se elimino la información'
                );
                $this->user->load(['cvCursoCertificacion']);
                $this->cursosExternos = $this->user->cvCursoCertificacion->where('tipo', 'externo');
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function editarCursoExterno($id)
    {
        $this->itemCurso = CvCursoCertificacion::find($id);
        $this->cursoModalExterno = true;
    }

    public function crearCursoInterno()
    {
        $this->cursoModalInterno = true;
        $this->itemCurso->tipo = 'interno';
    }
    public function guardarCursoInterno()
    {
        $this->validate([
            'itemCurso.nombre' => 'required',
            'itemCurso.tipo' => 'required',
            'itemCurso.year' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $this->user->cvCursoCertificacion()->updateOrCreate(['id' => $this->itemCurso->id], $this->itemCurso->toArray());
            DB::afterCommit(function () {
                $this->cursoModalInterno = false;
                $this->notification()->success(
                    $title = 'Cursos / Certificaciones',
                    $description = 'Se agregó información'
                );
                $this->user->load(['cvCursoCertificacion']);
                $this->cursosInternos = $this->user->cvCursoCertificacion->where('tipo', 'interno');
                $this->itemCurso = new CvCursoCertificacion();
            });
            DB::commit();
        } catch (\Exception $e) {
            $this->cursoModalInterno = false;
            $this->notification()->error(
                $title = 'Cursos / Certificaciones',
                $description = 'Ocurrió un error al guardar la información'
            );
            logger()->error($e->getMessage());
            DB::rollBack();
        }
    }
    public function borrarCursoInterno($id)
    {
        try {
            DB::beginTransaction();
            CvCursoCertificacion::destroy($id);
            DB::afterCommit(function () {
                $this->cursoModalInterno = false;
                $this->notification()->success(
                    $title = 'Cursos / Certificaciones',
                    $description = 'Se elimino la información'
                );
                $this->user->load(['cvCursoCertificacion']);
                $this->cursosInternos = $this->user->cvCursoCertificacion->where('tipo', 'interno');
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function editarCursoInterno($id)
    {
        $this->itemCurso = CvCursoCertificacion::find($id);
        $this->cursoModalInterno = true;
    }

    public function guardarServicio()
    {
        $this->validate([
            'itemHistorial.cliente' => 'required',
            'itemHistorial.servicio' => 'required',
            'itemHistorial.ramal' => 'required',
            'itemHistorial.year' => 'required',
            'itemHistorial.ubicacion' => 'required',

            'itemHistorial.cabezal' => 'required_if:formato,2',
            'itemHistorial.clase' => 'required_if:formato,2',

            'itemHistorial.alcance' => 'required_if:formato,1',
            'itemHistorial.mes' => 'required_if:formato,1',
        ]);

        try {
            DB::beginTransaction();
            $this->user->cvHistorialServicio()->updateOrCreate(['id' => $this->itemHistorial->id], $this->itemHistorial->toArray());
            DB::afterCommit(function () {
                $this->historialServicioModal = false;
                $this->notification()->success(
                    $title = 'Historial de servicios',
                    $description = 'Se agregó información'
                );
                $this->itemHistorial = new CvHistorialServicio();
                $this->user->load(['cvHistorialServicio']);
            });
            DB::commit();
        } catch (\Exception $e) {
            $this->historialServicioModal = false;
            $this->notification()->error(
                $title = 'Historial de servicios',
                $description = 'Ocurrió un error al guardar la información'
            );
            logger()->error($e->getMessage());
            DB::rollBack();
        }
    }
    public function borrarServicio($id)
    {
        try {
            DB::beginTransaction();
            CvHistorialServicio::destroy($id);
            DB::afterCommit(function () {
                $this->historialServicioModal = false;
                $this->notification()->success(
                    $title = 'Historial de servicios',
                    $description = 'Se elimino la información'
                );
                $this->user->load(['cvHistorialServicio']);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function editarServicio($id)
    {
        $this->itemHistorial = CvHistorialServicio::find($id);
        $this->historialServicioModal = true;
    }



    public function crearCursoSoldadura()
    {
        $this->cursoModalSoldadura = true;
        $this->itemCurso->tipo = 'solo soldadura';
    }
    public function guardarCursoSoldadura()
    {
        $this->validate([
            'itemCursoSoldadura.nombre' => 'required',
            'itemCursoSoldadura.proceso' => 'required',
            'itemCursoSoldadura.wps' => 'nullable',
            'itemCursoSoldadura.desde' => 'required',
            'itemCursoSoldadura.hasta' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $this->user->cvCursoSoldadura()->updateOrCreate(['id' => $this->itemCursoSoldadura->id], $this->itemCursoSoldadura->toArray());
            DB::afterCommit(function () {
                $this->cursoModalSoldadura = false;
                $this->notification()->success(
                    $title = 'Cursos / Certificaciones',
                    $description = 'Se agregó información'
                );
                $this->user->load(['cvCursoSoldadura']);
                $this->cursosSoldadura = $this->user->cvCursoSoldadura;
                $this->itemCursoSoldadura = new CvCursoSoldadura();
            });
            DB::commit();
        } catch (\Exception $e) {
            $this->notification()->error(
                $title = 'Cursos / Certificaciones',
                $description = 'Ocurrió un error al guardar la información'
            );
            logger()->error($e->getMessage());
            DB::rollBack();
        }
    }
    public function borrarCursoSoldadura($id)
    {
        try {
            DB::beginTransaction();
            CvCursoSoldadura::destroy($id);
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Cursos / Certificaciones',
                    $description = 'Se elimino la información'
                );
                $this->user->load(['cvCursoSoldadura']);
                $this->cursosSoldadura = $this->user->cvCursoSoldadura;
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function editarCursoSoldadura($id)
    {
        $this->itemCursoSoldadura = CvCursoSoldadura::find($id);
        $this->cursoModalSoldadura = true;
    }
}
