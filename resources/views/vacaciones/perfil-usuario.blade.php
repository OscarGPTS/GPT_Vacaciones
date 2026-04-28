@extends('layouts.codebase.master')

@push('css')
<style>
    .vac-profile-banner {
        height: 180px;
        background-image: url('/assets/images/banner/profile.png');
        background-size: cover;
        background-position: center;
        position: relative;
        border-radius: .5rem .5rem 0 0;
        overflow: hidden;
    }
    .vac-profile-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 10% 80%, rgba(249,190,0,.07) 0%, transparent 50%),
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20'%3E%3Ccircle cx='1' cy='1' r='1' fill='rgba(255,255,255,.06)'/%3E%3C/svg%3E");
        background-size: auto, 20px 20px;
    }
    .vac-profile-banner::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #CF0A2C 0%, #F9BE00 60%, transparent 100%);
        opacity: .75;
    }
    .vac-profile-card { position: relative; }
    .vac-avatar-wrap {
        position: absolute;
        top: calc(180px - 50px);
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
    }
    .vac-avatar-wrap img,
    .vac-avatar-wrap .vac-avatar-placeholder {
        width: 100px; height: 100px;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,.18);
        object-fit: cover;
        background: #e8f4f1;
    }
    .vac-avatar-placeholder {
        display: flex; align-items: center; justify-content: center;
        font-size: 2.5rem; color: #24695c; font-weight: 700;
    }
    .vac-period-card {
        border-radius: .6rem;
        border-left: 4px solid #24695c;
        transition: transform .15s, box-shadow .15s;
    }
    .vac-period-card:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(0,0,0,.1) !important; }
    .vac-period-card.vac-danger  { border-left-color: #c0392b; background: #fff5f5; }
    .vac-period-card.vac-warning { border-left-color: #e67e22; background: #fffbf0; }
    .vac-period-card.vac-success { border-left-color: #24695c; background: #f0fdf8; }
    .vac-period-stat {
        display: flex; flex-direction: column; align-items: center;
        padding: .35rem .6rem; border-radius: .4rem; min-width: 70px; text-align: center;
    }
    .vac-period-stat-value { font-size: 1.5rem; font-weight: 700; line-height: 1; }
    .vac-period-stat-label { font-size: .67rem; text-transform: uppercase; letter-spacing: .03em; opacity: .72; margin-top: .15rem; }
    .boss-mini-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        object-fit: cover; border: 2px solid #24695c33;
        background: #e8f4f1; flex-shrink: 0;
    }
    .boss-mini-placeholder {
        width: 36px; height: 36px; border-radius: 50%;
        background: #24695c22; display: flex; align-items: center; justify-content: center;
        color: #24695c; font-weight: 700; font-size: .85rem; flex-shrink: 0;
    }
    .firma-preview {
        border: 1.5px solid #d1e7dd; border-radius: .5rem;
        padding: .5rem; background: #f8fdfc;
        max-height: 90px; object-fit: contain;
    }
    @media (max-width: 991px) {
        .vac-profile-banner { height: 140px; }
        .vac-avatar-wrap { top: calc(140px - 44px); }
        .vac-avatar-wrap img, .vac-avatar-wrap .vac-avatar-placeholder { width: 88px; height: 88px; }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- ═══ BARRA SUPERIOR: VOLVER ═══════════════════════════════════════════ --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('vacaciones.reporte') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Volver al reporte
        </a>
        <div>
            <h5 class="mb-0 fw-bold" style="color:#1b2a3b;">
                Perfil de Vacaciones
            </h5>
            <p class="mb-0 text-muted" style="font-size:.8rem;">
                Visualización de RH — solo lectura
            </p>
        </div>
    </div>

    {{-- ═══ BANNER + AVATAR ═══════════════════════════════════════════════════ --}}
    <div class="card mb-4 border-0 shadow-sm vac-profile-card">
        <div class="vac-profile-banner"></div>

        <div class="vac-avatar-wrap">
            @if($currentUser->profile_image)
                <img src="{{ $currentUser->profile_image }}" alt="{{ $currentUser->first_name }}">
            @else
                <div class="vac-avatar-placeholder">
                    {{ strtoupper(substr($currentUser->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($currentUser->last_name ?? '', 0, 1)) }}
                </div>
            @endif
        </div>

        <div class="card-body text-center pt-5 pb-3">
            <h4 class="mb-1 fw-bold">
                {{ trim(($currentUser->first_name ?? '') . ' ' . ($currentUser->last_name ?? '')) ?: 'Sin nombre' }}
            </h4>
            <p class="mb-1 text-muted" style="font-size:.9rem;">{{ $currentUser->job?->name ?? 'Sin puesto' }}</p>
            <div class="d-flex justify-content-center gap-2 flex-wrap mt-1">
                @if($currentUser->job?->departamento)
                    <span class="badge bg-light text-secondary border" style="font-size:.73rem;">
                        <i class="fa fa-sitemap me-1"></i>{{ $currentUser->job->departamento->name }}
                    </span>
                @endif
                @if($currentUser->razonSocial)
                    <span class="badge bg-light text-secondary border" style="font-size:.73rem;">
                        <i class="fa fa-building me-1"></i>{{ $currentUser->razonSocial->name }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ TÉRMINOS (solo lectura) ════════════════════════════════════════════ --}}
    <div class="card border-0 shadow-sm mb-4" style="border-left:4px solid {{ $hasAcceptedTerms ? '#198754' : '#f59e0b' }} !important; border-radius:.5rem;">
        <div class="card-body py-3 px-4">
            <div class="d-flex align-items-center gap-3">
                <div style="width:40px;height:40px;border-radius:.45rem;background:{{ $hasAcceptedTerms ? '#d1fae5' : '#fef3c7' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa {{ $hasAcceptedTerms ? 'fa-file-contract' : 'fa-exclamation-triangle' }}"
                       style="color:{{ $hasAcceptedTerms ? '#065f46' : '#92400e' }};font-size:1rem;"></i>
                </div>
                <div>
                    <div class="fw-semibold" style="font-size:.9rem;color:#111827;">
                        Términos y Condiciones del Sistema de Vacaciones
                    </div>
                    <div style="font-size:.78rem;color:#6b7280;margin-top:.1rem;">
                        @if($hasAcceptedTerms)
                            <i class="fa fa-check-circle text-success me-1"></i>
                            Aceptados el <strong>{{ $termsAcceptedAt->format('d/m/Y') }}</strong> a las {{ $termsAcceptedAt->format('H:i') }}
                        @else
                            <i class="fa fa-clock text-warning me-1"></i>
                            El colaborador aún no ha aceptado los términos y condiciones
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ JEFE DIRECTO + FIRMA DIGITAL ══════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div style="width:44px;height:44px;border-radius:.5rem;background:#eaf7f4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa fa-user-tie" style="color:#24695c;font-size:1.15rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.06em;color:#6c757d;font-weight:600;">Jefe directo</div>
                        @if($currentUser->jefe)
                            <div class="d-flex align-items-center gap-2 mt-1">
                                @if($currentUser->jefe->profile_image)
                                    <img src="{{ $currentUser->jefe->profile_image }}" class="boss-mini-avatar" alt="">
                                @else
                                    <div class="boss-mini-placeholder">
                                        {{ strtoupper(substr($currentUser->jefe->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr($currentUser->jefe->last_name ?? '', 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold" style="font-size:.92rem;color:#1b4c43;line-height:1.2;">
                                        {{ trim(($currentUser->jefe->first_name ?? '') . ' ' . ($currentUser->jefe->last_name ?? '')) }}
                                    </div>
                                    <div class="text-muted" style="font-size:.78rem;">{{ $currentUser->jefe->job?->name ?? '' }}</div>
                                </div>
                            </div>
                        @else
                            <div class="text-muted" style="font-size:.85rem;">Sin jefe directo asignado</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:44px;height:44px;border-radius:.5rem;background:#{{ $hasSignature ? 'eaf7f4' : 'fff8e1' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa fa-pen-nib" style="color:#{{ $hasSignature ? '24695c' : 'b45309' }};font-size:1.15rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.06em;color:#6c757d;font-weight:600;">Firma digital</div>
                            @if($hasSignature)
                                <div class="mt-2">
                                    <img src="{{ asset($userSignature->signature_url) }}?v={{ filemtime(public_path($userSignature->signature_url)) }}"
                                         class="firma-preview" alt="Firma del colaborador"
                                         style="max-height:56px;max-width:160px;">
                                </div>
                            @else
                                <div class="text-muted mt-1" style="font-size:.83rem;">
                                    El colaborador aún no ha registrado su firma digital.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ BALANCE POR PERÍODO ═══════════════════════════════════════════════ --}}
    @php
        $activePeriods = $vacationPeriods
            ->filter(fn($p) => !$p['is_not_yet_available'])
            ->sortBy('days_until_expiration')
            ->values();
    @endphp

    @if($activePeriods->isNotEmpty())
    <div class="row g-3 mb-4">
        @foreach($activePeriods as $period)
        @php
            if ($period['is_expired'])       { $cardClass = 'vac-danger';  $expBadge = 'danger';  $expIcon = 'fa-times-circle'; }
            elseif ($period['expires_soon']) { $cardClass = 'vac-warning'; $expBadge = 'warning'; $expIcon = 'fa-exclamation-triangle'; }
            else                             { $cardClass = 'vac-success'; $expBadge = 'success'; $expIcon = 'fa-check-circle'; }
            $expDate  = \Carbon\Carbon::parse($period['expiration_date'])->format('d/m/Y');
            $daysLeft = abs((int)$period['days_until_expiration']);
            $dStart   = \Carbon\Carbon::parse($period['date_start'])->format('d/m/Y');
            $dEnd     = \Carbon\Carbon::parse($period['date_end'])->format('d/m/Y');
        @endphp
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm vac-period-card {{ $cardClass }}">
                <div class="card-body pb-2 pt-3 px-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="fw-bold" style="font-size:.95rem;color:#1b4c43;">Período {{ $period['period'] }}</div>
                            <div class="text-muted" style="font-size:.73rem;">{{ $dStart }} — {{ $dEnd }}</div>
                        </div>
                        <span class="badge bg-{{ $expBadge }} text-{{ $expBadge === 'warning' ? 'dark' : 'white' }} d-flex align-items-center gap-1" style="font-size:.72rem;">
                            <i class="fa {{ $expIcon }}"></i> Vence {{ $expDate }}
                        </span>
                    </div>
                    <div class="d-flex gap-2 justify-content-around mt-3">
                        <div class="vac-period-stat" style="background:rgba(186,137,93,.1);">
                            <div class="vac-period-stat-value" style="color:#6a3d00;">{{ $period['days_enjoyed'] }}</div>
                            <div class="vac-period-stat-label" style="color:#ba895d;">Disfrutados</div>
                        </div>
                        <div class="vac-period-stat" style="background:rgba(41,128,185,.1);">
                            <div class="vac-period-stat-value" style="color:#1a3a8a;">{{ $period['available_days'] }}</div>
                            <div class="vac-period-stat-label" style="color:#2980b9;">Disponibles</div>
                        </div>
                    </div>
                    <div class="text-center mt-2 mb-1" style="font-size:.75rem;color:#6c757d;">
                        @if($period['is_expired'])
                            <span class="text-danger"><i class="fa fa-clock me-1"></i>Vencido hace {{ $daysLeft }} días</span>
                        @elseif($period['expires_soon'])
                            <span class="text-warning fw-semibold"><i class="fa fa-exclamation-triangle me-1"></i>Vence en {{ $daysLeft }} días</span>
                        @else
                            <span class="text-success"><i class="fa fa-calendar-check me-1"></i>Vence en {{ $daysLeft }} días</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-light border mb-4 text-center py-3">
        <i class="fa fa-calendar-times text-muted me-2"></i>
        <span class="text-muted">No hay períodos de vacaciones activos en este momento.</span>
    </div>
    @endif

    {{-- ═══ TABS: SOLICITUDES + HISTORIAL ════════════════════════════════════ --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <ul class="nav nav-tabs card-header-tabs" id="perfilTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-semibold" id="tab-solicitudes" data-bs-toggle="tab"
                            data-bs-target="#pane-solicitudes" type="button">
                        <i class="fa fa-list-alt me-1"></i> Solicitudes
                        <span class="badge bg-primary ms-1">{{ $requests->count() }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-semibold" id="tab-historial" data-bs-toggle="tab"
                            data-bs-target="#pane-historial" type="button">
                        <i class="fa fa-history me-1"></i> Historial aprobado
                        <span class="badge bg-success ms-1">{{ $vacationHistory->sum('total_days') }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="perfilTabsContent">

                {{-- ── Tab Solicitudes ──────────────────────────────────── --}}
                <div class="tab-pane fade show active" id="pane-solicitudes" role="tabpanel">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show py-2 mb-3">
                            <i class="fa fa-check-circle me-1"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show py-2 mb-3">
                            <i class="fa fa-times-circle me-1"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if($requests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="font-size:.88rem;">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha Solicitud</th>
                                    <th>Tipo</th>
                                    <th class="text-center">Días</th>
                                    <th>Período</th>
                                    <th>Días de Vacaciones</th>
                                    <th>Jefe Directo</th>
                                    <th>Dirección</th>
                                    <th>RH</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $req)
                                @php
                                    $periodNumber = null;
                                    if ($req->opcion) {
                                        $parts = explode('|', $req->opcion);
                                        $periodNumber = $parts[0] ?? null;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $req->created_at->format('d/m/Y H:i') }}</td>
                                    <td><span class="badge bg-info">{{ $req->type_request }}</span></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $req->requestDays->count() }}</span>
                                    </td>
                                    <td>
                                        @if($periodNumber)
                                            <span class="badge bg-secondary">Período {{ $periodNumber }}</span>
                                        @else
                                            <span class="text-muted fst-italic">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach($req->requestDays->sortBy('start')->take(4) as $day)
                                            <span class="badge bg-light text-dark border me-1 mb-1" style="font-size:.72rem;">
                                                {{ \Carbon\Carbon::parse($day->start)->format('d/m/Y') }}
                                            </span>
                                        @endforeach
                                        @if($req->requestDays->count() > 4)
                                            <span class="badge bg-secondary">+{{ $req->requestDays->count() - 4 }} más</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->direct_manager_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @elseif($req->direct_manager_status === 'Rechazada')
                                            <span class="badge bg-danger">Rechazada</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->direction_approbation_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @elseif($req->direction_approbation_status === 'Rechazada')
                                            <span class="badge bg-danger">Rechazada</span>
                                        @elseif($req->direction_approbation_status === 'Pendiente')
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        @else
                                            <span class="badge bg-secondary">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->human_resources_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @elseif($req->human_resources_status === 'Rechazada')
                                            <span class="badge bg-danger">Rechazada</span>
                                        @elseif($req->human_resources_status === 'Cancelada')
                                            <span class="badge bg-secondary">Cancelada</span>
                                        @elseif($req->human_resources_status === 'Pendiente')
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        @else
                                            <span class="badge bg-secondary">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button type="button" class="btn btn-outline-info btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#detailModal{{ $req->id }}"
                                                    title="Ver detalle">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            @if(!in_array($req->human_resources_status, ['Aprobada', 'Cancelada']))
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                    title="Cancelar solicitud"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#cancelModal"
                                                    data-request-id="{{ $req->id }}"
                                                    data-user-id="{{ $currentUser->id }}"
                                                    data-dias="{{ $req->requestDays->count() }}"
                                                    data-fecha="{{ $req->created_at->format('d/m/Y') }}">
                                                <i class="fa fa-ban"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-light border text-center py-3 mb-0">
                        <i class="fa fa-inbox text-muted me-2"></i>
                        <span class="text-muted">Este colaborador no tiene solicitudes registradas.</span>
                    </div>
                    @endif
                </div>

                {{-- ── Tab Historial ────────────────────────────────────── --}}
                <div class="tab-pane fade" id="pane-historial" role="tabpanel">
                    @if($vacationHistory->count() > 0)
                        @foreach($vacationHistory as $yearData)
                        <div class="card border-0 border-bottom mb-3">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                <span class="fw-bold" style="font-size:.9rem;color:#1b2a3b;">
                                    <i class="fa fa-calendar-alt text-primary me-1"></i> {{ $yearData['year'] }}
                                </span>
                                <span class="badge bg-primary">
                                    {{ $yearData['total_days'] }} {{ $yearData['total_days'] == 1 ? 'día' : 'días' }} tomados
                                </span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0" style="font-size:.85rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center ps-3" style="width:40px;">#</th>
                                                <th>Fecha inicio</th>
                                                <th>Fecha fin</th>
                                                <th class="text-center">Días</th>
                                                <th>Días aprobados</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($yearData['vacations'] as $i => $vacation)
                                            <tr>
                                                <td class="text-center ps-3 text-muted">{{ $i + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($vacation['start'])->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($vacation['end'])->format('d/m/Y') }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-success">{{ $vacation['days_count'] }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted" style="font-size:.8rem;">
                                                        {{ implode(', ', $vacation['approved_days']) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="alert alert-light border text-center py-3 mb-0">
                        <i class="fa fa-calendar-times text-muted me-2"></i>
                        <span class="text-muted">Este colaborador no tiene vacaciones aprobadas registradas.</span>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Info de desbloqueo si aplica --}}
    @if($unlockInfo)
    <div class="alert alert-info border mb-4 py-3">
        <div class="d-flex align-items-start gap-3">
            <i class="fa fa-info-circle fa-2x text-info mt-1"></i>
            <div>
                <strong>Vacaciones aún no disponibles</strong>
                <p class="mb-1 mt-1">
                    <i class="fa fa-calendar-alt me-1"></i>
                    Fecha de ingreso: <strong>{{ $unlockInfo['admission_date'] }}</strong>
                </p>
                <p class="mb-0">
                    <i class="fa fa-unlock-alt text-success me-1"></i>
                    Se desbloquean el <strong class="text-success">{{ $unlockInfo['unlock_date'] }}</strong>
                    <span class="badge bg-success ms-1">faltan {{ $unlockInfo['days_remaining'] }} días</span>
                </p>
            </div>
        </div>
    </div>
    @endif

</div>{{-- /container-fluid --}}

{{-- ═══ MODALES DE DETALLE DE SOLICITUDES ════════════════════════════════════ --}}
@foreach($requests as $req)
<div class="modal fade" id="detailModal{{ $req->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-white">
            <div class="modal-header bg-primary text-white ">
                <h5 class="modal-title">
                    <i class="fa fa-info-circle me-1"></i> Detalle de Solicitud
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fa fa-file-alt text-warning me-1"></i> Datos de la Solicitud</h6>
                        <ul class="list-unstyled" style="font-size:.9rem;">
                            <li><strong>Tipo:</strong> {{ $req->type_request }}</li>
                            <li><strong>Fecha:</strong> {{ $req->created_at->format('d/m/Y H:i') }}</li>
                            @if($req->opcion)
                                <li><strong>Opción:</strong> {{ $req->opcion }}</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fa fa-clipboard-check text-success me-1"></i> Estados</h6>
                        <ul class="list-unstyled" style="font-size:.9rem;">
                            <li><strong>Jefe:</strong>
                                <span class="badge bg-{{ $req->direct_manager_status === 'Aprobada' ? 'success' : ($req->direct_manager_status === 'Rechazada' ? 'danger' : 'warning') }}">
                                    {{ $req->direct_manager_status }}
                                </span>
                            </li>
                            <li><strong>Dirección:</strong>
                                <span class="badge bg-{{ $req->direction_approbation_status === 'Aprobada' ? 'success' : ($req->direction_approbation_status === 'Rechazada' ? 'danger' : ($req->direction_approbation_status === 'Pendiente' ? 'warning' : 'secondary')) }}">
                                    {{ $req->direction_approbation_status ?? '—' }}
                                </span>
                            </li>
                            <li><strong>RH:</strong>
                                <span class="badge bg-{{ $req->human_resources_status === 'Aprobada' ? 'success' : ($req->human_resources_status === 'Rechazada' ? 'danger' : ($req->human_resources_status === 'Pendiente' ? 'warning' : 'secondary')) }}">
                                    {{ $req->human_resources_status ?? '—' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                <h6><i class="fa fa-calendar-days text-success me-1"></i> Días Solicitados ({{ $req->requestDays->count() }})</h6>
                <div class="row">
                    @foreach($req->requestDays->sortBy('start') as $day)
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                        <div class="card border-primary text-center p-2">
                            <div class="fw-bold">{{ \Carbon\Carbon::parse($day->start)->format('d') }}</div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($day->start)->format('M Y') }}</small>
                            <small class="text-primary">{{ \Carbon\Carbon::parse($day->start)->locale('es')->dayName }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($req->reveal)
                <hr>
                <h6><i class="fa fa-user-shield text-secondary me-1"></i> Responsable durante ausencia</h6>
                <p>{{ $req->reveal->first_name ?? 'N/A' }} {{ $req->reveal->last_name ?? '' }}</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- ═══ MODAL CANCELAR SOLICITUD ══════════════════════════════════════════════ --}}
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white border-0 shadow">
            <div class="modal-header border-0 pb-0" style="background:#fff5f5;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:38px;height:38px;border-radius:.4rem;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-exclamation-triangle text-danger"></i>
                    </div>
                    <h5 class="modal-title mb-0 fw-bold" id="cancelModalLabel" style="color:#991b1b;font-size:1rem;">
                        Cancelar Solicitud
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <p style="font-size:.9rem;color:#374151;">
                    ¿Estás seguro de que deseas cancelar esta solicitud?
                </p>
                <div class="rounded p-3 mb-3" style="background:#f8fafc;border:1px solid #e2e8f0;font-size:.85rem;">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Fecha solicitud:</span>
                        <span class="fw-semibold" id="cancelFecha">—</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Días a liberar:</span>
                        <span class="fw-semibold text-success" id="cancelDias">—</span>
                    </div>
                </div>
                <div class="alert alert-warning py-2 mb-0" style="font-size:.82rem;">
                    <i class="fa fa-info-circle me-1"></i>
                    La solicitud quedará marcada como <strong>Cancelada</strong> por RH y los días reservados serán liberados de vuelta al saldo del período.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    No cancelar
                </button>
                <form id="cancelForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm fw-semibold">
                        <i class="fa fa-times me-1"></i> Sí, cancelar solicitud
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const cancelModal = document.getElementById('cancelModal');
    if (!cancelModal) return;

    cancelModal.addEventListener('show.bs.modal', function (e) {
        const btn       = e.relatedTarget;
        const requestId = btn.dataset.requestId;
        const userId    = btn.dataset.userId;
        const dias      = btn.dataset.dias;
        const fecha     = btn.dataset.fecha;

        document.getElementById('cancelFecha').textContent = fecha;
        document.getElementById('cancelDias').textContent  = dias + (dias == 1 ? ' día' : ' días');

        const form = document.getElementById('cancelForm');
        form.action = `/vacaciones/reporte/perfil/${userId}/solicitud/${requestId}`;
    });
})();
</script>
@endpush

@endsection
