<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\RequestVacations;
use App\Models\VacationsAvailable;
use Illuminate\Support\Facades\Auth;

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
}
