# Arquitectura del Sistema

**Sistema:** RRHH Satech Energy  
**Stack:** Laravel 10 + Livewire 3 + Tailwind CSS + WireUI  
**Última actualización:** Abril 2026

---

## 1. Separación de Bases de Datos

El sistema utiliza **2 bases de datos MySQL**:

| Base de datos | Contenido | Conexión Laravel |
|---|---|---|
| `rh` (principal) | `users`, `jobs`, `departamentos`, roles, permisos | `mysql` |
| `rh_vacations` | Todas las tablas del módulo de vacaciones | `mysql_vacations` |

### Tablas en `rh_vacations`

1. `requests` — Solicitudes de vacaciones
2. `vacations_availables` — Períodos de vacaciones por empleado
3. `request_approved` — Días aprobados (calendario)
4. `request_rejected` — Días rechazados
5. `vacation_per_years` — Catálogo de días por antigüedad (LFT México)
6. `no_working_days` — Días no laborables
7. `direction_approvers` — Aprobadores de dirección personalizados
8. `manager_approvers` — Jefes directos personalizados
9. `delegation_permissions` — Permisos de solicitud en representación
10. `system_logs` — Logs del sistema

### Configuración de Modelos

Todos los modelos de vacaciones usan `protected $connection = 'mysql_vacations'`:

```php
// Modelos en BD vacaciones
RequestVacations, VacationsAvailable, RequestApproved, RequestRejected,
VacationPerYear, NoWorkingDays, DirectionApprover, ManagerApprover,
DelegationPermission, SystemLog
```

### Relaciones Cross-Database

**BelongsTo (vacaciones → principal):** Usar `setConnection('mysql')`:

```php
// En RequestVacations.php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class)->setConnection('mysql');
}
```

**HasMany (principal → vacaciones):** Funciona automáticamente porque el modelo hijo ya tiene su conexión:

```php
// En User.php
public function requestVacations(): HasMany
{
    return $this->hasMany(RequestVacations::class, 'user_id');
}
```

### Local vs Producción

| Aspecto | Local (XAMPP) | Producción (StackCP) |
|---------|---------------|----------------------|
| Vistas SQL cross-DB | Disponibles (opcional) | No permitidas |
| Relaciones Eloquent | `setConnection()` | `setConnection()` |
| Transacciones cross-DB | No atómicas | No atómicas |

> **Nota:** En producción NO se usan vistas SQL. Las relaciones Eloquent con `setConnection()` son suficientes.

### Queries directas

```php
// ❌ Incorrecto (usa conexión por defecto)
DB::table('vacations_availables')->get();

// ✅ Correcto
DB::connection('mysql_vacations')->table('vacations_availables')->get();

// ✅ Mejor: usar Eloquent
VacationsAvailable::all();
```

---

## 2. Modelo de Datos de Vacaciones

### Tabla `vacations_availables`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `users_id` | bigint | ID del empleado |
| `period` | int | Año de antigüedad (1-40) |
| `date_start` | date | Fecha inicio del período |
| `date_end` | date | Fecha fin del período (aniversario) |
| `cutoff_date` | date | Fecha de vencimiento (date_end + 15 meses) |
| `days_availables` | decimal(8,2) | Saldo base fijo del período (según LFT) |
| `days_calculated` | decimal(8,2) | Días acumulados por devengamiento diario del sistema |
| `days_enjoyed` | int | Días ya disfrutados acumulados |
| `days_reserved` | decimal(5,2) | Días reservados en solicitudes pendientes |
| `status` | enum | `actual` o `vencido` |

**Fórmula de saldo:**
```
saldo_disponible = days_availables - days_enjoyed - days_reserved
```

- `days_availables` — **Nunca cambia** (saldo base del período)
- `days_calculated` — Actualizado diariamente por el sistema (devengamiento)
- `days_enjoyed` — Solo aumenta al aprobar vacaciones
- `days_reserved` — Sube al crear solicitud, baja al aprobar/rechazar

### Tabla `requests`

| Campo | Descripción | Estados |
|-------|-------------|---------|
| `user_id` | Empleado solicitante | — |
| `created_by_user_id` | Creador si es en representación | NULL o user_id |
| `opcion` | Formato: `{period}\|{date_start}` | `5\|2024-08-08` |
| `direct_manager_id` | Manager asignado | — |
| `direct_manager_status` | Aprobación del manager | `Pendiente`, `Aprobada`, `Rechazada` |
| `direction_approbation_id` | Dirección asignada | — |
| `direction_approbation_status` | Aprobación de dirección | `Pendiente`, `Aprobada`, `Rechazada` |
| `human_resources_status` | Aprobación de RH | `Pendiente`, `Aprobada`, `Rechazada` |

### Catálogo `vacation_per_years` (LFT México)

Fuente única de verdad para días por antigüedad. Elimina redundancia de `days_total_period`.

---

## 3. Capa de Servicios

El sistema sigue el principio SRP con servicios especializados:

| Servicio | Responsabilidad | Comando Artisan |
|----------|-----------------|-----------------|
| `VacationPeriodCreatorService` | Crear períodos faltantes para empleados | `vacations:create-periods` |
| `VacationDailyAccumulatorService` | Actualizar devengamiento diario | `vacations:daily-accrual` |
| `AutoApprovalService` | Auto-aprobar solicitudes > 5 días | `vacations:auto-approve` |

### Programación (Cron)

Configurada en `app/Console/Kernel.php`:

| Hora | Comando | Descripción |
|------|---------|-------------|
| 00:01 | `vacations:daily-accrual` | Actualizar días devengados |
| 00:30 | `vacations:check-expired` | Verificar períodos vencidos |
| 09:00 | `vacations:auto-approve` | Auto-aprobar solicitudes pendientes |

**Windows XAMPP:** Configurar Task Scheduler para ejecutar `php artisan schedule:run` cada minuto.

---

## 4. Sistema de Logs

Tabla `system_logs` en `mysql_vacations` para registrar eventos del sistema.

```php
// Registrar un log
SystemLog::create([
    'user_id' => $userId,
    'level' => 'error',      // error, warning, info, debug
    'type' => 'vacation_import',
    'message' => 'Error al importar',
    'context' => json_encode($data),
    'status' => 'pending',   // pending, resolved, ignored
]);
```

---

## 5. Archivos Clave del Código

### Controladores
| Archivo | Métodos Clave |
|---------|---------------|
| `VacacionesController.php` | `create()`, `store()`, `ajax()` |
| `RequestController.php` | `approveRejectManager()`, `releaseReservedDays()` |

### Componentes Livewire
| Archivo | Métodos Clave |
|---------|---------------|
| `VacacionesRh.php` | `approveRequest()`, `rejectRequest()` |
| `VacationReport.php` | Reporte con filtros de empleados |
| `VacationImport.php` | Importación masiva 3 pasos |

### Servicios
| Archivo | Responsabilidad |
|---------|-----------------|
| `AutoApprovalService.php` | Auto-aprobaciones |
| `VacationPeriodCreatorService.php` | Creación de períodos |
| `VacationDailyAccumulatorService.php` | Devengamiento diario |

### Modelos
| Archivo | Conexión |
|---------|----------|
| `User.php` | `mysql` |
| `RequestVacations.php` | `mysql_vacations` |
| `VacationsAvailable.php` | `mysql_vacations` |
| `ManagerApprover.php` | `mysql_vacations` |
| `DirectionApprover.php` | `mysql_vacations` |
| `DelegationPermission.php` | `mysql_vacations` |

### Rutas
| Archivo | Contenido |
|---------|-----------|
| `routes/web.php` | Rutas públicas, auth, vacaciones |
| `routes/rrhh.php` | Módulo RRHH, administración |
| `routes/perfil.php` | Perfil de usuario, CV |

### Composers
| Archivo | Propósito |
|---------|-----------|
| `SidebarComposer.php` | Contadores de notificaciones del sidebar |
