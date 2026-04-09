<?php

namespace App\Http\Controllers\Login;


use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\PersonalData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('authentication.login');
    }
    public function redirectToProvider()
    {
        Log::info('🔐 OAuth: Iniciando redirección a Google', [
            'url' => config('app.url'),
            'redirect_uri' => config('services.google.redirect'),
            'session_id' => session()->getId(),
        ]);
        
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        Log::info('🔄 OAuth: Google callback recibido', [
            'session_id' => session()->getId(),
            'has_code' => $request->has('code'),
            'has_state' => $request->has('state'),
            'query_params' => $request->query(),
            'url' => $request->fullUrl(),
        ]);

        try {
            Log::info('📡 OAuth: Solicitando datos de usuario a Google...');
            
            $userGoogle = Socialite::driver('google')->user();
            
            Log::info('✅ OAuth: Datos de Google recibidos', [
                'google_email' => $userGoogle->email,
                'google_name' => $userGoogle->name,
                'google_id' => $userGoogle->id,
            ]);

            // Validar si existe el usuario que viene de google en la tabla USERS
            $user = User::where('email', $userGoogle->email)
                ->where('active', 1)
                ->first();

            if (is_null($user)) {
                Log::warning('⚠️ OAuth: Usuario no encontrado en BD', [
                    'google_email' => $userGoogle->email,
                ]);

                flash()->error('Usuario no encontrado, intentalo mas tarde');
                return redirect()->route('login');
            }

            Log::info('👤 OAuth: Usuario encontrado en BD', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_name' => $user->nombre(),
            ]);

            Log::info('🔓 OAuth: Intentando hacer login...');
            
            Auth::login($user, $remember = true);
            
            Log::info('✅ OAuth: Login ejecutado', [
                'auth_check' => Auth::check(),
                'auth_user_id' => Auth::id(),
                'session_id' => session()->getId(),
                'session_has_auth' => $request->session()->has('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'),
            ]);

            // Regenerar ID de sesión para seguridad
            $request->session()->regenerate();
            
            Log::info('🔄 OAuth: Sesión regenerada', [
                'new_session_id' => session()->getId(),
                'auth_check_after_regenerate' => Auth::check(),
            ]);

        } catch (\Throwable $th) {
            Log::error('❌ OAuth: Error en callback', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            
            flash()->error('Error al procesar login: ' . $th->getMessage());
            return redirect()->route('login');
        }

        Log::info('🏠 OAuth: Preparando redirección final', [
            'has_intended_url' => $request->session()->has('intended_url'),
            'auth_check' => Auth::check(),
        ]);

        if ($request->session()->has('intended_url')) {
            $intended_url = $request->session()->get('intended_url');
            $request->session()->forget('intended_url');
            
            Log::info('↩️ OAuth: Redirigiendo a URL original', ['url' => $intended_url]);
            return redirect()->to($intended_url);
        } else {
            Log::info('🏡 OAuth: Redirigiendo a home');
            return redirect()->route('home');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }

    public function home()
    {
        $year = date('Y');
        $mes = date('m');
        $userBirthday = PersonalData::with(['user'])
            ->whereMonth('birthday', $mes)
            ->orderByRaw("DAY(birthday) ASC")
            ->whereHas('user', function ($query) {
                $query->where('active', 1);
            })
            ->get();

        $usersAniversario = User::whereYear('admission', '!=', $year)
            ->whereMonth('admission', $mes)
            ->where('active', 1)
            ->orderByRaw("DAY(admission) ASC")
            ->get();

        return view('index')
            ->with('userBirthday', $userBirthday)
            ->with('usersAniversario', $usersAniversario);
    }
}
