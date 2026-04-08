<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PositionHierarchyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('position_hierarchy')->delete();
        
        \DB::table('position_hierarchy')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Operativo de Soporte ',
                'expected_value' => 21,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Operativo Especializado ',
                'expected_value' => 22,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Coordinación',
                'expected_value' => 29,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Jefatura',
                'expected_value' => 30,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Gerencial ',
                'expected_value' => 40,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Dirección ',
                'expected_value' => 40,
            ),
        ));
        
        
    }
}