<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\RequestVacations;
use App\Models\VacationsAvailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load([
            'job.departamento',
            'jefe.job',
            'razonSocial',
            'personalData',
        ]);

        // Períodos de vacaciones vigentes y vencidos
        $vacationPeriods = VacationsAvailable::where('users_id', $user->id)
            ->orderByDesc('period')
            ->limit(5)
            ->get();

        // Resumen: totales del período actual
        $currentPeriod = $vacationPeriods->where('status', 'actual')->first()
            ?? $vacationPeriods->first();

        // Últimas 6 solicitudes de vacaciones (cualquier estado)
        $recentRequests = RequestVacations::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        // Totales globales
        $totalAvailable  = $vacationPeriods->sum('days_availables');
        $totalEnjoyed    = $vacationPeriods->sum('days_enjoyed');
        $totalReserved   = $vacationPeriods->sum('days_reserved');
        $totalRemaining  = max(0, $totalAvailable - $totalEnjoyed - $totalReserved);

        return view('perfil.profile', compact(
            'user',
            'vacationPeriods',
            'currentPeriod',
            'recentRequests',
            'totalAvailable',
            'totalEnjoyed',
            'totalReserved',
            'totalRemaining'
        ));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ]);

        $user = Auth::user();

        // Directorio de destino
        $dir = public_path('fotos-de-empleados/perfil');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Nombre de archivo estable: {id}.jpg
        $filename = $user->id . '.jpg';
        $destPath = $dir . DIRECTORY_SEPARATOR . $filename;

        // Imagen redimensionada: 350×350 cuadrada con recorte centrado, JPEG 85%
        Image::make($request->file('foto')->getRealPath())
            ->fit(350, 350, function ($constraint) {
                $constraint->upsize();
            })
            ->save($destPath, 85);

        // URL pública con cache-buster para que el navegador la refresque
        $url = asset('fotos-de-empleados/perfil/' . $filename) . '?v=' . time();

        $user->profile_image = $url;
        $user->save();

        return back()->with('foto_actualizada', true);
    }
}
