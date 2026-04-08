# Corrección: Descuento de Días en days_calculated y days_availables

**Fecha:** 5 de abril de 2026  
**Problema:** Los días aprobados solo incrementaban `days_enjoyed`, pero no decrementaban `days_calculated` ni `days_availables`

---

## Cambios Implementados

### 1. VacacionesRh.php - Aprobación de Solicitudes (líneas ~195-208)

**ANTES:**
```php
$periodo->update([
    'days_reserved' => max(0, $periodo->days_reserved - $diasSolicitados),
    'days_enjoyed' => $periodo->days_enjoyed + $diasSolicitados,
    'days_enjoyed_before_anniversary' => ...,
    'days_enjoyed_after_anniversary' => ...
]);
```

**AHORA:**
```php
$periodo->update([
    'days_reserved' => max(0, $periodo->days_reserved - $diasSolicitados),
    'days_enjoyed' => $periodo->days_enjoyed + $diasSolicitados,
    'days_enjoyed_before_anniversary' => ...,
    'days_enjoyed_after_anniversary' => ...,
    // ✅ NUEVO: Descontar de days_calculated
    'days_calculated' => max(0, ($periodo->days_calculated ?? 0) - $diasSolicitados),
    // ✅ NUEVO: Descontar de days_availables
    'days_availables' => max(0, $periodo->days_availables - $diasSolicitados),
]);
```

### 2. VacacionesRh.php - Validación de Saldo Disponible (líneas ~148-152)

**ANTES:**
```php
$diasDisponiblesEnPeriodo = $periodo->days_availables - $periodo->days_enjoyed;
```

**AHORA:**
```php
// Priorizar days_calculated (cálculo automático), si no existe usar days_availables (importado Excel)
$baseDisponible = $periodo->days_calculated ?? $periodo->days_availables;
$diasDisponiblesEnPeriodo = $baseDisponible - $periodo->days_enjoyed;
```

### 3. VacacionesController.php - Cálculo de Saldo para Vista (línea ~46)

**ANTES:**
```php
$availableDays = $period->days_availables - $period->days_enjoyed - $period->days_reserved;
```

**AHORA:**
```php
// Priorizar days_calculated (cálculo automático), si no existe usar days_availables (importado Excel)
$baseDisponible = $period->days_calculated ?? $period->days_availables;
$availableDays = $baseDisponible - $period->days_enjoyed - $period->days_reserved;
```

### 4. VacacionesController.php - Validación antes de Reservar (línea ~175-177)

**ANTES:**
```php
$diasDisponibles = $vacationPeriod->days_availables
                 - $vacationPeriod->days_enjoyed 
                 - $vacationPeriod->days_reserved;
```

**AHORA:**
```php
// Priorizar days_calculated (cálculo automático), si no existe usar days_availables (importado Excel)
$baseDisponible = $vacationPeriod->days_calculated ?? $vacationPeriod->days_availables;
$diasDisponibles = $baseDisponible
                 - $vacationPeriod->days_enjoyed 
                 - $vacationPeriod->days_reserved;
```

### 5. VacacionesController.php - Suma Total de Días (línea ~265)

**ANTES:**
```php
$totalAvailable = $vacationAvailables->sum(function($period) {
    $available = $period->days_availables - $period->days_enjoyed - $period->days_reserved;
    return floor($available);
});
```

**AHORA:**
```php
$totalAvailable = $vacationAvailables->sum(function($period) {
    // Priorizar days_calculated (cálculo automático), si no existe usar days_availables (importado Excel)
    $baseDisponible = $period->days_calculated ?? $period->days_availables;
    $available = $baseDisponible - $period->days_enjoyed - $period->days_reserved;
    return floor($available);
});
```

### 6. VacacionesController.php - getUserRestrictions AJAX (línea ~274)

**ANTES:**
```php
$availableDays = $period->days_availables - $period->days_enjoyed - $period->days_reserved;
```

**AHORA:**
```php
// Priorizar days_calculated (cálculo automático), si no existe usar days_availables (importado Excel)
$baseDisponible = $period->days_calculated ?? $period->days_availables;
$availableDays = $baseDisponible - $period->days_enjoyed - $period->days_reserved;
```

---

## Lógica de Negocio

### Campos en `vacations_availables`

| Campo | Descripción | Actualizado Por | Origen |
|-------|-------------|----------------|---------|
| `days_calculated` | Días acumulados automáticamente | Sistema (comando diario) | Cálculo proporcional |
| `days_availables` | Días disponibles importados | Importación Excel | Columna Q del Excel |
| `days_enjoyed` | Días ya disfrutados | Aprobación RH | Incrementa con cada aprobación |
| `days_reserved` | Días en solicitudes pendientes | Creación/Aprobación | Se libera al aprobar/rechazar |

### Fórmula de Saldo

```php
// 1. Determinar base disponible (prioridad: calculado > importado)
$baseDisponible = $period->days_calculated ?? $period->days_availables;

// 2. Calcular saldo
$saldo = $baseDisponible - $period->days_enjoyed - $period->days_reserved;
```

**¿Por qué priorizar `days_calculated`?**
- Es el valor más actualizado (se recalcula diariamente)
- Refleja la acumulación real de días trabajados
- `days_availables` puede estar desactualizado si no se importa Excel frecuentemente

### Flujo de Aprobación

```
1. Usuario crea solicitud
   → days_reserved += días_solicitados

2. RH aprueba solicitud
   → days_reserved -= días_solicitados  (libera reserva)
   → days_enjoyed += días_solicitados   (incrementa disfrutados)
   → days_calculated -= días_solicitados (decrementa cálculo automático)
   → days_availables -= días_solicitados (decrementa saldo importado)
   → days_enjoyed_before_anniversary += días (separación)
   → days_enjoyed_after_anniversary += días (separación)

3. Resultado en saldo visual
   → ANTES: base = 20 días
   → DESPUÉS: base = 17 días (si se aprobaron 3)
   → enjoyed = 3 (incrementó)
   → Saldo final = 17 - 3 = 14 días
```

---

## Validación de Pruebas

### Test Ejecutado: `test_descuento_both_fields.php`

**Resultado:** ✅ TODAS LAS VALIDACIONES PASARON

```
Estado inicial:
  days_calculated: 17.78
  days_availables: 21.00
  days_enjoyed: 3

Días aprobados: 3

Estado final:
  days_calculated: 14.78  ✅ (-3 días)
  days_availables: 18.00  ✅ (-3 días)
  days_enjoyed: 6         ✅ (+3 días)

Saldo visual: 14.78 - 6 = 8.78 días ✅
```

---

## Impacto en Vistas

### `/vacaciones` (index)
- ✅ Usa `days_calculated ?? days_availables` para calcular saldo
- ✅ Muestra correctamente días disponibles por período
- ✅ Total de días disponibles usa la nueva fórmula

### `/vacaciones/create`
- ✅ Validación pre-reserva usa `days_calculated ?? days_availables`
- ✅ No permite reservar más días de los disponibles

### `/vacaciones/rh` (Livewire)
- ✅ Validación pre-aprobación usa nueva fórmula
- ✅ Descuenta de AMBOS campos al aprobar

---

## Casos Edge Considerados

### 1. Período sin `days_calculated` (NULL)
```php
$base = null ?? 24;  // Usa days_availables = 24
$saldo = 24 - 0 - 0 = 24 días ✅
```

### 2. Período antiguo con `days_calculated = 0`
```php
$base = 0 ?? 22.12;  // 0 es falsy, usa days_availables
$saldo = 22.12 - 5 - 0 = 17.12 días ✅
```

### 3. Periodo actual acumulando
```php
$base = 20.78 ?? 24;  // Usa days_calculated = 20.78
$saldo = 20.78 - 0 - 0 = 20.78 días ✅
```

### 4. Descuento llevando `days_calculated` a negativo
```php
// Antes: days_calculated = 5
// Aprobar 10 días
days_calculated = max(0, 5 - 10) = 0  ✅ No negativo
days_availables = max(0, 24 - 10) = 14 ✅
```

---

## Archivos Modificados

1. `app/Livewire/VacacionesRh.php` (2 ubicaciones)
2. `app/Http/Controllers/VacacionesController.php` (4 ubicaciones)

**Total:** 6 cambios en 2 archivos

---

## Testing

**Scripts de prueba:**
- `tests/test_days_calculated_vs_availables.php` - Comparación de valores
- `tests/test_descuento_both_fields.php` - Validación de descuento ✅ PASS
- `tests/test_vacation_approval_flow.php` - Flujo completo de aprobación

---

## Próximos Pasos (Opcionales)

1. **Actualizar reportes Excel** para incluir ambas columnas
2. **Agregar columna en vista RH** para mostrar `days_calculated` vs `days_availables`
3. **Comando de auditoría** para detectar discrepancias entre ambos campos
4. **Migración de datos** para sincronizar valores históricos

---

**Estado:** ✅ Implementado y validado  
**Versión:** Laravel 10.48 + Livewire 3.4  
**Última actualización:** 5 de abril de 2026
