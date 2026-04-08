# Prueba de Separación de Días por Fecha de Aniversario

## Propósito

Validar que cuando RH aprueba una solicitud de vacaciones, los días se clasifican correctamente en:
- `days_enjoyed_before_anniversary`: Días tomados dentro del período (antes o en la fecha de aniversario)
- `days_enjoyed_after_anniversary`: Días tomados después de la fecha de aniversario

## Escenario de Prueba

### Datos de Ejemplo

**Usuario:** Juan García (ID: 13)  
**Período 5:**
- `date_start`: 2024-08-08 (inicio del período)
- `date_end`: 2025-08-08 (fecha de aniversario)
- `cutoff_date`: 2026-11-08 (vencimiento 15 meses después)

**Solicitud de vacaciones:**
- Días solicitados: 10 días
- Fechas:
  - 6 días antes del aniversario (2025-07-21 a 2025-07-26)
  - 4 días después del aniversario (2025-08-11 a 2025-08-14)

### Estado Inicial

```sql
SELECT 
    id,
    period,
    date_start,
    date_end,
    days_availables,
    days_enjoyed,
    days_enjoyed_before_anniversary,
    days_enjoyed_after_anniversary,
    days_reserved
FROM vacations_availables
WHERE users_id = 13 AND period = 5;
```

**Resultado esperado antes de aprobación:**
```
id: 567
period: 5
date_start: 2024-08-08
date_end: 2025-08-08
days_availables: 20.00
days_enjoyed: 0
days_enjoyed_before_anniversary: 0.00
days_enjoyed_after_anniversary: 0.00
days_reserved: 10.00  (reservados al crear solicitud)
```

### Lógica de Clasificación Implementada

```php
// VacacionesRh.php líneas ~167-192

$fechaAniversario = Carbon::parse($periodo->date_end); // 2025-08-08

foreach ($fechasIndividuales as $fecha) {
    $fechaDia = Carbon::parse($fecha);
    
    if ($fechaDia->lte($fechaAniversario)) {  // <= 2025-08-08
        $diasAntesAniversario++;              // 6 días
    } else {                                   // > 2025-08-08
        $diasDespuesAniversario++;            // 4 días
    }
}

// Actualización
$periodo->update([
    'days_enjoyed' => 0 + 10,                              // Total: 10
    'days_enjoyed_before_anniversary' => 0 + 6,           // Antes: 6
    'days_enjoyed_after_anniversary' => 0 + 4,            // Después: 4
    'days_reserved' => 10 - 10                            // Libera: 0
]);
```

### Estado Después de Aprobación RH

```sql
SELECT 
    id,
    period,
    days_enjoyed,
    days_enjoyed_before_anniversary,
    days_enjoyed_after_anniversary,
    days_reserved
FROM vacations_availables
WHERE users_id = 13 AND period = 5;
```

**Resultado esperado después:**
```
id: 567
period: 5
days_enjoyed: 10                            ✅ Total correcto
days_enjoyed_before_anniversary: 6.00       ✅ 6 días antes del 08/08/2025
days_enjoyed_after_anniversary: 4.00        ✅ 4 días después del 08/08/2025
days_reserved: 0.00                         ✅ Reserva liberada
```

**Validación matemática:**
```
days_enjoyed = days_enjoyed_before_anniversary + days_enjoyed_after_anniversary
10 = 6 + 4 ✅
```

## Casos de Prueba

### Caso 1: Todos los Días Antes del Aniversario

**Solicitud:**
- 5 días del 2025-07-28 al 2025-08-01
- Todos son `<= 2025-08-08`

**Resultado esperado:**
```
days_enjoyed: 5
days_enjoyed_before_anniversary: 5
days_enjoyed_after_anniversary: 0
```

**Mensaje:** "todos antes del aniversario"

### Caso 2: Todos los Días Después del Aniversario

**Solicitud:**
- 3 días del 2025-08-11 al 2025-08-13
- Todos son `> 2025-08-08`

**Resultado esperado:**
```
days_enjoyed: 3
days_enjoyed_before_anniversary: 0
days_enjoyed_after_anniversary: 3
```

**Mensaje:** "todos después del aniversario"

### Caso 3: Incluye Exactamente el Día de Aniversario

**Solicitud:**
- 3 días del 2025-08-07 al 2025-08-09
- Fechas: 07/08 (antes), 08/08 (aniversario), 09/08 (después)

**Clasificación:**
```
2025-08-07 <= 2025-08-08  → ANTES
2025-08-08 <= 2025-08-08  → ANTES (mismo día se considera dentro del período)
2025-08-09 >  2025-08-08  → DESPUÉS
```

**Resultado esperado:**
```
days_enjoyed: 3
days_enjoyed_before_anniversary: 2
days_enjoyed_after_anniversary: 1
```

### Caso 4: Días Fragmentados (No Consecutivos)

**Solicitud:**
- 7 días: 2025-07-21, 2025-07-22, 2025-07-30, 2025-08-04, 2025-08-11, 2025-08-15, 2025-08-20

**Clasificación:**
```
2025-07-21 <= 2025-08-08  → ANTES
2025-07-22 <= 2025-08-08  → ANTES
2025-07-30 <= 2025-08-08  → ANTES
2025-08-04 <= 2025-08-08  → ANTES
2025-08-11 >  2025-08-08  → DESPUÉS
2025-08-15 >  2025-08-08  → DESPUÉS
2025-08-20 >  2025-08-08  → DESPUÉS
```

**Resultado esperado:**
```
days_enjoyed: 7
days_enjoyed_before_anniversary: 4
days_enjoyed_after_anniversary: 3
```

**Mensaje:** "(4 antes del aniversario, 3 después)"

## Script SQL de Validación

```sql
-- 1. Verificar estado inicial de un período
SELECT 
    users_id,
    period,
    DATE_FORMAT(date_start, '%d/%m/%Y') AS inicio,
    DATE_FORMAT(date_end, '%d/%m/%Y') AS aniversario,
    days_availables AS disponibles,
    days_enjoyed AS disfrutados_total,
    days_enjoyed_before_anniversary AS antes_aniversario,
    days_enjoyed_after_anniversary AS despues_aniversario,
    days_reserved AS reservados,
    (days_availables - days_enjoyed - days_reserved) AS saldo_real
FROM vacations_availables
WHERE users_id = 13 AND period = 5;

-- 2. Ver fechas de una solicitud específica
SELECT 
    ra.id,
    DATE_FORMAT(ra.start, '%d/%m/%Y') AS fecha_dia,
    CASE 
        WHEN ra.start <= va.date_end THEN 'ANTES/EN aniversario'
        ELSE 'DESPUÉS aniversario'
    END AS clasificacion,
    va.date_end AS fecha_aniversario
FROM request_approved ra
JOIN requests r ON ra.requests_id = r.id
JOIN vacations_availables va ON r.user_id = va.users_id
WHERE r.id = 890  -- ID de la solicitud
    AND SUBSTRING_INDEX(r.opcion, '|', 1) = va.period
    AND SUBSTRING_INDEX(r.opcion, '|', -1) = va.date_start
ORDER BY ra.start;

-- 3. Historial de vacaciones de un usuario por período
SELECT 
    va.period AS periodo,
    DATE_FORMAT(va.date_end, '%d/%m/%Y') AS aniversario,
    va.days_enjoyed AS total_disfrutados,
    va.days_enjoyed_before_anniversary AS antes,
    va.days_enjoyed_after_anniversary AS despues,
    (va.days_enjoyed_before_anniversary + va.days_enjoyed_after_anniversary) AS suma_verificacion,
    CASE 
        WHEN va.days_enjoyed = (va.days_enjoyed_before_anniversary + va.days_enjoyed_after_anniversary) 
        THEN 'OK ✅' 
        ELSE 'ERROR ❌' 
    END AS validacion
FROM vacations_availables va
WHERE va.users_id = 13
    AND va.is_historical = 0
ORDER BY va.period;

-- 4. Reporte completo de aprobación reciente
SELECT 
    r.id AS solicitud_id,
    u.first_name,
    u.last_name,
    va.period,
    COUNT(ra.id) AS dias_solicitados,
    SUM(CASE WHEN ra.start <= va.date_end THEN 1 ELSE 0 END) AS dias_antes,
    SUM(CASE WHEN ra.start > va.date_end THEN 1 ELSE 0 END) AS dias_despues,
    va.days_enjoyed_before_anniversary AS registrado_antes,
    va.days_enjoyed_after_anniversary AS registrado_despues,
    r.human_resources_status AS estado
FROM requests r
JOIN users u ON r.user_id = u.id
JOIN request_approved ra ON r.id = ra.requests_id
JOIN vacations_availables va ON r.user_id = va.users_id
WHERE r.id = 890  -- ID solicitud
GROUP BY r.id, u.first_name, u.last_name, va.period;
```

## Validaciones Manuales en la Base de Datos

### Paso 1: Crear Solicitud de Prueba

```php
// En tinker o controller de prueba
$user = User::find(13);
$periodo = VacationsAvailable::where('users_id', 13)->where('period', 5)->first();

// Crear solicitud
$request = RequestVacations::create([
    'user_id' => 13,
    'type_request' => 'Vacaciones',
    'opcion' => "5|{$periodo->date_start}",
    'direct_manager_id' => $user->boss_id,
    'direct_manager_status' => 'Aprobada',
    'direction_approbation_status' => 'Aprobada',
    'human_resources_status' => 'Pendiente',
]);

// Crear días (6 antes, 4 después del aniversario 2025-08-08)
$diasAntes = ['2025-07-21', '2025-07-22', '2025-07-23', '2025-07-28', '2025-07-29', '2025-08-04'];
$diasDespues = ['2025-08-11', '2025-08-12', '2025-08-13', '2025-08-14'];

foreach ($diasAntes as $fecha) {
    RequestApproved::create([
        'requests_id' => $request->id,
        'users_id' => 13,
        'start' => $fecha,
        'end' => $fecha,
        'title' => 'Vacaciones',
    ]);
}

foreach ($diasDespues as $fecha) {
    RequestApproved::create([
        'requests_id' => $request->id,
        'users_id' => 13,
        'start' => $fecha,
        'end' => $fecha,
        'title' => 'Vacaciones',
    ]);
}

// Reservar días
$periodo->update(['days_reserved' => 10]);
```

### Paso 2: Aprobar desde Panel RH

1. Acceder a `/vacaciones/rh`
2. Buscar la solicitud de test
3. Hacer clic en "Aprobar"
4. Verificar mensaje: "...Se descontaron 10 días... (6 antes del aniversario, 4 después)"

### Paso 3: Verificar en Base de Datos

```sql
SELECT 
    days_enjoyed,
    days_enjoyed_before_anniversary,
    days_enjoyed_after_anniversary,
    days_reserved
FROM vacations_availables
WHERE users_id = 13 AND period = 5;

-- Esperado:
-- days_enjoyed: 10
-- days_enjoyed_before_anniversary: 6
-- days_enjoyed_after_anniversary: 4
-- days_reserved: 0
```

## Casos Extremos a Considerar

### ⚠️ Caso Edge 1: Solicitud Muy Antigua (Antes del date_start)

**Escenario:** Usuario solicita días del período 5, pero las fechas son antes del `date_start` (2024-08-08)

**Problema potencial:** Fechas como 2024-07-01 serían técnicamente "antes" del período completo.

**Solución actual:** Se clasificaría como "antes del aniversario" porque `2024-07-01 < 2025-08-08`.

**¿Es correcto?** ⚠️ **Inconsistencia potencial** - deberían validarse fechas dentro del rango del período.

**Mejora sugerida:**
```php
// Validar que las fechas estén dentro del rango del período
if ($fechaDia->lt($periodo->date_start) || $fechaDia->gt($periodo->cutoff_date)) {
    throw new \Exception("Fecha {$fechaDia->format('d/m/Y')} está fuera del rango del período");
}
```

### ⚠️ Caso Edge 2: Solicitud Después del cutoff_date

**Escenario:** Usuario solicita días después del `cutoff_date` (2026-11-08)

**Comportamiento actual:** Se clasificarían como "después del aniversario".

**¿Es correcto?** ❌ **ERROR** - no deberían permitirse días fuera del período de validez.

**Validación necesaria:** Ya existe en `VacacionesController::store()` pero debe estar en aprobación también.

### ✅ Caso Edge 3: Múltiples Aprobaciones del Mismo Período

**Escenario:** 
- Solicitud 1: 5 días antes del aniversario → Aprobada
- Solicitud 2: 3 días después del aniversario → Aprobada

**Comportamiento esperado:**
```
Después de solicitud 1:
- days_enjoyed_before_anniversary: 5
- days_enjoyed_after_anniversary: 0

Después de solicitud 2:
- days_enjoyed_before_anniversary: 5  (sin cambio)
- days_enjoyed_after_anniversary: 3   (+3)
- days_enjoyed: 8  (5 + 3)
```

**Validación:** ✅ Funciona correctamente (usa `+=` en update)

## Mensaje de Confirmación

El mensaje de confirmación varía según la distribución:

```php
// Todos antes
"...Se descontaron 5 días... (todos antes del aniversario)."

// Todos después
"...Se descontaron 3 días... (todos después del aniversario)."

// Mixto
"...Se descontaron 10 días... (6 antes del aniversario, 4 después)."

// Si todas las fechas == date_end (caso raro)
"...Se descontaron 1 día... (todos antes del aniversario)."
```

## Reportes Afectados

Los siguientes reportes deberían mostrar la separación:

1. **Panel RH** (`/vacaciones/rh`):
   - Mostrar columnas: "Antes aniv." y "Después aniv."

2. **Reporte de Vacaciones** (`/rrhh/vacaciones/reporte`):
   - Tabla detallada con separación por aniversario

3. **Exportación Excel**:
   - Incluir ambas columnas en export

4. **Vista de Empleado** (`/vacaciones`):
   - Opcional: mostrar separación al empleado

## Próximos Pasos

1. ✅ Implementar lógica de separación en `VacacionesRh.php`
2. ⏳ Crear test unitario para validar clasificación
3. ⏳ Actualizar vistas para mostrar ambas columnas
4. ⏳ Agregar validación de fechas dentro del rango del período
5. ⏳ Documentar en manual de usuario

---

**Fecha de implementación:** 5 de abril de 2026  
**Desarrollador:** Asistente IA  
**Estado:** ✅ Implementado en código, pendiente pruebas
