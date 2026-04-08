<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use App\Models\User;

class EmpleadoAniversarioController extends Controller
{
 public function existeAniversario()
 {

  $fechaHoy = now();

  $empleados = User::select('last_name', 'first_name', 'admission', 'email')
   ->whereMonth('admission', $fechaHoy)
   ->whereDay('admission', $fechaHoy)
   ->get();

  if ($empleados->count() <= 0) {
   return response()->json([
    'code' => '404',
    'mensaje' => 'No hay aniversarios para este dia',
   ]);
  }

  foreach ($empleados as $empleado) {
   $aniversario = $fechaHoy->diffInYears($empleado->admission);
   $empleado->aniversario = $aniversario;
   $empleado->imagen  = obtenerImagenAniversario($aniversario);
  }

  return response()->json([
   'empleados' => $empleados,
  ]);

 }
}
