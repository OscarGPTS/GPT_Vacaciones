# Sistema de Logs del Sistema

## Descripción
Sistema de registro de errores, advertencias e información general de la aplicación. Permite identificar usuarios con problemas en sus datos y rastrear la resolución de errores.

## Tabla: `system_logs`

### Campos

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `user_id` | bigint nullable | Usuario afectado por el error |
| `created_by` | bigint nullable | Usuario que generó/detectó el error |
| `level` | enum | Nivel: `error`, `warning`, `info`, `debug` |
| `type` | string | Tipo de operación: `vacation_import`, `vacation_export`, `employee_update`, etc. |
| `message` | text | Mensaje descriptivo del error |
| `context` | json nullable | Datos adicionales relevantes |
| `status` | enum | Estado: `pending`, `resolved`, `ignored` |
| `resolved_at` | timestamp nullable | Fecha de resolución |
| `resolved_by` | bigint nullable | Usuario que resolvió el error |
| `resolution_notes` | text nullable | Notas sobre la resolución |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de actualización |

### Índices
- `user_id` + `status`
- `type` + `status`
- `created_at`

## Modelo: `SystemLog`

### Relaciones

```php
$log->user;      // Usuario afectado
$log->creator;   // Usuario que creó el log
$log->resolver;  // Usuario que resolvió el error
```

### Métodos Estáticos (Helpers)

#### Crear logs

```php
// Error
SystemLog::logError(
    'vacation_import',                        // Tipo
    'Usuario no encontrado',                  // Mensaje
    $userId,                                  // User ID (nullable)
    ['nombre' => 'Juan Pérez', 'dni' => '123'] // Context (nullable)
);

// Advertencia
SystemLog::logWarning(
    'employee_data',
    'Fecha de admisión futura',
    $userId,
    ['admission' => '2027-01-01']
);

// Información
SystemLog::logInfo(
    'vacation_period_created',
    'Nuevo período creado exitosamente',
    $userId,
    ['period_id' => 123]
);
```

#### Marcar como resuelto

```php
$log = SystemLog::find($id);
$log->markAsResolved('Se corrigió la fecha de aniversario manualmente');

// O marcar como ignorado
$log->markAsIgnored('Error duplicado, ya se resolvió en log #456');
```

### Scopes

```php
// Obtener errores pendientes
SystemLog::pending()->get();

// Obtener errores resueltos
SystemLog::resolved()->get();

// Filtrar por tipo
SystemLog::byType('vacation_import')->get();

// Filtrar por usuario
SystemLog::forUser($userId)->get();

// Solo errores (nivel error)
SystemLog::errors()->get();

// Solo advertencias (nivel warning)
SystemLog::warnings()->get();

// Combinaciones
SystemLog::errors()
    ->pending()
    ->byType('vacation_import')
    ->forUser($userId)
    ->orderBy('created_at', 'desc')
    ->get();
```

## Ejemplos de Uso

### 1. Importación de Vacaciones (ya implementado)

```php
// En VacationImport::executeImport()

// Usuario no encontrado
if (empty($record['user'])) {
    SystemLog::logError(
        'vacation_import',
        'Usuario no identificado (no existe en la BD o no se pudo mapear)',
        null,
        [
            'nombre_completo' => $record['nombre_completo'],
            'numero_empleado' => $record['numero_empleado'],
        ]
    );
}

// Usuario inactivo
SystemLog::logError(
    'vacation_import',
    'Usuario encontrado, pero está en estado inactivo',
    $userId,
    ['nombre_completo' => $nombre]
);

// Período no encontrado
SystemLog::logError(
    'vacation_import',
    "No se encontró período con fecha fin {$fechaExcel}",
    $userId,
    [
        'nombre_completo' => $nombre,
        'fecha_excel' => $fechaExcel,
        'fecha_admision_real' => $fechaAdmisionReal,
    ]
);
```

### 2. Consultar Errores por Usuario

```php
// En VacationReport (vista de usuarios)
$logsUsuarios = SystemLog::errors()
    ->pending()
    ->byType('vacation_import')
    ->with('user')
    ->get()
    ->groupBy('user_id');

// Identificar usuarios con errores
$usuariosConErrores = $logsUsuarios->keys();

// En Blade
@if(isset($usuariosConErrores) && in_array($employee->id, $usuariosConErrores->toArray()))
    <span class="badge bg-danger" title="Este usuario tiene errores pendientes">
        ⚠️ {{ $logsUsuarios[$employee->id]->count() }} errores
    </span>
@endif
```

### 3. Panel de Administración de Logs

```php
// Livewire Component: SystemLogsManager

public function getLogsProperty()
{
    return SystemLog::with(['user', 'creator', 'resolver'])
        ->when($this->filterType, fn($q) => $q->byType($this->filterType))
        ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
        ->when($this->filterLevel, fn($q) => $q->where('level', $this->filterLevel))
        ->orderBy('created_at', 'desc')
        ->paginate(50);
}

public function resolveLog($logId, $notes)
{
    $log = SystemLog::find($logId);
    $log->markAsResolved($notes);
    
    $this->notification()->success('Log marcado como resuelto');
}
```

### 4. Dashboard de Estadísticas

```php
// Errores por tipo
$errorsByType = SystemLog::errors()
    ->pending()
    ->select('type', DB::raw('count(*) as total'))
    ->groupBy('type')
    ->get();

// Errores por usuario (top 10)
$topUsersWithErrors = SystemLog::errors()
    ->pending()
    ->whereNotNull('user_id')
    ->select('user_id', DB::raw('count(*) as total'))
    ->groupBy('user_id')
    ->orderBy('total', 'desc')
    ->limit(10)
    ->with('user')
    ->get();

// Errores resueltos hoy
$resolvedToday = SystemLog::resolved()
    ->whereDate('resolved_at', today())
    ->count();
```

## Tipos de Logs Sugeridos

### Vacaciones
- `vacation_import` - Importación de vacaciones
- `vacation_export` - Exportación de datos
- `vacation_period_create` - Creación de períodos
- `vacation_period_update` - Actualización de períodos
- `vacation_request` - Solicitudes de vacaciones

### Empleados
- `employee_create` - Alta de empleados
- `employee_update` - Actualización de datos
- `employee_delete` - Baja de empleados
- `employee_data_validation` - Validación de datos

### Aprobaciones
- `approval_manager` - Aprobación de gerente
- `approval_direction` - Aprobación de dirección
- `approval_hr` - Aprobación de RRHH
- `auto_approval` - Aprobaciones automáticas

### Sistema
- `system_error` - Errores generales del sistema
- `database_error` - Errores de base de datos
- `file_upload` - Carga de archivos
- `authentication` - Autenticación

## Visualización en Vista de Vacaciones

### Opción 1: Indicador Visual en Tabla

```blade
<td>
    {{ $employee->full_name }}
    
    @php
        $userLogs = $logsUsuarios[$employee->id] ?? collect();
    @endphp
    
    @if($userLogs->isNotEmpty())
        <span class="badge badge-sm bg-warning ms-2" 
              x-data x-tooltip.raw="{{ $userLogs->pluck('message')->join(', ') }}">
            {{ $userLogs->count() }} ⚠️
        </span>
    @endif
</td>
```

### Opción 2: Filtro de Usuarios con Errores

```php
// En VacationReport.php
public $filterUsersWithErrors = false;

public function getEmployeesProperty()
{
    $query = User::with(['job.departamento', 'vacationPeriods'])
        ->where('active', 1);
    
    if ($this->filterUsersWithErrors) {
        $usersWithErrors = SystemLog::errors()
            ->pending()
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->unique();
        
        $query->whereIn('id', $usersWithErrors);
    }
    
    return $query->paginate($this->perPage);
}
```

### Opción 3: Modal con Detalles de Errores

```blade
<button wire:click="$emit('showUserLogs', {{ $employee->id }})"
        class="btn btn-sm btn-outline-danger">
    Ver errores ({{ $employee->logs_count }})
</button>

<!-- Modal -->
<x-modal wire:model="showLogsModal">
    <div class="space-y-2">
        @foreach($selectedUserLogs as $log)
            <div class="alert alert-{{ $log->level === 'error' ? 'danger' : 'warning' }}">
                <strong>{{ $log->message }}</strong>
                <p class="text-sm mt-1">{{ $log->created_at->diffForHumans() }}</p>
                
                @if($log->context)
                    <details class="mt-2">
                        <summary>Ver detalles</summary>
                        <pre class="text-xs">{{ json_encode($log->context, JSON_PRETTY_PRINT) }}</pre>
                    </details>
                @endif
                
                <button wire:click="resolveLog({{ $log->id }})" 
                        class="btn btn-sm btn-success mt-2">
                    Marcar como resuelto
                </button>
            </div>
        @endforeach
    </div>
</x-modal>
```

## Limpieza Automática (Tarea Programada)

```php
// app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // Eliminar logs resueltos mayores a 90 días
    $schedule->call(function () {
        SystemLog::resolved()
            ->where('resolved_at', '<', now()->subDays(90))
            ->delete();
    })->daily();
    
    // Eliminar logs info mayores a 30 días
    $schedule->call(function () {
        SystemLog::where('level', 'info')
            ->where('created_at', '<', now()->subDays(30))
            ->delete();
    })->daily();
}
```

## Notificaciones para Administradores

```php
// Notificar cuando hay muchos errores
if (SystemLog::errors()->pending()->count() > 50) {
    // Enviar email o notificación a admins
    Notification::send(
        User::role('admin')->get(),
        new HighErrorCountNotification()
    );
}
```
