@extends('layouts.codebase.master')

@section('content')
<div class="container-fluid py-3">

    {{-- ── HEADER ─────────────────────────────────────────────────────── --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-chart-line text-primary me-2"></i>
                Panel de Estadísticas
            </h4>
            <small class="text-muted">
                Uso del sistema · Solicitudes · Logs · Auditoría
            </small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-danger text-white px-3 py-2" style="font-size:.8rem;">
                <i class="fas fa-lock me-1"></i> ACCESO RESTRINGIDO
            </span>
            {{-- Rango de tiempo --}}
            <form method="GET" action="{{ route('admin.stats') }}" class="d-flex gap-1 ms-2">
                <select name="range" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width:130px;">
                    <option value="7"   {{ $range==7  ? 'selected':'' }}>Últimos 7 días</option>
                    <option value="30"  {{ $range==30 ? 'selected':'' }}>Últimos 30 días</option>
                    <option value="60"  {{ $range==60 ? 'selected':'' }}>Últimos 60 días</option>
                    <option value="90"  {{ $range==90 ? 'selected':'' }}>Últimos 90 días</option>
                    <option value="365" {{ $range==365? 'selected':'' }}>Último año</option>
                </select>
            </form>
            {{-- Exportar --}}
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download me-1"></i> Exportar
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.stats.excel', ['range' => $range]) }}">
                            <i class="fas fa-file-excel me-2 text-success"></i> Descargar Excel (.xlsx)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.stats.pdf', ['range' => $range]) }}">
                            <i class="fas fa-file-pdf me-2 text-danger"></i> Descargar PDF (.pdf)
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ── KPI CARDS ────────────────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">

        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:48px;height:48px;background:#e8f4ff;">
                        <i class="fas fa-paper-plane text-primary" style="font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold lh-1">{{ $totalRequests }}</div>
                        <div class="text-muted" style="font-size:.8rem;">Solicitudes totales</div>
                        <div class="text-primary" style="font-size:.75rem;">+{{ $requestsSince }} en rango</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:48px;height:48px;background:#e8fef0;">
                        <i class="fas fa-check-double text-success" style="font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold lh-1">{{ $fullyApproved }}</div>
                        <div class="text-muted" style="font-size:.8rem;">Aprobadas completas</div>
                        <div class="text-danger" style="font-size:.75rem;">{{ $rejected }} rechazadas</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:48px;height:48px;background:#fff8e1;">
                        <i class="fas fa-clock text-warning" style="font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold lh-1">{{ $pendingAll }}</div>
                        <div class="text-muted" style="font-size:.8rem;">Pendientes</div>
                        <div class="text-muted" style="font-size:.75rem;">sin ninguna aprobación</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:48px;height:48px;background:#f3e8ff;">
                        <i class="fas fa-users text-purple" style="font-size:1.1rem;color:#8b5cf6;"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold lh-1">{{ $totalUsers }}</div>
                        <div class="text-muted" style="font-size:.8rem;">Empleados activos</div>
                        <div style="font-size:.75rem; color:#8b5cf6;">{{ $activeEmployeesCount }} activos en rango</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── CHARTS ROW ────────────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">

        {{-- Solicitudes por día --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pb-0">
                    <span class="fw-semibold" style="font-size:.9rem;">
                        <i class="fas fa-chart-bar text-primary me-1"></i>
                        Solicitudes creadas — últimos {{ $range }} días
                    </span>
                </div>
                <div class="card-body pt-2">
                    <canvas id="requestsChart" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Días de vacaciones resumen --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <span class="fw-semibold" style="font-size:.9rem;">
                        <i class="fas fa-umbrella-beach text-info me-1"></i>
                        Saldo de Vacaciones (Global)
                    </span>
                </div>
                <div class="card-body">
                    <canvas id="vacationDonut" height="160"></canvas>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1" style="font-size:.8rem;">
                            <span><span class="badge me-1" style="background:#3b82f6;">&nbsp;</span>Disponibles</span>
                            <strong>{{ number_format($totalAvailDays, 1) }} días</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:.8rem;">
                            <span><span class="badge me-1" style="background:#10b981;">&nbsp;</span>Disfrutados</span>
                            <strong>{{ number_format($totalEnjoyedDays, 1) }} días</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:.8rem;">
                            <span><span class="badge me-1" style="background:#f59e0b;">&nbsp;</span>Reservados</span>
                            <strong>{{ number_format($totalReservedDays, 1) }} días</strong>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between" style="font-size:.78rem; color:#888;">
                            <span>{{ $activePeriods }} períodos activos</span>
                            <span>{{ $expiredPeriods }} vencidos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── ACTIVIDAD POR MES + TOP REQUESTERS ─────────────────────────── --}}
    <div class="row g-3 mb-4">

        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <span class="fw-semibold" style="font-size:.9rem;">
                        <i class="fas fa-calendar-alt text-secondary me-1"></i>
                        Solicitudes por mes (últimos 6 meses)
                    </span>
                </div>
                <div class="card-body pt-2">
                    <canvas id="monthChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <span class="fw-semibold" style="font-size:.9rem;">
                        <i class="fas fa-trophy text-warning me-1"></i>
                        Top solicitantes — últimos {{ $range }} días
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0" style="font-size:.83rem;">
                            <thead style="background:#f8f9fa;">
                                <tr>
                                    <th class="ps-3 py-2">#</th>
                                    <th class="py-2">Empleado</th>
                                    <th class="text-center pe-3 py-2">Solicitudes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topRequestersList as $i => $tr)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $i + 1 }}</td>
                                    <td>
                                        <div class="fw-semibold lh-sm">{{ $tr['name'] }}</div>
                                        <div class="text-muted" style="font-size:.75rem;">{{ $tr['email'] }}</div>
                                    </td>
                                    <td class="text-center pe-3">
                                        <span class="badge bg-primary rounded-pill">{{ $tr['total'] }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Sin solicitudes en el rango</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── AUDITORÍA + ACTIVIDAD USUARIOS ─────────────────────────────── --}}
    <div class="row g-3 mb-4">

        {{-- Usuarios activos por día (proxy via audits) --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <span class="fw-semibold" style="font-size:.9rem;">
                        <i class="fas fa-user-clock text-info me-1"></i>
                        Usuarios activos por día (vía auditoría)
                    </span>
                </div>
                <div class="card-body pt-2">
                    <canvas id="activityChart" height="120"></canvas>
                </div>
                <div class="card-footer bg-white border-0 pt-0">
                    <div class="row g-2 text-center" style="font-size:.78rem;">
                        <div class="col-4">
                            <div class="fw-bold text-success fs-5">{{ $auditsByEvent->get('created')?->cnt ?? 0 }}</div>
                            <div class="text-muted">Creaciones</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-warning fs-5">{{ $auditsByEvent->get('updated')?->cnt ?? 0 }}</div>
                            <div class="text-muted">Actualizaciones</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-danger fs-5">{{ $auditsByEvent->get('deleted')?->cnt ?? 0 }}</div>
                            <div class="text-muted">Eliminaciones</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Auditoría reciente --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between align-items-center">
                    <span class="fw-semibold" style="font-size:.9rem;">
                        <i class="fas fa-history text-secondary me-1"></i>
                        Auditoría reciente
                    </span>
                    <small class="text-muted">Últimos 30 registros</small>
                </div>
                <div class="card-body p-0" style="max-height:340px; overflow-y:auto;">
                    <table class="table table-sm table-hover mb-0" style="font-size:.8rem;">
                        <thead style="background:#f8f9fa; position:sticky; top:0; z-index:1;">
                            <tr>
                                <th class="ps-3 py-2">Evento</th>
                                <th class="py-2">Modelo</th>
                                <th class="py-2">Usuario</th>
                                <th class="py-2">IP</th>
                                <th class="pe-3 py-2">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAuditsEnriched as $audit)
                            <tr>
                                <td class="ps-3">
                                    @if($audit->event === 'created')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">created</span>
                                    @elseif($audit->event === 'updated')
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">updated</span>
                                    @elseif($audit->event === 'deleted')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">deleted</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border">{{ $audit->event }}</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $audit->model_name }}</td>
                                <td>{{ $audit->user_name }}</td>
                                <td class="text-muted" style="font-size:.73rem;">{{ $audit->ip_address ?? '—' }}</td>
                                <td class="pe-3 text-muted" style="font-size:.73rem;">
                                    {{ \Carbon\Carbon::parse($audit->created_at)->format('d/m H:i') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Sin registros de auditoría</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- ── SYSTEM LOGS ──────────────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <span class="fw-semibold" style="font-size:.9rem;">
                        <i class="fas fa-terminal text-danger me-1"></i>
                        System Logs recientes
                        <span class="ms-2">
                            @if(isset($logsByLevel['error']))
                                <span class="badge bg-danger">{{ $logsByLevel['error']->cnt }} errores</span>
                            @endif
                            @if(isset($logsByLevel['warning']))
                                <span class="badge bg-warning text-dark">{{ $logsByLevel['warning']->cnt }} advertencias</span>
                            @endif
                            @if(isset($logsByLevel['info']))
                                <span class="badge bg-info text-white">{{ $logsByLevel['info']->cnt }} info</span>
                            @endif
                        </span>
                    </span>
                    <div class="d-flex gap-2" style="font-size:.78rem; color:#888;">
                        @if(isset($logsByStatus['pending']))
                            <span><i class="fas fa-circle text-warning me-1"></i>{{ $logsByStatus['pending']->cnt }} pendientes</span>
                        @endif
                        @if(isset($logsByStatus['resolved']))
                            <span><i class="fas fa-circle text-success me-1"></i>{{ $logsByStatus['resolved']->cnt }} resueltos</span>
                        @endif
                        @if(isset($logsByStatus['ignored']))
                            <span><i class="fas fa-circle text-secondary me-1"></i>{{ $logsByStatus['ignored']->cnt }} ignorados</span>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0" style="max-height:380px; overflow-y:auto;">
                    <table class="table table-sm table-hover mb-0" style="font-size:.8rem;">
                        <thead style="background:#f8f9fa; position:sticky; top:0; z-index:1;">
                            <tr>
                                <th class="ps-3 py-2" style="width:90px;">Nivel</th>
                                <th class="py-2" style="width:150px;">Tipo</th>
                                <th class="py-2">Mensaje</th>
                                <th class="py-2" style="width:90px;">Estado</th>
                                <th class="pe-3 py-2" style="width:120px;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLogs as $log)
                            <tr>
                                <td class="ps-3">
                                    @if($log->level === 'error')
                                        <span class="badge bg-danger">error</span>
                                    @elseif($log->level === 'warning')
                                        <span class="badge bg-warning text-dark">warning</span>
                                    @elseif($log->level === 'info')
                                        <span class="badge bg-info text-white">info</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $log->level }}</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $log->type }}</td>
                                <td>
                                    <span title="{{ $log->message }}" style="cursor:default;">
                                        {{ \Illuminate\Support\Str::limit($log->message, 120) }}
                                    </span>
                                    @if($log->context)
                                        <button class="btn btn-link btn-sm p-0 ms-1 text-muted"
                                                data-bs-toggle="tooltip"
                                                title="{{ $log->context }}"
                                                style="font-size:.7rem;">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    @if($log->status === 'pending')
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">pendiente</span>
                                    @elseif($log->status === 'resolved')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">resuelto</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border">{{ $log->status }}</span>
                                    @endif
                                </td>
                                <td class="pe-3 text-muted">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('d/m H:i') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Sin logs registrados
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ── FOOTER INFO ──────────────────────────────────────────────────── --}}
    <div class="text-muted text-center" style="font-size:.75rem;">
        Datos actualizados en tiempo real · Rango actual: últimos {{ $range }} días desde
        {{ $since->format('d/m/Y') }}
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const gridColor = 'rgba(0,0,0,0.05)';

    // ── Solicitudes por día ──────────────────────────────────
    new Chart(document.getElementById('requestsChart'), {
        type: 'bar',
        data: {
            labels: @json($dailyLabels),
            datasets: [{
                label: 'Solicitudes',
                data: @json($dailyData),
                backgroundColor: 'rgba(59,130,246,0.7)',
                borderColor:     'rgba(59,130,246,1)',
                borderWidth: 1,
                borderRadius: 3,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid:  { color: gridColor }
                },
                x: {
                    ticks: { font: { size: 10 }, maxTicksLimit: 15 },
                    grid:  { display: false }
                }
            }
        }
    });

    // ── Donut vacaciones ────────────────────────────────────
    new Chart(document.getElementById('vacationDonut'), {
        type: 'doughnut',
        data: {
            labels: ['Disponibles', 'Disfrutados', 'Reservados'],
            datasets: [{
                data: [
                    {{ $totalAvailDays }},
                    {{ $totalEnjoyedDays }},
                    {{ $totalReservedDays }}
                ],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.toFixed(1)} días`
                    }
                }
            }
        }
    });

    // ── Solicitudes por mes ─────────────────────────────────
    new Chart(document.getElementById('monthChart'), {
        type: 'line',
        data: {
            labels: @json($monthLabels),
            datasets: [{
                label: 'Solicitudes',
                data: @json($monthData),
                fill: true,
                backgroundColor: 'rgba(99,102,241,0.1)',
                borderColor: 'rgba(99,102,241,0.8)',
                borderWidth: 2,
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: 'rgba(99,102,241,1)',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid:  { color: gridColor }
                },
                x: {
                    ticks: { font: { size: 11 } },
                    grid:  { display: false }
                }
            }
        }
    });

    // ── Usuarios activos por día ────────────────────────────
    new Chart(document.getElementById('activityChart'), {
        type: 'bar',
        data: {
            labels: @json($dailyLabels),
            datasets: [{
                label: 'Usuarios activos',
                data: @json($auditDailyData),
                backgroundColor: 'rgba(20,184,166,0.65)',
                borderColor:     'rgba(20,184,166,1)',
                borderWidth: 1,
                borderRadius: 3,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid:  { color: gridColor }
                },
                x: {
                    ticks: { font: { size: 10 }, maxTicksLimit: 10 },
                    grid:  { display: false }
                }
            }
        }
    });

    // Tooltips Bootstrap
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el, { placement: 'top' });
    });
});
</script>
@endpush
@endsection
