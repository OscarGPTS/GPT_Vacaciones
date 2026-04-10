# Despliegue y Configuración

**Última actualización:** Abril 2026

---

## 1. Variables de Entorno

### Bases de datos

```env
# Base de datos principal (RRHH)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1          # Producción: mysql.gb.stackcp.com
DB_PORT=3306                # Producción: 43019
DB_DATABASE=rh              # Producción: rrhh_db-XXXXX
DB_USERNAME=root
DB_PASSWORD=

# Base de datos de vacaciones
DB_VACATIONS_HOST=127.0.0.1
DB_VACATIONS_PORT=3306
DB_VACATIONS_DATABASE=rh_vacations
DB_VACATIONS_USERNAME=root
DB_VACATIONS_PASSWORD=
```

### Email (SMTP)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
```

### OAuth Google

```env
GOOGLE_CLIENT_ID=tu_client_id
GOOGLE_CLIENT_SECRET=tu_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

---

## 2. Despliegue en Producción (StackCP)

### Paso 1: Configurar permisos de BD

En el panel StackCP, asignar el usuario MySQL a **ambas** bases de datos con permisos:
- SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, DROP

### Paso 2: Subir código

Subir todos los modelos con `setConnection()` configurado para relaciones cross-database.

### Paso 3: Migraciones

```bash
php artisan migrate --database=mysql_vacations \
    --path=database/migrations/2025_10_13_095851_create_vacaciones_table.php
```

### Paso 4: Limpiar cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Paso 5: NO crear vistas SQL

En producción (hosting compartido) **no se necesitan** vistas SQL cross-database. Las relaciones Eloquent con `setConnection()` resuelven todo.

---

## 3. Entorno Local (XAMPP)

### Crear base de datos de vacaciones

```bash
mysql -u root -e "CREATE DATABASE rh_vacations CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Ejecutar migraciones

```bash
php artisan migrate --database=mysql_vacations \
    --path=database/migrations/2025_10_13_095851_create_vacaciones_table.php
```

### Vistas SQL (opcional, solo local)

```bash
# Solo si necesitas whereHas cross-DB con queries raw
php artisan vacation:recreate-views --force
# O directamente:
mysql -u root < database/sql/create_cross_db_views.sql
```

### Build de assets

```bash
npm run dev          # Desarrollo
npm run watch        # Watch mode
npm run production   # Producción (minificado)
```

---

## 4. OAuth con HTTPS / Túneles

Si usas túneles (ngrok, Cloudflare) para desarrollo:

### Forzar HTTPS en Laravel

En `AppServiceProvider::boot()`:
```php
if (config('app.env') === 'production' || request()->header('X-Forwarded-Proto') === 'https') {
    URL::forceScheme('https');
}
```

### Configurar proxy de confianza

En `TrustProxies` middleware:
```php
protected $proxies = '*';
```

### Google Cloud Console

1. Agregar URL del túnel en **Authorized redirect URIs**
2. Actualizar `GOOGLE_REDIRECT_URI` en `.env`

---

## 5. Troubleshooting

### "Table 'rh.requests' doesn't exist"

**Causa:** Vistas cross-DB eliminadas (después de `migrate:fresh`).

**Solución local:**
```bash
php artisan vacation:recreate-views --force
```

**En producción:** No aplica (no usa vistas).

### "Unknown database 'rh_vacations'"

**Causa:** BD de vacaciones no existe.

```bash
mysql -u root -e "CREATE DATABASE rh_vacations CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate --database=mysql_vacations --path=database/migrations/2025_10_13_095851_create_vacaciones_table.php
```

### "Access denied for user"

**Causa:** Credenciales incorrectas o permisos faltantes.

- Verificar `.env` con credenciales correctas
- En StackCP: asignar usuario a ambas BDs con permisos completos
- `php artisan config:clear`

### "Connection refused"

**Causa:** Variables `DB_VACATIONS_*` incorrectas en `.env`.

```bash
php artisan config:clear
php artisan cache:clear
```

### whereHas no encuentra registros

**Causa local:** Vistas desincronizadas → `php artisan vacation:recreate-views --force`  
**Causa producción:** Verificar que modelos tienen `setConnection()` en relaciones BelongsTo.

### Transacciones cross-DB no son atómicas

MySQL no soporta transacciones entre BDs diferentes. Usar transacciones separadas:

```php
DB::connection('mysql')->beginTransaction();
DB::connection('mysql_vacations')->beginTransaction();
try {
    // operaciones...
    DB::connection('mysql')->commit();
    DB::connection('mysql_vacations')->commit();
} catch (\Exception $e) {
    DB::connection('mysql')->rollBack();
    DB::connection('mysql_vacations')->rollBack();
    throw $e;
}
```

### Performance lento en whereHas cross-DB

```php
// Agregar filtros antes de whereHas
User::where('active', 1)->whereHas('requestVacations', function($q) {
    $q->where('human_resources_status', 'Pendiente');
})->get();

// Usar eager loading
User::with('requestVacations')->get();
```

---

## 6. Verificación

### Script de validación

```bash
php artisan tinker
>>> $user = App\Models\User::first();
>>> $user->requestVacations()->count();      // Debe retornar número
>>> $req = App\Models\RequestVacations::first();
>>> $req->user->first_name;                  // Debe retornar nombre
```
