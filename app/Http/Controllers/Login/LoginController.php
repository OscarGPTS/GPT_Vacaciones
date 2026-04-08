<?php

namespace App\Http\Controllers\Login;


use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\PersonalData;
use Illuminate\Support\Facades\Auth;
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
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        try {
            $userGoogle = Socialite::driver('google')->user();
            // Validar si existe el usuario que viene de google en la tabla USERS
            $user = User::where('email', $userGoogle->email)
                ->where('active', 1)
                ->first();

            if (is_null($user)) {

                flash()->error('Usuario no encontrado, intentalo mas tarde');

                return redirect()->route('login');
            }

            Auth::login($user, $remember = true);
        } catch (\Throwable $th) {
            flash()->error('Usuario no encontrado');
            return redirect()->route('login');
        }

        if ($request->session()->has('intended_url')) {
            $intended_url = $request->session()->get('intended_url');
            $request->session()->forget('intended_url');
            return redirect()->to($intended_url);
        }else{
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
