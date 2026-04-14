<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RequestVacations;
use App\Models\User;
use App\Models\Departamento;
use App\Models\DirectionApprover;
use App\Mail\VacationRequestApprovedByManager;
use App\Mail\VacationRequestRejectedByManager;
use App\Mail\VacationRequestPendingDirection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class VacacionesJefeDirecto extends Component
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

    public function showDaysDetail($requestId)
    {
        $this->selectedRequest = RequestVacations::with(['user', 'requestDays', 'reveal'])
            ->find($requestId);
        $this->showDaysModal = true;
    }

    public function approveRequestDirect($requestId)
    {
        $this->selectedRequest = RequestVacations::with(['user', 'requestDays', 'reveal'])
            ->find($requestId);
        $this->approveRequest();
    }

    public function rejectRequestDirect($requestId)
    {
        $this->selectedRequest = RequestVacations::with(['user', 'requestDays', 'reveal'])
            ->find($requestId);
        $this->rejectRequest();
    }

    public function approveRequest()
    {
        if ($this->selectedRequest) {
            try {
                // ASIGNACIÓN INTELIGENTE DE APROBADOR DE DIRECCIÓN
                // Buscar aprobador de dirección personalizado para el departamento del empleado
                $employee = $this->selectedRequest->user;
                $departamentoId = $employee->job->depto_id ?? null;
                
                if (!$departamentoId) {
                    session()->flash('error', 'Error: El empleado no tiene un departamento asignado.');
                    return;
                }
                
                // Buscar aprobador de dirección configurado para este departamento
                $customDirectionId = DirectionApprover::getDirectionApproverForDepartment($departamentoId);
                
                // Usar el aprobador personalizado si existe, sino usar el director por defecto (job_id = 60)
                $directionApproverId = $customDirectionId ?? User::where('job_id', 60)->where('active', 1)->value('id');
                
                if (!$directionApproverId) {
                    session()->flash('error', 'Error: No se encontró un aprobador de Dirección asignado para este departamento.');
                    return;
                }

                // Actualizar el estado de la solicitud
                $this->selectedRequest->update([
                    'direct_manager_status' => 'Aprobada',
                    'direction_approbation_status' => 'Pendiente',
                    'direction_approbation_id' => $directionApproverId,
                    'updated_at' => now()
                ]);

                session()->flash('success', "Solicitud aprobada como Jefe Directo. Ahora pasará a Dirección para revisión.");
                
                // Enviar notificación al empleado
                if ($this->selectedRequest->user && $this->selectedRequest->user->email) {
                    try {
                        sleep(1);
                        Mail::to($this->selectedRequest->user->email)
                            ->send(new VacationRequestApprovedByManager($this->selectedRequest));
                        Log::info('Correo de aprobación de jefe directo enviado al empleado', [
                            'request_id' => $this->selectedRequest->id,
                            'employee_email' => $this->selectedRequest->user->email
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Error enviando correo de aprobación al empleado: ' . $e->getMessage(), [
                            'request_id' => $this->selectedRequest->id
                        ]);
                    }
                }

                // Enviar notificación a Dirección
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
                        Log::info('Correo enviado a Dirección desde Jefe Directo', [
                            'request_id' => $this->selectedRequest->id,
                            'direction_email' => $directionUser->email
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Error enviando correo a Dirección: ' . $e->getMessage(), [
                            'request_id' => $this->selectedRequest->id,
                            'direction_user_id' => $directionApproverId
                        ]);
                    }
                }

            } catch (\Exception $e) {
                session()->flash('error', 'Error al procesar la aprobación: ' . $e->getMessage());
                return;
            }

            $this->showDaysModal = false;
            $this->selectedRequest = null;
        }
    }

    public function rejectRequest()
    {
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
                    'direct_manager_status' => 'Rechazada',
                    'updated_at' => now()
                ]);

                session()->flash('success', 'Solicitud rechazada. Los días han sido liberados.');
                
                // Enviar notificación al empleado
                if ($this->selectedRequest->user && $this->selectedRequest->user->email) {
                    try {
                        sleep(1);
                        Mail::to($this->selectedRequest->user->email)
                            ->send(new VacationRequestRejectedByManager($this->selectedRequest));
                        Log::info('Correo de rechazo enviado al empleado', [
                            'request_id' => $this->selectedRequest->id,
                            'employee_email' => $this->selectedRequest->user->email
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Error enviando correo de rechazo al empleado: ' . $e->getMessage(), [
                            'request_id' => $this->selectedRequest->id
                        ]);
                    }
                }

            } catch (\Exception $e) {
                session()->flash('error', 'Error al procesar el rechazo: ' . $e->getMessage());
                return;
            }

            $this->showDaysModal = false;
            $this->selectedRequest = null;
        }
    }

    public function closeModal()
    {
        $this->showDaysModal = false;
        $this->selectedRequest = null;
    }

    // Computed properties para obtener datos
    public function getPendingRequestsProperty()
    {
        if ($this->statusFilter === 'pending') {
            return $this->getFilteredRequests()
                ->where('direct_manager_status', 'Pendiente')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        }
        return collect([]);
    }

    public function getProcessedRequestsProperty()
    {
        if ($this->statusFilter === 'processed') {
            return $this->getFilteredRequests()
                ->whereIn('direct_manager_status', ['Aprobada', 'Rechazada'])
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        }
        return collect([]);
    }

    private function getFilteredRequests()
    {
        $query = RequestVacations::with(['user.job.departamento', 'requestDays', 'reveal'])
            ->where('type_request', 'Vacaciones');

        // FILTRAR POR JEFE DIRECTO ASIGNADO
        // LÓGICA CORRECTA: Solo mostrar solicitudes donde el usuario autenticado 
        // sea EXACTAMENTE el direct_manager_id asignado en la solicitud.
        // Esto respeta la configuración de manager_approvers que se asigna 
        // automáticamente al crear la solicitud.
        
        $query->where('direct_manager_id', auth()->id());

        // Aplicar filtro de búsqueda
        if ($this->search) {
            $query->where(function (Builder $q) {
                $q->whereHas('user', function (Builder $userQuery) {
                    $userQuery->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })->orWhere('reason', 'like', '%' . $this->search . '%');
            });
        }

        // Aplicar filtro de empleado
        if ($this->userFilter) {
            $query->where('user_id', $this->userFilter);
        }

        // Aplicar filtro de departamento
        if ($this->departmentFilter) {
            $query->whereHas('user.job.departamento', function (Builder $q) {
                $q->where('id', $this->departmentFilter);
            });
        }

        return $query;
    }

    public function getUsersProperty()
    {
        return User::whereHas('job')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
    }

    public function getDepartmentsProperty()
    {
        return Departamento::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.vacaciones-jefe-directo');
    }
}
