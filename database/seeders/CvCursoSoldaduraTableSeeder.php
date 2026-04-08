<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CvCursoSoldaduraTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cv_curso_soldadura')->delete();
        
        \DB::table('cv_curso_soldadura')->insert(array (
            0 => 
            array (
                'id' => 1,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (AWS D1.1)',
                'proceso' => 'SMAW',
                'wps' => 'TECH-WPS-09',
                'desde' => '2016',
                'hasta' => 'Vigente',
                'user_id' => 14,
                'created_at' => '2023-09-25 21:57:17',
                'updated_at' => '2023-09-25 22:07:47',
            ),
            1 => 
            array (
                'id' => 2,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (ASME IX)',
                'proceso' => 'SMAW',
                'wps' => 'WPS-GPT-005',
                'desde' => '2016',
                'hasta' => 'Vigente',
                'user_id' => 14,
                'created_at' => '2023-09-26 01:28:59',
                'updated_at' => '2023-09-26 01:28:59',
            ),
            2 => 
            array (
                'id' => 3,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (API 1104)',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-GW-01 / WPS-TECH-GW-02',
                'desde' => '2018',
                'hasta' => 'Vigente',
                'user_id' => 14,
                'created_at' => '2023-09-26 01:29:53',
                'updated_at' => '2023-09-26 01:29:53',
            ),
            3 => 
            array (
                'id' => 4,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-SL-01/20',
                'desde' => '2020',
                'hasta' => 'Vigente',
                'user_id' => 14,
                'created_at' => '2023-09-26 01:30:34',
                'updated_at' => '2023-09-26 01:30:34',
            ),
            4 => 
            array (
                'id' => 5,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-SL-01/20 Rev.03',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 14,
                'created_at' => '2023-09-26 01:31:18',
                'updated_at' => '2025-08-29 02:55:15',
            ),
            5 => 
            array (
                'id' => 7,
                'nombre' => 'SOLDADURA DE REPARACIÓN',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-R-BW',
                'desde' => '2021',
                'hasta' => '2022',
                'user_id' => 14,
                'created_at' => '2023-09-26 01:52:22',
                'updated_at' => '2023-09-26 01:52:22',
            ),
            6 => 
            array (
                'id' => 8,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (AWS D1.1)',
                'proceso' => 'SMAW',
                'wps' => 'TECH-WPS-09',
                'desde' => '2016',
                'hasta' => 'Vigente',
                'user_id' => 26,
                'created_at' => '2023-09-26 01:54:28',
                'updated_at' => '2023-09-26 01:54:28',
            ),
            7 => 
            array (
                'id' => 9,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (ASME IX)',
                'proceso' => 'SMAW',
                'wps' => 'WPS-GPT-005',
                'desde' => '2016',
                'hasta' => 'Vigente',
                'user_id' => 26,
                'created_at' => '2023-09-26 01:55:04',
                'updated_at' => '2023-09-26 01:55:04',
            ),
            8 => 
            array (
                'id' => 10,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (API 1104)',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-GW-01 / WPS-TECH-GW-02',
                'desde' => '2018',
                'hasta' => 'Vigente',
                'user_id' => 26,
                'created_at' => '2023-09-26 01:56:02',
                'updated_at' => '2023-09-26 01:56:02',
            ),
            9 => 
            array (
                'id' => 11,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-SL-01/20',
                'desde' => '2020',
                'hasta' => 'Vigente',
                'user_id' => 26,
                'created_at' => '2023-09-26 01:56:38',
                'updated_at' => '2023-09-26 01:56:38',
            ),
            10 => 
            array (
                'id' => 12,
            'nombre' => 'SOLDADURA IN SERVICE (BRANCH) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'GPT-WPS-009',
                'desde' => '2017',
                'hasta' => '2018',
                'user_id' => 26,
                'created_at' => '2023-09-26 01:57:19',
                'updated_at' => '2025-09-25 06:59:32',
            ),
            11 => 
            array (
                'id' => 13,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'GTAW',
                'wps' => 'WPS-TECH-SL-INOX-01',
                'desde' => '2023',
                'hasta' => '2024',
                'user_id' => 26,
                'created_at' => '2023-09-26 01:57:56',
                'updated_at' => '2025-08-29 02:49:55',
            ),
            12 => 
            array (
                'id' => 14,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (AWS D1.1)',
                'proceso' => 'SMAW',
                'wps' => 'TECH-WPS-09',
                'desde' => '2019',
                'hasta' => 'Vigente',
                'user_id' => 89,
                'created_at' => '2023-09-26 02:01:30',
                'updated_at' => '2023-09-26 02:01:30',
            ),
            13 => 
            array (
                'id' => 15,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (ASME IX)',
                'proceso' => 'SMAW',
                'wps' => 'WPS-GPT-005',
                'desde' => '2019',
                'hasta' => 'Vigente',
                'user_id' => 89,
                'created_at' => '2023-09-26 02:02:11',
                'updated_at' => '2023-09-26 02:02:11',
            ),
            14 => 
            array (
                'id' => 16,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (API 1104)',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-GW-01 / WPS-TECH-GW-02',
                'desde' => '2020',
                'hasta' => 'Vigente',
                'user_id' => 89,
                'created_at' => '2023-09-26 02:03:00',
                'updated_at' => '2023-09-26 02:03:00',
            ),
            15 => 
            array (
                'id' => 17,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-SL-01/20',
                'desde' => '2020',
                'hasta' => 'Vigente',
                'user_id' => 89,
                'created_at' => '2023-09-26 02:03:27',
                'updated_at' => '2023-09-26 02:03:27',
            ),
            16 => 
            array (
                'id' => 18,
            'nombre' => 'SOLDADURA IN SERVICE (BRANCH) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'GPT-WPS-009',
                'desde' => '2020',
                'hasta' => '2022',
                'user_id' => 89,
                'created_at' => '2023-09-26 02:04:01',
                'updated_at' => '2025-09-25 07:02:18',
            ),
            17 => 
            array (
                'id' => 19,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (AWS D1.1)',
                'proceso' => 'SMAW',
                'wps' => 'TECH-WPS-09',
                'desde' => '2019',
                'hasta' => 'Vigente',
                'user_id' => 99,
                'created_at' => '2023-09-26 02:07:24',
                'updated_at' => '2023-09-26 02:07:24',
            ),
            18 => 
            array (
                'id' => 20,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (ASME IX)',
                'proceso' => 'SMAW',
                'wps' => 'WPS-GPT-005',
                'desde' => '2019',
                'hasta' => 'Vigente',
                'user_id' => 99,
                'created_at' => '2023-09-26 02:08:04',
                'updated_at' => '2023-09-26 02:08:04',
            ),
            19 => 
            array (
                'id' => 21,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (API 1104)',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-GW-01 / WPS-TECH-GW-02',
                'desde' => '2019',
                'hasta' => 'Vigente',
                'user_id' => 99,
                'created_at' => '2023-09-26 02:08:55',
                'updated_at' => '2023-09-26 02:08:55',
            ),
            20 => 
            array (
                'id' => 22,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-SL-01/20',
                'desde' => '2020',
                'hasta' => 'Vigente',
                'user_id' => 99,
                'created_at' => '2023-09-26 02:09:28',
                'updated_at' => '2023-09-26 02:09:28',
            ),
            21 => 
            array (
                'id' => 23,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (AWS D1.1)',
                'proceso' => 'SMAW',
                'wps' => 'TECH-WPS-09',
                'desde' => '2023',
                'hasta' => 'Vigente',
                'user_id' => 131,
                'created_at' => '2023-09-26 02:10:53',
                'updated_at' => '2023-09-26 02:10:53',
            ),
            22 => 
            array (
                'id' => 24,
            'nombre' => 'SOLDADURA RAÍZ ABIERTA (ASME IX)',
                'proceso' => 'SMAW',
                'wps' => 'WPS-GPT-005',
                'desde' => '2023',
                'hasta' => 'Vigente',
                'user_id' => 131,
                'created_at' => '2023-09-26 02:11:25',
                'updated_at' => '2023-09-26 02:11:25',
            ),
            23 => 
            array (
                'id' => 25,
            'nombre' => 'SOLDADURA MÚLTIPLE (BUTTJOINT) API 5L X52',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-GW-01 Rev. 02',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 299,
                'created_at' => '2025-07-10 01:52:38',
                'updated_at' => '2025-07-10 02:15:28',
            ),
            24 => 
            array (
                'id' => 26,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-SL-01/20 Rev. 02',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 299,
                'created_at' => '2025-07-10 02:11:26',
                'updated_at' => '2025-07-10 02:15:21',
            ),
            25 => 
            array (
                'id' => 27,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-SL-01/20 Rev. 03',
                'desde' => '2005',
                'hasta' => 'Vigente',
                'user_id' => 318,
                'created_at' => '2025-07-10 02:15:05',
                'updated_at' => '2025-07-10 02:15:05',
            ),
            26 => 
            array (
                'id' => 28,
            'nombre' => 'SOLDADURA MÚLTIPLE (BUTTJOINT) API 5L X52',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-GW-01 Rev.02',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 318,
                'created_at' => '2025-07-10 02:16:15',
                'updated_at' => '2025-07-10 02:16:15',
            ),
            27 => 
            array (
                'id' => 29,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-SL-01/20 Rev. 03',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 89,
                'created_at' => '2025-08-29 02:36:39',
                'updated_at' => '2025-08-29 02:36:39',
            ),
            28 => 
            array (
                'id' => 30,
            'nombre' => 'SOLDADURA MÚLTIPLE (BUTTJOINT) API 5L X52',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-GW-01-REV.01 /WPS-TECH-GW-02-REV.02',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 26,
                'created_at' => '2025-08-29 02:49:06',
                'updated_at' => '2025-08-29 02:49:06',
            ),
            29 => 
            array (
                'id' => 31,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-SL-01/20 REV.03',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 26,
                'created_at' => '2025-08-29 02:50:53',
                'updated_at' => '2025-08-29 02:50:53',
            ),
            30 => 
            array (
                'id' => 32,
            'nombre' => 'SOLDADURA IN SERVICE (SLEEVE) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS-TECH-SL-01/20 Rev.03',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 99,
                'created_at' => '2025-08-29 03:10:49',
                'updated_at' => '2025-08-29 03:10:49',
            ),
            31 => 
            array (
                'id' => 33,
            'nombre' => 'SOLDADURA IN SERVICE (BRANCH) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS/TECH/BRANCH-02 Rev.0',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 14,
                'created_at' => '2025-09-25 06:57:55',
                'updated_at' => '2025-09-25 06:57:55',
            ),
            32 => 
            array (
                'id' => 34,
            'nombre' => 'SOLDADURA IN SERVICE (BRANCH) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS/TECH/BRANCH-02 Rev.0',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 26,
                'created_at' => '2025-09-25 07:00:58',
                'updated_at' => '2025-09-25 07:00:58',
            ),
            33 => 
            array (
                'id' => 35,
            'nombre' => 'SOLDADURA IN SERVICE (BRANCH) API 1104, APEND-B',
                'proceso' => 'SMAW',
                'wps' => 'WPS/TECH/BRANCH-02 Rev.0',
                'desde' => '2025',
                'hasta' => 'Vigente',
                'user_id' => 89,
                'created_at' => '2025-09-25 07:02:53',
                'updated_at' => '2025-09-25 07:02:53',
            ),
        ));
        
        
    }
}