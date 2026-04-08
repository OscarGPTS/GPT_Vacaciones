<?php

namespace App\Http\Controllers\Perfil\RequisicionPersonal;

use Illuminate\Http\Request;
use App\Models\RequisicionPersonal;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RevisarController extends Controller
{
    public function index()
    {

        $subordinados = Auth::user()->subordinados->pluck('id');

        $requisiciones = RequisicionPersonal::whereIn('solicitante_id', $subordinados)
            ->orderBy('id', 'desc')
            ->get();

        return view('perfil.requisiciones_personal.revisar.index')
            ->with('requisiciones', $requisiciones);
    }
    public function show($rq_id)
    {
        // $this->authorize('revisar', $rq_id);
        $requisicion = RequisicionPersonal::with(['solicitante', 'puesto'])
            ->where('id', $rq_id)
            ->firstOrFail();

        return view('perfil.requisiciones_personal.revisar.show')
            ->with('requisicion', $requisicion);
    }
}
