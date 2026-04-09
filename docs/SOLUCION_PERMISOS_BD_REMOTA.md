# Solución: Permisos de Base de Datos Remota

## 🔴 Problema Identificado

```
SQLSTATE[HY000] [1044] Access denied for user 'remote_user-034a'@'%' 
to database 'rrhh_db-3530323522bf'
```

**Causa:** El usuario de base de datos no tiene permisos para acceder a la base de datos principal `rrhh_db-3530323522bf`.

**Confirmado por logs:** El flujo OAuth funciona perfectamente hasta que intenta consultar la tabla `users`:
```sql
SELECT * FROM users WHERE email = 'ochavez@gptservices.com' AND active = 1
```

## ✅ Solución: Otorgar Permisos en StackCP

### Paso 1: Ingresar al Panel de StackCP

1. Ve a tu panel de StackCP
2. Busca la sección **"Bases de Datos"** o **"MySQL Databases"**

### Paso 2: Verificar Usuario y Bases de Datos

**Usuario de BD:** `remote_user-034a`

**Bases de datos que necesitan permisos:**
- ✅ `rrhh_db-3530323522bf` (base de datos principal - **FALTA PERMISO**)
- ✅ `rrhh_vacations-3530333952ee` (base de datos de vacaciones - verificar)

### Paso 3: Otorgar Permisos

En StackCP, busca la opción **"Add User to Database"** o **"Assign User to Database"**:

1. **Selecciona el usuario:** `remote_user-034a`
2. **Selecciona la base de datos:** `rrhh_db-3530323522bf`
3. **Marca TODOS los privilegios necesarios:**
   - ✅ SELECT
   - ✅ INSERT
   - ✅ UPDATE
   - ✅ DELETE
   - ✅ CREATE (para migraciones)
   - ✅ ALTER (para migraciones)
   - ✅ INDEX (para migraciones)
   - ✅ DROP (para migraciones)

4. **Aplica los cambios**

### Paso 4: Repetir para la Segunda Base de Datos

Haz lo mismo para `rrhh_vacations-3530333952ee` si aún no tiene permisos.

### Paso 5: Verificar Conexión

Después de otorgar permisos, ejecuta este script:

```powershell
php tests/verify_remote_db_permissions.php
```

## 🔍 Diagnóstico Detallado (Para Referencia)

### Log del Error Completo

```
[2026-04-09 13:45:07] local.INFO: ✅ OAuth: Datos de Google recibidos {
    "google_email":"ochavez@gptservices.com",
    "google_name":"Oscar Chávez Rosales",
    "google_id":"112452126946298320695"
} 

[2026-04-09 13:45:07] local.ERROR: ❌ OAuth: Error en callback {
    "error":"SQLSTATE[HY000] [1044] Access denied for user 'remote_user-034a'@'%' 
             to database 'rrhh_db-3530323522bf'",
    "file":"vendor/laravel/framework/src/Illuminate/Database/Connection.php",
    "line":829
}
```

### Qué Estaba Intentando Hacer

Laravel intentaba ejecutar:
```php
User::where('email', 'ochavez@gptservices.com')
    ->where('active', 1)
    ->first();
```

Que genera:
```sql
SELECT * FROM users WHERE email = 'ochavez@gptservices.com' AND active = 1 LIMIT 1
```

Pero el usuario de BD no tiene permiso `SELECT` en esa base de datos.

## 📋 Checklist Post-Solución

Después de otorgar permisos, verifica:

- [ ] El usuario `remote_user-034a` está asignado a `rrhh_db-3530323522bf`
- [ ] El usuario tiene permisos SELECT, INSERT, UPDATE, DELETE
- [ ] El usuario está asignado también a `rrhh_vacations-3530333952ee`
- [ ] Ejecutaste `php tests/verify_remote_db_permissions.php`
- [ ] El login con Google funciona correctamente

## 🎯 Resultado Esperado

Una vez otorgados los permisos, cuando intentes hacer login:

1. OAuth redirige a Google ✅
2. Google devuelve los datos del usuario ✅
3. Laravel busca el usuario en la BD ✅ **(ahora funcionará)**
4. Ejecuta `Auth::login($user)` ✅
5. Redirige al home autenticado ✅

---

**Nota:** Este problema ocurrió porque en el servidor remoto el usuario de base de datos tiene permisos restringidos. En tu entorno local (XAMPP) el usuario `root` tiene todos los permisos, por eso funciona sin problemas.
