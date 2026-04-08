# Sistema de Aprobaciones Automáticas de Vacaciones

Este sistema permite aprobar automáticamente solicitudes de vacaciones que han estado pendientes por más de 5 días.

## 🚀 Características

### ✅ Aprobación Automática de Supervisor
- **Activada**: ✓ Funcional
- **Timeout**: 5 días desde la creación de la solicitud
- **Condición**: `direct_manager_status = 'Pendiente'`
- **Acción**: Cambia a `direct_manager_status = 'Aprobada'`

### ⏸️ Aprobación Automática de RH
- **Estado**: 🔴 DESHABILITADA por el momento
- **Timeout**: 5 días desde la última actualización
- **Condición**: `human_resources_status = 'Pendiente'`
- **Acción**: Aprobaría y descontaría días automáticamente

## 🛠️ Uso del Sistema

### 📋 Comando de Consola

```bash
# Ejecutar proceso completo
php artisan vacations:auto-approve

# Solo mostrar estadísticas
php artisan vacations:auto-approve --stats

# Modo dry-run (sin cambios reales)
php artisan vacations:auto-approve --dry-run
```

### 🌐 API Endpoints

Todas las rutas requieren autenticación con Sanctum:

```bash
# Procesar aprobaciones automáticas
POST /api/vacations/auto-approvals/process

# Obtener estadísticas
GET /api/vacations/auto-approvals/stats

# Vista previa (dry-run)
GET /api/vacations/auto-approvals/dry-run

# Habilitar aprobaciones automáticas de RH (futuro)
POST /api/vacations/auto-approvals/hr/enable

# Deshabilitar aprobaciones automáticas de RH
POST /api/vacations/auto-approvals/hr/disable
```

### 📅 Programación Automática

El sistema está programado para ejecutarse automáticamente:
- **Frecuencia**: Diariamente a las 9:00 AM
- **Zona horaria**: America/Mexico_City
- **Configuración**: `app/Console/Kernel.php`

## 🔧 Configuración

### Lógica de Funcionamiento

#### Para Supervisor (Activa):
1. Busca solicitudes con `direct_manager_status = 'Pendiente'`
2. Filtra las que tienen más de 5 días desde `created_at`
3. Cambia estado a `'Aprobada'`
4. Actualiza `updated_at` con timestamp actual
5. Registra la acción en logs para auditoría

#### Para RH (Deshabilitada):
1. Buscaría solicitudes con `human_resources_status = 'Pendiente'`
2. Filtraría las que tienen más de 5 días desde `updated_at`
3. Validaría días disponibles del empleado
4. Aprobaría y descontaría días automáticamente
5. Actualizaría `human_resources_status = 'Aprobada'`

## 📊 Ejemplo de Respuesta API

```json
{
  "success": true,
  "message": "Proceso de aprobaciones automáticas completado",
  "data": {
    "direct_manager_approvals": 3,
    "hr_approvals": 0,
    "errors": []
  }
}
```

## 🚨 Consideraciones de Seguridad

- ✅ Requiere autenticación con Sanctum
- ✅ Logs detallados de todas las acciones
- ✅ Registro de cambios en `updated_at`
- ✅ Validación de días disponibles (para RH)
- ✅ Manejo de errores robusto

## 📝 Logs

El sistema registra logs detallados en:
- `storage/logs/laravel.log`
- Incluye información de solicitudes procesadas
- Errores y excepciones
- Timestamps de procesamiento

## ⚡ Habilitar Aprobaciones de RH

Para habilitar las aprobaciones automáticas de RH en el futuro:

1. Descomentar las líneas en `AutoApprovalService::processAutoApprovals()`
2. Llamar al endpoint: `POST /api/vacations/auto-approvals/hr/enable`
3. El sistema comenzará a procesar aprobaciones de RH automáticamente

## 🔧 Mantenimiento

- El comando puede ejecutarse manualmente en cualquier momento
- Las estadísticas muestran el estado actual del sistema
- El modo dry-run permite probar sin hacer cambios
- Los logs proporcionan auditoría completa del proceso