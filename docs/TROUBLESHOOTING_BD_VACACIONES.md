# Troubleshooting - Separación de Bases de Datos

## Problema 1: Table 'rh.requests' doesn't exist

### Síntomas
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'rh.requests' doesn't exist

Error en: User::whereHas('requestVacations')
```

### Causa
Las vistas cross-database en la BD `rh` no existen o fueron eliminadas (posiblemente después de `php artisan migrate:fresh`).

### Solución

**Opción 1 - Comando Artisan (Recomendado):**
```bash
php artisan vacation:recreate-views --force
```

**Opción 2 - SQL directo:**
```bash
mysql -u root < database/sql/create_cross_db_views.sql
```

**Opción 3 - MySQL CLI:**
```bash
mysql -u root
```
```sql
USE rh;
CREATE VIEW requests AS SELECT * FROM rh_vacations.requests;
CREATE VIEW vacations_availables AS SELECT * FROM rh_vacations.vacations_availables;
-- (repetir para las 9 tablas)
```

### Prevención
El `VacationViewsServiceProvider` debería recrear las vistas automáticamente después de cada migración en entorno local. Si no funciona, verifica que esté registrado en `config/app.php`.

---

## Problema 2: Unknown database 'rh_vacations'

### Síntomas
```
SQLSTATE[HY000] [1049] Unknown database 'rh_vacations'
```

### Causa
La base de datos `rh_vacations` no existe.

### Solución

**Crear la base de datos:**
```bash
mysql -u root -e "CREATE DATABASE rh_vacations CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

**Ejecutar las migraciones:**
```bash
php artisan migrate --path=database/migrations/2025_10_13_095851_create_vacaciones_table.php
```

**Recrear las vistas:**
```bash
php artisan vacation:recreate-views --force
```

---

## Problema 3: Connection refused al conectar a mysql_vacations

### Síntomas
```
SQLSTATE[HY000] [2002] Connection refused
```

### Causa
Las variables de entorno `DB_VACATIONS_*` no están configuradas o son incorrectas.

### Solución

**Verificar .env:**
```env
DB_VACATIONS_HOST=127.0.0.1
DB_VACATIONS_PORT=3306
DB_VACATIONS_DATABASE=rh_vacations
DB_VACATIONS_USERNAME=root
DB_VACATIONS_PASSWORD=
```

**Limpiar caches:**
```bash
php artisan config:clear
php artisan cache:clear
```

---

## Problema 4: Access denied for user 'forge'@'localhost'

### Síntomas
```
SQLSTATE[HY000] [1045] Access denied for user 'forge'@'localhost'
```

### Causa
Las credenciales de `mysql_vacations` en `.env` están usando valores por defecto incorrectos.

### Solución

**Actualizar .env con credenciales correctas:**
```env
DB_VACATIONS_USERNAME=root
DB_VACATIONS_PASSWORD=tu_password
```

**Limpiar config cache:**
```bash
php artisan config:clear
```

---

## Problema 5: whereHas no encuentra registros (pero existen)

### Síntomas
```php
User::whereHas('requestVacations')->count(); // Retorna 0 (pero hay solicitudes)
```

### Causa
Las vistas en `rh` o `rh_vacations` están desincronizadas o no existen.

### Solución

**1. Verificar que las vistas existan:**
```bash
mysql -u root -e "SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'rh' AND TABLE_NAME = 'requests';"
```

Debe retornar `VIEW`. Si retorna vacío, recrear vistas:

```bash
php artisan vacation:recreate-views --force
```

**2. Verificar que los datos existan:**
```bash
php artisan tinker --execute="echo RequestVacations::count();"
```

---

## Problema 6: Las vistas se eliminan después de migrate:fresh

### Síntomas
Después de ejecutar `php artisan migrate:fresh`, las páginas de vacaciones fallan con "Table 'rh.requests' doesn't exist".

### Causa
`migrate:fresh` elimina TODO en la BD principal, incluyendo las vistas.

### Solución

**Después de cada migrate:fresh, recrear vistas:**
```bash
php artisan migrate:fresh --seed
php artisan vacation:recreate-views --force
```

**Automatizar (si no funciona el ServiceProvider):**
Crear un alias en tu shell:
```bash
# En PowerShell (agregar a $PROFILE)
function Migrate-Fresh {
    php artisan migrate:fresh --seed
    php artisan vacation:recreate-views --force
}
```

---

## Problema 7: Performance lento en whereHas cross-DB

### Síntomas
Consultas con `whereHas()` entre bases de datos son muy lentas.

### Causa
Las vistas cross-DB no están indexadas correctamente, o hay demasiados registros sin filtrar.

### Solución

**1. Usar filtros adicionales antes de whereHas:**
```php
// ❌ Lento
User::whereHas('requestVacations')->get();

// ✅ Más rápido
User::where('active', 1)
    ->whereHas('requestVacations', function($q) {
        $q->where('human_resources_status', 'Aprobada');
    })
    ->get();
```

**2. Verificar índices en las tablas:**
```sql
-- Verificar índices en rh_vacations.requests
SHOW INDEXES FROM rh_vacations.requests;

-- Agregar índices faltantes
CREATE INDEX idx_user_id ON rh_vacations.requests(user_id);
CREATE INDEX idx_status ON rh_vacations.requests(direct_manager_status, human_resources_status);
```

**3. Usar eager loading cuando sea posible:**
```php
// ❌ N+1 queries
$users = User::all();
foreach ($users as $user) {
    $count = $user->requestVacations->count();
}

// ✅ 2 queries
$users = User::with('requestVacations')->get();
foreach ($users as $user) {
    $count = $user->requestVacations->count();
}
```

---

## Problema 8: Transacciones entre bases de datos no funcionan

### Síntomas
```php
DB::transaction(function() {
    User::create([...]); // BD: mysql
    VacationsAvailable::create([...]); // BD: mysql_vacations
    throw new Exception('Rollback'); // Solo revierte User, no VacationsAvailable
});
```

### Causa
MySQL no soporta transacciones atómicas entre bases de datos diferentes.

### Solución

**Usar transacciones separadas y manejar rollback manual:**
```php
DB::connection('mysql')->beginTransaction();
DB::connection('mysql_vacations')->beginTransaction();

try {
    $user = User::create([...]);
    $vacation = VacationsAvailable::create(['users_id' => $user->id]);
    
    DB::connection('mysql')->commit();
    DB::connection('mysql_vacations')->commit();
} catch (\Exception $e) {
    DB::connection('mysql')->rollBack();
    DB::connection('mysql_vacations')->rollBack();
    throw $e;
}
```

**O usar eventos de Eloquent para sincronización:**
```php
// En User model
protected static function booted()
{
    static::created(function ($user) {
        // Crear períodos de vacaciones automáticamente
        VacationPeriodCreatorService::createMissingPeriodsForUser($user->id);
    });
}
```

---

## Verificación general del sistema

Ejecuta este comando para verificar que todo esté bien configurado:

```bash
php tests/test_cross_db.php
```

Debe mostrar todos los tests con `✓`.

---

## Contacto soporte

Si ninguna de estas soluciones funciona, verifica:
1. Que las migraciones de vacaciones se ejecutaron correctamente
2. Que los modelos tengan `$connection = 'mysql_vacations'`
3. Que el archivo `.env` tenga las variables `DB_VACATIONS_*`
4. Que las vistas existan en ambas bases de datos

Ejecuta el script de diagnóstico completo:
```bash
php tests/test_cross_db.php
php tests/test_views_sync.php
php tests/test_user_update.php
```
