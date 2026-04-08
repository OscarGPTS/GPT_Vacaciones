<?php

namespace App\Http\Controllers\Perfil\RequisicionPersonal;

use Illuminate\Http\Request;
use App\Models\RequisicionPersonal;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SolicitarController extends Controller
{
    public function index()
    {
        $requisiciones = RequisicionPersonal::with('puesto')
            ->orderBy('id', 'desc')
            ->where('solicitante_id', Auth::user()->id)
            ->get();
        return view('perfil.requisiciones_personal.index')
            ->with('requisiciones', $requisiciones);
    }

    public function create()
    {
        return view('perfil.requisiciones_personal.create');
    }

    public function show($rq_id)
    {
        $requisicion = RequisicionPersonal::with(['solicitante', 'puesto'])
            ->where('id', $rq_id)
            ->where('solicitante_id', Auth::user()->id)
            ->firstOrFail();
        $history = $requisicion->status()->history()->get();
        return  view('perfil.requisiciones_personal.show')
            ->with([
                'requisicion' => $requisicion,
                'history' => $history
            ]);
    }
}
