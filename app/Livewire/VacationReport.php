<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Departamento;
use App\Models\RequestVacations;
use App\Models\VacationsAvailable;
use App\Models\SystemLog;
use App\Services\VacationCalculatorService;
use App\Services\VacationPeriodCreatorService;
use App\Services\VacationDailyAccumulatorService;
use App\Services\VacationImportService;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Options;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use WireUi\Traits\Actions;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\BorderStyle;

class VacationReport extends Component
{
    use WithFileUploads, WithPagination, Actions;

    // Paginación
    public $perPage = 20;

    // Filtros
    public $userFilter = '';
    public $searchTerm = '';
    public $departmentFilter = '';
    public $selectedUserId = null;
    public $showSearchResults = false;
    public $expirationFilter = 'all'; // Opciones: 'all', 'expiring', 'expired'
    
    // Modal de vacaciones tomadas
    public $showVacationHistoryModal = false;
    public $selectedEmployeeId = null;
    public $selectedEmployeeName = '';

    // Modal de cálculo de vacaciones
    public $showCalculateVacationsModal = false;
    public $showCalculateResultsModal = false;
    public $calculationResults = null;

    // Modal de actualización de períodos
    public $showUpdatePeriodsModal = false;
    public $showUpdatePeriodsResultsModal = false;
    public $updatePeriodsResults = null;

    // Modal de actualización de días
    public $showUpdateDaysModal = false;
    public $showUpdateDaysResultsModal = false;
    public $updateDaysResults = null;

    // Usuarios con incidencias
    public $showEditIncidentModal = false;
    public $editingIncidentUserId = null;
    public $editingIncidentUser = null;
    public $editingIncidentLogs = [];
    public $editingAdmission = '';
    public $editingStatus = '';



    protected $queryString = [
        'departmentFilter' => ['except' => ''],
        'selectedUserId' => ['except' => null]
    ];

    public function mount()
    {
        // Verificar permisos de RH
        if (!auth()->user()->can('ver modulo rrhh')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }

    public function clearFilters()
    {
        $this->searchTerm = '';
        $this->selectedUserId = null;
        $this->departmentFilter = '';
        $this->expirationFilter = 'all';
        $this->showSearchResults = false;
        $this->resetPage();
    }
    
    // Reset pagination cuando cambian los filtros
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedUserId', 'departmentFilter', 'expirationFilter', 'perPage'])) {
            $this->resetPage();
        }
    }
    
    /**
     * Verifica si un empleado tiene períodos próximos a vencer (3 meses o menos)
     * con días no disfrutados
     */
    private function hasExpiringPeriods($employee)
    {
        $today = \Carbon\Carbon::today();
        $threeMonthsFromNow = $today->copy()->addMonths(3);
        
        $periods = VacationsAvailable::where('users_id', $employee->id)
            ->where('is_historical', false)
            ->get();
        
        foreach ($periods as $period) {
            $expirationDate = \Carbon\Carbon::parse($period->date_end)->addMonths(15);
            
            // Verificar si no está vencido y vence en los próximos 3 meses
            $isExpired = $today->gt($expirationDate) || 
                        $period->is_historical || 
                        (isset($period->status) && $period->status === 'vencido');
            
            // Calcular días restantes (saldo fijo - tomados)
            $daysRemaining = round($period->days_availables - $period->days_enjoyed);
            
            // Solo retornar true si está próximo a vencer Y tiene días sin disfrutar
            if (!$isExpired && $expirationDate->lte($threeMonthsFromNow) && $daysRemaining > 0) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Verifica si un empleado tiene períodos vencidos
     * con días no disfrutados
     */
    private function hasExpiredPeriods($employee)
    {
        $today = \Carbon\Carbon::today();
        
        $periods = VacationsAvailable::where('users_id', $employee->id)
            ->where('is_historical', false)
            ->get();
        
        foreach ($periods as $period) {
            $expirationDate = \Carbon\Carbon::parse($period->date_end)->addMonths(15);
            
            // Verificar si está vencido
            $isExpired = $today->gt($expirationDate) || 
                        $period->is_historical || 
                        (isset($period->status) && $period->status === 'vencido');
            
            // Calcular días restantes (saldo fijo - tomados)
            $daysRemaining = round($period->days_availables - $period->days_enjoyed);
            
            // Solo retornar true si está vencido Y tiene días sin disfrutar (días perdidos)
            if ($isExpired && $daysRemaining > 0) {
                return true;
            }
        }
        
        return false;
    }

    public function selectUser($userId, $userName)
    {
        $this->selectedUserId = $userId;
        $this->searchTerm = $userName;
        $this->showSearchResults = false;
    }

    public function updatedSearchTerm()
    {
        if (strlen($this->searchTerm) >= 2) {
            $this->showSearchResults = true;
            $this->selectedUserId = null;
        } else {
            $this->showSearchResults = false;
            $this->selectedUserId = null;
        }
    }

    public function clearSearch()
    {
        $this->searchTerm = '';
        $this->selectedUserId = null;
        $this->showSearchResults = false;
    }

    public function hideSearchResults()
    {
        $this->showSearchResults = false;
    }

    public function showVacationHistory($employeeId, $employeeName)
    {
        $this->selectedEmployeeId = $employeeId;
        $this->selectedEmployeeName = $employeeName;
        $this->showVacationHistoryModal = true;
    }

    public function closeVacationHistoryModal()
    {
        $this->showVacationHistoryModal = false;
        $this->selectedEmployeeId = null;
        $this->selectedEmployeeName = '';
    }

    public function showCalculateVacationsConfirm()
    {
        $this->showCalculateVacationsModal = true;
    }

    public function closeCalculateVacationsModal()
    {
        $this->showCalculateVacationsModal = false;
        $this->calculationResults = null;
    }

    public function closeCalculateResultsModal()
    {
        $this->showCalculateResultsModal = false;
        $this->calculationResults = null;
    }

    public function processCalculateVacations()
    {
        try {
            $vacationService = new VacationCalculatorService();
            
            // Recalcular para todos los usuarios
            $results = $vacationService->recalculateAllUsers();
            
            $this->calculationResults = $results;
            
            // Cerrar modal de confirmación y abrir modal de resultados
            $this->showCalculateVacationsModal = false;
            $this->showCalculateResultsModal = true;
            
            // Refrescar datos
            $this->dispatch('vacations-calculated');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al calcular vacaciones: ' . $e->getMessage());
            $this->showCalculateVacationsModal = false;
        }
    }

    public function showUpdatePeriodsConfirm()
    {
        $this->showUpdatePeriodsModal = true;
    }

    public function closeUpdatePeriodsModal()
    {
        $this->showUpdatePeriodsModal = false;
        $this->updatePeriodsResults = null;
    }

    public function closeUpdatePeriodsResultsModal()
    {
        $this->showUpdatePeriodsResultsModal = false;
        $this->updatePeriodsResults = null;
    }

    public function processUpdatePeriods()
    {
        try {
            $startTime = now();
            $periodCreator = new VacationPeriodCreatorService();
            
            // Obtener todos los usuarios activos
            $users = User::where('active', 1)->get();
            $results = [
                'total_users' => 0,
                'periods_created' => 0,
                'errors' => 0,
                'created_details' => [],
                'error_details' => [],
            ];
            
            foreach ($users as $user) {
                try {
                    $created = $periodCreator->createMissingPeriodsForUser($user);
                    $results['total_users']++;

                    if (!($created['success'] ?? false)) {
                        $results['errors']++;
                        $userName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
                        $errorMessage = $created['message'] ?? 'Sin mensaje de error';
                        
                        $results['error_details'][] = [
                            'user_id' => $user->id,
                            'user_name' => $userName,
                            'error_message' => $errorMessage,
                        ];
                        
                        Log::warning("Actualización de períodos sin éxito para usuario {$user->id}: " . $errorMessage);
                        continue;
                    }

                    $createdHistorical = $created['data']['historical'] ?? [];
                    $createdCurrent = $created['data']['current'] ?? [];
                    $totalCreatedUser = count($createdHistorical) + count($createdCurrent);
                    $results['periods_created'] += $totalCreatedUser;

                    if ($totalCreatedUser > 0) {
                        $userName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));

                        foreach (array_merge($createdHistorical, $createdCurrent) as $period) {
                            $results['created_details'][] = [
                                'user_id' => $user->id,
                                'user_name' => $userName,
                                'period' => $period->period,
                                'date_start' => optional($period->date_start)->format('Y-m-d') ?? (string) $period->date_start,
                                'date_end' => optional($period->date_end)->format('Y-m-d') ?? (string) $period->date_end,
                                'status' => $period->status ?? 'actual',
                                'is_historical' => (bool) ($period->is_historical ?? false),
                            ];
                        }
                    }
                } catch (\Exception $e) {
                    $results['errors']++;
                    $userName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
                    $errorMessage = $e->getMessage();
                    
                    $results['error_details'][] = [
                        'user_id' => $user->id,
                        'user_name' => $userName,
                        'error_message' => $errorMessage,
                    ];
                    
                    Log::error("Error actualizando períodos para usuario {$user->id}: " . $errorMessage);
                }
            }
            
            $endTime = now();
            $duration = $startTime->diffInSeconds($endTime);
            
            $results['duration'] = $duration;
            $this->updatePeriodsResults = $results;
            
            // Cerrar modal de confirmación y abrir modal de resultados
            $this->showUpdatePeriodsModal = false;
            $this->showUpdatePeriodsResultsModal = true;
            
            // Refrescar datos
            $this->dispatch('periods-updated');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar períodos: ' . $e->getMessage());
            $this->showUpdatePeriodsModal = false;
        }
    }

    public function showUpdateDaysConfirm()
    {
        $this->showUpdateDaysModal = true;
    }

    public function closeUpdateDaysModal()
    {
        $this->showUpdateDaysModal = false;
        $this->updateDaysResults = null;
    }

    public function closeUpdateDaysResultsModal()
    {
        $this->showUpdateDaysResultsModal = false;
        $this->updateDaysResults = null;
    }

    public function processUpdateDays()
    {
        try {
            $startTime = now();
            $dailyAccumulator = new VacationDailyAccumulatorService();
            
            // Ejecutar actualización masiva
            $results = $dailyAccumulator->updateDailyAccumulationForAllUsers();
            
            $endTime = now();
            $duration = $startTime->diffInSeconds($endTime);
            
            $results['duration'] = $duration;
            $this->updateDaysResults = $results;
            
            // Cerrar modal de confirmación y abrir modal de resultados
            $this->showUpdateDaysModal = false;
            $this->showUpdateDaysResultsModal = true;
            
            // Refrescar datos
            $this->dispatch('days-updated');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar días: ' . $e->getMessage());
            $this->showUpdateDaysModal = false;
        }
    }

    #[Computed]
    public function vacationHistory()
    {
        if (!$this->selectedEmployeeId) {
            return collect([]);
        }

        // Obtener todas las solicitudes de vacaciones aprobadas del empleado
        $vacations = RequestVacations::where('user_id', $this->selectedEmployeeId)
            ->where('type_request', 'Vacaciones')
            ->where('direct_manager_status', 'Aprobada')
            ->where('human_resources_status', 'Aprobada')
            ->with(['approvedRequests'])
            ->orderBy('start', 'desc')
            ->get();

        // Agrupar por año
        $grouped = $vacations->groupBy(function($vacation) {
            return date('Y', strtotime($vacation->start));
        });

        // Formatear los datos
        return $grouped->map(function($yearVacations, $year) {
            $vacationDetails = $yearVacations->map(function($vacation) {
                $daysCount = $vacation->approvedRequests->count();
                
                return [
                    'id' => $vacation->id,
                    'start' => $vacation->start,
                    'end' => $vacation->end,
                    'days_count' => $daysCount,
                    'approved_days' => $vacation->approvedRequests->map(function($day) {
                        return date('d/m/Y', strtotime($day->start));
                    })->toArray()
                ];
            });

            return [
                'year' => $year,
                'total_days' => $vacationDetails->sum('days_count'),
                'vacations' => $vacationDetails
            ];
        })->sortKeysDesc();
    }

    #[Computed]
    public function searchResults()
    {
        if (strlen($this->searchTerm) < 2) {
            return collect([]);
        }

        return User::with(['job.departamento'])
            ->whereHas('job')
            ->where('active', 1)
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $this->searchTerm . '%']);
            })
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->limit(10)
            ->get();
    }

    #[Computed]
    public function availableYears()
    {
        $currentYear = (int)date('Y');
        
        // Buscar la fecha de admisión más antigua de todos los empleados activos
        $oldestAdmission = User::whereHas('job')
            ->where('active', 1)
            ->whereNotNull('admission')
            ->where('admission', '!=', '0000-00-00')
            ->where('admission', '!=', '0000-00-00 00:00:00')
            ->where('admission', '>', '1900-01-01') // Filtrar fechas absurdas
            ->orderBy('admission', 'asc')
            ->value('admission');
        
        if ($oldestAdmission) {
            // Extraer el año de la fecha (ej: 2008-08-08 -> 2008)
            $admissionYear = (int)date('Y', strtotime($oldestAdmission));
        } else {
            // Si no hay fechas válidas, usar 10 años atrás como predeterminado
            $admissionYear = $currentYear - 10;
        }
        
        // Generar array de años desde la admisión más antigua hasta año siguiente
        $years = [];
        for ($year = $admissionYear; $year <= $currentYear + 1; $year++) {
            $years[] = $year;
        }
        
        return $years;
    }

    #[Computed]
    public function departments()
    {
        return Departamento::orderBy('name')->get();
    }

    #[Computed]
    public function allEmployees()
    {
        return User::with(['job.departamento'])
            ->whereHas('job')
            ->where('active', 1)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
    }

    #[Computed]
    public function employeesData()
    {
        $calculator = app(VacationCalculatorService::class);
        $currentYear = date('Y');

        // Obtener todos los usuarios activos con sus relaciones
        $employees = User::with(['job.departamento', 'requestVacations', 'jefe'])
            ->whereHas('job')
            ->where('active', 1)
            ->orderBy('id')
            ->get();

        // Aplicar filtros
        if ($this->selectedUserId) {
            $employees = $employees->filter(function ($employee) {
                return $employee->id == $this->selectedUserId;
            });
        }

        if ($this->departmentFilter) {
            $employees = $employees->filter(function ($employee) {
                return $employee->job && 
                       $employee->job->departamento && 
                       $employee->job->departamento->id == $this->departmentFilter;
            });
        }
        
        // Aplicar filtro de vencimiento de períodos
        if ($this->expirationFilter === 'expiring') {
            // Solo períodos próximos a vencer (3 meses o menos)
            $employees = $employees->filter(function ($employee) {
                return $this->hasExpiringPeriods($employee);
            });
        } elseif ($this->expirationFilter === 'expired') {
            // Solo períodos vencidos
            $employees = $employees->filter(function ($employee) {
                return $this->hasExpiredPeriods($employee);
            });
        }
        // Si es 'all', no se aplica ningún filtro adicional

        // Procesar datos de vacaciones para cada empleado
        $processedEmployees = $employees->map(function ($employee) use ($calculator, $currentYear) {
            // Obtener datos de vacaciones del servicio
            $vacationData = $calculator->getAvailableDaysForUser($employee);
            
            // Calcular días tomados en el año actual
            $daysTaken = RequestVacations::where('user_id', $employee->id)
                ->where('human_resources_status', 'Aprobada')
                ->whereHas('requestDays', function ($query) use ($currentYear) {
                    $query->whereYear('start', $currentYear);
                })
                ->with('requestDays')
                ->get()
                ->sum(function ($request) use ($currentYear) {
                    return $request->requestDays->filter(function ($day) use ($currentYear) {
                        return date('Y', strtotime($day->start)) == $currentYear;
                    })->count();
                });

            // Obtener solicitudes del año para mostrar períodos
            $vacationPeriods = RequestVacations::where('user_id', $employee->id)
                ->where('human_resources_status', 'Aprobada')
                ->whereHas('requestDays', function ($query) use ($currentYear) {
                    $query->whereYear('start', $currentYear);
                })
                ->with('requestDays')
                ->get()
                ->map(function ($request) use ($currentYear) {
                    $days = $request->requestDays->filter(function ($day) use ($currentYear) {
                        return date('Y', strtotime($day->start)) == $currentYear;
                    })->sortBy('start');
                    
                    if ($days->count() > 0) {
                        return [
                            'start' => $days->first()->start,
                            'end' => $days->last()->start,
                            'days_count' => $days->count(),
                            'type' => $request->type_request
                        ];
                    }
                    return null;
                })->filter()->values();

            // Obtener TODOS los períodos de vacaciones del usuario (más reciente primero)
            $allVacationPeriods = VacationsAvailable::where('users_id', $employee->id)
                ->orderBy('date_end', 'desc')
                ->get();

            $today = \Carbon\Carbon::today();
            $oldestActivePeriod = $allVacationPeriods
                ->filter(function ($period) use ($today) {
                    $cutoffDate = !empty($period->cutoff_date)
                        ? \Carbon\Carbon::parse($period->cutoff_date)->endOfDay()
                        : \Carbon\Carbon::parse($period->date_end)->addMonths(15)->endOfDay();

                    $isExpired = $today->gt($cutoffDate)
                        || $period->is_historical
                        || (isset($period->status) && $period->status === 'vencido');

                    return !$isExpired;
                })
                ->sortBy('date_end')
                ->first();

            $oldestActivePeriodDaysToExpire = null;
            $oldestActivePeriodCutoffDate = null;
            $oldestActivePeriodLabel = null;

            if ($oldestActivePeriod) {
                $oldestCutoffDate = !empty($oldestActivePeriod->cutoff_date)
                    ? \Carbon\Carbon::parse($oldestActivePeriod->cutoff_date)->endOfDay()
                    : \Carbon\Carbon::parse($oldestActivePeriod->date_end)->addMonths(15)->endOfDay();

                $oldestActivePeriodDaysToExpire = $today->diffInDays($oldestCutoffDate, false);
                $oldestActivePeriodCutoffDate = $oldestCutoffDate->format('Y-m-d');
                $oldestActivePeriodLabel = 'Período ' . ($oldestActivePeriod->period ?? 'N/D');
            }
            
            // Verificar si tiene períodos próximos a vencer
            $hasExpiringPeriods = $this->hasExpiringPeriods($employee);
            
            // Verificar si tiene períodos vencidos
            $hasExpiredPeriods = $this->hasExpiredPeriods($employee);

            // Usar datos calculados por el servicio
            $daysEntitled = $vacationData['total_available'];
            $daysRemaining = $vacationData['total_remaining'];

            return [
                'employee' => $employee,
                'days_entitled' => $daysEntitled,
                'days_taken' => $daysTaken,
                'days_remaining' => $daysRemaining,
                'vacation_periods' => $vacationPeriods,
                'all_vacation_periods' => $allVacationPeriods,
                'oldest_active_period' => $oldestActivePeriod,
                'oldest_active_period_days_to_expire' => $oldestActivePeriodDaysToExpire,
                'oldest_active_period_cutoff_date' => $oldestActivePeriodCutoffDate,
                'oldest_active_period_label' => $oldestActivePeriodLabel,
                'has_expiring_periods' => $hasExpiringPeriods,
                'has_expired_periods' => $hasExpiredPeriods,
                'year' => $currentYear,
                'vacation_data' => $vacationData
            ];
        });
        
        // Aplicar paginación manual
        $currentPage = $this->getPage();
        $total = $processedEmployees->count();
        $offset = ($currentPage - 1) * $this->perPage;
        
        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $processedEmployees->slice($offset, $this->perPage)->values(),
            $total,
            $this->perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return $paginatedData;
    }

    public function exportToExcel()
    {
        $currentYear = date('Y');
        $today = \Carbon\Carbon::today();
        
        // Obtener empleados aplicando los filtros activos
        $employees = User::with(['job.departamento'])
            ->whereHas('job')
            ->where('active', 1)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        
        // Aplicar filtro por usuario específico
        if ($this->selectedUserId) {
            $employees = $employees->filter(function ($employee) {
                return $employee->id == $this->selectedUserId;
            });
        }
        
        // Aplicar filtro por departamento
        if ($this->departmentFilter) {
            $employees = $employees->filter(function ($employee) {
                return $employee->job && 
                       $employee->job->departamento && 
                       $employee->job->departamento->id == $this->departmentFilter;
            });
        }
        
        // Aplicar filtro de vencimiento de períodos
        if ($this->expirationFilter === 'expiring') {
            $employees = $employees->filter(function ($employee) {
                return $this->hasExpiringPeriods($employee);
            });
        } elseif ($this->expirationFilter === 'expired') {
            $employees = $employees->filter(function ($employee) {
                return $this->hasExpiredPeriods($employee);
            });
        }
        
        // Preparar datos para una sola tabla
        $exportData = [];
        
        // Título del reporte
        $titleSuffix = '';
        if ($this->selectedUserId || $this->departmentFilter || $this->expirationFilter !== 'all') {
            $titleSuffix = ' (FILTRADO)';
        }
        
        $exportData[] = [
            'REPORTE DETALLADO DE VACACIONES POR PERÍODOS' . $titleSuffix,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];
        
        // Fecha de generación y filtros aplicados
        $filterInfo = 'Fecha de generación: ' . date('d/m/Y H:i:s');
        if ($this->selectedUserId) {
            $selectedUser = $employees->first();
            if ($selectedUser) {
                $filterInfo .= ' | Usuario: ' . $selectedUser->first_name . ' ' . $selectedUser->last_name;
            }
        }
        if ($this->departmentFilter) {
            $dept = \App\Models\Departamento::find($this->departmentFilter);
            if ($dept) {
                $filterInfo .= ' | Departamento: ' . $dept->name;
            }
        }
        if ($this->expirationFilter === 'expiring') {
            $filterInfo .= ' | Solo períodos próximos a vencer (≤3 meses) con días sin disfrutar';
        } elseif ($this->expirationFilter === 'expired') {
            $filterInfo .= ' | Solo períodos vencidos con días sin disfrutar (perdidos)';
        }
        
        $exportData[] = [
            $filterInfo,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];
        
        // Fila vacía
        $exportData[] = ['', '', '', '', '', '', '', '', '', '', ''];
        
        // Encabezados de columnas (una sola vez)
        $exportData[] = [
            'Nombre Empleado',
            'Departamento',
            'Cargo',
            'Fecha Ingreso',
            'Fecha Aniversario',
            'Fecha Vencimiento',
            'Días Disponibles',
            'Días Tomados',
            'Días Restantes',
            'Estado',
            'Días Perdidos/Pendientes'
        ];
        
        // Agrupar empleados por departamento para mantener el orden
        $employeesByDepartment = $employees->groupBy(function($employee) {
            return $employee->job && $employee->job->departamento 
                ? $employee->job->departamento->name 
                : 'Sin Departamento';
        })->sortKeys();
        
        // Recorrer todos los departamentos y empleados
        foreach ($employeesByDepartment as $departmentName => $employees) {
            foreach ($employees as $employee) {
                // Obtener TODOS los períodos del empleado (incluyendo vigentes y vencidos)
                $allPeriods = VacationsAvailable::where('users_id', $employee->id)
                    ->where('is_historical', false)
                    ->orderBy('date_start')
                    ->get();
                
                // Aplicar filtro de vencimiento si está activo
                if ($this->expirationFilter === 'expiring') {
                    // Solo períodos próximos a vencer (≤3 meses) con días sin disfrutar
                    $threeMonthsFromNow = $today->copy()->addMonths(3);
                    $allPeriods = $allPeriods->filter(function($period) use ($today, $threeMonthsFromNow) {
                        $expirationDate = \Carbon\Carbon::parse($period->date_end)->addMonths(15);
                        
                        // Verificar si no está vencido
                        $isExpired = $today->gt($expirationDate) || 
                                    $period->is_historical || 
                                    (isset($period->status) && $period->status === 'vencido');
                        
                        // Calcular días restantes (saldo fijo - tomados)
                        $daysRemaining = round($period->days_availables - $period->days_enjoyed);
                        
                        // Retornar solo períodos que no estén vencidos Y vencen en los próximos 3 meses Y tienen días sin disfrutar
                        return !$isExpired && $expirationDate->lte($threeMonthsFromNow) && $daysRemaining > 0;
                    });
                } elseif ($this->expirationFilter === 'expired') {
                    // Solo períodos vencidos con días sin disfrutar (días perdidos)
                    $allPeriods = $allPeriods->filter(function($period) use ($today) {
                        $expirationDate = \Carbon\Carbon::parse($period->date_end)->addMonths(15);
                        
                        // Verificar si está vencido
                        $isExpired = $today->gt($expirationDate) || 
                                    $period->is_historical || 
                                    (isset($period->status) && $period->status === 'vencido');
                        
                        // Calcular días restantes (saldo fijo - tomados)
                        $daysRemaining = round($period->days_availables - $period->days_enjoyed);
                        
                        // Retornar solo períodos vencidos Y con días sin disfrutar (perdidos)
                        return $isExpired && $daysRemaining > 0;
                    });
                }
                // Si es 'all', no se filtra nada
                
                // Procesar cada período
                foreach ($allPeriods as $period) {
                    $dateStart = \Carbon\Carbon::parse($period->date_start);
                    $dateEnd = \Carbon\Carbon::parse($period->date_end);
                    $expirationDate = $dateEnd->copy()->addMonths(15);
                    
                    // Verificar si el período está vencido
                    $isExpiredByDate = $today->gt($expirationDate);
                    $isExpired = $period->is_historical || 
                                 (isset($period->status) && $period->status === 'vencido') || 
                                 $isExpiredByDate;
                    
                    // Calcular días tomados de este período específico
                    $daysTaken = \App\Models\RequestVacations::where('user_id', $employee->id)
                        ->where('human_resources_status', 'Aprobada')
                        ->whereHas('requestDays', function ($query) use ($dateStart, $dateEnd) {
                            $query->whereBetween('start', [$dateStart, $dateEnd]);
                        })
                        ->with('requestDays')
                        ->get()
                        ->sum(function ($request) use ($dateStart, $dateEnd) {
                            return $request->requestDays->filter(function ($day) use ($dateStart, $dateEnd) {
                                $dayDate = \Carbon\Carbon::parse($day->start);
                                return $dayDate->between($dateStart, $dateEnd);
                            })->count();
                        });
                    
                    // days_availables ya ES el saldo real, solo restar reservados
                    $daysRemaining = $period->days_availables - ($period->days_reserved ?? 0);
                    
                    // Determinar estado y días perdidos/pendientes para mostrar en el Excel
                    $status = 'VIGENTE';
                    $daysRemainingRounded = round($daysRemaining);
                    $daysLostOrPending = '';
                    
                    if ($isExpired) {
                        // Si está vencido
                        $status = 'VENCIDO';
                        if ($daysRemainingRounded > 0) {
                            $daysLostOrPending = $daysRemainingRounded . ' día' . ($daysRemainingRounded != 1 ? 's' : '') . ' perdido' . ($daysRemainingRounded != 1 ? 's' : '');
                        } else {
                            $daysLostOrPending = 'Completamente disfrutado';
                        }
                    } else {
                        // Verificar si está próximo a vencer (3 meses o menos)
                        $threeMonthsFromNow = $today->copy()->addMonths(3);
                        if ($expirationDate->lte($threeMonthsFromNow)) {
                            $status = 'PRÓXIMO A VENCER';
                            if ($daysRemainingRounded > 0) {
                                $daysLostOrPending = $daysRemainingRounded . ' día' . ($daysRemainingRounded != 1 ? 's' : '') . ' pendiente' . ($daysRemainingRounded != 1 ? 's' : '');
                            } else {
                                $daysLostOrPending = 'Sin días pendientes';
                            }
                        } else {
                            // Vigente normal
                            $status = 'VIGENTE';
                            if ($daysRemainingRounded > 0) {
                                $daysLostOrPending = $daysRemainingRounded . ' día' . ($daysRemainingRounded != 1 ? 's' : '') . ' disponible' . ($daysRemainingRounded != 1 ? 's' : '');
                            } else {
                                $daysLostOrPending = 'Completamente disfrutado';
                            }
                        }
                    }
                    
                    $exportData[] = [
                        $employee->first_name . ' ' . $employee->last_name,
                        $employee->job && $employee->job->departamento ? $employee->job->departamento->name : 'Sin asignar',
                        $employee->job ? $employee->job->name : 'Sin cargo',
                        $dateStart->format('d/m/Y'),
                        $dateEnd->format('d/m/Y'),
                        $expirationDate->format('d/m/Y'),
                        number_format($period->days_availables, 2),
                        number_format($period->days_enjoyed, 2),
                        number_format($daysRemaining, 2),
                        $status,
                        $daysLostOrPending
                    ];
                }
                
                // Si el empleado no tiene períodos, agregar una fila vacía
                if ($allPeriods->isEmpty()) {
                    $exportData[] = [
                        $employee->first_name . ' ' . $employee->last_name,
                        $employee->job && $employee->job->departamento ? $employee->job->departamento->name : 'Sin asignar',
                        $employee->job ? $employee->job->name : 'Sin cargo',
                        'Sin períodos',
                        '',
                        '',
                        '0.00',
                        '0.00',
                        '0.00',
                        'SIN DATOS',
                        ''
                    ];
                }
            }
        }
        
        // Construir nombre del archivo dinámico según filtros
        $fileNameParts = ['reporte_vacaciones'];
        
        if ($this->selectedUserId) {
            $selectedUser = $employees->first();
            if ($selectedUser) {
                $userName = strtolower(str_replace(' ', '_', $selectedUser->first_name . '_' . $selectedUser->last_name));
                $fileNameParts[] = $userName;
            }
        } elseif ($this->departmentFilter) {
            $dept = \App\Models\Departamento::find($this->departmentFilter);
            if ($dept) {
                $deptName = strtolower(str_replace(' ', '_', $dept->name));
                $fileNameParts[] = $deptName;
            }
        }
        
        $fileNameParts[] = date('Y-m-d_His');
        $fileName = implode('_', $fileNameParts) . '.xlsx';
        $filePath = storage_path('app/' . $fileName);
        
        // Crear el escritor de Excel con OpenSpout
        $writer = new Writer();
        $writer->openToFile($filePath);
        
        // Configurar nombre de la primera hoja (actual)
        $currentSheet = $writer->getCurrentSheet();
        $currentSheet->setName('Períodos de Vacaciones');
        
        // ========== HOJA 1: PERÍODOS DE VACACIONES ==========
        // Agregar datos de períodos
        foreach ($exportData as $rowData) {
            $cells = [];
            foreach ($rowData as $cellValue) {
                $cells[] = $cellValue;
            }
            $writer->addRow(Row::fromValues($cells));
        }
        
        // Agregar nueva hoja para solicitudes
        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $newSheet->setName('Solicitudes Aprobadas');
        
        // ========== HOJA 2: SOLICITUDES DE VACACIONES ==========
        // Título con indicador de filtro
        $titleSolicitudes = 'SOLICITUDES DE VACACIONES APROBADAS' . ($titleSuffix ? ' (FILTRADO)' : '');
        $writer->addRow(Row::fromValues([$titleSolicitudes, '', '', '', '', '', '', '', '']));
        
        // Fecha de generación con filtros
        $writer->addRow(Row::fromValues([$filterInfo, '', '', '', '', '', '', '', '']));
        
        // Fila vacía
        $writer->addRow(Row::fromValues(['', '', '', '', '', '', '', '', '']));
        
        // Encabezados
        $writer->addRow(Row::fromValues([
            'Fecha de Solicitud',
            'Nombre',
            'Departamento',
            'Cargo',
            'Período',
            'Fecha Vencimiento',
            'Días Solicitados',
            'Tipo',
            'Estatus'
        ]));
        
        // Obtener solicitudes aprobadas aplicando filtros
        $requestsQuery = RequestVacations::with(['user.job.departamento', 'requestDays'])
            ->where('type_request', 'Vacaciones')
            ->where('human_resources_status', 'Aprobada');
        
        // Aplicar filtro por usuario específico
        if ($this->selectedUserId) {
            $requestsQuery->where('user_id', $this->selectedUserId);
        }
        
        // Aplicar filtro por departamento
        if ($this->departmentFilter) {
            $requestsQuery->whereHas('user.job.departamento', function($query) {
                $query->where('id', $this->departmentFilter);
            });
        }
        
        $approvedRequests = $requestsQuery->orderBy('created_at', 'desc')->get();
        
        // Agregar datos de solicitudes
        foreach ($approvedRequests as $request) {
            $user = $request->user;
            
            // Contar días aprobados
            $daysCount = $request->requestDays->count();
            
            // Crear lista de fechas si hay múltiples días
            $datesList = '';
            if ($daysCount > 1) {
                $dates = $request->requestDays->pluck('start')->map(function($date) {
                    return \Carbon\Carbon::parse($date)->format('d/m/Y');
                })->toArray();
                $datesList = ' (' . implode(', ', $dates) . ')';
            }
            
            // Extraer información del período desde opcion (formato: "3|2024-07-03")
            $periodInfo = '';
            $expirationInfo = '';
            
            if (!empty($request->opcion)) {
                $parts = explode('|', $request->opcion);
                if (count($parts) === 2) {
                    list($periodNumber, $startDate) = $parts;
                    
                    // Calcular end_date (start_date + 1 año)
                    $startCarbon = \Carbon\Carbon::parse($startDate);
                    $endCarbon = $startCarbon->copy()->addYear();
                    
                    // Formato del período: "2024-07-03 - 2025-07-03"
                    $periodInfo = $startCarbon->format('d/m/Y') . ' - ' . $endCarbon->format('d/m/Y');
                    
                    // Calcular fecha de vencimiento (end_date + 15 meses)
                    $expirationCarbon = $endCarbon->copy()->addMonths(15);
                    $expirationInfo = $expirationCarbon->format('d/m/Y');
                }
            }
            
            $writer->addRow(Row::fromValues([
                \Carbon\Carbon::parse($request->created_at)->format('d/m/Y'),
                $user->first_name . ' ' . $user->last_name,
                $user->job && $user->job->departamento ? $user->job->departamento->name : 'Sin asignar',
                $user->job ? $user->job->name : 'Sin cargo',
                $periodInfo ?: 'N/A',
                $expirationInfo ?: 'N/A',
                $daysCount . ($daysCount > 1 ? ' días' : ' día') . $datesList,
                'Vacaciones',
                'Aprobado'
            ]));
        }
        
        // Cerrar el archivo
        $writer->close();
        
        // Descargar el archivo
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    /**
     * Exportar vacaciones de todos los empleados en formato Excel con colores
     */
    public function exportVacations()
    {
        try {
            $currentYear = date('Y');
            $previousYear = $currentYear - 1;
            $nextYear = $currentYear + 1;

            // Crear nuevo spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // A1: GPT SERVICES
            $sheet->setCellValue('A1', 'GPT SERVICES');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            
            // A2: VACACIONES 2026 (año dinámico)
            $sheet->setCellValue('A2', 'VACACIONES ' . $currentYear);
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);

            // Fila 4: Headers con colores
            $headers = [
                'B4' => ['text' => 'No.', 'color' => 'B4D7FF'], // Azul claro
                'C4' => ['text' => 'NOMBRE', 'color' => 'B4D7FF'],
                'D4' => ['text' => '', 'color' => 'FFFFFF'], // Vacía
                'E4' => ['text' => '', 'color' => 'FFFFFF'], // Vacía
                'F4' => ['text' => '', 'color' => 'FFFFFF'], // Vacía
                'G4' => ['text' => '', 'color' => 'FFFFFF'], // Vacía
                'H4' => ['text' => '', 'color' => 'FFFFFF'], // Vacía
                'I4' => ['text' => '', 'color' => 'FFFFFF'], // Vacía
                'J4' => ['text' => "Saldo Pendiente\nPeriodo\n{$previousYear}-{$currentYear}", 'color' => 'B4D7FF'],
                'K4' => ['text' => "Fecha de\nAniversario", 'color' => '0066FF'], // Azul brillante
                'L4' => ['text' => 'Antigüedad', 'color' => 'B4D7FF'],
                'M4' => ['text' => "Días De vacaciones\nCorrespondientes\nPeriodo", 'color' => 'D9D9D9'], // Gris
                'N4' => ['text' => "Días disfrutados\nantes de la fecha de\nAniversario", 'color' => 'CBE5CB'], // Verde
                'O4' => ['text' => "Días\nDisfrutados\nperiodo\n{$currentYear}-{$nextYear}", 'color' => 'B4D7FF'],
                'P4' => ['text' => "Días disfrutados\ndespues de\nfecha de\naniversario", 'color' => 'F4C7C3'], // Rosa
                'Q4' => ['text' => "Saldo\nPendiente\nPeriodo\n{$currentYear}-{$nextYear}", 'color' => 'B4D7FF'],
            ];

            foreach ($headers as $cell => $header) {
                $sheet->setCellValue($cell, $header['text']);
                $sheet->getStyle($cell)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 10,
                        'color' => ['rgb' => $header['color'] === '0066FF' ? 'FFFFFF' : '000000'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => $header['color']],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
            }

            // Ajustar altura de fila de headers
            $sheet->getRowDimension(4)->setRowHeight(60);

            // Ocultar columnas D, E, F, G, H, I
            foreach (range('D', 'I') as $col) {
                $sheet->getColumnDimension($col)->setVisible(false);
            }

            // Obtener usuarios activos y aplicar filtros actuales del reporte
            $employees = User::with(['job.departamento', 'jefe'])
                ->whereHas('job')
                ->where('active', 1)
                ->orderBy('id')
                ->get();

            if ($this->selectedUserId) {
                $employees = $employees->filter(function ($employee) {
                    return $employee->id == $this->selectedUserId;
                });
            }

            if ($this->departmentFilter) {
                $employees = $employees->filter(function ($employee) {
                    return $employee->job
                        && $employee->job->departamento
                        && $employee->job->departamento->id == $this->departmentFilter;
                });
            }

            if ($this->expirationFilter === 'expiring') {
                $employees = $employees->filter(function ($employee) {
                    return $this->hasExpiringPeriods($employee);
                });
            } elseif ($this->expirationFilter === 'expired') {
                $employees = $employees->filter(function ($employee) {
                    return $this->hasExpiredPeriods($employee);
                });
            }

            if ($employees->isEmpty()) {
                $this->notification()->warning(
                    'Sin resultados para exportar',
                    'No hay empleados que coincidan con los filtros actuales.'
                );

                return null;
            }

            $row = 5; // Empezar datos en fila 5
            
            foreach ($employees as $employee) {
                // Obtener períodos ordenados por fecha descendente
                $periods = VacationsAvailable::where('users_id', $employee->id)
                    ->orderBy('date_end', 'desc')
                    ->get();

                // Período actual: el que tiene end_date en el año actual
                $periodoActual = $periods->filter(function($period) use ($currentYear) {
                    $endYear = \Carbon\Carbon::parse($period->date_end)->year;
                    return $endYear == $currentYear;
                })->first();
                
                // Si no hay período actual, usar el más reciente disponible
                $usarPeriodoAlternativo = false;
                if (!$periodoActual && $periods->isNotEmpty()) {
                    $periodoActual = $periods->first(); // El más reciente (ya ordenado desc)
                    $usarPeriodoAlternativo = true;
                }
                
                // Período anterior "viejito": el que termina en el año anterior
                $periodoAnterior = $periods->filter(function($period) use ($currentYear) {
                    $endYear = \Carbon\Carbon::parse($period->date_end)->year;
                    return $endYear == ($currentYear - 1);
                })->first();

                // B: No. (ID del usuario)
                $sheet->setCellValue("B{$row}", $employee->id);
                
                // C: NOMBRE (mayúsculas, apellidos primero, con acentos)
                $nombreCompleto = mb_strtoupper(trim($employee->last_name . ' ' . $employee->first_name), 'UTF-8');
                $sheet->setCellValue("C{$row}", $nombreCompleto);
                
                // J: Saldo pendiente período anterior (del período viejito)
                $saldoAnterior = $periodoAnterior ? ((float) ($periodoAnterior->days_availables ?? 0)) : 0;
                $sheet->setCellValue("J{$row}", number_format($saldoAnterior, 2, '.', ''));
                
                // K: Fecha de aniversario (end_date del período actual o más reciente)
                if ($periodoActual) {
                    $fechaAniversario = \Carbon\Carbon::parse($periodoActual->date_end)->format('d-M-y');
                    $sheet->setCellValue("K{$row}", $fechaAniversario);
                    
                    // Si se usa período alternativo, marcar en amarillo
                    if ($usarPeriodoAlternativo) {
                        $sheet->getStyle("K{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FFFF00'], // Amarillo
                            ],
                        ]);
                    }
                } else {
                    $sheet->setCellValue("K{$row}", '');
                }
                
                // L: Antigüedad (años en la empresa al end_date del período)
                if ($employee->admission && $periodoActual) {
                    $fechaReferencia = \Carbon\Carbon::parse($periodoActual->date_end);
                    $antiguedad = \Carbon\Carbon::parse($employee->admission)->diffInYears($fechaReferencia);
                    $sheet->setCellValue("L{$row}", $antiguedad);
                } else {
                    $sheet->setCellValue("L{$row}", 0);
                }
                
                // M: Días correspondientes período anterior (del período viejito)
                $diasCorrespondientes = $periodoAnterior ? ((float) ($periodoAnterior->days_total_period ?? 0)) : 0;
                $sheet->setCellValue("M{$row}", number_format($diasCorrespondientes, 2, '.', ''));
                
                // N: Días disfrutados antes de aniversario (del período actual)
                $diasAntesAniv = $periodoActual ? ((float) ($periodoActual->days_enjoyed_before_anniversary ?? 0)) : 0;
                $sheet->setCellValue("N{$row}", number_format($diasAntesAniv, 2, '.', ''));
                
                // Q: Saldo pendiente período actual (del período actual)
                $saldoActual = $periodoActual ? ((float) ($periodoActual->days_availables ?? 0)) : 0;
                $sheet->setCellValue("Q{$row}", number_format($saldoActual, 2, '.', ''));
                
                // O: Días disfrutados período actual (CALCULADO: Total - Saldo)
                $totalPeriodo = $periodoActual ? ((float) ($periodoActual->days_total_period ?? 0)) : 0;
                $diasDisfrutadosCalculado = max(0, $totalPeriodo - $saldoActual);
                $sheet->setCellValue("O{$row}", number_format($diasDisfrutadosCalculado, 2, '.', ''));
                
                // P: Días disfrutados después de aniversario (del período actual)
                $diasDespuesAniv = $periodoActual ? ((float) ($periodoActual->days_enjoyed_after_anniversary ?? 0)) : 0;
                $sheet->setCellValue("P{$row}", number_format($diasDespuesAniv, 2, '.', ''));
                
                $row++; // Siguiente fila
            } // Fin foreach employees
            
            // Aplicar bordes a todas las celdas de datos (B5 hasta Q + última fila)
            $lastRow = $row - 1;
            if ($lastRow >= 5) {
                $sheet->getStyle("B5:C{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
                $sheet->getStyle("J5:Q{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
            }

            // Ajustar ancho de columnas
            $sheet->getColumnDimension('B')->setWidth(8);
            $sheet->getColumnDimension('C')->setWidth(35);
            foreach (range('J', 'Q') as $col) {
                $sheet->getColumnDimension($col)->setWidth(15);
            }

            // Guardar archivo
            $fileNameParts = ['Vacaciones GPT Services', $currentYear];

            if ($this->selectedUserId) {
                $selectedUser = $employees->first();
                if ($selectedUser) {
                    $fileNameParts[] = trim($selectedUser->first_name . ' ' . $selectedUser->last_name);
                }
            } elseif ($this->departmentFilter) {
                $selectedDepartment = Departamento::find($this->departmentFilter);
                if ($selectedDepartment) {
                    $fileNameParts[] = $selectedDepartment->name;
                }
            } elseif ($this->expirationFilter === 'expiring') {
                $fileNameParts[] = 'Proximos a vencer';
            } elseif ($this->expirationFilter === 'expired') {
                $fileNameParts[] = 'Vencidos';
            }

            $fileName = implode(' - ', array_filter($fileNameParts)) . '.xlsx';
            $filePath = storage_path('app/temp/' . $fileName);
            
            // Crear directorio si no existe
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);

            $this->notification()->success(
                'Exportación Exitosa',
                'Se exportaron ' . ($row - 5) . ' empleados correctamente.'
            );

            // Descargar el archivo
            return response()->download($filePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Error exportando vacaciones: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            $this->notification()->error(
                'Error al Exportar',
                'Ocurrió un error: ' . $e->getMessage()
            );
        }
    }

    /**
     * Obtener usuarios con incidencias (logs pendientes de vacation_import)
     */
    #[Computed]
    public function usersWithIncidents()
    {
        return SystemLog::with('user')
            ->byType('vacation_import')
            ->pending()
            ->whereNotNull('user_id')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(function ($logs) {
                return [
                    'user' => $logs->first()->user,
                    'logs' => $logs,
                    'count' => $logs->count(),
                    'latest_error' => $logs->first()->message,
                ];
            });
    }

    /**
     * Editar usuario con incidencia
     */
    /**
     * Abrir modal de edición de incidencia
     */
    public function openEditIncidentModal($userId)
    {
        $user = User::with(['job.departamento'])->find($userId);
        if (!$user) {
            $this->notification()->error('Error', 'Usuario no encontrado');
            return;
        }

        $this->editingIncidentUserId = $userId;
        $this->editingIncidentUser = $user;
        $this->editingAdmission = $user->admission ? \Carbon\Carbon::parse($user->admission)->format('Y-m-d') : '';
        $this->editingStatus = $user->active;
        
        // Cargar logs del usuario
        $this->editingIncidentLogs = SystemLog::byType('vacation_import')
            ->pending()
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $this->showEditIncidentModal = true;
    }

    /**
     * Cerrar modal de edición
     */
    public function closeEditIncidentModal()
    {
        $this->showEditIncidentModal = false;
        $this->editingIncidentUserId = null;
        $this->editingIncidentUser = null;
        $this->editingIncidentLogs = [];
        $this->editingAdmission = '';
        $this->editingStatus = '';
        $this->resetErrorBag();
    }

    public function editIncidentUser($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            $this->notification()->error('Error', 'Usuario no encontrado');
            return;
        }

        $this->editingIncidentUserId = $userId;
        $this->editingAdmission = $user->admission ? \Carbon\Carbon::parse($user->admission)->format('Y-m-d') : '';
        $this->editingStatus = $user->active;
    }

    /**
     * Cancelar edición
     */
    public function cancelEditIncident()
    {
        $this->closeEditIncidentModal();
    }

    /**
     * Guardar cambios del usuario con incidencia
     */
    public function saveIncidentUser()
    {
        $this->validate([
            'editingAdmission' => 'required|date',
            'editingStatus' => 'required|in:1,2',
        ]);

        $user = User::find($this->editingIncidentUserId);
        if (!$user) {
            $this->notification()->error('Error', 'Usuario no encontrado');
            return;
        }

        $user->update([
            'admission' => $this->editingAdmission,
            'active' => $this->editingStatus,
        ]);

        // Resolver automáticamente todos los logs de este usuario
        $logs = SystemLog::byType('vacation_import')
            ->pending()
            ->where('user_id', $this->editingIncidentUserId)
            ->get();

        foreach ($logs as $log) {
            $log->markAsResolved('Datos del usuario corregidos desde el reporte de vacaciones');
        }

        $this->notification()->success(
            'Usuario actualizado',
            'Se actualizaron los datos del usuario y se resolvieron ' . $logs->count() . ' incidencias'
        );

        $this->closeEditIncidentModal();
    }

    /**
     * Marcar logs de un usuario como resueltos
     */
    public function resolveUserIncidents($userId)
    {
        $logs = SystemLog::byType('vacation_import')
            ->pending()
            ->where('user_id', $userId)
            ->get();

        $count = $logs->count();

        // Marcar todos los logs como resueltos (status = 'resolved')
        foreach ($logs as $log) {
            $log->markAsResolved('Marcado como resuelto manualmente desde el reporte de vacaciones');
        }

        $this->notification()->success(
            'Incidencias resueltas',
            'Se resolvieron ' . $count . ' incidencias del usuario'
        );
    }

    /**
     * Ignorar logs de un usuario
     */
    public function ignoreUserIncidents($userId)
    {
        $logs = SystemLog::byType('vacation_import')
            ->pending()
            ->where('user_id', $userId)
            ->get();

        foreach ($logs as $log) {
            $log->markAsIgnored('Ignorado desde el reporte de vacaciones');
        }

        $this->notification()->info(
            'Incidencias ignoradas',
            'Se marcaron ' . $logs->count() . ' incidencias como ignoradas'
        );
    }


    public function render()
    {
        return view('livewire.vacation-report');
    }
}
