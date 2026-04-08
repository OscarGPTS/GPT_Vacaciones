# Flujo Completo del Sistema de Solicitud de Vacaciones

**Última actualización:** 5 de abril de 2026  
**Sistema:** RRHH Satech Energy - Módulo de Vacaciones

---

## 📋 Tabla de Contenidos

1. [Modelo de Datos](#modelo-de-datos)
2. [Fórmulas de Cálculo](#fórmulas-de-cálculo)
3. [Flujo de Aprobación](#flujo-de-aprobación)
4. [Estados de la Base de Datos](#estados-de-la-base-de-datos)
5. [Casos de Prueba](#casos-de-prueba)
6. [Diagramas de Flujo](#diagramas-de-flujo)
7. [Configuración de Aprobadores](#configuración-de-aprobadores)

---

## 1. Modelo de Datos

### 1.1 Tabla `vacations_availables`

Almacena los períodos de vacaciones de cada empleado. Cada registro representa un año de antigüedad.

| Campo | Tipo | Descripción | Ejemplo |
|-------|------|-------------|---------|
| `id` | bigint | ID único del período | 123 |
| `users_id` | bigint | ID del empleado | 13 |
| `period` | int | Año de antigüedad (1-40) | 5 |
| `date_start` | date | Fecha inicio del período | 2024-08-08 |
| `date_end` | date | Fecha fin del período (aniversario) | 2025-08-08 |
| `cutoff_date` | date | Fecha de vencimiento (date_end + 1 año + 3 meses) | 2026-11-08 |
| `days_availables` | decimal(8,2) | **Saldo base fijo** del período (no cambia) | 20.00 |
| `days_enjoyed` | int | Días ya disfrutados acumulados | 5 |
| `days_reserved` | decimal(8,2) | Días reservados en solicitudes pendientes | 3.00 |
| `days_calculated` | decimal(8,2) | Días acumulados por devengamiento diario | 18.52 |
| `is_historical` | boolean | Si es período ya vencido y cerrado | false |
| `status` | varchar | Estado: `actual`, `vencido` | actual |

**Fórmula de saldo disponible:**
```
saldo_disponible = days_availables - days_enjoyed - days_reserved
```

**Ejemplo:**
```
Período 5 de usuario 13:
- days_availables = 20.00  (saldo base del período 5 según LFT)
- days_enjoyed = 5         (ya tomó 5 días)
- days_reserved = 3.00     (tiene solicitud pendiente de 3 días)
- Saldo disponible = 20 - 5 - 3 = 12 días
```

### 1.2 Tabla `requests` (Modelo: RequestVacations)

Almacena las solicitudes de vacaciones con su flujo de aprobación.

| Campo | Tipo | Descripción | Estados Posibles |
|-------|------|-------------|------------------|
| `id` | bigint | ID único de la solicitud | - |
| `user_id` | bigint | Empleado solicitante | - |
| `created_by_user_id` | bigint | Usuario que creó la solicitud (si es en representación) | NULL o user_id |
| `reveal_id` | bigint | Usuario que cubrirá las funciones | - |
| `type_request` | varchar | Tipo de solicitud | `Vacaciones` |
| `start` | datetime | (No usado para vacaciones) | NULL |
| `end` | datetime | (No usado para vacaciones) | NULL |
| `opcion` | varchar | **Formato:** `{period}|{date_start}` | `5|2024-08-08` |
| `reason` | text | Motivo de la solicitud | "Descanso personal" |
| `direct_manager_id` | bigint | **Manager asignado** (ManagerApprover o boss_id) | 45 |
| `direct_manager_status` | varchar | Estado de aprobación del manager | `Pendiente`, `Aprobada`, `Rechazada` |
| `direction_approbation_id` | bigint | **Dirección asignada** (DirectionApprover o job_id=60) | 60 |
| `direction_approbation_status` | varchar | Estado de aprobación de dirección | `Pendiente`, `Aprobada`, `Rechazada` |
| `human_resources_status` | varchar | Estado de aprobación de RH | `Pendiente`, `Aprobada`, `Rechazada` |
| `visible` | boolean | Si la solicitud es visible | true |

### 1.3 Tabla `request_calendars` (Modelo: RequestApproved)

Almacena los días individuales de cada solicitud.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID único del día |
| `requests_id` | bigint | ID de la solicitud (FK) |
| `users_id` | bigint | ID del empleado |
| `start` | datetime | Fecha del día solicitado |
| `end` | datetime | (Mismo que start) |
| `title` | varchar | Descripción |
| `type` | varchar | Tipo de solicitud |

---

## 2. Fórmulas de Cálculo

### 2.1 Saldo Disponible (Para Crear Solicitud)

**Fórmula:**
```php
$saldo_disponible = $periodo->days_availables 
                  - $periodo->days_enjoyed 
                  - $periodo->days_reserved;
```

**Significado:**
- `days_availables`: Saldo base del período según LFT México (12-32 días según antigüedad)
- `days_enjoyed`: Días ya disfrutados y aprobados anteriormente
- `days_reserved`: Días en solicitudes pendientes (reservados temporalmente)

### 2.2 Actualización al Crear Solicitud

Cuando un empleado crea una solicitud con N días:

```php
// RESERVAR los días
$periodo->days_reserved = $periodo->days_reserved + N;
```

**Efecto:** Los días quedan "congelados" y no pueden usarse en otra solicitud hasta que esta se apruebe o rechace.

### 2.3 Actualización al Aprobar Solicitud (RH Final)

Cuando RH aprueba la solicitud con N días:

```php
// 1. LIBERAR la reserva
$periodo->days_reserved = max(0, $periodo->days_reserved - N);

// 2. DESCONTAR definitivamente
$periodo->days_enjoyed = $periodo->days_enjoyed + N;
```

**Efecto:** 
- Los días pasan de "reservados" a "disfrutados"
- `days_availables` NO cambia (es el saldo base fijo)

### 2.4 Actualización al Rechazar Solicitud

Cuando se rechaza en cualquier etapa:

```php
// LIBERAR la reserva (devolver días al saldo)
$periodo->days_reserved = max(0, $periodo->days_reserved - N);
```

**Efecto:** Los días vuelven a estar disponibles para solicitudes futuras.

---

## 3. Flujo de Aprobación

### 3.1 Diagrama General

```
┌─────────────────────────────────────────────────────────────────┐
│                    CREACIÓN DE SOLICITUD                        │
│                      (Usuario Empleado)                         │
│                                                                 │
│  1. Validar antigüedad mínima (1 año)                          │
│  2. Validar días disponibles en período                        │
│  3. Validar anticipación mínima (5 días)                       │
│  4. RESERVAR días en vacations_availables                      │
│  5. Crear registro en requests                                 │
│  6. Crear días individuales en request_calendars               │
│  7. Asignar direct_manager_id (ManagerApprover o boss_id)      │
│  8. Notificar al jefe directo por email                        │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ direct_manager_status = 'Pendiente'
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│              APROBACIÓN NIVEL 1: JEFE DIRECTO                   │
│              (Usuario con direct_manager_id)                    │
│                                                                 │
│  OPCIÓN A: APROBAR                                              │
│  - Cambiar direct_manager_status = 'Aprobada'                  │
│  - Asignar direction_approbation_id                            │
│    (DirectionApprover o job_id=60)                             │
│  - Cambiar direction_approbation_status = 'Pendiente'          │
│  - Notificar a dirección por email                             │
│                                                                 │
│  OPCIÓN B: RECHAZAR                                             │
│  - Cambiar direct_manager_status = 'Rechazada'                 │
│  - LIBERAR días reservados (days_reserved -= N)                │
│  - Mover días a request_rejected                               │
│  - Notificar empleado por email                                │
│  - FIN DEL FLUJO ❌                                             │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ APROBADA
                         │ direction_approbation_status = 'Pendiente'
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│         APROBACIÓN NIVEL 2: DIRECCIÓN (OPCIONAL)                │
│         (Usuario con direction_approbation_id)                  │
│                                                                 │
│  NOTA: En el código actual, el frontend NO implementa este     │
│        paso explícitamente. Las solicitudes pasan directamente │
│        de Manager a RH. Sin embargo, la estructura de DB está  │
│        preparada para este nivel.                              │
│                                                                 │
│  OPCIÓN A: APROBAR                                              │
│  - Cambiar direction_approbation_status = 'Aprobada'           │
│  - Solicitud queda lista para RH                               │
│                                                                 │
│  OPCIÓN B: RECHAZAR                                             │
│  - Cambiar direction_approbation_status = 'Rechazada'          │
│  - LIBERAR días reservados                                     │
│  - FIN DEL FLUJO ❌                                             │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ APROBADA (o directo desde Manager)
                         │ human_resources_status = 'Pendiente'
                         ▼
┌─────────────────────────────────────────────────────────────────┐
│        APROBACIÓN NIVEL 3: RECURSOS HUMANOS (FINAL)             │
│        (Usuarios con permiso 'ver modulo rrhh')                 │
│                                                                 │
│  OPCIÓN A: APROBAR ✅                                           │
│  - Cambiar human_resources_status = 'Aprobada'                 │
│  - LIBERAR días reservados (days_reserved -= N)                │
│  - DESCONTAR días definitivamente (days_enjoyed += N)          │
│  - Notificar empleado por email                                │
│  - FIN DEL FLUJO (EXITOSO) ✅                                   │
│                                                                 │
│  OPCIÓN B: RECHAZAR ❌                                          │
│  - Cambiar human_resources_status = 'Rechazada'                │
│  - LIBERAR días reservados (days_reserved -= N)                │
│  - Mover días a request_rejected                               │
│  - Notificar empleado por email                                │
│  - FIN DEL FLUJO (RECHAZADO) ❌                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 3.2 Sistema de Auto-Aprobación

**Servicio:** `AutoApprovalService`  
**Comando:** `php artisan vacations:auto-approve`  
**Programación:** Diario a las 9:00 AM

**Lógica:**
- Busca solicitudes con `direct_manager_status = 'Pendiente'` creadas hace más de 5 días
- Las aprueba automáticamente
- Asigna `direction_approbation_id` y avanza al siguiente nivel

**Código ejecutado:**
```php
$requestVacation->update([
    'direct_manager_status' => 'Aprobada',
    'direction_approbation_status' => 'Pendiente',
    'direction_approbation_id' => $directionApproverId
]);
```

---

## 4. Estados de la Base de Datos

### 4.1 Estado Inicial (Usuario 13, Período 5)

**Tabla: `vacations_availables`**

```sql
SELECT * FROM vacations_availables WHERE users_id = 13 AND period = 5;
```

| Campo | Valor |
|-------|-------|
| id | 567 |
| users_id | 13 |
| period | 5 |
| date_start | 2024-08-08 |
| date_end | 2025-08-08 |
| days_availables | **20.00** |
| days_enjoyed | **3** |
| days_reserved | **0.00** |
| is_historical | 0 |
| status | actual |

**Saldo disponible:** `20 - 3 - 0 = 17 días`

---

### 4.2 Usuario Crea Solicitud de 5 Días

**Acción:** Usuario 13 solicita 5 días de vacaciones del 15-19 de abril de 2026

**Archivos involucrados:**
- `app/Http/Controllers/VacacionesController.php::store()`

**Cambios en DB:**

**1. Tabla `requests` (nueva fila):**

```sql
INSERT INTO requests VALUES (
    id: 890,
    user_id: 13,
    created_by_user_id: NULL,
    reveal_id: 25,
    type_request: 'Vacaciones',
    opcion: '5|2024-08-08',
    direct_manager_id: 45,  -- Asignado desde ManagerApprover o boss_id
    direct_manager_status: 'Pendiente',
    direction_approbation_id: NULL,
    direction_approbation_status: NULL,
    human_resources_status: 'Pendiente',
    created_at: '2026-04-05 10:30:00'
);
```

**2. Tabla `request_calendars` (5 filas nuevas):**

```sql
INSERT INTO request_calendars VALUES
    (id: 1001, requests_id: 890, users_id: 13, start: '2026-04-15 00:00:00'),
    (id: 1002, requests_id: 890, users_id: 13, start: '2026-04-16 00:00:00'),
    (id: 1003, requests_id: 890, users_id: 13, start: '2026-04-17 00:00:00'),
    (id: 1004, requests_id: 890, users_id: 13, start: '2026-04-18 00:00:00'),
    (id: 1005, requests_id: 890, users_id: 13, start: '2026-04-19 00:00:00');
```

**3. Tabla `vacations_availables` (UPDATE):**

```sql
UPDATE vacations_availables 
SET days_reserved = days_reserved + 5  -- 0 + 5 = 5
WHERE users_id = 13 AND period = 5;
```

**Estado después:**

| Campo | Antes | Después |
|-------|-------|---------|
| days_availables | 20.00 | 20.00 ✅ (sin cambio) |
| days_enjoyed | 3 | 3 ✅ (sin cambio) |
| days_reserved | 0.00 | **5.00** ⬆️ (+5) |

**Saldo disponible:** `20 - 3 - 5 = 12 días` ⬇️

---

### 4.3 Manager Aprueba Solicitud

**Acción:** Usuario 45 (jefe directo) aprueba la solicitud 890

**Archivos involucrados:**
- `app/Http/Controllers/RequestController.php::approveRejectManager()`

**Cambios en DB:**

**1. Tabla `requests` (UPDATE):**

```sql
UPDATE requests 
SET 
    direct_manager_status = 'Aprobada',
    direction_approbation_id = 60,  -- Usuario con job_id=60 o DirectionApprover
    direction_approbation_status = 'Pendiente'
WHERE id = 890;
```

**Estado después:**

| Campo | Estado |
|-------|--------|
| direct_manager_status | **'Aprobada'** ✅ |
| direction_approbation_id | **60** |
| direction_approbation_status | **'Pendiente'** |
| human_resources_status | 'Pendiente' |

**2. Tabla `vacations_availables`:**

❌ **SIN CAMBIOS** - Los días siguen reservados

| Campo | Valor |
|-------|-------|
| days_reserved | 5.00 (sin cambio) |

---

### 4.4 RH Aprueba Solicitud (FINAL)

**Acción:** Usuario con rol RH aprueba la solicitud 890

**Archivos involucrados:**
- `app/Livewire/VacacionesRh.php::approveRequest()`

**Cambios en DB:**

**1. Tabla `requests` (UPDATE):**

```sql
UPDATE requests 
SET human_resources_status = 'Aprobada'
WHERE id = 890;
```

**2. Tabla `vacations_availables` (UPDATE - LO MÁS IMPORTANTE):**

```sql
UPDATE vacations_availables 
SET 
    days_reserved = days_reserved - 5,  -- 5 - 5 = 0 (liberar reserva)
    days_enjoyed = days_enjoyed + 5     -- 3 + 5 = 8 (descontar definitivo)
WHERE users_id = 13 AND period = 5 AND date_start = '2024-08-08';
```

**Estado después:**

| Campo | Antes | Después | Explicación |
|-------|-------|---------|-------------|
| days_availables | 20.00 | 20.00 ✅ | **Saldo base NUNCA cambia** |
| days_enjoyed | 3 | **8** ⬆️ | +5 días descontados |
| days_reserved | 5.00 | **0.00** ⬇️ | Reserva liberada |

**Saldo disponible final:** `20 - 8 - 0 = 12 días` ✅

---

### 4.5 Escenario: Manager Rechaza Solicitud

**Acción:** Usuario 45 (jefe directo) RECHAZA la solicitud 890

**Archivos involucrados:**
- `app/Http/Controllers/RequestController.php::approveRejectManager()`

**Cambios en DB:**

**1. Tabla `requests` (UPDATE):**

```sql
UPDATE requests 
SET direct_manager_status = 'Rechazada'
WHERE id = 890;
```

**2. Tabla `vacations_availables` (UPDATE - LIBERAR RESERVA):**

```sql
UPDATE vacations_availables 
SET days_reserved = days_reserved - 5  -- 5 - 5 = 0
WHERE users_id = 13 AND period = 5;
```

**Estado después:**

| Campo | Antes | Después | Explicación |
|-------|-------|---------|-------------|
| days_availables | 20.00 | 20.00 ✅ | Sin cambio |
| days_enjoyed | 3 | 3 ✅ | **NO se descuentan días** |
| days_reserved | 5.00 | **0.00** ⬇️ | Reserva liberada |

**Saldo disponible:** `20 - 3 - 0 = 17 días` ✅ (vuelve al estado inicial)

---

## 5. Casos de Prueba

### Caso 1: Flujo Exitoso Completo

**Usuario:** Juan García (ID: 13)  
**Período:** 5 (20 días totales)  
**Estado inicial:** 3 días disfrutados, 0 reservados  
**Solicitud:** 5 días (15-19 abril 2026)

**Paso 1: Creación de Solicitud**

```php
// Código: VacacionesController::store()

// Validaciones previas
✅ Antigüedad: 5 años (cumple >= 1 año)
✅ Días disponibles: 20 - 3 - 0 = 17 días (cumple >= 5)
✅ Anticipación: 10 días antes (cumple >= 5)

// DB Changes
INSERT INTO requests (id: 890, user_id: 13, direct_manager_id: 45, ...)
INSERT INTO request_calendars (5 filas para días individuales)
UPDATE vacations_availables SET days_reserved = 5 WHERE period = 5
```

**Estado DB:**
- `requests.direct_manager_status` = `Pendiente`
- `vacations_availables.days_reserved` = 5
- Saldo: 20 - 3 - 5 = **12 días disponibles**

**Paso 2: Aprobación Manager**

```php
// Código: RequestController::approveRejectManager()

// Usuario 45 aprueba
UPDATE requests SET 
    direct_manager_status = 'Aprobada',
    direction_approbation_id = 60,
    direction_approbation_status = 'Pendiente'
WHERE id = 890
```

**Estado DB:**
- `requests.direct_manager_status` = `Aprobada`
- `vacations_availables.days_reserved` = 5 (sin cambio)
- Saldo: **12 días** (sin cambio)

**Paso 3: Aprobación RH (Final)**

```php
// Código: VacacionesRh::approveRequest()

// Usuario con rol RH aprueba
UPDATE requests SET human_resources_status = 'Aprobada'
UPDATE vacations_availables SET 
    days_reserved = 0,      -- Liberar reserva
    days_enjoyed = 8        -- Descontar definitivo
WHERE period = 5
```

**Estado DB Final:**
- `requests.human_resources_status` = `Aprobada` ✅
- `vacations_availables.days_enjoyed` = 8
- `vacations_availables.days_reserved` = 0
- Saldo: 20 - 8 - 0 = **12 días disponibles** ✅

---

### Caso 2: Rechazo por Manager

**Usuario:** María López (ID: 25)  
**Período:** 3 (16 días totales)  
**Estado inicial:** 2 días disfrutados, 0 reservados  
**Solicitud:** 7 días (20-26 abril 2026)

**Paso 1: Creación**

```
✅ Solicitud creada (ID: 891)
✅ days_reserved = 7
✅ Saldo: 16 - 2 - 7 = 7 días
```

**Paso 2: Manager RECHAZA**

```php
// Código: RequestController::approveRejectManager()

UPDATE requests SET direct_manager_status = 'Rechazada'

// LIBERAR días reservados
UPDATE vacations_availables SET days_reserved = 0
```

**Estado DB Final:**
- `requests.direct_manager_status` = `Rechazada` ❌
- `vacations_availables.days_enjoyed` = 2 (sin cambio)
- `vacations_availables.days_reserved` = 0 (liberado)
- Saldo: 16 - 2 - 0 = **14 días disponibles** ✅ (volvió al estado inicial)

---

### Caso 3: Días Insuficientes

**Usuario:** Pedro Ramírez (ID: 52)  
**Período:** 1 (12 días totales)  
**Estado inicial:** 8 días disfrutados, 3 reservados  
**Solicitud:** 5 días (25-29 abril 2026)

**Validación en Creación:**

```php
// Código: VacacionesController::store()

$diasDisponibles = 12 - 8 - 3 = 1 día
$diasSolicitados = 5

if ($diasDisponibles < $diasSolicitados) {
    return back()->with('error', 
        "El período seleccionado solo tiene 1 días disponibles. Solicitados: 5"
    );
}
```

**Resultado:**
- ❌ Solicitud NO creada
- ❌ Sin cambios en DB
- ❌ Usuario recibe mensaje de error

---

### Caso 4: Múltiples Períodos Disponibles

**Usuario:** Ana Torres (ID: 33)  
**Períodos disponibles:**

| Período | Total | Disfrutados | Reservados | Disponible |
|---------|-------|-------------|------------|------------|
| 7 | 22 | 5 | 0 | **17 días** |
| 8 | 22 | 0 | 0 | **22 días** |

**Solicitud 1:** 10 días del período 7

```
✅ Solicitud creada, days_reserved = 10 en período 7
✅ Saldo período 7: 22 - 5 - 10 = 7 días
```

**Solicitud 2:** 15 días del período 8 (mientras solicitud 1 está pendiente)

```
✅ Solicitud creada, days_reserved = 15 en período 8
✅ Saldo período 8: 22 - 0 - 15 = 7 días
✅ Ambas solicitudes coexisten con reservas independientes
```

**Aprobación RH de Solicitud 1:**

```
✅ Período 7: days_enjoyed = 15, days_reserved = 0
✅ Período 8: Sin cambios (days_reserved = 15)
```

---

### Caso 5: Auto-Aprobación (5 Días Sin Respuesta)

**Usuario:** Carlos Méndez (ID: 18)  
**Solicitud creada:** 1 de abril de 2026, 08:00 AM  
**Comando auto-approval:** 6 de abril de 2026, 09:00 AM (cron diario)

**Estado Inicial (1 abril):**

```
requests.id = 892
direct_manager_status = 'Pendiente'
created_at = '2026-04-01 08:00:00'
```

**Ejecución Auto-Aprobación (6 abril):**

```php
// Código: AutoApprovalService::processAutoApprovals()

// Búsqueda de solicitudes >= 5 días
$requests = RequestVacations::where('direct_manager_status', 'Pendiente')
    ->where('created_at', '<=', now()->subDays(5))
    ->get();

// Aprobación automática
foreach ($requests as $request) {
    $request->update([
        'direct_manager_status' => 'Aprobada',
        'direction_approbation_status' => 'Pendiente',
        'direction_approbation_id' => 60
    ]);
}
```

**Estado Final:**
- `direct_manager_status` = `Aprobada` ✅ (auto-aprobada)
- `direction_approbation_status` = `Pendiente`
- ⏰ Aprobación automática después de 5 días

---

### Caso 6: Solicitud en Representación (Usuario RH)

**Usuario solicitante:** Empleado nuevo sin acceso (ID: 100)  
**Creador:** Usuario RH (ID: 5)  
**Período:** 1 (12 días totales)  
**Solicitud:** 6 días

**Paso 1: Creación por RH**

```php
// Código: VacacionesController::store()

$targetUserId = $request->behalf_user_id; // 100
$createdByUserId = auth()->id(); // 5

INSERT INTO requests (
    user_id: 100,
    created_by_user_id: 5,  -- Quién creó la solicitud
    direct_manager_id: 45,  -- Manager del empleado 100
    ...
)
```

**Flujo normal:**
- ✅ Solicitud se crea para usuario 100
- ✅ Aprobaciones las hace el manager del usuario 100 (no del creador)
- ✅ Días se descuentan del períodoodel usuario 100

---

## 6. Diagramas de Flujo

### 6.1 Creación de Solicitud (Detallado)

```
START
  │
  ├─> Usuario selecciona período
  │
  ├─> Usuario selecciona días en calendario
  │   (Almacenado temporalmente en request_calendars sin requests_id)
  │
  ├─> Usuario envía formulario
  │
  ├─> VALIDACIÓN 1: ¿Antigüedad >= 1 año?
  │   ├─ NO ──> ERROR: "Debes tener al menos 1 año de antigüedad"
  │   └─ SÍ ──> Continuar
  │
  ├─> VALIDACIÓN 2: ¿Días seleccionados > 0?
  │   ├─ NO ──> ERROR: "Debes seleccionar al menos un día"
  │   └─ SÍ ──> Continuar
  │
  ├─> VALIDACIÓN 3: ¿Días seleccionados <= 32?
  │   ├─ NO ──> ERROR: "No puedes solicitar más de 32 días"
  │   └─ SÍ ──> Continuar
  │
  ├─> VALIDACIÓN 4: ¿Anticipación >= 5 días?
  │   ├─ NO ──> ERROR: "Debes solicitar con al menos 5 días de anticipación"
  │   └─ SÍ ──> Continuar
  │
  ├─> VALIDACIÓN 5: ¿Días disponibles en período >= días solicitados?
  │   │   (Considerando days_reserved de solicitudes pendientes)
  │   ├─ NO ──> ERROR: "El período solo tiene X días disponibles"
  │   └─ SÍ ──> Continuar
  │
  ├─> VALIDACIÓN 6: ¿Usuario tiene jefe directo asignado?
  │   │   (Buscar en ManagerApprover o boss_id)
  │   ├─ NO ──> ERROR: "No tienes un jefe directo asignado"
  │   └─ SÍ ──> Continuar
  │
  ├─> RESERVAR días en vacations_availables
  │   UPDATE days_reserved = days_reserved + N
  │
  ├─> CREAR registro en requests
  │   - Asignar direct_manager_id
  │   - Estado: direct_manager_status = 'Pendiente'
  │   - Guardar período en campo 'opcion'
  │
  ├─> ACTUALIZAR días en request_calendars
  │   UPDATE SET requests_id = [nueva_solicitud_id]
  │
  ├─> ENVIAR email a jefe directo
  │
  └─> SUCCESS ✅
```

### 6.2 Aprobación por Manager

```
START (Manager recibe notificación)
  │
  ├─> Manager accede a /vacaciones/autorizar
  │   (Solo ve solicitudes donde direct_manager_id = auth()->id())
  │
  ├─> Manager revisa detalles de solicitud
  │
  ├─> Manager decide
  │   │
  │   ├─> OPCIÓN A: APROBAR
  │   │   │
  │   │   ├─> UPDATE requests
  │   │   │   SET direct_manager_status = 'Aprobada'
  │   │   │
  │   │   ├─> ASIGNAR aprobador de dirección
  │   │   │   - Buscar DirectionApprover para departamento
  │   │   │   - Fallback: Usuario con job_id = 60
  │   │   │   - UPDATE direction_approbation_id
  │   │   │   - UPDATE direction_approbation_status = 'Pendiente'
  │   │   │
  │   │   ├─> ENVIAR email a dirección
  │   │   │
  │   │   └─> SUCCESS: "Solicitud aprobada, enviada a Dirección"
  │   │
  │   └─> OPCIÓN B: RECHAZAR
  │       │
  │       ├─> UPDATE requests
  │       │   SET direct_manager_status = 'Rechazada'
  │       │
  │       ├─> LIBERAR días reservados
  │       │   UPDATE vacations_availables
  │       │   SET days_reserved = days_reserved - N
  │       │
  │       ├─> MOVER días a request_rejected
  │       │
  │       ├─> ENVIAR email a empleado
  │       │
  │       └─> SUCCESS: "Solicitud rechazada"
  │
END
```

### 6.3 Aprobación Final por RH

```
START (RH accede a panel)
  │
  ├─> Livewire Component: VacacionesRh
  │   (Solo ve solicitudes con human_resources_status = 'Pendiente')
  │
  ├─> RH revisa detalles
  │
  ├─> RH decide
  │   │
  │   ├─> OPCIÓN A: APROBAR
  │   │   │
  │   │   ├─> VALIDAR: ¿Período existe y es válido?
  │   │   │   ├─ NO ──> ERROR
  │   │   │   └─ SÍ ──> Continuar
  │   │   │
  │   │   ├─> VALIDAR: ¿Días suficientes en período?
  │   │   │   (days_availables - days_enjoyed >= N)
  │   │   │   ├─ NO ──> ERROR
  │   │   │   └─ SÍ ──> Continuar
  │   │   │
  │   │   ├─> UPDATE requests
  │   │   │   SET human_resources_status = 'Aprobada'
  │   │   │
  │   │   ├─> UPDATE vacations_availables
  │   │   │   SET days_reserved = days_reserved - N  (liberar)
  │   │   │   SET days_enjoyed = days_enjoyed + N    (descontar)
  │   │   │
  │   │   ├─> ENVIAR email a empleado
  │   │   │
  │   │   └─> SUCCESS ✅: "Solicitud aprobada, días descontados"
  │   │
  │   └─> OPCIÓN B: RECHAZAR
  │       │
  │       ├─> UPDATE requests
  │       │   SET human_resources_status = 'Rechazada'
  │       │
  │       ├─> LIBERAR días reservados
  │       │   UPDATE vacations_availables
  │       │   SET days_reserved = days_reserved - N
  │       │
  │       ├─> ENVIAR email a empleado
  │       │
  │       └─> SUCCESS: "Solicitud rechazada"
  │
END
```

---

## 7. Configuración de Aprobadores

### 7.1 Tabla `manager_approvers`

Permite configurar jefes directos personalizados por departamento, sobrescribiendo el `boss_id` del usuario.

| Campo | Descripción |
|-------|-------------|
| `id` | ID único |
| `user_id` | Usuario que será el jefe directo (aprobador) |
| `departamento_id` | Departamento para el cual aplica |
| `is_active` | Si está activo |

**Ejemplo:**

```sql
INSERT INTO manager_approvers VALUES
    (1, 45, 10, 1);  -- Usuario 45 aprueba solicitudes del depto 10
```

**Lógica de asignación en creación:**

```php
// 1. Verificar si hay jefe personalizado para el departamento
$customManagerId = ManagerApprover::getManagerForDepartment($user->job->depto_id);

// 2. Si existe, usar el personalizado. Sino, usar boss_id
$directManagerId = $customManagerId ?? $user->boss_id;

// 3. Asignar a la solicitud
$request->direct_manager_id = $directManagerId;
```

### 7.2 Tabla `direction_approvers`

Permite configurar aprobadores de dirección personalizados por departamento, sobrescribiendo el `job_id = 60`.

| Campo | Descripción |
|-------|-------------|
| `id` | ID único |
| `user_id` | Usuario que será el aprobador de dirección |
| `departamento_id` | Departamento para el cual aplica |
| `is_active` | Si está activo |

**Ejemplo:**

```sql
INSERT INTO direction_approvers VALUES
    (1, 60, 10, 1);  -- Usuario 60 aprueba solicitudes del depto 10
```

**Lógica de asignación en aprobación manager:**

```php
// 1. Verificar si hay aprobador de dirección para el departamento
$customDirectionId = DirectionApprover::getDirectionApproverForDepartment($depto_id);

// 2. Si existe, usar el personalizado. Sino, buscar job_id = 60
$directionApproverId = $customDirectionId ?? User::where('job_id', 60)->first()?->id;

// 3. Asignar a la solicitud
$request->direction_approbation_id = $directionApproverId;
```

---

## 8. Archivos Relevantes del Código

### Controladores

| Archivo | Métodos Clave | Descripción |
|---------|---------------|-------------|
| `VacacionesController.php` | `store()` | Creación de solicitudes |
| `RequestController.php` | `approveRejectManager()` | Aprobación/rechazo por manager |
| `RequestController.php` | `releaseReservedDays()` | Liberar días reservados |

### Componentes Livewire

| Archivo | Métodos Clave | Descripción |
|---------|---------------|-------------|
| `VacacionesRh.php` | `approveRequest()` | Aprobación final por RH |
| `VacacionesRh.php` | `rejectRequest()` | Rechazo final por RH |

### Servicios

| Archivo | Métodos Clave | Descripción |
|---------|---------------|-------------|
| `AutoApprovalService.php` | `processAutoApprovals()` | Auto-aprobación después de 5 días |

### Modelos

| Archivo | Descripción |
|---------|-------------|
| `RequestVacations.php` | Modelo de solicitudes |
| `VacationsAvailable.php` | Modelo de períodos de vacaciones |
| `ManagerApprover.php` | Jefes directos personalizados |
| `DirectionApprover.php` | Aprobadores de dirección personalizados |

---

## 9. Queries SQL Útiles para Testing

### Ver estado de períodos de un usuario

```sql
SELECT 
    period,
    date_start,
    date_end,
    days_availables,
    days_enjoyed,
    days_reserved,
    (days_availables - days_enjoyed - days_reserved) AS saldo_disponible,
    status
FROM vacations_availables
WHERE users_id = 13
ORDER BY period;
```

### Ver solicitudes pendientes de aprobación

```sql
SELECT 
    r.id,
    u.first_name,
    u.last_name,
    r.direct_manager_status,
    r.direction_approbation_status,
    r.human_resources_status,
    r.opcion AS periodo,
    COUNT(rc.id) AS dias_solicitados
FROM requests r
JOIN users u ON r.user_id = u.id
LEFT JOIN request_calendars rc ON r.id = rc.requests_id
WHERE r.human_resources_status = 'Pendiente'
GROUP BY r.id;
```

### Ver historial de días de un período

```sql
SELECT 
    'Inicial' AS momento,
    NULL AS request_id,
    20 AS days_availables,
    0 AS days_enjoyed,
    0 AS days_reserved,
    20 AS saldo
UNION ALL
SELECT 
    'Después creación',
    890,
    20,
    0,
    5,
    15
UNION ALL
SELECT 
    'Después aprobación RH',
    890,
    20,
    5,
    0,
    15;
```

---

## 10. Troubleshooting

### Problema: Días reservados no se liberan al rechazar

**Síntoma:** Después de rechazar una solicitud, `days_reserved` sigue con el valor anterior.

**Causa:** El método `releaseReservedDays()` no se está llamando o el campo `opcion` está vacío.

**Solución:**

```php
// Verificar que se llama al método
if ($request->action === 'rechazar') {
    $this->releaseReservedDays($requestVacation);
}

// Verificar que opcion tiene formato correcto
Log::info('opcion:', ['value' => $requestVacation->opcion]);
// Debe ser: "5|2024-08-08"
```

### Problema: Usuario no tiene jefe directo asignado

**Síntoma:** Error al crear solicitud: "No tienes un jefe directo asignado"

**Causa:** El usuario no tiene `boss_id` ni hay `ManagerApprover` para su departamento.

**Solución:**

```sql
-- Opción 1: Asignar boss_id al usuario
UPDATE users SET boss_id = 45 WHERE id = 13;

-- Opción 2: Crear ManagerApprover para el departamento
INSERT INTO manager_approvers (user_id, departamento_id, is_active)
VALUES (45, 10, 1);  -- Usuario 45 aprueba depto 10
```

### Problema: RH no puede aprobar (error de período no encontrado)

**Síntoma:** Error al aprobar: "No se encontró el período de vacaciones especificado"

**Causa:** El campo `opcion` tiene formato incorrecto o el período fue eliminado.

**Diagnóstico:**

```sql
-- Ver el campo opcion
SELECT id, user_id, opcion FROM requests WHERE id = 890;
-- Debe ser: "5|2024-08-08"

-- Verificar que el período existe
SELECT * FROM vacations_availables 
WHERE users_id = 13 
AND period = 5 
AND date_start = '2024-08-08'
AND is_historical = 0;
```

---

## 11. Resumen de Reglas de Negocio

### ✅ Validaciones de Creación

1. **Antigüedad mínima:** 1 año desde `admission`
2. **Días por solicitud:** Mínimo 1, máximo 32
3. **Anticipación:** Mínimo 5 días antes del inicio
4. **Días disponibles:** Debe haber saldo suficiente (considerando reservados)
5. **Jefe directo:** El usuario debe tener manager asignado

### 🔒 Reserva de Días

- Al crear solicitud: `days_reserved += N`
- Al aprobar (RH): `days_reserved -= N` y `days_enjoyed += N`
- Al rechazar: `days_reserved -= N`

### 📊 Cálculo de Saldo

```
Saldo Disponible = days_availables - days_enjoyed - days_reserved
```

- `days_availables`: **Nunca cambia** (saldo base del período)
- `days_enjoyed`: **Solo aumenta** (al aprobar vacaciones)
- `days_reserved`: **Sube y baja** (crear/aprobar/rechazar)

### ⏰ Auto-Aprobación

- Después de **5 días** sin respuesta del manager
- Se ejecuta diariamente a las **9:00 AM**
- Solo aprueba nivel manager, pasa a dirección/RH

---

**Fin del documento**
