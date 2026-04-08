# Sistema de Gestión de Vacaciones - RRHH Satech Energy

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-blue.svg)](https://livewire.laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-purple.svg)](https://www.php.net)
[![License](https://img.shields.io/badge/License-Proprietary-orange.svg)]()

Sistema integral de gestión de recursos humanos especializado en el módulo de vacaciones, desarrollado con Laravel 10 y Livewire 3. Implementa un flujo de aprobación multinivel configurable y cumple con la Ley Federal del Trabajo de México.

---

## 📋 Tabla de Contenidos

- [Características Principales](#-características-principales)
- [Requisitos del Sistema](#-requisitos-del-sistema)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Arquitectura](#-arquitectura)
- [Flujo de Aprobación de Vacaciones](#-flujo-de-aprobación-de-vacaciones)
- [Reglas de Negocio](#-reglas-de-negocio)
- [Comandos Artisan](#-comandos-artisan)
- [Importación Masiva](#-importación-masiva)
- [Sistema de Auto-Aprobación](#-sistema-de-auto-aprobación)
- [Vencimiento de Periodos](#-vencimiento-de-periodos)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Testing](#-testing)
- [Documentación Técnica](#-documentación-técnica)
- [Licencia](#-licencia)

---

## 🎯 Características Principales

### Gestión de Vacaciones
- ✅ **Solicitud de vacaciones** con validación automática de días disponibles
- ✅ **Flujo de aprobación multinivel** configurable (Manager → Dirección → RH)
- ✅ **Auto-aprobación automática** después de 5 días sin respuesta
- ✅ **Vencimiento automático** de periodos (15 meses post-aniversario)
- ✅ **Importación/exportación masiva** de datos en Excel
- ✅ **Notificaciones por email** en cada etapa del flujo
- ✅ **Calendario visual** de vacaciones aprobadas
- ✅ **Reportes detallados** con filtros avanzados

### Cumplimiento Legal
- 📜 **Ley Federal del Trabajo (México)** - Artículo 76
- 📈 **Escala progresiva** de días de vacaciones (12-32 días según antigüedad)
- ⏰ **Control de vencimientos** según normativa laboral mexicana
- 📊 **Auditoría completa** de todas las operaciones

### Gestión de Personal
- 👥 **Gestión de empleados** con datos completos
- 📄 **Gestión de CV** y documentos
- 🎓 **Control de cursos y capacitaciones**
- 📊 **Puestos de trabajo** y organigrama
- 🔐 **Sistema de permisos** basado en roles (Spatie)

---

## 💻 Requisitos del Sistema

### Software Requerido

| Componente | Versión Mínima | Recomendada |
|------------|----------------|-------------|
| **PHP** | 8.1 | 8.2+ |
| **MySQL** | 5.7 | 8.0+ |
| **Composer** | 2.0 | 2.6+ |
| **Node.js** | 16.x | 20.x LTS |
| **NPM** | 8.x | 10.x |

### Extensiones PHP Requeridas
```
- BCMath
- Ctype
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD (para generación de imágenes)
- cURL
```

### Entorno de Desarrollo
- **Windows**: XAMPP 8.1+ / Laragon
- **Linux**: Apache/Nginx + PHP-FPM
- **macOS**: Laravel Valet / MAMP

---

## 🚀 Instalación

### 1. Clonar el Repositorio
```bash
git clone https://github.com/OscarGPTS/GPT_Vacaciones.git
cd GPT_Vacaciones
```

### 2. Instalar Dependencias PHP
```bash
composer install
```

### 3. Instalar Dependencias JavaScript
```bash
npm install
```

### 4. Configurar Variables de Entorno
```bash
# Copiar archivo de ejemplo
copy .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 5. Configurar Base de Datos
Editar `.env` con tus credenciales:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rrhh_satechenergy
DB_USERNAME=root
DB_PASSWORD=tu_password_seguro
```

### 6. Ejecutar Migraciones
```bash
php artisan migrate --seed
```

### 7. Compilar Assets
```bash
# Desarrollo
npm run dev

# Producción
npm run production
```

### 8. Iniciar Servidor
```bash
php artisan serve
```

Accede a: `http://localhost:8000`

---

## ⚙️ Configuración

### Configuración de Vacaciones
Editar `config/vacations.php`:

```php
return [
    // IDs de usuarios de RH que aprueban solicitudes
    'rh_user_ids' => [
        123,  // Agregar IDs reales
    ],

    // IDs de usuarios de Dirección
    'direction_user_ids' => [
        // IDs según organigrama
    ],
];
```

### Configuración de Emails
Editar `.env` con tu servidor SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.tu-servidor.com
MAIL_PORT=587
MAIL_USERNAME=tu_usuario
MAIL_PASSWORD=tu_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@satechenergy.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Autenticación con Google (OAuth)
```env
GOOGLE_CLIENT_ID=tu_client_id
GOOGLE_CLIENT_SECRET=tu_client_secret
GOOGLE_REDIRECT=/login/google/callback
```

**Nota:** Nunca expongas tus credenciales en el repositorio. Usa `.env` que está en `.gitignore`.

### Programación de Tareas (Cron)

#### Windows (XAMPP/Laragon)
Configurar **Programador de Tareas** de Windows:

1. Abrir **Task Scheduler**
2. Crear tarea básica:
   - **Nombre**: Laravel Scheduler - RRHH
   - **Desencadenador**: Diario, repetir cada 1 minuto
   - **Acción**: Iniciar programa
     - **Programa**: `C:\xampp\php\php.exe`
     - **Argumentos**: `C:\xampp\htdocs\rrhh.satechenergy\artisan schedule:run`
     - **Directorio**: `C:\xampp\htdocs\rrhh.satechenergy`

#### Linux/macOS
Agregar a crontab:
```bash
crontab -e

# Agregar línea:
* * * * * cd /path/to/rrhh.satechenergy && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🏗️ Arquitectura

### Stack Tecnológico

#### Backend
- **Framework**: Laravel 10.48
- **Real-time**: Livewire 3.4 (componentes reactivos)
- **Autenticación**: Laravel Sanctum + Socialite (Google)
- **Permisos**: Spatie Laravel Permission 6.0
- **Base de Datos**: MySQL (conexión dual: principal + vacaciones)
- **PDFs**: Barryvdh DomPDF 2.2
- **Excel**: rap2hpoutre/fast-excel 5.5 + OpenSpout
- **Estados**: asantibanez/eloquent-state-machines

#### Frontend
- **CSS Framework**: Tailwind CSS 3.3
- **UI Components**: WireUI 1.18 + Flowbite 1.8
- **Build Tool**: Laravel Mix 6
- **Icons**: Font Awesome
- **Calendar**: omnia-digital/livewire-calendar 3.1

### Patrones de Arquitectura

#### 1. Service Layer Pattern
Lógica de negocio compleja aislada en servicios:
```
app/Services/
├── VacationCalculatorService.php     # Cálculos de vacaciones
├── VacationImportService.php         # Importación masiva
├── AutoApprovalService.php           # Auto-aprobaciones
└── VacationExportService.php         # Exportación Excel
```

#### 2. Repository Pattern (Livewire)
Componentes Livewire actúan como repositorios reactivos:
```
app/Livewire/
├── VacacionesRh.php                  # Vista RH
├── VacationReport.php                # Reportes
├── VacationImport.php                # Importación wizard
└── SolicitudVacaciones.php           # Solicitud empleado
```

#### 3. View Composers
Datos compartidos inyectados automáticamente:
```php
// app/View/Composers/SidebarComposer.php
- Contadores de notificaciones
- Solicitudes pendientes por rol
- Badges en sidebar
```

#### 4. Command Pattern
Comandos Artisan para operaciones batch:
```bash
php artisan vacations:auto-approve     # Auto-aprobación
php artisan vacations:check-expired    # Verificar vencidos
```

### Estructura de Base de Datos

#### Conexión Principal (`mysql`)
- `users` - Usuarios del sistema
- `jobs` - Puestos de trabajo
- `departamentos` - Departamentos
- `requests` - Solicitudes de vacaciones
- `request_calendars` - Días individuales
- `manager_approvers` - Aprobadores personalizados (manager)
- `direction_approvers` - Aprobadores personalizados (dirección)

#### Conexión Vacaciones (`mysql_vacations`)
- `vacations_availables` - Periodos de vacaciones
- `vacation_per_years` - Catálogo LFT (días por antigüedad)

---

## 🔄 Flujo de Aprobación de Vacaciones

### Diagrama de Flujo

```
┌────────────────────────────────────────────────────────┐
│  PASO 1: EMPLEADO CREA SOLICITUD                       │
│  ────────────────────────────────────────────────      │
│  • Selecciona periodo de vacaciones                    │
│  • Elige días a disfrutar                              │
│  • Asigna persona que cubrirá funciones                │
│  • Sistema valida:                                     │
│    - Antigüedad mínima (1 año)                         │
│    - Días disponibles en periodo                       │
│    - Anticipación mínima (5 días)                      │
│  • RESERVA días automáticamente                        │
│  • Asigna manager aprobador (ManagerApprover o boss_id)│
│  • Envía notificación por email                        │
└──────────────────┬─────────────────────────────────────┘
                   │
                   │ Status: direct_manager_status = 'Pendiente'
                   ▼
┌────────────────────────────────────────────────────────┐
│  PASO 2: JEFE DIRECTO APRUEBA/RECHAZA                  │
│  ────────────────────────────────────────────────      │
│  ✅ APRUEBA:                                           │
│     • direct_manager_status = 'Aprobada'               │
│     • Asigna direction_approbation_id                  │
│     • direction_approbation_status = 'Pendiente'       │
│     • Notifica a Dirección                             │
│                                                         │
│  ❌ RECHAZA:                                           │
│     • direct_manager_status = 'Rechazada'              │
│     • LIBERA días reservados (days_reserved -= N)      │
│     • Mueve días a request_rejected                    │
│     • Notifica al empleado                             │
│     • FIN ❌                                           │
└──────────────────┬─────────────────────────────────────┘
                   │
                   │ Si aprobó: direction_approbation_status = 'Pendiente'
                   ▼
┌────────────────────────────────────────────────────────┐
│  PASO 3: DIRECCIÓN APRUEBA/RECHAZA (CONFIGURABLE)      │
│  ────────────────────────────────────────────────      │
│  ✅ APRUEBA:                                           │
│     • direction_approbation_status = 'Aprobada'        │
│     • human_resources_status = 'Pendiente'             │
│     • Notifica a RH                                    │
│                                                         │
│  ❌ RECHAZA:                                           │
│     • direction_approbation_status = 'Rechazada'       │
│     • LIBERA días reservados                           │
│     • Notifica al empleado                             │
│     • FIN ❌                                           │
└──────────────────┬─────────────────────────────────────┘
                   │
                   │ Si aprobó: human_resources_status = 'Pendiente'
                   ▼
┌────────────────────────────────────────────────────────┐
│  PASO 4: RH APRUEBA/RECHAZA (FINAL)                    │
│  ────────────────────────────────────────────────      │
│  ✅ APRUEBA:                                           │
│     • human_resources_status = 'Aprobada'              │
│     • LIBERA days_reserved                             │
│     • DESCUENTA days_enjoyed += N                      │
│     • Actualiza calendarios                            │
│     • Notifica al empleado                             │
│     • APROBADO ✅                                      │
│                                                         │
│  ❌ RECHAZA:                                           │
│     • human_resources_status = 'Rechazada'             │
│     • LIBERA days_reserved                             │
│     • Notifica al empleado                             │
│     • FIN ❌                                           │
└────────────────────────────────────────────────────────┘
```

### Estados de Solicitud

| Campo | Valores Posibles |
|-------|-----------------|
| `direct_manager_status` | `Pendiente`, `Aprobada`, `Rechazada` |
| `direction_approbation_status` | `Pendiente`, `Aprobada`, `Rechazada` |
| `human_resources_status` | `Pendiente`, `Aprobada`, `Rechazada` |

---

## 📐 Reglas de Negocio

### 1. Periodo de Vacaciones

#### Estructura
Cada empleado tiene periodos anuales según antigüedad:
- **Periodo 1**: Año 1 de trabajo → 12 días
- **Periodo 2**: Año 2 de trabajo → 14 días
- **Periodo 5**: Año 5 de trabajo → 20 días
- **Periodo 10**: Año 10 de trabajo → 26 días
- **Periodo 15+**: Año 15+ de trabajo → 32 días

#### Campos Clave

```php
VacationsAvailable {
    period: int                    // Año de antigüedad (1-40)
    date_start: date              // Inicio del periodo (fecha ingreso)
    date_end: date                // Fin del periodo (aniversario)
    cutoff_date: date             // date_end + 15 meses (vencimiento)
    days_availables: decimal      // Saldo base del periodo (fijo)
    days_calculated: decimal      // Días acumulados diarios
    days_enjoyed: int             // Días ya disfrutados
    days_reserved: decimal        // Días en solicitudes pendientes
    status: string               // 'actual' | 'vencido'
    is_historical: boolean        // true si es periodo cerrado
}
```

#### Fórmulas de Cálculo

**Saldo Disponible:**
```
saldo_disponible = days_availables - days_enjoyed - days_reserved
```

**Al Crear Solicitud:**
```php
$periodo->days_reserved += dias_solicitados;
```

**Al Aprobar Solicitud (RH):**
```php
$periodo->days_reserved -= dias_solicitados;
$periodo->days_enjoyed += dias_solicitados;
```

**Al Rechazar Solicitud:**
```php
$periodo->days_reserved -= dias_solicitados;
// Los días vuelven a estar disponibles
```

### 2. Validaciones de Solicitud

#### Antigüedad Mínima
- ✅ Empleado debe tener **mínimo 1 año** de antigüedad
- ⏰ Se calcula desde `users.date_admission`

#### Días Disponibles
- ✅ `dias_solicitados <= saldo_disponible`
- ❌ No puede solicitar más días de los disponibles
- ⚠️ Bloqueo automático si `days_reserved > 0` (solicitud pendiente)

#### Anticipación
- ✅ Solicitud debe hacerse con **mínimo 5 días de anticipación**
- ⏰ Se valida contra `Carbon::now()->addDays(5)`

#### Periodos Vencidos
- ❌ No se pueden usar periodos con `status = 'vencido'`
- ⚠️ Periodos vencen **15 meses después** de `date_end`
- 🔄 Verificación automática diaria a las 00:30 AM

### 3. Aprobadores Configurables

#### Concepto
El sistema permite **sobrescribir** los aprobadores por defecto por departamento.

#### Manager Directo (Nivel 1)
**Prioridad:**
1. ✅ `ManagerApprover::getManagerForDepartment($depto_id)` (si existe)
2. ⬇️ Fallback: `user->boss_id` (jefe directo del organigrama)

**Tabla:** `manager_approvers`
```php
{
    departamento_id: int,
    user_id: int,      // Manager personalizado
    is_active: bool
}
```

#### Dirección (Nivel 2)
**Prioridad:**
1. ✅ `DirectionApprover::getDirectionApproverForDepartment($depto_id)` (si existe)
2. ⬇️ Fallback: Usuario con `job_id = 60` (Director General)

**Tabla:** `direction_approvers`
```php
{
    departamento_id: int,
    user_id: int,      // Director personalizado
    is_active: bool
}
```

#### REGLA CRÍTICA
- ✅ **Filtrar siempre por ID exacto** asignado: `WHERE direct_manager_id = auth()->id()`
- ❌ **NUNCA filtrar por departamento o job_id** en queries de aprobación
- 🎯 Esto garantiza que **solo una persona** vea cada solicitud en cada nivel

---

## 🔧 Comandos Artisan

### Vacaciones

#### Auto-Aprobación
```bash
# Aprobar solicitudes pendientes > 5 días
php artisan vacations:auto-approve

# Solo ver estadísticas
php artisan vacations:auto-approve --stats

# Simulación (no hace cambios)
php artisan vacations:auto-approve --dry-run
```

**Programación:** Automático diario a las 9:00 AM

#### Verificar Periodos Vencidos
```bash
# Marcar periodos vencidos (> 15 meses)
php artisan vacations:check-expired

# Solo estadísticas
php artisan vacations:check-expired --stats

# Simulación
php artisan vacations:check-expired --dry-run
```

**Programación:** Automático diario a las 00:30 AM

### Cache y Optimización
```bash
# Limpiar caché completo
php artisan optimize:clear

# Cachear configuración (producción)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Base de Datos
```bash
# Migrar base de datos
php artisan migrate

# Migrar con seeders
php artisan migrate:seed

# Rollback última migración
php artisan migrate:rollback

# Reiniciar base de datos
php artisan migrate:fresh --seed
```

---

## 📤 Importación Masiva

Sistema de importación wizard con 3 pasos y validación visual.

### Formato de Excel

#### Columnas Requeridas
```
| Nombre Completo | Fecha Ingreso | Fecha Aniversario | Días Disponibles | Días Disfrutados |
|-----------------|---------------|-------------------|------------------|------------------|
| GARCÍA LÓPEZ JUAN | 08/08/2024  | 08/08/2025        | 12.00            | 3                |
```

#### Formatos de Fecha Soportados
- ✅ `dd/mm/yyyy` (08/08/2024)
- ✅ `dd-mm-yyyy` (08-08-2024)
- ✅ `yyyy-mm-dd` (2024-08-08)
- ✅ Excel serial (45236)

### Proceso de Importación

#### Paso 1: Cargar Archivo
- Descargar plantilla con ejemplos
- Subir archivo Excel (.xlsx/.xls)
- Validación automática de formato

#### Paso 2: Revisión y Asignación
**Sección Verde:** Registros válidos con auto-matching
- Empleados identificádos por nombre completo
- Vista previa de todos los datos
- Validación: `días_disfrutados <= días_disponibles`

**Sección Amarilla:** Registros sin matching
- Dropdown para asignación manual de empleado
- Al asignar, se mueve automáticamente a sección verde
- Validación en tiempo real

#### Paso 3: Resultados
- Estadísticas completas de la importación
- Detalles de errores con número de fila
- Resumen de registros creados/actualizados

### Validaciones Críticas

| Validación | Descripción |
|------------|-------------|
| **Días disfrutados** | Debe ser ≤ días disponibles |
| **Duplicados** | Detecta periodos con fechas similares (±7 días) |
| **Nombres** | Matching case-insensitive, soporta orden invertido |
| **Fechas exactas** | Rechaza coincidencias aproximadas |

### Comandos desde UI
```
Vacaciones → Reporte → Importar Excel
```

**Documentación:** [docs/IMPORTACION_MASIVA_VACACIONES.md](docs/IMPORTACION_MASIVA_VACACIONES.md)

---

## ⏰ Sistema de Auto-Aprobación

Aprobación automática de solicitudes pendientes después de 5 días sin respuesta.

### Configuración

#### Timeout de Aprobación
```php
// config/vacations.php o AutoApprovalService.php
const APPROVAL_TIMEOUT_DAYS = 5;
```

#### Niveles que Auto-Aprueban
- ✅ **Jefe Directo** (direct_manager_status)
- ❌ **Dirección** (deshabilitado intencionalmente)
- ❌ **RH** (requiere aprobación manual)

### Lógica de Auto-Aprobación

```php
// Criterios
$cutoffDate = Carbon::now()->subDays(5);

$pendingRequests = RequestVacations::where('direct_manager_status', 'Pendiente')
    ->where('created_at', '<=', $cutoffDate)
    ->get();

// Acción
foreach ($pendingRequests as $request) {
    $request->update([
        'direct_manager_status' => 'Aprobada',
        // Asigna siguiente aprobador (dirección)
        'direction_approbation_status' => 'Pendiente'
    ]);
}
```

### Ejecución

#### Automática (Programada)
```bash
# Cron ejecuta diariamente a las 9:00 AM
php artisan schedule:run
```

#### Manual
```bash
# Desde terminal
php artisan vacations:auto-approve

# Desde interfaz web (Livewire)
# VacacionesRh → Botón "Procesar Auto-Aprobaciones"
```

### Estadísticas
```
✅ Proceso completado:
   📋 Supervisor - Solicitudes aprobadas: 3
   🏢 RH - Solicitudes aprobadas: 0 (deshabilitado)

📊 Estadísticas actuales:
┌─────────────────────┬──────────────────┬────────────────────┐
│ Categoría           │ Total Pendientes │ Vencidas (>5 días) │
├─────────────────────┼──────────────────┼────────────────────┤
│ Supervisor Directo  │ 5                │ 0                  │
│ Recursos Humanos    │ 12               │ 2                  │
└─────────────────────┴──────────────────┴────────────────────┘
```

**Documentación:** [docs/SISTEMA_AUTO_APROBACION.md](docs/SISTEMA_AUTO_APROBACION.md)

---

## 📅 Vencimiento de Periodos

Control automático de vencimiento de periodos de vacaciones según normativa.

### Política de Vencimiento

**Regla:** Los periodos vencen **15 meses después** del aniversario laboral
```
Fecha Vencimiento = date_end + 15 meses
```

**Ejemplo:**
```
Periodo: 01/01/2024 - 31/12/2024
Aniversario (date_end): 31/12/2024
Fecha de vencimiento: 31/03/2026
```

### Estados de Periodo

| Estado | Descripción | Usable |
|--------|-------------|--------|
| `actual` | Periodo vigente | ✅ Sí |
| `vencido` | Expiró (>15 meses) | ❌ No |
| `is_historical=true` | Periodo cerrado histórico | ❌ No |

### Verificación Automática

#### Programación
```bash
# Comando programado: 00:30 AM diario
php artisan vacations:check-expired
```

#### Proceso
1. Revisa todos los periodos activos
2. Calcula `cutoff_date = date_end + 15 meses`
3. Si `today > cutoff_date` → marca `status = 'vencido'`
4. Registra en logs de auditoría

### Impacto en el Sistema

#### Al Solicitar Vacaciones
```php
// Solo muestra periodos vigentes
$periodos = VacationsAvailable::where('users_id', $user->id)
    ->where('is_historical', false)
    ->where('status', '!=', 'vencido')  // ← Excluye vencidos
    ->get();
```

#### En Reportes
- Badge "Vencido" en color rojo
- No se suman a días disponibles
- Visible solo para auditoría RH

**Documentación:** [docs/VENCIMIENTO_PERIODOS_VACACIONES.md](docs/VENCIMIENTO_PERIODOS_VACACIONES.md)

---

## 📁 Estructura del Proyecto

```
rrhh.satechenergy/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       ├── ProcessAutoApprovals.php      # Auto-aprobación
│   │       └── CheckExpiredVacations.php     # Vencimientos
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/
│   │       │   ├── ManagerApproversController.php
│   │       │   └── DirectionApproversController.php
│   │       └── Vacaciones/
│   │           ├── VacacionesController.php
│   │           └── RequestController.php
│   ├── Livewire/
│   │   ├── VacacionesRh.php                  # Vista RH
│   │   ├── VacationReport.php                # Reportes
│   │   ├── VacationImport.php                # Importación
│   │   └── SolicitudVacaciones.php           # Solicitud empleado
│   ├── Models/
│   │   ├── User.php
│   │   ├── VacationsAvailable.php
│   │   ├── RequestVacations.php
│   │   ├── VacationPerYear.php
│   │   ├── ManagerApprover.php
│   │   └── DirectionApprover.php
│   ├── Services/
│   │   ├── VacationCalculatorService.php     # Cálculos
│   │   ├── AutoApprovalService.php           # Auto-aprobación
│   │   ├── VacationImportService.php         # Importación
│   │   └── VacationExportService.php         # Exportación
│   └── View/
│       └── Composers/
│           └── SidebarComposer.php           # Notificaciones sidebar
├── config/
│   └── vacations.php                         # Configuración vacaciones
├── database/
│   ├── migrations/                           # Migraciones DB
│   └── seeders/                              # Datos iniciales
├── docs/                                     # Documentación técnica
│   ├── FLUJO_SOLICITUD_VACACIONES.md
│   ├── SISTEMA_AUTO_APROBACION.md
│   ├── IMPORTACION_MASIVA_VACACIONES.md
│   └── VENCIMIENTO_PERIODOS_VACACIONES.md
├── public/                                   # Assets públicos
├── resources/
│   ├── views/
│   │   └── livewire/                         # Vistas Livewire
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                               # Rutas web
│   ├── rrhh.php                              # Rutas módulo RRHH
│   └── perfil.php                            # Rutas perfil
├── storage/
│   └── logs/                                 # Logs del sistema
├── tests/                                    # Scripts de prueba
├── .env.example                              # Plantilla de configuración
├── composer.json                             # Dependencias PHP
├── package.json                              # Dependencias JS
└── README.md                                 # Este archivo
```

---

## 🧪 Testing

Este proyecto usa **scripts de prueba manuales** en lugar de PHPUnit.

### Ejecutar Pruebas

```bash
# Validar lógica de aprobadores
php tests/test_manager_approver_logic.php

# Probar importación de vacaciones
php tests/test_vacation_import.php

# Validar flujo de aprobación
php tests/test_vacation_approval_flow.php

# Probar actualización de periodos
php tests/test_vacation_update.php
```

### Tests Disponibles

| Script | Descripción |
|--------|-------------|
| `test_manager_approver_logic.php` | Validar asignación de aprobadores |
| `test_vacation_import.php` | Importación masiva |
| `test_vacation_approval_flow.php` | Flujo completo de aprobación |
| `test_vacation_update.php` | Actualización de periodos |
| `test_vacation_validation.php` | Validaciones de solicitud |
| `test_antiguedad_enddate.php` | Cálculo de antigüedad |

**Nota:** Tests manuales recomendados antes de commits importantes.

---

## 📚 Documentación Técnica

Documentación detallada en el directorio `docs/`:

| Documento | Descripción |
|-----------|-------------|
| [FLUJO_SOLICITUD_VACACIONES.md](docs/FLUJO_SOLICITUD_VACACIONES.md) | Flujo completo con fórmulas y estados |
| [SISTEMA_AUTO_APROBACION.md](docs/SISTEMA_AUTO_APROBACION.md) | Configuración y arquitectura de auto-aprobación |
| [IMPORTACION_MASIVA_VACACIONES.md](docs/IMPORTACION_MASIVA_VACACIONES.md) | Formato Excel y proceso de importación |
| [VENCIMIENTO_PERIODOS_VACACIONES.md](docs/VENCIMIENTO_PERIODOS_VACACIONES.md) | Sistema de vencimiento automático |
| [SISTEMA_NOTIFICACIONES_VACACIONES.md](docs/SISTEMA_NOTIFICACIONES_VACACIONES.md) | Notificaciones por email |
| [SISTEMA_LOGS.md](docs/SISTEMA_LOGS.md) | Auditoría y logs del sistema |

---

## 🔒 Seguridad

### Buenas Prácticas Implementadas

- ✅ **Variables de entorno** (`.env`) nunca en repositorio
- ✅ **Autenticación OAuth** con Google
- ✅ **Permisos granulares** con Spatie
- ✅ **Validación de inputs** con Form Requests
- ✅ **Protección CSRF** en formularios
- ✅ **Auditoría completa** con Laravel Auditing
- ✅ **Logs detallados** de operaciones críticas

### Configuración de Producción

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Deshabilitar debug en producción
LOG_LEVEL=error

# Usar HTTPS
SESSION_SECURE_COOKIE=true
```

---

## 🤝 Contribución

### Workflow de Desarrollo

1. **Crear branch** desde `master`
```bash
git checkout -b feature/nueva-funcionalidad
```

2. **Desarrollo y commits**
```bash
git add .
git commit -m "feat: descripción del cambio"
```

3. **Push y Pull Request**
```bash
git push origin feature/nueva-funcionalidad
```

4. **Code Review** requerido antes de merge

### Convenciones de Commits

- `feat:` Nueva funcionalidad
- `fix:` Corrección de bugs
- `docs:` Documentación
- `refactor:` Refactorización
- `test:` Testing
- `chore:` Tareas de mantenimiento

---

## 📞 Soporte

### Recursos
- **Documentación Laravel**: https://laravel.com/docs/10.x
- **Documentación Livewire**: https://livewire.laravel.com/docs/3.x
- **Tailwind CSS**: https://tailwindcss.com/docs
- **WireUI**: https://livewire-wireui.com/

### Contacto
Para soporte técnico, contactar al equipo de desarrollo de Satech Energy.

---

## 📄 Licencia

Copyright © 2026 Tech Energy. Todos los derechos reservados.

Este software es propiedad de Tech Energy y está protegido por leyes de derechos de autor. 
El uso no autorizado está prohibido.

---

**Última actualización:** Abril 2026  
**Versión:** 1.0.0  
**Desarrollado por el equipo de Tech Energy**
