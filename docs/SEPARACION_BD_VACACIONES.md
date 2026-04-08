# Separación de Bases de Datos - Sistema de Vacaciones

## Arquitectura Implementada

El sistema ahora utiliza **2 bases de datos** en el mismo servidor MySQL:

| Base de datos | Tablas reales | Vistas |
|---|---|---|
| **`rh`** (principal) | `users`, `jobs`, `departamentos`, etc. | 9 vistas → `rh_vacations.*` |
| **`rh_vacations`** (vacaciones) | 9 tablas de vacaciones | 3 vistas → `rh.users/jobs/departamentos` |

---

## Tablas migradas a `rh_vacations`

Las siguientes tablas ahora existen físicamente en `rh_vacations`:

1. `requests` - Solicitudes de vacaciones/permisos
2. `vacations_availables` - Períodos de vacaciones por empleado
3. `request_approved` - Días aprobados detallados
4. `request_rejected` - Días rechazados
5. `vacation_per_years` - Catálogo de días por antigüedad (LFT México)
6. `no_working_days` - Días no laborables (festivos)
7. `direction_approvers` - Aprobadores de dirección personalizados
8. `manager_approvers` - Jefes directos personalizados
9. `system_logs` - Logs del sistema

---

## Vistas para transparencia cross-database

### En `rh` (BD principal)
Se crearon **9 vistas** que apuntan a las tablas reales en `rh_vacations`:

```sql
CREATE VIEW rh.requests AS SELECT * FROM rh_vacations.requests;
CREATE VIEW rh.vacations_availables AS SELECT * FROM rh_vacations.vacations_availables;
-- (... resto de tablas)
```

**Propósito**: Permitir que el modelo `User` (en BD principal) pueda hacer `whereHas('requestVacations')`.

### En `rh_vacations` (BD vacaciones)
Se crearon **3 vistas** que apuntan a las tablas reales en `rh`:

```sql
CREATE VIEW rh_vacations.users AS SELECT * FROM rh.users;
CREATE VIEW rh_vacations.jobs AS SELECT * FROM rh.jobs;
CREATE VIEW rh_vacations.departamentos AS SELECT * FROM rh.departamentos;
```

**Propósito**: Permitir que los modelos de vacaciones puedan hacer `whereHas('user.job.departamento')`.

---

## Configuración de modelos

### Modelos en BD principal (`rh`)

```php
// app/Models/User.php
protected $connection = 'mysql';  // BD principal
protected $table = 'users';
```

- ✅ **Escritura**: Siempre escribe en `rh.users` (tabla real)
- ✅ **Lectura**: Siempre lee de `rh.users` (tabla real)
- ✅ No usa la vista `rh_vacations.users` para nada

### Modelos en BD vacaciones (`rh_vacations`)

```php
// app/Models/RequestVacations.php
protected $connection = 'mysql_vacations';  // BD separada
public $table = 'requests';
```

Todos estos modelos tienen `$connection = 'mysql_vacations'`:
- `RequestVacations`
- `VacationsAvailable`
- `RequestApproved`
- `RequestRejected`
- `VacationPerYear`
- `NoWorkingDays`
- `DirectionApprover`
- `ManagerApprover`
- `SystemLog`

---

## Relaciones cross-database (cómo funcionan)

### Caso 1: User → RequestVacations (HasMany)

```php
// En User.php (BD: mysql)
public function requestVacations(): HasMany
{
    return $this->hasMany(RequestVacations::class, 'user_id');
}

// Uso:
$user = User::find(1);
$requests = $user->requestVacations; // ✅ Funciona (queries separadas)
```

**Detrás de escenas:**
1. Laravel consulta: `SELECT * FROM rh.users WHERE id = 1`
2. Luego consulta: `SELECT * FROM rh_vacations.requests WHERE user_id = 1`
3. Combina resultados en memoria

### Caso 2: RequestVacations → User (BelongsTo)

```php
// En RequestVacations.php (BD: mysql_vacations)
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

// Uso:
$request = RequestVacations::find(1);
$user = $request->user; // ✅ Funciona
```

**Detrás de escenas:**
1. Laravel consulta: `SELECT * FROM rh_vacations.requests WHERE id = 1`
2. Detecta `user_id = 13`
3. Consulta: `SELECT * FROM rh.users WHERE id = 13` (usa conexión de User)

### Caso 3: whereHas con cross-DB (usa vistas)

```php
// Filtrar usuarios que tienen solicitudes de vacaciones
$users = User::whereHas('requestVacations')->get();
```

**Detrás de escenas:**
1. Laravel genera: `SELECT * FROM rh.users WHERE EXISTS (SELECT * FROM rh.requests WHERE user_id = users.id)`
2. MySQL resuelve `rh.requests` → **vista** → `SELECT * FROM rh_vacations.requests`
3. ✅ Funciona transparentemente gracias a las vistas

---

## Actualización de datos (FAQ)

### ✅ Actualizar usuarios

```php
$user = User::find(1);
$user->admission = '2026-04-07';  // Cambiar fecha de admisión
$user->active = 1;                // Activar usuario
$user->save();                    // ✅ Escribe en rh.users (tabla real)
```

**¿Se sincroniza la vista?** → **SÍ, automáticamente**
- La vista `rh_vacations.users` ejecuta `SELECT * FROM rh.users` en tiempo real
- No hay sincronización manual, es instantánea

### ✅ Actualizar vacaciones

```php
$vacation = VacationsAvailable::find(1);
$vacation->days_availables = 24;
$vacation->save();  // ✅ Escribe en rh_vacations.vacations_availables (tabla real)
```

**¿Se sincroniza la vista?** → **SÍ, automáticamente**
- La vista `rh.vacations_availables` refleja cambios al instante

### ✅ Crear nuevos registros

```php
// Crear usuario
User::create([...]);  // ✅ Inserta en rh.users → Vista se actualiza sola

// Crear período de vacaciones
VacationsAvailable::create([...]);  // ✅ Inserta en rh_vacations.vacations_availables
```

### ✅ Eliminar registros

```php
User::destroy(1);  // ✅ Elimina de rh.users → Vista refleja cambio
```

**Importante**: Las foreign keys cross-database fueron removidas de la migración (MySQL no las soporta entre BDs). Las eliminaciones en cascada se manejan a nivel aplicación (eventos de Eloquent).

---

## Queries directas con DB::table()

### ❌ INCORRECTO (usa conexión por defecto)
```php
DB::table('vacations_availables')->get();  // ❌ Buscará en 'rh' (conexión default)
```

### ✅ CORRECTO (especifica conexión)
```php
DB::connection('mysql_vacations')->table('vacations_availables')->get();
```

**Alternativa mejor**: Usa el modelo Eloquent en lugar de queries directas:
```php
VacationsAvailable::all();  // ✅ Usa automáticamente 'mysql_vacations'
```

---

## Archivos modificados

| Archivo | Cambio |
|---|---|
| `.env` | Variables `DB_VACATIONS_*` |
| `config/database.php` | Conexión `mysql_vacations` |
| 9 modelos en `app/Models/` | `$connection = 'mysql_vacations'` |
| `database/migrations/2025_10_13_095851_create_vacaciones_table.php` | `Schema::connection('mysql_vacations')`, FKs reemplazados por índices |
| `app/Http/Controllers/RequestController.php` (línea 350) | `DB::connection('mysql_vacations')` |

---

## Validación del sistema

Ejecuta los tests de validación:

```bash
# Test de conexiones y relaciones cross-DB
php tests/test_cross_db.php

# Test de sincronización de vistas
php tests/test_views_sync.php

# Test de actualización de usuarios
php tests/test_user_update.php
```

Todos deben pasar con `✓`.

---

## ⚠️ Recrear vistas si se pierden

**IMPORTANTE**: Si ejecutas `php artisan migrate:fresh` o las vistas se eliminan por algún motivo, debes recrearlas.

### Síntomas de vistas faltantes:
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'rh.requests' doesn't exist
```

### Solución rápida (Comando Artisan):
```bash
php artisan vacation:recreate-views --force
```

### Solución alternativa (SQL directo):
```bash
mysql -u root < database/sql/create_cross_db_views.sql
```

**Cuándo ejecutar:**
- Después de `php artisan migrate:fresh`
- Después de restaurar un backup de la BD
- Si ves errores de "Table 'rh.requests' doesn't exist"
- Después de clonar el proyecto en un nuevo entorno

---

## Ventajas de esta arquitectura

1. **Separación de responsabilidades**: Vacaciones en BD independiente
2. **Transparencia total**: Código existente sigue funcionando sin cambios
3. **Sin pérdida de funcionalidad**: Las vistas resuelven `whereHas()` cross-DB
4. **Escalabilidad**: Puedes mover `rh_vacations` a otro servidor en el futuro
5. **Backups independientes**: Puedes respaldar solo vacaciones sin tocar RRHH
6. **Performance**: Queries grandes de vacaciones no afectan RRHH

---

## Restricciones conocidas

1. **No hay foreign keys reales entre BDs**: Se manejan a nivel aplicación (Eloquent)
2. **Transacciones separadas**: No puedes hacer transacciones atómicas entre ambas BDs
3. **Joins directos no funcionan**: Usa relaciones Eloquent en lugar de joins SQL manuales
4. **Vistas son read-only para relaciones**: Solo tablas reales permiten escritura directa

---

## Rollback (si es necesario)

Si necesitas revertir:

```sql
-- 1. Copiar datos de vuelta
CREATE TABLE rh.requests LIKE rh_vacations.requests;
INSERT INTO rh.requests SELECT * FROM rh_vacations.requests;
-- (repetir para las 9 tablas)

-- 2. Eliminar vistas
DROP VIEW rh.requests;
-- (repetir para todas las vistas)

-- 3. Revertir modelos (quitar $connection = 'mysql_vacations')
```

---

## Autor
Implementado en abril 2026 - Branch: `database-separator`
