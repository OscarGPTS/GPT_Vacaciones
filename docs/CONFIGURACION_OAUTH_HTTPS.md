# Configuración OAuth con Túneles (Ngrok/Cloudflare)

## 🔒 Problema Resuelto: OAuth Requiere HTTPS

**Error de Google:**
```
No puedes acceder a esta app porque no cumple con la política OAuth 2.0 de Google.
Request details: redirect_uri=http://vacaciones.tech-energy.lat/login/google/callback
```

**Causa:** Laravel genera URLs con `http://` pero el túnel usa `https://`. OAuth requiere HTTPS.

---

## ✅ Solución Implementada

Se configuró Laravel para **forzar HTTPS** cuando está detrás de un proxy/túnel:

### Archivos Modificados

1. **`app/Http/Middleware/TrustProxies.php`**
   ```php
   protected $proxies = '*'; // Confiar en todos los proxies
   ```

2. **`app/Providers/AppServiceProvider.php`**
   ```php
   public function boot()
   {
       // Forzar HTTPS cuando se usa túnel o en producción
       if (config('app.force_https', false) || request()->header('X-Forwarded-Proto') === 'https') {
           URL::forceScheme('https');
       }
       // ... resto del código
   }
   ```

3. **`config/app.php`**
   ```php
   'force_https' => env('FORCE_HTTPS', false),
   ```

4. **`.env`**
   ```env
   APP_URL=https://vacaciones.tech-energy.lat
   FORCE_HTTPS=true
   ```

---

## 🚀 Configuración Paso a Paso

### 1. Configurar Variables de Entorno

**Para desarrollo con túnel (ngrok/cloudflare):**
```env
APP_URL=https://tu-subdominio.ngrok-free.app
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
SESSION_DOMAIN=null
```

**Para producción con HTTPS:**
```env
APP_URL=https://tu-dominio.com
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
SESSION_DOMAIN=null
```

**Para desarrollo local sin túnel:**
```env
APP_URL=http://localhost
FORCE_HTTPS=false
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax
```

### 2. Limpiar Caché

Después de cambiar `.env`:
```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Configurar Google Cloud Console

#### A. Acceder a Google Cloud Console

1. Ve a: https://console.cloud.google.com/
2. Selecciona tu proyecto
3. Ve a **APIs & Services** → **Credentials**

#### B. Actualizar URI de Redirección

1. Encuentra tu **OAuth 2.0 Client ID**
2. Click en editar (ícono de lápiz)
3. En **Authorized redirect URIs**, agrega:
   ```
   https://vacaciones.tech-energy.lat/login/google/callback
   ```
4. **IMPORTANTE:** Si estás usando ngrok, cada vez que se reinicia cambia la URL. Considera:
   - Usar **ngrok con dominio fijo** (plan de pago)
   - Usar **Cloudflare Tunnel** (gratis, dominio permanente)
   - Desplegar en producción

#### C. Guardar Cambios

Click en **Save** y espera 1-2 minutos para que los cambios se propaguen.

---

## 🔍 Verificación

### Test 1: Verificar que Laravel genera HTTPS

```bash
php artisan tinker
>>> url('/');
# Debe devolver: "https://vacaciones.tech-energy.lat"
>>> route('login');  
# Debe devolver: "https://vacaciones.tech-energy.lat/login"
```

### Test 2: Verificar Headers del Proxy

```bash
php artisan tinker
>>> request()->header('X-Forwarded-Proto');
# Debe devolver: "https"
>>> request()->isSecure();
# Debe devolver: true
```

### Test 3: Probar Login con Google

1. Navega a: `https://vacaciones.tech-energy.lat/login`
2. Click en "Login con Google"
3. Debería redirigir correctamente sin errores

---

## 🛠️ Solución de Problemas

### Error: "redirect_uri mismatch"

**Causa:** La URI en Google Cloud no coincide exactamente.

**Solución:**
1. Copia el error completo que muestra la URI exacta
2. Pega esa URI exacta en Google Cloud Console
3. Asegúrate que no tenga espacios ni caracteres extra
4. Espera 1-2 minutos tras guardar

### Error: Laravel sigue generando HTTP

**Verificar:**
```bash
# .env debe tener:
FORCE_HTTPS=true

# Limpiar caché:
php artisan config:clear
```

### Error: Selecciono cuenta de Google pero no inicia sesión

**Causa:** Las cookies de sesión no se guardan porque no están marcadas como `Secure` en HTTPS.

**Solución:**
```env
# Agregar a .env:
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
SESSION_DOMAIN=null

# Limpiar caché:
php artisan config:clear
php artisan cache:clear
```

**Cómo verificar:**
1. Abre las DevTools del navegador (F12)
2. Ve a la pestaña "Application" > "Cookies"
3. Busca la cookie `laravel_session`
4. Debe tener:
   - ✅ `Secure`: Yes
   - ✅ `SameSite`: Lax
   - ✅ `Domain`: tu dominio

Si la cookie no aparace o está marcada como bloqueada, revisa la configuración.

### Error: "Session cookie is not secure"

**Causa:** `SESSION_SECURE_COOKIE` no está habilitado.

**Solución:**
```env
SESSION_SECURE_COOKIE=true
```

Luego limpia caché:
```bash
php artisan config:clear
```

### Ngrok cambia la URL cada vez

**Opciones:**
1. **Ngrok con dominio fijo** ($8/mes):
   ```bash
   ngrok http 80 --domain=tu-app.ngrok-free.app
   ```

2. **Cloudflare Tunnel** (gratis):
   ```bash
   cloudflared tunnel --url http://localhost:80
   ```
   - Crea un túnel permanente
   - Dominio fijo tipo: `app-name.trycloudflare.com`

3. **Desplegar en servidor real**

---

## 🌐 Configuración para Otros Proveedores OAuth

### Facebook OAuth

Configurar en: https://developers.facebook.com/apps/

**Valid OAuth Redirect URIs:**
```
https://vacaciones.tech-energy.lat/login/facebook/callback
```

### Microsoft/Azure AD

Configurar en: https://portal.azure.com/

**Redirect URIs:**
```
https://vacaciones.tech-energy.lat/login/microsoft/callback
```

### GitHub OAuth

Configurar en: https://github.com/settings/developers

**Authorization callback URL:**
```
https://vacaciones.tech-energy.lat/login/github/callback
```

---

## 📝 Configuración en Producción

Una vez en producción con dominio real:

```env
# .env en producción
APP_ENV=production
APP_DEBUG=false
APP_URL=https://rrhh.satechenergy.com
FORCE_HTTPS=true
```

Y actualiza Google Cloud Console con la URL de producción:
```
https://rrhh.satechenergy.com/login/google/callback
```

---

## 🔐 Mejores Prácticas de Seguridad

1. **NUNCA** expongas tu aplicación local directamente a internet sin túnel
2. **Usa HTTPS** siempre en producción
3. **Limita los dominios** autorizados en Google Cloud Console
4. **Rota credenciales** OAuth periódicamente
5. **Monitorea logs** de autenticación

---

## 📚 Referencias

- [Laravel Behind Proxies](https://laravel.com/docs/10.x/requests#configuring-trusted-proxies)
- [Google OAuth 2.0](https://developers.google.com/identity/protocols/oauth2)
- [Ngrok Documentation](https://ngrok.com/docs)
- [Cloudflare Tunnel](https://developers.cloudflare.com/cloudflare-one/connections/connect-apps/)

---

**✅ Estado:** Configurado para túneles y producción  
**📅 Fecha:** Abril 2026  
**🔒 Seguridad:** OAuth funciona correctamente con HTTPS
