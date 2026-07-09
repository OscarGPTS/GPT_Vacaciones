<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RequestVacations;
use App\Models\RequestApproved;
use App\Models\User;
use App\Models\Departamento;
use App\Models\UserSignature;
use App\Models\SystemLog;
use App\Models\DirectionApprover;
use App\Services\AutoApprovalService;
use App\Mail\VacationRequestApprovedByRH;
use App\Mail\VacationRequestRejectedByRH;
use App\Mail\VacationRequestApprovedByManager;
use App\Mail\VacationRequestRejectedByManager;
use App\Mail\VacationRequestPendingDirection;
use App\Mail\VacationRequestPendingRH;
use App\Mail\VacationRequestRejectedByDirection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class VacacionesRh extends Component
{
    use WithPagination;
    
    // Propiedades para filtros
    public $userFilter = '';
    public $departmentFilter = '';
    public $search = '';
    public $statusFilter = 'pending'; // 'pending' o 'processed'
    
    // Propiedades para paginación y ordenamiento
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // Propiedades para modales
    public $selectedRequest = null;
    public $showDaysModal = false;
    public $showAutoApprovalModal = false;
    public $showDecisionModal = false;
    public $decisionType = null;
    public $decisionStage = null; // 'manager' | 'direction' | 'rh'
    public $showTrackingModal = false;

    protected $queryString = [
        'userFilter' => ['except' => ''],
        'departmentFilter' => ['except' => ''],
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'pending'],
    ];

    public function mount()
    {
        // Inicializar valores desde la URL si existen
    }

    public function updatedUserFilter()
    {
        $this->resetPage();
    }

    public function updatedDepartmentFilter()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function resetPage()
    {
        // Reset pagination when filters change
    }

    public function clearFilters()
    {
        $this->userFilter = '';
        $this->departmentFilter = '';
        $this->search = '';
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    private function loadSelectedRequest($requestId): void
    {
        $this->selectedRequest = RequestVacations::with([
            'user.job.departamento',
            'user.vacationsAvailable.vacationPerYear',
            'requestDays',
            'reveal',
        ])->find($requestId);
    }

    public function showDaysDetail($requestId)
    {
        $this->loadSelectedRequest($requestId);
        $this->showDaysModal = true;
    }

    public function approveRequestDirect($requestId)
    {
        $this->confirmApprove($requestId);
    }

    public function rejectRequestDirect($requestId)
    {
        $this->confirmReject($requestId);
    }

    public function confirmApprove($requestId = null)
    {
        if ($requestId) {
            $this->loadSelectedRequest($requestId);
        }

        $this->decisionType = 'approve';
        $this->decisionStage = 'rh';
        $this->showDecisionModal = true;
    }

    public function confirmReject($requestId = null)
    {
        if ($requestId) {
            $this->loadSelectedRequest($requestId);
        }

        $this->decisionType = 'reject';
        $this->decisionStage = 'rh';
        $this->showDecisionModal = true;
    }

    public function closeDecisionModal()
    {
        $this->showDecisionModal = false;
        $this->decisionType = null;
        $this->decisionStage = null;
    }

    public function executeDecision()
    {
        if ($this->decisionType === 'approve') {
            if ($this->decisionStage === 'manager') {
                $this->approveAsManager();
            } elseif ($this->decisionStage === 'direction') {
                $this->approveAsDirection();
            } else {
                $this->approveRequest();
            }
            return;
        }

        if ($this->decisionType === 'reject') {
            if ($this->decisionStage === 'manager') {
                $this->rejectAsManager();
            } elseif ($this->decisionStage === 'direction') {
                $this->rejectAsDirection();
            } else {
                $this->rejectRequest();
            }
        }
    }

    /* ═══ Seguimiento: gestión de solicitud desde cualquier etapa ═══════════ */

    /**
     * Etapa actual del flujo en la que está detenida la solicitud.
     * Devuelve null si la solicitud ya terminó (aprobada, rechazada o cancelada).
     */
    public static function currentStageOf(RequestVacations $request): ?string
    {
        if ($request->human_resources_status === 'Cancelada'
            || $request->human_resources_status === 'Rechazada'
            || $request->human_resources_status === 'Aprobada'
            || $request->direct_manager_status === 'Rechazada'
            || $request->direction_approbation_status === 'Rechazada') {
            return null;
        }

        if ($request->direct_manager_status === 'Pendiente') {
            return 'manager';
        }

        if ($request->direction_approbation_status !== 'Aprobada') {
            return 'direction';
        }

        return 'rh';
    }

    public function showTrackingDetail($requestId)
    {
        $this->loadSelectedRequest($requestId);
        $this->showTrackingModal = true;
    }

    public function closeTrackingModal()
    {
        $this->showTrackingModal = false;
        $this->selectedRequest = null;
    }

    public function confirmAdvance($requestId = null)
    {
        if ($requestId) {
            $this->loadSelectedRequest($requestId);
        }

        $stage = $this->selectedRequest ? self::currentStageOf($this->selectedRequest) : null;
        if (!$stage) {
            session()->flash('error', 'Esta solicitud ya no tiene etapas pendientes por avanzar.');
            return;
        }

        $this->decisionType = 'approve';
        $this->decisionStage = $stage;
        $this->showDecisionModal = true;
    }

    public function confirmRejectTracking($requestId = null)
    {
        if ($requestId) {
            $this->loadSelectedRequest($requestId);
        }

        $stage = $this->selectedRequest ? self::currentStageOf($this->selectedRequest) : null;
        if (!$stage) {
            session()->flash('error', 'Esta solicitud ya no puede ser rechazada.');
            return;
        }

        $this->decisionType = 'reject';
        $this->decisionStage = $stage;
        $this->showDecisionModal = true;
    }

    /**
     * Aprobar la etapa de Jefe Directo (mismo flujo que VacacionesJefeDirecto::approveRequest).
     */
    private function approveAsManager()
    {
        if (!UserSignature::userHasSignature(auth()->id())) {
            session()->flash('error', 'Debes registrar tu firma digital antes de poder aprobar solicitudes.');
            return;
        }

        if (!$this->selectedRequest) {
            return;
        }

        try {
            // ASIGNACIÓN INTELIGENTE DE APROBADOR DE DIRECCIÓN por departamento
            $employee = $this->selectedRequest->user;
            $departamentoId = $employee->job->depto_id ?? null;

            if (!$departamentoId) {
                session()->flash('error', 'Error: El empleado no tiene un departamento asignado.');
                return;
            }

            $customDirectionId = DirectionApprover::getDirectionApproverForDepartment($departamentoId);
            $directionApproverId = $customDirectionId ?? User::where('job_id', 60)->where('active', 1)->value('id');

            if (!$directionApproverId) {
                session()->flash('error', 'Error: No se encontró un aprobador de Dirección asignado para este departamento.');
                return;
            }

            $this->selectedRequest->update([
                'direct_manager_status' => 'Aprobada',
                'direction_approbation_status' => 'Pendiente',
                'direction_approbation_id' => $directionApproverId,
                'updated_at' => now()
            ]);

            SystemLog::logInfo('rh_tracking_manager_approval', 'Etapa de Jefe Directo aprobada desde Seguimiento RH', $this->selectedRequest->user_id, [
                'request_id' => $this->selectedRequest->id,
                'rh_user_id' => auth()->id(),
            ]);

            session()->flash('success', 'Etapa de Jefe Directo aprobada. La solicitud pasó a Dirección.');

            // Notificar al empleado
            if ($this->selectedRequest->user && $this->selectedRequest->user->email) {
                try {
                    sleep(1);
                    Mail::to($this->selectedRequest->user->email)
                        ->send(new VacationRequestApprovedByManager($this->selectedRequest));
                } catch (\Exception $e) {
                    Log::error('Error enviando correo de aprobación al empleado: ' . $e->getMessage(), [
                        'request_id' => $this->selectedRequest->id
                    ]);
                }
            }

            // Notificar a Dirección
            $directionUser = User::find($directionApproverId);
            if ($directionUser && $directionUser->email) {
                try {
                    sleep(1);
                    Mail::to($directionUser->email)
                        ->send(new VacationRequestPendingDirection(
                            $this->selectedRequest->user,
                            $this->selectedRequest->requestDays->count(),
                            auth()->user()
                        ));
                } catch (\Exception $e) {
                    Log::error('Error enviando correo a Dirección: ' . $e->getMessage(), [
                        'request_id' => $this->selectedRequest->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->closeDecisionModal();
            session()->flash('error', 'Error al procesar la aprobación: ' . $e->getMessage());
            return;
        }

        $this->closeDecisionModal();
        $this->closeTrackingModal();
    }

    /**
     * Rechazar en la etapa de Jefe Directo (mismo flujo que VacacionesJefeDirecto::rejectRequest).
     */
    private function rejectAsManager()
    {
        if (!UserSignature::userHasSignature(auth()->id())) {
            session()->flash('error', 'Debes registrar tu firma digital antes de poder rechazar solicitudes.');
            return;
        }

        if (!$this->selectedRequest) {
            return;
        }

        try {
            $this->releaseReservedDaysForSelected();

            $this->selectedRequest->update([
                'direct_manager_status' => 'Rechazada',
                'updated_at' => now()
            ]);

            SystemLog::logInfo('rh_tracking_manager_rejection', 'Etapa de Jefe Directo rechazada desde Seguimiento RH', $this->selectedRequest->user_id, [
                'request_id' => $this->selectedRequest->id,
                'rh_user_id' => auth()->id(),
            ]);

            session()->flash('success', 'Solicitud rechazada en la etapa de Jefe Directo. Los días han sido liberados.');

            if ($this->selectedRequest->user && $this->selectedRequest->user->email) {
                try {
                    sleep(1);
                    Mail::to($this->selectedRequest->user->email)
                        ->send(new VacationRequestRejectedByManager($this->selectedRequest));
                } catch (\Exception $e) {
                    Log::error('Error enviando correo de rechazo al empleado: ' . $e->getMessage(), [
                        'request_id' => $this->selectedRequest->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->closeDecisionModal();
            session()->flash('error', 'Error al procesar el rechazo: ' . $e->getMessage());
            return;
        }

        $this->closeDecisionModal();
        $this->closeTrackingModal();
    }

    /**
     * Aprobar la etapa de Dirección (mismo flujo que VacacionesDireccion::approveRequest).
     */
    private function approveAsDirection()
    {
        if (!UserSignature::userHasSignature(auth()->id())) {
            session()->flash('error', 'Debes registrar tu firma digital antes de poder aprobar solicitudes.');
            return;
        }

        if (!$this->selectedRequest) {
            return;
        }

        try {
            $this->selectedRequest->update([
                'direction_approbation_status' => 'Aprobada',
                'direction_approbation_id' => auth()->id(),
                'updated_at' => now()
            ]);

            SystemLog::logInfo('rh_tracking_direction_approval', 'Etapa de Dirección aprobada desde Seguimiento RH', $this->selectedRequest->user_id, [
                'request_id' => $this->selectedRequest->id,
                'rh_user_id' => auth()->id(),
            ]);

            session()->flash('success', 'Etapa de Dirección aprobada. La solicitud pasó a Recursos Humanos para aprobación final.');

            // Notificar a RH (mismo flujo que Dirección)
            $rhUsers = config('vacations.rh_user_ids', []);
            foreach ($rhUsers as $rhUserId) {
                $rhUser = User::find($rhUserId);
                if ($rhUser && $rhUser->email) {
                    try {
                        sleep(1);
                        Mail::to($rhUser->email)
                            ->send(new VacationRequestPendingRH($this->selectedRequest));
                    } catch (\Exception $e) {
                        Log::error('Error enviando correo a RH: ' . $e->getMessage(), [
                            'request_id' => $this->selectedRequest->id,
                            'rh_user_id' => $rhUserId
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->closeDecisionModal();
            session()->flash('error', 'Error al procesar la aprobación: ' . $e->getMessage());
            return;
        }

        $this->closeDecisionModal();
        $this->closeTrackingModal();
    }

    /**
     * Rechazar en la etapa de Dirección (mismo flujo que VacacionesDireccion::rejectRequest).
     */
    private function rejectAsDirection()
    {
        if (!UserSignature::userHasSignature(auth()->id())) {
            session()->flash('error', 'Debes registrar tu firma digital antes de poder rechazar solicitudes.');
            return;
        }

        if (!$this->selectedRequest) {
            return;
        }

        try {
            $this->releaseReservedDaysForSelected();

            $this->selectedRequest->update([
                'direction_approbation_status' => 'Rechazada',
                'direction_approbation_id' => auth()->id(),
                'updated_at' => now()
            ]);

            SystemLog::logInfo('rh_tracking_direction_rejection', 'Etapa de Dirección rechazada desde Seguimiento RH', $this->selectedRequest->user_id, [
                'request_id' => $this->selectedRequest->id,
                'rh_user_id' => auth()->id(),
            ]);

            session()->flash('success', 'Solicitud rechazada en la etapa de Dirección. Los días han sido liberados.');

            if ($this->selectedRequest->user && $this->selectedRequest->user->email) {
                try {
                    sleep(1);
                    Mail::to($this->selectedRequest->user->email)
                        ->send(new VacationRequestRejectedByDirection($this->selectedRequest));
                } catch (\Exception $e) {
                    Log::error('Error enviando correo de rechazo de Dirección: ' . $e->getMessage(), [
                        'request_id' => $this->selectedRequest->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->closeDecisionModal();
            session()->flash('error', 'Error al procesar el rechazo: ' . $e->getMessage());
            return;
        }

        $this->closeDecisionModal();
        $this->closeTrackingModal();
    }

    /**
     * Liberar días reservados de la solicitud seleccionada (flujo existente de rechazo).
     */
    private function releaseReservedDaysForSelected(): void
    {
        if (empty($this->selectedRequest->opcion)) {
            return;
        }

        $parts = explode('|', $this->selectedRequest->opcion);
        if (count($parts) !== 2) {
            return;
        }

        list($periodNumber, $dateStart) = $parts;

        $periodo = \App\Models\VacationsAvailable::where('users_id', $this->selectedRequest->user_id)
            ->where('period', $periodNumber)
            ->where('date_start', $dateStart)
            ->where('is_historical', false)
            ->first();

        if ($periodo) {
            $diasSolicitados = $this->selectedRequest->requestDays->count();
            $periodo->update([
                'days_reserved' => max(0, $periodo->days_reserved - $diasSolicitados)
            ]);
        }
    }

    public function approveRequest()
    {
        if (!UserSignature::userHasSignature(auth()->id())) {
            session()->flash('error', 'Debes registrar tu firma digital antes de poder aprobar solicitudes. Ve a tu perfil para agregarla.');
            return;
        }

        if ($this->selectedRequest) {
            try {
                // Obtener días solicitados
                $diasSolicitados = $this->selectedRequest->requestDays->count();
                
                // Validar que la solicitud tiene un período asignado
                if (empty($this->selectedRequest->opcion)) {
                    session()->flash('error', "Error: La solicitud no tiene un período de vacaciones asignado.");
                    return;
                }

                // Parse el campo opcion (formato: "periodo|date_start")
                $parts = explode('|', $this->selectedRequest->opcion);
                if (count($parts) !== 2) {
                    session()->flash('error', "Error: El formato del período no es válido.");
                    return;
                }

                list($periodNumber, $dateStart) = $parts;

                // Buscar el período específico
                $periodo = \App\Models\VacationsAvailable::where('users_id', $this->selectedRequest->user_id)
                    ->where('period', $periodNumber)
                    ->where('date_start', $dateStart)
                    ->where('is_historical', false)
                    ->first();

                if (!$periodo) {
                    session()->flash('error', "Error: No se encontró el período de vacaciones especificado (Período {$periodNumber}, inicio: {$dateStart}).");
                    return;
                }

                // Validar que hay días suficientes en este período.
                // Para mantener consistencia con las cards del formulario,
                // la validación usa el saldo basado en `days_availables`.
                $diasDisponiblesEnPeriodo = $periodo->available_balance;
                
                if ($diasDisponiblesEnPeriodo < $diasSolicitados) {
                    session()->flash('error', "Error: El período {$periodNumber} solo tiene {$diasDisponiblesEnPeriodo} días disponibles. Se solicitaron {$diasSolicitados} días.");
                    return;
                }

                // Actualizar el estado de la solicitud
                $this->selectedRequest->update([
                    'human_resources_status' => 'Aprobada',
                    'updated_at' => now()
                ]);

                // Registrar quién aprobó en RH para el PDF
                SystemLog::logInfo('rh_vacation_approval', 'Solicitud de vacaciones aprobada por RH', $this->selectedRequest->user_id, [
                    'request_id' => $this->selectedRequest->id,
                    'rh_user_id' => auth()->id(),
                ]);

                // SEPARAR DÍAS ANTES Y DESPUÉS DEL ANIVERSARIO
                // Obtener las fechas individuales de los días solicitados
                $fechasIndividuales = $this->selectedRequest->requestDays->pluck('start');
                
                $diasAntesAniversario = 0;
                $diasDespuesAniversario = 0;
                
                $fechaAniversario = \Carbon\Carbon::parse($periodo->date_end)->startOfDay();
                $fechaLimiteDisfrute = $fechaAniversario->copy()->addMonths(15)->endOfDay();
                
                foreach ($fechasIndividuales as $fecha) {
                    $fechaDia = \Carbon\Carbon::parse($fecha)->startOfDay();

                    if ($fechaDia->gt($fechaLimiteDisfrute)) {
                        session()->flash(
                            'error',
                            "Error: la fecha {$fechaDia->format('d/m/Y')} excede la vigencia del Período {$periodNumber}. Fecha límite para tomarlo: {$fechaLimiteDisfrute->format('d/m/Y')}."
                        );
                        return;
                    }
                    
                    // Comparar si el día solicitado es antes o después del aniversario
                    if ($fechaDia->lte($fechaAniversario)) {
                        // Día está dentro del período (antes o en la fecha de aniversario)
                        $diasAntesAniversario++;
                    } else {
                        // Día está después del aniversario, pero dentro de la ventana de 12 + 3 meses
                        $diasDespuesAniversario++;
                    }
                }
                
                // LIBERAR RESERVA Y DESCONTAR DÍAS del período específico
                // IMPORTANTE: Los días se descuentan de AMBOS campos:
                // - days_calculated (cálculo automático del sistema)
                // - days_availables (dato importado de Excel)
                $periodo->update([
                    'days_reserved' => max(0, $periodo->days_reserved - $diasSolicitados), // Liberar reserva
                    'days_enjoyed' => $periodo->days_enjoyed + $diasSolicitados, // Incrementar disfrutados
                    'days_enjoyed_before_anniversary' => $periodo->days_enjoyed_before_anniversary + $diasAntesAniversario,
                    'days_enjoyed_after_anniversary' => $periodo->days_enjoyed_after_anniversary + $diasDespuesAniversario,
                    // Descontar de days_calculated (si existe)
                    'days_calculated' => max(0, ($periodo->days_calculated ?? 0) - $diasSolicitados),
                    // Descontar de days_availables (siempre)
                    'days_availables' => max(0, $periodo->days_availables - $diasSolicitados),
                ]);

                $dateStartFormatted = \Carbon\Carbon::parse($dateStart)->format('d/m/Y');
                $dateEndFormatted = \Carbon\Carbon::parse($periodo->date_end)->format('d/m/Y');
                
                $detalleAniversario = "";
                if ($diasAntesAniversario > 0 && $diasDespuesAniversario > 0) {
                    $detalleAniversario = " ({$diasAntesAniversario} antes del aniversario, {$diasDespuesAniversario} después)";
                } elseif ($diasAntesAniversario > 0) {
                    $detalleAniversario = " (todos antes del aniversario)";
                } elseif ($diasDespuesAniversario > 0) {
                    $detalleAniversario = " (todos después del aniversario)";
                }
                
                session()->flash('success', "Solicitud aprobada exitosamente. Se descontaron {$diasSolicitados} días del Período {$periodNumber} ({$dateStartFormatted} - {$dateEndFormatted}){$detalleAniversario}.");
                
            // Enviar notificación al empleado
            if ($this->selectedRequest->user && $this->selectedRequest->user->email) {
                try {
                    // Pequeño delay para evitar límite de tasa de Mailtrap
                    sleep(1);

                    Mail::to($this->selectedRequest->user->email)
                        ->send(new VacationRequestApprovedByRH($this->selectedRequest));
                    Log::info('Correo de aprobación enviado al empleado', [
                        'request_id' => $this->selectedRequest->id,
                        'employee_email' => $this->selectedRequest->user->email
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error enviando correo de aprobación al empleado: ' . $e->getMessage(), [
                        'request_id' => $this->selectedRequest->id,
                        'employee_id' => $this->selectedRequest->user_id
                    ]);
                }
            }
            } catch (\Exception $e) {
                $this->closeDecisionModal();
                session()->flash('error', 'Error al procesar la aprobación: ' . $e->getMessage());
                return;
            }

            $this->closeDecisionModal();
            $this->showDaysModal = false;
            $this->showTrackingModal = false;
            $this->selectedRequest = null;
        }
    }

    public function rejectRequest()
    {
        if (!UserSignature::userHasSignature(auth()->id())) {
            session()->flash('error', 'Debes registrar tu firma digital antes de poder rechazar solicitudes. Ve a tu perfil para agregarla.');
            return;
        }

        if ($this->selectedRequest) {
            try {
                // LIBERAR DÍAS RESERVADOS antes de rechazar
                if (!empty($this->selectedRequest->opcion)) {
                    $parts = explode('|', $this->selectedRequest->opcion);
                    if (count($parts) === 2) {
                        list($periodNumber, $dateStart) = $parts;
                        
                        $periodo = \App\Models\VacationsAvailable::where('users_id', $this->selectedRequest->user_id)
                            ->where('period', $periodNumber)
                            ->where('date_start', $dateStart)
                            ->where('is_historical', false)
                            ->first();
                        
                        if ($periodo) {
                            $diasSolicitados = $this->selectedRequest->requestDays->count();
                            $periodo->update([
                                'days_reserved' => max(0, $periodo->days_reserved - $diasSolicitados)
                            ]);
                        }
                    }
                }
                
                // Actualizar el estado de la solicitud
                $this->selectedRequest->update([
                    'human_resources_status' => 'Rechazada',
                    'updated_at' => now()
                ]);

                // Registrar quién rechazó en RH para el PDF
                SystemLog::logInfo('rh_vacation_rejection', 'Solicitud de vacaciones rechazada por RH', $this->selectedRequest->user_id, [
                    'request_id' => $this->selectedRequest->id,
                    'rh_user_id' => auth()->id(),
                ]);

                // Mover días de request_approved a request_rejected
                $this->moveToRejected($this->selectedRequest);

                session()->flash('success', 'Solicitud rechazada por Recursos Humanos. Los días han sido liberados.');
                
                // Enviar notificación al empleado
                if ($this->selectedRequest->user && $this->selectedRequest->user->email) {
                    try {
                        // Pequeño delay para evitar límite de tasa de Mailtrap
                        sleep(1);
                        
                        Mail::to($this->selectedRequest->user->email)
                            ->send(new VacationRequestRejectedByRH($this->selectedRequest));
                        Log::info('Correo de rechazo enviado al empleado', [
                            'request_id' => $this->selectedRequest->id,
                            'employee_email' => $this->selectedRequest->user->email
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Error enviando correo de rechazo al empleado: ' . $e->getMessage(), [
                            'request_id' => $this->selectedRequest->id,
                            'employee_id' => $this->selectedRequest->user_id
                        ]);
                    }
                }
                
            } catch (\Exception $e) {
                $this->closeDecisionModal();
                session()->flash('error', 'Error al procesar el rechazo: ' . $e->getMessage());
                return;
            }

            $this->closeDecisionModal();
            $this->showDaysModal = false;
            $this->showTrackingModal = false;
            $this->selectedRequest = null;
        }
    }

    /**
     * Mover días de request_approved a request_rejected cuando se rechaza una solicitud
     */
    private function moveToRejected(RequestVacations $requestVacation)
    {
        // Obtener los días aprobados
        $approvedDays = RequestApproved::where('requests_id', $requestVacation->id)->get();
        
        // Crear registros en request_rejected
        foreach ($approvedDays as $day) {
            \App\Models\RequestRejected::create([
                'title' => $day->title,
                'start' => $day->start,
                'end' => $day->end,
                'users_id' => $day->users_id,
                'requests_id' => $day->requests_id
            ]);
        }
        
        // Eliminar de request_approved
        RequestApproved::where('requests_id', $requestVacation->id)->delete();
    }

    public function closeModal()
    {
        $this->showDaysModal = false;
        $this->showAutoApprovalModal = false;
        $this->showDecisionModal = false;
        $this->showTrackingModal = false;
        $this->decisionType = null;
        $this->decisionStage = null;
        $this->selectedRequest = null;
    }

    public function showAutoApprovalConfirm()
    {
        $this->showAutoApprovalModal = true;
    }

    public function processAutoApprovals()
    {
        try {
            $autoApprovalService = new AutoApprovalService();
            $results = $autoApprovalService->processAutoApprovals();
            
            $message = "Proceso completado: ";
            $message .= "{$results['direct_manager_approvals']} solicitudes de supervisor aprobadas automáticamente";
            
            if ($results['hr_approvals'] > 0) {
                $message .= ", {$results['hr_approvals']} solicitudes de RH aprobadas automáticamente";
            } else {
                $message .= " (aprobaciones de RH deshabilitadas)";
            }
            
            if (!empty($results['errors'])) {
                $errorMsg = "Errores encontrados: " . implode(', ', $results['errors']);
                session()->flash('error', $errorMsg);
            } else {
                session()->flash('success', $message);
            }
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al procesar aprobaciones automáticas: ' . $e->getMessage());
        }
    }

    public function getRequestsProperty()
    {
        $query = RequestVacations::with(['user.job.departamento', 'requestDays', 'reveal'])
            ->where('direct_manager_status', 'Aprobada')
            ->where('direction_approbation_status', 'Aprobada');

        // Aplicar filtros de estado
        if ($this->statusFilter === 'pending') {
            $query->where('human_resources_status', 'Pendiente');
        } else {
            $query->whereIn('human_resources_status', ['Aprobada', 'Rechazada']);
        }

        // Aplicar filtro por usuario
        if ($this->userFilter) {
            $query->where('user_id', $this->userFilter);
        }

        // Aplicar filtro por departamento
        if ($this->departmentFilter) {
            $query->whereHas('user.job.departamento', function (Builder $q) {
                $q->where('id', $this->departmentFilter);
            });
        }

        // Aplicar búsqueda por texto
        if ($this->search) {
            $query->where(function (Builder $q) {
                $q->whereHas('user', function (Builder $subQ) {
                    $subQ->where('first_name', 'like', '%' . $this->search . '%')
                         ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('reason', 'like', '%' . $this->search . '%')
                ->orWhere('type_request', 'like', '%' . $this->search . '%');
            });
        }

        // Aplicar ordenamiento
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function getPendingRequestsProperty()
    {
        if ($this->statusFilter === 'pending') {
            return $this->requests;
        }
        return collect([]);
    }

    /**
     * Seguimiento: todas las solicitudes sin importar la etapa del flujo,
     * para visualizar en qué paso de aprobación se encuentra cada una.
     */
    public function getTrackingRequestsProperty()
    {
        if ($this->statusFilter !== 'tracking') {
            return collect([]);
        }

        $query = RequestVacations::with(['user.job.departamento', 'requestDays']);

        // Aplicar filtro por usuario
        if ($this->userFilter) {
            $query->where('user_id', $this->userFilter);
        }

        // Aplicar filtro por departamento
        if ($this->departmentFilter) {
            $query->whereHas('user.job.departamento', function (Builder $q) {
                $q->where('id', $this->departmentFilter);
            });
        }

        // Aplicar búsqueda por texto
        if ($this->search) {
            $query->where(function (Builder $q) {
                $q->whereHas('user', function (Builder $subQ) {
                    $subQ->where('first_name', 'like', '%' . $this->search . '%')
                         ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('reason', 'like', '%' . $this->search . '%')
                ->orWhere('type_request', 'like', '%' . $this->search . '%');
            });
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function getProcessedRequestsProperty()
    {
        if ($this->statusFilter === 'processed') {
            return $this->requests;
        }
        return collect([]);
    }

    /**
     * IDs de usuarios con solicitudes según la pestaña activa.
     * En 'Seguimiento' se incluyen todas las solicitudes sin importar la etapa.
     */
    private function getFilterUserIds(): array
    {
        if ($this->statusFilter === 'tracking') {
            return RequestVacations::distinct()->pluck('user_id')->toArray();
        }

        return RequestVacations::where('direct_manager_status', 'Aprobada')
            ->where('direction_approbation_status', 'Aprobada')
            ->where('human_resources_status', '!=', 'Rechazada')
            ->distinct()
            ->pluck('user_id')
            ->toArray();
    }

    public function getUsersProperty()
    {
        // Primero obtener IDs de usuarios desde mysql_vacations
        $userIds = $this->getFilterUserIds();

        // Luego filtrar usuarios en mysql usando whereIn (no cross-database)
        return User::whereIn('id', $userIds)
            ->where('active', 1)
            ->orderBy('first_name')
            ->get();
    }

    public function getDepartmentsProperty()
    {
        // Primero obtener IDs de usuarios desde mysql_vacations
        $userIds = $this->getFilterUserIds();
        
        // Luego obtener departamentos de esos usuarios (via jobs)
        return Departamento::whereHas('jobs.empleados', function (Builder $q) use ($userIds) {
            $q->whereIn('id', $userIds);
        })
        ->orderBy('name')
        ->get();
    }

    public function render()
    {
        return view('livewire.vacaciones-rh', [
            'hasSignature' => UserSignature::userHasSignature(auth()->id()),
        ]);
    }
}