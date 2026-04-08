# Sistema de Importación Masiva de Vacaciones

## Descripción General

El sistema permite importar/actualizar datos de vacaciones masivamente desde archivos Excel, facilitando la sincronización de períodos de vacaciones de múltiples empleados con una interfaz intuitiva que permite asignación manual de usuarios no identificados.

## Ubicación

- **Ruta**: `/vacaciones/importar`
- **Componente**: `app/Livewire/VacationImport.php`
- **Vista**: `resources/views/livewire/vacation-import.blade.php`
- **Acceso**: Menú lateral → Vacaciones → Importar Vacaciones (requiere permiso `ver modulo rrhh`)

## Formato del Excel Simplificado

### Columnas Requeridas (Nombres Legibles)

| Columna | Tipo | Descripción | Ejemplo |
|---------|------|-------------|---------|
| `Nombre Completo` | String | Apellidos y nombre del empleado | GARCÍA LÓPEZ JUAN |
| `Fecha Ingreso` | Date | Fecha de inicio del período | 08/08/2024 o 2024-08-08 |
| `Fecha Aniversario` | Date | Fecha de fin del período (opcional*) | 08/08/2025 o 2025-08-08 |
| `Dias Disponibles` | Decimal | Días totales disponibles en el período | 12.00 |
| `Dias Disfrutados` | Decimal | Días ya utilizados | 5.00 |

**\* Si no se proporciona, se calcula automáticamente como 1 año después de Fecha Ingreso**

### Campos Eliminados (Calculados Automáticamente)

- **DV**: Siempre se establece en 0
- **Dias Reservados**: Siempre se establece en 0 (no hay sistema para detectarlo)
- **Status**: Se calcula automáticamente basado en 15 meses después de la Fecha Ingreso
  - Si `Fecha Ingreso + 15 meses < hoy` → `vencido`
  - De lo contrario → `actual`

### Plantilla de Ejemplo

```
Nombre Completo     | Fecha Ingreso | Fecha Aniversario | Dias Disponibles | Dias Disfrutados
--------------------|---------------|-------------------|------------------|------------------
GARCÍA LÓPEZ JUAN   | 2024-08-08    | 2025-08-08        | 12.00            | 5.00
MARTÍNEZ PÉREZ MARÍA| 2023-01-15    | 2024-01-15        | 14.00            | 8.00
```

## Flujo de Importación (3 Pasos)

### Paso 1: Cargar Archivo Excel

**Interfaz**:
- Botón "Descargar Plantilla" para obtener formato correcto
- Campo de selección de archivo (solo `.xlsx`, `.xls`)
- Botón "Procesar Archivo"

**Validaciones**:
- Archivo no vacío
- Formato Excel válido
- Tamaño máximo: 5MB

### Paso 2: Revisión y Asignación Manual

El sistema muestra un **preview detallado** con validación visual de todos los datos cargados:

#### Resumen General
- **Alert informativo** mostrando:
  - Total de registros en el archivo
  - Cantidad de registros válidos (identificados)
  - Cantidad que requieren asignación manual

#### Sección 1: Registros Válidos - Listos para Importar
- ✅ **Bloque verde** con tabla de registros identificados correctamente
- **Tabla con scroll independiente** (max 400px de altura)
- **Columnas mostradas**:
  - # (número de fila)
  - Empleado (nombre + puesto)
  - Fecha Ingreso (formato dd/mm/yyyy)
  - Fecha Aniversario (formato dd/mm/yyyy)
  - Días Disponibles (badge azul)
  - Días Disfrutados (badge celeste)
  - Status (badge verde "Actual" o amarillo "Vencido")
- **Fondo verde claro** en cada fila para identificación visual
- Muestra puesto del empleado debajo del nombre

#### Sección 2: Registros No Identificados - Requieren Asignación Manual
- ⚠️ **Bloque amarillo** con tarjetas de registros sin identificar
- **Alert explicativo** sobre el proceso de asignación
- **Layout en grilla** (2 columnas en pantallas grandes)
- **Cada tarjeta muestra**:
  - Badge "Registro #" con número correlativo
  - Nombre completo del Excel (en rojo)
  - Tabla detallada con:
    - Fecha Ingreso con icono
    - Fecha Aniversario con icono
    - Días Disponibles (badge azul)
    - Días Disfrutados (badge celeste)
    - Status (badge verde/amarillo)
  - Dropdown para asignar empleado (lista completa de activos)
- **Asignación dinámica**: Al seleccionar un empleado:
  - Notificación de éxito
  - Registro se mueve automáticamente a Sección 1
  - Contadores se actualizan en tiempo real

**Ventajas de la nueva interfaz**:
- Clara separación visual entre registros válidos y pendientes
- Preview completo de TODOS los datos antes de importar
- Usuario puede validar fechas, días y status calculado
- Evita confusión entre tablas con colores y bloques diferenciados
- Espacio adecuado para cada sección (no hay overlapping)

**Botones de Acción**:
- "Cancelar" - Reinicia proceso completo
- "Importar X Registro(s)" - Procede con registros identificados
  - Deshabilitado si no hay registros válidos
  - Muestra cantidad exacta de registros a procesar
  - Indicador de carga durante importación

**Alert informativo** (si hay pendientes):
- Muestra cantidad de registros sin asignar
- Informa que se puede continuar solo con válidos o completar todos

#### Ejemplo Visual del Preview

```
┌─────────────────────────────────────────────────────────────────────┐
│ ℹ️ Preview de Datos Cargados                                       │
│ Total: 5 registros • 3 válidos • 2 requieren asignación            │
└─────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│ ✅ Registros Válidos - Listos para Importar          [3 registros]  │
├───┬─────────────────────────┬────────────┬────────────┬──────┬──────┤
│ # │ Empleado                │ F.Ingreso  │ F.Aniversar│ Disp │ Disfr│
├───┼─────────────────────────┼────────────┼────────────┼──────┼──────┤
│ 1 │ GARCÍA LÓPEZ JUAN       │ 08/08/2024 │ 08/08/2025 │  12  │  5   │
│   │ Gerente de Proyectos    │            │            │      │      │
├───┼─────────────────────────┼────────────┼────────────┼──────┼──────┤
│ 2 │ MARTÍNEZ PÉREZ MARÍA    │ 15/01/2023 │ 15/01/2024 │  14  │  8   │
│   │ Analista de RRHH        │            │            │      │      │
└───┴─────────────────────────┴────────────┴────────────┴──────┴──────┘

┌─────────────────────────────────────────────────────────────────────┐
│ ⚠️  Registros No Identificados - Asignación Manual   [2 registros]  │
├─────────────────────────────────────────────────────────────────────┤
│ ┌─────────────────────────────┐  ┌─────────────────────────────┐   │
│ │ Registro 1  [No identificado]│  │ Registro 2  [No identificado]│   │
│ │ ❌ LOPEZ GARCIA PEDRO       │  │ ❌ HERNANDEZ ANA            │   │
│ │                             │  │                             │   │
│ │ 📅 Fecha Ingreso: 10/03/2024│  │ 📅 Fecha Ingreso: 20/05/2023│   │
│ │ 📅 F.Aniversario: 10/03/2025│  │ 📅 F.Aniversario: 20/05/2024│   │
│ │ 📊 Días Disponibles: 10     │  │ 📊 Días Disponibles: 12     │   │
│ │ 🏖️  Días Disfrutados: 3     │  │ 🏖️  Días Disfrutados: 6     │   │
│ │                             │  │                             │   │
│ │ Asignar a empleado:         │  │ Asignar a empleado:         │   │
│ │ [Dropdown con lista ▼]      │  │ [Dropdown con lista ▼]      │   │
│ └─────────────────────────────┘  └─────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────┘

[Cancelar]                           [Importar 3 Registro(s) →]

ℹ️ Quedan 2 registro(s) sin asignar. Puedes continuar con la 
   importación de los registros válidos o asignar todos primero.
```


### Paso 3: Resultados

**Estadísticas**:
- Total Procesados
- Creados (períodos nuevos)
- Actualizados (períodos existentes)
- Errores

**Detalles de Errores** (si los hay):
- Nombre del empleado
- Mensaje de error específico

**Advertencia de Pendientes**:
Si quedaron registros sin asignar, se muestra la cantidad

**Acciones**:
- "Ver Reporte de Vacaciones" - Ir al reporte completo
- "Nueva Importación" - Reiniciar proceso

## Lógica de Identificación de Usuarios

### Búsqueda Automática por Nombre (Case-Insensitive)

El sistema utiliza un algoritmo robusto de identificación que normaliza los nombres antes de comparar:

#### 1. Normalización del Input
```php
// Convierte a mayúsculas y elimina espacios múltiples
$nombreNormalizado = strtoupper(trim(preg_replace('/\s+/', ' ', $nombreCompleto)));
// Ejemplo: "  garcía   lópez  juan  " → "GARCÍA LÓPEZ JUAN"
```

#### 2. Búsqueda Exacta (APELLIDO NOMBRE)
```php
UPPER(TRIM(CONCAT(TRIM(last_name), ' ', TRIM(first_name)))) = 'GARCÍA LÓPEZ JUAN'
```

#### 3. Búsqueda Invertida (NOMBRE APELLIDO)
```php
UPPER(TRIM(CONCAT(TRIM(first_name), ' ', TRIM(last_name)))) = 'JUAN GARCÍA LÓPEZ'
```

#### 4. Búsqueda Parcial por Apellido (Fallback)
Si no encuentra coincidencia exacta, busca por las primeras dos palabras:
```php
UPPER(TRIM(last_name)) LIKE 'GARCÍA LÓPEZ%'
```

### Formatos de Nombre Soportados

✅ **Todos estos formatos identifican al mismo usuario:**

| Formato en Excel | Descripción | Ejemplo |
|------------------|-------------|---------|
| `GARCÍA LÓPEZ JUAN` | TODO MAYÚSCULAS | ✅ Funciona |
| `garcía lópez juan` | todo minúsculas | ✅ Funciona |
| `García López Juan` | Título Case | ✅ Funciona |
| `GaRcÍa LóPeZ jUaN` | Mixto aleatorio | ✅ Funciona |
| `JUAN GARCÍA LÓPEZ` | Invertido (nombre primero) | ✅ Funciona |
| `  García  López  Juan  ` | Con espacios extras | ✅ Funciona |

### Ventajas de la Normalización

1. **Insensible a mayúsculas/minúsculas**: Acepta cualquier combinación
2. **Maneja espacios múltiples**: Ignora espacios dobles, triples, etc.
3. **Trim automático**: Elimina espacios al inicio y final
4. **Orden flexible**: Funciona con "APELLIDO NOMBRE" o "NOMBRE APELLIDO"
5. **Búsqueda parcial**: Como último recurso, busca por apellido

### Condiciones de Búsqueda

**Requisitos**:
- Solo usuarios con `active = 1`
- Comparación case-insensitive con `UPPER()`
- Trim de espacios con `TRIM()`

### Casos de Identificación Fallida

El usuario NO se identifica si:
1. ❌ **Nombre incompleto**: "GARCÍA" sin apellido materno ni nombre
2. ❌ **Empleado inactivo**: `active = 0` en la base de datos
3. ❌ **No existe en DB**: El empleado no está registrado
4. ❌ **Caracteres completamente diferentes**: "PÉREZ" vs "GARCÍA"
5. ⚠️ **Nombres muy similares**: Podría identificar al usuario equivocado (revisar en preview)

**Solución**: Asignación manual en Paso 2 con dropdown de empleados activos

## Procesamiento de Registros

### 1. Búsqueda Inteligente de Período Existente

El sistema utiliza una **estrategia de 3 niveles** para evitar duplicados cuando las fechas del Excel difieren ligeramente de la base de datos:

#### Nivel 1: Búsqueda por Fecha Exacta
```php
$period = VacationsAvailable::where('users_id', $userId)
    ->where('date_start', $dateStart)
    ->where('is_historical', false)
    ->first();
```
**Si encuentra:** ✅ Actualiza el período existente

#### Nivel 2: Búsqueda por Número de Período
```php
$periodNumber = calculatePeriodNumber($userId, $dateStart);
$period = VacationsAvailable::where('users_id', $userId)
    ->where('period', $periodNumber)
    ->where('is_historical', false)
    ->first();
```
**Si encuentra:** ✅ Actualiza el período existente (aunque la fecha sea diferente)

#### Nivel 3: Búsqueda por Rango de Fechas Cercanas (±30 días)
```php
$dateStartMinus = $dateStart->copy()->subDays(30);
$dateStartPlus = $dateStart->copy()->addDays(30);

$period = VacationsAvailable::where('users_id', $userId)
    ->whereBetween('date_start', [$dateStartMinus, $dateStartPlus])
    ->where('is_historical', false)
    ->orderByRaw('ABS(DATEDIFF(date_start, ?))', [$dateStart])
    ->first();
```
**Si encuentra:** ✅ Actualiza el período más cercano (y actualiza también la fecha)

#### Sin Coincidencia
**Si NO encuentra en ningún nivel:** ➕ Crea un nuevo período

### Escenarios de Uso

| Escenario | Fecha en DB | Fecha en Excel | Acción del Sistema |
|-----------|-------------|----------------|-------------------|
| **Fecha exacta** | 2024-08-08 | 2024-08-08 | ✅ Actualiza (Nivel 1) |
| **Error de captura leve** | 2024-08-08 | 2024-08-10 (+2 días) | ✅ Actualiza (Nivel 3 - Rango) |
| **Corrección de fecha** | 2024-08-08 | 2024-08-15 (+7 días) | ✅ Actualiza (Nivel 3 - Rango) |
| **Variación moderada** | 2024-08-08 | 2024-08-28 (+20 días) | ✅ Actualiza (Nivel 3 - Rango) |
| **Límite del rango** | 2024-08-08 | 2024-09-06 (+29 días) | ✅ Actualiza (Nivel 3 - Rango) |
| **Fuera de rango** | 2024-08-08 | 2024-10-08 (+61 días) | ➕ Crea nuevo período |
| **Período siguiente** | 2024-08-08 | 2025-08-08 (+1 año) | ➕ Crea nuevo período |

### Ventajas de la Búsqueda Multinivel

1. **Tolerancia a errores de captura**: Acepta diferencias de ±30 días
2. **Previene duplicados**: Busca por fecha, número de período y rango
3. **Actualiza fechas incorrectas**: Si encuentra por rango, corrige la fecha en DB
4. **Inteligente**: Selecciona el período más cercano en caso de múltiples coincidencias
5. **Flexible**: Permite correcciones menores sin crear duplicados

**Criterios de búsqueda**:
- Mismo `user_id`
- Fecha `date_start` (exacta, por número, o en rango ±30 días)
- Solo períodos no históricos (`is_historical = false`)

### 2. Actualización o Creación

**SI EL PERÍODO EXISTE (UPDATE)**:
```php
$period->update([
    'date_end' => $fechaAniversario,
    'days_availables' => $diasDisponibles,
    'days_enjoyed' => $diasDisfrutados,
    'status' => $status, // Calculado automáticamente
]);
```

**SI EL PERÍODO NO EXISTE (CREATE)**:
```php
VacationsAvailable::create([
    'users_id' => $userId,
    'period' => $periodNumber, // Auto-calculado
    'date_start' => $fechaIngreso,
    'date_end' => $fechaAniversario,
    'days_availables' => $diasDisponibles,
    'dv' => 0, // Fijo
    'days_enjoyed' => $diasDisfrutados,
    'days_reserved' => 0, // Fijo
    'status' => $status, // Auto-calculado
    'is_historical' => false,
]);
```

### 3. Cálculo de Número de Período

Cuenta períodos anteriores del mismo usuario:

```php
$existingPeriodsCount = VacationsAvailable::where('users_id', $userId)
    ->where('is_historical', false)
    ->where('date_start', '<', $fechaIngreso)
    ->count();

$periodNumber = $existingPeriodsCount + 1;
```

### 4. Cálculo Automático de Status

```php
$fechaLimite = Carbon::parse($fechaIngreso)->addMonths(15);

if (Carbon::now()->greaterThan($fechaLimite)) {
    $status = 'vencido';
} else {
    $status = 'actual';
}
```

## Casos de Uso

### Caso 1: Importación Inicial de Empleado Nuevo

**Escenario**: Un empleado acaba de ingresar y necesitas crear su primer período.

**Excel**:
```
Nombre Completo       | Fecha Ingreso | Fecha Aniversario | Dias Disponibles | Dias Disfrutados
----------------------|---------------|-------------------|------------------|------------------
NUEVO EMPLEADO CARLOS | 2024-11-01    | 2025-11-01        | 12               | 0
```

**Resultado**:
- Sistema identifica al empleado automáticamente
- Crea período con `period = 1`
- Status: `actual` (no han pasado 15 meses)

### Caso 2: Actualizar Días Disfrutados

**Escenario**: Un empleado tomó vacaciones y necesitas actualizar sus días disfrutados.

**Excel**:
```
Nombre Completo     | Fecha Ingreso | Fecha Aniversario | Dias Disponibles | Dias Disfrutados
--------------------|---------------|-------------------|------------------|------------------
GARCÍA LÓPEZ JUAN   | 2024-08-08    | 2025-08-08        | 12               | 8
```

**Proceso**:
1. Sistema encuentra período existente por `user_id + date_start`
2. Actualiza `days_enjoyed` de 5 → 8
3. Resultado: "1 actualizado"

### Caso 3: Múltiples Períodos de Mismo Empleado

**Escenario**: Empleado con varios períodos (actual + históricos).

**Excel**:
```
Nombre Completo     | Fecha Ingreso | Fecha Aniversario | Dias Disponibles | Dias Disfrutados
--------------------|---------------|-------------------|------------------|------------------
GARCÍA LÓPEZ JUAN   | 2023-08-08    | 2024-08-08        | 12               | 12
GARCÍA LÓPEZ JUAN   | 2024-08-08    | 2025-08-08        | 12               | 5
```

**Resultado**:
- Primer registro: Período 1, Status: `vencido` (>15 meses)
- Segundo registro: Período 2, Status: `actual`

### Caso 4: Nombre No Identificado

**Escenario**: El nombre en Excel no coincide con la BD.

**Excel**: `GARCIA LOPEZ JUAN` (sin acento)
**BD**: `GARCÍA LÓPEZ JUAN` (con acento)

**Proceso**:
1. Sistema no identifica automáticamente
2. Aparece en tabla de "Registros Sin Identificar"
3. Usuario selecciona manualmente del dropdown
4. Se mueve a tabla de "Identificados"
5. Procede con importación

## Validaciones y Reglas

### Validaciones de Formato

- **Nombre Completo**: Requerido, string
- **Fecha Ingreso**: Requerida, formato fecha válido
- **Fecha Aniversario**: Opcional, formato fecha válido
- **Dias Disponibles**: Requerido, numérico, >= 0
- **Dias Disfrutados**: Requerido, numérico, >= 0
  - **REGLA CRÍTICA**: Días disfrutados NO pueden ser mayores a días disponibles
  - Error: "Los días disfrutados (X) no pueden ser mayores a los días disponibles (Y)"

### Parseo de Fechas

El sistema acepta múltiples formatos:

```php
// Excel serial number
25569 → 1970-01-01

// Texto
"08/08/2024" → 2024-08-08
"2024-08-08" → 2024-08-08
"08-Ago-2024" → 2024-08-08
```

### Reglas de Negocio

1. **Usuario debe existir y estar activo**: `active = 1`
2. **Unicidad**: Solo un período por `user_id + date_start + is_historical=false`
3. **Valores positivos**: Días no pueden ser negativos
4. **Días disfrutados <= Días disponibles**: Validación crítica para evitar inconsistencias
   - Se valida tanto al parsear el Excel como al guardar en BD
   - Los registros que violen esta regla van a "Errores"
5. **Fecha Aniversario calculada**: Si no viene, se agrega 1 año a Fecha Ingreso
6. **Fechas exactas**: El sistema requiere coincidencia exacta de `date_start`
   - Si existe período con fecha similar (±7 días), se marca como error
   - El usuario debe corregir la fecha en el Excel manualmente

## Transacciones y Seguridad

### Transacciones de Base de Datos

```php
DB::beginTransaction();
try {
    foreach ($validRecords as $record) {
        $this->importRecord($record);
    }
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    // Todos los cambios se revierten
}
```

**Comportamiento**:
- Si hay error crítico, SE REVIERTE TODO
- Errores individuales se registran pero no detienen el proceso

### Logging

```php
Log::info('Error importando registro', [
    'nombre' => 'GARCÍA LÓPEZ JUAN',
    'error' => 'Usuario no identificado'
]);
```

## Ventajas del Nuevo Sistema

### Para el Usuario

✅ **Nombres legibles** en lugar de IDs numéricos
✅ **Interfaz visual** para resolver conflictos
✅ **Feedback inmediato** de qué se identificó y qué no
✅ **Asignación manual** sin editar Excel
✅ **Menos campos** para completar (DV, reservados, status auto-calculados)

### Para el Sistema

✅ **Vista dedicada** separada del reporte
✅ **Proceso en pasos** (upload → review → import)
✅ **Validación temprana** antes de guardar
✅ **Manejo de múltiples períodos** por empleado
✅ **Logging completo** para auditoría

## Limitaciones

1. **No elimina períodos**: Solo crea o actualiza
2. **Búsqueda exacta**: No usa fuzzy matching para nombres
3. **Un período por fecha**: No permite múltiples períodos con misma `date_start`
4. **Solo períodos activos**: `is_historical` siempre `false`
5. **Días reservados en 0**: No hay detección automática

## Recomendaciones

1. **Descargar plantilla** siempre para formato correcto
2. **Verificar nombres** que coincidan EXACTAMENTE con la BD
3. **Importar en lotes** de 50-100 registros máximo
4. **Revisar asignaciones manuales** antes de confirmar
5. **Verificar resultados** en Reporte de Vacaciones después
6. **Backup antes de importaciones masivas**

## Soporte Técnico

Para problemas reportar:
- Archivo Excel usado (sanitizar datos sensibles)
- Screenshot del Paso 2 (tabla de no identificados)
- Screenshot de Resultados
- Logs: `storage/logs/laravel.log`


## Flujo de Importación

### 1. Descarga de Plantilla

**Acción**: Clic en botón "Descargar Plantilla"

**Resultado**: Se genera y descarga archivo Excel con:
- Encabezados correctos
- 3 filas de ejemplo
- Formato listo para usar

**Código**:
```php
$service = new VacationImportService();
$fileName = $service->generateTemplate();
// Genera: storage/app/public/plantilla_importacion_vacaciones_YYYYMMDDHHMMSS.xlsx
```

### 2. Carga de Archivo

**Acción**: Usuario selecciona archivo Excel y hace clic en "Importar"

**Validación**:
- Formato: `.xlsx` o `.xls`
- Tamaño máximo: 10MB
- Encabezados correctos

### 3. Procesamiento

Para cada fila del Excel:

#### 3.1. Validación de Datos

```php
$validator = Validator::make($data, [
    'user_id' => 'required|integer|exists:users,id',
    'date_start' => 'required|date',
    'date_end' => 'required|date|after:date_start',
    'days_availables' => 'required|numeric|min:0',
    'dv' => 'nullable|numeric|min:0',
    'days_enjoyed' => 'nullable|numeric|min:0',
    'days_reserved' => 'nullable|numeric|min:0',
    'status' => 'required|in:actual,vencido',
]);
```

#### 3.2. Búsqueda de Período Existente

```php
$period = VacationsAvailable::where('users_id', $data['user_id'])
    ->where('date_start', $dateStart->format('Y-m-d'))
    ->where('is_historical', false)
    ->first();
```

**Criterios de búsqueda**:
- `user_id`: Mismo usuario
- `date_start`: Misma fecha de inicio
- `is_historical = false`: Solo períodos actuales

#### 3.3. Actualización o Creación

**SI EL PERÍODO EXISTE**:
```php
$period->date_end = $dateEnd;
$period->days_availables = $data['days_availables'];
$period->dv = $data['dv'];
$period->days_enjoyed = $data['days_enjoyed'];
$period->days_reserved = $data['days_reserved'];
$period->status = $data['status'];
$period->save();

// Resultado: 'updated'
```

**SI EL PERÍODO NO EXISTE**:
```php
VacationsAvailable::create([
    'users_id' => $data['user_id'],
    'period' => $periodNumber,  // Calculado automáticamente
    'date_start' => $dateStart,
    'date_end' => $dateEnd,
    'days_availables' => $data['days_availables'],
    'dv' => $data['dv'],
    'days_enjoyed' => $data['days_enjoyed'],
    'days_reserved' => $data['days_reserved'],
    'status' => $data['status'],
    'is_historical' => false,
]);

// Resultado: 'created'
```

#### 3.4. Cálculo Automático de Número de Período

Cuando se crea un período nuevo, el número se calcula contando períodos anteriores:

```php
protected function calculatePeriodNumber(int $userId, Carbon $dateStart): int
{
    $existingPeriodsCount = VacationsAvailable::where('users_id', $userId)
        ->where('is_historical', false)
        ->where('date_start', '<', $dateStart->format('Y-m-d'))
        ->count();

    return $existingPeriodsCount + 1;
}
```

### 4. Resultados

Después del procesamiento, se muestra modal con:

#### Estadísticas
- **Procesados**: Total de filas procesadas
- **Actualizados**: Períodos que ya existían y fueron actualizados
- **Creados**: Períodos nuevos creados
- **Errores**: Filas con errores de validación o procesamiento

#### Detalles de Errores (si los hay)
- Número de fila
- Mensaje de error específico

## Casos de Uso

### Caso 1: Actualizar Días Disfrutados/Reservados

**Escenario**: Un empleado tiene 2 períodos activos y necesitas actualizar cuántos días ha disfrutado.

**Proceso**:
1. Descargar plantilla
2. Llenar solo las filas de los períodos a actualizar
3. Modificar valores de `days_enjoyed` y/o `days_reserved`
4. Importar archivo

**Resultado**: Los períodos se actualizan manteniendo el mismo `period_id`.

### Caso 2: Crear Períodos para Empleados Nuevos

**Escenario**: Nuevos empleados sin períodos de vacaciones.

**Proceso**:
1. Descargar plantilla
2. Agregar filas con los datos de los nuevos períodos
3. Asegurarse que `date_start` no exista para ese usuario
4. Importar archivo

**Resultado**: Se crean los períodos con `period` calculado automáticamente.

### Caso 3: Importación Masiva Inicial

**Escenario**: Migración de sistema antiguo con datos de 100+ empleados.

**Proceso**:
1. Exportar datos del sistema antiguo
2. Adaptar al formato de la plantilla
3. Importar en lotes (recomendado: 50-100 registros por archivo)

**Resultado**: Creación masiva de períodos.

## Validaciones y Reglas

### Reglas de Negocio

1. **Usuario debe existir**: El `user_id` debe corresponder a un usuario activo
2. **Fechas válidas**: `date_end` debe ser posterior a `date_start`
3. **Valores positivos**: Todos los días deben ser >= 0
4. **Estado válido**: Solo `actual` o `vencido`
5. **Unicidad**: Solo un período por `user_id` + `date_start` + `is_historical=false`

### Manejo de Errores

**Errores de Validación**:
```
Fila 5: The user_id field must exist in users table.
Fila 8: The date_end must be a date after date_start.
```

**Errores de Base de Datos**:
```
Fila 12: Usuario 999 no encontrado
```

Todos los errores se muestran en el modal de resultados sin detener el proceso completo.

## Transacciones

El proceso usa transacciones de base de datos:

```php
DB::beginTransaction();
try {
    // Procesar todas las filas
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    // Revertir todos los cambios
}
```

**Comportamiento**: Si hay un error crítico, TODAS las importaciones se revierten.

## Logging

Cada operación se registra en los logs de Laravel:

```php
Log::info("Período actualizado para usuario {$userId}", [
    'period_id' => $period->id,
    'date_start' => '2024-08-08',
    'date_end' => '2025-08-08'
]);

Log::info("Período creado para usuario {$userId}", [
    'period_id' => $newPeriod->id,
    'period_number' => 2,
    'date_start' => '2024-08-08',
    'date_end' => '2025-08-08'
]);
```

## Pruebas

### Prueba de Creación

```bash
php tests/test_vacation_import.php
```

Valida:
- Generación de plantilla
- Creación de períodos nuevos
- Cálculo correcto de `period`

### Prueba de Actualización

```bash
php tests/test_vacation_update.php
```

Valida:
- Actualización de períodos existentes
- Preservación de `period_id`
- Cambios en días disfrutados/reservados

## Limitaciones

1. **No elimina períodos**: Solo crea o actualiza
2. **No valida lógica de negocio compleja**: No verifica si los días disfrutados exceden disponibles
3. **Un período por `date_start`**: No permite múltiples períodos con la misma fecha de inicio
4. **Solo períodos no históricos**: `is_historical` siempre es `false` para importaciones

## Recomendaciones

1. **Siempre usar plantilla**: Garantiza formato correcto
2. **Importar en lotes**: No más de 100 registros por archivo
3. **Validar datos primero**: Revisar que todos los `user_id` existan
4. **Backup antes de importar**: Especialmente en importaciones masivas
5. **Revisar resultados**: Verificar estadísticas y corregir errores
6. **Logs para auditoría**: Los logs contienen detalles de cada cambio

## Soporte Técnico

Para problemas contactar al equipo de desarrollo con:
- Archivo Excel usado
- Mensaje de error exacto
- Screenshot del modal de resultados
- Logs de `storage/logs/laravel.log`
