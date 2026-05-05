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

        $userId = $user->id;
        $now = \Carbon\Carbon::now();

        // ── Unlock info (menos de 1 año de antigüedad) ──────────────────
        $unlockInfo = null;
        if ($user->admission) {
            $admissionDate = \Carbon\Carbon::parse($user->admission);
            $oneYearDate   = $admissionDate->copy()->addYear();
            if ($now->lt($oneYearDate)) {
                $unlockInfo = [
                    'unlock_date'    => $oneYearDate->format('d/m/Y'),
                    'days_remaining' => $now->diffInDays($oneYearDate),
                    'admission_date' => $admissionDate->format('d/m/Y'),
                ];
            }
        }

        // ── Períodos de vacaciones vigentes (igual lógica que VacacionesController) ──
        $vacationPeriods = VacationsAvailable::where('users_id', $userId)
            ->where('status', 'actual')
            ->orderBy('period')
            ->get()
            ->map(function ($period) use ($now) {
                $expirationDate      = \Carbon\Carbon::parse($period->date_end)->addMonths(15);
                $daysUntilExpiration = $now->diffInDays($expirationDate, false);

                $dateStart           = \Carbon\Carbon::parse($period->date_start);
                $availableFromDate   = $dateStart->copy()->addYear();
                $daysUntilAvailable  = $now->diffInDays($availableFromDate, false);
                $isNotYetAvailable   = $daysUntilAvailable > 0;

                $availableDays = $period->available_balance;
                $isExpired     = $daysUntilExpiration < 0;

                $endYear = (int)\Carbon\Carbon::parse($period->date_end)->format('Y');

                return [
                    'period'               => $period->period,
                    'period_name'          => 'Período ' . $endYear . '-' . ($endYear + 1),
                    'date_start'           => $period->date_start,
                    'date_end'             => $period->date_end,
                    'days_availables'      => $period->days_availables,
                    'days_enjoyed'         => $period->days_enjoyed,
                    'days_reserved'        => $period->days_reserved ?? 0,
                    'available_days'       => floor($availableDays),
                    'available_days_exact' => round($availableDays, 2),
                    'expiration_date'      => $expirationDate,
                    'days_until_expiration'=> $daysUntilExpiration,
                    'is_expired'           => $isExpired,
                    'expires_soon'         => $daysUntilExpiration <= 60 && !$isExpired,
                    'is_not_yet_available' => $isNotYetAvailable,
                    'available_from_date'  => $availableFromDate,
                    'days_until_available' => $daysUntilAvailable,
                ];
            })
            ->reject(fn($p) => $p['is_expired']);

        $totalAvailableDays = $vacationPeriods->sum('available_days');
        $totalAvailable     = $vacationPeriods->sum('days_availables');
        $totalEnjoyed       = $vacationPeriods->sum('days_enjoyed');
        $totalReserved      = $vacationPeriods->sum('days_reserved');
        $totalRemaining     = $totalAvailableDays;

        // ── Últimas 6 solicitudes ────────────────────────────────────────
        $recentRequests = RequestVacations::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return view('perfil.profile', compact(
            'user',
            'vacationPeriods',
            'totalAvailableDays',
            'totalAvailable',
            'totalEnjoyed',
            'totalReserved',
            'totalRemaining',
            'unlockInfo',
            'recentRequests'
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
