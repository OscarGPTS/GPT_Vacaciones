@extends('layouts.codebase.master')

@section('content')
<style>
/* Estilos para details/summary */
details summary {
    list-style: none;
    cursor: pointer;
    user-select: none;
    padding: 8px 12px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    transition: all 0.2s;
}

details summary:hover {
    background: #e9ecef;
    border-color: #0d6efd;
}

details summary::-webkit-details-marker {
    display: none;
}

details[open] summary {
    background: #0d6efd;
    color: white;
    border-color: #0d6efd;
    margin-bottom: 10px;
}

details[open] summary:hover {
    background: #0b5ed7;
}

details summary::before {
    content: '▶';
    display: inline-block;
    margin-right: 5px;
    transition: transform 0.2s;
}

details[open] summary::before {
    transform: rotate(90deg);
}

.employee-list-content {
    padding: 10px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    margin-top: -4px;
}

.employee-list-content .dept-section {
    margin-bottom: 15px;
}

.employee-list-content .dept-section:last-child {
    margin-bottom: 0;
}

.employee-item {
    padding: 6px 10px;
    background: white;
    border-radius: 3px;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.15s;
}

.employee-item:hover {
    background: #e7f3ff;
}

.employee-item:last-child {
    margin-bottom: 0;
}

.btn-delete-inline {
    padding: 2px 6px;
    font-size: 0.75rem;
    line-height: 1;
    border-radius: 3px;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="card-title mb-0 text-black">
                                <i class="fas fa-user-tie me-2"></i> Gestión de Jefes Directos Personalizados
                            </h3>
                            <small class="text-black d-block mt-1">
                                Asigna jefes directos personalizados para departamentos específicos
                            </small>
                        </div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addApproverModal">
                            <i class="fas fa-plus me-1"></i> Asignar Nuevo Jefe Directo
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>¿Qué hace este módulo?</strong>
                        <p class="mb-0 mt-2">
                            Permite asignar jefes directos personalizados para departamentos específicos. Cuando un empleado de ese departamento 
                            crea una solicitud de vacaciones, se le asignará automáticamente este jefe personalizado en lugar del jefe por defecto.
                        </p>
                    </div>

                    @if($approvers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Jefe Directo</th>
                                        <th>Departamentos</th>
                                        <th>Empleados Asignados</th>
                                        <th class="text-center" style="width: 120px;">Estado</th>
                                        <th class="text-center" style="width: 200px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($approvers as $bossId => $userApprovers)
                                        @php
                                            $boss = $userApprovers->first()->user;
                                            $byDept = $userApprovers->groupBy('departamento_id');
                                            $activeCount = $userApprovers->where('is_active', true)->count();
                                            $totalCount = $userApprovers->count();
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                         style="width: 35px; height: 35px; font-size: 0.9rem; font-weight: 600; flex-shrink: 0;">
                                                        {{ strtoupper(substr($boss->first_name ?? '', 0, 1)) }}{{ strtoupper(substr($boss->last_name ?? '', 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $boss->first_name }} {{ $boss->last_name }}</strong>
                                                        @if($boss->job)
                                                            <br><small class="text-muted">{{ $boss->job->name }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($byDept as $deptId => $deptApprovers)
                                                        @php
                                                            $dept = $deptApprovers->first()->departamento;
                                                            $deptActive = $deptApprovers->where('is_active', true)->count();
                                                        @endphp
                                                        <span class="badge bg-{{ $deptActive > 0 ? 'primary' : 'secondary' }}" style="font-size: 0.8rem;">
                                                            <i class="fas fa-building me-1"></i>{{ $dept->name }} ({{ $deptApprovers->count() }})
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                <details>
                                                    <summary>
                                                        <i class="fas fa-users me-2"></i>
                                                        <strong>{{ $totalCount }}</strong> empleado(s) asignado(s)
                                                    </summary>
                                                    <div class="employee-list-content">
                                                        @foreach($byDept as $deptId => $deptApprovers)
                                                            @php $dept = $deptApprovers->first()->departamento; @endphp
                                                            <div class="dept-section">
                                                                <div class="fw-bold text-primary mb-2" style="font-size: 0.9rem;">
                                                                    <i class="fas fa-building me-2"></i>{{ $dept->name }}
                                                                    <span class="badge bg-secondary ms-1">{{ $deptApprovers->count() }}</span>
                                                                </div>
                                                                <div>
                                                                    @foreach($deptApprovers->sortBy(fn($a) => $a->employee->first_name ?? '') as $approver)
                                                                        <div class="employee-item">
                                                                            <div class="d-flex align-items-center gap-2">
                                                                                <i class="fas fa-user-circle text-muted"></i>
                                                                                <span>{{ $approver->employee->first_name ?? 'N/A' }} {{ $approver->employee->last_name ?? '' }}</span>
                                                                                <span class="badge bg-{{ $approver->is_active ? 'success' : 'secondary' }}" style="font-size: 0.7rem;">
                                                                                    {{ $approver->is_active ? 'Activo' : 'Inactivo' }}
                                                                                </span>
                                                                            </div>
                                                                            <button class="btn btn-danger btn-delete-inline" 
                                                                                    onclick="event.stopPropagation(); deleteApprover({{ $approver->id }}, '{{ addslashes(($approver->employee->first_name ?? '') . ' ' . ($approver->employee->last_name ?? '')) }}')"
                                                                                    title="Eliminar empleado">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </details>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success d-block mb-1">{{ $activeCount }} activos</span>
                                                <small class="text-muted">de {{ $totalCount }}</small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group-vertical btn-group-sm w-100" role="group">
                                                    <button class="btn btn-outline-primary" onclick="openEditModal({{ $bossId }})">
                                                        <i class="fas fa-edit me-1"></i>Editar
                                                    </button>
                                                    <button class="btn btn-outline-danger" onclick="deleteAllForBoss({{ $bossId }}, '{{ addslashes($boss->first_name . ' ' . $boss->last_name) }}')">
                                                        <i class="fas fa-trash me-1"></i>Eliminar Todo
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-user-tie fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay jefes directos personalizados asignados</h5>
                            <p class="text-muted">Haz clic en "Asignar Nuevo Jefe Directo" para comenzar</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Asignar Jefe Directo -->
<div class="modal fade" id="addApproverModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-white">
            <form action="{{ route('admin.manager-approvers.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>
                        Asignar Nuevo Jefe Directo Personalizado
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Asignación por departamento:</strong> Todos los empleados del departamento tendrán este jefe.<br>
                        <strong>Asignación por usuario específico:</strong> Solo el/los usuario(s) seleccionado(s) tendrán este jefe (prioridad sobre departamento).
                    </div>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">
                            <i class="fas fa-user me-1"></i> Usuario (Jefe Directo) <span class="text-danger">*</span>
                        </label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">Seleccione un usuario...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                    @if($user->job)
                                        - {{ $user->job->name }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Usuario que actuará como jefe directo</small>
                    </div>

                    <!-- Tipo de Asignación -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-tasks me-1"></i> Tipo de Asignación <span class="text-danger">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="assignment_type" id="type_departamento" value="departamento" checked>
                            <label class="btn btn-outline-primary" for="type_departamento">
                                <i class="fas fa-building"></i> Por Departamento
                            </label>

                            <input type="radio" class="btn-check" name="assignment_type" id="type_usuario" value="usuario">
                            <label class="btn btn-outline-primary" for="type_usuario">
                                <i class="fas fa-user"></i> Por Usuario Específico
                            </label>
                        </div>
                    </div>

                    <!-- Sección Departamentos -->
                    <div id="departamentosSection" class="mb-3">
                        <label class="form-label">
                            Departamentos <span class="text-danger">*</span>
                        </label>
                        <small class="text-muted d-block mb-2">Selecciona uno o más departamentos</small>
                        <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                            @foreach($departamentos as $dept)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="departamentos[]" 
                                           value="{{ $dept->id }}" id="dept{{ $dept->id }}">
                                    <label class="form-check-label" for="dept{{ $dept->id }}">
                                        {{ $dept->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sección Usuarios Específicos -->
                    <div id="usuariosSection" class="mb-3" style="display: none;">
                        <label class="form-label">
                            Usuarios Específicos <span class="text-danger">*</span>
                        </label>
                        <small class="text-muted d-block mb-2">Selecciona uno o más usuarios que reportarán a este jefe</small>
                        <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                            @foreach($users as $user)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="usuarios_especificos[]" 
                                           value="{{ $user->id }}" id="userApprove{{ $user->id }}">
                                    <label class="form-check-label" for="userApprove{{ $user->id }}">
                                        {{ $user->first_name }} {{ $user->last_name }}
                                        @if($user->job)
                                            <small class="text-muted">- {{ $user->job->name }}</small>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Asignar Jefe Directo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Formulario oculto para toggle -->
<form id="toggleForm" method="POST" style="display: none;">
    @csrf
</form>

<!-- Formulario oculto para delete -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Formulario oculto para delete all -->
<form id="deleteAllForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Editar Asignaciones -->
<div class="modal fade" id="editApproverModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-white">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>
                        <span id="editModalTitle">Editar Asignaciones</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-user me-1"></i> Jefe Directo <span class="text-danger">*</span>
                        </label>
                        <select name="new_boss_id" id="editBossSelect" class="form-select" required>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">
                                    {{ $u->first_name }} {{ $u->last_name }}
                                    @if($u->job) - {{ $u->job->name }} @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-users me-1"></i> Empleados Asignados
                        </label>
                        <input type="text" class="form-control mb-2" id="editSearchEmployees" placeholder="Buscar empleado...">
                        <div class="border rounded p-2" style="max-height: 350px; overflow-y: auto;" id="editEmployeeList">
                            @php
                                $usersByDept = $users->filter(fn($u) => $u->job)->groupBy(fn($u) => $u->job->depto_id);
                            @endphp
                            @foreach($departamentos as $dept)
                                @if(isset($usersByDept[$dept->id]))
                                    <div class="fw-bold text-primary mt-2 mb-1 border-bottom pb-1 dept-header">
                                        <i class="fas fa-building me-1"></i> {{ $dept->name }}
                                    </div>
                                    @foreach($usersByDept[$dept->id] as $emp)
                                        <div class="form-check ms-3 edit-employee-item">
                                            <input class="form-check-input" type="checkbox"
                                                   name="employee_ids[]" value="{{ $emp->id }}"
                                                   id="editEmp{{ $emp->id }}">
                                            <label class="form-check-label" for="editEmp{{ $emp->id }}">
                                                {{ $emp->first_name }} {{ $emp->last_name }}
                                                @if($emp->job) <small class="text-muted">- {{ $emp->job->name }}</small> @endif
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Datos de asignaciones actuales para el modal de edición
const approverData = @json($approvers->map(fn($group) => $group->pluck('employee_id')->toArray()));

// Toggle entre departamentos y usuarios específicos (modal agregar)
document.getElementById('type_departamento').addEventListener('change', function() {
    document.getElementById('departamentosSection').style.display = 'block';
    document.getElementById('usuariosSection').style.display = 'none';
    document.querySelectorAll('input[name="usuarios_especificos[]"]').forEach(el => el.checked = false);
});

document.getElementById('type_usuario').addEventListener('change', function() {
    document.getElementById('departamentosSection').style.display = 'none';
    document.getElementById('usuariosSection').style.display = 'block';
    document.querySelectorAll('input[name="departamentos[]"]').forEach(el => el.checked = false);
});

// Búsqueda en modal de edición
document.getElementById('editSearchEmployees').addEventListener('input', function() {
    const search = this.value.toLowerCase();
    document.querySelectorAll('#editEmployeeList .edit-employee-item').forEach(el => {
        const label = el.querySelector('label').textContent.toLowerCase();
        el.style.display = label.includes(search) ? '' : 'none';
    });
    // Mostrar/ocultar headers de departamento según si tienen items visibles
    document.querySelectorAll('#editEmployeeList .dept-header').forEach(header => {
        let next = header.nextElementSibling;
        let hasVisible = false;
        while (next && !next.classList.contains('dept-header')) {
            if (next.style.display !== 'none') hasVisible = true;
            next = next.nextElementSibling;
        }
        header.style.display = hasVisible ? '' : 'none';
    });
});

function toggleApprover(id, employeeName) {
    if (confirm(`¿Cambiar el estado de la asignación de ${employeeName}?`)) {
        const form = document.getElementById('toggleForm');
        form.action = `/admin/manager-approvers/${id}/toggle`;
        form.submit();
    }
}

function deleteApprover(id, employeeName) {
    if (confirm(`¿Está seguro de eliminar la asignación de ${employeeName}?\n\nEsta acción no se puede deshacer.`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/manager-approvers/${id}`;
        form.submit();
    }
    return false;
}

function deleteAllForBoss(bossId, bossName) {
    if (confirm(`¿Eliminar TODAS las asignaciones de ${bossName}?\n\nSe eliminarán todos los empleados asignados. Esta acción no se puede deshacer.`)) {
        const form = document.getElementById('deleteAllForm');
        form.action = `/admin/manager-approvers/${bossId}/all`;
        form.submit();
    }
}

function openEditModal(bossId) {
    const form = document.getElementById('editForm');
    form.action = `/admin/manager-approvers/${bossId}`;

    // Seleccionar el jefe actual
    document.getElementById('editBossSelect').value = bossId;

    // Limpiar búsqueda
    document.getElementById('editSearchEmployees').value = '';
    document.querySelectorAll('#editEmployeeList .edit-employee-item').forEach(el => el.style.display = '');
    document.querySelectorAll('#editEmployeeList .dept-header').forEach(el => el.style.display = '');

    // Desmarcar todos
    document.querySelectorAll('#editEmployeeList input[type=checkbox]').forEach(cb => cb.checked = false);

    // Marcar empleados asignados actualmente
    const empIds = approverData[bossId] || [];
    empIds.forEach(id => {
        const cb = document.getElementById('editEmp' + id);
        if (cb) cb.checked = true;
    });

    // Actualizar título
    const bossSelect = document.getElementById('editBossSelect');
    const bossName = bossSelect.options[bossSelect.selectedIndex].text.split(' - ')[0].trim();
    document.getElementById('editModalTitle').textContent = 'Editar Asignaciones de: ' + bossName;

    new bootstrap.Modal(document.getElementById('editApproverModal')).show();
}
</script>
@endpush
