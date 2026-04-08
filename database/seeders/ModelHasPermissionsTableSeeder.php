<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModelHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('model_has_permissions')->delete();
        
        \DB::table('model_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 218,
            ),
            1 => 
            array (
                'permission_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 255,
            ),
            2 => 
            array (
                'permission_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 333,
            ),
            3 => 
            array (
                'permission_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            4 => 
            array (
                'permission_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 331,
            ),
            5 => 
            array (
                'permission_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            6 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            7 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            8 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            9 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            10 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            11 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            12 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 158,
            ),
            13 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 180,
            ),
            14 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 211,
            ),
            15 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 250,
            ),
            16 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 280,
            ),
            17 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 326,
            ),
            18 => 
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 331,
            ),
            19 => 
            array (
                'permission_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 132,
            ),
            20 => 
            array (
                'permission_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            21 => 
            array (
                'permission_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 301,
            ),
            22 => 
            array (
                'permission_id' => 8,
                'model_type' => 'App\\Models\\User',
                'model_id' => 301,
            ),
            23 => 
            array (
                'permission_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 301,
            ),
            24 => 
            array (
                'permission_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 301,
            ),
        ));
        
        
    }
}