# Sistema de Notificaciones por Correo para Solicitudes de Vacaciones

## 📋 Resumen

Se ha implementado un sistema completo de notificaciones por correo electrónico para el flujo de solicitudes de vacaciones.

## ✅ Archivos Creados

### 1. Clases de Correo (app/Mail/)
- `VacationRequestCreated.php` - Notifica al jefe directo sobre nueva solicitud
- `VacationRequestRejectedByManager.php` - Notifica al empleado sobre rechazo del jefe
- `VacationRequestPendingRH.php` - Notifica a RH sobre solicitud aprobada por jefe
- `VacationRequestApprovedByRH.php` - Notifica al empleado sobre aprobación de RH
- `VacationRequestRejectedByRH.php` - Notifica al empleado sobre rechazo de RH

### 2. Vistas de Correo (resources/views/emails/vacations/)
- `request-created.blade.php`
- `request-rejected-by-manager.blade.php`
- `request-pending-rh.blade.php`
- `request-approved-by-rh.blade.php`
- `request-rejected-by-rh.blade.php`

### 3. Configuración
- `config/vacations.php` - Contiene IDs de usuarios de RH (configurable)

## ✅ Modificaciones COMPLETADAS

### 1. VacacionesController.php ✓

**Ubicación:** `app/Http/Controllers/VacacionesController.php`

**Línea ~120** - Después de crear la solicitud

```php
use App\Mail\VacationRequestCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

// ... en método store() ...

$newRequest = RequestVacations::create($requestData);

// Actualizar días seleccionados
RequestApproved::where('users_id', $targetUserId)
    ->whereNull('requests_id')
    ->update(['requests_id' => $newRequest->id]);

// Enviar notificación al jefe directo
if ($newRequest->directManager && $newRequest->directManager->email) {
    try {
        Mail::to($newRequest->directManager->email)
            ->send(new VacationRequestCreated($newRequest));
        Log::info('Correo enviado al jefe directo', [
            'request_id' => $newRequest->id,
            'manager_email' => $newRequest->directManager->email
        ]);
    } catch (\Exception $e) {
        Log::error('Error enviando correo al jefe directo: ' . $e->getMessage(), [
            'request_id' => $newRequest->id,
            'manager_id' => $newRequest->direct_manager_id
        ]);
    }
}
```

### 2. RequestController.php ✓

**Ubicación:** `app/Http/Controllers/RequestController.php`

**Método `approveRejectManager()` - Línea ~155**

```php
use App\Mail\VacationRequestRejectedByManager;
use App\Mail\VacationRequestPendingRH;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

public function approveRejectManager(Request $request, $id)
{
    $requestVacation = RequestVacations::findOrFail($id);

    $request->validate([
        'action' => 'required|in:aprobar,rechazar'
    ]);

    $status = $request->action === 'aprobar' ? 'Aprobada' : 'Rechazada';
    
    $requestVacation->update([
        'direct_manager_status' => $status
    ]);

    if ($request->action === 'rechazar') {
        $this->moveToRejected($requestVacation);
        
        // Notificar al empleado sobre el rechazo
        if ($requestVacation->user && $requestVacation->user->email) {
            try {
                Mail::to($requestVacation->user->email)
                    ->send(new VacationRequestRejectedByManager($requestVacation));
                Log::info('Correo de rechazo enviado al empleado', [
                    'request_id' => $requestVacation->id,
                    'employee_email' => $requestVacation->user->email
                ]);
            } catch (\Exception $e) {
                Log::error('Error enviando correo de rechazo al empleado: ' . $e->getMessage(), [
                    'request_id' => $requestVacation->id,
                    'employee_id' => $requestVacation->user_id
                ]);
            }
        }
    } else {
        // Si aprueba, notificar a usuarios de RH
        $rhUserIds = config('vacations.rh_user_ids', [123]);
        $rhUsers = User::whereIn('id', $rhUserIds)->whereNotNull('email')->get();

        foreach ($rhUsers as $rhUser) {
            try {
                Mail::to($rhUser->email)
                    ->send(new VacationRequestPendingRH($requestVacation));
                Log::info('Correo enviado a RH', [
                    'request_id' => $requestVacation->id,
                    'rh_user_email' => $rhUser->email
                ]);
            } catch (\Exception $e) {
                Log::error('Error enviando correo a RH: ' . $e->getMessage(), [
                    'request_id' => $requestVacation->id,
                    'rh_user_id' => $rhUser->id
                ]);
            }
        }
    }

    $message = $request->action === 'aprobar' 
        ? 'Solicitud aprobada correctamente. Será enviada a Recursos Humanos.'
        : 'Solicitud rechazada correctamente.';
        
    return back()->with('success', $message);
}
```

### 3. VacacionesRh.php (Livewire) ✓

**Ubicación:** `app/Livewire/VacacionesRh.php`

**Imports agregados:**

```php
use App\Mail\VacationRequestApprovedByRH;
use App\Mail\VacationRequestRejectedByRH;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
```

**En método `approveRequest()` - Línea ~169:**

```php
session()->flash('success', "Solicitud aprobada exitosamente. Se descontaron {$diasSolicitados} días: {$detalleAfectados}");

// Enviar notificación al empleado
if ($this->selectedRequest->user && $this->selectedRequest->user->email) {
    try {
        Mail::to($this->selectedRequest->user->email)
            ->send(new VacationRequestApprovedByRH($this->selectedRequest));
        Log::info('Correo de aprobación enviado al empleado', [
            'request_id' => $this->selectedRequest->id,
            'employee_email' => $this->selectedRequest->user->email
        ]);
    } catch (\Exception $e) {
        Log::error('Error enviando correo de aprobación al empleado: ' . $e->getMessage(), [
            'request_id' => $this->selectedRequest->id,
            'employee_id' => $this->selectedRequest->user_id
        ]);
    }
}
```

**En método `rejectRequest()` - Línea ~194:**

```php
session()->flash('success', 'Solicitud rechazada por Recursos Humanos.');

// Enviar notificación al empleado
if ($this->selectedRequest->user && $this->selectedRequest->user->email) {
    try {
        Mail::to($this->selectedRequest->user->email)
            ->send(new VacationRequestRejectedByRH($this->selectedRequest));
        Log::info('Correo de rechazo enviado al empleado', [
            'request_id' => $this->selectedRequest->id,
            'employee_email' => $this->selectedRequest->user->email
        ]);
    } catch (\Exception $e) {
        Log::error('Error enviando correo de rechazo al empleado: ' . $e->getMessage(), [
            'request_id' => $this->selectedRequest->id,
            'employee_id' => $this->selectedRequest->user_id
        ]);
    }
}
```

## 📧 Flujo de Notificaciones

```
1. EMPLEADO crea solicitud (VacacionesController::store)
   └─> 📧 Correo a: JEFE DIRECTO (request-created.blade.php)

2. JEFE DIRECTO rechaza (RequestController::approveRejectManager)
   └─> 📧 Correo a: EMPLEADO (request-rejected-by-manager.blade.php)

3. JEFE DIRECTO aprueba (RequestController::approveRejectManager)
   └─> 📧 Correo a: USUARIOS RH [123, ...] (request-pending-rh.blade.php)

4. RH aprueba (VacacionesRh::approveRequest)
   └─> 📧 Correo a: EMPLEADO (request-approved-by-rh.blade.php)

5. RH rechaza (VacacionesRh::rejectRequest)
   └─> 📧 Correo a: EMPLEADO (request-rejected-by-rh.blade.php)
```

## ⚙️ Configuración de IDs de RH

Para agregar más usuarios de RH que reciban notificaciones, edita:

**config/vacations.php:**

```php
'rh_user_ids' => [
    123,  // Usuario principal de RH
    456,  // Otro usuario de RH
    789,  // Otro usuario de RH
],
```

## 🧪 Pruebas

Para probar los correos, puedes usar:

```php
// En routes/web.php o tinker
Route::get('/test-vacation-email', function () {
    $request = \App\Models\RequestVacations::with(['user', 'directManager', 'requestDays'])->first();
    return new \App\Mail\VacationRequestCreated($request);
});
```

Luego visita: `http://tu-dominio/test-vacation-email`

## 📝 Notas Importantes

1. **Relaciones requeridas en RequestVacations:**
   - `user` - El empleado que solicita
   - `directManager` - El jefe directo
   - `requestDays` - Los días específicos solicitados

2. **Verificar que exista el campo `email` en la tabla `users`**

3. **Configurar correctamente el servidor SMTP** en `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tuempresa.com
MAIL_FROM_NAME="${APP_NAME}"
```

4. **Todos los envíos de correo están envueltos en try-catch** para que no interrumpan el flujo si falla el envío.

5. **Los errores de envío se registran en el log** (`storage/logs/laravel.log`) para debugging.

6. **Cada envío exitoso también se registra en el log** para auditoría.

## ✨ Características

- ✅ Diseño responsive y profesional
- ✅ Compatible con clientes de correo (Gmail, Outlook, etc.)
- ✅ Manejo de errores sin interrumpir el flujo
- ✅ Logging completo de envíos y errores
- ✅ Fácilmente extensible y configurable
- ✅ IDs de RH configurables por archivo
- ✅ Listado de días específicos en los correos
- ✅ Emojis para mejor visualización
- ✅ Totalmente integrado en el flujo existente

## 🎯 Estado de Implementación

| Componente | Estado | Ubicación |
|------------|--------|-----------|
| Mailable Classes | ✅ Completado | `app/Mail/` |
| Email Templates | ✅ Completado | `resources/views/emails/vacations/` |
| Configuración | ✅ Completado | `config/vacations.php` |
| Integración VacacionesController | ✅ Completado | Línea ~120 |
| Integración RequestController | ✅ Completado | Línea ~155 |
| Integración VacacionesRh | ✅ Completado | Líneas ~169, ~194 |

## 🔍 Verificación

Para verificar que todo funciona correctamente:

1. **Crear una solicitud de vacaciones** → Verifica que el jefe reciba correo
2. **Jefe aprueba** → Verifica que RH reciba correos
3. **Jefe rechaza** → Verifica que empleado reciba correo de rechazo
4. **RH aprueba** → Verifica que empleado reciba correo de aprobación
5. **RH rechaza** → Verifica que empleado reciba correo de rechazo
6. **Revisar logs** → `storage/logs/laravel.log` para mensajes de éxito/error
