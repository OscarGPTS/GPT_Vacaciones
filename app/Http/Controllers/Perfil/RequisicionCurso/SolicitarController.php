<?php

namespace App\Http\Controllers\Perfil\RequisicionCurso;

use Illuminate\Http\Request;
use App\Models\RequisicionCurso;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SolicitarController extends Controller
{
    public function index()
    {
        $requisiciones = RequisicionCurso::whereHas('participantes', function ($query) {
            $query->where('rol', 'solicitante')
            ->where('user_id',Auth::user()->id);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        // dd($requisiciones);
        return view('perfil.requisiciones_curso.solicita.index')
        ->with('requisiciones',$requisiciones);
    }

    public function show($rq_id)
    {
        $requisicion = RequisicionCurso::with(['participantes'])->findOrFail($rq_id);

        $solicitante = $requisicion->participantes()->wherePivot('rol', 'solicitante')->first();
        $participantes = $requisicion->participantes->whereNotIn('id',[$solicitante->id]);

        // $temario = $requisicion->getMedia('temario')->first();
        // dd($temario);
        return  view('perfil.requisiciones_curso.solicita.show')
            ->with([
                'requisicion' => $requisicion,
                'solicitante' => $solicitante,
                'participantes' => $participantes
            ]);
    }
}
