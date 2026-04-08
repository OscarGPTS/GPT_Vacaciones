<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CvCertificacionesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cv_certificaciones')->delete();
        
        \DB::table('cv_certificaciones')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => '9a018526-70c4-49a6-9ea2-6e9045fe90ba',
                'alcance' => 'en alcance de perforaciones de ½” hasta 24” – Obturaciones de 2” hasta 20”.',
                'user_id' => 92,
                'created_at' => '2023-10-26 23:11:51',
                'updated_at' => '2023-10-26 23:11:51',
            ),
            1 => 
            array (
                'id' => 3,
                'uuid' => 'c0c03bd3-07f1-49c0-b028-1af10ed2b1e3',
                'alcance' => 'en alcance de perforaciones de ½” hasta 24” – Obturaciones de 2” hasta 20”.',
                'user_id' => 270,
                'created_at' => '2023-10-31 02:29:05',
                'updated_at' => '2023-10-31 02:29:05',
            ),
            2 => 
            array (
                'id' => 4,
                'uuid' => 'd91a4e11-6451-4dff-a0aa-eb21045ead08',
            'alcance' => 'en alcance de perforaciones de ½” hasta 12” - (No se permite la ejecución de obturaciones).',
                'user_id' => 50,
                'created_at' => '2023-10-31 02:30:18',
                'updated_at' => '2023-10-31 02:30:18',
            ),
            3 => 
            array (
                'id' => 6,
                'uuid' => '9c829820-a28e-425b-8fa0-fba3b7e23981',
                'alcance' => 'en alcance de perforaciones de ½” hasta 48”  –Obturaciones de 2” hasta 48".',
                'user_id' => 22,
                'created_at' => '2023-11-02 22:07:09',
                'updated_at' => '2023-11-02 22:07:09',
            ),
            4 => 
            array (
                'id' => 8,
                'uuid' => '40f8502c-1b9a-401c-9072-cbcdc67d34c7',
                'alcance' => NULL,
                'user_id' => 212,
                'created_at' => '2024-08-28 07:44:25',
                'updated_at' => '2024-08-28 07:44:25',
            ),
            5 => 
            array (
                'id' => 9,
                'uuid' => 'b6b7f0d5-d38b-4363-8898-feb98c0b61e3',
                'alcance' => NULL,
                'user_id' => 26,
                'created_at' => '2024-10-31 02:53:53',
                'updated_at' => '2024-10-31 02:53:53',
            ),
            6 => 
            array (
                'id' => 10,
                'uuid' => '69c4fae1-1c7e-48e0-a659-f4ab58c01449',
                'alcance' => NULL,
                'user_id' => 131,
                'created_at' => '2024-10-31 02:55:15',
                'updated_at' => '2024-10-31 02:55:15',
            ),
            7 => 
            array (
                'id' => 11,
                'uuid' => 'f2c534ea-40ed-4ffa-aaa0-1db98b35c3ae',
                'alcance' => NULL,
                'user_id' => 263,
                'created_at' => '2024-11-15 07:21:04',
                'updated_at' => '2024-11-15 07:21:04',
            ),
            8 => 
            array (
                'id' => 12,
                'uuid' => '4abac093-85fd-489f-a468-ca5d174aa29c',
                'alcance' => NULL,
                'user_id' => 304,
                'created_at' => '2024-12-04 08:33:19',
                'updated_at' => '2024-12-04 08:33:19',
            ),
            9 => 
            array (
                'id' => 13,
                'uuid' => '7cf24cfb-2d84-4da4-8138-635742b925f3',
                'alcance' => NULL,
                'user_id' => 14,
                'created_at' => '2025-04-01 10:51:21',
                'updated_at' => '2025-04-01 10:51:21',
            ),
            10 => 
            array (
                'id' => 14,
                'uuid' => 'bfac557d-d414-4d60-ad4d-cc67a78599d0',
                'alcance' => NULL,
                'user_id' => 205,
                'created_at' => '2025-09-25 06:08:52',
                'updated_at' => '2025-09-25 06:08:52',
            ),
            11 => 
            array (
                'id' => 15,
                'uuid' => '5ceb5176-18f4-43be-b5d7-9944d013946c',
                'alcance' => NULL,
                'user_id' => 157,
                'created_at' => '2025-09-25 06:10:58',
                'updated_at' => '2025-09-25 06:10:58',
            ),
        ));
        
        
    }
}