# Refactorización de Servicios de Vacaciones - Principio de Responsabilidad Única (SRP)

## 📋 Resumen

Se refactorizó el sistema de cálculo de vacaciones para seguir el **Principio de Responsabilidad Única (Single Responsibility Principle)**. El servicio monolítico original se dividió en dos servicios especializados con responsabilidades claras y separadas.

---

## 🔧 Servicios Refactorizados

### 1. **VacationPeriodCreatorService**
**Responsabilidad Única**: Crear períodos de vacaciones faltantes

#### Qué hace:
- ✅ Crear SOLO períodos nuevos que no existen
- ✅ Validar fechas de ingreso
- ✅ Determinar esquema (antiguo vs actual)
- ✅ Calcular días según antigüedad (LFT México)
- ✅ Crear períodos históricos (pre-2023)
- ✅ Crear períodos actuales (post-2023)

#### Qué NO hace:
- ❌ NO modifica períodos existentes
- ❌ NO actualiza acumulación diaria
- ❌ NO marca períodos como vencidos
- ❌ NO toca `days_reserved`, `days_enjoyed`

#### Métodos públicos:
```php
createMissingPeriodsForUser(User $user): array
createMissingPeriodsForAllUsers(): array
calculateDaysForYears(int $years): int  // Para testing
```

---

### 2. **VacationDailyAccumulatorService**
**Responsabilidad Única**: Actualizar acumulación diaria de días

#### Qué hace:
- ✅ Actualizar SOLO `days_availables` en períodos activos
- ✅ Calcular acumulación proporcional diaria
- ✅ Verificar y marcar períodos vencidos
- ✅ Preservar `days_reserved` (sistema de reservas)
- ✅ Preservar `days_enjoyed` (días ya tomados)

#### Qué NO hace:
- ❌ NO crea períodos nuevos
- ❌ NO modifica períodos históricos
- ❌ NO elimina registros
- ❌ NO recalcula `days_enjoyed`

#### Métodos públicos:
```php
updateDailyAccumulation(VacationsAvailable $vacation): bool
updateDailyAccumulationForUser(int $userId): array
updateDailyAccumulationForAllUsers(): array
checkExpiredPeriodsForAllUsers(): array
```

---

## Validaciones Implementadas

### Casos Extremos Cubiertos

#### 1. **Períodos Vencidos (15 meses después del end_date)**
- Cualquier período con `date_end` + 15 meses < HOY se marca automáticamente como `status = 'vencido'`
- El comando `vacation:update-daily --check-expired` revisa y actualiza estos estados
- Los períodos vencidos siguen mostrándose en el historial pero no están disponibles para nuevas solicitudes

#### 2. **Usuario Nuevo Ingresa al Sistema**
- Se crean TODOS los períodos faltantes desde su `admission_date` hasta hoy
- Incluye períodos históricos (si aplica esquema antiguo pre-2023)
- Incluye todos los períodos actuales hasta el año en curso
- NO se resetean datos: `days_reserved` y `days_enjoyed` se preservan si ya existían

#### 3. **Usuario Existente Sin Nuevos Períodos**
- El sistema verifica si ya existe cada período antes de crearlo (`exists()` check)
- Si todos los períodos ya existen, NO se crea nada nuevo
- NO se modifican períodos existentes (preservación de datos)

#### 4. **Usuario con end_date que se Cumple HOY**
- **NUEVO**: Al ejecutar el comando, se verifica el último período del usuario
- Si `last_period.date_end <= HOY`, se crea automáticamente el **próximo período**
- El nuevo período inicia en `last_period.date_end` y termina en `+1 año`
- Calcula correctamente la antigüedad para asignar días según LFT México
- Ejemplo:
  ```
  Último período: 2024-01-15 a 2025-01-15
  Hoy: 2025-01-15
  → Se crea: 2025-01-15 a 2026-01-15 con días correspondientes al año de antigüedad
  ```

#### 5. **Cumplimiento con Regulaciones Mexicanas (LFT)**
- Esquema validado con 19 casos de prueba (comando `php artisan vacation:test`)
- Progresión de días:
  * Año 1: 12 días
  * Año 2: 14 días
  * Año 3: 16 días
  * Año 4: 18 días
  * Año 5: 20 días
  * Años 6-10: 22 días
  * Años 11-15: 24 días
  * Años 16-20: 26 días
  * Años 21-25: 28 días
  * Años 26-30: 30 días
  * Años 31+: 32 días (máximo)
- Acumulación diaria proporcional: `días_año / 365`
- Fecha de cambio de política: 2023-01-01 (separa esquema antiguo de actual)

### Prevención de Duplicados
- Cada período se identifica por: `(users_id, date_start, is_historical)`
- Antes de crear, se verifica: `exists()` con estos campos
- Si existe, se SALTA la creación (no se modifica el registro existente)

### Preservación de Datos Críticos
- `days_reserved`: Solo se modifica al reservar/liberar/deducir días en solicitudes
- `days_enjoyed`: Solo se calcula desde solicitudes aprobadas
- `days_availables`: Único campo que actualiza el acumulador diario
- Los servicios NUNCA resetean estos campos sin justificación

## Configuración de Cron Jobs

### Laravel Scheduler (Recomendado)

Los comandos están configurados en `app/Console/Kernel.php` para ejecutarse automáticamente:

```php
// 1. Crear períodos faltantes (00:00 AM diario)
$schedule->command('vacation:create-periods --all')
         ->dailyAt('00:00')
         ->timezone('America/Mexico_City')
         ->withoutOverlapping()
         ->runInBackground();

// 2. Actualizar acumulación diaria (00:05 AM diario)
$schedule->command('vacation:update-daily --all --check-expired')
         ->dailyAt('00:05')
         ->timezone('America/Mexico_City')
         ->withoutOverlapping()
         ->runInBackground();
```

### Activar el Scheduler

**En servidor Linux:**
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

**En servidor Windows (Task Scheduler):**
1. Abrir "Programador de tareas"
2. Crear tarea básica
3. Disparador: Diariamente
4. Acción: Iniciar un programa
5. Programa: `C:\xampp\php\php.exe`
6. Argumentos: `C:\xampp\htdocs\rrhh.satechenergy\artisan schedule:run`
7. Repetir cada: 1 minuto

### Ejecución Manual

Si prefieres ejecutar los comandos manualmente o desde un cron específico:

```bash
# Crear períodos faltantes
php artisan vacation:create-periods --all

# Actualizar días acumulados + verificar vencidos
php artisan vacation:update-daily --all --check-expired
```

## Migración desde Comandos Antiguos

### Comandos Obsoletos (No usar)
- ❌ `php artisan vacations:update-accrual --all`
- ❌ `php artisan vacations:check-expired`

### Comandos Nuevos (Usar)
- ✅ `php artisan vacation:create-periods --all`
- ✅ `php artisan vacation:update-daily --all --check-expired`

**Nota**: Los comandos antiguos están comentados en el Kernel pero no se eliminan para mantener compatibilidad temporal.

## Comandos Artisan

### Crear períodos faltantes
```bash
# Usuario específico
php artisan vacation:create-periods {user_id}

# Todos los usuarios
php artisan vacation:create-periods --all
```

### Actualizar acumulación diaria
```bash
# Usuario específico
php artisan vacation:update-daily {user_id}

# Todos los usuarios (ejecutar diariamente vía CRON)
php artisan vacation:update-daily --all

# Solo verificar y marcar vencidos
php artisan vacation:update-daily --check-expired
```

### Pruebas y validación
```bash
# Validar esquema LFT México
php artisan vacation:test

# Probar usuario específico
php artisan vacation:test {user_id}
```

---

## 🔄 Flujo de Trabajo Recomendado

### 1. **Al contratar un nuevo empleado**
```bash
php artisan vacation:create-periods {user_id}
```
- Crea todos los períodos desde su fecha de ingreso
- Calcula acumulación hasta hoy
- Inicializa `days_reserved = 0`

### 2. **Proceso diario automático (CRON)**
```bash
# Ejecutar todos los días a las 00:00
php artisan vacation:update-daily --all
```
- Actualiza acumulación diaria para períodos activos
- Marca períodos vencidos automáticamente
- Preserva reservas y días disfrutados

### 3. **Verificación mensual de vencimientos**
```bash
# Primer día de cada mes
php artisan vacation:update-daily --check-expired
```

---

## 📊 Ventajas de la Refactorización

### ✅ Separación de Responsabilidades
- Cada servicio hace UNA cosa bien
- Fácil de entender y mantener
- Cambios en uno no afectan al otro

### ✅ Seguridad de Datos
- **Creador**: Solo crea, nunca modifica
- **Actualizador**: Solo actualiza `days_availables`
- **Preservación**: `days_reserved` y `days_enjoyed` intactos

### ✅ Flexibilidad
- Crear períodos sin actualizar acumulación
- Actualizar acumulación sin crear períodos
- Procesos independientes ejecutables por separado

### ✅ Testing Más Fácil
- Pruebas unitarias por servicio
- Validación independiente de cada responsabilidad
- Más fácil detectar problemas

### ✅ Performance
- Procesos masivos optimizados con `chunk()`
- Logging detallado de operaciones
- Manejo de errores por servicio

---

## 🔒 Garantías de Integridad

### Sistema de Reservas
- `days_reserved` **NUNCA** se modifica por servicios de cálculo
- Solo `VacacionesController` y `RequestController` pueden modificarlo
- Acumulación diaria no afecta reservas activas

### Días Disfrutados
- `days_enjoyed` solo se calcula al **crear** períodos nuevos
- No se recalcula en actualizaciones diarias
- Solo `VacacionesRh` (al aprobar) puede modificarlo

### Períodos Históricos
- Marcados con `is_historical = true`
- **NUNCA** se actualizan o modifican
- Solo se crean si no existen

---

## 📝 Logs y Auditoría

Ambos servicios registran todas sus operaciones:

```php
// VacationPeriodCreatorService
Log::info("Período histórico creado", [...])
Log::info("Período actual creado", [...])

// VacationDailyAccumulatorService  
Log::info("Acumulación diaria actualizada", [
    'old_value' => ...,
    'new_value' => ...,
    'days_reserved' => ...,  // Validar que se preserva
    'days_enjoyed' => ...     // Validar que se preserva
])
Log::info("Periodo marcado como vencido", [...])
```

---

## 🧪 Validación

Ejecuta las pruebas para validar:

```bash
php artisan vacation:test
```

Valida:
- ✅ Esquema de días según LFT México (1-40 años)
- ✅ Preservación de `days_reserved`
- ✅ Preservación de `days_enjoyed`
- ✅ No creación de duplicados
- ✅ Acumulación diaria correcta

---

## 📅 Programación Recomendada (Cron)

```bash
# app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // Actualizar acumulación diaria todos los días a medianoche
    $schedule->command('vacation:update-daily --all')
        ->daily()
        ->at('00:00');
    
    // Verificar vencimientos el primer día de cada mes
    $schedule->command('vacation:update-daily --check-expired')
        ->monthlyOn(1, '01:00');
    
    // Crear períodos para nuevos empleados (si aplica)
    // Se ejecuta manualmente al contratar
}
```

---

## 🎓 Principio SRP Aplicado

| Servicio | Responsabilidad | Input | Output |
|----------|----------------|-------|--------|
| **VacationPeriodCreatorService** | Crear períodos nuevos | User | Array de períodos creados |
| **VacationDailyAccumulatorService** | Actualizar acumulación | VacationsAvailable | Bool/Array de resultados |

Cada servicio cumple con:
- Una razón para cambiar
- Una responsabilidad bien definida
- Independencia de otros servicios
- Fácil de probar y mantener
