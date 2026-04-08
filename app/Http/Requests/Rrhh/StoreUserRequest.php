<?php

namespace App\Http\Requests\Rrhh;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'nombre'=> 'required',
            'apellidos'=> 'required',
            'admision'=> 'required',
            'puesto'=> 'required',
            'razonSocial'=> 'required',
            'jefe'=> 'required',
            'activo'=> 'required',
        ];
    }
}
