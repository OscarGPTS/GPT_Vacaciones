<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'super-admin',
                'guard_name' => 'web',
                'created_at' => '2022-09-19 15:22:05',
                'updated_at' => '2022-09-19 15:22:05',
            ),
        ));
        
        
    }
}