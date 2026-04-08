<?php

namespace App\Policies;

use App\Models\RequisicionPersonal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequisicionPersonalPolicy
{
    use HandlesAuthorization;

  public function revisar(User $user, RequisicionPersonal $requisicion){


    $subordinado = $user->subordinados->find($requisicion->solicitante_id);

    if(isset($subordinado))
    {
        return false;
    }

    return $subordinado->id == $requisicion->solicitante_id;

  }

}
