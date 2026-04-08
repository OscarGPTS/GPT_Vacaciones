<?php

namespace App\Http\Controllers\Perfil\RequisicionCurso;

use Illuminate\Http\Request;
use App\Models\RequisicionPersonal;
use App\Http\Controllers\Controller;

class AutorizarController extends Controller
{
    // public function index()
    // {
    //     $requisiciones = RequisicionPersonal::with(['solicitante'])
    //     ->whereIn('status',['en revisión por dirección general','rechazada por dirección general', 'en reclutamiento', 'finalizada'])
    //     ->orderBy('id', 'desc')
    //     ->get();
    //     return view('perfil.requisiciones_personal.autorizar.index')
    //         ->with('requisiciones', $requisiciones);
    // }
    // public function show($rq_id)
    // {
    //     $requisicion = RequisicionPersonal::with(['solicitante', 'puesto'])
    //         ->where('id', $rq_id)
    //         ->firstOrFail();


    //     return view('perfil.requisiciones_personal.autorizar.show')
    //         ->with('requisicion', $requisicion);
    // }
}
