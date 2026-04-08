<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'ver modulo rrhh',
                'guard_name' => 'web',
                'created_at' => '2022-02-16 19:27:37',
                'updated_at' => '2022-02-16 19:27:37',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'requisicion personal revisar',
                'guard_name' => 'web',
                'created_at' => '2022-09-19 15:01:12',
                'updated_at' => '2022-09-19 15:01:12',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'requisicion personal autorizar',
                'guard_name' => 'web',
                'created_at' => '2022-09-19 15:01:16',
                'updated_at' => '2022-09-19 15:01:16',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'solicitar requisicion personal',
                'guard_name' => 'web',
                'created_at' => '2022-09-19 15:01:16',
                'updated_at' => '2022-09-19 15:01:16',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'editar otros cvs',
                'guard_name' => 'web',
                'created_at' => '2023-08-13 04:45:54',
                'updated_at' => '2023-08-13 04:45:54',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'requisicion curso autorizar',
                'guard_name' => 'web',
                'created_at' => '2024-04-06 14:31:55',
                'updated_at' => '2024-04-06 14:31:55',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'sidebar colaborador',
                'guard_name' => 'web',
                'created_at' => '2024-06-07 03:01:55',
                'updated_at' => '2024-06-07 03:01:55',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'list colaborador',
                'guard_name' => 'web',
                'created_at' => '2024-06-07 03:01:55',
                'updated_at' => '2024-06-07 03:01:55',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'show colaborador',
                'guard_name' => 'web',
                'created_at' => '2024-06-07 03:01:55',
                'updated_at' => '2024-06-07 03:01:55',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'show check documentos',
                'guard_name' => 'web',
                'created_at' => '2024-06-07 03:01:55',
                'updated_at' => '2024-06-07 03:01:55',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'create colaborador',
                'guard_name' => 'web',
                'created_at' => '2024-06-07 03:25:52',
                'updated_at' => '2024-06-07 03:25:52',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'edit colaborador',
                'guard_name' => 'web',
                'created_at' => '2024-06-07 03:25:52',
                'updated_at' => '2024-06-07 03:25:52',
            ),
        ));
        
        
    }
}