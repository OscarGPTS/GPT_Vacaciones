# Validación: Días Disfrutados <= Días Disponibles

## Descripción

**Regla de negocio crítica**: Los días disfrutados de vacaciones NO pueden ser mayores a los días disponibles en un período.

Esta validación previene inconsistencias en los datos y asegura la integridad del sistema de gestión de vacaciones.

## Implementación

### 1. Importación de Vacaciones (VacationImport.php)

La validación se aplica en **DOS niveles** para máxima seguridad:

#### Nivel 1: Al Parsear el Excel (Método `parseRow()`)

```php
// Líneas 149-158
$diasDisponibles = floatval($normalizedRow['dias disponibles'] ?? 0);
$diasDisfrutados = floatval($normalizedRow['dias disfrutados'] ?? 0);

// Validar regla de negocio
$validationError = null;
if ($diasDisfrutados > $diasDisponibles) {
    $validationError = "Los días disfrutados ({$diasDisfrutados}) no pueden ser mayores a los días disponibles ({$diasDisponibles})";
}

return [
    // ... otros campos
    'validation_error' => $validationError,
];
```

**Flujo**:
- Se detecta la violación al leer el archivo Excel
- El registro se marca con `validation_error`
- En `processFile()`, estos registros van automáticamente a `unmatchedRecords` (Step 2, sección de errores)

#### Nivel 2: Al Guardar en Base de Datos (Método `importRecord()`)

```php
// Líneas 365-371
// Validar regla de negocio: días disfrutados no pueden ser mayores a días disponibles
if ($record['dias_disfrutados'] > $record['dias_disponibles']) {
    throw new \Exception(
        "Los días disfrutados ({$record['dias_disfrutados']}) no pueden ser mayores a los días disponibles ({$record['dias_disponibles']})"
    );
}
```

**Propósito**:
- Doble verificación antes de insertar/actualizar en BD
- Protección contra manipulación de datos en tránsito
- Logging del error para auditoría

### 2. Edición Manual (RequestController.php)

En el reporte de vacaciones, la edición manual también valida:

```php
// Línea 599-604
$maxDays = $vacation->days_availables + $vacation->dv;
if ($request->days_enjoyed > $maxDays) {
    return response()->json([
        'success' => false, 
        'message' => "Los días disfrutados no pueden exceder {$maxDays} días (disponibles + DV)."
    ], 400);
}
```

**Interfaz (vacation-report.blade.php)**:
```javascript
// Línea 999-1009
if (enjoyed > maxDays) {
    warningText.textContent = `Los días disfrutados (${enjoyed.toFixed(2)}) exceden el máximo permitido (${maxDays.toFixed(2)})`;
    warning.style.display = 'block';
}

// Línea 1021-1024
if (daysEnjoyed > maxDays) {
    showAlert('danger', `Los días disfrutados no pueden exceder ${maxDays.toFixed(2)} días.`);
    return;
}
```

## Mensajes de Error

### En Importación (Step 3)

Formato estructurado en tabla con mensaje claro:

```
┌──────────────────────────────────────────────────────────┐
│ Registros con Errores - Requieren Corrección Manual     │
├────┬─────────────────────┬──────────────────────────────┤
│ #  │ Empleado            │ Motivo del Error             │
├────┼─────────────────────┼──────────────────────────────┤
│ 1  │ GARCÍA LÓPEZ JUAN   │ Los días disfrutados (20.0)  │
│    │                     │ no pueden ser mayores a los  │
│    │                     │ días disponibles (15.0)      │
│    │                     │                              │
│    │                     │ 💡 Solución: Verifique los   │
│    │                     │ valores en el Excel          │
└────┴─────────────────────┴──────────────────────────────┘
```

### En Edición Manual (Modal)

- **Warning badge** amarillo en tiempo real al escribir
- **Alert de Bootstrap** al intentar guardar
- Mensaje: "Los días disfrutados no pueden exceder X.XX días"

## Casos de Prueba

Ver: `tests/test_vacation_validation.php`

### Escenarios Cubiertos

| # | Días Disponibles | Días Disfrutados | ¿Válido? | Resultado Esperado |
|---|------------------|------------------|----------|-------------------|
| 1 | 15.0 | 10.0 | ✅ Sí | Pasa validación |
| 2 | 15.0 | 15.0 | ✅ Sí | Pasa validación (iguales está permitido) |
| 3 | 15.0 | 20.0 | ❌ No | Error: "Los días disfrutados (20) no pueden ser mayores..." |
| 4 | 10.0 | 50.0 | ❌ No | Error |
| 5 | 0.0 | 0.0 | ✅ Sí | Pasa validación |
| 6 | 0.0 | 5.0 | ❌ No | Error |
| 7 | 15.5 | 12.75 | ✅ Sí | Pasa validación (decimales) |
| 8 | 15.0 | 15.01 | ❌ No | Error (diferencia mínima) |
| 9 | -5.0 | 0.0 | ❌ No | Error: "Los días disponibles no pueden ser negativos (-5)" |
| 10 | 15.0 | -2.0 | ❌ No | Error: "Los días disfrutados no pueden ser negativos (-2)" |
| 11 | -10.0 | -5.0 | ❌ No | Error: "Los días disponibles no pueden ser negativos (-10)" |

### Ejecutar Tests

```powershell
php tests\test_vacation_validation.php
```

**Resultado esperado**: 11/11 tests pasados (100%)

## Edición Inline en Preview

### Funcionalidad

Los usuarios pueden corregir valores directamente en el preview (Step 2) sin necesidad de recargar el archivo Excel.

### Importación con Error

1. Usuario sube Excel con datos incorrectos:
   ```
   Nombre Completo      | Dias Disponibles | Dias Disfrutados
   GARCÍA LÓPEZ JUAN    | 15.0            | 20.0             ← ERROR
   ```

2. **Step 2 (Preview)**: No aparece en tabla verde de válidos

3. **Step 3 (Resultados)**: Aparece en tabla roja de errores con mensaje:
   ```
   ❌ GARCÍA LÓPEZ JUAN: Los días disfrutados (20.0) no pueden ser mayores 
                         a los días disponibles (15.0)
   
   💡 Solución: Verifique los valores en el Excel
   ```

4. Usuario **corrige el Excel** y vuelve a importar

### Edición Manual con Error

1. Usuario abre modal de edición de período
2. Ingresa `25.00` en "Días Disfrutados" (máximo permitido: 20.00)
3. **Warning en vivo**: "Los días disfrutados (25.00) exceden el máximo permitido (20.00)"
4. Al intentar guardar: **Alert rojo** impide el guardado
5. Usuario corrige el valor a `20.00` o menos

## Ubicación del Código

| Archivo | Líneas | Descripción |
|---------|--------|-------------|
| `app/Livewire/VacationImport.php` | 149-158 | Validación en parseRow() |
| `app/Livewire/VacationImport.php` | 365-371 | Validación en importRecord() |
| `app/Livewire/VacationImport.php` | 86-94 | Separación de errores en processFile() |
| `app/Http/Controllers/RequestController.php` | 599-604 | Validación en edición manual |
| `resources/views/livewire/vacation-import.blade.php` | 373-399 | Display de errores (Step 3) |
| `resources/views/livewire/vacation-report.blade.php` | 999-1024 | Validación frontend en modal |
| `tests/test_vacation_validation.php` | Todo | Tests automatizados |

## Consideraciones Técnicas

### ¿Por qué dos niveles de validación?

1. **Nivel Excel (parseRow)**:
   - Detecta errores temprano
   - Mejora UX (usuario ve error inmediatamente en Step 2/3)
   - Reduce carga en BD (no intenta guardar datos inválidos)

2. **Nivel BD (importRecord)**:
   - Seguridad adicional (defense in depth)
   - Protege contra manipulación de datos
   - Garantiza integridad incluso si frontend falla

### Diferencias con Edición Manual

En edición manual se permite que `days_enjoyed <= days_availables + dv`:

```php
$maxDays = $vacation->days_availables + $vacation->dv;
```

**Razón**: Los días de variación (DV) son días adicionales otorgados por RH que pueden usarse.

En importación NO se suma `dv` porque:
- El campo `dv` se establece en `0` por defecto
- Si existe DV, debe editarse manualmente después

## Documentación Relacionada

- **Guía completa de importación**: `docs/IMPORTACION_VACACIONES.md`
- **Vista previa visual**: `docs/PREVIEW_IMPORTACION.md`
- **Sistema auto-aprobación**: `docs/SISTEMA_AUTO_APROBACION.md`
- **Instrucciones AI**: `.github/copilot-instructions.md`

## Historial de Cambios

| Fecha | Descripción |
|-------|-------------|
| 2025-11-13 | Implementación inicial de validación en 2 niveles |
| 2025-11-13 | Mejora de mensajes de error con formato estructurado |
| 2025-11-13 | Creación de test suite con 8 casos |
| 2025-11-13 | Actualización de documentación |

---

**Última actualización**: 13 de Noviembre de 2025
