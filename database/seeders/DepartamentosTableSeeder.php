<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartamentosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('departamentos')->delete();
        
        \DB::table('departamentos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Almacén',
                'area_id' => 1,
                'created_at' => '2023-07-02 16:56:13',
                'updated_at' => '2023-07-02 16:56:13',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Logística',
                'area_id' => 1,
                'created_at' => '2023-07-02 16:56:13',
                'updated_at' => '2023-07-02 16:56:13',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Servicios Generales',
                'area_id' => 1,
                'created_at' => '2023-07-02 16:56:13',
                'updated_at' => '2023-07-02 16:56:13',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'IT',
                'area_id' => 1,
                'created_at' => '2023-07-02 16:56:13',
                'updated_at' => '2023-07-02 16:56:13',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Soldadura',
                'area_id' => 2,
                'created_at' => '2023-07-02 16:56:13',
                'updated_at' => '2023-07-02 16:56:13',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'HT & LS',
                'area_id' => 2,
                'created_at' => '2023-07-02 16:56:13',
                'updated_at' => '2023-07-02 16:56:13',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Manufactura y Mantenimiento',
                'area_id' => 3,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Manufactura',
                'area_id' => 3,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Ingeniería',
                'area_id' => 3,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Mantenimiento Especializado',
                'area_id' => 2,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2025-07-16 07:24:24',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Proyectos',
                'area_id' => 12,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2024-12-31 06:02:31',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Administración',
                'area_id' => 5,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Compras',
                'area_id' => 5,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2024-07-23 02:45:42',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Recursos Humanos',
                'area_id' => 5,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2024-07-23 02:45:32',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Finanzas ',
                'area_id' => 5,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Comercial',
                'area_id' => 12,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2025-07-16 06:47:11',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'QHSE',
                'area_id' => 7,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Dirección General',
                'area_id' => 8,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Marketing ',
                'area_id' => 8,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Servicios Generales',
                'area_id' => 9,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Mantenimiento ',
                'area_id' => 9,
                'created_at' => '2023-07-02 16:56:14',
                'updated_at' => '2023-07-02 16:56:14',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Seguridad Patrimonial',
                'area_id' => 1,
                'created_at' => '2023-09-12 23:36:01',
                'updated_at' => '2023-09-12 23:36:01',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Calidad',
                'area_id' => 7,
                'created_at' => '2024-01-21 20:40:45',
                'updated_at' => '2025-01-02 05:35:11',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Legal ',
                'area_id' => 8,
                'created_at' => '2024-05-24 00:23:41',
                'updated_at' => '2024-05-24 00:23:41',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Contratos',
                'area_id' => 12,
                'created_at' => '2024-07-03 03:50:43',
                'updated_at' => '2025-07-16 06:57:55',
            ),
        ));
        
        
    }
}