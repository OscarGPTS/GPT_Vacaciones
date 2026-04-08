<?php

namespace App\Http\Controllers\Perfil;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CertificadoCv;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CvController extends Controller
{
    public function show()
    {
        return view('perfil.cv.show');
    }
    public function pdf()
    {
        $user = Auth::user();
        $user->load(['cvExperiencia' => fn ($query) => $query->orderBy('fecha_inicio', 'desc'), 'cvHistorialServicio' => fn ($query) => $query->orderBy('year', 'desc')->orderBy('created_at', 'desc'), 'cvCursoCertificacion', 'cvCursoSoldadura']);
        // return $user;
        $pdf = PDF::loadView('perfil.cv.pdf_template', compact('user'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream();
    }

    public function indexOtros()
    {
        $depto_id = Auth::user()->job->departamento->id;
        $empleados = User::with(['job.departamento'])
            ->whereHas('job.departamento', function ($query) use ($depto_id) {
                $query->where('id', $depto_id);
            })
            ->where('active', 1)
            ->whereNot('id', Auth::user()->id)
            ->get();
        return view('perfil.cv.index_otros')
            ->with('empleados', $empleados);
    }
    public function showOtros($id)
    {
        $depto_id = Auth::user()->job->departamento->id;
        $user = User::with(['job.departamento'])->findOrFail($id);

        if ($depto_id !== $user->job->departamento->id) {
            return redirect()->route('perfil.cv.editar.otros');
        }
        return view('perfil.cv.show_otro')
            ->with('user', $user);
    }

    public function pdfOtros($id)
    {

        $depto_id = Auth::user()->job->departamento->id;
        $user = User::with(['job.departamento'])->findOrFail($id);
        $user->load(['cvExperiencia' => fn ($query) => $query->orderBy('fecha_inicio', 'desc'), 'cvHistorialServicio' => fn ($query) => $query->orderBy('year', 'desc')->orderBy('created_at', 'desc'), 'cvCursoCertificacion', 'cvCursoSoldadura']);

        if ($depto_id !== $user->job->departamento->id) {
            return redirect()->route('perfil.cv.editar.otros');
        }

        // return $user;
        $pdf = PDF::loadView('perfil.cv.pdf_template', compact('user'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream();
    }

    public function showCvPublic($id)
    {
        $certificado = CertificadoCv::where('uuid', $id)->first();
        if ($certificado) {
            $user = User::with(['cvExperiencia' => fn ($query) => $query->orderBy('fecha_inicio', 'desc'), 'cvHistorialServicio' => fn ($query) => $query->orderBy('year', 'desc')->orderBy('created_at', 'desc'), 'cvCursoCertificacion', 'cvCursoSoldadura'])
                ->find($certificado->user_id);
            $pdf = PDF::loadView('perfil.cv.pdf_template', compact('user'))
                ->setPaper('A4', 'portrait');

            return $pdf->download($user->nombre() . ' certificado.pdf');
        }
    }
}
