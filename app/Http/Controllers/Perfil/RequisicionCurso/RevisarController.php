<?php

namespace App\Http\Controllers\Perfil\RequisicionCurso;

use Illuminate\Http\Request;
use App\Models\RequisicionCurso;
use App\Models\RequisicionPersonal;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Perfil\RqCursoService;

class RevisarController extends Controller
{
    public function index()
    {
        $rqService = new RqCursoService();
        $users = $rqService->getUsersNivelJefe();
        $requisiciones = RequisicionCurso::whereHas('participantes', function ($query) use ($users) {
            $query->where('rol', 'solicitante')
                ->whereIn('user_id', $users);
        })
            ->orderBy('created_at', 'desc')
            ->get();
        return view('perfil.requisiciones_curso.revisa_jefe.index')
            ->with('requisiciones', $requisiciones);
    }
    public function indexGerente()
    {
        $rqService = new RqCursoService();
        $users = $rqService->getUsersNivelGerente();
        $requisiciones = RequisicionCurso::whereHas('participantes', function ($query) use ($users) {
            $query->where('rol', 'solicitante')
                ->whereIn('user_id', $users);
        })
            ->get();
        return view('perfil.requisiciones_curso.revisa_gerente.index')
            ->with('requisiciones', $requisiciones);
    }
    public function indexDg()
    {
        $requisiciones = RequisicionCurso::with('participantes')
            ->whereIn('status', ['En revisión por dirección general', 'Rechazada por dirección general', 'Aceptada por dirección general'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('perfil.requisiciones_curso.autoriza.index')
            ->with('requisiciones', $requisiciones);
    }
}
