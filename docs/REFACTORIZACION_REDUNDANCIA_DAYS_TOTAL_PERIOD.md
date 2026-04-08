# Refactorización: Eliminación de Redundancia days_total_period

## 📋 Problema Identificado

### Redundancia Actual
En el sistema actual existen **3 puntos** que almacenan la misma información (días de vacaciones por año de antigüedad):

1. **`vacation_per_years` (tabla catálogo)**
   - Almacena la norma mexicana (LFT)
   - Estructura: `year` → `days`
   - Ejemplo: año 1 → 12 días, año 2 → 14 días

2. **`vacations_available.days_total_period` (campo redundante)**
   - Se asigna al crear cada período
   - Duplica el valor de `vacation_per_years`
   - **PROBLEMA:** Datos duplicados que pueden desincronizarse

3. **Constantes hardcodeadas en servicios** (ahora eliminadas ✅)
   - `CURRENT_SCHEME_DAYS` en `VacationPeriodCreatorService`
   - `CURRENT_SCHEME_DAYS` en `VacationCalculatorService`
   - **SOLUCIÓN APLICADA:** Ahora consultan `VacationPerYear::getDaysForYear()`

---

## ✅ Cambios Implementados (Fase 1)

### 1. Seeder de Catálogo LFT
**Archivo:** `database/seeders/VacationPerYearSeeder.php`

Pobla la tabla `vacation_per_years` con la norma mexicana:
- Años 1-5: 12, 14, 16, 18, 20 días
- Años 6-10: 22 días
- Años 11-15: 24 días
- Años 16-20: 26 días
- Años 21-25: 28 días
- Años 26-30: 30 días
- Años 31+: 32 días (máximo)

**Ejecución:**
```bash
php artisan db:seed --class=VacationPerYearSeeder
```

### 2. Refactorización de Servicios
**Archivos modificados:**
- `app/Services/VacationPeriodCreatorService.php`
- `app/Services/VacationCalculatorService.php`

**Cambio aplicado:**
```php
// ANTES (hardcodeado)
protected function getDaysForSeniority(int $years, array $scheme): int
{
    if ($years <= 4) {
        return $scheme[$years] ?? 0;
    }
    // ... rangos hardcodeados
}

// DESPUÉS (consulta centralizada)
protected function getDaysForSeniority(int $years, array $scheme): int
{
    // Primero intentar obtener de la tabla centralizada
    $days = VacationPerYear::getDaysForYear($years);
    
    if ($days > 0) {
        return $days;
    }
    
    // Fallback al esquema hardcodeado (solo si tabla no poblada)
    // ...
}
```

### 3. Relación en Modelo
**Archivo:** `app/Models/VacationsAvailable.php`

**Nueva relación agregada:**
```php
/**
 * Relación con catálogo de días por año (LFT México)
 */
public function vacationPerYear(): BelongsTo
{
    return $this->belongsTo(VacationPerYear::class, 'period', 'year');
}

/**
 * Accessor: Obtiene días totales desde la relación
 * (alternativa a days_total_period para migración gradual)
 */
public function getTotalDaysFromCatalogAttribute(): int
{
    return $this->vacationPerYear?->days ?? 
           (int) $this->days_total_period ?? 
           0;
}
```

**Uso:**
```php
// Opción 1: Campo actual (redundante)
$days = $vacation->days_total_period;

// Opción 2: Relación (centralizada) 
$days = $vacation->vacationPerYear->days;

// Opción 3: Accessor (migración gradual)
$days = $vacation->total_days_from_catalog;
```

---

## 🔄 Plan de Migración (Fase 2 - PENDIENTE)

### Paso 1: Verificar Consistencia
Antes de eliminar `days_total_period`, verificar que todos los registros coincidan:

```php
// Script de verificación
$inconsistencies = VacationsAvailable::with('vacationPerYear')
    ->get()
    ->filter(function($vacation) {
        return $vacation->days_total_period != ($vacation->vacationPerYear->days ?? 0);
    });

if ($inconsistencies->count() > 0) {
    // Corregir inconsistencias antes de migrar
    foreach ($inconsistencies as $vac) {
        $vac->days_total_period = $vac->vacationPerYear->days;
        $vac->save();
    }
}
```

### Paso 2: Refactorizar Código
Reemplazar todas las referencias a `days_total_period` por la relación:

**Archivos a modificar:**
```
✓ app/Livewire/VacationImport.php (líneas 590, 654)
✓ app/Services/VacationDailyAccumulatorService.php (línea 47)
✓ app/Services/VacationPeriodCreatorService.php (asignaciones en create)
✓ app/Services/VacationCalculatorService.php (asignaciones en create)
✓ resources/views/livewire/vacation-report.blade.php (líneas 504, 582)
```

**Patrón de reemplazo:**
```php
// ANTES
$totalDays = $vacation->days_total_period;

// DESPUÉS
$totalDays = $vacation->vacationPerYear->days;
// O usando el accessor:
$totalDays = $vacation->total_days_from_catalog;
```

### Paso 3: Crear Migración para Eliminar Columna
```php
// database/migrations/YYYY_MM_DD_remove_days_total_period.php
public function up()
{
    Schema::table('vacations_availables', function (Blueprint $table) {
        $table->dropColumn('days_total_period');
    });
}

public function down()
{
    Schema::table('vacations_availables', function (Blueprint $table) {
        $table->decimal('days_total_period', 8, 2)->nullable()
            ->comment('Total de dias a acumular en el periodo para calculo diario');
    });
}
```

### Paso 4: Actualizar Fillable y Casts
```php
// app/Models/VacationsAvailable.php
protected $fillable = [
    'period',
    // 'days_total_period', // ❌ ELIMINAR
    'days_availables',
    // ...
];

protected $casts = [
    // 'days_total_period' => 'decimal:2', // ❌ ELIMINAR
    // ...
];
```

---

## 📊 Impacto de la Refactorización

### Beneficios
✅ **Centralización:** Un solo lugar de verdad (`vacation_per_years`)
✅ **Mantenibilidad:** Cambios en días de vacaciones solo en un seeder
✅ **Consistencia:** Imposible tener datos desincronizados
✅ **Escalabilidad:** Fácil actualizar norma si cambia la ley
✅ **Reducción de storage:** Elimina columna redundante de miles de registros

### Riesgos
⚠️ **Migración de datos:** Requiere verificación exhaustiva
⚠️ **Testing:** Probar todas las funcionalidades de vacaciones post-migración
⚠️ **Rollback:** Mantener migración `down()` funcional por si hay problemas

---

## 🧪 Testing Recomendado

### Test 1: Verificar Relación
```php
$vacation = VacationsAvailable::find(1);
$this->assertEquals(
    $vacation->days_total_period, 
    $vacation->vacationPerYear->days
);
```

### Test 2: Verificar Importación
```php
// Importar Excel de prueba
// Verificar que days_enjoyed se calcule correctamente sin days_total_period
```

### Test 3: Verificar Cálculo Diario
```php
// VacationDailyAccumulatorService debe usar la relación
$service = new VacationDailyAccumulatorService();
$result = $service->accumulateDailyVacations($user);
// Verificar acumulación correcta
```

---

## 📝 Notas Importantes

1. **El campo `days_availables` NO es redundante:**
   - Almacena el saldo actual (puede ser < days_total_period)
   - Se actualiza con importaciones
   - Refleja días reales disponibles considerando ajustes

2. **El campo `days_enjoyed` es necesario:**
   - Contador de días tomados
   - Fórmula: `saldo = days_availables - days_enjoyed - days_reserved`

3. **El campo `days_calculated` es diferente:**
   - Acumulación diaria proporcional
   - Se usa para cálculos intermedios en el año

4. **Mantener `vacation_per_years` actualizado:**
   - Ejecutar seeder en producción: `php artisan db:seed --class=VacationPerYearSeeder`
   - Revisar si hay cambios legales en la LFT

---

## ✅ Estado Actual

**Fase 1 (COMPLETA):**
- [x] Crear seeder `VacationPerYearSeeder`
- [x] Poblar tabla `vacation_per_years`
- [x] Refactorizar servicios para usar `VacationPerYear::getDaysForYear()`
- [x] Agregar relación `vacationPerYear()` en modelo
- [x] Agregar accessor `total_days_from_catalog`

**Fase 2 (COMPLETA ✅):**
- [x] Verificar consistencia de datos
- [x] Refactorizar código para usar relación
- [x] Crear migración para eliminar `days_total_period`
- [x] Actualizar modelo (fillable y casts)
- [x] Ejecutar migración exitosamente
- [x] Testing básico validado

---

## 📋 Archivos Modificados (Fase 2)

### 1. Refactorización de Lógica
- ✅ `app/Livewire/VacationImport.php` (2 cambios - líneas 590, 654)
- ✅ `app/Services/VacationDailyAccumulatorService.php` (1 cambio - línea 47)
- ✅ `app/Services/VacationPeriodCreatorService.php` (3 cambios - creates)
- ✅ `app/Services/VacationCalculatorService.php` (6 cambios - creates y updates)

### 2. Refactorización de Vista
- ✅ `resources/views/livewire/vacation-report.blade.php` (2 cambios - líneas 504, 582)

### 3. Modelo y Migración
- ✅ `app/Models/VacationsAvailable.php` (eliminado de fillable y casts)
- ✅ `database/migrations/2026_04_04_214932_remove_days_total_period_from_vacations_availables_table.php`

---

## 🎯 Resultado Final

### ANTES (Redundancia)
```
vacation_per_years          vacations_availables
┌──────┬──────┐            ┌────────────────────┐
│ year │ days │            │ days_total_period  │ ← ❌ REDUNDANTE
├──────┼──────┤            └────────────────────┘
│  1   │  12  │                    12
│  2   │  14  │                    14
│  3   │  16  │                    16
└──────┴──────┘                    ...
```

### DESPUÉS (Sin Redundancia ✅)
```
vacation_per_years          vacations_availables
┌──────┬──────┐            ┌────────────────────┐
│ year │ days │ ←──────────┤ period (FK)        │ ✅ RELACIÓN
├──────┼──────┤            │ (no days_total)    │
│  1   │  12  │            └────────────────────┘
│  2   │  14  │
│  3   │  16  │            $vacation->vacationPerYear->days
└──────┴──────┘                          ↑
                                    Acceso directo
```

---

## 📊 Impacto del Cambio

### ✅ Beneficios Confirmados
1. **Centralización total:** Un solo lugar de verdad (`vacation_per_years`)
2. **Sin redundancia:** Columna eliminada de ~5000+ registros
3. **Mantenibilidad:** Cambios en LFT solo requieren actualizar seeder
4. **Consistencia garantizada:** Imposible desincronización
5. **Código más limpio:** `$vacation->vacationPerYear->days` es más semántico

### 📉 Storage Reducido
- **Columna eliminada:** `days_total_period DECIMAL(8,2)` = 5 bytes por registro
- **Registros estimados:** ~5000 períodos de vacaciones
- **Ahorro:** ~25 KB + índices

### ⚡ Performance
- **Reads:** Relación lazy-loaded (cache automático en memoria)
- **Writes:** Menos updates innecesarios
- **Queries complejos:** Puede usar eager loading `->with('vacationPerYear')`

---

## 🧪 Validación Post-Migración

### Test 1: Verificar Relación ✅
```bash
# Ejecutar en tinker:
php artisan tinker
$vacation = VacationsAvailable::with('vacationPerYear')->first();
$vacation->vacationPerYear->days; // Debe retornar valor correcto
```

### Test 2: Importación Excel ✅
- Importar archivo de prueba
- Verificar cálculo: `days_enjoyed = total - days_availables`
- Total obtenido de: `$periodo->vacationPerYear->days`

### Test 3: Creación de Períodos ✅
- Crear período nuevo vía servicio
- Verificar que NO intente asignar `days_total_period`
- Verificar acceso: `$period->vacationPerYear->days`

---

**Última actualización:** 2026-04-04 21:50  
**Responsable:** Sistema de Vacaciones RRHH Satech Energy  
**Status:** ✅ **FASE 2 COMPLETA - REDUNDANCIA ELIMINADA**
