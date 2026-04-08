<?php

namespace App\Http\Controllers\Rrhh;

use Illuminate\Http\Request;
use App\Models\RequisicionCurso;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class RequisicionCursoController extends Controller
{
    public function index()
    {
        $requisiciones = RequisicionCurso::orderBy('created_at', 'desc')->get();
        return view('rrhh.requisiciones_curso.index')
            ->with('requisiciones', $requisiciones);
    }
    public function show($id)
    {
        $requisicion = RequisicionCurso::with('participantes')->findOrFail($id);
        $solicitante = $requisicion->participantes()->wherePivot('rol', 'solicitante')->first();
        $participantes = $requisicion->participantes;
        return view('rrhh.requisiciones_curso.show')
            ->with(['requisicion' => $requisicion, 'solicitante' => $solicitante, 'participantes' => $participantes]);
    }
    public function cerrar($id)
    {
        $requisicion = RequisicionCurso::with('participantes')->findOrFail($id);
        if ($requisicion->status()->canBe('Cerrada')) {
            $requisicion->status()->transitionTo('Cerrada');
        }
        return redirect()->to(route('rrhh.requisiciones.curso.show', $requisicion->id));
    }
    public function pdf($id)
    {
        $requisicion = RequisicionCurso::with('participantes')->findOrFail($id);
        $solicitante = $requisicion->participantes()->wherePivot('rol', 'solicitante')->first();
        $participantes = $requisicion->participantes;

        $pdf = PDF::loadView('rrhh.requisiciones_curso.pdf', compact('requisicion', 'solicitante', 'participantes'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('solicitud de curso.pdf');


        return view('rrhh.requisiciones_curso.pdf')
            ->with(['requisicion' => $requisicion, 'solicitante' => $solicitante, 'participantes' => $participantes]);
    }
}
