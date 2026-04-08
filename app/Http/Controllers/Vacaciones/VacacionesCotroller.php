<?php

namespace App\Http\Controllers\Vacaciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VacacionesCotroller extends Controller
{
    public function home()
    {
        return view('vacaciones.index');
    }

    public function create()
    {
        return view('vacaciones.create');
    }
}
