<?php

namespace App\Services\Perfil;

use App\Models\User;
use App\Models\RequisicionCurso;
use Illuminate\Support\Facades\Auth;

class RqCursoService
{
    public  $solicitante;
    public  $rq;

    public $nivel;
    public $usersNivel;
    function __construct($user = null, $rq = null)
    {
        $this->solicitante = $user;
        $this->rq = $rq;
        if (filled($this->solicitante)) {
            $this->nivel = $this->obtenerJerarquiaNivel();
        }
    }
    function notificacionNuevaRq()
    {
        if ($this->nivel == 4) {
            $this->rq->status()->transitionTo('En revisión por jefe directo');
        }
        if ($this->nivel == 3) {
            $this->rq->status()->transitionTo('En revisión por gerente');
        }
        if ($this->nivel == 2) {
            $this->rq->status()->transitionTo('En revisión por dirección general');
        }
    }
    function obtenerJerarquiaNivel()
    {
        // El nivel maximo son 4
        $user = $this->solicitante;
        $ids = [];
        while ($user) {
            $ids[] = $user->id;
            if ($user->id == 106) {
                break;
            }
            $user = $user->jefe;
        }
        return count($ids);
    }

    function getJefeDirecto()
    {
        return $this->solicitante->jefe;
    }
    function getGerente()
    {
        if ($this->nivel == 4) {
            return $this->solicitante->jefe->jefe;
        }
        if ($this->nivel == 3) {
            return $this->solicitante->jefe;
        }
    }
    function getDG()
    {
        if ($this->nivel == 4) {
            return $this->solicitante->jefe->jefe->jefe;
        }
        if ($this->nivel == 3) {
            return $this->solicitante->jefe->jefe;
        }
        if ($this->nivel == 2) {
            return $this->solicitante->jefe;
        }
    }

    function getUsersNivelJefe()
    {
        $lista = collect();
        $users = User::all();
        foreach ($users as $user) {
            $ids = [];
            while ($user) {
                $ids[] = $user->id;
                if ($user->id == 106) {
                    break;
                }
                $user = $user->jefe;
            }
            $lista->push(($ids));
        }
        $filtered = $lista->filter(function ($value) {
            return count($value) == 4;
        });
        $filtered = $filtered->toArray();
        $result = array_filter($filtered, function ($subarray) {
            return $subarray[1] === Auth::user()->id;
        });
        return array_column($result, 0);
    }
    function getUsersNivelGerente()
    {
        $lista = collect();
        $users = User::all();
        foreach ($users as $user) {
            $ids = [];
            while ($user) {
                $ids[] = $user->id;
                if ($user->id == 106) {
                    break;
                }
                $user = $user->jefe;
            }
            $lista->push(($ids));
        }
        $filtered = $lista->filter(function ($value) {
            return count($value) == 3 || count($value) == 4;
        });
        $filtered = $filtered->toArray();
        $result = array_filter($filtered, function ($subarray) {
            if (count($subarray) == 4) {
                return $subarray[2] === Auth::user()->id;
            }
            if (count($subarray) == 3) {
                return $subarray[1] === Auth::user()->id;
            }
        });
        return array_column($result, 0);
    }
}
