<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AutoApprovalService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AutoApprovalController extends Controller
{
    protected $autoApprovalService;

    public function __construct(AutoApprovalService $autoApprovalService)
    {
        $this->autoApprovalService = $autoApprovalService;
    }

    /**
     * Procesar aprobaciones automáticas
     */
    public function processAutoApprovals(): JsonResponse
    {
        try {
            $results = $this->autoApprovalService->processAutoApprovals();
            
            return response()->json([
                'success' => true,
                'message' => 'Proceso de aprobaciones automáticas completado',
                'data' => $results
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar aprobaciones automáticas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de solicitudes pendientes
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = $this->autoApprovalService->getPendingRequestsStats();
            
            return response()->json([
                'success' => true,
                'message' => 'Estadísticas obtenidas correctamente',
                'data' => $stats
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Habilitar aprobaciones automáticas de RH
     */
    public function enableHRAutoApprovals(): JsonResponse
    {
        try {
            $this->autoApprovalService->enableHRAutoApprovals();
            
            return response()->json([
                'success' => true,
                'message' => 'Aprobaciones automáticas de RH habilitadas'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al habilitar aprobaciones automáticas de RH',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deshabilitar aprobaciones automáticas de RH
     */
    public function disableHRAutoApprovals(): JsonResponse
    {
        try {
            $this->autoApprovalService->disableHRAutoApprovals();
            
            return response()->json([
                'success' => true,
                'message' => 'Aprobaciones automáticas de RH deshabilitadas'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al deshabilitar aprobaciones automáticas de RH',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ejecutar proceso en modo dry-run (sin cambios reales)
     */
    public function dryRun(): JsonResponse
    {
        try {
            $stats = $this->autoApprovalService->getPendingRequestsStats();
            
            $preview = [
                'supervisor_would_approve' => $stats['pending_supervisor_expired'],
                'hr_would_approve' => $stats['pending_hr_expired'],
                'hr_function_enabled' => false,
                'current_stats' => $stats
            ];
            
            return response()->json([
                'success' => true,
                'message' => 'Vista previa del proceso de aprobaciones automáticas',
                'data' => $preview
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en dry-run',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}