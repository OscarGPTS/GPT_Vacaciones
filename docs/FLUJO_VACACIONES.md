# Flujo de Solicitud de Vacaciones

**Última actualización:** Abril 2026

---

## 1. Flujo de Aprobación

```
Empleado crea solicitud
    │
    ▼
NIVEL 1: Jefe Directo (direct_manager_id)
    │ Aprueba → asigna direction_approbation_id
    │ Rechaza → libera días reservados → FIN ❌
    ▼
NIVEL 2: Dirección (direction_approbation_id)
    │ Aprueba → pasa a RH
    │ Rechaza → libera días reservados → FIN ❌
    ▼
NIVEL 3: Recursos Humanos (permiso 'ver modulo rrhh')
    │ Aprueba → descuenta días definitivamente → FIN ✅
    │ Rechaza → libera días reservados → FIN ❌
```

---

## 2. Validaciones de Creación

1. **Antigüedad mínima:** 1 año desde `admission`
2. **Días por solicitud:** Mínimo 1, máximo 32
3. **Anticipación:** Mínimo 5 días antes del inicio
4. **Saldo suficiente:** `days_availables - days_enjoyed - days_reserved >= días solicitados`
5. **Jefe directo asignado:** Busca en `ManagerApprover` → fallback a `boss_id`
6. **Delegación autorizada:** Si es en representación, valida `DelegationPermission`

---

## 3. Manejo de Días (Reserva, Descuento, Liberación)

### Al crear solicitud
```php
$periodo->days_reserved += N;  // Reservar días
```

### Al aprobar (RH - final)
```php
$periodo->days_reserved -= N;  // Liberar reserva
$periodo->days_enjoyed += N;   // Descontar definitivamente
```

### Al rechazar (cualquier nivel)
```php
$periodo->days_reserved -= N;  // Devolver días al saldo
```

> `days_availables` **nunca cambia** — es el saldo base fijo del período según LFT.

---

## 4. Configuración de Aprobadores

### Jefes Directos (`manager_approvers`)

Sobrescribe el `boss_id` del usuario para la asignación de aprobador.

```php
// Al crear solicitud:
$customManagerId = ManagerApprover::getManagerForUser($targetUserId);
$directManagerId = $customManagerId ?? $targetUser->boss_id;
```

### Aprobadores de Dirección (`direction_approvers`)

Sobrescribe la búsqueda por `job_id=60` en la asignación de dirección.

```php
// Al aprobar el manager:
$customDirectionId = DirectionApprover::getDirectionApproverForUser($employeeId);
$directionId = $customDirectionId ?? User::where('job_id', 60)->first()?->id;
```

### Permisos de Delegación (`delegation_permissions`)

Controla quién puede crear solicitudes en representación de otro empleado.

```php
// Al mostrar checkbox de "en representación":
$canDelegate = DelegationPermission::hasPermission(auth()->id());
```

> **Regla crítica:** Siempre filtrar solicitudes por ID asignado exacto (`WHERE direct_manager_id = auth()->id()`), nunca por departamento.

---

## 5. Sistema de Auto-Aprobación

**Servicio:** `AutoApprovalService::processAutoApprovals()`  
**Comando:** `php artisan vacations:auto-approve`  
**Programación:** Diario a las 9:00 AM

### Lógica
- Busca solicitudes con `direct_manager_status = 'Pendiente'` creadas hace > 5 días
- Las aprueba automáticamente y asigna `direction_approbation_id`
- **Auto-aprobación RH:** Intencionalmente desactivada

### Opciones del comando
```bash
php artisan vacations:auto-approve              # Ejecutar
php artisan vacations:auto-approve --dry-run     # Simulación (sin cambios reales)
php artisan vacations:auto-approve --stats        # Ver estadísticas
```

### Ejecución manual desde Livewire
El componente `VacacionesRh` permite disparar manualmente el proceso.

---

## 6. Vencimiento de Períodos

**Regla:** Los períodos vencen **15 meses después de `date_end`**.

```
Fecha vencimiento = date_end + 15 meses
```

**Comando:** `php artisan vacations:check-expired`  
**Programación:** Diario a las 00:30 AM

### Efecto
- `status` cambia a `'vencido'`
- El período ya no se puede usar para solicitudes
- `getAvailableDaysForUser()` excluye períodos vencidos

### Opciones
```bash
php artisan vacations:check-expired --dry-run    # Simulación
php artisan vacations:check-expired --stats       # Estadísticas
```

---

## 7. Notificaciones por Email

| Evento | Destinatario | Clase Mail |
|--------|-------------|------------|
| Solicitud creada | Jefe directo | `VacationRequestCreated` |
| Manager rechaza | Empleado | `VacationRequestRejectedByManager` |
| Manager aprueba | Usuarios RH | `VacationRequestPendingRH` |
| RH aprueba | Empleado | `VacationRequestApprovedByRH` |
| RH rechaza | Empleado | `VacationRequestRejectedByRH` |

**Configuración:**
- Clases en `app/Mail/`
- Templates en `resources/views/emails/vacations/`
- IDs de usuarios RH en `config/vacations.php`
- Todos los envíos están en `try-catch` (no bloquean el flujo)

---

## 8. Validación de Días Disfrutados

**Regla:** `días_disfrutados <= días_disponibles`

### Nivel 1: Importación Excel
```php
// En VacationImport.php - al parsear cada fila
if ($diasDisfrutados > $diasDisponibles) {
    $record['validation_error'] = "Los días disfrutados ($diasDisfrutados) no pueden ser mayores...";
}
```

### Nivel 2: Guardado en BD
```php
// En VacationImport.php - al guardar
if ($daysEnjoyed > $daysAvailables) {
    throw new \Exception("Validación fallida...");
}
```

### Nivel 3: Edición Manual
```php
// En RequestController.php - edición inline
// Permite: days_enjoyed <= (days_availables + dv)
// DV = días de variación adicionales asignados por RH
```

---

## 9. Campos `days_calculated` vs `days_availables`

| Campo | Fuente | Propósito |
|-------|--------|-----------|
| `days_availables` | Importación Excel / creación manual | Saldo base fijo del período |
| `days_calculated` | Cálculo diario automático del sistema | Días devengados acumulados |

- El sistema actualiza `days_calculated` diariamente via `VacationDailyAccumulatorService`
- Al aprobar vacaciones, se descuentan de **ambos** campos
- No se deben confundir: uno es el saldo oficial, otro es el cálculo del sistema

---

## 10. Estados de la Base de Datos (Ejemplo)

### Estado inicial
```
Período 5, Usuario 13:
days_availables=20, days_enjoyed=3, days_reserved=0
Saldo: 20 - 3 - 0 = 17 días
```

### Después de crear solicitud (5 días)
```
days_reserved=5 → Saldo: 20 - 3 - 5 = 12 días
```

### Manager aprueba
```
Sin cambios en vacations_availables (días siguen reservados)
```

### RH aprueba (final)
```
days_reserved=0, days_enjoyed=8 → Saldo: 20 - 8 - 0 = 12 días ✅
```

### Si se rechaza (cualquier nivel)
```
days_reserved=0 → Saldo vuelve a: 20 - 3 - 0 = 17 días
```

---

## 11. Archivos del Flujo

| Paso | Archivo | Método |
|------|---------|--------|
| Creación | `VacacionesController.php` | `store()` |
| Aprobación Manager | `RequestController.php` | `approveRejectManager()` |
| Aprobación RH | `VacacionesRh.php` (Livewire) | `approveRequest()` |
| Rechazo (liberar días) | `RequestController.php` | `releaseReservedDays()` |
| Auto-aprobación | `AutoApprovalService.php` | `processAutoApprovals()` |
| Vencimiento | `CheckExpiredPeriodsCommand` | `handle()` |

---

## 12. Queries SQL Útiles

### Saldo de períodos de un usuario
```sql
SELECT period, date_start, date_end, days_availables, days_enjoyed, days_reserved,
       (days_availables - days_enjoyed - days_reserved) AS saldo, status
FROM vacations_availables WHERE users_id = 13 ORDER BY period;
```

### Solicitudes pendientes
```sql
SELECT r.id, CONCAT(u.first_name, ' ', u.last_name) AS empleado,
       r.direct_manager_status, r.human_resources_status,
       COUNT(rc.id) AS dias
FROM requests r
JOIN rh.users u ON r.user_id = u.id
LEFT JOIN request_approved rc ON r.id = rc.requests_id
WHERE r.human_resources_status = 'Pendiente'
GROUP BY r.id;
```
