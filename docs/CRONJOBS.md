# Despliegue de Cron Jobs — RRHH Satech Energy

**Última actualización:** Abril 2026

---

## Resumen de tareas programadas

| Comando | Tipo | Hora | Descripción |
|---|---|---|---|
| `vacation:create-periods --all` | Producción | 00:00 diario | Crea períodos de vacaciones faltantes |
| `vacation:update-daily --all --check-expired` | Producción | 00:05 diario | Acumulación diaria + marca vencidos |
| `vacations:auto-approve` | Producción | 09:00 diario | Aprueba automáticamente solicitudes >5 días |
| `cron:test-log` | Validación | Cada minuto | Escribe en `system_logs` para confirmar scheduler activo |

> **Nota:** `cron:test-log` es para validación inicial. Una vez confirmado que el scheduler funciona, comentarlo en `Kernel.php`.

---

## 1. Registro de ejecuciones (`system_logs`)

Los comandos `vacation:create-periods` y `vacation:update-daily` escriben automáticamente en la tabla `system_logs` de la base de datos `mysql_vacations` al finalizar.

### Tipos de log registrados

| `type` | Origen |
|---|---|
| `cron_create_periods` | `vacation:create-periods --all` |
| `cron_daily_accrual` | `vacation:update-daily --all` |
| `cron_test` | `cron:test-log` |

### Niveles usados

- `info` — ejecución exitosa sin errores  
- `warning` — completó pero con algunos errores por usuario  
- `debug` — cron de prueba  

### Consulta rápida en MySQL

```sql
-- Últimas 20 ejecuciones de crons
SELECT id, level, type, message, status, created_at
FROM system_logs
WHERE type IN ('cron_create_periods', 'cron_daily_accrual', 'cron_test')
ORDER BY created_at DESC
LIMIT 20;

-- Ver contexto detallado de una ejecución
SELECT message, context, created_at
FROM system_logs
WHERE type = 'cron_daily_accrual'
ORDER BY created_at DESC
LIMIT 1;
```

---

## 2. Cómo funciona el scheduler de Laravel

Laravel usa **un solo cron de sistema** que llama a `schedule:run` cada minuto. Laravel decide internamente qué tareas ejecutar según su configuración en `Kernel.php`.

```
# Sistema operativo → cada minuto
* * * * * php /ruta/al/proyecto/artisan schedule:run >> /dev/null 2>&1
```

---

## 3. Configuración en producción (StackCP / cPanel)

### Acceder a Cron Jobs en cPanel

1. Iniciar sesión en cPanel  
2. Ir a **Cron Jobs** (sección Avanzado)  
3. Agregar el siguiente cron:

### Cron a configurar

| Campo | Valor |
|---|---|
| Minuto | `*` |
| Hora | `*` |
| Día | `*` |
| Mes | `*` |
| Día de semana | `*` |
| Comando | ver abajo |

**Comando (ajustar la ruta al proyecto real):**

```bash
/usr/local/bin/php /home/USUARIO_CPANEL/public_html/artisan schedule:run >> /home/USUARIO_CPANEL/logs/laravel-cron.log 2>&1
```

> Reemplaza `USUARIO_CPANEL` con el usuario de tu cuenta de hosting.  
> El path de PHP puede variar: usa `which php` en SSH para confirmarlo.

### Verificar ruta de PHP en SSH

```bash
which php
# Ejemplo de salida: /usr/local/bin/php

php -v
# Debe ser PHP 8.1+
```

### Ejemplo con ruta verificada

```bash
/usr/local/bin/php /home/satechenergy/public_html/artisan schedule:run >> /home/satechenergy/logs/laravel-cron.log 2>&1
```

---

## 4. Configuración local (XAMPP / Windows)

En Windows el scheduler de Linux no existe. Usa el **Programador de tareas** de Windows.

### Opción A: Programador de tareas de Windows (recomendado)

1. Abrir **Programador de tareas**  
2. Crear tarea básica → Disparador: cada 1 minuto  
3. Acción → Iniciar programa:
   - Programa: `C:\xampp\php\php.exe`
   - Argumentos: `C:\xampp\htdocs\rrhh.satechenergy\artisan schedule:run`
   - Iniciar en: `C:\xampp\htdocs\rrhh.satechenergy`

### Opción B: Script PowerShell en bucle (desarrollo rápido)

Crear `run-scheduler.ps1` en el raíz del proyecto:

```powershell
while ($true) {
    php artisan schedule:run
    Start-Sleep -Seconds 60
}
```

Ejecutar en PowerShell:

```powershell
Set-Location C:\xampp\htdocs\rrhh.satechenergy
.\run-scheduler.ps1
```

### Probar el scheduler manualmente

```bash
php artisan schedule:run
```

Verificar en `system_logs` que se creó el registro de `cron_test`:

```bash
php artisan tinker
>>> App\Models\SystemLog::where('type','cron_test')->latest()->first()
```

---

## 5. Ejecutar comandos manualmente

```bash
# Crear períodos faltantes (equivalente al botón "Actualizar Períodos")
php artisan vacation:create-periods --all

# Actualizar acumulación diaria (equivalente al botón "Actualizar Acumulación Diaria")
php artisan vacation:update-daily --all --check-expired

# Solo marcar períodos vencidos
php artisan vacation:update-daily --check-expired

# Para un usuario específico
php artisan vacation:create-periods 42
php artisan vacation:update-daily 42

# Cron de prueba manual
php artisan cron:test-log
php artisan cron:test-log --message="Prueba manual desde desarrollo"
```

---

## 6. Validación del scheduler en producción

### Paso 1: Activar cron de prueba

Confirmar que en `Kernel.php` esté habilitado:

```php
$schedule->command('cron:test-log')
         ->everyMinute()
         ->withoutOverlapping();
```

### Paso 2: Configurar cron en cPanel

Agregar el cron de `schedule:run` (ver sección 3).

### Paso 3: Esperar 2–3 minutos y verificar

```sql
SELECT COUNT(*), MAX(created_at) 
FROM system_logs 
WHERE type = 'cron_test' 
  AND created_at > NOW() - INTERVAL 10 MINUTE;
```

Si el COUNT > 0, el scheduler está funcionando correctamente.

### Paso 4: Desactivar cron de prueba

Una vez validado, comentar en `Kernel.php`:

```php
// $schedule->command('cron:test-log')->everyMinute()->withoutOverlapping();
```

---

## 7. Troubleshooting

### "No output / cron no ejecuta"

- Verificar ruta de PHP: `which php` en SSH  
- Verificar permisos: `chmod +x artisan`  
- Revisar log del cron: `tail -f /home/USUARIO/logs/laravel-cron.log`  
- Probar manualmente: `php artisan schedule:run`

### "Overlapping / procesos duplicados"

Los comandos usan `->withoutOverlapping()`, lo que crea un mutex en caché.

```bash
php artisan cache:clear
```

### "Error de conexión a mysql_vacations"

```bash
php artisan config:clear
# Verificar DB_VACATIONS_* en .env
```

### Verificar tareas activas del scheduler

```bash
php artisan schedule:list
```
