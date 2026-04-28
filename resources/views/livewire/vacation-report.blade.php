<div>
    <div class="container-fluid">
        <div class="row">
            <!-- Card de Usuarios con Incidencias (separada) -->
            @if($this->usersWithIncidents->count() > 0)
                <div class="col-12 mb-3">
                    <div class="card border-stone-300 shadow-sm" x-data="{ expanded: false }">
                        <div class="card-header bg-white bg-opacity-10 border-stone-300" 
                             style="cursor: pointer;" 
                             @click="expanded = !expanded">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h5 class="mb-0">
                                            <strong>Usuarios con Incidencias</strong>
                                            <span class="badge bg-warning text-dark ms-2">{{ $this->usersWithIncidents->count() }}</span>
                                        </h5>
                                        <small class="text-muted">Usuarios con errores detectados durante la importación de vacaciones</small>
                                    </div>
                                </div>
                                <div>
                                    <i class="fas fa-chevron-up transition-all blink-icon" :class="expanded ? '' : 'fa-rotate-180'" style="transition: transform 0.3s;"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body" x-show="expanded" x-collapse>
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Instrucciones:</strong> Estos usuarios tienen incidencias, presentadas al importar vacaciones. Edita la fecha de admisión o estado del usuario, marca las incidencias como resueltas y carga el archivo nuevamente.
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-middle">
                                    <thead class="table-warning">
                                        <tr>
                                            <th width="5%" class="text-center">ID</th>
                                            <th width="25%">Usuario</th>
                                            <th width="15%" class="text-center">Fecha Admisión</th>
                                            <th width="10%" class="text-center">Estado</th>
                                            <th width="5%" class="text-center">Errores</th>
                                            <th width="25%">Último Error</th>
                                            <th width="15%" class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($this->usersWithIncidents as $userId => $incident)
                                            @php
                                                $user = $incident['user'];
                                            @endphp
                                            <tr>
                                                <td class="text-center"><strong>{{ $user->id }}</strong></td>
                                                <td>
                                                    <div>
                                                        <strong class="d-block">{{ $user->first_name }} {{ $user->last_name }}</strong>
                                                        @if($user->job)
                                                            <small class="text-muted">{{ $user->job->name ?? 'Sin puesto' }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    {{ $user->admission ? \Carbon\Carbon::parse($user->admission)->format('d/m/Y') : 'Sin fecha' }}
                                                </td>
                                                <td class="text-center">
                                                    @if($user->active == 1)
                                                        <span class="badge bg-success">Activo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactivo</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-warning text-dark fs-6">{{ $incident['count'] }}</span>
                                                </td>
                                                <td>
                                                    <small class="text-break">{{ $incident['latest_error'] }}</small>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <button wire:click="openEditIncidentModal({{ $userId }})" 
                                                                class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-edit me-1"></i> Editar
                                                        </button>
                                                        <button wire:click="resolveUserIncidents({{ $userId }})" 
                                                                class="btn btn-outline-success btn-sm"
                                                                onclick="return confirm('¿Marcar las {{ $incident['count'] }} incidencias como resueltas?')">
                                                            <i class="fas fa-check-circle me-1"></i> Marcar como Resuelto
                                                        </button>
                                                        <button wire:click="ignoreUserIncidents({{ $userId }})" 
                                                                class="btn btn-outline-secondary btn-sm"
                                                                onclick="return confirm('¿Ignorar las {{ $incident['count'] }} incidencias?')">
                                                            <i class="fas fa-trash-alt me-1"></i> Eliminar
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Card Principal de Reporte de Vacaciones -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="card-title mb-1">
                                    <i class="fas fa-chart-bar"></i> 
                                    Reporte de Vacaciones - Recursos Humanos
                                </h3>
                                <small class="text-muted d-block">Resumen general de vacaciones de todos los empleados</small>
                            </div>
                            <div class="d-flex gap-2">
                                @role('super-admin')
                                <!-- Actualizar Períodos -->
                                <button wire:click="showUpdatePeriodsConfirm" class="btn btn-primary" wire:loading.attr="disabled" title="Crear períodos faltantes para todos los empleados">
                                    <span wire:loading.remove wire:target="showUpdatePeriodsConfirm">
                                        <i class="fas fa-calendar-plus"></i> Actualizar Períodos
                                    </span>
                                    <span wire:loading wire:target="showUpdatePeriodsConfirm">
                                        <i class="fas fa-spinner fa-spin"></i> Cargando...
                                    </span>
                                </button>
                                
                                <!-- Actualizar Días -->
                                <button wire:click="showUpdateDaysConfirm" class="btn btn-success" wire:loading.attr="disabled" title="Actualizar acumulación diaria de días de vacaciones">
                                    <span wire:loading.remove wire:target="showUpdateDaysConfirm">
                                        <i class="fas fa-sync-alt"></i> Actualizar Días
                                    </span>
                                    <span wire:loading wire:target="showUpdateDaysConfirm">
                                        <i class="fas fa-spinner fa-spin"></i> Actualizando...
                                    </span>
                                </button>
                                @endrole
                                
                                <!-- Importar Vacaciones -->
                                <a href="{{ route('vacaciones.importar') }}" class="btn btn-warning" title="Importar vacaciones desde archivo Excel">
                                    <i class="fas fa-file-import"></i> Importar Vacaciones
                                </a>
                                
                                <!-- Exportar Vacaciones -->
                                <button wire:click="exportVacations" class="btn btn-info text-white" wire:loading.attr="disabled" title="Exportar vacaciones aplicando los filtros actuales a Excel">
                                    <span wire:loading.remove wire:target="exportVacations">
                                        <i class="fas fa-file-excel"></i> Exportar Vacaciones
                                    </span>
                                    <span wire:loading wire:target="exportVacations">
                                        <i class="fas fa-spinner fa-spin"></i> Exportando...
                                    </span>
                                </button>

                                <a href="{{ url('/vacaciones/calendario') }}" class="btn btn-primary" title="Ir al calendario de vacaciones">
                                    <i class="fas fa-calendar-alt"></i> Calendario de Vacaciones
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Filtros Dinámicos -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">
                                             Buscar Empleado
                                        </label>
                                        <div class="position-relative">
                                            <input 
                                                type="text" 
                                                wire:model.live.debounce.300ms="searchTerm" 
                                                class="form-control" 
                                                placeholder="Escribe el nombre del empleado..."
                                                autocomplete="off">
                                            @if($searchTerm)
                                                <button 
                                                    type="button" 
                                                    wire:click="clearSearch" 
                                                    class="btn btn-sm btn-link position-absolute end-0 top-50 translate-middle-y text-muted"
                                                    style="z-index: 10;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                            
                                            <!-- Resultados de búsqueda -->
                                            @if($showSearchResults && $this->searchResults->count() > 0)
                                                <div class="position-absolute w-100 bg-white border rounded shadow-lg mt-1" style="z-index: 1000; max-height: 300px; overflow-y: auto;">
                                                    <ul class="list-group list-group-flush">
                                                        @foreach($this->searchResults as $user)
                                                            <li 
                                                                wire:click="selectUser({{ $user->id }}, '{{ $user->first_name }} {{ $user->last_name }}')" 
                                                                class="list-group-item list-group-item-action cursor-pointer"
                                                                style="cursor: pointer;">
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                                                        @if($user->job && $user->job->departamento)
                                                                            <br><small class="text-muted">{{ $user->job->departamento->name }}</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @elseif($showSearchResults && strlen($searchTerm) >= 2)
                                                <div class="position-absolute w-100 bg-white border rounded shadow-lg mt-1 p-3" style="z-index: 1000;">
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle"></i> No se encontraron empleados con ese nombre
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        @if(strlen($searchTerm) < 2 && strlen($searchTerm) > 0)
                                            <small class="text-muted">Escribe al menos 2 caracteres para buscar</small>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Filtrar por Departamento</label>
                                        <select wire:model.live="departmentFilter" class="form-select">
                                            <option value="">Todos los departamentos</option>
                                            @foreach($this->departments as $department)
                                                <option value="{{ $department->id }}">
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Estado de Períodos</label>
                                        <select wire:model.live="expirationFilter" class="form-select">
                                            <option value="all">Todos los períodos</option>
                                            <option value="expiring">Próximos a vencer (≤3 meses)</option>
                                            <option value="expired">Períodos vencidos</option>
                                        </select>
                                        <small class="text-muted d-block mt-1">
                                            @if($expirationFilter === 'expiring')
                                                Períodos que vencen en 3 meses o menos
                                            @elseif($expirationFilter === 'expired')
                                                Períodos que ya perdieron sus vacaciones
                                            @else
                                                Mostrando todos los períodos
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Mostrar por página</label>
                                        <select wire:model.live="perPage" class="form-select">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end gap-2 mb-4 ">
                                        @if($searchTerm || $selectedUserId || $departmentFilter || $expirationFilter !== 'all')
                                            <button wire:click="clearFilters" class="btn btn-outline-secondary" title="Limpiar filtros">
                                                <i class="fas fa-times"></i> Limpiar
                                            </button>
                                        @endif
                                        
                                        <div wire:loading class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de filtros activos -->
                        @if($selectedUserId || $departmentFilter)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="alert alert-info d-flex align-items-center">
                                        <i class="fas fa-filter me-2"></i>
                                        <span>
                                            <strong>Filtros activos:</strong>
                                            @if($selectedUserId)
                                                @php
                                                    $selectedUser = $this->allEmployees->firstWhere('id', $selectedUserId);
                                                @endphp
                                                Empleado: {{ $selectedUser ? $selectedUser->first_name . ' ' . $selectedUser->last_name : 'N/A' }}
                                            @endif
                                            @if($selectedUserId && $departmentFilter) | @endif
                                            @if($departmentFilter)
                                                @php
                                                    $selectedDepartment = $this->departments->find($departmentFilter);
                                                @endphp
                                                Departamento: {{ $selectedDepartment ? $selectedDepartment->name : 'N/A' }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Tabla de empleados -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="vacationReportTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 30px;"><i class="fas fa-plus-square"></i></th>
                                        <th>Empleado</th>
                                        <th>Departamento</th>
                                        <th>Jefe Directo</th>
                                        <th>Período</th>
                                        <th>Días Disponibles</th>
                                        <th>Cargo</th>
                                        <th style="width: 170px;">Días para vencer</th>
                                        <th><i class="fas fa-history"></i> Historial</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($this->employeesData as $data)
                                        @php
                                            $employee = $data['employee'];
                                            $usagePercentage = $data['days_entitled'] > 0 ?
                                                round(($data['days_taken'] / $data['days_entitled']) * 100, 1) : 0;
                                            $daysToExpire = $data['oldest_active_period_days_to_expire'];
                                            $today = \Carbon\Carbon::today();
                                            $periodsDisponibles = $data['all_vacation_periods']
                                                ->filter(function($period) use ($today) {
                                                    if ($period->is_historical || (isset($period->status) && $period->status === 'vencido')) return false;
                                                    $dateEnd = \Carbon\Carbon::parse($period->date_end);
                                                    $cutoff  = !empty($period->cutoff_date)
                                                        ? \Carbon\Carbon::parse($period->cutoff_date)
                                                        : $dateEnd->copy()->addMonths(15);
                                                    return $today->gte($dateEnd) && $today->lte($cutoff);
                                                })
                                                ->sortBy('date_end');
                                        @endphp
                                        <tr class="employee-row" data-employee-id="{{ $employee->id }}">
                                            <td class="text-center">
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-primary toggle-periods-btn"
                                                        data-employee-id="{{ $employee->id }}"
                                                        onclick="togglePeriods({{ $employee->id }})">
                                                    <i class="fas fa-plus-square"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong>
                                                        <br><small class="text-muted">ID: {{ $employee->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($employee->job && $employee->job->departamento)
                                                    {{ $employee->job->departamento->name }}
                                                @else
                                                    <span class="text-muted">Sin asignar</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($employee->jefe)
                                                    {{ $employee->jefe->first_name }} {{ $employee->jefe->last_name }}
                                                @else
                                                    <span class="text-muted">Sin jefe asignado</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($periodsDisponibles->isEmpty())
                                                    <span class="text-muted">—</span>
                                                @else
                                                    @foreach($periodsDisponibles as $pd)
                                                        @php $endYr = \Carbon\Carbon::parse($pd->date_end)->year; @endphp
                                                        <div class="mb-1">
                                                            <span class="badge bg-secondary">{{ $endYr }}-{{ $endYr + 1 }}</span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($periodsDisponibles->isEmpty())
                                                    <span class="badge bg-secondary">Sin períodos activos</span>
                                                @else
                                                    @foreach($periodsDisponibles as $pd)
                                                        <div class="mb-1">
                                                            <span class="badge bg-primary">{{ number_format($pd->days_availables, 2) }} días</span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @if($employee->job)
                                                    {{ $employee->job->name }}
                                                @else
                                                    <span class="text-muted">Sin cargo</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex flex-column gap-1 align-items-center">
                                                    @if(!is_null($daysToExpire))
                                                        <span class="badge {{ $daysToExpire <= 30 ? 'bg-danger' : ($daysToExpire <= 90 ? 'bg-warning text-dark' : 'bg-success') }}" style="font-size:14px;">
                                                            <i class="fas fa-hourglass-half me-1"></i>
                                                            {{ $daysToExpire }} día(s)
                                                        </span>
                                                        <small class="text-muted">{{ $data['oldest_active_period_label'] ?? 'Período vigente' }}</small>
                                                        <small class="text-muted">Vence: {{ \Carbon\Carbon::parse($data['oldest_active_period_cutoff_date'])->format('d/m/Y') }}</small>
                                                    @else
                                                        <span class="badge bg-secondary" style="font-size:14px;">
                                                            <i class="fas fa-ban me-1"></i> Sin período vigente
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('vacaciones.reporte.perfil', $employee->id) }}"
                                                   class="btn btn-sm btn-outline-info"
                                                   title="Ver perfil completo de vacaciones">
                                                    <i class="fa fa-user-circle me-1"></i> Ver Perfil
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Fila expandible con todos los períodos de vacaciones -->
                                        <tr class="periods-detail" id="periods-{{ $employee->id }}" style="display: none;">
                                            <td colspan="9" style="background-color: #f8f9fa; padding: 0;">
                                                    <div class="p-4">
                                                        <h5 class="mb-3">
                                                            <i class="fas fa-calendar-alt text-primary"></i>
                                                            Todos los Períodos de Vacaciones - {{ $employee->first_name }} {{ $employee->last_name }}
                                                        </h5>
                                                        @if($data['all_vacation_periods']->count() > 0)
                                                            <div class="table-responsive">
                                                                <table class="table table-sm table-bordered">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th style="width: 50px; background-color: #1e3a8a; color: white;" class="text-center">#</th>
                                                                            <th style="background-color: #1e3a8a; color: white;" class="text-center">Antigüedad</th>
                                                                            <th style="background-color: #1e3a8a; color: white;">Período</th>
                                                                            <th style="background-color: #b8bfc6; color: black;" class="text-center">Días de Vacaciones<br>Correspondientes<br>Período</th>
                                                                            {{-- <th style="background-color: #ffc000; color: black;" class="text-center">Días Calculados<br>(Acumulación<br>Sistema)</th> --}}
                                                                            <th style="background-color: #9bc2e6; color: black;" class="text-center">Saldo Pendiente</th>
                                                                            <th style="background-color: #9ec89f; color: black;" class="text-center">Días Disfrutados<br>Antes de la Fecha<br>de Aniversario</th>
                                                                            <th style="background-color: #f4b6c2; color: black;" class="text-center">Días Disfrutados<br>Después de Fecha<br>de Aniversario</th>
                                                                            <th style="background-color: #9bc2e6; color: black;" class="text-center">Días Disfrutados</th>
                                                                            <th style="background-color: #1e3a8a; color: white;" class="text-center">Fecha Vencimiento</th>
                                                                            <th style="background-color: #1e3a8a; color: white;" class="text-center">Estado</th>
                                                                            <th style="background-color: #1e3a8a; color: white;" class="text-center">Acciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($data['all_vacation_periods'] as $index => $period)
                                                                            @php
                                                                                $remaining = $period->days_availables - $period->days_enjoyed; // saldo = fijo - tomados
                                                                                $expirationDate = !empty($period->cutoff_date)
                                                                                    ? \Carbon\Carbon::parse($period->cutoff_date)
                                                                                    : \Carbon\Carbon::parse($period->date_end)->addMonths(15);
                                                                                $today = \Carbon\Carbon::today();
                                                                                $daysUntilExpiration = $today->diffInDays($expirationDate, false);
                                                                                $yearLabel = 'N/D';

                                                                                if (!empty($employee->admission) && $employee->admission !== '0000-00-00' && $employee->admission !== '0000-00-00 00:00:00') {
                                                                                    try {
                                                                                        $admissionDate = \Carbon\Carbon::parse($employee->admission);
                                                                                        $periodStart = \Carbon\Carbon::parse($period->date_start);
                                                                                        $seniorityYear = $periodStart->diffInYears($admissionDate) + 1;
                                                                                        $yearLabel = 'Año ' . max(1, $seniorityYear);
                                                                                    } catch (\Exception $e) {
                                                                                        $yearLabel = 'N/D';
                                                                                    }
                                                                                }
                                                                                
                                                                                // Verificar si está vencido
                                                                                $isExpired = $daysUntilExpiration < 0 || $period->is_historical || (isset($period->status) && $period->status === 'vencido');
                                                                                
                                                                                // Verificar si está próximo a vencer (3 meses = ~90 días)
                                                                                $threeMonthsInDays = 90;
                                                                                $isExpiringSoon = !$isExpired && $daysUntilExpiration >= 0 && $daysUntilExpiration <= $threeMonthsInDays;
                                                                            @endphp
                                                                            <tr class="{{ $isExpired ? 'table-secondary text-muted' : '' }}" style="{{ $isExpired ? 'opacity: 0.6;' : '' }}">
                                                                                <td class="text-center"><strong>{{ $index + 1 }}</strong></td>
                                                                                <td class="text-center">
                                                                                    <span class="badge {{ $isExpired ? 'bg-secondary' : 'bg-secondary' }}">{{ $yearLabel }}</span>
                                                                                </td>
                                                                                <td>
                                                                                    @php $endYr = \Carbon\Carbon::parse($period->date_end)->year; @endphp
                                                                                    <span class="badge bg-dark">{{ $endYr }}-{{ $endYr + 1 }}</span>
                                                                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($period->date_start)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($period->date_end)->format('d/m/Y') }}</small>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <span class="badge {{ $isExpired ? 'bg-secondary' : 'bg-secondary' }}">{{ number_format($period->vacationPerYear->days ?? 0, 2) }}</span>
                                                                                </td>
                                                                                {{-- <td class="text-center" style="background-color: {{ $isExpired ? '#e9ecef' : '#fff3cd' }};">
                                                                                    @if($period->days_calculated !== null)
                                                                                        <span class="badge bg-warning text-dark">{{ number_format($period->days_calculated, 2) }}</span>
                                                                                    @else
                                                                                        <span class="badge bg-secondary">0.00</span>
                                                                                    @endif
                                                                                </td> --}}
                                                                                <td class="text-center" style="background-color: {{ $isExpired ? '#e9ecef' : '#d9edf7' }};">
                                                                                    <strong>{{ number_format($period->days_availables, 2) }}</strong>
                                                                                </td>
                                                                                <td class="text-center" style="background-color: {{ $isExpired ? '#e9ecef' : '#d4edda' }};">
                                                                                    {{ number_format($period->days_enjoyed_before_anniversary ?? 0, 2) }}
                                                                                </td>
                                                                                <td class="text-center" style="background-color: {{ $isExpired ? '#e9ecef' : '#f8d7da' }};">
                                                                                    {{ number_format($period->days_enjoyed_after_anniversary ?? 0, 2) }}
                                                                                </td>
                                                                                <td class="text-center" style="background-color: {{ $isExpired ? '#e9ecef' : '#d9edf7' }};">
                                                                                    <strong class="days-enjoyed-badge" id="days-enjoyed-{{ $period->id }}">
                                                                                        {{ number_format($period->days_enjoyed, 2) }}
                                                                                    </strong>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex flex-column align-items-center">
                                                                                        <span class="fw-bold {{ $isExpired ? 'text-danger' : ($isExpiringSoon ? 'text-warning' : 'text-muted') }}">
                                                                                            {{ $expirationDate->format('d/m/Y') }}
                                                                                        </span>
                                                                                        <small class="{{ $isExpired ? 'text-danger' : ($isExpiringSoon ? 'text-warning' : 'text-muted') }}">
                                                                                            {{ $daysUntilExpiration < 0
                                                                                                ? 'Venció hace ' . abs($daysUntilExpiration) . ' día(s)'
                                                                                                : ($daysUntilExpiration === 0
                                                                                                    ? 'Vence hoy'
                                                                                                    : 'Faltan ' . $daysUntilExpiration . ' día(s)') }}
                                                                                        </small>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center" id="type-cell-{{ $period->id }}">
                                                                                    @if($isExpired)
                                                                                        <span class="badge bg-danger">
                                                                                            <i class="fas fa-times-circle"></i> Vencido
                                                                                        </span>
                                                                                    @elseif($isExpiringSoon)
                                                                                        <span class="badge bg-warning text-dark">
                                                                                            <i class="fas fa-exclamation-triangle"></i> Próximo a Vencer
                                                                                        </span>
                                                                                    @else
                                                                                        <span class="badge bg-success">
                                                                                            <i class="fas fa-check-circle"></i> Vigente
                                                                                        </span>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="btn-group" role="group">
                                                                                        <button type="button" 
                                                                                                class="btn btn-sm btn-primary edit-vacation-btn" 
                                                                                                data-vacation-id="{{ $period->id }}"
                                                                                                data-period="{{ $period->period }}"
                                                                                                data-current-days="{{ $period->days_enjoyed }}"
                                                                                                data-max-days="{{ $period->days_availables }}"
                                                                                                data-available="{{ $period->days_availables }}"
                                                                                                data-is-historical="{{ $period->is_historical ? 'true' : 'false' }}"
                                                                                                data-status="{{ $period->status ?? 'actual' }}"
                                                                                                title="Editar período">
                                                                                            <i class="fas fa-edit"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot class="table-light">
                                                                        <tr>
                                                                            <th colspan="3" class="text-end">TOTALES (Solo Vigentes):</th>
                                                                            @php
                                                                                // Filtrar solo períodos vigentes para los totales
                                                                                $today = \Carbon\Carbon::today();
                                                                                $vigentePeriods = $data['all_vacation_periods']->filter(function($period) use ($today) {
                                                                                    $expirationDate = \Carbon\Carbon::parse($period->date_end)->addMonths(15);
                                                                                    $isExpired = $today->gt($expirationDate) || $period->is_historical || (isset($period->status) && $period->status === 'vencido');
                                                                                    return !$isExpired;
                                                                                });
                                                                            @endphp
                                                                            
                                                                            <th class="text-center" style="background-color: #b8bfc6;">
                                                                                <strong>{{ number_format($vigentePeriods->sum(function($p) { return $p->vacationPerYear->days ?? 0; }), 2) }}</strong>
                                                                            </th>
                                                                            {{-- <th> </th> --}}
                                                                            <th class="text-center" style="background-color: #d9edf7;">
                                                                                <strong class="fs-6">{{ number_format($vigentePeriods->sum('days_availables'), 2) }}</strong>
                                                                            </th>
                                                                            <th class="text-center" style="background-color: #d4edda;">
                                                                                <strong class="fs-6">{{ number_format($vigentePeriods->sum('days_enjoyed_before_anniversary'), 2) }}</strong>
                                                                            </th>
                                                                            <th class="text-center" style="background-color: #f8d7da;">
                                                                                <strong class="fs-6">{{ number_format($vigentePeriods->sum('days_enjoyed_after_anniversary'), 2) }}</strong>
                                                                            </th>
                                                                            <th class="text-center" style="background-color: #d9edf7;">
                                                                                <strong class="fs-6">{{ number_format($vigentePeriods->sum('days_enjoyed'), 2) }}</strong>
                                                                            </th>
                                                                            <th colspan="3"></th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div class="alert alert-warning">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                                Este empleado aún no tiene períodos de vacaciones calculados.
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <i class="fas fa-users-slash fa-4x text-muted mb-3 d-block"></i>
                                                <h4 class="text-muted">No se encontraron empleados</h4>
                                                <p class="text-muted">
                                                    @if($expirationFilter === 'expiring')
                                                        No hay empleados con períodos próximos a vencer (≤3 meses).
                                                    @elseif($expirationFilter === 'expired')
                                                        No hay empleados con períodos vencidos.
                                                    @elseif($departmentFilter)
                                                        No hay empleados en el departamento seleccionado.
                                                    @else
                                                        No hay empleados registrados en el sistema.
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-3">
                            {{ $this->employeesData->links() }}
                        </div>

                        <!-- El historial de vacaciones se muestra en la página de perfil de usuario -->
                        @if(false)
                        </div>
                        @endif

                        <!-- Modal de Edición de Incidencias -->
                        @if($showEditIncidentModal)
                        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content bg-white">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title text-white">
                                            <i class="fas fa-user-edit"></i> Editar Datos del Usuario
                                        </h5>
                                        <button type="button" class="btn-close" wire:click="closeEditIncidentModal"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if($editingIncidentUser)
                                            <div class="alert alert-info mb-4">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Instrucción:</strong> Corrige los datos del usuario (campos resaltados) y guarda los cambios. Los errores se marcarán como resueltos automáticamente.
                                            </div>

                                            <div class="row">
                                                <!-- Información General (Solo Lectura) -->
                                                <div class="col-md-6">
                                                    <h6 class="text-muted mb-3"><i class="fas fa-user"></i> Información General</h6>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">ID de Usuario</label>
                                                        <input type="text" class="form-control" value="{{ $editingIncidentUser->id }}" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Nombre Completo</label>
                                                        <input type="text" class="form-control" value="{{ $editingIncidentUser->first_name }} {{ $editingIncidentUser->last_name }}" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Puesto</label>
                                                        <input type="text" class="form-control" value="{{ $editingIncidentUser->job->name ?? 'Sin puesto' }}" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Departamento</label>
                                                        <input type="text" class="form-control" value="{{ $editingIncidentUser->job && $editingIncidentUser->job->departamento ? $editingIncidentUser->job->departamento->name : 'Sin departamento' }}" readonly>
                                                    </div>
                                                </div>

                                                <!-- Campos Editables (Resaltados) -->
                                                <div class="col-md-6">
                                                    <h6 class="text-primary mb-3"><i class="fas fa-edit"></i> Datos a Corregir</h6>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">
                                                            <i class="fas fa-calendar-alt text-primary"></i> Fecha de Admisión *
                                                        </label>
                                                        <input type="date" 
                                                               wire:model="editingAdmission" 
                                                               class="form-control border-primary border-2 {{ $errors->has('editingAdmission') ? 'is-invalid' : '' }}">
                                                        @error('editingAdmission')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <small class="text-muted">Esta fecha determina el cálculo de períodos de vacaciones</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">
                                                            <i class="fas fa-toggle-on text-primary"></i> Estado del Usuario *
                                                        </label>
                                                        <select wire:model="editingStatus" 
                                                                class="form-select border-primary border-2 {{ $errors->has('editingStatus') ? 'is-invalid' : '' }}">
                                                            <option value="1">Activo</option>
                                                            <option value="2">Inactivo</option>
                                                        </select>
                                                        @error('editingStatus')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <small class="text-muted">Solo usuarios activos pueden importar vacaciones</small>
                                                    </div>

                                                    <div class="alert alert-warning mb-0">
                                                        <strong><i class="fas fa-exclamation-triangle"></i> Errores Detectados:</strong>
                                                        <ul class="mb-0 mt-2">
                                                            @foreach($editingIncidentLogs as $log)
                                                                <li><small>{{ $log->message }}</small></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" wire:click="closeEditIncidentModal">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
                                        <button type="button" class="btn btn-primary" wire:click="saveIncidentUser">
                                            <i class="fas fa-save"></i> Guardar y Resolver Incidencias
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Modal de Resultados de Sincronización -->
                        <div class="modal fade" id="syncResultsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title">
                                            <i class="fas fa-sync-alt"></i> Resultados de Sincronización de Vacaciones
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body bg-white">
                                        @if(session('sync_completed'))
                                            <div class="alert alert-success mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-check-circle fa-2x me-3"></i>
                                                    <div>
                                                        <h5 class="mb-1">Sincronización Completada Exitosamente</h5>
                                                        <small>
                                                            <i class="fas fa-clock"></i> Fecha: {{ session('sync_timestamp') }} |
                                                            <i class="fas fa-hourglass-half"></i> Duración: {{ session('sync_duration') }} segundos
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="card border-primary">
                                                        <div class="card-body text-center">
                                                            <i class="fas fa-check-circle fa-3x text-primary mb-2"></i>
                                                            <h3 class="mb-0">{{ count(session('sync_updates', [])) }}</h3>
                                                            <small class="text-muted">Actualizaciones Realizadas</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card border-danger">
                                                        <div class="card-body text-center">
                                                            <i class="fas fa-exclamation-triangle fa-3x text-danger mb-2"></i>
                                                            <h3 class="mb-0">{{ count(session('sync_errors', [])) }}</h3>
                                                            <small class="text-muted">Errores Encontrados</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(count(session('sync_updates', [])) > 0)
                                                <div class="card mb-3">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">
                                                            <i class="fas fa-list-check"></i> Detalle de Actualizaciones
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach(session('sync_updates') as $update)
                                                                <li class="mb-2">
                                                                    <i class="fas fa-check text-success me-2"></i>
                                                                    <code>{{ $update }}</code>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(count(session('sync_errors', [])) > 0)
                                                <div class="card mb-3">
                                                    <div class="card-header bg-danger text-white">
                                                        <h6 class="mb-0">
                                                            <i class="fas fa-exclamation-circle"></i> Errores Detectados
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach(session('sync_errors') as $error)
                                                                <li class="mb-2">
                                                                    <i class="fas fa-times text-danger me-2"></i>
                                                                    <code class="text-danger">{{ $error }}</code>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="card">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0">
                                                        <i class="fas fa-terminal"></i> Output Completo del Comando
                                                    </h6>
                                                </div>
                                                <div class="card-body bg-dark text-light" style="max-height: 300px; overflow-y: auto;">
                                                    <pre class="mb-0" style="color: #00ff00; font-family: 'Courier New', monospace; font-size: 0.85rem;">{{ session('sync_output') }}</pre>
                                                </div>
                                            </div>
                                        @endif

                                        @if(session('sync_error'))
                                            <div class="alert alert-danger">
                                                <h5 class="alert-heading">
                                                    <i class="fas fa-times-circle"></i> Error en la Sincronización
                                                </h5>
                                                <p class="mb-0">{{ session('sync_error_message') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer bg-white">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cerrar
                                        </button>
                                        <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                                            <i class="fas fa-redo"></i> Recargar Página
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Edición de Período de Vacaciones -->
                        <div class="modal fade" id="editVacationModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">
                                            <i class="fas fa-edit"></i> Editar Período de Vacaciones
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body bg-white">
                                        <form id="editVacationForm">
                                            <input type="hidden" id="edit_vacation_id" name="vacation_id">
                                            
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle"></i>
                                                        <strong>Período <span id="edit_period_number"></span></strong>
                                                        <span id="edit_period_type" class="ms-2"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold">
                                                        <i class="fas fa-calculator"></i> Días Acumulados
                                                    </label>
                                                    <input type="text" class="form-control" id="edit_days_available" readonly>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">
                                                        <i class="fas fa-umbrella-beach"></i> Días Disfrutados <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" 
                                                           class="form-control" 
                                                           id="edit_days_enjoyed" 
                                                           name="days_enjoyed"
                                                           min="0" 
                                                           step="0.01"
                                                           required>
                                                    <small class="text-muted">Máximo: <span id="edit_max_days"></span> días</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">
                                                        <i class="fas fa-chart-line"></i> Días Restantes
                                                    </label>
                                                    <input type="text" class="form-control bg-light" id="edit_days_remaining" readonly>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">
                                                        <i class="fas fa-tag"></i> Estado del Período <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select" id="edit_status" name="status" required>
                                                        <option value="actual">Actual / Vigente</option>
                                                        <option value="vencido">Vencido</option>
                                                    </select>
                                                    <small class="text-muted">Marca como "Vencido" si el período ya caducó y no se puede usar</small>
                                                </div>
                                            </div>

                                            <div class="alert alert-warning" id="edit_warning" style="display: none;">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                <span id="edit_warning_text"></span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer bg-white">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
                                        <button type="button" class="btn btn-primary" id="saveVacationBtn">
                                            <i class="fas fa-save"></i> Guardar Cambios
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
    .table th {
        border-top: none;
        font-weight: 600;
        vertical-align: middle;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.075);
    }

    .badge.fs-6 {
        font-size: 0.875rem !important;
        padding: 0.375rem 0.75rem;
    }

    .progress {
        border-radius: 10px;
    }

    .progress-bar {
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .periods-detail {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes blink {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.3;
        }
    }

    .blink-icon {
        animation: blink 1.5s ease-in-out infinite;
    }

    .periods-detail td {
        border-top: 3px solid #007bff;
    }

    .modal-content {
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .modal-header {
        border-radius: 10px 10px 0 0;
    }
    
    .modal.show {
        animation: modalFadeIn 0.3s ease;
    }
    
    @keyframes modalFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Estilos para el buscador de empleados */
    .list-group-item-action:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* Animación de resultados de búsqueda */
    .position-absolute.w-100 {
        animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .badge.fs-6 {
            font-size: 0.75rem !important;
            padding: 0.25rem 0.5rem;
        }
        
        .progress {
            height: 16px !important;
        }
        
        .progress-bar {
            font-size: 0.7rem;
        }
    }

    @media print {
        .btn, .modal, .alert {
            display: none !important;
        }
        
        .table {
            font-size: 0.8rem;
        }
        
        .periods-detail {
            display: none !important;
        }
    }
    </style>
    @endpush

    @push('scripts')
    <script>
    // ========== FUNCIONALIDAD DE EXPANDIR/COLAPSAR PERÍODOS ==========
    function togglePeriods(employeeId) {
        const periodsRow = document.getElementById('periods-' + employeeId);
        const button = document.querySelector('.toggle-periods-btn[data-employee-id="' + employeeId + '"]');
        const icon = button.querySelector('i');
        
        if (periodsRow.style.display === 'none') {
            // Expandir
            periodsRow.style.display = 'table-row';
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-primary');
            icon.classList.remove('fa-plus-square');
            icon.classList.add('fa-minus-square');
        } else {
            // Colapsar
            periodsRow.style.display = 'none';
            button.classList.remove('btn-primary');
            button.classList.add('btn-outline-primary');
            icon.classList.remove('fa-minus-square');
            icon.classList.add('fa-plus-square');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // ========== MOSTRAR MODAL DE RESULTADOS DE SINCRONIZACIÓN ==========
        @if(session('sync_completed') || session('sync_error'))
            const syncModal = new bootstrap.Modal(document.getElementById('syncResultsModal'));
            syncModal.show();
        @endif

        // ========== CERRAR RESULTADOS DE BÚSQUEDA AL HACER CLIC FUERA ==========
        document.addEventListener('click', function(e) {
            const searchContainer = e.target.closest('.position-relative');
            if (!searchContainer) {
                // Click fuera del contenedor de búsqueda
                Livewire.dispatch('hideSearchResults');
            }
        });

        // ========== MODAL DE EDICIÓN DE PERÍODO ==========
        const editModal = new bootstrap.Modal(document.getElementById('editVacationModal'));
        const editForm = document.getElementById('editVacationForm');
        const saveBtn = document.getElementById('saveVacationBtn');
        
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-vacation-btn')) {
                const button = e.target.closest('.edit-vacation-btn');
                const vacationId = button.getAttribute('data-vacation-id');
                const period = button.getAttribute('data-period');
                const currentDays = parseFloat(button.getAttribute('data-current-days'));
                const maxDays = parseFloat(button.getAttribute('data-max-days'));
                const available = parseFloat(button.getAttribute('data-available'));
                const isHistorical = button.getAttribute('data-is-historical') === 'true';
                const status = button.getAttribute('data-status') || 'actual';

                // Llenar el modal
                document.getElementById('edit_vacation_id').value = vacationId;
                document.getElementById('edit_period_number').textContent = period;
                document.getElementById('edit_days_available').value = available.toFixed(2);
                document.getElementById('edit_days_enjoyed').value = currentDays.toFixed(2);
                document.getElementById('edit_max_days').textContent = maxDays.toFixed(2);
                document.getElementById('edit_days_remaining').value = (maxDays - currentDays).toFixed(2);
                document.getElementById('edit_status').value = status;

                // Actualizar badge de tipo
                const typeHtml = isHistorical 
                    ? '<span class="badge bg-secondary"><i class="fas fa-history"></i> Histórico</span>'
                    : '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Actual</span>';
                document.getElementById('edit_period_type').innerHTML = typeHtml;

                // Deshabilitar estado si es histórico
                document.getElementById('edit_status').disabled = isHistorical;

                editModal.show();
            }
        });

        // Calcular días restantes al cambiar días disfrutados
        document.getElementById('edit_days_enjoyed').addEventListener('input', function() {
            const maxDays = parseFloat(document.getElementById('edit_max_days').textContent);
            const enjoyed = parseFloat(this.value) || 0;
            const remaining = maxDays - enjoyed;
            
            document.getElementById('edit_days_remaining').value = remaining.toFixed(2);

            // Mostrar advertencia si excede
            const warning = document.getElementById('edit_warning');
            const warningText = document.getElementById('edit_warning_text');
            
            if (enjoyed > maxDays) {
                warningText.textContent = `Los días disfrutados (${enjoyed.toFixed(2)}) exceden el máximo permitido (${maxDays.toFixed(2)})`;
                warning.style.display = 'block';
            } else {
                warning.style.display = 'none';
            }
        });

        // Guardar cambios
        saveBtn.addEventListener('click', function() {
            const vacationId = document.getElementById('edit_vacation_id').value;
            const daysEnjoyed = parseFloat(document.getElementById('edit_days_enjoyed').value);
            const maxDays = parseFloat(document.getElementById('edit_max_days').textContent);
            const status = document.getElementById('edit_status').value;

            // Validaciones
            if (isNaN(daysEnjoyed) || daysEnjoyed < 0) {
                showAlert('danger', 'Por favor ingrese un número válido de días disfrutados.');
                return;
            }

            if (daysEnjoyed > maxDays) {
                showAlert('danger', `Los días disfrutados no pueden exceder ${maxDays.toFixed(2)} días.`);
                return;
            }

            // Mostrar loading
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

            // Enviar solicitud
            updateVacationPeriod(vacationId, daysEnjoyed, status);
        });

        function updateVacationPeriod(vacationId, daysEnjoyed, status) {
            fetch('{{ route('vacaciones.update-days-enjoyed') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    vacation_id: vacationId,
                    days_enjoyed: daysEnjoyed,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cerrar modal y mostrar mensaje
                    editModal.hide();
                    showAlert('success', data.message);

                    // Recargar después de 2 segundos para reflejar cambios
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'Error al actualizar. Por favor intente nuevamente.');
            })
            .finally(() => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Guardar Cambios';
            });
        }

        function showAlert(type, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            const cardBody = document.querySelector('.card-body');
            const existingAlerts = cardBody.querySelectorAll('.alert:not(.alert-info)');
            existingAlerts.forEach(alert => alert.remove());
            
            cardBody.insertAdjacentHTML('afterbegin', alertHtml);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    // ========== SINCRONIZACIÓN DE VACACIONES ==========
    function confirmSync() {
        if (confirm('¿Está seguro que desea sincronizar las vacaciones de todos los empleados?\n\nEste proceso puede tomar varios minutos y actualizará los días acumulados de todos los usuarios activos.')) {
            const form = document.getElementById('syncVacationsForm');
            const button = form.querySelector('button');
            
            // Mostrar loading
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sincronizando...';
            
            // Enviar formulario
            form.submit();
        }
    }
    </script>
    @endpush

    <!-- Modal de Confirmación - Calcular Vacaciones -->
    @if($showCalculateVacationsModal)
    <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-calculator me-2"></i>
                        Confirmar Cálculo de Vacaciones
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeCalculateVacationsModal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="mx-auto d-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle" style="width: 80px; height: 80px;">
                            <i class="fas fa-calculator text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    
                    <p class="text-center mb-3">
                        Esta acción calculará y generará los registros de vacaciones para <strong>todos los empleados</strong> del sistema.
                    </p>
                    
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-1"></i>
                            ¿Qué hace este proceso?
                        </h6>
                        <ul class="mb-0 small">
                            <li>Genera registros históricos para empleados contratados antes de 2023</li>
                            <li>Calcula periodos de vacaciones según antigüedad</li>
                            <li>Aplica acumulación diaria proporcional</li>
                            <li>No duplica registros existentes (es idempotente)</li>
                            <li>Puede tardar varios minutos dependiendo del número de empleados</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning mb-0">
                        <small>
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>Nota:</strong> Este proceso solo crea registros faltantes. No modifica registros existentes.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeCalculateVacationsModal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="button" 
                            class="btn btn-primary" 
                            wire:click="processCalculateVacations"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="processCalculateVacations">
                            <i class="fas fa-calculator me-1"></i> Calcular Vacaciones
                        </span>
                        <span wire:loading wire:target="processCalculateVacations">
                            <i class="fas fa-spinner fa-spin me-1"></i> Procesando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de Resultados - Cálculo de Vacaciones -->
    @if($showCalculateResultsModal && $calculationResults)
    <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-white">
                <div class="modal-header {{ $calculationResults['failed'] > 0 ? 'bg-warning' : 'bg-success' }} text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>
                        Resultado del Cálculo de Vacaciones
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeCalculateResultsModal"></button>
                </div>
                <div class="modal-body">
                    <!-- Resumen de resultados -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-success bg-opacity-10 border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-check-circle text-success" style="font-size: 2.5rem;"></i>
                                    <h3 class="mt-2 mb-0 text-white">{{ $calculationResults['success'] }}</h3>
                                    <p class="text-white mb-0">Usuarios Procesados Exitosamente</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card {{ $calculationResults['failed'] > 0 ? 'bg-danger bg-opacity-10 border-danger' : 'bg-light border-secondary' }}">
                                <div class="card-body text-center">
                                    <i class="fas fa-exclamation-triangle {{ $calculationResults['failed'] > 0 ? 'text-danger' : 'text-muted' }}" style="font-size: 2.5rem;"></i>
                                    <h3 class="mt-2 mb-0  {{ $calculationResults['failed'] > 0 ? 'text-white' : 'text-white' }}">{{ $calculationResults['failed'] }}</h3>
                                    <p class="text-white mb-0">Usuarios con Errores</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje de éxito -->
                    <div class="alert {{ $calculationResults['failed'] > 0 ? 'alert-warning' : 'alert-success' }}">
                        <i class="fas {{ $calculationResults['failed'] > 0 ? 'fa-exclamation-triangle' : 'fa-check-circle' }} me-2"></i>
                        <strong>Proceso completado:</strong> 
                        Se procesaron {{ $calculationResults['success'] }} usuarios exitosamente
                        @if($calculationResults['failed'] > 0)
                            , con {{ $calculationResults['failed'] }} errores.
                        @else
                            sin errores.
                        @endif
                    </div>

                    <!-- Lista de errores si existen -->
                    @if(!empty($calculationResults['errors']))
                    <div class="mt-3">
                        <h6 class="text-danger">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Detalles de Errores:
                        </h6>
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-sm table-striped">
                                <thead class="table-dark sticky-top">
                                    <tr>
                                        <th style="width: 20%;">User ID</th>
                                        <th style="width: 80%;">Mensaje de Error</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($calculationResults['errors'] as $error)
                                    <tr>
                                        <td><code>{{ $error['user_id'] }}</code></td>
                                        <td><small>{{ $error['message'] }}</small></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Información adicional -->
                    <div class="alert alert-info mt-3 mb-0">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Los registros de vacaciones se han generado correctamente. Los empleados ahora pueden visualizar sus periodos de vacaciones disponibles.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" wire:click="closeCalculateResultsModal">
                        <i class="fas fa-check me-1"></i> Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de Confirmación - Actualizar Períodos -->
    @if($showUpdatePeriodsModal)
    <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Actualizar Períodos de Vacaciones
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeUpdatePeriodsModal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Este proceso creará los períodos faltantes para todos los empleados activos según su fecha de ingreso y antigüedad.
                    </div>
                    <p class="mb-0">
                        <strong>¿Está seguro que desea continuar?</strong>
                    </p>
                    <small class="text-muted">
                        El sistema verificará cada empleado y creará solo los períodos que no existan, preservando los datos existentes.
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeUpdatePeriodsModal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="button" 
                            class="btn btn-primary" 
                            wire:click="processUpdatePeriods"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="processUpdatePeriods">
                            <i class="fas fa-calendar-plus me-1"></i> Actualizar Períodos
                        </span>
                        <span wire:loading wire:target="processUpdatePeriods">
                            <i class="fas fa-spinner fa-spin me-1"></i> Procesando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de Resultados - Actualizar Períodos -->
    @if($showUpdatePeriodsResultsModal && $updatePeriodsResults)
    <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-white">
                <div class="modal-header {{ $updatePeriodsResults['errors'] > 0 ? 'bg-warning' : 'bg-success' }} text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>
                        Resultado de Actualización de Períodos
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeUpdatePeriodsResultsModal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary bg-opacity-10 border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-users text-primary" style="font-size: 2.5rem;"></i>
                                    <h3 class="mt-2 mb-0">{{ $updatePeriodsResults['total_users'] }}</h3>
                                    <p class="text-muted mb-0"><small>Usuarios Procesados</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success bg-opacity-10 border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-plus text-success" style="font-size: 2.5rem;"></i>
                                    <h3 class="mt-2 mb-0">{{ $updatePeriodsResults['periods_created'] }}</h3>
                                    <p class="text-muted mb-0"><small>Períodos Creados</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card {{ $updatePeriodsResults['errors'] > 0 ? 'bg-danger bg-opacity-10 border-danger' : 'bg-light border-secondary' }}">
                                <div class="card-body text-center">
                                    <i class="fas fa-exclamation-triangle {{ $updatePeriodsResults['errors'] > 0 ? 'text-danger' : 'text-muted' }}" style="font-size: 2.5rem;"></i>
                                    <h3 class="mt-2 mb-0">{{ $updatePeriodsResults['errors'] }}</h3>
                                    <p class="text-muted mb-0"><small>Errores</small></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert {{ $updatePeriodsResults['errors'] > 0 ? 'alert-warning' : 'alert-success' }}">
                        <i class="fas {{ $updatePeriodsResults['errors'] > 0 ? 'fa-exclamation-triangle' : 'fa-check-circle' }} me-2"></i>
                        <strong>Proceso completado:</strong> 
                        Se crearon {{ $updatePeriodsResults['periods_created'] }} nuevos períodos para {{ $updatePeriodsResults['total_users'] }} empleados en {{ $updatePeriodsResults['duration'] }} segundos.
                    </div>

                    <div class="alert alert-info mb-0">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Los períodos faltantes se han creado correctamente. Los datos existentes se preservaron intactos.
                        </small>
                    </div>

                    @if(!empty($updatePeriodsResults['error_details']))
                        <div class="card mt-3 border-danger">
                            <div class="card-header bg-danger text-white">
                                <strong><i class="fas fa-exclamation-triangle me-1"></i> Errores encontrados ({{ count($updatePeriodsResults['error_details']) }})</strong>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead class="table-danger sticky-top">
                                            <tr>
                                                <th width="20%">Usuario</th>
                                                <th width="10%" class="text-center">ID</th>
                                                <th>Mensaje de Error</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($updatePeriodsResults['error_details'] as $error)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $error['user_name'] }}</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-secondary">{{ $error['user_id'] }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">
                                                            <i class="fas fa-exclamation-circle me-1"></i>
                                                            {{ $error['error_message'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($updatePeriodsResults['created_details']))
                        <div class="card mt-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-list me-1"></i> Períodos creados por usuario</strong>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>Usuario</th>
                                                <th class="text-center">Período</th>
                                                <th>Inicio</th>
                                                <th>Fin</th>
                                                <th class="text-center">Tipo</th>
                                                <th class="text-center">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($updatePeriodsResults['created_details'] as $detail)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $detail['user_name'] }}</strong>
                                                        <br><small class="text-muted">ID: {{ $detail['user_id'] }}</small>
                                                    </td>
                                                    <td class="text-center">{{ $detail['period'] }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($detail['date_start'])->format('d/m/Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($detail['date_end'])->format('d/m/Y') }}</td>
                                                    <td class="text-center">
                                                        @if($detail['is_historical'])
                                                            <span class="badge bg-secondary">Histórico</span>
                                                        @else
                                                            <span class="badge bg-primary">Actual</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge {{ $detail['status'] === 'vencido' ? 'bg-danger' : 'bg-success' }}">
                                                            {{ ucfirst($detail['status']) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" wire:click="closeUpdatePeriodsResultsModal">
                        <i class="fas fa-check me-1"></i> Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de Confirmación - Actualizar Días -->
    @if($showUpdateDaysModal)
    <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-sync-alt me-2"></i>
                        Actualizar Acumulación Diaria
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeUpdateDaysModal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Este proceso actualizará la acumulación diaria de días de vacaciones de todos los empleados activos.
                    </div>
                    <p class="mb-0">
                        <strong>¿Está seguro que desea continuar?</strong>
                    </p>
                    <small class="text-muted">
                        El sistema actualizará solo los días acumulados, preservando los días reservados y disfrutados.
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeUpdateDaysModal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="button" 
                            class="btn btn-success" 
                            wire:click="processUpdateDays"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="processUpdateDays">
                            <i class="fas fa-sync-alt me-1"></i> Actualizar Días
                        </span>
                        <span wire:loading wire:target="processUpdateDays">
                            <i class="fas fa-spinner fa-spin me-1"></i> Procesando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de Resultados - Actualizar Días -->
    @if($showUpdateDaysResultsModal && $updateDaysResults)
    <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-white">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>
                        Resultado de Actualización de Días
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeUpdateDaysResultsModal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary bg-opacity-10 border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-users text-primary" style="font-size: 2rem;"></i>
                                    <h4 class="mt-2 mb-0">{{ $updateDaysResults['users_processed'] }}</h4>
                                    <p class="text-muted mb-0"><small>Usuarios</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success bg-opacity-10 border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
                                    <h4 class="mt-2 mb-0">{{ $updateDaysResults['periods_updated'] }}</h4>
                                    <p class="text-muted mb-0"><small>Actualizados</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning bg-opacity-10 border-warning">
                                <div class="card-body text-center">
                                    <i class="fas fa-clock text-warning" style="font-size: 2rem;"></i>
                                    <h4 class="mt-2 mb-0">{{ $updateDaysResults['periods_skipped'] }}</h4>
                                    <p class="text-muted mb-0"><small>Omitidos</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger bg-opacity-10 border-danger">
                                <div class="card-body text-center">
                                    <i class="fas fa-times-circle text-danger" style="font-size: 2rem;"></i>
                                    <h4 class="mt-2 mb-0">{{ $updateDaysResults['periods_expired'] }}</h4>
                                    <p class="text-muted mb-0"><small>Vencidos</small></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Proceso completado:</strong> 
                        Se procesaron {{ $updateDaysResults['users_processed'] }} usuarios,
                        actualizando {{ $updateDaysResults['periods_updated'] }} períodos y
                        marcando {{ $updateDaysResults['periods_expired'] }} como vencidos
                        en {{ $updateDaysResults['duration'] }} segundos.
                    </div>

                    {{-- DEBUG: Mostrar información del array details --}}
                    <div class="alert alert-info mb-3">
                        <small>
                            <strong>Debug Info:</strong>
                            @if(isset($updateDaysResults['details']))
                                Array 'details' existe con {{ count($updateDaysResults['details']) }} registros
                            @else
                                Array 'details' NO está definido
                            @endif
                        </small>
                    </div>

                    @if(isset($updateDaysResults['details']))
                    <div class="mt-4">
                        <h6 class="mb-3">
                            <i class="fas fa-table me-2"></i>
                            Detalle de Actualizaciones ({{ count($updateDaysResults['details']) }} registros)
                        </h6>
                        
                        @if(count($updateDaysResults['details']) === 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>No hay cambios para mostrar:</strong> 
                            Todos los períodos ya fueron actualizados el día de hoy. 
                            Los detalles solo se muestran cuando hay incrementos > 0.01 días.
                        </div>
                        @else
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-primary sticky-top">
                                    <tr>
                                        <th style="width: 20%;">#</th>
                                        <th style="width: 25%;">Planta</th>
                                        <th style="width: 35%;">Usuario</th>
                                        <th class="text-center" style="width: 10%;">Período</th>
                                        <th class="text-end" style="width: 15%;">Días Anteriores</th>
                                        <th class="text-end" style="width: 15%;">Días Actualizados</th>
                                        <th class="text-end" style="width: 10%;">Incremento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($updateDaysResults['details'] as $index => $detail)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td><small>{{ $detail['planta'] }}</small></td>
                                        <td><small>{{ $detail['usuario'] }}</small></td>
                                        <td class="text-center"><span class="badge bg-secondary">{{ $detail['periodo'] }}</span></td>
                                        <td class="text-end"><span class="badge bg-warning text-dark">{{ number_format($detail['dias_anteriores'], 2) }}</span></td>
                                        <td class="text-end"><span class="badge bg-success">{{ number_format($detail['dias_actualizados'], 2) }}</span></td>
                                        <td class="text-end">
                                            <span class="badge bg-primary">
                                                <i class="fas fa-arrow-up"></i> {{ number_format($detail['incremento'], 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="alert alert-info mb-0">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            La acumulación diaria se ha actualizado correctamente. Los días reservados y disfrutados se preservaron intactos.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" wire:click="closeUpdateDaysResultsModal">
                        <i class="fas fa-check me-1"></i> Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif


</div>
