# Importación Masiva de Vacaciones

## Descripción

Este módulo permite sincronizar masivamente los datos de vacaciones desde un archivo Excel a la base de datos del sistema. Puede **crear nuevos períodos** o **actualizar períodos existentes** de forma automática.

## Formato del Archivo Excel

### Columnas Requeridas (en este orden):

| # | Columna          | Tipo    | Descripción                                    | Ejemplo      |
|---|------------------|---------|------------------------------------------------|--------------|
| 1 | user_id          | Entero  | ID del usuario en la base de datos            | 52           |
| 2 | date_start       | Fecha   | Fecha de inicio del período (YYYY-MM-DD)      | 2024-08-08   |
| 3 | date_end         | Fecha   | Fecha de fin del período (YYYY-MM-DD)          | 2025-08-08   |
| 4 | days_availables  | Decimal | Días acumulados disponibles                    | 12.00        |
| 5 | dv               | Decimal | Días adicionales (DV)                          | 0            |
| 6 | days_enjoyed     | Decimal | Días ya disfrutados                            | 5.00         |
| 7 | days_reserved    | Decimal | Días reservados (en solicitudes pendientes)    | 2.50         |
| 8 | status           | Texto   | Estado del período (actual o vencido)          | actual       |

### Ejemplo de Archivo:

```
| user_id | date_start | date_end   | days_availables | dv | days_enjoyed | days_reserved | status |
|---------|------------|------------|-----------------|----|--------------| --------------|--------|
| 52      | 2024-08-08 | 2025-08-08 | 12.00           | 0  | 5.00         | 2.50          | actual |
| 53      | 2023-01-15 | 2024-01-15 | 14.00           | 1  | 8.00         | 0.00          | actual |
| 54      | 2022-03-20 | 2023-03-20 | 16.00           | 0  | 16.00        | 0.00          | vencido|
```

## Validaciones

### Validaciones de Datos:
- ✅ **user_id**: Debe existir en la tabla `users`
- ✅ **date_start**: Formato válido YYYY-MM-DD
- ✅ **date_end**: Debe ser posterior a `date_start`
- ✅ **days_availables**: Número >= 0
- ✅ **dv**: Número >= 0 (opcional, default: 0)
- ✅ **days_enjoyed**: Número >= 0 (opcional, default: 0)
- ✅ **days_reserved**: Número >= 0 (opcional, default: 0)
- ✅ **status**: Solo acepta `actual` o `vencido`

### Lógica de Importación:

**El sistema busca períodos existentes por:**
- `user_id` + `date_start` + `is_historical = false`

**Si el período EXISTE:**
- ✅ **Actualiza** todos los campos (date_end, days_availables, dv, days_enjoyed, days_reserved, status)
- ✅ Mantiene el mismo `id` y `period`

**Si el período NO EXISTE:**
- ✅ **Crea** un nuevo período
- ✅ Calcula automáticamente el número de `period` (cuenta períodos anteriores del usuario + 1)
- ✅ Asigna `is_historical = false`

## Uso

### Desde la Interfaz Web:

1. Ir a **Vacaciones → Reporte**
2. Clic en botón **"Importar Excel"** (amarillo)
3. Descargar plantilla de ejemplo (opcional)
4. Seleccionar archivo Excel
5. Clic en **"Importar Datos"**
6. Revisar resultados

### Plantilla de Ejemplo

Puedes descargar una plantilla pre-configurada con:
- Encabezados correctos
- 3 filas de ejemplos
- Formato listo para usar

**Desde la interfaz:** Botón "Descargar Plantilla de Ejemplo" en el modal de importación.

## Casos de Uso

### 1. Crear Períodos Nuevos
**Escenario:** Empleados nuevos o períodos faltantes

**Proceso:**
1. Preparar Excel con datos del nuevo período
2. Asegurarse que `date_start` NO exista para ese usuario
3. Importar archivo
4. El sistema **crea** el período con número calculado automáticamente

**Resultado:** Nuevo registro en `vacations_availables`

### 2. Actualizar Períodos Existentes  
**Escenario:** Corrección de días disfrutados/reservados

**Proceso:**
1. Preparar Excel con `date_start` que ya existe para el usuario
2. Modificar valores (days_enjoyed, days_reserved, etc.)
3. Importar archivo
4. El sistema **actualiza** el período existente

**Resultado:** Registro actualizado manteniendo el mismo `id`

### 3. Sincronización Inicial
Importar datos históricos de vacaciones desde un sistema anterior o Excel.

### 4. Corrección Masiva
Corregir múltiples registros de vacaciones de forma eficiente.

### 5. Migración de Datos
Mover datos desde hojas de cálculo al sistema RRHH.

## Resultados de Importación

El sistema mostrará un modal con estadísticas detalladas:

- 📊 **Registros procesados**: Total de filas leídas del Excel
- ✅ **Actualizados**: Períodos que ya existían y fueron modificados
- ➕ **Creados**: Períodos nuevos creados en el sistema
- ❌ **Errores**: Registros con problemas de validación
- 📋 **Detalles de errores**: Lista completa con número de fila y mensaje

### Ejemplo de Resultados:
```
Procesados: 10
Actualizados: 6
Creados: 3
Errores: 1

Detalles:
Fila 8: The user_id field must exist in users table.
```

## Recomendaciones

### ✅ Buenas Prácticas:
- **Descarga la plantilla** para usar el formato correcto
- **Valida los datos** antes de importar (user_id existentes, fechas correctas)
- **Haz una prueba** con pocos registros primero
- **Respalda la base de datos** antes de importaciones grandes
- **Revisa los resultados** después de la importación (estadísticas y errores)
- **Importa en lotes** de 50-100 registros para mejor control

### ❌ Evitar:
- Archivos con formato incorrecto o columnas desordenadas
- Datos de usuarios inexistentes (validar `user_id`)
- Fechas en formato diferente a YYYY-MM-DD
- Valores negativos en días
- Status diferentes a `actual` o `vencido`

## Características Técnicas

### Transacciones
- ✅ Todas las operaciones usan transacciones de base de datos
- ✅ Si hay un error crítico, se revierten TODOS los cambios
- ✅ Garantiza integridad de datos

### Cálculo Automático de Período
Cuando se crea un período nuevo:
```php
// Cuenta períodos anteriores del usuario
$periodNumber = (períodos con date_start < nueva_fecha) + 1
```

### Logging
Cada operación se registra en `storage/logs/laravel.log`:
- Períodos actualizados (con ID y fechas)
- Períodos creados (con número calculado)
- Errores de procesamiento

## Límites

- **Tamaño máximo de archivo:** 10 MB
- **Formatos soportados:** .xlsx, .xls
- **Operación:** Creación Y actualización automática

## Solución de Problemas

### Error: "Usuario no encontrado"
**Causa:** El `user_id` no existe en la tabla `users`  
**Solución:** Verifica que el usuario esté registrado en el sistema

### Error: "Formato de archivo inválido"
**Causa:** Encabezados incorrectos o faltantes  
**Solución:** Usa la plantilla descargable con encabezados correctos

### Error: "Fecha inválida"
**Causa:** Formato de fecha incorrecto  
**Solución:** Usa formato YYYY-MM-DD (ejemplo: 2024-12-31)

### Error: "date_end must be after date_start"
**Causa:** Fecha de fin anterior o igual a fecha de inicio  
**Solución:** Verifica que date_end > date_start

### Período creado con número incorrecto
**Causa:** Ya existen otros períodos para ese usuario  
**Solución:** Normal - el sistema calcula automáticamente basado en períodos existentes

## Archivos Relacionados

- **Servicio:** `app/Services/VacationImportService.php`
- **Componente Livewire:** `app/Livewire/VacationReport.php`
- **Vista:** `resources/views/livewire/vacation-report.blade.php`
- **Modelo:** `app/Models/VacationsAvailable.php`
- **Documentación detallada:** `docs/IMPORTACION_VACACIONES.md`

## Logs

Los errores se registran en:
```
storage/logs/laravel.log
```

Buscar por: 
- `Error en importación masiva`
- `Error procesando fila`
- `Período actualizado para usuario`
- `Período creado para usuario`

## Pruebas

Scripts de prueba disponibles:
```bash
# Prueba de creación de períodos
php tests/test_vacation_import.php

# Prueba de actualización de períodos
php tests/test_vacation_update.php
```
