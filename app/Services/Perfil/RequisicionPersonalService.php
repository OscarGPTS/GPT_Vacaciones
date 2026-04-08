<?php
namespace App\Services\Perfil;

use App\Models\RequisicionPersonal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RequisicionPersonalService
{

 public function crearRequisicionPuestoActual($request)
 {

    if(!isset($request->trabajoCampo))
    {
        $request->trabajoCampo = 0;
    }

    if(!isset($request->tratoClientes))
    {
        $request->tratoClientes = 0;
    }

    if(!isset($request->manejoPersonal))
    {
        $request->manejoPersonal = 0;
    }

    if(!isset($request->manejoPersonal))
    {
        $request->manejoPersonal = 0;
    }

    if(!isset($request->licencia))
    {
        $request->licencia = 0;
        $request->licenciaTipo = '';
    }



  $nuevaRequisicion = RequisicionPersonal::create(
   [
    'token_url' => Str::uuid()->toString(),
    'tipo_personal' => $request->tipoPersonal,
    'motivo' => $request->motivo,
    'horario' => $request->horario,
    'personas_requeridas' => $request->personasRequeridad,
    'grado_escolar' => $request->gradoEstudios,
    'experiencia_years' => $request->experiencia,
    'trabajo_campo' => $request->trabajoCampo,
    'trato_clientes' => $request->tratoClientes,
    'licencia_conducir' => $request->licencia,
    'licencia_tipo' => $request->licenciaTipo,
    'manejo_personal' => $request->manejoPersonal,
    'estatus' => 1,
    'puesto_solicitado' => $request->puesto,
    'solicitante_id' => Auth::user()->id,
   ]
  );
  return $nuevaRequisicion;
 }

}
