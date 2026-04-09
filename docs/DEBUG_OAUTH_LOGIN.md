# Guía de Depuración de OAuth Login

## 🔍 Problema Actual
El flujo de OAuth con Google se completa correctamente (seleccionas tu cuenta de Google), pero después te redirige de vuelta a la pantalla de login en lugar de mantener la sesión activa.

## 📊 Logs Implementados

Se han agregado logs detallados en `LoginController` que registran cada paso del proceso de autenticación:

### Eventos registrados:
- 🔐 **Inicio de redirección a Google**: Muestra URL, redirect_uri y session_id
- 🔄 **Callback recibido**: Muestra parámetros de query, session_id, código de autorización
- 📡 **Solicitud a Google**: Indica cuando se pide información del usuario a Google
- ✅ **Datos de Google recibidos**: Email, nombre e ID del usuario de Google
- 👤 **Usuario encontrado en BD**: ID, email y nombre del usuario local
- 🔓 **Intento de login**: Antes de ejecutar Auth::login()
- ✅ **Login ejecutado**: Estado de Auth::check(), user_id, session_id
- 🔄 **Sesión regenerada**: Nuevo session_id después de regenerate()
- 🏠 **Preparando redirección**: Verifica si hay URL de destino original
- ❌ **Errores**: Cualquier excepción capturada con stack trace completo

## 🚀 Cómo Probar

### Opción 1: Ver logs en tiempo real (RECOMENDADO)

1. **Abre una terminal PowerShell en tu proyecto**
2. **Ejecuta el monitor de logs:**
   ```powershell
   php tests/watch_oauth_logs.php
   ```
3. **Deja esta terminal abierta** - verás cada evento de OAuth en tiempo real
4. **En tu navegador**, intenta hacer login con Google
5. **Observa la terminal** - verás el flujo completo paso a paso

### Opción 2: Ver el archivo de logs completo

Después de intentar hacer login, abre el archivo:
```
storage/logs/laravel.log
```

Busca las líneas que contienen emojis (🔐, 🔄, ✅, ❌, etc.)

## 🧪 Verificación de Configuración

Ejecuta este script para verificar que todo esté configurado correctamente:

```powershell
php tests/verify_session_config.php
```

Esto verificará:
- ✅ Configuración de sesiones (driver, secure, same_site)
- ✅ Permisos del directorio de sesiones
- ✅ Middleware configurado
- ✅ Variables de entorno

## 📋 Checklist de Diagnóstico

Cuando ejecutes la prueba de login, presta atención a:

### ✅ Puntos de verificación exitosos:
- [ ] Se recibe el callback de Google con código de autorización
- [ ] Socialite obtiene los datos del usuario de Google
- [ ] Se encuentra el usuario en la base de datos local
- [ ] Auth::login() se ejecuta sin errores
- [ ] Auth::check() devuelve `true` después del login
- [ ] La sesión tiene un ID válido
- [ ] Se regenera la sesión correctamente

### ⚠️ Puntos problemáticos comunes:
- [ ] El session_id cambia entre redirect y callback (cookies no se guardan)
- [ ] Auth::check() es `false` después del login (sesión no persiste)
- [ ] Error 500 o excepción capturada (problema con la BD o Google API)
- [ ] El archivo de sesión no se crea en `storage/framework/sessions/`

## 🔧 Posibles Soluciones según Diagnóstico

### Si el session_id cambia constantemente:
**Problema:** Las cookies no se están guardando en el navegador

**Solución:**
1. Verifica que tu tunnel (ngrok/cloudflare) esté activo
2. Asegúrate de que `APP_URL` en `.env` sea exactamente tu URL de tunnel
3. Limpia las cookies del navegador para tu dominio
4. Verifica que `SESSION_SECURE_COOKIE=1` esté activo

### Si Auth::check() es false después de Auth::login():
**Problema:** La sesión no se está guardando correctamente

**Solución:**
1. Verifica permisos del directorio `storage/framework/sessions`
2. Ejecuta `php artisan cache:clear`
3. Ejecuta `php artisan config:clear`
4. Reinicia Apache en XAMPP

### Si no se encuentra el usuario en la BD:
**Problema:** El email de Google no coincide con la BD

**Solución:**
1. Revisa en los logs qué email devuelve Google
2. Verifica en la BD que ese usuario exista con `active=1`
3. Asegúrate de que el email coincida exactamente

### Si aparece error "Call to a member function session() on null":
**Problema:** El middleware StartSession no está corriendo

**Solución:**
1. Verifica que las rutas estén en `routes/web.php`
2. Ejecuta `php artisan route:clear`
3. Reinicia el servidor

## 📝 Formato de Logs

Cada entrada de log incluye información estructurada en formato JSON:

```
[2024-01-15 10:30:15] local.INFO: 🔐 OAuth: Iniciando redirección a Google {
    "url": "https://vacaciones.tech-energy.lat",
    "redirect_uri": "https://vacaciones.tech-energy.lat/login/google/callback",
    "session_id": "abc123xyz"
}
```

**Busca específicamente:**
- El valor de `session_id` - ¿cambia entre eventos?
- El valor de `auth_check` - ¿es `true` después del login?
- Cualquier línea con ❌ - indica un error

## 🎯 Siguiente Paso

Una vez que tengas los logs:

1. **Si ves el flujo completo sin errores pero Auth::check() es false:**
   - Problema con la persistencia de sesión después de regenerate()
   - Necesitamos investigar el middleware de autenticación

2. **Si ves que el session_id cambia entre redirect y callback:**
   - Problema con cookies HTTPS
   - Necesitamos revisar la configuración del tunnel

3. **Si ves errores ❌:**
   - Indica el problema específico en el stack trace
   - Podemos corregirlo directamente

## 📞 Información a Reportar

Cuando tengas los logs, comparte:
1. El flujo completo de emojis que aparecieron
2. Los valores de `session_id` en cada paso
3. El valor de `auth_check` después del login
4. Cualquier mensaje de error ❌

---

**Archivos modificados:**
- `app/Http/Controllers/Login/LoginController.php` - Logs agregados
- `tests/watch_oauth_logs.php` - Monitor en tiempo real
- `tests/verify_session_config.php` - Verificación de configuración
