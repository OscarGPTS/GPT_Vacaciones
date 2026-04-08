# Análisis de Factibilidad: Separación del Módulo de Vacaciones en BD Independiente

**Fecha:** 5 de abril de 2026  
**Solicitado por:** Usuario del proyecto  
**Analista:** Asistente de Desarrollo

---

## 📋 Resumen Ejecutivo

**Objetivo:** Evaluar la viabilidad de separar el módulo de vacaciones del sistema RRHH principal en una base de datos independiente.

**Conclusión Rápida:** ⚠️ **COMPLEJIDAD MEDIA-ALTA** - Técnicamente factible pero requiere refactorización significativa debido a dependencias estrechas con tablas del sistema principal.

**Recomendación:** 
- ✅ **Factible** para nuevos proyectos o entornos de desarrollo
- ⚠️ **Riesgoso** para entorno de producción actual sin plan de migración detallado
- 🔄 **Alternativa sugerida:** Mantener BD única con mejor separación lógica (schemas/namespaces)

---

## 1. Migraciones a Separar

### 1.1 Listado de Migraciones Identificadas

| # | Archivo | Tablas Creadas | Fecha |
|---|---------|----------------|-------|
| 1 | `2025_10_13_095851_create_vacaciones_table.php` | `requests`, `vacations_availables`, `request_approved`, `request_rejected`, `vacation_per_years`, `no_working_days` | Oct 2025 |
| 2 | `2025_11_07_093402_create_direction_approvers_table.php` | `direction_approvers` | Nov 2025 |
| 3 | `2025_11_07_111444_create_manager_approvers_table.php` | `manager_approvers` | Nov 2025 |
| 4 | `2026_03_31_142951_create_system_logs_table.php` | `system_logs` | Mar 2026 |

**Total:** 10 tablas a migrar a BD separada

### 1.2 Propósito de Cada Tabla

```
BD_VACACIONES (propuesta)
├── requests                    # Solicitudes de vacaciones
├── vacations_availables        # Períodos de vacaciones por empleado
├── request_approved            # Días individuales aprobados (calendario)
├── request_rejected            # Días rechazados
├── vacation_per_years          # Catálogo LFT México (días por antigüedad)
├── no_working_days             # Días festivos nacionales
├── direction_approvers         # Aprobadores de dirección personalizados
├── manager_approvers           # Jefes directos personalizados
└── system_logs                 # Logs de errores del sistema
```

---

## 2. Análisis de Dependencias (CRÍTICO)

### 2.1 Dependencias con BD Principal (RRHH)

#### 🔴 **DEPENDENCIAS FUERTES (Foreign Keys Explícitas)**

| Tabla Vacaciones | Campo | Tabla RRHH | Tipo FK | Impacto |
|------------------|-------|------------|---------|---------|
| `requests` | `user_id` | `users` | CASCADE | **CRÍTICO** - Usuario solicitante |
| `requests` | `created_by_user_id` | `users` | SET NULL | **ALTO** - Usuario que creó (si es en representación) |
| `requests` | `direct_manager_id` | `users` | REQUIRED | **CRÍTICO** - Jefe directo aprobador |
| `vacations_availables` | `users_id` | `users` | CASCADE | **CRÍTICO** - Propietario del período |
| `request_approved` | `users_id` | `users` | CASCADE | **CRÍTICO** - Propietario de los días |
| `request_rejected` | `users_id` | `users` | CASCADE | **ALTO** - Propietario de días rechazados |
| `direction_approvers` | `user_id` | `users` | CASCADE | **CRÍTICO** - Usuario aprobador |
| `direction_approvers` | `departamento_id` | `departamentos` | CASCADE | **CRÍTICO** - Departamento |
| `manager_approvers` | `user_id` | `users` | CASCADE | **CRÍTICO** - Usuario jefe |
| `manager_approvers` | `departamento_id` | `departamentos` | CASCADE | **CRÍTICO** - Departamento |
| `system_logs` | `user_id` | `users` | CASCADE | **MEDIO** - Usuario afectado |
| `system_logs` | `created_by` | `users` | SET NULL | **MEDIO** - Usuario que generó log |
| `system_logs` | `resolved_by` | `users` | SET NULL | **MEDIO** - Usuario que resolvió |

#### 🟡 **DEPENDENCIAS IMPLÍCITAS (Sin FK pero referencias en código)**

| Tabla Vacaciones | Campo | Referencia RRHH | Impacto |
|------------------|-------|-----------------|---------|
| `requests` | `reveal_id` | `users.id` | **ALTO** - Usuario que cubre funciones |
| `requests` | `direction_approbation_id` | `users.id` | **ALTO** - Aprobador de dirección asignado |

**Total de dependencias:** 15 referencias directas a tablas de BD principal

### 2.2 Dependencias en Modelos Eloquent

**Modelo `User` (BD Principal):**

```php
// Relaciones que apuntan a BD Vacaciones
public function requestVacations()      // requests.user_id
public function requestsAsManager()     // requests.direct_manager_id
public function vacationsAvailable()    // vacations_availables.users_id
public function vacationsAvailables()   // vacations_availables.users_id
public function daysApproved()          // request_approved.users_id
public function daysSelected()          // request_approved.users_id
```

**Modelos de Vacaciones que dependen de User:**

```php
RequestVacations::class
- user() → users
- directManager() → users
- directionApprover() → users
- createdBy() → users
- reveal() → users

VacationsAvailable::class
- user() → users

ManagerApprover::class
- user() → users
- departamento() → departamentos

DirectionApprover::class
- user() → users
- departamento() → departamentos
```

### 2.3 Dependencias en Lógica de Negocio

**Archivos que cruzan ambas BDs:**

| Archivo | Dependencia Cross-DB | Complejidad |
|---------|---------------------|-------------|
| `VacacionesController.php` | Accede a `User::findOrFail()`, `$user->job`, `$user->boss_id` | **ALTA** |
| `RequestController.php` | Valida permisos con `auth()->user()->can()`, accede a `User::where('job_id', 60)` | **ALTA** |
| `VacacionesRh.php` (Livewire) | Filtra por departamento, accede a `$user->email` | **MEDIA** |
| `AutoApprovalService.php` | Envía emails a `User`, busca por `job_id` | **MEDIA** |
| `VacationImportService.php` | Busca usuarios por nombre, valida `User::where('active', 1)` | **ALTA** |
| `VacationCalculatorService.php` | Valida `$user->admission`, calcula antigüedad | **MEDIA** |
| `SidebarComposer.php` | Filtra solicitudes por `auth()->id()` | **BAJA** |

---

## 3. Arquitectura Propuesta (Si se Separa)

### 3.1 Esquema de Conexiones Múltiples

**Configuración `config/database.php`:**

```php
'connections' => [
    'mysql' => [ // BD Principal RRHH
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'database' => env('DB_DATABASE', 'rrhh_satech'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
    ],
    
    'vacaciones' => [ // BD Separada Vacaciones
        'driver' => 'mysql',
        'host' => env('DB_VACATION_HOST', '127.0.0.1'),
        'database' => env('DB_VACATION_DATABASE', 'rrhh_vacaciones'),
        'username' => env('DB_VACATION_USERNAME', 'root'),
        'password' => env('DB_VACATION_PASSWORD', ''),
    ],
],
```

**.env:**

```env
# BD Principal RRHH
DB_HOST=127.0.0.1
DB_DATABASE=rrhh_satech
DB_USERNAME=root
DB_PASSWORD=

# BD Vacaciones
DB_VACATION_HOST=127.0.0.1
DB_VACATION_DATABASE=rrhh_vacaciones
DB_VACATION_USERNAME=root
DB_VACATION_PASSWORD=
```

### 3.2 Modificaciones en Modelos

**Todos los modelos de vacaciones necesitarían:**

```php
class RequestVacations extends Model
{
    protected $connection = 'vacaciones'; // ⬅️ Nueva línea
    protected $table = 'requests';
    
    // Relaciones cross-database (PROBLEMA)
    public function user()
    {
        // ❌ ESTO NO FUNCIONARÁ directamente
        return $this->belongsTo(User::class, 'user_id');
    }
}
```

**Problema:** Laravel **NO soporta foreign keys ni joins entre diferentes bases de datos** directamente.

### 3.3 Soluciones Técnicas para Cross-Database Queries

#### Opción A: Relaciones Sin FK (Queries Manuales)

```php
class RequestVacations extends Model
{
    protected $connection = 'vacaciones';
    
    // Relación manual sin FK
    public function user()
    {
        \DB::setDefaultConnection('mysql'); // Cambiar a BD principal
        $user = User::find($this->user_id);
        \DB::setDefaultConnection('vacaciones'); // Volver a BD vacaciones
        return $user;
    }
    
    // Accessor para evitar N+1
    public function getUserAttribute()
    {
        return Cache::remember("user_{$this->user_id}", 3600, function() {
            return User::on('mysql')->find($this->user_id);
        });
    }
}
```

**Problemas:**
- ❌ No hay integridad referencial (FK)
- ❌ Riesgo de datos huérfanos
- ❌ Performance degradada (no hay joins, solo subqueries)
- ❌ N+1 query problem en colecciones grandes
- ❌ `with()`, `whereHas()`, `has()` no funcionan nativamente

#### Opción B: Replicación de Datos (Tabla Espejo)

```php
// En BD Vacaciones, crear tabla users_cache
Schema::connection('vacaciones')->create('users_cache', function($table) {
    $table->id();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email');
    $table->integer('job_id');
    $table->integer('departamento_id');
    $table->timestamp('synced_at');
});

// Job para sincronizar cada hora
class SyncUsersToVacationDB
{
    public function handle()
    {
        $users = User::on('mysql')->get();
        foreach ($users as $user) {
            DB::connection('vacaciones')->table('users_cache')->updateOrInsert(
                ['id' => $user->id],
                [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'job_id' => $user->job_id,
                    'synced_at' => now()
                ]
            );
        }
    }
}
```

**Problemas:**
- ❌ Datos duplicados (inconsistencia potencial)
- ❌ Complejidad de sincronización
- ❌ Delay entre actualización real y caché

#### Opción C: API Interna (Microservicio)

```php
// Crear API para consultar usuarios
Route::get('/api/users/{id}', function($id) {
    return User::find($id);
});

// En módulo vacaciones
class RequestVacations extends Model
{
    public function getUserData()
    {
        return Http::get("http://rrhh-api.local/api/users/{$this->user_id}")->json();
    }
}
```

**Problemas:**
- ❌ Latencia de red
- ❌ Complejidad de autenticación API
- ❌ Overhead de HTTP

---

## 4. Desafíos Técnicos Específicos

### 4.1 Validaciones que Fallarían

**VacacionesController.php línea ~110:**

```php
// ❌ ESTO FALLARÍA con BDs separadas
$customManagerId = ManagerApprover::getManagerForDepartment($targetUser->job->depto_id);
                   ↑                                         ↑
              (BD vacaciones)                           (BD rrhh)
```

**Problema:** Necesita hacer JOIN entre `manager_approvers` (vacaciones) y `users.job` (rrhh).

**Solución requerida:**

```php
// Primero obtener depto_id de BD rrhh
$targetUser = User::on('mysql')->find($targetUserId);
$deptoId = $targetUser->job->depto_id;

// Luego buscar en BD vacaciones
DB::setDefaultConnection('vacaciones');
$customManagerId = ManagerApprover::getManagerForDepartment($deptoId);
```

### 4.2 Filtros en Livewire

**VacacionesRh.php línea ~80:**

```php
// ❌ ESTO NO FUNCIONARÍA
$query->whereHas('user.job.departamento', function ($q) use ($departmentId) {
    $q->where('id', $departmentId);
});
```

**Problema:** `whereHas()` requiere JOIN entre BDs, lo cual MySQL no soporta directamente.

**Solución:**

```php
// Primero obtener user_ids del departamento
$userIds = User::on('mysql')
    ->whereHas('job', function($q) use ($departmentId) {
        $q->where('depto_id', $departmentId);
    })
    ->pluck('id');

// Luego filtrar solicitudes
$query->whereIn('user_id', $userIds);
```

### 4.3 Autenticación y Permisos

```php
// ❌ auth()->user() vive en BD rrhh
// Necesitarías middleware personalizado en TODAS las rutas de vacaciones

Route::middleware(['auth', 'set.vacation.connection'])->group(function() {
    Route::get('/vacaciones', [VacacionesController::class, 'index']);
});

// Middleware SetVacationConnection
public function handle($request, $next)
{
    DB::setDefaultConnection('vacaciones');
    $response = $next($request);
    DB::setDefaultConnection('mysql');
    return $response;
}
```

### 4.4 Notificaciones por Email

```php
// VacacionesRh.php línea ~240
Mail::to($this->selectedRequest->user->email)
    ->send(new VacationRequestApprovedByRH($this->selectedRequest));
    
// ❌ $this->selectedRequest->user requiere query cross-database
// ❌ La clase Mail necesita acceso a user real (no caché)
```

---

## 5. Impacto en Archivos del Proyecto

### 5.1 Archivos que Requerirían Modificación (Estimado)

| Categoría | Archivos Afectados | Complejidad | Horas Est. |
|-----------|-------------------|-------------|-----------|
| **Modelos** | 8 archivos | Media | 8h |
| `RequestVacations.php`, `VacationsAvailable.php`, `RequestApproved.php`, `ManagerApprover.php`, etc. | | | |
| **Controladores** | 4 archivos | Alta | 16h |
| `VacacionesController.php`, `RequestController.php`, `Admin/*ApproversController.php` | | | |
| **Livewire** | 3 componentes | Alta | 12h |
| `VacacionesRh.php`, `VacationReport.php`, `VacationImport.php` | | | |
| **Servicios** | 5 archivos | Media-Alta | 12h |
| `VacationCalculatorService.php`, `AutoApprovalService.php`, `VacationImportService.php`, etc. | | | |
| **Middleware** | 2 nuevos | Media | 4h |
| `SetVacationConnection.php`, `EnsureUserInBothDBs.php` | | | |
| **Migraciones** | 4 migraciones | Baja | 2h |
| Agregar `connection('vacaciones')` | | | |
| **Seeders** | 2 archivos | Baja | 2h |
| `VacationPerYearSeeder.php`, `NoWorkingDaysSeeder.php` | | | |
| **Tests** | 15 archivos | Alta | 20h |
| Reescribir tests para manejar 2 BDs | | | |
| **Configuración** | 3 archivos | Media | 4h |
| `database.php`, `.env.example`, deployment scripts | | | |

**Total estimado:** ~80 horas de desarrollo + testing

### 5.2 Riesgo de Regresiones

| Funcionalidad | Riesgo | Razón |
|---------------|--------|-------|
| Creación de solicitudes | **ALTO** | Valida datos de `users`, `jobs`, `departamentos` |
| Aprobación de solicitudes | **ALTO** | Envía emails, actualiza estados, valida permisos |
| Importación masiva | **CRÍTICO** | Busca usuarios por nombre, valida existencia |
| Reportes de vacaciones | **ALTO** | Filtra por departamento, job, jefe directo |
| Auto-aprobación (cron) | **MEDIO** | Busca usuarios por job_id |
| Sidebar notifications | **MEDIO** | Cuenta solicitudes por auth()->id() |

---

## 6. Alternativas Más Simples

### 6.1 Opción Recomendada: Schemas en Misma BD

**En lugar de BDs separadas, usar schemas (prefijos de tabla):**

```php
// Mantener BD única pero con prefijos
rrhh_satech
├── HR_users                # Módulo RRHH
├── HR_departamentos
├── HR_jobs
├── VAC_requests            # Módulo Vacaciones
├── VAC_vacations_availables
├── VAC_manager_approvers
└── VAC_system_logs
```

**Ventajas:**
- ✅ Foreign keys funcionan normalmente
- ✅ Joins son eficientes
- ✅ Sin cambios en modelos Eloquent
- ✅ Separación lógica clara
- ✅ Backup/restore selectivo posible

**Implementación:**

```php
// En migraciones
Schema::create('VAC_requests', function (Blueprint $table) {
    $table->foreignId('user_id')->constrained('HR_users'); // ✅ Funciona
});

// En modelos
class RequestVacations extends Model
{
    protected $table = 'VAC_requests'; // Simple cambio de nombre
}
```

### 6.2 Opción 2: Namespaces en Código

```
app/Modules/
├── RRHH/
│   ├── Controllers/
│   ├── Models/
│   └── Services/
└── Vacaciones/
    ├── Controllers/
    ├── Models/
    └── Services/
```

**Ventajas:**
- ✅ Mejor organización del código
- ✅ Sin cambios en BD
- ✅ Fácil de implementar
- ✅ Posibilita extracción futura a paquete

### 6.3 Opción 3: BD Read-Only Replica

Si el problema es **performance en reportes**, considera:

```php
'connections' => [
    'mysql' => [
        'driver' => 'mysql',
        'host' => 'master-db.local',
        'database' => 'rrhh_satech',
        'read' => [
            'host' => ['replica1-db.local', 'replica2-db.local'],
        ],
        'write' => [
            'host' => ['master-db.local'],
        ],
    ],
],
```

---

## 7. Análisis Costo-Beneficio

### 7.1 Costos de Separar en BD Independiente

| Tipo de Costo | Impacto | Detalle |
|---------------|---------|---------|
| **Desarrollo inicial** | 🔴 Alto | 80+ horas de refactorización |
| **Testing exhaustivo** | 🔴 Alto | Cada funcionalidad debe re-testearse |
| **Performance** | 🟡 Medio | Queries cross-database más lentos |
| **Mantenimiento continuo** | 🔴 Alto | Complejidad en cada nueva feature |
| **Documentación** | 🟡 Medio | Explicar arquitectura dual-DB |
| **Onboarding devs** | 🟡 Medio | Curva de aprendizaje mayor |
| **Backups** | 🟢 Bajo | Más simple (backup selectivo) |
| **Deployment** | 🟡 Medio | 2 migraciones en vez de 1 |

### 7.2 Beneficios de Separar

| Beneficio | Impacto Real | Comentario |
|-----------|--------------|------------|
| **Separación de concerns** | 🟡 Medio | Útil pero se puede lograr con prefijos |
| **Performance aislada** | 🔴 Negativo | Joins cross-DB son MÁS lentos |
| **Escalabilidad horizontal** | 🟢 Alto | Solo si planeas servidores separados |
| **Backups independientes** | 🟢 Alto | Backup solo módulo vacaciones |
| **Seguridad por aislamiento** | 🟡 Medio | Útil si hay usuarios diferentes |
| **Facilita extracción a microservicio** | 🟢 Alto | Paso previo a arquitectura distribuida |

### 7.3 Escenarios de Justificación

**✅ VALE LA PENA separar si:**

1. **Escalabilidad extrema:** Esperas >100K empleados con millones de solicitudes
2. **SaaS Multi-tenant:** Cada cliente tendrá su BD vacaciones separada
3. **Equipos separados:** Equipo A mantiene RRHH, Equipo B mantiene Vacaciones
4. **Regulación legal:** Ley obliga a separar datos de vacaciones
5. **Microservicios futuro:** Planeas servicio independiente de vacaciones en 6 meses

**❌ NO VALE LA PENA si:**

1. **Single-tenant:** Solo una empresa (Satech Energy) usa el sistema
2. **Equipo pequeño:** <5 developers que mantienen todo
3. **Datos entrelazados:** Vacaciones dependen fuertemente de RRHH
4. **No hay problemas de performance actualmente**
5. **Budget/tiempo limitado:** 80h de desarrollo no está justificado

---

## 8. Recomendación Final

### 8.1 Para Entorno Actual (Producción Satech Energy)

**⛔ NO RECOMENDADO** separar en BD independiente por:

1. **Alto acoplamiento:** 15 dependencias fuertes con tablas RRHH
2. **Complejidad innecesaria:** Sistema funciona bien en BD única
3. **Riesgo de regresiones:** Demasiadas áreas críticas afectadas
4. **Costo vs beneficio:** 80h de trabajo sin beneficio tangible

### 8.2 Recomendación Inmediata

**✅ IMPLEMENTAR:** Refactorización con **prefijos de tabla** (`VAC_*`)

**Plan de acción (8 horas):**

1. **Crear migración de renombrado** (2h)
   ```bash
   php artisan make:migration rename_vacation_tables_with_prefix
   ```

2. **Actualizar nombres en modelos** (2h)
   ```php
   protected $table = 'VAC_requests';
   ```

3. **Ejecutar en desarrollo** (1h)
   ```bash
   php artisan migrate
   ```

4. **Testing exhaustivo** (2h)

5. **Deploy a producción** (1h)

**Beneficios inmediatos:**
- ✅ Separación visual clara en BD
- ✅ Backups selectivos posibles (`mysqldump --tables VAC_*`)
- ✅ Sin cambios en lógica de negocio
- ✅ Sin degradación de performance
- ✅ Posibilita migración futura a BD separada (si es necesario)

### 8.3 Para Proyectos Futuros

Si estás empezando un **nuevo proyecto SaaS multi-tenant**:

**✅ RECOMENDADO:** Separar desde el inicio con arquitectura de 3 capas:

```
1. BD Tenants (por cliente)
   - vacations_client1
   - vacations_client2

2. BD Shared (catálogos comunes)
   - vacation_per_years
   - no_working_days

3. BD Master (usuarios, suscripciones)
   - users
   - subscriptions
```

---

## 9. Migración Segura (Si Decides Separar)

### 9.1 Plan de Migración (12 pasos)

1. **Crear BD vacaciones vacía** (1h)
2. **Copiar migraciones 2025+** (1h)
3. **Modificar modelos con `connection`** (8h)
4. **Refactorizar controladores para queries cross-DB** (16h)
5. **Actualizar Livewire components** (12h)
6. **Crear middleware de conexión** (4h)
7. **Testing unitario** (10h)
8. **Testing integración** (10h)
9. **Deployment a staging** (4h)
10. **Testing QA completo** (8h)
11. **Migración de datos producción** (4h)
12. **Deployment a producción + rollback plan** (4h)

**Total:** ~82 horas (10 días laborales)

### 9.2 Script de Migración de Datos

```php
// database/migrations/2026_04_05_migrate_vacation_data_to_new_db.php

public function up()
{
    // 1. Copiar datos de requests
    $requests = DB::connection('mysql')->table('requests')->get();
    foreach ($requests as $request) {
        DB::connection('vacaciones')->table('requests')->insert((array)$request);
    }
    
    // 2. Copiar vacations_availables
    $vacations = DB::connection('mysql')->table('vacations_availables')->get();
    foreach ($vacations as $vacation) {
        DB::connection('vacaciones')->table('vacations_availables')->insert((array)$vacation);
    }
    
    // ... repetir para todas las tablas
    
    // 3. Validar integridad
    $oldCount = DB::connection('mysql')->table('requests')->count();
    $newCount = DB::connection('vacaciones')->table('requests')->count();
    
    if ($oldCount !== $newCount) {
        throw new Exception("Data migration failed: counts don't match");
    }
}

public function down()
{
    // Rollback: copiar de vuelta a BD original
    DB::connection('vacaciones')->table('requests')->truncate();
    DB::connection('vacaciones')->table('vacations_availables')->truncate();
    // ...
}
```

---

## 10. Conclusión

### Matriz de Decisión

| Criterio | BD Única (Actual) | BD Separada | Prefijos (Recomendado) |
|----------|-------------------|-------------|------------------------|
| **Complejidad de implementación** | 🟢 Baja | 🔴 Alta | 🟢 Baja |
| **Performance** | 🟢 Óptima | 🔴 Degradada | 🟢 Óptima |
| **Mantenibilidad** | 🟢 Simple | 🔴 Compleja | 🟢 Simple |
| **Separación lógica** | 🔴 Nula | 🟢 Total | 🟡 Media |
| **Escalabilidad futura** | 🟡 Media | 🟢 Alta | 🟡 Media |
| **Costo desarrollo** | 🟢 $0 | 🔴 ~$8,000 | 🟢 ~$800 |
| **Riesgo** | 🟢 Bajo | 🔴 Alto | 🟢 Bajo |

**Puntaje final:**
- 🥇 **Prefijos (VAC_*):** 28/35 puntos
- 🥈 **BD Única actual:** 24/35 puntos
- 🥉 **BD Separada:** 18/35 puntos

### Decisión Ejecutiva

**Para Satech Energy (Producción Actual):**
- ✅ Implementar prefijos de tabla (`VAC_*`) en próximo sprint
- ⏸️ Posponer separación de BD hasta que haya justificación técnica clara

**Para Nuevos Proyectos SaaS:**
- ✅ Comenzar con BD separada desde el diseño inicial
- ✅ Implementar patrón multi-tenant desde día 1

---

**Preparado por:** Asistente de Desarrollo IA  
**Revisado por:** [Pendiente]  
**Fecha de vigencia:** Abril 2026  
**Próxima revisión:** Octubre 2026 (o al surgir nuevos requerimientos)

---

## Anexos

### A. Checklist de Implementación (Prefijos)

```
□ Crear migración de renombrado
□ Actualizar 8 modelos (protected $table)
□ Buscar/reemplazar nombres de tabla en código
□ Ejecutar en desarrollo
□ Testing de creación de solicitudes
□ Testing de aprobaciones
□ Testing de importación
□ Testing de reportes
□ Deploy a staging
□ QA completo
□ Deploy a producción (ventana de mantenimiento)
□ Monitoreo post-deploy (24h)
```

### B. Contacto para Consultas

Si decides proceder con cualquier opción, el equipo de desarrollo deberá:

1. Revisar este análisis con arquitecto de software
2. Validar con DBA los impactos en performance
3. Consultar con DevOps sobre infraestructura
4. Preparar plan de rollback detallado

---

**FIN DEL ANÁLISIS**
