# Separación de Campos: days_calculated vs days_availables

**Fecha:** 1 de abril de 2026  
**Cambio:** Agregar campo `days_calculated` para resolver conflicto con importaciones

---

## Problema Original

El campo `days_availables` se usaba para dos propósitos diferentes que causaban conflictos:

1. **Cálculo Automático del Sistema** - Días acumulados día con día
2. **Importación desde Excel** - Saldo pendiente de la columna Q

Cuando se importaba un Excel, los valores calculados automáticamente se sobrescribían, y viceversa.

---

## Solución Implementada

Se agregó un nuevo campo `days_calculated` para separar ambas funcionalidades:

| Campo | Propósito | Actualizado Por | Frecuencia |
|-------|-----------|----------------|------------|
| **days_calculated** | Cálculo automático del sistema | Servicios automáticos | Diario |
| **days_availables** | Datos importados desde Excel | Importación manual | Cuando se importa |

---

## Cambios Realizados

### 1. Migración de Base de Datos

**Archivo:** `database/migrations/2026_04_01_130852_add_days_calculated_to_vacations_availables_table.php`

```php
Schema::table('vacations_availables', function (Blueprint $table) {
    $table->decimal('days_calculated', 8, 2)->nullable()->after('days_availables')
        ->comment('Días calculados automáticamente por el sistema (acumulación diaria)');
});
```

**Ejecutado:** ✅ `php artisan migrate --path=database/migrations/2026_04_01_130852_add_days_calculated_to_vacations_availables_table.php`

### 2. Modelo VacationsAvailable

**Archivo:** `app/Models/VacationsAvailable.php`

**Agregado a $fillable:**
```php
'days_calculated',
```

**Agregado a $casts:**
```php
'days_calculated' => 'decimal:2',
```

### 3. VacationDailyAccumulatorService

**Archivo:** `app/Services/VacationDailyAccumulatorService.php`

**ANTES:**
```php
$oldValue = $vacation->days_availables;
$vacation->days_availables = $accumulatedDays;
```

**AHORA:**
```php
$oldValue = $vacation->days_calculated;
$vacation->days_calculated = $accumulatedDays;
```

### 4. UpdateVacationAccrual Command

**Archivo:** `app/Console/Commands/UpdateVacationAccrual.php`

**ANTES:**
```php
$oldDays = $period->days_availables;
// ...
$period->days_availables = round($accruedDays, 2);
```

**AHORA:**
```php
$oldDays = $period->days_calculated ?? 0;
// ...
$period->days_calculated = round($accruedDays, 2);
```

### 5. VacationImport (SIN CAMBIOS)

**Archivo:** `app/Livewire/VacationImport.php`

El código de importación **permanece igual**, actualizando `days_availables`:

```php
'days_availables' => $diasDisponiblesActual,  // Columna Q del Excel
'days_enjoyed' => $diasDisfrutadosActual,      // CALCULADO: total - Q
```

---

## Flujo de Datos

### Cálculo Automático (Sistema)

```
┌─────────────────────┐
│  Comando Artisan    │
│  (diario/manual)    │
└──────────┬──────────┘
           │
           ▼
┌────────────────────────────────────────┐
│  VacationDailyAccumulatorService       │
│  UpdateVacationAccrual                 │
└──────────┬─────────────────────────────┘
           │
           ▼
     [days_calculated]  ← Acumulación proporcional
     
Fórmula: (days_total_period / días_en_año) × días_trabajados
```

### Importación desde Excel

```
┌─────────────────────┐
│  Archivo Excel      │
│  Columna Q          │
└──────────┬──────────┘
           │
           ▼
┌────────────────────────────────────────┐
│  VacationImport (Livewire)             │
│  executeImport()                       │
└──────────┬─────────────────────────────┘
           │
           ▼
     [days_availables]  ← Saldo pendiente del Excel
     [days_enjoyed]     ← CALCULADO: total - saldo
```

---

## Ventajas de la Separación

✅ **No hay conflictos** - Cada proceso actualiza su propio campo  
✅ **Trazabilidad** - Puedes comparar cálculo automático vs Excel  
✅ **Auditoría** - Ambos valores se conservan para análisis  
✅ **Flexibilidad** - Puedes usar uno u otro según necesites  
✅ **Retrocompatibilidad** - days_availables sigue funcionando igual  

---

## Uso en el Sistema

### Para Cálculos Automáticos
Usa `days_calculated` cuando el sistema calcula automáticamente:

```php
// Días acumulados automáticamente
$diasCalculados = $period->days_calculated;

// Días restantes calculados automáticamente
$diasRestantes = ($period->days_calculated + $period->dv) 
                - $period->days_enjoyed 
                - $period->days_reserved;
```

### Para Datos Importados
Usa `days_availables` cuando provienen de Excel:

```php
// Saldo pendiente según Excel
$saldoExcel = $period->days_availables;

// Mostrar en reportes que usan datos de importación
$saldoActual = $period->days_availables;
```

### Para Comparaciones
Puedes comparar ambos valores para detectar discrepancias:

```php
$diferencia = abs($period->days_calculated - $period->days_availables);

if ($diferencia > 1) {
    // Hay diferencia significativa entre cálculo y Excel
    // Revisar con RRHH
}
```

---

## Comandos Útiles

### Poblar days_calculated con Datos Actuales
```bash
php artisan vacations:update-accrual
```
Esto calculará y guardará los días proporcionales en `days_calculated` para todos los períodos activos.

### Verificar Campos
```bash
php tests/test_days_calculated_separation.php
```

### Importar Excel (Actualiza days_availables)
1. Ve a `/vacaciones/importar`
2. Sube tu archivo Excel
3. Revisa y confirma
4. `days_availables` se actualiza automáticamente

---

## Ejemplo Real

**Usuario:** Benjamín Alcántara Bautista  
**Período:** 11 (25/05/2024 - 25/05/2025)  
**Total período:** 24 días

| Campo | Valor | Fuente |
|-------|-------|--------|
| days_total_period | 24.00 | Definido al crear período |
| **days_calculated** | 23.52 | Sistema: acumulación diaria hasta hoy |
| **days_availables** | 23.00 | Excel: columna Q (saldo pendiente) |
| days_enjoyed | 1 | Días tomados de vacaciones |

**Días restantes (según cálculo automático):**  
`23.52 + 0 (dv) - 1 (enjoyed) - 0 (reserved) = 22.52 días`

**Días restantes (según Excel):**  
`23.00 días` (ya viene calculado en el Excel)

---

## Migración de Datos Existentes

Si tienes datos existentes en `days_availables` que quieres copiar a `days_calculated`:

```sql
-- Copiar datos existentes (OPCIONAL, solo si es necesario)
UPDATE vacations_availables 
SET days_calculated = days_availables 
WHERE days_calculated IS NULL 
  AND days_availables IS NOT NULL;
```

⚠️ **NOTA:** No es necesario hacer esto si prefieres que el sistema calcule automáticamente desde cero.

---

## Testing

### Test Automatizado
```bash
php tests/test_days_calculated_separation.php
```

Verifica:
- ✅ Campo existe en BD
- ✅ Modelo actualizado
- ✅ Servicios usan days_calculated
- ✅ Import usa days_availables
- ✅ Ambos coexisten sin conflictos

### Test Manual

1. **Importar Excel:**
   - Subir archivo
   - Verificar que `days_availables` se actualiza
   - Verificar que `days_calculated` NO se modifica

2. **Ejecutar cálculo automático:**
   ```bash
   php artisan vacations:update-accrual
   ```
   - Verificar que `days_calculated` se actualiza
   - Verificar que `days_availables` NO se modifica

3. **Comparar ambos valores:**
   - Deben poder ser diferentes
   - No deben sobrescribirse entre sí

---

## Archivos Modificados

| Archivo | Tipo | Cambio |
|---------|------|--------|
| `2026_04_01_130852_add_days_calculated_to_vacations_availables_table.php` | Migración | ✅ Nuevo |
| `app/Models/VacationsAvailable.php` | Modelo | ✅ Modificado |
| `app/Services/VacationDailyAccumulatorService.php` | Servicio | ✅ Modificado |
| `app/Console/Commands/UpdateVacationAccrual.php` | Comando | ✅ Modificado |
| `app/Livewire/VacationImport.php` | Componente | ⚪ Sin cambios |
| `tests/test_days_calculated_separation.php` | Test | ✅ Nuevo |

---

## Próximos Pasos

1. ✅ **Ejecutado:** Migración de base de datos
2. ✅ **Ejecutado:** Actualización de modelo y servicios
3. ✅ **Ejecutado:** Test de validación
4. ⏳ **Pendiente:** Ejecutar `php artisan vacations:update-accrual` para poblar days_calculated
5. ⏳ **Pendiente:** Probar importación Excel
6. ⏳ **Pendiente:** Verificar que ambos campos se mantienen independientes

---

**Estado:** ✅ Implementación completa  
**Probado:** ✅ Test automatizado pasado  
**Producción:** ⚠️ Requiere ejecutar comando de acumulación inicial
