@extends('layouts.codebase.master')

@push('css')
<style>
    /* ── Banner & Avatar ─────────────────────────────────── */
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
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,.18);
        object-fit: cover;
        background: #e8f4f1;
    }
    .vac-avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #24695c;
        font-weight: 700;
    }
    /* ── Period stat cards ───────────────────────────────── */
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
        padding: .35rem .6rem;
        border-radius: .4rem;
        min-width: 70px;
        text-align: center;
    }
    .vac-period-stat-value { font-size: 1.5rem; font-weight: 700; line-height: 1; }
    .vac-period-stat-label { font-size: .67rem; text-transform: uppercase; letter-spacing: .03em; opacity: .72; margin-top: .15rem; }
    /* ── Pulse button ────────────────────────────────────── */
    @keyframes btn-pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(245,158,11,.55); }
        50%       { box-shadow: 0 0 0 9px rgba(245,158,11,0); }
    }
    .btn-pulse { animation: btn-pulse 2.2s ease-in-out infinite; }
    @keyframes btn-glow {
        0%, 100% { box-shadow: 0 0 4px 1px rgba(245,158,11,.6), 0 0 0 2px rgba(245,158,11,.3); }
        50%       { box-shadow: 0 0 14px 4px rgba(245,158,11,.95), 0 0 0 3px rgba(245,158,11,.7); }
    }
    .btn-blink { animation: btn-glow 1.4s ease-in-out infinite; }
    /* ── Boss mini card ──────────────────────────────────── */
    .boss-mini {
        display: flex; align-items: center; gap: .65rem;
        background: #f8fdfc; border: 1.5px solid #e3eeec;
        border-radius: .5rem; padding: .65rem .85rem;
    }
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
    /* ── Firma canvas ────────────────────────────────────── */
    #signature-canvas {
        border: 2px dashed #24695c;
        border-radius: .5rem;
        cursor: crosshair;
        background: #f9fffe;
        width: 300px;
        max-width: 100%;
        aspect-ratio: 1 / 1;
        display: block;
        margin: 0 auto;
        touch-action: none;
    }
    .firma-preview {
        border: 1.5px solid #d1e7dd;
        border-radius: .5rem;
        padding: .5rem;
        background: #f8fdfc;
        max-height: 90px;
        object-fit: contain;
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

    {{-- ═══ BANNER + AVATAR DE PERFIL ══════════════════════════════════════ --}}
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

    {{-- ═══ TÉRMINOS Y CONDICIONES — card compacto ════════════════════════ --}}
    @if(session('terms_accepted'))
    <div class="alert alert-success alert-dismissible fade show mb-3 py-2" style="font-size:.88rem;">
        <i class="fa fa-check-circle me-1"></i>{{ session('terms_accepted') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm mb-4" style="border-left:4px solid {{ $hasAcceptedTerms ? '#198754' : '#f59e0b' }} !important; border-radius:.5rem;">
        <div class="card-body py-3 px-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;border-radius:.45rem;background:{{ $hasAcceptedTerms ? '#d1fae5' : '#fef3c7' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa {{ $hasAcceptedTerms ? 'fa-file-contract' : 'fa-exclamation-triangle' }}"
                           style="color:{{ $hasAcceptedTerms ? '#065f46' : '#92400e' }};font-size:1rem;"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:.9rem;color:#111827;">
                            Ayuda
                        </div>
                        <div style="font-size:.78rem;color:#6b7280;margin-top:.1rem;">
                            @if($hasAcceptedTerms)
                                <i class="fa fa-check-circle text-success me-1"></i>
                                Aceptados el <strong>{{ $termsAcceptedAt->format('d/m/Y') }}</strong> a las {{ $termsAcceptedAt->format('H:i') }}
                            @else
                                <i class="fa fa-clock text-warning me-1"></i>
                                Debes leer y aceptar los términos para poder crear solicitudes
                            @endif
                        </div>
                    </div>
                </div>
                <button type="button"
                        class="btn btn-sm {{ $hasAcceptedTerms ? 'btn-outline-secondary' : 'btn-warning fw-semibold btn-blink' }}"
                        data-bs-toggle="modal" data-bs-target="#termsModal"
                        style="white-space:nowrap;">
                    <i class="fa {{ $hasAcceptedTerms ? 'fa-eye' : 'fa-file-signature' }} me-1"></i>
                    {{ $hasAcceptedTerms ? 'Ver términos' : 'Leer y aceptar' }}
                </button>
            </div>
        </div>
    </div>

    {{-- ═══ FILA: JEFE DIRECTO + FIRMA DIGITAL ════════════════════════════ --}}
    <div class="row g-3 mb-4">

        {{-- Jefe directo --}}
        <div class="col-12 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div style="width:44px; height:44px; border-radius:.5rem; background:#eaf7f4; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-user-tie" style="color:#24695c; font-size:1.15rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:.72rem; text-transform:uppercase; letter-spacing:.06em; color:#6c757d; font-weight:600;">Jefe directo</div>
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
                                    <div class="fw-semibold" style="font-size:.92rem; color:#1b4c43; line-height:1.2;">
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

        {{-- Firma digital --}}
        <div class="col-12 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:44px; height:44px; border-radius:.5rem; background:#{{ $hasSignature ? 'eaf7f4' : 'fff8e1' }}; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fa fa-pen-nib" style="color:#{{ $hasSignature ? '24695c' : 'b45309' }}; font-size:1.15rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div style="font-size:.72rem; text-transform:uppercase; letter-spacing:.06em; color:#6c757d; font-weight:600;">Firma digital</div>
                            @if($hasSignature)
                                <div class="d-flex align-items-center gap-3 mt-2 flex-wrap">
                                    <img src="{{ asset($userSignature->signature_url) }}?v={{ filemtime(public_path($userSignature->signature_url)) }}"
                                         class="firma-preview" alt="Mi firma"
                                         style="max-height:56px; max-width:160px;">
                                    @if($isSuperAdmin)
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#firmaModal">
                                        <i class="fa fa-edit me-1"></i> Editar firma
                                    </button>
                                    @endif
                                </div>
                            @else
                                <div class="text-muted mt-1" style="font-size:.83rem;">Necesitas registrar tu firma para crear solicitudes.</div>
                                <button type="button" class="btn btn-warning btn-sm fw-semibold mt-2 btn-pulse"
                                        data-bs-toggle="modal" data-bs-target="#firmaModal">
                                    <i class="fa fa-pen me-1"></i> Registrar firma
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ BALANCE POR PERÍODO ════════════════════════════════════════════ --}}
    @php
        $activePeriods = $vacationPeriods
            ->filter(fn($p) => !$p['is_not_yet_available'])
            ->sortBy('days_until_expiration')
            ->values();
        $hasAvailableDays = $activePeriods->contains(fn($p) => $p['available_days'] > 0);
    @endphp
    @if($activePeriods->isNotEmpty())
    <div class="row g-3 mb-4">
        @foreach($activePeriods as $period)
        @php
            if ($period['is_expired'])         { $cardClass = 'vac-danger';  $expBadge = 'danger';  $expIcon = 'fa-times-circle'; }
            elseif ($period['expires_soon'])   { $cardClass = 'vac-warning'; $expBadge = 'warning'; $expIcon = 'fa-exclamation-triangle'; }
            else                               { $cardClass = 'vac-success'; $expBadge = 'success'; $expIcon = 'fa-check-circle'; }
            $expDate = \Carbon\Carbon::parse($period['expiration_date'])->format('d/m/Y');
            $daysLeft = abs((int)$period['days_until_expiration']);
            $dStart   = \Carbon\Carbon::parse($period['date_start'])->format('d/m/Y');
            $dEnd     = \Carbon\Carbon::parse($period['date_end'])->format('d/m/Y');
            $endYear  = (int)\Carbon\Carbon::parse($period['date_end'])->format('Y');
            $periodLabel = $endYear . '-' . ($endYear + 1);
        @endphp
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm vac-period-card {{ $cardClass }}">
                <div class="card-body pb-2 pt-3 px-3">
                    {{-- Encabezado: período y vencimiento --}}
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="fw-bold" style="font-size:.95rem; color:#1b4c43;">Período {{ $periodLabel }}</div>
                            <div class="text-muted" style="font-size:.73rem;">{{ $dStart }} — {{ $dEnd }}</div>
                        </div>
                        <span class="badge bg-{{ $expBadge }} text-{{ $expBadge === 'warning' ? 'dark' : 'white' }} d-flex align-items-center gap-1" style="font-size:.72rem;">
                            <i class="fa {{ $expIcon }}"></i>
                            Vence {{ $expDate }}
                        </span>
                    </div>
                    {{-- Stats row --}}
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
                    {{-- Días restantes para vencer --}}
                    <div class="text-center mt-2 mb-1" style="font-size:.75rem; color:#6c757d;">
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
        <span class="text-muted">No tienes períodos de vacaciones activos en este momento.</span>
    </div>
    @endif

    {{-- Alertas de sesión de firma --}}
    @if(session('firma_guardada'))
        <div class="alert alert-success alert-dismissible fade show"><i class="fa fa-check-circle me-2"></i>{{ session('firma_guardada') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('firma_eliminada'))
        <div class="alert alert-warning alert-dismissible fade show"><i class="fa fa-exclamation-triangle me-2"></i>{{ session('firma_eliminada') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('firma_error'))
        <div class="alert alert-danger alert-dismissible fade show"><i class="fa fa-times-circle me-2"></i>{{ session('firma_error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- ═══ MÓDULO DE SOLICITUDES (original, intacto) ═══════════════════════ --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Mis Solicitudes de Vacaciones y Permisos</h5>
                        @if($hasSignature && ($hasAvailableDays || $canDelegate))
                            <a href="{{ route('vacaciones.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Nueva Solicitud
                            </a>
                        @elseif($hasSignature && !$hasAvailableDays && !$canDelegate)
                            <button type="button" class="btn btn-secondary" disabled
                                    data-bs-toggle="tooltip"
                                    title="No tienes días de vacaciones disponibles en este momento">
                                <i class="fa fa-lock me-1"></i> Nueva Solicitud
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary"
                                    data-bs-toggle="modal" data-bs-target="#firmaModal"
                                    title="Registra tu firma digital para crear solicitudes">
                                <i class="fa fa-lock me-1"></i> Nueva Solicitud
                            </button>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($hasSignature && !$hasAvailableDays && !$canDelegate)
                    <div class="alert alert-warning border mb-3 py-2">
                        <i class="fa fa-exclamation-triangle me-2"></i>
                        <strong>Sin días disponibles.</strong>
                        No cuentas con días de vacaciones disponibles en este momento.
                        @if($activePeriods->isEmpty() && isset($unlockInfo))
                            Tus vacaciones se desbloquearán el <strong>{{ $unlockInfo['unlock_date'] }}</strong> (faltan {{ $unlockInfo['days_remaining'] }} días).
                        @else
                            Contacta a Recursos Humanos para más información.
                        @endif
                    </div>
                    @endif

                    <!-- Balance de Vacaciones - Compacto -->
                    @if($activePeriods->contains(fn($p) => $p['available_days'] > 0))
                    <div class="alert alert-light border mb-3 py-2">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <strong>Balance de vacaciones:</strong>
                                <div class="mt-1">
                                    @foreach($activePeriods as $period)
                                        @if($period['available_days'] > 0)
                                            @php
                                                $daysText = $period['available_days'] === 1 ? 'día' : 'días';
                                                $dateStart = \Carbon\Carbon::parse($period['date_start'])->format('d/m/Y');
                                                $dateEnd   = \Carbon\Carbon::parse($period['date_end'])->format('d/m/Y');
                                                $endYr     = (int)\Carbon\Carbon::parse($period['date_end'])->format('Y');
                                                $periodLbl = $endYr . '-' . ($endYr + 1);
                                                $expirationDate = \Carbon\Carbon::parse($period['expiration_date'])->format('d/m/Y');
                                                $daysRemaining = abs($period['days_until_expiration']);
                                                if ($period['expires_soon']) {
                                                    $daysClass = 'text-warning fw-bold';
                                                    $expirationClass = 'text-warning fw-bold';
                                                } else {
                                                    $daysClass = 'text-success fw-bold';
                                                    $expirationClass = '';
                                                }
                                            @endphp
                                            <div class="mb-2">
                                                • Tienes
                                                <span class="{{ $daysClass }}" title="Exactos: {{ $period['available_days_exact'] }}">{{ $period['available_days'] }} {{ $daysText }}</span>
                                                del período <strong>{{ $periodLbl }}</strong>
                                                <span class="text-muted" style="font-size:.8rem;">({{ $dateStart }} al {{ $dateEnd }})</span>
                                                que vencen el <strong class="{{ $expirationClass }}">{{ $expirationDate }}</strong>
                                                <span class="{{ $expirationClass }}">(faltan {{ $daysRemaining }} días)</span>
                                                @if($period['expires_soon'])
                                                    <span class="badge bg-warning text-dark ms-2">
                                                        <i class="fa fa-exclamation-triangle"></i> ¡Vence pronto!
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                        <!-- Mensaje cuando no hay períodos disponibles -->
                        <div class="alert alert-info border mb-3 py-3">
                            <div class="d-flex align-items-start">
                                <i class="fa fa-info-circle fa-2x me-3 text-info"></i>
                                <div class="flex-grow-1">
                                    <strong>No tienes períodos de vacaciones disponibles actualmente</strong>
                                    @if(isset($unlockInfo))
                                        <div class="mt-2">
                                            <p class="mb-1">
                                                <i class="fa fa-calendar-alt"></i> 
                                                Fecha de ingreso: <strong>{{ $unlockInfo['admission_date'] }}</strong>
                                            </p>
                                            <p class="mb-0">
                                                <i class="fa fa-unlock-alt text-success"></i> 
                                                Tus vacaciones se desbloquearán el <strong class="text-success">{{ $unlockInfo['unlock_date'] }}</strong>
                                                <span class="badge bg-success ms-1">(faltan {{ $unlockInfo['days_remaining'] }} días)</span>
                                            </p>
                                            <small class="text-muted">
                                                Se requiere 1 año de antigüedad mínima para solicitar vacaciones.
                                            </small>
                                        </div>
                                    @else
                                        <p class="mt-2 mb-0 text-muted">
                                            Por favor, contacta con Recursos Humanos para verificar tu información de vacaciones.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Pestañas -->
                    <ul class="nav nav-tabs mb-3" id="vacationTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="my-requests-tab" data-bs-toggle="tab" data-bs-target="#my-requests" type="button" role="tab">
                                <i class="fas fa-user"></i> Mis Solicitudes
                                <span class="badge bg-primary ms-1">{{ $requests->count() }}</span>
                            </button>
                        </li>
                        @if(isset($canDelegate) && $canDelegate)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="behalf-requests-tab" data-bs-toggle="tab" data-bs-target="#behalf-requests" type="button" role="tab">
                                <i class="fas fa-user-friends"></i> Solicitudes en Representación
                                <span class="badge bg-info ms-1">{{ $behalfRequests->count() }}</span>
                            </button>
                        </li>
                        @endif
                    </ul>

                    <div class="tab-content" id="vacationTabsContent">
                        <!-- Pestaña de Mis Solicitudes -->
                        <div class="tab-pane fade show active" id="my-requests" role="tabpanel">
                            <!-- Lista de Solicitudes -->
                    @if($requests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha Solicitud</th>
                                        <th>Tipo</th>
                                        <th>Días Solicitados</th>
                                        <th>Período</th>
                                        <th>Días de Vacaciones</th>
                                        <th>Jefe Directo</th>
                                        <th>Dirección</th>
                                        <th>RH</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:15px;">
                                    @foreach($requests as $request)
                                    <tr>
                                        <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $request->type_request }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6">{{ $request->requestDays->count() }}</span>
                                        </td>
                                        <td>
                                            @php
                                                // Parsear opcion para obtener el período (formato: "11|2024-05-25")
                                                $periodNumber = null;
                                                if ($request->opcion) {
                                                    $parts = explode('|', $request->opcion);
                                                    $periodNumber = $parts[0] ?? null;
                                                }
                                            @endphp
                                            @if($periodNumber)
                                                <span class="badge bg-info">Período {{ $periodNumber }}</span>
                                            @else
                                                <span class="text-muted fst-italic">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->requestDays->count() > 0)
                                                <div style="max-width: 300px;">
                                                    @foreach($request->requestDays->sortBy('start')->take(5) as $day)
                                                        <span class="badge bg-light text-dark border me-1 mb-1">
                                                            {{ \Carbon\Carbon::parse($day->start)->format('d/m/Y') }}
                                                        </span>
                                                    @endforeach
                                                    @if($request->requestDays->count() > 5)
                                                        <span class="badge bg-secondary">+{{ $request->requestDays->count() - 5 }} más</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->direct_manager_status === 'Pendiente')
                                                <span class="badge bg-warning">Pendiente</span>
                                            @elseif($request->direct_manager_status === 'Aprobada')
                                                <span class="badge bg-success">Aprobada</span>
                                            @else
                                                <span class="badge bg-danger">Rechazada</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->direction_approbation_status === 'Pendiente')
                                                <span class="badge bg-warning">Pendiente</span>
                                            @elseif($request->direction_approbation_status === 'Aprobada')
                                                <span class="badge bg-success">Aprobada</span>
                                            @elseif($request->direction_approbation_status === 'Rechazada')
                                                <span class="badge bg-danger">Rechazada</span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->human_resources_status === 'Pendiente')
                                                <span class="badge bg-warning">Pendiente</span>
                                            @elseif($request->human_resources_status === 'Aprobada')
                                                <span class="badge bg-success">Aprobada</span>
                                            @elseif($request->human_resources_status === 'Rechazada')
                                                <span class="badge bg-danger">Rechazada</span>
                                            @elseif($request->human_resources_status === 'Cancelada')
                                                <span class="badge bg-secondary">Cancelada</span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $request->id }}">
                                                <i class="fas fa-eye"></i> Ver Detalles
                                            </button>
                                            @if($request->direct_manager_status === 'Pendiente'
                                                && $request->human_resources_status === 'Pendiente'
                                                && !in_array($request->direction_approbation_status, ['Aprobada', 'Rechazada']))
                                                <a href="{{ route('vacaciones.edit', $request->id) }}" class="btn btn-outline-warning btn-sm ms-1">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                            @endif
                                            @if($request->direct_manager_status === 'Pendiente'
                                                && $request->human_resources_status !== 'Cancelada')
                                                <button type="button" class="btn btn-outline-danger btn-sm ms-1"
                                                        data-bs-toggle="modal" data-bs-target="#cancelRequestModal"
                                                        data-request-id="{{ $request->id }}"
                                                        data-dias="{{ $request->requestDays->count() }}"
                                                        data-fecha="{{ $request->created_at->format('d/m/Y') }}"
                                                        title="Cancelar solicitud">
                                                    <i class="fas fa-ban"></i> Cancelar
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if($requests->hasPages())
                                <div class="mt-3">
                                    {{ $requests->links() }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            No tienes solicitudes de vacaciones registradas.
                            @if($hasSignature)
                                <a href="{{ route('vacaciones.create') }}" class="btn btn-primary btn-sm ms-2">
                                    Crear primera solicitud
                                </a>
                            @else
                                <button class="btn btn-secondary btn-sm ms-2" disabled
                                        data-bs-toggle="tooltip"
                                        title="Debes registrar tu firma digital antes de crear solicitudes">
                                    <i class="fa fa-lock me-1"></i> Crear primera solicitud
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pestaña de Solicitudes en Representación -->
            @if(isset($canDelegate) && $canDelegate)
            <div class="tab-pane fade" id="behalf-requests" role="tabpanel">
                @if($behalfRequests->count() > 0)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Solicitudes creadas por ti en representación de otros usuarios</strong>
                        <p class="mb-0 mt-2">Estas son las solicitudes que has creado para usuarios que no tienen acceso al sistema.</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-info">
                                <tr>
                                    <th>Usuario Representado</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Tipo</th>
                                    <th>Días Solicitados</th>
                                    <th>Período</th>
                                    <th>Días de Vacaciones</th>
                                    <th>Jefe Directo</th>
                                    <th>Dirección</th>
                                    <th>RH</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($behalfRequests as $request)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $request->user->first_name ?? 'N/A' }} {{ $request->user->last_name ?? '' }}</strong>
                                                @if($request->user->job)
                                                    <br><small class="text-muted">{{ $request->user->job->name ?? '' }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        {{ $request->type_request }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary fs-6">{{ $request->requestDays->count() }}</span>
                                    </td>
                                    <td>
                                        @php
                                            // Parsear opcion para obtener el período (formato: "11|2024-05-25")
                                            $periodNumber = null;
                                            if ($request->opcion) {
                                                $parts = explode('|', $request->opcion);
                                                $periodNumber = $parts[0] ?? null;
                                            }
                                        @endphp
                                        @if($periodNumber)
                                            <span class="badge bg-info">Período {{ $periodNumber }}</span>
                                        @else
                                            <span class="text-muted fst-italic">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->requestDays->count() > 0)
                                            <div style="max-width: 300px;">
                                                @foreach($request->requestDays->sortBy('start')->take(5) as $day)
                                                    <span class="badge bg-light text-dark border me-1 mb-1">
                                                        {{ \Carbon\Carbon::parse($day->start)->format('d/m/Y') }}
                                                    </span>
                                                @endforeach
                                                @if($request->requestDays->count() > 5)
                                                    <span class="badge bg-secondary">+{{ $request->requestDays->count() - 5 }} más</span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->direct_manager_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->direct_manager_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @else
                                            <span class="badge bg-danger">Rechazada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->direction_approbation_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->direction_approbation_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @elseif($request->direction_approbation_status === 'Rechazada')
                                            <span class="badge bg-danger">Rechazada</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->human_resources_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->human_resources_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @elseif($request->human_resources_status === 'Rechazada')
                                            <span class="badge bg-danger">Rechazada</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailBehalfModal{{ $request->id }}">
                                            Ver Detalles
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if($behalfRequests->hasPages())
                            <div class="mt-3">
                                {{ $behalfRequests->links() }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        No has creado solicitudes en representación de otros usuarios.
                    </div>
                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ═══ MODAL CANCELAR SOLICITUD (propia) ═══════════════════════════════ --}}
    <div class="modal fade" id="cancelRequestModal" tabindex="-1" aria-labelledby="cancelRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white border-0 shadow">
                <div class="modal-header border-0 pb-0" style="background:#fff5f5;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:38px;height:38px;border-radius:.4rem;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                            <i class="fa fa-exclamation-triangle text-danger"></i>
                        </div>
                        <h5 class="modal-title mb-0 fw-bold" id="cancelRequestModalLabel" style="color:#991b1b;font-size:1rem;">
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
                            <span class="fw-semibold" id="cancelReqFecha">—</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Días a liberar:</span>
                            <span class="fw-semibold text-success" id="cancelReqDias">—</span>
                        </div>
                    </div>
                    <div class="alert alert-warning py-2 mb-0" style="font-size:.82rem;">
                        <i class="fa fa-info-circle me-1"></i>
                        Solo puedes cancelar mientras tu jefe directo no la haya revisado. La solicitud quedará <strong>Cancelada</strong> y los días reservados volverán al saldo del período.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        No cancelar
                    </button>
                    <form id="cancelRequestForm" method="POST">
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

    <!-- Modales para Mis Solicitudes -->
    @foreach($requests as $request)
        <div class="modal fade" id="detailModal{{ $request->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle"></i> 
                            Detalle de Mi Solicitud
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body bg-white">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-file-alt text-warning"></i> Detalles de la Solicitud</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Tipo:</strong> {{ $request->type_request }}</li>
                                    <li><strong>Fecha Solicitud:</strong> {{ $request->created_at->format('d-m-Y H:i') }}</li>
                                    @if($request->opcion)
                                        @php
                                            $modalPeriodNum = explode('|', $request->opcion)[0] ?? null;
                                            $modalPeriodLabel = null;
                                            if ($modalPeriodNum && isset($allPeriodsMap[$modalPeriodNum])) {
                                                $modalEndYear = \Carbon\Carbon::parse($allPeriodsMap[$modalPeriodNum]->date_end)->year;
                                                $modalPeriodLabel = $modalEndYear . '-' . ($modalEndYear + 1);
                                            }
                                        @endphp
                                        <li><strong>Período:</strong>
                                            <span class="badge bg-secondary">{{ $modalPeriodLabel ?? 'Período ' . $modalPeriodNum }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-clipboard-check text-success"></i> Estados de Aprobación</h6>
                                <ul class="list-unstyled">
                                    <li>
                                        <strong>Jefe Directo:</strong> 
                                        @if($request->direct_manager_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->direct_manager_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @else
                                            <span class="badge bg-danger">Rechazada</span>
                                        @endif
                                    </li>
                                    <li>
                                        <strong>Dirección:</strong>
                                        @if($request->direction_approbation_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->direction_approbation_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @elseif($request->direction_approbation_status === 'Rechazada')
                                            <span class="badge bg-danger">Rechazada</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </li>
                                    <li>
                                        <strong>Recursos Humanos:</strong>
                                        @if($request->human_resources_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->human_resources_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @elseif($request->human_resources_status === 'Rechazada')
                                            <span class="badge bg-danger">Rechazada</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <hr>

                        <h6><i class="fas fa-calendar-days text-success"></i> Días Solicitados ({{ $request->requestDays->count() }} días)</h6>
                        <div class="row">
                            @foreach($request->requestDays->sortBy('start') as $day)
                                <div class="col-md-3 col-sm-4 col-6 mb-2">
                                    <div class="card border-primary">
                                        <div class="card-body text-center p-2">
                                            <h6 class="card-title mb-1">
                                                {{ \Carbon\Carbon::parse($day->start)->format('d') }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($day->start)->format('M Y') }}
                                            </small>
                                            <br>
                                            <small class="text-primary">
                                                {{ \Carbon\Carbon::parse($day->start)->locale('es')->dayName }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($request->reason)
                            <hr>
                            <h6><i class="fas fa-comment text-warning"></i> Motivo de la Solicitud</h6>
                            <div class="alert alert-light">
                                {{ $request->reason }}
                            </div>
                        @endif

                        @if($request->reveal)
                            <h6><i class="fas fa-user-shield text-secondary"></i> Responsable durante la Ausencia</h6>
                            <p>{{ $request->reveal->first_name ?? 'N/A' }} {{ $request->reveal->last_name ?? '' }}</p>
                        @endif
                    </div>
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modales para Solicitudes en Representación -->
    @if(isset($canDelegate) && $canDelegate)
    @foreach($behalfRequests as $request)
        <div class="modal fade" id="detailBehalfModal{{ $request->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle"></i> 
                            Detalle de Solicitud en Representación - {{ $request->user->first_name ?? '' }} {{ $request->user->last_name ?? '' }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body bg-white">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Solicitud creada en representación</strong>
                            <p class="mb-0 mt-2">Has creado esta solicitud para <strong>{{ $request->user->first_name ?? '' }} {{ $request->user->last_name ?? '' }}</strong></p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-user text-primary"></i> Información del Empleado Representado</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Nombre:</strong> {{ $request->user->first_name ?? 'N/A' }} {{ $request->user->last_name ?? '' }}</li>
                                    <li><strong>Email:</strong> {{ $request->user->email ?? 'N/A' }}</li>
                                    @if($request->user->job ?? false)
                                        <li><strong>Puesto:</strong> {{ $request->user->job->name ?? 'N/A' }}</li>
                                        <li><strong>Departamento:</strong> {{ $request->user->job->departamento->name ?? 'N/A' }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-file-alt text-warning"></i> Detalles de la Solicitud</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Tipo:</strong> {{ $request->type_request }}</li>
                                    <li><strong>Fecha Solicitud:</strong> {{ $request->created_at->format('d-m-Y H:i') }}</li>
                                    <li><strong>Forma de Pago:</strong> {{ $request->payment }}</li>
                                    <li><strong>Creada por:</strong> Tú</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6><i class="fas fa-clipboard-check text-success"></i> Estados de Aprobación</h6>
                                <ul class="list-unstyled">
                                    <li>
                                        <strong>Jefe Directo:</strong> 
                                        @if($request->direct_manager_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->direct_manager_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @else
                                            <span class="badge bg-danger">Rechazada</span>
                                        @endif
                                    </li>
                                    <li>
                                        <strong>Dirección:</strong>
                                        @if($request->direction_approbation_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->direction_approbation_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @elseif($request->direction_approbation_status === 'Rechazada')
                                            <span class="badge bg-danger">Rechazada</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </li>
                                    <li>
                                        <strong>Recursos Humanos:</strong>
                                        @if($request->human_resources_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->human_resources_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @elseif($request->human_resources_status === 'Rechazada')
                                            <span class="badge bg-danger">Rechazada</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <hr>

                        <h6><i class="fas fa-calendar-days text-success"></i> Días Solicitados ({{ $request->requestDays->count() }} días)</h6>
                        <div class="row">
                            @foreach($request->requestDays->sortBy('start') as $day)
                                <div class="col-md-3 col-sm-4 col-6 mb-2">
                                    <div class="card border-info">
                                        <div class="card-body text-center p-2">
                                            <h6 class="card-title mb-1">
                                                {{ \Carbon\Carbon::parse($day->start)->format('d') }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($day->start)->format('M Y') }}
                                            </small>
                                            <br>
                                            <small class="text-info">
                                                {{ \Carbon\Carbon::parse($day->start)->locale('es')->dayName }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($request->reason)
                            <hr>
                            <h6><i class="fas fa-comment text-warning"></i> Motivo de la Solicitud</h6>
                            <div class="alert alert-light">
                                {{ $request->reason }}
                            </div>
                        @endif

                        @if($request->reveal)
                            <h6><i class="fas fa-user-shield text-secondary"></i> Responsable durante la Ausencia</h6>
                            <p>{{ $request->reveal->first_name ?? 'N/A' }} {{ $request->reveal->last_name ?? '' }}</p>
                        @endif
                    </div>
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endif
</div>{{-- /row --}}


</div>{{-- /container-fluid --}}

{{-- ═══ MODAL TÉRMINOS Y CONDICIONES ══════════════════════════════════════ --}}
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content bg-white">

            <div class="modal-header border-0 pb-2" style="background:#f8fafc;">
                <div>
                    <h5 class="modal-title fw-bold mb-0" id="termsModalLabel" style="color:#111827;">
                        <i class="fa fa-question-circle me-2 text-primary"></i>Ayuda
                    </h5>
                    <p class="mb-0 text-muted" style="font-size:.75rem;">
                        Sistema de Gestión de Vacaciones &nbsp;·&nbsp; Actualización: Abril 2026
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Cuerpo con scroll fijo --}}
            <div class="modal-body px-4 py-3" style="font-size:.875rem;color:#374151;line-height:1.75;max-height:60vh;overflow-y:auto;" id="termsScrollBody">

                {{-- ── Artículos del Reglamento Interno ── --}}
                <div class="terms-section mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill bg-primary" style="font-size:.7rem;">1</span>
                        <h6 class="mb-0 fw-bold" style="color:#1e3a5f;">Asignación y vigencia de días de vacaciones <span class="text-muted fw-normal" style="font-size:.78rem;">(Art. 71 Reglamento Interno)</span></h6>
                    </div>
                    <div class="ps-4">
                        <p class="mb-2">
                            Los trabajadores que tengan más de un año de servicio disfrutarán de un periodo anual de vacaciones,
                            que en ningún caso podrá ser menor a 12 días y aumentarán dos días hasta llegar a veinte.
                            Después del sexto año, el periodo vacacional aumentará en dos días por cada cinco años de servicio,
                            esto estipulado en la Ley vigente:
                        </p>
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-bordered text-center mb-0" style="font-size:.8rem;max-width:320px;">
                                <thead style="background:#1e3a5f;color:#fff;">
                                    <tr>
                                        <th class="py-1 px-3">Años de servicio</th>
                                        <th class="py-1 px-3">Días de vacaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td><strong>12</strong></td></tr>
                                    <tr><td>2</td><td><strong>14</strong></td></tr>
                                    <tr><td>3</td><td><strong>16</strong></td></tr>
                                    <tr><td>4</td><td><strong>18</strong></td></tr>
                                    <tr><td>5</td><td><strong>20</strong></td></tr>
                                    <tr><td>6 a 10</td><td><strong>22</strong></td></tr>
                                    <tr><td>11 a 15</td><td><strong>24</strong></td></tr>
                                    <tr><td>16 a 20</td><td><strong>26</strong></td></tr>
                                    <tr><td>21 a 25</td><td><strong>28</strong></td></tr>
                                    <tr><td>26 a 30</td><td><strong>30</strong></td></tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="mb-1">
                            La prima vacacional será calculada de acuerdo a los días autorizados en la tabla antes mencionada.
                        </p>
                        <p class="mb-0 text-muted" style="font-size:.82rem;">
                            Cada período tiene una vigencia de <strong>15 meses</strong> a partir de la fecha de término; los días no ejercidos
                            dentro de ese plazo <strong>caducan automáticamente</strong> y no son recuperables.
                        </p>
                    </div>
                </div>

                <div class="terms-section mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill" style="font-size:.7rem;background:#0891b2;">2</span>
                        <h6 class="mb-0 fw-bold" style="color:#1e3a5f;">Fraccionamiento del período vacacional <span class="text-muted fw-normal" style="font-size:.78rem;">(Art. 72 Reglamento Interno)</span></h6>
                    </div>
                    <p class="mb-0 ps-4">
                        De acuerdo con la naturaleza de las funciones que se desarrollan en GPT Services®, los trabajadores
                        podrán, con previa autorización del jefe inmediato, proceder al fraccionamiento del descanso vacacional,
                        lo cual deberá ser comunicado a Recursos Humanos con cinco días de anterioridad
                        a la fecha de programación.
                    </p>
                </div>

                <div class="terms-section mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill" style="font-size:.7rem;background:#dc2626;">3</span>
                        <h6 class="mb-0 fw-bold" style="color:#1e3a5f;">Responsabilidad de jefaturas <span class="text-muted fw-normal" style="font-size:.78rem;">(Art. 73 Reglamento Interno)</span></h6>
                    </div>
                    <p class="mb-0 ps-4">
                        Las jefaturas inmediatas tendrán la responsabilidad de que el personal a su cargo haga uso efectivo
                        de su descanso físico vacacional dentro del año correspondiente más un periodo de gracia de tres meses.
                        En caso contrario, la jefatura será sancionada de acuerdo con lo estipulado en el presente Reglamento Interno de Trabajo.
                    </p>
                </div>

                {{-- ── Normativas del sistema ── --}}
                <div class="terms-section mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill bg-success" style="font-size:.7rem;">4</span>
                        <h6 class="mb-0 fw-bold" style="color:#1e3a5f;">Flujo de aprobación</h6>
                    </div>
                    <div class="ps-4">
                        <p class="mb-2">Las solicitudes pasan por tres instancias en orden:</p>
                        <div class="d-flex flex-column gap-1 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark border" style="min-width:22px;">1</span>
                                <span><strong>Jefe directo</strong> — primera instancia de aprobación.</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark border" style="min-width:22px;">2</span>
                                <span><strong>Dirección</strong> — valida impacto operacional del área.</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark border" style="min-width:22px;">3</span>
                                <span><strong>Recursos Humanos</strong> — confirma saldo y genera documento oficial.</span>
                            </div>
                        </div>
                        <p class="mb-0 text-muted" style="font-size:.82rem;">
                            Un rechazo en cualquier instancia cancela la solicitud y libera los días reservados.
                        </p>
                    </div>
                </div>

                <div class="terms-section mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill bg-secondary" style="font-size:.7rem;">5</span>
                        <h6 class="mb-0 fw-bold" style="color:#1e3a5f;">Firma digital</h6>
                    </div>
                    <p class="mb-0 ps-4">
                        Es obligatorio registrar la <strong>firma digital</strong> antes de crear solicitudes. La firma constituye
                        un consentimiento informado y aparece en el documento PDF oficial. Puede actualizarse en cualquier momento;
                        eliminarla suspende la creación de nuevas solicitudes hasta registrar una nueva.
                    </p>
                </div>

                <div class="terms-section mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill bg-dark" style="font-size:.7rem;">6</span>
                        <h6 class="mb-0 fw-bold" style="color:#1e3a5f;">Responsabilidad de Recursos Humanos</h6>
                    </div>
                    <ul class="mb-0 ps-4" style="line-height:1.9;">
                        <li>Verificar que los períodos y saldos asignados correspondan a la antigüedad de cada colaborador.</li>
                        <li>Revisar las solicitudes y emitir aprobación u observaciones dentro del plazo establecido.</li>
                        <li>Gestionar la correcta habilitación de accesos y permisos en el sistema vacacional.</li>
                    </ul>
                </div>

                <div class="terms-section mb-2">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill bg-info" style="font-size:.7rem;">7</span>
                        <h6 class="mb-0 fw-bold" style="color:#1e3a5f;">Tratamiento de datos personales</h6>
                    </div>
                    <p class="mb-0 ps-4">
                        La información registrada (nombre, firma digital, fechas) es de uso <strong>exclusivamente interno</strong>.
                        Los datos se almacenan de forma segura y no se comparten con terceros. Para corrección o eliminación
                        de datos, contacta a Recursos Humanos o el equipo de TI.
                    </p>
                </div>

            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 pt-0" style="background:#f8fafc;">
                @if(!$hasAcceptedTerms)
                <form action="{{ route('vacaciones.terms.accept') }}" method="POST" id="termsForm" class="w-100">
                    @csrf
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                        <div class="form-check d-flex align-items-center gap-2 mb-0">
                            <input class="form-check-input" type="checkbox" id="termsCheck"
                                   style="width:1.1rem;height:1.1rem;margin-top:0;cursor:pointer;">
                            <label class="form-check-label" for="termsCheck"
                                   style="font-size:.84rem;cursor:pointer;color:#374151;">
                                He leído y acepto la ayuda
                            </label>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary btn-sm fw-semibold" id="acceptTermsBtn" disabled>
                                <i class="fa fa-check me-1"></i> Aceptar
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <div class="d-flex align-items-center justify-content-between w-100 flex-wrap gap-2">
                    <span class="text-success" style="font-size:.84rem;">
                        <i class="fa fa-check-circle me-1"></i>
                        Aceptados el <strong>{{ $termsAcceptedAt->format('d/m/Y') }}</strong> a las {{ $termsAcceptedAt->format('H:i') }}
                    </span>
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- ═══ MODAL FIRMA DIGITAL ════════════════════════════════════════════════ --}}
<div class="modal fade" id="firmaModal" tabindex="-1" aria-labelledby="firmaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-white">
            <div class="modal-header" style="background:linear-gradient(135deg,#18181b,#27272a); color:#fff;">
                <h5 class="modal-title" id="firmaModalLabel">
                    <i class="fa fa-pen-nib me-2"></i>
                    {{ $hasSignature ? 'Actualizar firma digital' : 'Registrar firma digital' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3" style="font-size:.88rem;">
                    Dibuja tu firma con el ratón o con tu dedo en la pantalla táctil.
                    Esta firma aparecerá en los documentos de solicitud de vacaciones.
                </p>

                {{-- Canvas --}}
                <div class="position-relative mb-2">
                    <canvas id="signature-canvas"></canvas>
                    <small class="text-muted position-absolute" style="bottom:8px; right:12px; pointer-events:none; opacity:.4; font-size:.72rem;">
                        Dibuja aquí
                    </small>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="clearSignatureBtn">
                            <i class="fa fa-eraser me-1"></i> Limpiar
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm ms-1" id="undoSignatureBtn">
                            <i class="fa fa-undo me-1"></i> Deshacer
                        </button>
                    </div>
                    <small class="text-muted" style="font-size:.78rem;">Usa lápiz negro sobre fondo blanco</small>
                </div>

                <form id="firmaForm" action="{{ route('perfil.firma.store') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="signature" id="signatureData">
                    <div class="d-flex gap-2 justify-content-end flex-wrap">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        @if($hasSignature)
                        <button type="button" class="btn btn-outline-danger"
                                onclick="if(confirm('¿Eliminar tu firma? No podrás crear solicitudes hasta registrar una nueva.')) document.getElementById('deleteSignatureForm').submit()">
                            <i class="fa fa-trash me-1"></i> Eliminar firma
                        </button>
                        @endif
                        <button type="submit" class="btn btn-success fw-semibold" id="saveSignatureBtn">
                            <i class="fa fa-save me-1"></i> Guardar firma
                        </button>
                    </div>
                </form>
                @if($hasSignature)
                <form id="deleteSignatureForm" action="{{ route('perfil.firma.destroy') }}" method="POST" class="d-none">
                    @csrf @method('DELETE')
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
{{-- Signature Pad — librería ligera (~10KB) específica para firmas digitales --}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
(function () {
    const canvas   = document.getElementById('signature-canvas');
    const form     = document.getElementById('firmaForm');
    const dataInput = document.getElementById('signatureData');

    if (!canvas) return;

    // Ajustar resolución al DPI real del dispositivo
    function resizeCanvas() {
        const ratio  = Math.max(window.devicePixelRatio || 1, 1);
        const rect   = canvas.getBoundingClientRect();
        canvas.width  = rect.width  * ratio;
        canvas.height = rect.height * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
    }

    window.addEventListener('resize', function() {
        // Al redimensionar se pierde el trazo — avisar al usuario
        if (!signaturePad.isEmpty()) {
            signaturePad.clear();
        }
        resizeCanvas();
    });

    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgba(255,255,255,1)',
        penColor: '#1a1a1a',
        minWidth: 1,
        maxWidth: 3,
    });

    // Inicializar tamaño cuando el modal es visible
    document.getElementById('firmaModal').addEventListener('shown.bs.modal', function () {
        resizeCanvas();
        signaturePad.clear();
    });

    document.getElementById('clearSignatureBtn').addEventListener('click', function () {
        signaturePad.clear();
    });

    document.getElementById('undoSignatureBtn').addEventListener('click', function () {
        const data = signaturePad.toData();
        if (data.length > 0) {
            data.pop();
            signaturePad.fromData(data);
        }
    });

    form.addEventListener('submit', function (e) {
        if (signaturePad.isEmpty()) {
            e.preventDefault();
            alert('Por favor dibuja tu firma antes de guardar.');
            return;
        }
        dataInput.value = signaturePad.toDataURL('image/png');
    });

    // Tooltips de Bootstrap
    const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipEls.forEach(el => new bootstrap.Tooltip(el));
})();

// Términos — habilitar botón al marcar checkbox
(function () {
    const check = document.getElementById('termsCheck');
    const btn   = document.getElementById('acceptTermsBtn');
    if (check && btn) {
        check.addEventListener('change', () => { btn.disabled = !check.checked; });
    }
})();

// Cancelar solicitud propia — configurar el action del formulario
(function () {
    const cancelModal = document.getElementById('cancelRequestModal');
    if (!cancelModal) return;

    cancelModal.addEventListener('show.bs.modal', function (e) {
        const btn       = e.relatedTarget;
        const requestId = btn.dataset.requestId;
        const dias      = btn.dataset.dias;
        const fecha     = btn.dataset.fecha;

        document.getElementById('cancelReqFecha').textContent = fecha;
        document.getElementById('cancelReqDias').textContent  = dias + (dias == 1 ? ' día' : ' días');

        document.getElementById('cancelRequestForm').action = `/vacaciones/cancelar/${requestId}`;
    });
})();
</script>
@endpush

@endsection