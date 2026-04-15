<?php

namespace App\View\Composers;

use App\Models\RequestVacations;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $pendingManagerRequests = 0;
        $pendingDirectionRequests = 0;
        $pendingRHRequests = 0;
        $hasSubordinates = false;
        $userHasDirectionRole = false;

        if (Auth::check()) {
            // Obtener solicitudes pendientes para jefe directo
            $pendingManagerRequests = RequestVacations::where('direct_manager_id', auth()->id())
                ->where('direct_manager_status', 'Pendiente')
                ->count();

            // Obtener solicitudes pendientes para Dirección (solo las asignadas al usuario actual)
            $pendingDirectionRequests = RequestVacations::where('direction_approbation_id', auth()->id())
                ->where('direction_approbation_status', 'Pendiente')
                ->count();

            $userHasDirectionRole = User::where('id', auth()->id())->where('job_id', 60)->exists();
            // Obtener solicitudes pendientes para RH
            $pendingRHRequests = RequestVacations::where('direct_manager_status', 'Aprobada')
                ->where('direction_approbation_status', 'Aprobada')
                ->where('human_resources_status', 'Pendiente')
                ->count();

            // Verificar si el usuario tiene empleados a su cargo
            $hasSubordinates = User::where('boss_id', auth()->id())->exists();
        }

        $view->with([
            'pendingManagerRequests' => $pendingManagerRequests,
            'pendingDirectionRequests' => $pendingDirectionRequests,
            'pendingRHRequests' => $pendingRHRequests,
            'hasSubordinates' => $hasSubordinates,
            'userHasDirectionRole' => $userHasDirectionRole
        ]);
    }
}