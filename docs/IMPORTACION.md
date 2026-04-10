# Importación Masiva de Vacaciones

**Última actualización:** Abril 2026

---

## 1. Descripción General

Componente Livewire `VacationImport` con proceso de 3 pasos:

1. **Subir archivo** — Cargar Excel y descargar plantilla
2. **Previsualizar** — Revisar registros válidos, corregir no identificados
3. **Resultados** — Resumen de importación

**Ruta:** `/vacaciones/importar`  
**Paquete:** `rap2hpoutre/fast-excel` (OpenSpout, NO PhpSpreadsheet)

---

## 2. Formato del Excel

### Columnas requeridas

| Columna | Ejemplo | Descripción |
|---------|---------|-------------|
| Nombre Completo | `GARCÍA LÓPEZ JUAN` | Apellidos + Nombre (mayúsculas) |
| Fecha Ingreso | `08/08/2024` | Fecha de admisión |
| Fecha Aniversario | `08/08/2025` | Fecha fin del período |
| Dias Disponibles | `12` | Saldo base del período |
| Dias Disfrutados | `5` | Días ya tomados |

### Formatos de fecha soportados
- `dd/mm/yyyy` — `08/08/2024`
- `dd-mm-yyyy` — `08-08-2024`
- `yyyy-mm-dd` — `2024-08-08`
- Números seriales de Excel

### Campos auto-calculados
- `status` — `actual` o `vencido` (basado en 15 meses después de fecha ingreso)
- `dv` (days_variation) — `0`
- `days_reserved` — `0`
- `period` — Calculado desde antigüedad

---

## 3. Identificación de Usuarios

Algoritmo de 4 niveles (en orden de prioridad):

```php
// Nivel 1: Coincidencia exacta "APELLIDOS NOMBRE"
User::whereRaw("CONCAT(TRIM(last_name), ' ', TRIM(first_name)) = ?", [$nombre])

// Nivel 2: Coincidencia exacta "NOMBRE APELLIDOS"
User::whereRaw("CONCAT(TRIM(first_name), ' ', TRIM(last_name)) = ?", [$nombre])

// Nivel 3: Búsqueda parcial (ambas partes contenidas)
User::where('last_name', 'LIKE', "%{$parts}%")
    ->where('first_name', 'LIKE', "%{$parts}%")

// Nivel 4: No identificado → va a sección de asignación manual
```

Todas las comparaciones son case-insensitive.

---

## 4. Previsualización (Paso 2)

### Sección verde — Registros válidos
- Tabla con scroll, headers sticky
- Muestra todos los campos para validación visual
- Badge con número de registros

### Sección amarilla — Registros no identificados
- Tarjetas individuales con todos los datos del registro
- Dropdown para asignación manual de usuario
- Al asignar, el registro se mueve automáticamente a la sección verde (Livewire reactivity)

```php
// Asignación manual
public function assignUser($recordIndex, $userId)
{
    // Mueve de unmatchedRecords a validRecords
}
```

---

## 5. Validaciones

### En parseo (al leer el archivo)
- Nombre no vacío
- Fechas válidas y parseables
- `días_disfrutados <= días_disponibles`

### En guardado (al importar)
- Usuario existe y está activo
- Período no duplicado (coincidencia exacta de fechas)
- Doble validación: `days_enjoyed <= days_availables`

### Coincidencia de períodos existentes
- Tolerancia de ±7 días para fechas similares
- Si hay match similar pero no exacto: rechazar, forzar corrección manual

### Mensajes de error
```
"Los días disfrutados (X) no pueden ser mayores a los días disponibles (Y)"
"No se encontró coincidencia para: NOMBRE"
"Período con fechas similares ya existe, corrija manualmente"
```

---

## 6. Generación de Plantilla

```php
FastExcel::data([
    [
        'Nombre Completo' => 'GARCÍA LÓPEZ JUAN',
        'Fecha Ingreso' => '08/08/2024',
        'Fecha Aniversario' => '08/08/2025',
        'Dias Disponibles' => 12,
        'Dias Disfrutados' => 0,
    ]
])->export($path);
```

---

## 7. Archivos Involucrados

| Archivo | Propósito |
|---------|-----------|
| `app/Livewire/VacationImport.php` | Componente Livewire con lógica de importación |
| `resources/views/livewire/vacation-import.blade.php` | Vista del wizard de 3 pasos |
| `app/Services/VacationImportService.php` | Servicio legacy (ID-based, ya no se usa) |
