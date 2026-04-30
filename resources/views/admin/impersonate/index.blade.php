@extends('layouts.codebase.master')

@section('content')
<div class="container-fluid py-3">

    {{-- ── PAGE HEADER ─────────────────────────────────────────────────── --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-user-secret text-warning me-2"></i>
                Módulo de Pruebas — Vista como Usuario
            </h4>
            <small class="text-muted">
                Accede al módulo de vacaciones con la sesión de cualquier empleado activo
            </small>
        </div>
        <span class="badge bg-warning text-dark px-3 py-2" style="font-size:.8rem;">
            <i class="fas fa-flask me-1"></i> SOLO SUPER-ADMIN
        </span>
    </div>

    {{-- ── SESIÓN ACTIVA ───────────────────────────────────────────────── --}}
    @if($currentlyImpersonating)
    <div class="alert alert-warning border-start border-warning border-4 d-flex align-items-center justify-content-between py-2 mb-4" role="alert">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ $currentlyImpersonating->profile_image ?? asset('assets/images/default-avatar.svg') }}"
                 class="rounded-circle border border-warning border-2"
                 style="width:42px;height:42px;object-fit:cover;" alt="">
            <div>
                <div class="fw-bold" style="font-size:.95rem;">
                    <i class="fas fa-circle text-success me-1" style="font-size:.5rem;vertical-align:middle;"></i>
                    Sesión activa
                </div>
                <div class="text-muted" style="font-size:.85rem;">
                    Visualizando como
                    <strong class="text-dark">
                        {{ $currentlyImpersonating->first_name }} {{ $currentlyImpersonating->last_name }}
                    </strong>
                    &nbsp;<span class="badge bg-secondary">ID {{ $currentlyImpersonating->id }}</span>
                    &nbsp;·&nbsp; {{ $currentlyImpersonating->job->name ?? '—' }}
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('vacaciones.index') }}" class="btn btn-sm btn-warning">
                <i class="fas fa-eye me-1"></i> Ir a Vacaciones
            </a>
            <form method="POST" action="{{ route('admin.impersonate.stop') }}" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-sign-out-alt me-1"></i> Salir del modo prueba
                </button>
            </form>
        </div>
    </div>
    @endif

    {{-- ── FLASH ───────────────────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ── FILTROS ─────────────────────────────────────────────────────── --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.impersonate.index') }}" id="filterForm">
                <div class="row g-2 align-items-end">

                    {{-- Búsqueda --}}
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold mb-1">
                            <i class="fas fa-search me-1 text-muted"></i> Buscar
                        </label>
                        <div class="input-group">
                            <input type="text"
                                   name="search"
                                   id="searchInput"
                                   class="form-control"
                                   placeholder="Nombre, correo o ID…"
                                   value="{{ $search }}"
                                   autocomplete="off">
                            @if($search)
                                <button type="button" class="btn btn-outline-secondary"
                                        onclick="document.getElementById('searchInput').value=''; document.getElementById('filterForm').submit();"
                                        title="Limpiar búsqueda">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                        <div class="form-text">Busca por nombre, correo electrónico o ID numérico</div>
                    </div>

                    {{-- Departamento --}}
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold mb-1">
                            <i class="fas fa-building me-1 text-muted"></i> Departamento
                        </label>
                        <select name="department" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos los departamentos</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ $deptFilter == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Botones --}}
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-filter me-1"></i> Filtrar
                        </button>
                        @if($search || $deptFilter)
                            <a href="{{ route('admin.impersonate.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ── TABLA ───────────────────────────────────────────────────────── --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex align-items-center justify-content-between py-2">
            <span class="fw-semibold text-muted" style="font-size:.85rem;">
                <i class="fas fa-users me-1"></i>
                {{ $users->total() }} empleado{{ $users->total() !== 1 ? 's' : '' }} encontrado{{ $users->total() !== 1 ? 's' : '' }}
                @if($search || $deptFilter)
                    <span class="ms-2">
                        @if($search)
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                "{{ $search }}"
                            </span>
                        @endif
                        @if($deptFilter)
                            @php $selectedDept = $departments->find($deptFilter); @endphp
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                {{ $selectedDept?->name }}
                            </span>
                        @endif
                    </span>
                @endif
            </span>
            <small class="text-muted">Página {{ $users->currentPage() }} / {{ $users->lastPage() }}</small>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fa; font-size:.8rem; text-transform:uppercase; letter-spacing:.04em;">
                    <tr>
                        <th class="ps-3" style="width:60px;">ID</th>
                        <th>Empleado</th>
                        <th>Correo</th>
                        <th>Departamento</th>
                        <th>Puesto</th>
                        <th class="text-center" style="width:150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $employee)
                        @php
                            $isActive = $currentlyImpersonating && $currentlyImpersonating->id === $employee->id;
                        @endphp
                        <tr class="{{ $isActive ? 'table-warning' : '' }}" style="font-size:.9rem;">

                            {{-- ID --}}
                            <td class="ps-3">
                                <span class="badge bg-light text-secondary border fw-normal" style="font-size:.8rem;">
                                    {{ $employee->id }}
                                </span>
                            </td>

                            {{-- Empleado --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $employee->profile_image ?? asset('assets/images/default-avatar.svg') }}"
                                         class="rounded-circle {{ $isActive ? 'border border-warning border-2' : '' }}"
                                         style="width:36px;height:36px;object-fit:cover;flex-shrink:0;" alt="">
                                    <div>
                                        <div class="fw-semibold lh-sm">
                                            {{ $employee->first_name }} {{ $employee->last_name }}
                                        </div>
                                        @if($isActive)
                                            <span class="badge bg-warning text-dark" style="font-size:.7rem;">
                                                <i class="fas fa-circle me-1" style="font-size:.45rem;vertical-align:middle;"></i>
                                                Sesión activa
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Correo --}}
                            <td class="text-muted">{{ $employee->email }}</td>

                            {{-- Departamento --}}
                            <td>
                                @if($employee->job?->departamento)
                                    <span class="badge bg-light text-dark border" style="font-size:.78rem;">
                                        <i class="fas fa-building me-1 text-muted"></i>
                                        {{ $employee->job->departamento->name }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- Puesto --}}
                            <td class="text-muted" style="font-size:.85rem;">
                                {{ $employee->job->name ?? '—' }}
                            </td>

                            {{-- Acción --}}
                            <td class="text-center">
                                <form method="POST" action="{{ route('admin.impersonate.start', $employee->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm {{ $isActive ? 'btn-warning' : 'btn-outline-primary' }}"
                                            title="Ver /vacaciones como {{ $employee->first_name }}">
                                        <i class="fas fa-user-secret me-1"></i>
                                        {{ $isActive ? 'Volver' : 'Acceder como' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fas fa-users-slash fa-2x d-block mb-2 opacity-25"></i>
                                No se encontraron empleados
                                @if($search || $deptFilter)
                                    con los filtros aplicados.
                                    <br>
                                    <a href="{{ route('admin.impersonate.index') }}" class="btn btn-sm btn-outline-secondary mt-2">
                                        <i class="fas fa-times me-1"></i> Limpiar filtros
                                    </a>
                                @else
                                    activos.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($users->hasPages())
            <div class="card-footer bg-white d-flex justify-content-between align-items-center py-2">
                <small class="text-muted">
                    Mostrando {{ $users->firstItem() }}–{{ $users->lastItem() }} de {{ $users->total() }}
                </small>
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<script>
// Submit form on Enter in search field
document.getElementById('searchInput').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('filterForm').submit();
    }
});
</script>
@endsection
