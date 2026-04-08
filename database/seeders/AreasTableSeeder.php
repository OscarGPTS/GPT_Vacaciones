<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('areas')->delete();
        
        \DB::table('areas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Servicios Generales y Almacén',
                'created_at' => '2023-07-02 16:56:13',
                'updated_at' => '2023-07-02 16:56:13',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Operaciones',
                'created_at' => '2023-07-02 16:56:13',
                'updated_at' => '2023-07-02 16:56:13',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Ingeniería y Manufactura',
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2024-08-05 02:29:24',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Proyectos',
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Administración y Finanzas',
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Comercial',
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'QHSE',
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Dirección General',
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Mantenimiento',
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2025-07-16 07:23:13',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Calidad',
                'created_at' => '2024-01-21 20:40:27',
                'updated_at' => '2024-01-21 20:40:27',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Compras',
                'created_at' => '2024-07-03 03:15:37',
                'updated_at' => '2024-07-03 03:15:37',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Contratos',
                'created_at' => '2024-07-03 03:50:09',
                'updated_at' => '2024-07-03 03:50:09',
            ),
        ));
        
        
    }
}