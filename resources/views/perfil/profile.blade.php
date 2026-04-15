@extends('layouts.codebase.master')

@push('css')
<style>
    /* ── Banner & Avatar ─────────────────────────────────── */
    .profile-banner {
        height: 220px;
        background: linear-gradient(135deg, #1b4c43 0%, #24695c 50%, #2d8a75 100%);
        position: relative;
        border-radius: .5rem .5rem 0 0;
        overflow: hidden; /* keeps the pattern clipped */
    }

    .profile-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 20% 50%, rgba(255,255,255,.06) 0%, transparent 60%),
            radial-gradient(circle at 80% 20%, rgba(255,255,255,.04) 0%, transparent 50%);
    }

    /* Subtle hexagonal grid pattern */
    .profile-banner::after {
        content: '';
        position: absolute;
        inset: 0;
        opacity: .08;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='52'%3E%3Cpolygon points='30,2 58,16 58,36 30,50 2,36 2,16' fill='none' stroke='white' stroke-width='1'/%3E%3C/svg%3E");
        background-size: 60px 52px;
    }

    /* Avatar sits on top of the banner edge — positioned
       relative to .profile-card, NOT the banner, so it
       never gets clipped by overflow:hidden on the banner */
    .profile-card {
        position: relative; /* anchor for avatar-wrap */
    }

    .profile-avatar-wrap {
        position: absolute;
        /* banner is 220px tall; avatar is 104px → center halfway over edge */
        top: calc(220px - 52px);
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
    }

    .profile-avatar-wrap img,
    .profile-avatar-wrap .profile-avatar-placeholder {
        width: 104px;
        height: 104px;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,.18);
        object-fit: cover;
        background: #e8f4f1;
    }

    .profile-avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #24695c;
        font-weight: 700;
    }

    .profile-card {
        border: none;
        box-shadow: 0 2px 16px rgba(0,0,0,.08);
        border-radius: .5rem;
    }

    /* ── Info labels ─────────────────────────────────────── */
    .info-label {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #6c757d;
        margin-bottom: .15rem;
    }

    .info-value {
        font-size: .92rem;
        color: #2d3748;
        font-weight: 500;
    }

    .info-row {
        padding: .65rem 0;
        border-bottom: 1px solid #f1f5f4;
    }

    .info-row:last-child { border-bottom: none; }

    /* ── Vacation stat cards ─────────────────────────────── */
    .vac-stat {
        border-radius: .5rem;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .vac-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: .4rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .vac-stat-value {
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1;
    }

    .vac-stat-label {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        opacity: .75;
        margin-top: .15rem;
    }

    /* ── Section headings ────────────────────────────────── */
    .section-title {
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #24695c;
        border-left: 3px solid #24695c;
        padding-left: .6rem;
        margin-bottom: 1rem;
    }

    /* ── Status badges ───────────────────────────────────── */
    .badge-pendiente   { background: #fff3cd; color: #856404; }
    .badge-aprobada    { background: #d1e7dd; color: #0f5132; }
    .badge-rechazada   { background: #f8d7da; color: #842029; }
    .badge-en-revision { background: #cfe2ff; color: #084298; }

    /* ── Boss card ───────────────────────────────────────── */
    .boss-card {
        border: 1.5px solid #e3eeec;
        border-radius: .5rem;
        padding: .85rem 1rem;
        display: flex;
        align-items: center;
        gap: .85rem;
        background: #f8fdfc;
    }

    .boss-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #24695c33;
        background: #e8f4f1;
        flex-shrink: 0;
    }

    .boss-avatar-placeholder {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #24695c22;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #24695c;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* ── Period row ──────────────────────────────────────── */
    .period-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .72rem;
        font-weight: 600;
        padding: .2rem .55rem;
        border-radius: 99px;
    }

    .period-badge.actual   { background: #d1e7dd; color: #0f5132; }
    .period-badge.vencido  { background: #f8d7da; color: #842029; }

    /* ── Requests table ──────────────────────────────────── */
    .req-table th {
        background: #f8fdfc;
        color: #24695c;
        font-size: .73rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-top: none;
        padding: .6rem .85rem;
    }

    .req-table td {
        font-size: .88rem;
        vertical-align: middle;
        padding: .65rem .85rem;
    }

    /* ── Avatar edit button ─────────────────────────────── */
    .avatar-edit-btn {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #24695c;
        border: 2px solid #fff;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .7rem;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,.25);
        transition: background .2s;
        z-index: 20;
    }

    .avatar-edit-btn:hover { background: #1b4c43; }

    .profile-avatar-outer {
        position: relative;
        display: inline-block;
    }

    /* ── Upload feedback ─────────────────────────────────── */
    .foto-uploading {
        opacity: .5;
        pointer-events: none;
    }

    @media (max-width: 991px) {
        .profile-banner { height: 160px; }
        .profile-avatar-wrap {
            top: calc(160px - 45px); /* 160 - half of 90 */
        }
        .profile-avatar-wrap img,
        .profile-avatar-wrap .profile-avatar-placeholder {
            width: 90px; height: 90px;
        }
    }
</style>
@endpush

@section('content')

@if(session('foto_actualizada'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
    <i class="fa fa-check-circle fs-5"></i>
    <span>Foto de perfil actualizada correctamente.</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif

@if($errors->has('foto'))
<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
    <i class="fa fa-exclamation-circle fs-5"></i>
    <span>{{ $errors->first('foto') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif

{{-- ═══ PROFILE HEADER ════════════════════════════════════════════════════ --}}
<div class="profile-card card mb-4">

    {{-- Banner (overflow:hidden here only affects the decorative pattern, not the avatar) --}}
    <div class="profile-banner"></div>

    {{-- Avatar: outside the banner div so overflow:hidden never clips it --}}
    <div class="profile-avatar-wrap">

        {{-- Formulario invisible para subir foto --}}
        <form id="fotoForm" action="{{ route('perfil.foto') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" id="fotoInput" name="foto" accept="image/jpeg,image/png,image/webp"
                class="d-none" onchange="submitFotoForm()">
        </form>

        <div class="profile-avatar-outer">
            @if($user->profile_image)
                <img id="avatarImg" src="{{ $user->profile_image }}" alt="{{ $user->first_name }}">
            @else
                <div class="profile-avatar-placeholder">
                    {{ strtoupper(substr($user->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}
                </div>
            @endif

            {{-- Botón de edición --}}
            <button type="button" class="avatar-edit-btn" onclick="document.getElementById('fotoInput').click()"
                title="Cambiar foto de perfil">
                <i class="fa fa-camera"></i>
            </button>
        </div>
    </div>

    {{-- Nombre y cargo --}}
    <div class="card-body text-center pt-5 pb-4">
        <h4 class="mb-1 fw-bold text-dark">
            {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'Sin nombre' }}
        </h4>
        <p class="mb-1 text-muted" style="font-size:.93rem;">
            {{ $user->job?->name ?? 'Sin puesto asignado' }}
        </p>
        <span class="badge bg-light text-secondary border" style="font-size:.75rem;">
            {{ $user->job?->departamento?->name ?? 'Sin departamento' }}
        </span>
        @if($user->razonSocial)
            <span class="ms-1 badge bg-light text-secondary border" style="font-size:.75rem;">
                {{ $user->razonSocial->name ?? '' }}
            </span>
        @endif
    </div>
</div>

{{-- ═══ STATS DE VACACIONES ════════════════════════════════════════════════ --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="vac-stat card" style="background:#eaf7f4; color:#1b4c43;">
            <div class="vac-stat-icon" style="background:#24695c22;">
                <i class="fa fa-calendar-alt" style="color:#24695c;"></i>
            </div>
            <div>
                <div class="vac-stat-value">{{ number_format($totalAvailable, 0) }}</div>
                <div class="vac-stat-label">Días totales</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="vac-stat card" style="background:#fff8ec; color:#6a3d00;">
            <div class="vac-stat-icon" style="background:#ba895d22;">
                <i class="fa fa-umbrella-beach" style="color:#ba895d;"></i>
            </div>
            <div>
                <div class="vac-stat-value">{{ number_format($totalEnjoyed, 0) }}</div>
                <div class="vac-stat-label">Días disfrutados</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="vac-stat card" style="background:#fff0f0; color:#6b1e1e;">
            <div class="vac-stat-icon" style="background:#c0392b22;">
                <i class="fa fa-clock" style="color:#c0392b;"></i>
            </div>
            <div>
                <div class="vac-stat-value">{{ number_format($totalReserved, 0) }}</div>
                <div class="vac-stat-label">Días reservados</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="vac-stat card" style="background:#edf3ff; color:#1a3a8a;">
            <div class="vac-stat-icon" style="background:#2980b922;">
                <i class="fa fa-check-circle" style="color:#2980b9;"></i>
            </div>
            <div>
                <div class="vac-stat-value">{{ number_format($totalRemaining, 0) }}</div>
                <div class="vac-stat-label">Días disponibles</div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ DOS COLUMNAS ════════════════════════════════════════════════════════ --}}
<div class="row g-4">

    {{-- ── COLUMNA IZQUIERDA ─────────────────────────────────────────── --}}
    <div class="col-lg-5">

        {{-- Información general --}}
        <div class="profile-card card mb-4">
            <div class="card-body">
                <div class="section-title mb-3">Información general</div>

                <div class="info-row">
                    <div class="info-label"><i class="fa fa-user me-1"></i> Nombre completo</div>
                    <div class="info-value">
                        {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: '—' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label"><i class="fa fa-envelope me-1"></i> Correo electrónico</div>
                    <div class="info-value">{{ $user->email ?? '—' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label"><i class="fa fa-phone me-1"></i> Teléfono</div>
                    <div class="info-value">{{ $user->phone ?? $user->personalData?->personal_phone ?? '—' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label"><i class="fa fa-calendar me-1"></i> Fecha de ingreso</div>
                    <div class="info-value">
                        @if($user->admission)
                            {{ \Carbon\Carbon::parse($user->admission)->isoFormat('D [de] MMMM [de] YYYY') }}
                            <small class="text-muted ms-1">
                                ({{ \Carbon\Carbon::parse($user->admission)->diffForHumans() }})
                            </small>
                        @else
                            —
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label"><i class="fa fa-building me-1"></i> Empresa</div>
                    <div class="info-value">{{ $user->razonSocial?->name ?? '—' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label"><i class="fa fa-briefcase me-1"></i> Departamento</div>
                    <div class="info-value">{{ $user->job?->departamento?->name ?? '—' }}</div>
                </div>

                @if($user->personalData?->birthday)
                <div class="info-row">
                    <div class="info-label"><i class="fa fa-birthday-cake me-1"></i> Fecha de nacimiento</div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($user->personalData->birthday)->isoFormat('D [de] MMMM [de] YYYY') }}
                    </div>
                </div>
                @endif

                @if($user->personalData?->estado_civil)
                <div class="info-row">
                    <div class="info-label"><i class="fa fa-heart me-1"></i> Estado civil</div>
                    <div class="info-value">
                        @php
                            $ec = $user->personalData->estado_civil;
                            echo is_array($ec) ? ($ec['nombre'] ?? implode(', ', $ec)) : $ec;
                        @endphp
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- Jefe inmediato --}}
        <div class="profile-card card mb-4">
            <div class="card-body">
                <div class="section-title mb-3">Jefe inmediato</div>
                @if($user->jefe)
                    <div class="boss-card">
                        @if($user->jefe->profile_image)
                            <img src="{{ $user->jefe->profile_image }}" class="boss-avatar" alt="{{ $user->jefe->first_name }}">
                        @else
                            <div class="boss-avatar-placeholder">
                                {{ strtoupper(substr($user->jefe->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr($user->jefe->last_name ?? '', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="fw-semibold" style="font-size:.93rem; color:#1b4c43;">
                                {{ trim(($user->jefe->first_name ?? '') . ' ' . ($user->jefe->last_name ?? '')) ?: 'Sin nombre' }}
                            </div>
                            <div class="text-muted" style="font-size:.8rem;">
                                {{ $user->jefe->job?->name ?? 'Sin puesto asignado' }}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-muted mb-0" style="font-size:.88rem;">
                        <i class="fa fa-info-circle me-1"></i> Sin jefe inmediato asignado
                    </p>
                @endif
            </div>
        </div>

    </div>

    {{-- ── COLUMNA DERECHA ───────────────────────────────────────────── --}}
    <div class="col-lg-7">

        {{-- Períodos de vacaciones --}}
        <div class="profile-card card mb-4">
            <div class="card-body">
                <div class="section-title mb-3">Períodos de vacaciones</div>

                @if($vacationPeriods->isEmpty())
                    <p class="text-muted mb-0" style="font-size:.88rem;">
                        <i class="fa fa-info-circle me-1"></i> Sin períodos registrados
                    </p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="font-size:.72rem; color:#6c757d; text-transform:uppercase;">Período</th>
                                    <th class="text-center" style="font-size:.72rem; color:#6c757d; text-transform:uppercase;">Disponibles</th>
                                    <th class="text-center" style="font-size:.72rem; color:#6c757d; text-transform:uppercase;">Disfrutados</th>
                                    <th class="text-center" style="font-size:.72rem; color:#6c757d; text-transform:uppercase;">Reservados</th>
                                    <th class="text-center" style="font-size:.72rem; color:#6c757d; text-transform:uppercase;">Restantes</th>
                                    <th class="text-center" style="font-size:.72rem; color:#6c757d; text-transform:uppercase;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vacationPeriods as $vp)
                                @php
                                    $remaining = max(0, ($vp->days_availables ?? 0) - ($vp->days_enjoyed ?? 0) - ($vp->days_reserved ?? 0));
                                @endphp
                                <tr>
                                    <td>
                                        <span class="fw-semibold" style="color:#24695c;">{{ $vp->period }}</span>
                                        @if($vp->date_start && $vp->date_end)
                                            <div class="text-muted" style="font-size:.72rem;">
                                                {{ \Carbon\Carbon::parse($vp->date_start)->format('d/m/Y') }}
                                                — {{ \Carbon\Carbon::parse($vp->date_end)->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center fw-semibold">{{ number_format($vp->days_availables ?? 0, 0) }}</td>
                                    <td class="text-center">{{ $vp->days_enjoyed ?? 0 }}</td>
                                    <td class="text-center">{{ number_format($vp->days_reserved ?? 0, 0) }}</td>
                                    <td class="text-center">
                                        <span style="color:{{ $remaining > 0 ? '#0f5132' : '#842029' }}; font-weight:600;">
                                            {{ number_format($remaining, 0) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="period-badge {{ $vp->status === 'actual' ? 'actual' : 'vencido' }}">
                                            <i class="fa fa-circle" style="font-size:.45rem;"></i>
                                            {{ ucfirst($vp->status ?? '—') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Últimas solicitudes --}}
        <div class="profile-card card">
            <div class="card-body">
                <div class="section-title mb-3">Últimas solicitudes de vacaciones</div>

                @if($recentRequests->isEmpty())
                    <p class="text-muted mb-0" style="font-size:.88rem;">
                        <i class="fa fa-info-circle me-1"></i> Sin solicitudes registradas
                    </p>
                @else
                    <div class="table-responsive">
                        <table class="table req-table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th class="text-center">Días</th>
                                    <th class="text-center">Estado general</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentRequests as $req)
                                @php
                                    $days = $req->start && $req->end
                                        ? $req->start->diffInDays($req->end) + 1
                                        : '—';

                                    $statuses = collect([
                                        $req->direct_manager_status,
                                        $req->direction_approbation_status,
                                        $req->human_resources_status,
                                    ])->filter();

                                    if ($statuses->contains('Rechazada')) {
                                        $globalStatus = 'Rechazada';
                                        $badgeClass = 'badge-rechazada';
                                    } elseif ($statuses->every(fn($s) => $s === 'Aprobada')) {
                                        $globalStatus = 'Aprobada';
                                        $badgeClass = 'badge-aprobada';
                                    } elseif ($statuses->contains('Pendiente')) {
                                        $globalStatus = 'En revisión';
                                        $badgeClass = 'badge-en-revision';
                                    } else {
                                        $globalStatus = ucfirst($req->human_resources_status ?? $req->direct_manager_status ?? '—');
                                        $badgeClass = 'badge-pendiente';
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <span class="text-capitalize" style="font-size:.85rem;">
                                            {{ $req->type_request ?? 'Vacaciones' }}
                                        </span>
                                    </td>
                                    <td style="white-space:nowrap; font-size:.84rem;">
                                        {{ $req->start ? $req->start->format('d/m/Y') : '—' }}
                                    </td>
                                    <td style="white-space:nowrap; font-size:.84rem;">
                                        {{ $req->end ? $req->end->format('d/m/Y') : '—' }}
                                    </td>
                                    <td class="text-center fw-semibold" style="font-size:.88rem;">
                                        {{ $days }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $badgeClass }}" style="font-size:.72rem; padding:.3em .65em; border-radius:99px;">
                                            {{ $globalStatus }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    function submitFotoForm() {
        const input = document.getElementById('fotoInput');
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];

        // Validar tipo de archivo
        const allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowed.includes(file.type)) {
            alert('Solo se permiten imágenes JPG, PNG o WebP.');
            input.value = '';
            return;
        }

        // Validar tamaño (8 MB máx)
        if (file.size > 8 * 1024 * 1024) {
            alert('La imagen no puede superar 8 MB.');
            input.value = '';
            return;
        }

        // Preview instantáneo antes de subir
        const avatarImg = document.getElementById('avatarImg');
        if (avatarImg) {
            const reader = new FileReader();
            reader.onload = function(e) { avatarImg.src = e.target.result; };
            reader.readAsDataURL(file);
        }

        // Indicar carga
        document.querySelector('.profile-avatar-outer').classList.add('foto-uploading');

        document.getElementById('fotoForm').submit();
    }
</script>
@endpush
