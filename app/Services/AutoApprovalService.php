<?php

namespace App\Services;

use App\Models\RequestVacations;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AutoApprovalService
{
    /**
     * Procesar aprobaciones automáticas por timeout
     */
    public function processAutoApprovals()
    {
        $results = [
            'direct_manager_approvals' => 0,
            'direction_approvals' => 0,
            'hr_approvals' => 0,
            'errors' => []
        ];

        try {
            // Aprobaciones automáticas para supervisor directo (5 días)
            $results['direct_manager_approvals'] = $this->processDirectManagerAutoApprovals();
            
            // Aprobaciones automáticas para Dirección (5 días)
            $results['direction_approvals'] = $this->processDirectionAutoApprovals();
            
            // Aprobaciones automáticas para RH (deshabilitado por ahora)
            // $results['hr_approvals'] = $this->processHRAutoApprovals();
            
        } catch (\Exception $e) {
            $results['errors'][] = 'Error general: ' . $e->getMessage();
            Log::error('Error en AutoApprovalService: ' . $e->getMessage());
        }

        return $results;
    }

    /**
     * Procesar aprobaciones automáticas para supervisor directo
     */
    private function processDirectManagerAutoApprovals()
    {
        $approvedCount = 0;
        $cutoffDate = Carbon::now()->subDays(5);

        // Obtener solicitudes pendientes de supervisor por más de 5 días
        $pendingRequests = RequestVacations::where('direct_manager_status', 'Pendiente')
            ->where('created_at', '<=', $cutoffDate)
            ->get();

        foreach ($pendingRequests as $request) {
            try {
                // Actualizar estado a aprobado automáticamente y enviar a Dirección
                $request->update([
                    'direct_manager_status' => 'Aprobada',
                    'direction_approbation_status' => 'Pendiente',
                    'updated_at' => now()
                ]);

                $approvedCount++;

                // Log para auditoría
                Log::info("Solicitud {$request->id} aprobada automáticamente por supervisor (timeout 5 días)", [
                    'user_id' => $request->user_id,
                    'request_id' => $request->id,
                    'created_at' => $request->created_at,
                    'auto_approved_at' => now(),
                    'next_step' => 'Dirección'
                ]);

            } catch (\Exception $e) {
                Log::error("Error al aprobar automáticamente solicitud {$request->id}: " . $e->getMessage());
            }
        }

        return $approvedCount;
    }

    /**
     * Procesar aprobaciones automáticas para Dirección
     */
    private function processDirectionAutoApprovals()
    {
        $approvedCount = 0;
        $cutoffDate = Carbon::now()->subDays(5);

        // Obtener solicitudes pendientes de Dirección por más de 5 días
        $pendingRequests = RequestVacations::where('direct_manager_status', 'Aprobada')
            ->where('direction_approbation_status', 'Pendiente')
            ->where('updated_at', '<=', $cutoffDate)
            ->get();

        foreach ($pendingRequests as $request) {
            try {
                // Actualizar estado a aprobado automáticamente por Dirección
                $request->update([
                    'direction_approbation_status' => 'Aprobada',
                    'updated_at' => now()
                ]);

                $approvedCount++;

                // Log para auditoría
                Log::info("Solicitud {$request->id} aprobada automáticamente por Dirección (timeout 5 días)", [
                    'user_id' => $request->user_id,
                    'request_id' => $request->id,
                    'direct_manager_approved_at' => $request->created_at,
                    'auto_approved_at' => now(),
                    'next_step' => 'Recursos Humanos'
                ]);

            } catch (\Exception $e) {
                Log::error("Error al aprobar automáticamente solicitud de Dirección {$request->id}: " . $e->getMessage());
            }
        }

        return $approvedCount;
    }

    /**
     * Procesar aprobaciones automáticas para RH (DESHABILITADO)
     */
    private function processHRAutoApprovals()
    {
        // FUNCIÓN DESHABILITADA POR AHORA
        return 0;
        
        /*
        $approvedCount = 0;
        $cutoffDate = Carbon::now()->subDays(5);

        // Obtener solicitudes pendientes de RH por más de 5 días
        $pendingRequests = RequestVacations::where('direct_manager_status', 'Aprobada')
            ->where('human_resources_status', 'Pendiente')
            ->where('updated_at', '<=', $cutoffDate)
            ->get();

        foreach ($pendingRequests as $request) {
            try {
                // Validar que el usuario tenga días suficientes antes de auto-aprobar
                $diasSolicitados = $request->requestDays->count();
                $periodosActivos = $request->user->vacationsAvailable()
                    ->where('is_historical', false)
                    ->get();

                $totalDiasDisponibles = 0;
                foreach ($periodosActivos as $periodo) {
                    $diasDisponiblesEnPeriodo = $periodo->days_availables - $periodo->days_enjoyed;
                    $totalDiasDisponibles += max(0, $diasDisponiblesEnPeriodo);
                }

                // Solo aprobar si tiene días suficientes
                if ($totalDiasDisponibles >= $diasSolicitados) {
                    $request->update([
                        'human_resources_status' => 'Aprobada',
                        'updated_at' => now()
                    ]);

                    // Descontar días de períodos (misma lógica que aprobación manual)
                    $this->deductVacationDays($request, $diasSolicitados);

                    $approvedCount++;

                    Log::info("Solicitud {$request->id} aprobada automáticamente por RH (timeout 5 días)", [
                        'user_id' => $request->user_id,
                        'request_id' => $request->id,
                        'days_deducted' => $diasSolicitados
                    ]);
                }

            } catch (\Exception $e) {
                Log::error("Error al aprobar automáticamente solicitud RH {$request->id}: " . $e->getMessage());
            }
        }

        return $approvedCount;
        */
    }

    /**
     * Descontar días de vacaciones de los períodos activos
     */
    private function deductVacationDays($request, $diasSolicitados)
    {
        $periodosActivos = $request->user->vacationsAvailable()
            ->where('is_historical', false)
            ->orderBy('date_start', 'asc')
            ->get();

        $diasPorDescontar = $diasSolicitados;
        
        foreach ($periodosActivos as $periodo) {
            if ($diasPorDescontar <= 0) {
                break;
            }
            
            // Saldo = days_availables (fijo) - days_enjoyed (tomados)
            $diasDisponiblesEnPeriodo = $periodo->days_availables - $periodo->days_enjoyed;
            
            if ($diasDisponiblesEnPeriodo > 0) {
                $diasADescontarDePeriodo = min($diasPorDescontar, $diasDisponiblesEnPeriodo);
                
                // days_availables NO se modifica; solo se incrementa days_enjoyed
                $periodo->update([
                    'days_enjoyed' => $periodo->days_enjoyed + $diasADescontarDePeriodo,
                ]);
                
                $diasPorDescontar -= $diasADescontarDePeriodo;
            }
        }
    }

    /**
     * Obtener estadísticas de solicitudes pendientes
     */
    public function getPendingRequestsStats()
    {
        $cutoffDate = Carbon::now()->subDays(5);

        $stats = [
            'pending_supervisor_total' => RequestVacations::where('direct_manager_status', 'Pendiente')->count(),
            'pending_supervisor_expired' => RequestVacations::where('direct_manager_status', 'Pendiente')
                ->where('created_at', '<=', $cutoffDate)->count(),
            'pending_direction_total' => RequestVacations::where('direct_manager_status', 'Aprobada')
                ->where('direction_approbation_status', 'Pendiente')->count(),
            'pending_direction_expired' => RequestVacations::where('direct_manager_status', 'Aprobada')
                ->where('direction_approbation_status', 'Pendiente')
                ->where('updated_at', '<=', $cutoffDate)->count(),
            'pending_hr_total' => RequestVacations::where('direct_manager_status', 'Aprobada')
                ->where('direction_approbation_status', 'Aprobada')
                ->where('human_resources_status', 'Pendiente')->count(),
            'pending_hr_expired' => RequestVacations::where('direct_manager_status', 'Aprobada')
                ->where('direction_approbation_status', 'Aprobada')
                ->where('human_resources_status', 'Pendiente')
                ->where('updated_at', '<=', $cutoffDate)->count(),
        ];

        return $stats;
    }

    /**
     * Habilitar aprobaciones automáticas de RH
     */
    public function enableHRAutoApprovals()
    {
        // Método para habilitar la funcionalidad cuando sea necesario
        Log::info('Aprobaciones automáticas de RH habilitadas');
        return true;
    }

    /**
     * Deshabilitar aprobaciones automáticas de RH
     */
    public function disableHRAutoApprovals()
    {
        // Método para deshabilitar la funcionalidad
        Log::info('Aprobaciones automáticas de RH deshabilitadas');
        return true;
    }
}