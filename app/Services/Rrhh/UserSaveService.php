<?php

namespace App\Services\Rrhh;

use App\Models\User;
use App\Models\PersonalData;

use App\Models\IT\User as UserIt;
use Illuminate\Support\Facades\DB;
use App\Models\Gpt\User as UserGpt;
use App\Models\Satech\User as UserSatech;
use App\Models\Opreport\User as UserOpreport;

class UserSaveService
{
    public $userService;

    public function __construct(User $user)
    {
        $this->userService = $user;
    }
    // Satech
    public function sincronizarUserSatech()
    {
        try {
            DB::beginTransaction();
            UserSatech::updateOrCreate(
                ['id' =>  $this->userService->id],
                [
                    'id' => $this->userService->id,
                    'last_name' => $this->userService->last_name,
                    'first_name' => $this->userService->first_name,
                    'admission' => $this->userService->admission,
                    'boss_id' => $this->userService->boss_id,
                    'email' => $this->userService->email,
                    'phone' => $this->userService->phone,
                    'profile_image' => $this->userService->profile_image,
                    'area' => $this->userService->job->departamento->area->name,
                    'depto' => $this->userService->job->departamento->name,
                    'puesto' => $this->userService->job->name,
                    'active' => $this->userService->active,
                ]
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
        }
    }
    // IT
    public function sincronizarUserIt()
    {
        try {
            DB::beginTransaction();
            UserIt::updateOrCreate(
                ['id' =>  $this->userService->id],
                [
                    'id' => $this->userService->id,
                    'last_name' => $this->userService->last_name,
                    'first_name' => $this->userService->first_name,
                    'admission' => $this->userService->admission,
                    'boss_id' => $this->userService->boss_id,
                    'email' => $this->userService->email,
                    'phone' => $this->userService->phone,
                    'profile_image' => $this->userService->profile_image,
                    'area' => $this->userService->job->departamento->area->name,
                    'depto' => $this->userService->job->departamento->name,
                    'puesto' => $this->userService->job->name,
                    'active' => $this->userService->active,
                    'business_name_id' => $this->userService->business_name_id
                ]
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
        }
    }
    // VCARD
    public function sincronizarUserVcard()
    {
        try {
            DB::beginTransaction();
            UserGpt::updateOrCreate(
                ['id' =>  $this->userService->id],
                [
                    'id' => $this->userService->id,
                    'nombre' => $this->userService->last_name,
                    'apellido' => $this->userService->first_name,
                    'admission' => $this->userService->admission,
                    'email' => $this->userService->email,
                    'cel_1' => $this->userService->phone,
                    'puesto' => $this->userService->job->name,
                    'empresa' => $this->userService->razonSocial->name,
                    'profile_img' => $this->userService->profile_image,
                ]
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
        }
    }
    // Cumpleaños
    public function sincronizarUserOpreport()
    {
        try {
            DB::beginTransaction();
            UserOpreport::updateOrCreate(
                ['id' =>  $this->userService->id],
                [
                    'id' => $this->userService->id,
                    'lastName' => $this->userService->last_name,
                    'firstName' => $this->userService->first_name,
                    'birthday' => $this->userService->personalData->birthday,
                    'curp' => $this->userService->personalData->curp,
                    'rfc' => $this->userService->personalData->rfc,
                    'nss' => $this->userService->personalData->nss,
                    'bloodType' => 'N/A',
                    'admission' => $this->userService->admission,
                    'area' => $this->userService->job->departamento->area->name,
                    'depto' => $this->userService->job->departamento->name,
                    'job' => $this->userService->job->name,
                    'pseudo' => 'N/A',
                    'business' => $this->userService->razonSocial->name,
                    'email' => $this->userService->email,
                    'phone' => $this->userService->phone,
                    'profile_img' => $this->userService->profile_image,
                    'empStatus' => $this->userService->active
                ]
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
        }
    }
    public function sincronizarTodo()
    {
        $this->sincronizarUserSatech();
        $this->sincronizarUserIt();
        $this->sincronizarUserVcard();
        $this->sincronizarUserOpreport();
    }

    public function sincronizarFoto()
    {
        try {
            DB::beginTransaction();
            $userUpdate = UserSatech::find($this->userService->id);
            $userUpdate->profile_image = $this->userService->profile_image;
            $userUpdate->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('error en SATECH');
            logger()->error($e);
        }
        try {
            DB::beginTransaction();
            $userUpdate = UserIt::find($this->userService->id);
            $userUpdate->profile_image = $this->userService->profile_image;
            $userUpdate->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('error en IT-Responsivas');
            logger()->error($e);
        }
        try {
            DB::beginTransaction();
            $userUpdate = UserGpt::find($this->userService->id);
            $userUpdate->profile_img = $this->userService->profile_image;
            $userUpdate->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('error en GPT Services');
            logger()->error($e);
        }
        try {
            DB::beginTransaction();
            $userUpdate = UserOpreport::find($this->userService->id);
            $userUpdate->profile_img = $this->userService->profile_image;
            $userUpdate->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('error en Cumpleaños');
            logger()->error($e);
        }
    }
}
