<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RequisicionCursoUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('requisicion_curso_user')->delete();
        
        \DB::table('requisicion_curso_user')->insert(array (
            0 => 
            array (
                'requisicion_curso_id' => 1,
                'user_id' => 310,
                'rol' => NULL,
            ),
            1 => 
            array (
                'requisicion_curso_id' => 1,
                'user_id' => 40,
                'rol' => NULL,
            ),
            2 => 
            array (
                'requisicion_curso_id' => 1,
                'user_id' => 227,
                'rol' => NULL,
            ),
            3 => 
            array (
                'requisicion_curso_id' => 1,
                'user_id' => 303,
                'rol' => 'solicitante',
            ),
            4 => 
            array (
                'requisicion_curso_id' => 2,
                'user_id' => 293,
                'rol' => NULL,
            ),
            5 => 
            array (
                'requisicion_curso_id' => 2,
                'user_id' => 301,
                'rol' => NULL,
            ),
            6 => 
            array (
                'requisicion_curso_id' => 2,
                'user_id' => 316,
                'rol' => 'solicitante',
            ),
            7 => 
            array (
                'requisicion_curso_id' => 3,
                'user_id' => 293,
                'rol' => NULL,
            ),
            8 => 
            array (
                'requisicion_curso_id' => 3,
                'user_id' => 301,
                'rol' => NULL,
            ),
            9 => 
            array (
                'requisicion_curso_id' => 3,
                'user_id' => 316,
                'rol' => 'solicitante',
            ),
            10 => 
            array (
                'requisicion_curso_id' => 4,
                'user_id' => 293,
                'rol' => NULL,
            ),
            11 => 
            array (
                'requisicion_curso_id' => 4,
                'user_id' => 301,
                'rol' => NULL,
            ),
            12 => 
            array (
                'requisicion_curso_id' => 4,
                'user_id' => 316,
                'rol' => 'solicitante',
            ),
            13 => 
            array (
                'requisicion_curso_id' => 5,
                'user_id' => 293,
                'rol' => NULL,
            ),
            14 => 
            array (
                'requisicion_curso_id' => 5,
                'user_id' => 301,
                'rol' => NULL,
            ),
            15 => 
            array (
                'requisicion_curso_id' => 5,
                'user_id' => 316,
                'rol' => 'solicitante',
            ),
            16 => 
            array (
                'requisicion_curso_id' => 6,
                'user_id' => 293,
                'rol' => NULL,
            ),
            17 => 
            array (
                'requisicion_curso_id' => 6,
                'user_id' => 301,
                'rol' => NULL,
            ),
            18 => 
            array (
                'requisicion_curso_id' => 6,
                'user_id' => 316,
                'rol' => 'solicitante',
            ),
            19 => 
            array (
                'requisicion_curso_id' => 7,
                'user_id' => 293,
                'rol' => NULL,
            ),
            20 => 
            array (
                'requisicion_curso_id' => 7,
                'user_id' => 301,
                'rol' => NULL,
            ),
            21 => 
            array (
                'requisicion_curso_id' => 7,
                'user_id' => 316,
                'rol' => 'solicitante',
            ),
            22 => 
            array (
                'requisicion_curso_id' => 8,
                'user_id' => 302,
                'rol' => NULL,
            ),
            23 => 
            array (
                'requisicion_curso_id' => 8,
                'user_id' => 123,
                'rol' => NULL,
            ),
            24 => 
            array (
                'requisicion_curso_id' => 8,
                'user_id' => 316,
                'rol' => 'solicitante',
            ),
            25 => 
            array (
                'requisicion_curso_id' => 9,
                'user_id' => 227,
                'rol' => 'solicitante',
            ),
            26 => 
            array (
                'requisicion_curso_id' => 10,
                'user_id' => 22,
                'rol' => NULL,
            ),
            27 => 
            array (
                'requisicion_curso_id' => 10,
                'user_id' => 270,
                'rol' => NULL,
            ),
            28 => 
            array (
                'requisicion_curso_id' => 10,
                'user_id' => 92,
                'rol' => NULL,
            ),
            29 => 
            array (
                'requisicion_curso_id' => 10,
                'user_id' => 50,
                'rol' => NULL,
            ),
            30 => 
            array (
                'requisicion_curso_id' => 10,
                'user_id' => 227,
                'rol' => 'solicitante',
            ),
            31 => 
            array (
                'requisicion_curso_id' => 11,
                'user_id' => 92,
                'rol' => NULL,
            ),
            32 => 
            array (
                'requisicion_curso_id' => 11,
                'user_id' => 270,
                'rol' => NULL,
            ),
            33 => 
            array (
                'requisicion_curso_id' => 11,
                'user_id' => 227,
                'rol' => 'solicitante',
            ),
        ));
        
        
    }
}