<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'migration' => '2019_12_14_000001_create_personal_access_tokens_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'migration' => '2022_02_11_092725_create_business_names_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'migration' => '2022_02_11_092728_create_areas_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'migration' => '2022_02_11_092729_create_departamentos_table',
                'batch' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'migration' => '2022_02_11_092730_create_jobs_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'migration' => '2022_02_11_092732_create_users_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'migration' => '2022_02_11_092734_create_failed_jobs_table',
                'batch' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'migration' => '2022_02_11_092743_create_password_resets_table',
                'batch' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'migration' => '2022_02_11_092753_create_technical_skills_table',
                'batch' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'migration' => '2022_02_12_123326_create_users_personal_data_table',
                'batch' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'migration' => '2022_02_17_141923_create_permission_tables',
                'batch' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'migration' => '2022_04_01_092936_create_requisiciones_personal_table',
                'batch' => 1,
            ),
            12 => 
            array (
                'id' => 13,
                'migration' => '2023_07_14_091145_create_audits_table',
                'batch' => 1,
            ),
            13 => 
            array (
                'id' => 14,
                'migration' => '2023_07_17_104513_create_pending_transitions_table',
                'batch' => 1,
            ),
            14 => 
            array (
                'id' => 15,
                'migration' => '2023_07_17_104513_create_state_histories_table',
                'batch' => 1,
            ),
            15 => 
            array (
                'id' => 16,
                'migration' => '2023_07_19_142943_create_media_table',
                'batch' => 1,
            ),
            16 => 
            array (
                'id' => 17,
                'migration' => '2023_08_10_103039_create_cv_experiencias_table',
                'batch' => 1,
            ),
            17 => 
            array (
                'id' => 18,
                'migration' => '2023_08_10_103310_create_cv_curso_certificacions_table',
                'batch' => 1,
            ),
            18 => 
            array (
                'id' => 19,
                'migration' => '2023_08_10_103328_create_cv_historial_servicios_table',
                'batch' => 1,
            ),
            19 => 
            array (
                'id' => 25,
                'migration' => '2025_10_13_095851_create_vacaciones_table',
                'batch' => 2,
            ),
        ));
        
        
    }
}