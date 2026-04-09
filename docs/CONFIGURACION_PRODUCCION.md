# Configuración de Producción - Servidor Remoto

## ⚠️ Problema Resuelto: Vistas Cross-Database

En el servidor de hosting compartido **NO es posible crear vistas entre bases de datos diferentes** debido a restricciones de permisos.

**Solución implementada:** Laravel Eloquent con relaciones cross-database usando `setConnection()`.

---

## 📋 Pasos para Configurar en Producción

### 1. Configurar `.env` en el Servidor

Actualiza las variables de entorno en tu servidor:

```env
# Base de datos principal (RRHH)
DB_CONNECTION=mysql
DB_HOST=mysql.gb.stackcp.com
DB_PORT=43019
DB_DATABASE=rrhh_db-3530323522bf
DB_USERNAME=remote_user-034a
DB_PASSWORD=tu_contraseña_aqui

# Base de datos de vacaciones
DB_VACATIONS_HOST=mysql.gb.stackcp.com
DB_VACATIONS_PORT=43019
DB_VACATIONS_DATABASE=rrhh_vacations-3530333952ee
DB_VACATIONS_USERNAME=remote_user-034a
DB_VACATIONS_PASSWORD=tu_contraseña_aqui
```

### 2. Subir Código Actualizado

Sube los siguientes archivos que ahora tienen relaciones cross-database configuradas:

```
app/Models/
├── User.php                    ✅ Actualizado
├── RequestVacations.php        ✅ Actualizado
├── VacationsAvailable.php      ✅ Actualizado
├── RequestApproved.php         ✅ Actualizado
├── RequestRejected.php         ✅ Actualizado
├── ManagerApprover.php         ✅ Actualizado
└── DirectionApprover.php       ✅ Actualizado
```

### 3. Ejecutar Migraciones

**IMPORTANTE:** Ejecuta las migraciones EN CADA BASE DE DATOS por separado:

```bash
# En producción, conectado al servidor
php artisan migrate --database=mysql_vacations --path=database/migrations/2025_10_13_095851_create_vacaciones_table.php

# Opcional: Migrar otras tablas de la BD principal
php artisan migrate --database=mysql
```

### 4. ❌ NO Ejecutar el Script de Vistas

**NO ejecutes** `database/sql/create_cross_db_views.sql` en producción.

Este archivo es **solo para desarrollo local**. En producción, las relaciones Eloquent reemplazan las vistas.

---

## 🔍 Cómo Funcionan las Relaciones Cross-Database

### Ejemplo 1: Obtener Usuario de una Solicitud

```php
// En BD vacaciones: requests
$request = RequestVacations::find(1);

// Accede al usuario en BD principal: users
$userName = $request->user->nombre();  // ✅ Funciona sin vistas

// Accede también a departamento vía relaciones anidadas
$department = $request->user->job->departamento->name;  // ✅ Funciona
```

**Internamente** Laravel ejecuta:
1. `SELECT * FROM rrhh_vacations-3530333952ee.requests WHERE id = 1`
2. `SELECT * FROM rrhh_db-3530323522bf.users WHERE id = ?`

### Ejemplo 2: Obtener Solicitudes de un Usuario

```php
// En BD principal: users
$user = User::find(100);

// Accede a solicitudes en BD vacaciones: requests
$requests = $user->requestVacations;  // ✅ Funciona sin vistas

foreach ($requests as $request) {
    echo $request->type_request;
}
```

---

## 🧪 Verificar que Todo Funciona

Ejecuta estos comandos en tu servidor para verificar:

```bash
# Test de relación: User → RequestVacations
php artisan tinker
>>> $user = App\Models\User::first();
>>> $user->requestVacations()->count();
# Debe devolver un número (cantidad de solicitudes)

# Test de relación: RequestVacations → User
>>> $request = App\Models\RequestVacations::first();
>>> $request->user->nombre();
# Debe devolver el nombre del usuario

# Test de relación anidada
>>> $request->user->job->departamento->name;
# Debe devolver el nombre del departamento
```

---

## 🆚 Comparación: Local vs Producción

| Aspecto | Local (XAMPP) | Producción (StackCP) |
|---------|---------------|----------------------|
| **BDs** | 2 bases en mismo servidor MySQL | 2 bases en hosting compartido |
| **Vistas SQL** | ✅ Sí (create_cross_db_views.sql) | ❌ No permitidas |
| **Relaciones** | ✅ Eloquent con setConnection() | ✅ Eloquent con setConnection() |
| **Permisos** | Usuario root (todos los permisos) | Usuario limitado (sin CREATE VIEW) |
| **Solución** | Funciona con vistas o Eloquent | Solo Eloquent |

---

## 🔧 Solución para Otros Entornos

Si en el futuro trabajas en un servidor donde **SÍ tengas permisos CREATE VIEW**, puedes ejecutar:

```bash
# Solo si tienes permisos completos en MySQL
mysql -u usuario -p < database/sql/create_cross_db_views.sql
```

Pero **NO ES NECESARIO**. Laravel Eloquent ya maneja todo.

---

## 📚 Documentos Relacionados

- `SEPARACION_BD_VACACIONES.md` - Arquitectura de separación
- `database/sql/create_cross_db_views.sql` - Script de vistas (solo desarrollo local)
- `copilot-instructions.md` - Patrones de arquitectura del proyecto

---

**Última actualización:** Abril 2026  
**Estado:** ✅ Configuración lista para producción sin vistas SQL
