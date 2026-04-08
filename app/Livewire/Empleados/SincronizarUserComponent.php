<?php

namespace App\Livewire\Empleados;

use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\IT\User as UserIt;
use Illuminate\Support\Facades\DB;
use App\Models\Gpt\User as UserGpt;
use App\Models\Satech\User as UserSatech;
use App\Models\Opreport\User as UserOpreport;



class SincronizarUserComponent extends Component
{
    use Actions;
    public $user_id;
    public $user, $satech, $it, $gpt, $opreport;

    public function mount()
    {
        try {
            $this->user = User::with(['job', 'razonSocial', 'personalData'])->find($this->user_id);
        } catch (\Exception $e) {
            dump("mysql_rrhh");
            dump($e->getMessage());
        }
        try {
            $this->satech = UserSatech::find($this->user_id);
        } catch (\Exception $e) {
            dump("mysql_satech");
            dump($e->getMessage());
        }
        try {
            $this->it = UserIt::with('razonSocial')->find($this->user_id);
        } catch (\Exception $e) {
            dump("mysql_it");
            dump($e->getMessage());
        }
        try {
            $this->gpt = UserGpt::find($this->user_id);
        } catch (\Exception $e) {
            dump("mysql_gpt");
            dump($e->getMessage());
        }
        try {
            $this->opreport = UserOpreport::find($this->user_id);
        } catch (\Exception $e) {
            dump("mysql_opreports");
            dump($e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.empleados.sincronizar-user-component');
    }

    // Satech
    public function sincronizarUserSatech()
    {
        try {
            DB::beginTransaction();
            $this->satech = UserSatech::updateOrCreate(
                ['id' =>  $this->user_id],
                [
                    'id' => $this->user->id,
                    'last_name' => $this->user->last_name,
                    'first_name' => $this->user->first_name,
                    'admission' => $this->user->admission,
                    'boss_id' => $this->user->boss_id,
                    'email' => $this->user->email,
                    'phone' => $this->user->phone,
                    'profile_image' => $this->user->profile_image,
                    'area' => $this->user->job->departamento->area->name,
                    'depto' => $this->user->job->departamento->name,
                    'puesto' => $this->user->job->name,
                    'active' => $this->user->active,
                    'business_name_id' => $this->user->business_name_id
                ]
            );
            DB::commit();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Información guardada',
                    $description = 'Se guardo la informacion del usuario en SATECH!!'
                );
            });
        } catch (\Exception $e) {
            DB::rollBack();
            throw ($e);
        }
        $this->mount();
    }
    // IT
    public function sincronizarUserIt()
    {
        try {
            DB::beginTransaction();
            $this->it = UserIt::updateOrCreate(
                ['id' =>  $this->user_id],
                [
                    'id' => $this->user->id,
                    'last_name' => $this->user->last_name,
                    'first_name' => $this->user->first_name,
                    'admission' => $this->user->admission,
                    'boss_id' => $this->user->boss_id,
                    'email' => $this->user->email,
                    'phone' => $this->user->phone,
                    'profile_image' => $this->user->profile_image,
                    'area' => $this->user->job->departamento->area->name,
                    'depto' => $this->user->job->departamento->name,
                    'puesto' => $this->user->job->name,
                    'active' => $this->user->active,
                    'business_name_id' => $this->user->business_name_id
                ]
            );
            DB::commit();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Información guardada',
                    $description = 'Se guardo la informacion del usuario en IT-Responsivas!!'
                );
            });
        } catch (\Exception $e) {
            DB::rollBack();
            throw ($e);
        }
        $this->mount();
    }
    // VCARD
    public function sincronizarUserVcard()
    {
        try {
            DB::beginTransaction();
            $this->gpt = UserGpt::updateOrCreate(
                ['id' =>  $this->user_id],
                [
                    'id' => $this->user->id,
                    'nombre' => $this->user->last_name,
                    'apellido' => $this->user->first_name,
                    'admission' => $this->user->admission,
                    'email' => $this->user->email,
                    'cel_1' => $this->user->phone,
                    'puesto' => $this->user->job->name,
                    'empresa' => $this->user->razonSocial->name,
                    'profile_img' => $this->user->profile_image,
                ]
            );
            DB::commit();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Información guardada',
                    $description = 'Se guardo la informacion del usuario en GptServices-VCARD!!'
                );
            });
        } catch (\Exception $e) {
            DB::rollBack();
            throw ($e);
        }
        $this->mount();
    }
    // Cumpleaños
    public function sincronizarUserOpreport()
    {
        try {
            DB::beginTransaction();
            $this->opreport = UserOpreport::updateOrCreate(
                ['id' =>  $this->user_id],
                [
                    'id' => $this->user->id,
                    'lastName' => $this->user->last_name,
                    'firstName' => $this->user->first_name,
                    'birthday' => $this->user->personalData->birthday,
                    'curp' => $this->user->personalData->curp,
                    'rfc' => $this->user->personalData->rfc,
                    'nss' => $this->user->personalData->nss,
                    'bloodType' => 'N/A',
                    'admission' => $this->user->admission,
                    'area' => $this->user->job->departamento->area->name,
                    'depto' => $this->user->job->departamento->name,
                    'job' => $this->user->job->name,
                    'pseudo' => 'N/A',
                    'business' => $this->user->razonSocial->name,
                    'email' => $this->user->email,
                    'phone' => $this->user->phone,
                    'profile_img' => $this->user->profile_image,
                    'empStatus' => $this->user->active
                ]
            );
            DB::commit();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Información guardada',
                    $description = 'Se guardo la informacion del usuario en GptServices-Cumpleaños!!'
                );
            });
        } catch (\Exception $e) {
            DB::rollBack();
            throw ($e);
        }

        $this->mount();
    }
    public function sincronizarTodo()
    {
        $this->sincronizarUserSatech();
        $this->sincronizarUserIt();
        $this->sincronizarUserVcard();
        $this->sincronizarUserOpreport();
        $this->notification()->success(
            $title = 'Información guardada',
            $description = 'Se guardo la informacion del usuario en todos los sistemas!!'
        );
    }
}
