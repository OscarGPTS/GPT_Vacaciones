@extends('layouts.codebase.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-1">
                                <i class="fas fa-chart-bar"></i> 
                                Reporte de Vacaciones - Recursos Humanoszz
                            </h3>
                            <small class="text-muted d-block">Resumen general de vacaciones de todos los empleadosaaa</small>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Actualizar Períodos -->
                            <form action="{{ route('vacaciones.update-periods') }}" method="POST" style="display: inline;" id="updatePeriodsForm">
                                @csrf
                                <button type="button" class="btn btn-primary" onclick="confirmUpdatePeriods()" title="Crear períodos faltantes para todos los empleados">
                                    <i class="fas fa-calendar-plus"></i> Actualizar Períodos
                                </button>
                            </form>
                            
                            <!-- Actualizar Días (antes "Sincronizar Vacaciones") -->
                            <form action="{{ route('vacaciones.update-days') }}" method="POST" style="display: inline;" id="updateDaysForm">
                                @csrf
                                <button type="button" class="btn btn-success" onclick="confirmUpdateDays()" title="Actualizar acumulación diaria de días de vacaciones">
                                    <i class="fas fa-sync-alt"></i> Actualizar Días
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Mensajes de éxito/error -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <form method="GET" action="{{ route('vacaciones.reporte') }}" class="row g-3" id="filterForm">
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Filtrar por Empleado
                                    </label>
                                    <select name="user_filter" class="form-select">
                                        <option value="">Todos los empleados</option>
                                        @foreach($employeesData->sortBy(function($data) {
                                            return $data['employee']->first_name . ' ' . $data['employee']->last_name;
                                        }) as $data)
                                            <option value="{{ $data['employee']->id }}" {{ request('user_filter') == $data['employee']->id ? 'selected' : '' }}>
                                                {{ $data['employee']->first_name }} {{ $data['employee']->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Filtrar por Departamento</label>
                                    <select name="department_filter" class="form-select">
                                        <option value="">Todos los departamentos</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ $departmentFilter == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label"><i class="fas fa-calendar-alt"></i> Filtrar por Año</label>
                                    <select name="year_filter" class="form-select">
                                        @for($year = date('Y') - 2; $year <= date('Y') + 1; $year++)
                                            <option value="{{ $year }}" {{ $yearFilter == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i> Filtrar
                                    </button>
                                    @if(request('user_filter') || $departmentFilter || $yearFilter != date('Y'))
                                        <a href="{{ route('vacaciones.reporte') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
                                            <i class="fas fa-times"></i> Limpiar
                                        </a>
                                    @endif
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Exportar a Excel">
                                            <i class="fas fa-file-excel"></i> Exportar
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <h6 class="dropdown-header">Exportar Reporte a Excel</h6>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            @if($departmentFilter)
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('vacaciones.export-department', $departmentFilter) }}">
                                                        <i class="fas fa-building text-info"></i> Reporte del Departamento
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('vacaciones.export-department') }}">
                                                        <i class="fas fa-globe text-success"></i> Reporte General (Todos)
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Información de filtros activos -->
                    @if(request('user_filter') || $departmentFilter || $yearFilter != date('Y'))
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="fas fa-filter me-2"></i>
                                    <span>
                                        <strong>Filtros activos:</strong>
                                        @if(request('user_filter'))
                                            @php
                                                $selectedUser = $employeesData->firstWhere(function($data) {
                                                    return $data['employee']->id == request('user_filter');
                                                });
                                            @endphp
                                            Empleado: {{ $selectedUser ? $selectedUser['employee']->first_name . ' ' . $selectedUser['employee']->last_name : 'N/A' }}
                                        @endif
                                        @if(request('user_filter') && $departmentFilter) | @endif
                                        @if($departmentFilter)
                                            @php
                                                $selectedDepartment = $departments->find($departmentFilter);
                                            @endphp
                                            Departamento: {{ $selectedDepartment ? $selectedDepartment->name : 'N/A' }}
                                        @endif
                                        @if((request('user_filter') || $departmentFilter) && $yearFilter != date('Y')) | @endif
                                        @if($yearFilter != date('Y'))
                                            Año: {{ $yearFilter }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Estadísticas generales -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $employeesData->count() }}</h3>
                                    <p class="mb-0"><i class="fas fa-users"></i> Total Empleados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $employeesData->sum('days_taken') }}</h3>
                                    <p class="mb-0"><i class="fas fa-calendar-check"></i> Días Tomados {{ $yearFilter }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $employeesData->sum('days_remaining') }}</h3>
                                    <p class="mb-0"><i class="fas fa-calendar-plus"></i> Días Restantes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    @php
                                    
                                        $totalEntitled = $employeesData->sum('days_entitled');
                                        $totalTaken = $employeesData->sum('days_taken');

                                        $avgUsage = ($employeesData->count() > 0 && $totalEntitled > 0) ? round(($totalTaken / $totalEntitled) * 100, 1): 0;
                                    @endphp
                                    <h3>{{ $avgUsage }}%</h3>
                                    <p class="mb-0"><i class="fas fa-percentage"></i> Promedio Uso</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de empleados -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="vacationReportTable">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 80px;"><i class="fas fa-cog"></i> Opciones</th>
                                    <th><i class="fas fa-user"></i> Empleado</th>
                                    <th><i class="fas fa-building"></i> Departamento</th>
                                    <th><i class="fas fa-briefcase"></i> Cargo</th>
                                    <th><i class="fas fa-calendar-plus"></i> Días Disponibles</th>
                                    <th><i class="fas fa-calendar-check"></i> Días Tomados {{ $yearFilter }}</th>
                                    <th><i class="fas fa-calendar-minus"></i> Días Restantes</th>
                                    <th><i class="fas fa-percentage"></i> % Usado</th>
                                    <th><i class="fas fa-info-circle"></i> Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeesData as $data)
                                    @php
                                        $employee = $data['employee'];
                                        $today = \Carbon\Carbon::today();
                                        $usagePercentage = $data['days_entitled'] > 0 ?
                                            round(($data['days_taken'] / $data['days_entitled']) * 100, 1) : 0;
                                        $periodsDisponibles = $data['all_vacation_periods']
                                            ->filter(function($period) use ($today) {
                                                if ($period->is_historical || (isset($period->status) && $period->status === 'vencido')) {
                                                    return false;
                                                }
                                                $dateEnd = \Carbon\Carbon::parse($period->date_end);
                                                $cutoff = !empty($period->cutoff_date)
                                                    ? \Carbon\Carbon::parse($period->cutoff_date)
                                                    : $dateEnd->copy()->addMonths(15);
                                                // Disponible solo si ya cumplió el año (date_end <= hoy) y no ha vencido (hoy <= cutoff)
                                                return $today->gte($dateEnd) && $today->lte($cutoff);
                                            })
                                            ->sortBy('date_end');
                                    @endphp
                                    <tr class="employee-row" data-employee-id="{{ $employee->id }}">
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button type="button" class="dropdown-item toggle-periods" data-employee-id="{{ $employee->id }}">
                                                            <i class="fas fa-calendar-alt text-primary"></i> Ver Períodos
                                                        </button>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a href="{{ route('vacaciones.export-employee', $employee->id) }}" class="dropdown-item">
                                                            <i class="fas fa-file-excel text-success"></i> Exportar Reporte
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
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
                                                <i class="fas fa-building text-info me-1"></i>
                                                {{ $employee->job->departamento->name }}
                                            @else
                                                <span class="text-muted"><i class="fas fa-question-circle me-1"></i>Sin asignar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($employee->job)
                                                <i class="fas fa-briefcase text-secondary me-1"></i>
                                                {{ $employee->job->name }}
                                            @else
                                                <span class="text-muted">Sin cargo</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($periodsDisponibles->isEmpty())
                                                <span class="badge bg-secondary">Sin períodos activos</span>
                                            @else
                                                @foreach($periodsDisponibles as $pd)
                                                    @php $endYr = \Carbon\Carbon::parse($pd->date_end)->year; @endphp
                                                    <div class="mb-1">
                                                        <span class="badge bg-secondary">{{ $endYr }}-{{ $endYr + 1 }}</span>
                                                        <span class="badge bg-primary">{{ number_format($pd->days_availables, 2) }} días</span>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success fs-6">{{ $data['days_taken'] }} días</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $data['days_remaining'] <= 3 ? 'bg-danger' : ($data['days_remaining'] <= 7 ? 'bg-warning' : 'bg-info') }} fs-6">
                                                {{ $data['days_remaining'] }} días
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar {{ $usagePercentage >= 80 ? 'bg-success' : ($usagePercentage >= 50 ? 'bg-warning' : 'bg-info') }}" 
                                                     role="progressbar" 
                                                     style="width: {{ min($usagePercentage, 100) }}%">
                                                    {{ $usagePercentage }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($data['days_remaining'] <= 0)
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-exclamation-triangle"></i> Agotado
                                                </span>
                                            @elseif($data['days_remaining'] <= 3)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-exclamation"></i> Crítico
                                                </span>
                                            @elseif($data['days_taken'] == 0)
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-clock"></i> Sin usar
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Normal
                                                </span>
                                            @endif
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
                                                                    <th style="width: 50px;" class="text-center">#</th>
                                                                    <th><i class="fas fa-calendar-day"></i> Período</th>
                                                                    <th><i class="fas fa-calendar-plus"></i> Año Período</th>
                                                                    <th><i class="fas fa-calendar-minus"></i> Aniversario</th>
                                                                    <th><i class="fas fa-calendar-check"></i> Fecha Corte</th>
                                                                    <th class="text-center"><i class="fas fa-calculator"></i> Días Acumulados</th>
                                                                    {{-- <th class="text-center"><i class="fas fa-plus-circle"></i> DV</th> ❌ ELIMINADO --}}
                                                                    <th class="text-center"><i class="fas fa-umbrella-beach"></i> Días Disfrutados</th>
                                                                    <th class="text-center"><i class="fas fa-chart-line"></i> Restantes</th>
                                                                    <th class="text-center"><i class="fas fa-tag"></i> Tipo</th>
                                                                    <th class="text-center"><i class="fas fa-edit"></i> Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($data['all_vacation_periods'] as $index => $period)
                                                                    @php
                                                                        $remaining = $period->days_availables - $period->days_enjoyed;
                                                                    @endphp
                                                                    <tr>
                                                                        <td class="text-center"><strong>{{ $index + 1 }}</strong></td>
                                                                        <td><span class="badge bg-secondary">Período {{ $period->period }}</span></td>
                                                                        @php $endYear = \Carbon\Carbon::parse($period->date_end)->year; @endphp
                                                                        <td><span class="badge bg-dark">{{ $endYear }}-{{ $endYear + 1 }}</span></td>
                                                                        <td>{{ \Carbon\Carbon::parse($period->date_end)->format('d/m/Y') }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($period->cutoff_date)->format('d/m/Y') }}</td>
                                                                        <td class="text-center">
                                                                            <span class="badge bg-info">{{ number_format($period->days_availables, 2) }}</span>
                                                                        </td>
                                                                        {{-- <td class="text-center">
                                                                            <span class="badge bg-primary">{{ $period->dv }}</span>
                                                                        </td> ❌ ELIMINADO --}}
                                                                        <td class="text-center">
                                                                            <span class="badge bg-success days-enjoyed-badge" id="days-enjoyed-{{ $period->id }}">
                                                                                {{ number_format($period->days_enjoyed, 2) }}
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="badge {{ $remaining <= 0 ? 'bg-danger' : ($remaining <= 3 ? 'bg-warning text-dark' : 'bg-info') }}" 
                                                                                  id="remaining-{{ $period->id }}">
                                                                                {{ number_format($remaining, 2) }}
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center" id="type-cell-{{ $period->id }}">
                                                                            @if($period->is_historical)
                                                                                <span class="badge bg-secondary">
                                                                                    <i class="fas fa-history"></i> Histórico
                                                                                </span>
                                                                            @elseif(isset($period->status) && $period->status === 'vencido')
                                                                                <span class="badge bg-danger">
                                                                                    <i class="fas fa-times-circle"></i> Vencido
                                                                                </span>
                                                                            @else
                                                                                <span class="badge bg-success">
                                                                                    <i class="fas fa-check-circle"></i> Actual
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
                                                                                        {{-- data-dv="{{ $period->dv }}" ❌ ELIMINADO --}}
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
                                                                    <th colspan="5" class="text-end">TOTALES:</th>
                                                                    <th class="text-center">
                                                                        <span class="badge bg-info fs-6">
                                                                            {{ number_format($data['all_vacation_periods']->sum('days_availables'), 2) }}
                                                                        </span>
                                                                    </th>
                                                                    {{-- <th class="text-center">
                                                                        <span class="badge bg-primary fs-6">
                                                                            {{ $data['all_vacation_periods']->sum('dv') }}
                                                                        </span>
                                                                    </th> ❌ ELIMINADO --}}
                                                                    <th class="text-center">
                                                                        <span class="badge bg-success fs-6">
                                                                            {{ number_format($data['all_vacation_periods']->sum('days_enjoyed'), 2) }}
                                                                        </span>
                                                                    </th>
                                                                    <th class="text-center">
                                                                        <span class="badge bg-info fs-6">
                                                                            {{ number_format($data['all_vacation_periods']->sum('days_availables'), 2) }}
                                                                        </span>
                                                                    </th>
                                                                    <th colspan="2"></th>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($employeesData->count() == 0)
                        <div class="text-center py-5">
                            <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No se encontraron empleados</h4>
                            <p class="text-muted">
                                @if($departmentFilter)
                                    No hay empleados en el departamento seleccionado.
                                @else
                                    No hay empleados registrados en el sistema.
                                @endif
                            </p>
                        </div>
                    @endif

                    <!-- Modales para períodos de vacaciones -->
                    @foreach($employeesData as $data)
                        @if($data['vacation_periods']->count() > 0)
                            <div class="modal fade" id="periodsModal{{ $data['employee']->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-calendar-alt"></i>
                                                Períodos de Vacaciones {{ $yearFilter }} - {{ $data['employee']->first_name }} {{ $data['employee']->last_name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th><i class="fas fa-calendar-plus"></i> Fecha Inicio</th>
                                                            <th><i class="fas fa-calendar-minus"></i> Fecha Fin</th>
                                                            <th><i class="fas fa-clock"></i> Días</th>
                                                            <th><i class="fas fa-tag"></i> Tipo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($data['vacation_periods'] as $index => $period)
                                                            <tr>
                                                                <td class="text-center">{{ $index + 1 }}</td>
                                                                <td>
                                                                    <strong>{{ \Carbon\Carbon::parse($period['start'])->format('d-m-Y') }}</strong>
                                                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($period['start'])->locale('es')->isoFormat('dddd') }}</small>
                                                                </td>
                                                                <td>
                                                                    <strong>{{ \Carbon\Carbon::parse($period['end'])->format('d-m-Y') }}</strong>
                                                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($period['end'])->locale('es')->isoFormat('dddd') }}</small>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="badge bg-primary">{{ $period['days_count'] }} días</span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge bg-secondary">{{ $period['type'] }}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <div class="alert alert-info mt-3">
                                                <i class="fas fa-info-circle"></i>
                                                <strong>Resumen:</strong> Total de {{ $data['vacation_periods']->sum('days_count') }} días tomados en {{ $data['vacation_periods']->count() }} período(s) durante {{ $yearFilter }}.
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times"></i> Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

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
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-calculator"></i> Días Acumulados
                                                </label>
                                                <input type="text" class="form-control" id="edit_days_available" readonly>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-plus-circle"></i> Días Adicionales (DV)
                                                </label>
                                                <input type="text" class="form-control" id="edit_dv" readonly>
                                            </div> ❌ ELIMINADO --}}
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

/* Estilos para filas expandibles */
.toggle-periods {
    cursor: pointer;
    transition: all 0.3s ease;
}

.toggle-periods:hover {
    transform: scale(1.1);
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

.periods-detail td {
    border-top: 3px solid #007bff;
}

.edit-days-btn {
    transition: all 0.2s ease;
}

.edit-days-btn:hover {
    transform: scale(1.1);
}

/* Modal mejorado */
.modal-content {
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.modal-header {
    border-radius: 10px 10px 0 0;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Responsive adjustments */
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

/* Print styles */
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== MOSTRAR MODAL DE RESULTADOS DE SINCRONIZACIÓN ==========
    @if(session('sync_completed') || session('sync_error'))
        const syncModal = new bootstrap.Modal(document.getElementById('syncResultsModal'));
        syncModal.show();
    @endif

    // ========== TOGGLE DE PERÍODOS EXPANDIBLES ==========
    document.querySelectorAll('.toggle-periods').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const employeeId = this.getAttribute('data-employee-id');
            const periodsRow = document.getElementById(`periods-${employeeId}`);
            const icon = this.querySelector('i');
            
            if (periodsRow.style.display === 'none' || periodsRow.style.display === '') {
                periodsRow.style.display = 'table-row';
                icon.classList.remove('fa-calendar-alt');
                icon.classList.add('fa-calendar-minus');
                this.innerHTML = '<i class="fas fa-calendar-minus text-danger"></i> Ocultar Períodos';
            } else {
                periodsRow.style.display = 'none';
                icon.classList.remove('fa-calendar-minus');
                icon.classList.add('fa-calendar-alt');
                this.innerHTML = '<i class="fas fa-calendar-alt text-primary"></i> Ver Períodos';
            }
        });
    });

    // ========== MODAL DE EDICIÓN DE PERÍODO ==========
    const editModal = new bootstrap.Modal(document.getElementById('editVacationModal'));
    const editForm = document.getElementById('editVacationForm');
    const saveBtn = document.getElementById('saveVacationBtn');
    
    document.querySelectorAll('.edit-vacation-btn').forEach(button => {
        button.addEventListener('click', function() {
            const vacationId = this.getAttribute('data-vacation-id');
            const period = this.getAttribute('data-period');
            const currentDays = parseFloat(this.getAttribute('data-current-days'));
            const maxDays = parseFloat(this.getAttribute('data-max-days'));
            const available = parseFloat(this.getAttribute('data-available'));
            // const dv = parseFloat(this.getAttribute('data-dv')); // ❌ ELIMINADO - campo deprecado
            const isHistorical = this.getAttribute('data-is-historical') === 'true';
            const status = this.getAttribute('data-status') || 'actual';

            // Llenar el modal
            document.getElementById('edit_vacation_id').value = vacationId;
            document.getElementById('edit_period_number').textContent = period;
            document.getElementById('edit_days_available').value = available.toFixed(2);
            // document.getElementById('edit_dv').value = dv; // ❌ ELIMINADO - campo deprecado
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
        });
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
                // Actualizar UI
                document.getElementById(`days-enjoyed-${vacationId}`).textContent = parseFloat(daysEnjoyed).toFixed(2);
                document.getElementById(`remaining-${vacationId}`).textContent = parseFloat(data.days_remaining).toFixed(2);
                
                // Actualizar color del badge de restantes
                const remainingBadge = document.getElementById(`remaining-${vacationId}`);
                remainingBadge.className = 'badge';
                if (data.days_remaining <= 0) {
                    remainingBadge.classList.add('bg-danger');
                } else if (data.days_remaining <= 3) {
                    remainingBadge.classList.add('bg-warning', 'text-dark');
                } else {
                    remainingBadge.classList.add('bg-info');
                }

                // Actualizar tipo/estado
                const typeCell = document.getElementById(`type-cell-${vacationId}`);
                if (status === 'vencido') {
                    typeCell.innerHTML = '<span class="badge bg-danger"><i class="fas fa-times-circle"></i> Vencido</span>';
                } else {
                    typeCell.innerHTML = '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Actual</span>';
                }

                // Actualizar el data-attribute del botón
                const editBtn = document.querySelector(`[data-vacation-id="${vacationId}"]`);
                if (editBtn) {
                    editBtn.setAttribute('data-current-days', daysEnjoyed);
                    editBtn.setAttribute('data-status', status);
                }

                // Cerrar modal y mostrar mensaje
                editModal.hide();
                showAlert('success', data.message);

                // Recargar después de 2 segundos
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
        const existingAlerts = cardBody.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        cardBody.insertAdjacentHTML('afterbegin', alertHtml);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Funcionalidad para exportar a Excel (placeholder)
    window.exportToExcel = function() {
        alert('Funcionalidad de exportación a Excel - Pendiente de implementar');
    };
});

// ========== ACTUALIZACIÓN DE PERÍODOS Y DÍAS ==========
function confirmUpdatePeriods() {
    if (confirm('¿Está seguro que desea actualizar los períodos de vacaciones?\n\nEste proceso creará los períodos faltantes para todos los empleados activos según su fecha de ingreso y antigüedad.')) {
        const form = document.getElementById('updatePeriodsForm');
        const button = form.querySelector('button');
        
        // Mostrar loading
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando períodos...';
        
        // Enviar formulario
        form.submit();
    }
}

function confirmUpdateDays() {
    if (confirm('¿Está seguro que desea actualizar los días acumulados?\n\nEste proceso actualizará la acumulación diaria de días de vacaciones de todos los empleados activos.')) {
        const form = document.getElementById('updateDaysForm');
        const button = form.querySelector('button');
        
        // Mostrar loading
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando días...';
        
        // Enviar formulario
        form.submit();
    }
}
</script>

@endsection