<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PuestoConocimientosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('puesto_conocimientos')->delete();
        
        \DB::table('puesto_conocimientos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'descripcion' => 'Fundamentos de Hot Tapping.',
                'job_id' => 65,
                'created_at' => '2023-08-17 20:31:15',
                'updated_at' => '2024-11-25 02:40:11',
            ),
            1 => 
            array (
                'id' => 2,
                'descripcion' => 'Sistemas de tuberías.',
                'job_id' => 65,
                'created_at' => '2023-08-17 20:31:15',
                'updated_at' => '2024-11-25 02:40:11',
            ),
            2 => 
            array (
                'id' => 3,
                'descripcion' => 'Equipos de hot tapping.',
                'job_id' => 65,
                'created_at' => '2023-08-17 20:31:15',
                'updated_at' => '2024-11-25 02:40:11',
            ),
            3 => 
            array (
                'id' => 4,
            'descripcion' => 'Normas y regulaciones (API 2201, 1104, ASME B31.3).',
                'job_id' => 65,
                'created_at' => '2023-08-17 20:31:15',
                'updated_at' => '2024-11-25 02:40:11',
            ),
            4 => 
            array (
                'id' => 5,
                'descripcion' => 'Seguridad industrial.',
                'job_id' => 65,
                'created_at' => '2023-08-17 20:31:15',
                'updated_at' => '2024-11-25 02:40:11',
            ),
            5 => 
            array (
                'id' => 6,
            'descripcion' => 'Conocimientos Adicionales (Fluidos de tubería, cálculos técnico, prueba de fugas).',
                'job_id' => 65,
                'created_at' => '2023-08-17 20:31:15',
                'updated_at' => '2024-11-25 02:40:11',
            ),
            6 => 
            array (
                'id' => 7,
            'descripcion' => ' Habilidades prácticas (Medición y calibración, Inspección visual, Manejo de herramientas).',
                'job_id' => 65,
                'created_at' => '2023-08-17 20:31:15',
                'updated_at' => '2024-11-25 02:40:11',
            ),
            7 => 
            array (
                'id' => 8,
                'descripcion' => 'Sin llenar.',
                'job_id' => 65,
                'created_at' => '2023-08-17 20:31:15',
                'updated_at' => '2024-11-22 06:35:56',
            ),
            8 => 
            array (
                'id' => 9,
                'descripcion' => 'Legislación fiscal.',
                'job_id' => 47,
                'created_at' => '2023-08-28 22:34:42',
                'updated_at' => '2024-11-20 06:17:31',
            ),
            9 => 
            array (
                'id' => 10,
                'descripcion' => 'Estados y razones financieras.',
                'job_id' => 47,
                'created_at' => '2023-08-28 22:34:43',
                'updated_at' => '2024-11-20 06:17:31',
            ),
            10 => 
            array (
                'id' => 11,
                'descripcion' => 'NIF.',
                'job_id' => 47,
                'created_at' => '2023-08-28 22:34:43',
                'updated_at' => '2024-11-20 06:17:31',
            ),
            11 => 
            array (
                'id' => 12,
            'descripcion' => 'ERP (SAE).',
                'job_id' => 47,
                'created_at' => '2023-08-28 22:34:43',
                'updated_at' => '2024-11-20 06:17:31',
            ),
            12 => 
            array (
                'id' => 13,
                'descripcion' => 'Contabilidad general.',
                'job_id' => 47,
                'created_at' => '2023-08-28 22:34:43',
                'updated_at' => '2024-11-20 06:17:31',
            ),
            13 => 
            array (
                'id' => 14,
                'descripcion' => 'Excel avanzado.',
                'job_id' => 47,
                'created_at' => '2023-08-28 22:34:43',
                'updated_at' => '2024-11-20 06:17:31',
            ),
            14 => 
            array (
                'id' => 15,
                'descripcion' => 'Sin llenar',
                'job_id' => 47,
                'created_at' => '2023-08-28 22:34:43',
                'updated_at' => '2023-08-28 22:34:43',
            ),
            15 => 
            array (
                'id' => 16,
                'descripcion' => 'Sin llenar',
                'job_id' => 47,
                'created_at' => '2023-08-28 22:34:43',
                'updated_at' => '2023-08-28 22:34:43',
            ),
            16 => 
            array (
                'id' => 17,
                'descripcion' => 'Manejo de incidentes.',
                'job_id' => 69,
                'created_at' => '2023-09-12 23:37:02',
                'updated_at' => '2024-11-21 03:29:13',
            ),
            17 => 
            array (
                'id' => 18,
                'descripcion' => 'Identificación, técnicas de descripción de personas y elementos.',
                'job_id' => 69,
                'created_at' => '2023-09-12 23:37:02',
                'updated_at' => '2024-11-21 03:29:13',
            ),
            18 => 
            array (
                'id' => 19,
                'descripcion' => 'Control de accesos.',
                'job_id' => 69,
                'created_at' => '2023-09-12 23:37:02',
                'updated_at' => '2024-11-21 03:29:13',
            ),
            19 => 
            array (
                'id' => 20,
                'descripcion' => 'Autocontrol, pánico y sus efectos. Miedo y estrés.',
                'job_id' => 69,
                'created_at' => '2023-09-12 23:37:02',
                'updated_at' => '2023-10-23 21:43:59',
            ),
            20 => 
            array (
                'id' => 21,
                'descripcion' => 'Respuestas a incidentes y emergencias.',
                'job_id' => 69,
                'created_at' => '2023-09-12 23:37:02',
                'updated_at' => '2024-11-22 06:19:32',
            ),
            21 => 
            array (
                'id' => 22,
            'descripcion' => 'Sistemas de seguridad, (cámaras de seguridad, sistemas de alarmas y equipos de comunicación de emergencia.).',
                'job_id' => 69,
                'created_at' => '2023-09-12 23:37:02',
                'updated_at' => '2024-11-22 06:19:32',
            ),
            22 => 
            array (
                'id' => 23,
                'descripcion' => 'Elaboración de informes de incidentes.',
                'job_id' => 69,
                'created_at' => '2023-09-12 23:37:02',
                'updated_at' => '2024-11-22 06:19:32',
            ),
            23 => 
            array (
                'id' => 24,
                'descripcion' => 'Sin llenar',
                'job_id' => 69,
                'created_at' => '2023-09-12 23:37:02',
                'updated_at' => '2024-11-21 03:29:13',
            ),
            24 => 
            array (
                'id' => 25,
                'descripcion' => 'Sistema PEPS',
                'job_id' => 5,
                'created_at' => '2023-09-18 22:53:35',
                'updated_at' => '2024-11-13 06:54:02',
            ),
            25 => 
            array (
                'id' => 26,
                'descripcion' => 'Conocimiento básico de Excel',
                'job_id' => 5,
                'created_at' => '2023-09-18 22:53:35',
                'updated_at' => '2024-11-13 06:54:02',
            ),
            26 => 
            array (
                'id' => 27,
                'descripcion' => 'Conocimiento en almacenamiento de materiales',
                'job_id' => 5,
                'created_at' => '2023-09-18 22:53:35',
                'updated_at' => '2024-11-13 06:54:02',
            ),
            27 => 
            array (
                'id' => 28,
                'descripcion' => 'Manejo de montacargas',
                'job_id' => 5,
                'created_at' => '2023-09-18 22:53:35',
                'updated_at' => '2024-11-13 06:54:02',
            ),
            28 => 
            array (
                'id' => 29,
                'descripcion' => 'Uso de herramientas mecánicas',
                'job_id' => 5,
                'created_at' => '2023-09-18 22:53:35',
                'updated_at' => '2024-11-13 06:54:02',
            ),
            29 => 
            array (
                'id' => 30,
                'descripcion' => 'Uso de herramientas de medición',
                'job_id' => 5,
                'created_at' => '2023-09-18 22:53:35',
                'updated_at' => '2024-11-13 06:54:02',
            ),
            30 => 
            array (
                'id' => 31,
                'descripcion' => 'Conocimientos para elaboración de reportes',
                'job_id' => 5,
                'created_at' => '2023-09-18 22:53:35',
                'updated_at' => '2024-11-13 06:54:02',
            ),
            31 => 
            array (
                'id' => 32,
                'descripcion' => 'Sin llenar',
                'job_id' => 5,
                'created_at' => '2023-09-18 22:53:35',
                'updated_at' => '2023-09-18 22:53:35',
            ),
            32 => 
            array (
                'id' => 33,
                'descripcion' => 'Fundamentos de Hot Tapping.',
                'job_id' => 19,
                'created_at' => '2023-10-02 19:23:22',
                'updated_at' => '2024-11-25 02:41:40',
            ),
            33 => 
            array (
                'id' => 34,
                'descripcion' => 'Sistemas de tuberías.',
                'job_id' => 19,
                'created_at' => '2023-10-02 19:23:22',
                'updated_at' => '2024-11-25 02:41:40',
            ),
            34 => 
            array (
                'id' => 35,
                'descripcion' => 'Herramientas y Equipos.',
                'job_id' => 19,
                'created_at' => '2023-10-02 19:23:22',
                'updated_at' => '2024-11-25 02:41:40',
            ),
            35 => 
            array (
                'id' => 36,
            'descripcion' => 'Normas y Regulaciones (API 2201: P)',
                'job_id' => 19,
                'created_at' => '2023-10-02 19:23:22',
                'updated_at' => '2024-11-25 02:41:40',
            ),
            36 => 
            array (
                'id' => 37,
                'descripcion' => 'Seguridad Industrial.',
                'job_id' => 19,
                'created_at' => '2023-10-02 19:23:22',
                'updated_at' => '2024-11-25 02:41:40',
            ),
            37 => 
            array (
                'id' => 38,
            'descripcion' => 'Conocimientos Adicionales (Fluidos en las tuberías, Matemáticas básicas y cálculo técnico, Pruebas de fugas).',
                'job_id' => 19,
                'created_at' => '2023-10-02 19:23:22',
                'updated_at' => '2024-11-25 02:41:40',
            ),
            38 => 
            array (
                'id' => 39,
                'descripcion' => 'Sin llenar.',
                'job_id' => 19,
                'created_at' => '2023-10-02 19:23:22',
                'updated_at' => '2024-11-25 02:41:40',
            ),
            39 => 
            array (
                'id' => 40,
                'descripcion' => 'Sin llenar',
                'job_id' => 19,
                'created_at' => '2023-10-02 19:23:22',
                'updated_at' => '2023-10-02 19:23:22',
            ),
            40 => 
            array (
                'id' => 41,
            'descripcion' => 'Inglés (capaz de entablar una conversación de negocios)',
                'job_id' => 70,
                'created_at' => '2023-10-10 17:49:38',
                'updated_at' => '2023-10-23 20:54:11',
            ),
            41 => 
            array (
                'id' => 42,
            'descripcion' => 'Conocimiento de los procesos involucrados e infraestructura requerida en el  sector energético, petróleo, gas y petroquímica (upstream, medstream y downstream)',
                'job_id' => 70,
                'created_at' => '2023-10-10 17:49:38',
                'updated_at' => '2023-10-23 20:54:11',
            ),
            42 => 
            array (
                'id' => 43,
                'descripcion' => 'Conocimiento en válvulas',
                'job_id' => 70,
                'created_at' => '2023-10-10 17:49:38',
                'updated_at' => '2023-10-23 20:54:11',
            ),
            43 => 
            array (
                'id' => 44,
                'descripcion' => 'Servicios de Hot Tapping & Line Stopping.',
                'job_id' => 70,
                'created_at' => '2023-10-10 17:49:38',
                'updated_at' => '2023-10-23 20:54:11',
            ),
            44 => 
            array (
                'id' => 45,
                'descripcion' => 'Integridad de ductos',
                'job_id' => 70,
                'created_at' => '2023-10-10 17:49:38',
                'updated_at' => '2023-10-23 20:54:11',
            ),
            45 => 
            array (
                'id' => 46,
                'descripcion' => 'Soldadura',
                'job_id' => 70,
                'created_at' => '2023-10-10 17:49:38',
                'updated_at' => '2023-10-23 20:54:11',
            ),
            46 => 
            array (
                'id' => 47,
                'descripcion' => 'Desarrollo de negocios ',
                'job_id' => 70,
                'created_at' => '2023-10-10 17:49:38',
                'updated_at' => '2023-10-23 20:54:11',
            ),
            47 => 
            array (
                'id' => 48,
                'descripcion' => 'Normatividad ASEA, ASME, API y otras aplicables',
                'job_id' => 70,
                'created_at' => '2023-10-10 17:49:38',
                'updated_at' => '2023-10-23 20:54:11',
            ),
            48 => 
            array (
                'id' => 49,
                'descripcion' => 'Manejo de montacargas.',
                'job_id' => 13,
                'created_at' => '2023-10-23 01:33:44',
                'updated_at' => '2024-11-22 03:38:10',
            ),
            49 => 
            array (
                'id' => 50,
                'descripcion' => 'Uso y manejo de izajes.',
                'job_id' => 13,
                'created_at' => '2023-10-23 01:33:44',
                'updated_at' => '2024-11-22 03:38:10',
            ),
            50 => 
            array (
                'id' => 51,
                'descripcion' => 'Experiencia laboral como maniobrista en almacenes.',
                'job_id' => 13,
                'created_at' => '2023-10-23 01:33:44',
                'updated_at' => '2024-11-22 03:38:10',
            ),
            51 => 
            array (
                'id' => 52,
                'descripcion' => 'Trabajo en altura.',
                'job_id' => 13,
                'created_at' => '2023-10-23 01:33:44',
                'updated_at' => '2024-11-22 03:38:10',
            ),
            52 => 
            array (
                'id' => 53,
                'descripcion' => 'Técnicas de almacenamiento.',
                'job_id' => 13,
                'created_at' => '2023-10-23 01:33:44',
                'updated_at' => '2024-11-22 03:38:10',
            ),
            53 => 
            array (
                'id' => 54,
                'descripcion' => 'Movimiento de maquinaria y equipo.',
                'job_id' => 13,
                'created_at' => '2023-10-23 01:33:44',
                'updated_at' => '2024-11-22 03:38:10',
            ),
            54 => 
            array (
                'id' => 55,
                'descripcion' => 'Manejo de computadora y paquetería.',
                'job_id' => 13,
                'created_at' => '2023-10-23 01:33:44',
                'updated_at' => '2024-11-22 03:38:10',
            ),
            55 => 
            array (
                'id' => 56,
                'descripcion' => 'Sin llenar',
                'job_id' => 13,
                'created_at' => '2023-10-23 01:33:44',
                'updated_at' => '2023-10-23 01:33:44',
            ),
            56 => 
            array (
                'id' => 57,
                'descripcion' => 'Reglamentos de transporte y carga.',
                'job_id' => 12,
                'created_at' => '2023-10-23 01:33:59',
                'updated_at' => '2024-11-22 05:36:29',
            ),
            57 => 
            array (
                'id' => 58,
                'descripcion' => 'Mecánica básica.',
                'job_id' => 12,
                'created_at' => '2023-10-23 01:33:59',
                'updated_at' => '2024-11-22 03:19:37',
            ),
            58 => 
            array (
                'id' => 59,
                'descripcion' => 'Mantenimiento de Instalación.',
                'job_id' => 12,
                'created_at' => '2023-10-23 01:33:59',
                'updated_at' => '2024-11-22 03:19:37',
            ),
            59 => 
            array (
                'id' => 60,
                'descripcion' => 'Uso de herramientas.',
                'job_id' => 12,
                'created_at' => '2023-10-23 01:33:59',
                'updated_at' => '2024-11-22 03:19:37',
            ),
            60 => 
            array (
                'id' => 61,
                'descripcion' => 'Normas de circulación y seguridad.',
                'job_id' => 12,
                'created_at' => '2023-10-23 01:33:59',
                'updated_at' => '2024-11-22 03:19:37',
            ),
            61 => 
            array (
                'id' => 62,
                'descripcion' => 'Habilidades logísticas.',
                'job_id' => 12,
                'created_at' => '2023-10-23 01:33:59',
                'updated_at' => '2024-11-22 03:19:37',
            ),
            62 => 
            array (
                'id' => 63,
                'descripcion' => 'Manejo de vehículos hasta 3 ejes.',
                'job_id' => 12,
                'created_at' => '2023-10-23 01:33:59',
                'updated_at' => '2024-11-22 03:19:37',
            ),
            63 => 
            array (
                'id' => 64,
                'descripcion' => 'Sin llenar.',
                'job_id' => 12,
                'created_at' => '2023-10-23 01:33:59',
                'updated_at' => '2024-11-22 05:36:29',
            ),
            64 => 
            array (
                'id' => 65,
                'descripcion' => 'Interpretación de planos de fabricación e isométricos',
                'job_id' => 66,
                'created_at' => '2023-10-23 01:34:32',
                'updated_at' => '2023-10-23 23:37:58',
            ),
            65 => 
            array (
                'id' => 66,
                'descripcion' => 'Inspección de instalaciones, material, equipo y superficies.',
                'job_id' => 66,
                'created_at' => '2023-10-23 01:34:32',
                'updated_at' => '2023-10-23 23:37:58',
            ),
            66 => 
            array (
                'id' => 67,
                'descripcion' => 'Procedimientos, estándares y posiciones de soldadura.',
                'job_id' => 66,
                'created_at' => '2023-10-23 01:34:32',
                'updated_at' => '2023-10-23 23:37:58',
            ),
            67 => 
            array (
                'id' => 68,
                'descripcion' => 'Soldadura SMAW',
                'job_id' => 66,
                'created_at' => '2023-10-23 01:34:32',
                'updated_at' => '2023-10-23 23:37:58',
            ),
            68 => 
            array (
                'id' => 69,
                'descripcion' => 'Instrumentos de tipo análogo y digital de medición',
                'job_id' => 66,
                'created_at' => '2023-10-23 01:34:32',
                'updated_at' => '2023-10-23 23:37:58',
            ),
            69 => 
            array (
                'id' => 70,
                'descripcion' => 'Sin llenar',
                'job_id' => 66,
                'created_at' => '2023-10-23 01:34:32',
                'updated_at' => '2023-10-23 01:34:32',
            ),
            70 => 
            array (
                'id' => 71,
                'descripcion' => 'Sin llenar',
                'job_id' => 66,
                'created_at' => '2023-10-23 01:34:32',
                'updated_at' => '2023-10-23 01:34:32',
            ),
            71 => 
            array (
                'id' => 72,
                'descripcion' => 'Sin llenar',
                'job_id' => 66,
                'created_at' => '2023-10-23 01:34:32',
                'updated_at' => '2023-10-23 01:34:32',
            ),
            72 => 
            array (
                'id' => 73,
                'descripcion' => ' Conocimientos sobre Materiales.',
                'job_id' => 63,
                'created_at' => '2023-10-23 02:45:05',
                'updated_at' => '2024-11-25 04:14:10',
            ),
            73 => 
            array (
                'id' => 74,
                'descripcion' => 'Equipos y Herramientas de Pintura.',
                'job_id' => 63,
                'created_at' => '2023-10-23 02:45:05',
                'updated_at' => '2024-11-25 04:14:10',
            ),
            74 => 
            array (
                'id' => 75,
                'descripcion' => 'Técnicas de Pintura.',
                'job_id' => 63,
                'created_at' => '2023-10-23 02:45:05',
                'updated_at' => '2024-11-25 04:14:10',
            ),
            75 => 
            array (
                'id' => 76,
                'descripcion' => 'Sustancias Químicas Peligrosas.',
                'job_id' => 63,
                'created_at' => '2023-10-23 02:45:05',
                'updated_at' => '2024-11-25 04:14:10',
            ),
            76 => 
            array (
                'id' => 77,
                'descripcion' => 'Mantenimiento de Equipos.',
                'job_id' => 63,
                'created_at' => '2023-10-23 02:45:05',
                'updated_at' => '2024-11-25 04:14:10',
            ),
            77 => 
            array (
                'id' => 78,
                'descripcion' => 'Seguridad e Higiene.',
                'job_id' => 63,
                'created_at' => '2023-10-23 02:45:05',
                'updated_at' => '2024-11-25 04:14:10',
            ),
            78 => 
            array (
                'id' => 79,
                'descripcion' => 'Adaptación a Entornos de Trabajo.',
                'job_id' => 63,
                'created_at' => '2023-10-23 02:45:05',
                'updated_at' => '2024-11-25 04:14:10',
            ),
            79 => 
            array (
                'id' => 80,
                'descripcion' => 'Sin llenar',
                'job_id' => 63,
                'created_at' => '2023-10-23 02:45:05',
                'updated_at' => '2023-10-23 02:45:05',
            ),
            80 => 
            array (
                'id' => 81,
                'descripcion' => 'Planeación estratégica',
                'job_id' => 60,
                'created_at' => '2023-10-23 18:02:54',
                'updated_at' => '2023-10-23 21:24:12',
            ),
            81 => 
            array (
                'id' => 82,
                'descripcion' => 'Sistemas de gestión integral',
                'job_id' => 60,
                'created_at' => '2023-10-23 18:02:54',
                'updated_at' => '2023-10-23 21:24:12',
            ),
            82 => 
            array (
                'id' => 83,
                'descripcion' => 'Finanzas y economía',
                'job_id' => 60,
                'created_at' => '2023-10-23 18:02:54',
                'updated_at' => '2023-10-23 21:24:12',
            ),
            83 => 
            array (
                'id' => 84,
                'descripcion' => 'Entorno sociopolítico del sector Oil & Gas',
                'job_id' => 60,
                'created_at' => '2023-10-23 18:02:54',
                'updated_at' => '2023-10-23 21:24:12',
            ),
            84 => 
            array (
                'id' => 85,
                'descripcion' => 'Gestión empresarial',
                'job_id' => 60,
                'created_at' => '2023-10-23 18:02:54',
                'updated_at' => '2023-10-23 21:24:12',
            ),
            85 => 
            array (
                'id' => 86,
                'descripcion' => 'Legislación empresarial',
                'job_id' => 60,
                'created_at' => '2023-10-23 18:02:54',
                'updated_at' => '2023-10-23 21:24:12',
            ),
            86 => 
            array (
                'id' => 87,
                'descripcion' => 'KPI´s.',
                'job_id' => 60,
                'created_at' => '2023-10-23 18:02:54',
                'updated_at' => '2023-10-23 21:24:12',
            ),
            87 => 
            array (
                'id' => 88,
                'descripcion' => 'Sin llenar',
                'job_id' => 60,
                'created_at' => '2023-10-23 18:02:54',
                'updated_at' => '2023-10-23 18:02:54',
            ),
            88 => 
            array (
                'id' => 89,
                'descripcion' => 'Costos administrativos',
                'job_id' => 39,
                'created_at' => '2023-10-23 18:03:33',
                'updated_at' => '2023-10-23 18:44:04',
            ),
            89 => 
            array (
                'id' => 90,
                'descripcion' => 'Conocimiento en indirectos, nómina y obra en ejecución',
                'job_id' => 39,
                'created_at' => '2023-10-23 18:03:33',
                'updated_at' => '2023-10-23 18:44:04',
            ),
            90 => 
            array (
                'id' => 91,
                'descripcion' => 'Elaboración de catálogo de conceptos',
                'job_id' => 39,
                'created_at' => '2023-10-23 18:03:33',
                'updated_at' => '2023-10-23 18:44:04',
            ),
            91 => 
            array (
                'id' => 92,
                'descripcion' => 'Análisis de precios unitarios',
                'job_id' => 39,
                'created_at' => '2023-10-23 18:03:33',
                'updated_at' => '2023-10-23 18:44:04',
            ),
            92 => 
            array (
                'id' => 93,
                'descripcion' => 'Costos y presupuestos de Obras',
                'job_id' => 39,
                'created_at' => '2023-10-23 18:03:33',
                'updated_at' => '2023-10-23 18:44:04',
            ),
            93 => 
            array (
                'id' => 94,
                'descripcion' => 'Elaboración presupuestos',
                'job_id' => 39,
                'created_at' => '2023-10-23 18:03:33',
                'updated_at' => '2023-10-23 18:44:04',
            ),
            94 => 
            array (
                'id' => 95,
                'descripcion' => 'Presupuestos ',
                'job_id' => 39,
                'created_at' => '2023-10-23 18:03:33',
                'updated_at' => '2023-10-23 18:44:04',
            ),
            95 => 
            array (
                'id' => 96,
                'descripcion' => 'Control de gastos ',
                'job_id' => 39,
                'created_at' => '2023-10-23 18:03:33',
                'updated_at' => '2023-10-23 18:44:04',
            ),
            96 => 
            array (
                'id' => 97,
                'descripcion' => 'Sistema de calidad.',
                'job_id' => 59,
                'created_at' => '2023-10-23 19:44:39',
                'updated_at' => '2024-11-19 07:15:16',
            ),
            97 => 
            array (
                'id' => 98,
                'descripcion' => 'Investigación de incidentes/accidentes',
                'job_id' => 59,
                'created_at' => '2023-10-23 19:44:39',
                'updated_at' => '2024-11-19 07:15:16',
            ),
            98 => 
            array (
                'id' => 99,
                'descripcion' => 'Legislación ambiental.',
                'job_id' => 59,
                'created_at' => '2023-10-23 19:44:39',
                'updated_at' => '2024-11-19 07:15:16',
            ),
            99 => 
            array (
                'id' => 100,
                'descripcion' => 'Cumplimiento normas STPS.',
                'job_id' => 59,
                'created_at' => '2023-10-23 19:44:39',
                'updated_at' => '2024-11-19 07:15:16',
            ),
            100 => 
            array (
                'id' => 101,
                'descripcion' => 'Seguridad e higiene.',
                'job_id' => 59,
                'created_at' => '2023-10-23 19:44:39',
                'updated_at' => '2024-11-19 07:15:16',
            ),
            101 => 
            array (
                'id' => 102,
                'descripcion' => 'Sin llenar',
                'job_id' => 59,
                'created_at' => '2023-10-23 19:44:39',
                'updated_at' => '2023-10-23 19:44:39',
            ),
            102 => 
            array (
                'id' => 103,
                'descripcion' => 'Sin llenar',
                'job_id' => 59,
                'created_at' => '2023-10-23 19:44:39',
                'updated_at' => '2023-10-23 19:44:39',
            ),
            103 => 
            array (
                'id' => 104,
                'descripcion' => 'Sin llenar',
                'job_id' => 59,
                'created_at' => '2023-10-23 19:44:39',
                'updated_at' => '2023-10-23 19:44:39',
            ),
            104 => 
            array (
                'id' => 105,
                'descripcion' => 'ISO 14001:2015, 9001:2015, 45001:2018.',
                'job_id' => 58,
                'created_at' => '2023-10-23 19:49:21',
                'updated_at' => '2024-11-20 06:31:16',
            ),
            105 => 
            array (
                'id' => 106,
                'descripcion' => 'Legislación ambiental.',
                'job_id' => 58,
                'created_at' => '2023-10-23 19:49:21',
                'updated_at' => '2024-11-20 06:31:16',
            ),
            106 => 
            array (
                'id' => 107,
                'descripcion' => 'Cumplimiento normas STPS.',
                'job_id' => 58,
                'created_at' => '2023-10-23 19:49:21',
                'updated_at' => '2024-11-20 06:31:16',
            ),
            107 => 
            array (
                'id' => 108,
                'descripcion' => 'Seguridad e higiene.',
                'job_id' => 58,
                'created_at' => '2023-10-23 19:49:21',
                'updated_at' => '2024-11-20 06:31:16',
            ),
            108 => 
            array (
                'id' => 109,
                'descripcion' => 'Paquetería Office.',
                'job_id' => 58,
                'created_at' => '2023-10-23 19:49:21',
                'updated_at' => '2024-11-20 06:31:16',
            ),
            109 => 
            array (
                'id' => 110,
                'descripcion' => 'Investigación de incidentes/accidentes.',
                'job_id' => 58,
                'created_at' => '2023-10-23 19:49:21',
                'updated_at' => '2024-11-20 06:31:16',
            ),
            110 => 
            array (
                'id' => 111,
                'descripcion' => 'Sistemas de Gestión Integrales.',
                'job_id' => 58,
                'created_at' => '2023-10-23 19:49:21',
                'updated_at' => '2024-11-20 06:31:16',
            ),
            111 => 
            array (
                'id' => 112,
            'descripcion' => 'Análisis de Riesgo (What If, HAZOP, et al).',
                'job_id' => 58,
                'created_at' => '2023-10-23 19:49:21',
                'updated_at' => '2024-11-20 06:31:16',
            ),
            112 => 
            array (
                'id' => 113,
            'descripcion' => 'Inglés  (capaz de mantener una conversación simple)',
                'job_id' => 56,
                'created_at' => '2023-10-23 21:45:16',
                'updated_at' => '2023-10-23 22:13:41',
            ),
            113 => 
            array (
                'id' => 114,
                'descripcion' => 'Servicios de Hot Tapping & Line Stopping.',
                'job_id' => 56,
                'created_at' => '2023-10-23 21:45:16',
                'updated_at' => '2023-10-23 22:13:41',
            ),
            114 => 
            array (
                'id' => 115,
                'descripcion' => 'Conocimiento del Sector Energético y la industria de Oil & Gas.',
                'job_id' => 56,
                'created_at' => '2023-10-23 21:45:16',
                'updated_at' => '2023-10-23 22:13:41',
            ),
            115 => 
            array (
                'id' => 116,
                'descripcion' => 'Integridad de ductos',
                'job_id' => 56,
                'created_at' => '2023-10-23 21:45:16',
                'updated_at' => '2023-10-23 22:13:41',
            ),
            116 => 
            array (
                'id' => 117,
                'descripcion' => 'Conocimiento en válvulas',
                'job_id' => 56,
                'created_at' => '2023-10-23 21:45:16',
                'updated_at' => '2023-10-23 22:13:41',
            ),
            117 => 
            array (
                'id' => 118,
                'descripcion' => 'Soldadura',
                'job_id' => 56,
                'created_at' => '2023-10-23 21:45:16',
                'updated_at' => '2023-10-23 22:13:41',
            ),
            118 => 
            array (
                'id' => 119,
            'descripcion' => 'Conocimientos en desarrollo de negocios (comercial y mercadotecnia)',
                'job_id' => 56,
                'created_at' => '2023-10-23 21:45:16',
                'updated_at' => '2023-10-23 22:13:41',
            ),
            119 => 
            array (
                'id' => 120,
                'descripcion' => 'Sin llenar',
                'job_id' => 56,
                'created_at' => '2023-10-23 21:45:16',
                'updated_at' => '2023-10-23 21:45:16',
            ),
            120 => 
            array (
                'id' => 121,
                'descripcion' => 'Elaboración y edición de videos.',
                'job_id' => 67,
                'created_at' => '2023-10-23 22:30:15',
                'updated_at' => '2024-11-25 04:43:15',
            ),
            121 => 
            array (
                'id' => 122,
                'descripcion' => 'Excelentes habilidades de comunicación escrita y verbal.',
                'job_id' => 67,
                'created_at' => '2023-10-23 22:30:15',
                'updated_at' => '2024-11-25 04:43:15',
            ),
            122 => 
            array (
                'id' => 123,
                'descripcion' => 'Fotografía.',
                'job_id' => 67,
                'created_at' => '2023-10-23 22:30:15',
                'updated_at' => '2024-11-25 04:43:15',
            ),
            123 => 
            array (
                'id' => 124,
            'descripcion' => 'Software de diseño (Photoshop, InDesign, ilustrador ).',
                'job_id' => 67,
                'created_at' => '2023-10-23 22:30:15',
                'updated_at' => '2024-11-25 04:43:15',
            ),
            124 => 
            array (
                'id' => 125,
                'descripcion' => 'Conocimiento de tácticas de marketing digital y email marketing.',
                'job_id' => 67,
                'created_at' => '2023-10-23 22:30:15',
                'updated_at' => '2024-11-25 04:43:15',
            ),
            125 => 
            array (
                'id' => 126,
                'descripcion' => 'Administración de Redes Sociales.',
                'job_id' => 67,
                'created_at' => '2023-10-23 22:30:15',
                'updated_at' => '2024-11-25 04:43:15',
            ),
            126 => 
            array (
                'id' => 127,
                'descripcion' => 'Sin llenar.',
                'job_id' => 67,
                'created_at' => '2023-10-23 22:30:15',
                'updated_at' => '2024-11-25 04:43:15',
            ),
            127 => 
            array (
                'id' => 128,
                'descripcion' => 'Sin llenar.',
                'job_id' => 67,
                'created_at' => '2023-10-23 22:30:15',
                'updated_at' => '2024-11-25 04:43:15',
            ),
            128 => 
            array (
                'id' => 129,
                'descripcion' => 'Intermedios en contabilidad general.',
                'job_id' => 68,
                'created_at' => '2023-10-23 23:07:42',
                'updated_at' => '2024-11-20 06:10:40',
            ),
            129 => 
            array (
                'id' => 130,
                'descripcion' => 'Solidos en facturación 4.0.',
                'job_id' => 68,
                'created_at' => '2023-10-23 23:07:42',
                'updated_at' => '2024-11-20 06:10:40',
            ),
            130 => 
            array (
                'id' => 131,
            'descripcion' => 'Impuestos de S.A.  De C.V (Básico a Intermedio)',
                'job_id' => 68,
                'created_at' => '2023-10-23 23:07:42',
                'updated_at' => '2024-11-20 06:10:40',
            ),
            131 => 
            array (
                'id' => 132,
            'descripcion' => 'Estados financieros (Estructura, nivel básico a intermedio)',
                'job_id' => 68,
                'created_at' => '2023-10-23 23:07:42',
                'updated_at' => '2024-11-20 06:10:40',
            ),
            132 => 
            array (
                'id' => 133,
            'descripcion' => 'Software administrativo (COI)',
                'job_id' => 68,
                'created_at' => '2023-10-23 23:07:42',
                'updated_at' => '2024-11-20 06:10:40',
            ),
            133 => 
            array (
                'id' => 134,
                'descripcion' => 'Excel Intermedio',
                'job_id' => 68,
                'created_at' => '2023-10-23 23:07:42',
                'updated_at' => '2024-11-20 06:10:40',
            ),
            134 => 
            array (
                'id' => 135,
                'descripcion' => 'Elaboración de reportes',
                'job_id' => 68,
                'created_at' => '2023-10-23 23:07:42',
                'updated_at' => '2024-11-20 06:10:40',
            ),
            135 => 
            array (
                'id' => 136,
                'descripcion' => 'Sin llenar',
                'job_id' => 68,
                'created_at' => '2023-10-23 23:07:42',
                'updated_at' => '2023-10-23 23:07:42',
            ),
            136 => 
            array (
                'id' => 137,
                'descripcion' => 'Ley federal del trabajo, Ley federal del seguro social, Ley de Infonavit.',
                'job_id' => 50,
                'created_at' => '2023-10-29 21:49:55',
                'updated_at' => '2024-11-25 04:28:18',
            ),
            137 => 
            array (
                'id' => 138,
                'descripcion' => 'Obligaciones en materia de capacitación ante la STPS.',
                'job_id' => 50,
                'created_at' => '2023-10-29 21:49:55',
                'updated_at' => '2024-11-19 06:27:48',
            ),
            138 => 
            array (
                'id' => 139,
                'descripcion' => 'Métodos de detección de necesidades de capacitación y planes de desarrollo.',
                'job_id' => 50,
                'created_at' => '2023-10-29 21:49:55',
                'updated_at' => '2024-11-25 04:28:18',
            ),
            139 => 
            array (
                'id' => 140,
            'descripcion' => 'Impartición de cursos (presenciales y en línea).',
                'job_id' => 50,
                'created_at' => '2023-10-29 21:49:55',
                'updated_at' => '2024-11-19 06:27:48',
            ),
            140 => 
            array (
                'id' => 141,
                'descripcion' => 'SIROC y REPSE.',
                'job_id' => 50,
                'created_at' => '2023-10-29 21:49:55',
                'updated_at' => '2024-11-25 04:28:18',
            ),
            141 => 
            array (
                'id' => 142,
                'descripcion' => 'Nominas.',
                'job_id' => 50,
                'created_at' => '2023-10-29 21:49:55',
                'updated_at' => '2024-11-25 04:28:18',
            ),
            142 => 
            array (
                'id' => 143,
                'descripcion' => 'Elaboración de indicadores.',
                'job_id' => 50,
                'created_at' => '2023-10-29 21:49:55',
                'updated_at' => '2024-11-25 04:28:18',
            ),
            143 => 
            array (
                'id' => 144,
                'descripcion' => 'Onboarding.',
                'job_id' => 50,
                'created_at' => '2023-10-29 21:49:55',
                'updated_at' => '2024-11-25 04:28:18',
            ),
            144 => 
            array (
                'id' => 145,
                'descripcion' => 'Gestión de proyectos',
                'job_id' => 38,
                'created_at' => '2023-11-06 20:20:08',
                'updated_at' => '2025-07-16 02:31:33',
            ),
            145 => 
            array (
                'id' => 146,
                'descripcion' => 'Obra civil',
                'job_id' => 38,
                'created_at' => '2023-11-06 20:20:08',
                'updated_at' => '2025-07-16 02:31:33',
            ),
            146 => 
            array (
                'id' => 147,
                'descripcion' => 'Servicios de Hot Tapping & Line Stopping.',
                'job_id' => 38,
                'created_at' => '2023-11-06 20:20:08',
                'updated_at' => '2025-07-16 02:31:33',
            ),
            147 => 
            array (
                'id' => 148,
                'descripcion' => 'Servicios de Onshore y Offshore.',
                'job_id' => 38,
                'created_at' => '2023-11-06 20:20:08',
                'updated_at' => '2025-07-16 02:31:33',
            ),
            148 => 
            array (
                'id' => 149,
                'descripcion' => 'Control documental',
                'job_id' => 38,
                'created_at' => '2023-11-06 20:20:08',
                'updated_at' => '2025-07-16 02:31:33',
            ),
            149 => 
            array (
                'id' => 150,
                'descripcion' => 'Sin llenar',
                'job_id' => 38,
                'created_at' => '2023-11-06 20:20:08',
                'updated_at' => '2023-11-06 20:20:08',
            ),
            150 => 
            array (
                'id' => 151,
                'descripcion' => 'Sin llenar',
                'job_id' => 38,
                'created_at' => '2023-11-06 20:20:08',
                'updated_at' => '2023-11-06 20:20:08',
            ),
            151 => 
            array (
                'id' => 152,
                'descripcion' => 'Sin llenar',
                'job_id' => 38,
                'created_at' => '2023-11-06 20:20:08',
                'updated_at' => '2023-11-06 20:20:08',
            ),
            152 => 
            array (
                'id' => 153,
                'descripcion' => 'Sin llenar',
                'job_id' => 71,
                'created_at' => '2023-11-06 21:11:53',
                'updated_at' => '2023-11-06 21:11:53',
            ),
            153 => 
            array (
                'id' => 154,
                'descripcion' => 'Sin llenar',
                'job_id' => 71,
                'created_at' => '2023-11-06 21:11:53',
                'updated_at' => '2023-11-06 21:11:53',
            ),
            154 => 
            array (
                'id' => 155,
                'descripcion' => 'Sin llenar',
                'job_id' => 71,
                'created_at' => '2023-11-06 21:11:53',
                'updated_at' => '2023-11-06 21:11:53',
            ),
            155 => 
            array (
                'id' => 156,
                'descripcion' => 'Sin llenar',
                'job_id' => 71,
                'created_at' => '2023-11-06 21:11:53',
                'updated_at' => '2023-11-06 21:11:53',
            ),
            156 => 
            array (
                'id' => 157,
                'descripcion' => 'Sin llenar',
                'job_id' => 71,
                'created_at' => '2023-11-06 21:11:53',
                'updated_at' => '2023-11-06 21:11:53',
            ),
            157 => 
            array (
                'id' => 158,
                'descripcion' => 'Sin llenar',
                'job_id' => 71,
                'created_at' => '2023-11-06 21:11:53',
                'updated_at' => '2023-11-06 21:11:53',
            ),
            158 => 
            array (
                'id' => 159,
                'descripcion' => 'Sin llenar',
                'job_id' => 71,
                'created_at' => '2023-11-06 21:11:53',
                'updated_at' => '2023-11-06 21:11:53',
            ),
            159 => 
            array (
                'id' => 160,
                'descripcion' => 'Sin llenar',
                'job_id' => 71,
                'created_at' => '2023-11-06 21:11:53',
                'updated_at' => '2023-11-06 21:11:53',
            ),
            160 => 
            array (
                'id' => 161,
                'descripcion' => ' Análisis de Mercado.',
                'job_id' => 44,
                'created_at' => '2023-11-07 00:46:22',
                'updated_at' => '2024-11-20 08:55:19',
            ),
            161 => 
            array (
                'id' => 162,
                'descripcion' => 'Proceso de importación.',
                'job_id' => 44,
                'created_at' => '2023-11-07 00:46:22',
                'updated_at' => '2024-11-20 08:55:19',
            ),
            162 => 
            array (
                'id' => 163,
            'descripcion' => 'ERP (Satech).',
                'job_id' => 44,
                'created_at' => '2023-11-07 00:46:22',
                'updated_at' => '2024-11-20 08:55:19',
            ),
            163 => 
            array (
                'id' => 164,
                'descripcion' => 'Evaluación de proveedores.',
                'job_id' => 44,
                'created_at' => '2023-11-07 00:46:22',
                'updated_at' => '2024-11-20 08:55:19',
            ),
            164 => 
            array (
                'id' => 165,
                'descripcion' => 'Ahorros.',
                'job_id' => 44,
                'created_at' => '2023-11-07 00:46:22',
                'updated_at' => '2024-11-20 08:55:19',
            ),
            165 => 
            array (
                'id' => 166,
                'descripcion' => 'Negociación.',
                'job_id' => 44,
                'created_at' => '2023-11-07 00:46:22',
                'updated_at' => '2024-11-20 08:55:19',
            ),
            166 => 
            array (
                'id' => 167,
                'descripcion' => 'Sin llenar',
                'job_id' => 44,
                'created_at' => '2023-11-07 00:46:22',
                'updated_at' => '2023-11-07 00:46:22',
            ),
            167 => 
            array (
                'id' => 168,
                'descripcion' => 'Sin llenar',
                'job_id' => 44,
                'created_at' => '2023-11-07 00:46:22',
                'updated_at' => '2023-11-07 00:46:22',
            ),
            168 => 
            array (
                'id' => 169,
                'descripcion' => 'Seguridad e Higiene ',
                'job_id' => 72,
                'created_at' => '2023-12-11 21:23:46',
                'updated_at' => '2023-12-11 23:17:18',
            ),
            169 => 
            array (
                'id' => 170,
                'descripcion' => 'Investigación de accidentes y/o incidentes ',
                'job_id' => 72,
                'created_at' => '2023-12-11 21:23:46',
                'updated_at' => '2023-12-11 23:17:18',
            ),
            170 => 
            array (
                'id' => 171,
            'descripcion' => 'Normatividad STPS (aplicable a la organización)',
                'job_id' => 72,
                'created_at' => '2023-12-11 21:23:46',
                'updated_at' => '2023-12-11 23:17:18',
            ),
            171 => 
            array (
                'id' => 172,
            'descripcion' => 'SEMARNAT (aplicable a la organización)',
                'job_id' => 72,
                'created_at' => '2023-12-11 21:23:46',
                'updated_at' => '2023-12-11 23:17:18',
            ),
            172 => 
            array (
                'id' => 173,
                'descripcion' => 'Ley General de Equilibrio Ecológico y Protección al Medio Ambiente ',
                'job_id' => 72,
                'created_at' => '2023-12-11 21:23:46',
                'updated_at' => '2023-12-11 23:17:18',
            ),
            173 => 
            array (
                'id' => 174,
                'descripcion' => 'Legislación ambiental  ',
                'job_id' => 72,
                'created_at' => '2023-12-11 21:23:46',
                'updated_at' => '2023-12-11 23:17:18',
            ),
            174 => 
            array (
                'id' => 175,
                'descripcion' => 'Anexo SSPA 3 A-AA',
                'job_id' => 72,
                'created_at' => '2023-12-11 21:23:46',
                'updated_at' => '2023-12-11 23:17:18',
            ),
            175 => 
            array (
                'id' => 176,
                'descripcion' => 'Sin llenar',
                'job_id' => 72,
                'created_at' => '2023-12-11 21:23:46',
                'updated_at' => '2023-12-11 21:23:46',
            ),
            176 => 
            array (
                'id' => 177,
                'descripcion' => 'Manejo de Excel.',
                'job_id' => 1,
                'created_at' => '2023-12-12 01:30:06',
                'updated_at' => '2024-11-21 03:32:23',
            ),
            177 => 
            array (
                'id' => 178,
                'descripcion' => 'Técnicas de almacenamiento.  ',
                'job_id' => 1,
                'created_at' => '2023-12-12 01:30:06',
                'updated_at' => '2024-11-21 03:32:23',
            ),
            178 => 
            array (
                'id' => 179,
                'descripcion' => 'Elaboración de inventarios.',
                'job_id' => 1,
                'created_at' => '2023-12-12 01:30:06',
                'updated_at' => '2024-11-13 06:06:57',
            ),
            179 => 
            array (
                'id' => 180,
                'descripcion' => 'Manejo de PowerPoint.',
                'job_id' => 1,
                'created_at' => '2023-12-12 01:30:06',
                'updated_at' => '2024-11-21 03:32:23',
            ),
            180 => 
            array (
                'id' => 181,
                'descripcion' => 'Control de información.',
                'job_id' => 1,
                'created_at' => '2023-12-12 01:30:06',
                'updated_at' => '2024-11-21 03:32:23',
            ),
            181 => 
            array (
                'id' => 182,
                'descripcion' => 'SAE.',
                'job_id' => 1,
                'created_at' => '2023-12-12 01:30:06',
                'updated_at' => '2024-11-21 03:32:23',
            ),
            182 => 
            array (
                'id' => 183,
                'descripcion' => 'Movimiento de maquinaria y equipo.',
                'job_id' => 1,
                'created_at' => '2023-12-12 01:30:06',
                'updated_at' => '2024-11-21 03:32:23',
            ),
            183 => 
            array (
                'id' => 184,
                'descripcion' => 'Sin llenar',
                'job_id' => 1,
                'created_at' => '2023-12-12 01:30:06',
                'updated_at' => '2023-12-12 01:30:06',
            ),
            184 => 
            array (
                'id' => 185,
                'descripcion' => 'Norma ISO 9001:2015.',
                'job_id' => 73,
                'created_at' => '2024-01-21 22:19:59',
                'updated_at' => '2024-11-20 06:26:00',
            ),
            185 => 
            array (
                'id' => 186,
                'descripcion' => 'Normativa API, ANSI, ASME, NOM, NACE, ISO.',
                'job_id' => 73,
                'created_at' => '2024-01-21 22:19:59',
                'updated_at' => '2024-11-20 06:26:00',
            ),
            186 => 
            array (
                'id' => 187,
                'descripcion' => 'Conocimiento de la industria Metal-Mecánica.',
                'job_id' => 73,
                'created_at' => '2024-01-21 22:19:59',
                'updated_at' => '2024-11-20 06:26:00',
            ),
            187 => 
            array (
                'id' => 188,
            'descripcion' => 'Metrología (intermedio).',
                'job_id' => 73,
                'created_at' => '2024-01-21 22:19:59',
                'updated_at' => '2024-11-20 06:26:00',
            ),
            188 => 
            array (
                'id' => 189,
            'descripcion' => 'Pruebas No Destructivas (básico).',
                'job_id' => 73,
                'created_at' => '2024-01-21 22:19:59',
                'updated_at' => '2024-11-20 06:26:00',
            ),
            189 => 
            array (
                'id' => 190,
            'descripcion' => 'Pruebas Destructivas (intermedio).',
                'job_id' => 73,
                'created_at' => '2024-01-21 22:19:59',
                'updated_at' => '2024-11-20 06:26:00',
            ),
            190 => 
            array (
                'id' => 191,
            'descripcion' => 'Conocimiento del sector OiI & Gas (Deseable)',
                'job_id' => 73,
                'created_at' => '2024-01-21 22:19:59',
                'updated_at' => '2024-11-20 06:26:00',
            ),
            191 => 
            array (
                'id' => 192,
            'descripcion' => 'Soldadura (básico y teórico deseable)',
                'job_id' => 73,
                'created_at' => '2024-01-21 22:19:59',
                'updated_at' => '2024-11-25 04:44:24',
            ),
            192 => 
            array (
                'id' => 193,
                'descripcion' => 'Sin llenar',
                'job_id' => 74,
                'created_at' => '2024-01-24 02:15:01',
                'updated_at' => '2024-01-24 02:15:01',
            ),
            193 => 
            array (
                'id' => 194,
                'descripcion' => 'Sin llenar',
                'job_id' => 74,
                'created_at' => '2024-01-24 02:15:01',
                'updated_at' => '2024-01-24 02:15:01',
            ),
            194 => 
            array (
                'id' => 195,
                'descripcion' => 'Sin llenar',
                'job_id' => 74,
                'created_at' => '2024-01-24 02:15:01',
                'updated_at' => '2024-01-24 02:15:01',
            ),
            195 => 
            array (
                'id' => 196,
                'descripcion' => 'Sin llenar',
                'job_id' => 74,
                'created_at' => '2024-01-24 02:15:01',
                'updated_at' => '2024-01-24 02:15:01',
            ),
            196 => 
            array (
                'id' => 197,
                'descripcion' => 'Sin llenar',
                'job_id' => 74,
                'created_at' => '2024-01-24 02:15:01',
                'updated_at' => '2024-01-24 02:15:01',
            ),
            197 => 
            array (
                'id' => 198,
                'descripcion' => 'Sin llenar',
                'job_id' => 74,
                'created_at' => '2024-01-24 02:15:01',
                'updated_at' => '2024-01-24 02:15:01',
            ),
            198 => 
            array (
                'id' => 199,
                'descripcion' => 'Sin llenar',
                'job_id' => 74,
                'created_at' => '2024-01-24 02:15:01',
                'updated_at' => '2024-01-24 02:15:01',
            ),
            199 => 
            array (
                'id' => 200,
                'descripcion' => 'Sin llenar',
                'job_id' => 74,
                'created_at' => '2024-01-24 02:15:01',
                'updated_at' => '2024-01-24 02:15:01',
            ),
            200 => 
            array (
                'id' => 201,
                'descripcion' => 'Sin llenar',
                'job_id' => 75,
                'created_at' => '2024-02-07 20:02:56',
                'updated_at' => '2024-02-07 20:02:56',
            ),
            201 => 
            array (
                'id' => 202,
                'descripcion' => 'Sin llenar',
                'job_id' => 75,
                'created_at' => '2024-02-07 20:02:56',
                'updated_at' => '2024-02-07 20:02:56',
            ),
            202 => 
            array (
                'id' => 203,
                'descripcion' => 'Sin llenar',
                'job_id' => 75,
                'created_at' => '2024-02-07 20:02:56',
                'updated_at' => '2024-02-07 20:02:56',
            ),
            203 => 
            array (
                'id' => 204,
                'descripcion' => 'Sin llenar',
                'job_id' => 75,
                'created_at' => '2024-02-07 20:02:56',
                'updated_at' => '2024-02-07 20:02:56',
            ),
            204 => 
            array (
                'id' => 205,
                'descripcion' => 'Sin llenar',
                'job_id' => 75,
                'created_at' => '2024-02-07 20:02:56',
                'updated_at' => '2024-02-07 20:02:56',
            ),
            205 => 
            array (
                'id' => 206,
                'descripcion' => 'Sin llenar',
                'job_id' => 75,
                'created_at' => '2024-02-07 20:02:56',
                'updated_at' => '2024-02-07 20:02:56',
            ),
            206 => 
            array (
                'id' => 207,
                'descripcion' => 'Sin llenar',
                'job_id' => 75,
                'created_at' => '2024-02-07 20:02:56',
                'updated_at' => '2024-02-07 20:02:56',
            ),
            207 => 
            array (
                'id' => 208,
                'descripcion' => 'Sin llenar',
                'job_id' => 75,
                'created_at' => '2024-02-07 20:02:56',
                'updated_at' => '2024-02-07 20:02:56',
            ),
            208 => 
            array (
                'id' => 209,
            'descripcion' => 'SolidWorks (Avanzado- Chapa metálica).',
                'job_id' => 35,
                'created_at' => '2024-02-07 21:13:46',
                'updated_at' => '2024-11-25 04:12:49',
            ),
            209 => 
            array (
                'id' => 210,
                'descripcion' => 'Metrología.',
                'job_id' => 35,
                'created_at' => '2024-02-07 21:13:46',
                'updated_at' => '2024-11-25 04:12:49',
            ),
            210 => 
            array (
                'id' => 211,
                'descripcion' => 'Diseño e interpretación de planos.',
                'job_id' => 35,
                'created_at' => '2024-02-07 21:13:46',
                'updated_at' => '2024-11-25 04:12:49',
            ),
            211 => 
            array (
                'id' => 212,
                'descripcion' => 'Normativa ASME.',
                'job_id' => 35,
                'created_at' => '2024-02-07 21:13:46',
                'updated_at' => '2024-11-25 04:12:49',
            ),
            212 => 
            array (
                'id' => 213,
                'descripcion' => 'Trato con proveedores.',
                'job_id' => 35,
                'created_at' => '2024-02-07 21:13:46',
                'updated_at' => '2024-11-25 04:12:49',
            ),
            213 => 
            array (
                'id' => 214,
                'descripcion' => 'Diseño en productos del sector metalmecánico.',
                'job_id' => 35,
                'created_at' => '2024-02-07 21:13:46',
                'updated_at' => '2024-11-25 04:12:49',
            ),
            214 => 
            array (
                'id' => 215,
                'descripcion' => 'Simbología y procesos de soldadura.',
                'job_id' => 35,
                'created_at' => '2024-02-07 21:13:46',
                'updated_at' => '2024-11-25 04:12:49',
            ),
            215 => 
            array (
                'id' => 216,
                'descripcion' => '-',
                'job_id' => 35,
                'created_at' => '2024-02-07 21:13:46',
                'updated_at' => '2024-03-19 22:58:58',
            ),
            216 => 
            array (
                'id' => 217,
                'descripcion' => 'Uso y Manejo de montacargas.',
                'job_id' => 76,
                'created_at' => '2024-02-07 21:58:06',
                'updated_at' => '2024-11-22 03:41:16',
            ),
            217 => 
            array (
                'id' => 218,
                'descripcion' => 'Uso y manejo de izajes.',
                'job_id' => 76,
                'created_at' => '2024-02-07 21:58:06',
                'updated_at' => '2024-11-22 03:36:23',
            ),
            218 => 
            array (
                'id' => 219,
                'descripcion' => 'Experiencia laboral como maniobrista en almacenes.',
                'job_id' => 76,
                'created_at' => '2024-02-07 21:58:06',
                'updated_at' => '2024-11-22 03:36:23',
            ),
            219 => 
            array (
                'id' => 220,
                'descripcion' => 'Trabajo en alturas.',
                'job_id' => 76,
                'created_at' => '2024-02-07 21:58:06',
                'updated_at' => '2024-11-22 03:41:16',
            ),
            220 => 
            array (
                'id' => 221,
            'descripcion' => 'Técnicas de almacenamiento (deseable).',
                'job_id' => 76,
                'created_at' => '2024-02-07 21:58:06',
                'updated_at' => '2024-11-22 03:36:23',
            ),
            221 => 
            array (
                'id' => 222,
                'descripcion' => 'Movimiento de maquinaria y equipo.',
                'job_id' => 76,
                'created_at' => '2024-02-07 21:58:06',
                'updated_at' => '2024-11-22 03:36:23',
            ),
            222 => 
            array (
                'id' => 223,
                'descripcion' => 'Manejo de computadora, paquetería Office y SAE.',
                'job_id' => 76,
                'created_at' => '2024-02-07 21:58:06',
                'updated_at' => '2024-11-22 03:41:16',
            ),
            223 => 
            array (
                'id' => 224,
                'descripcion' => 'Control de información e inventarios.',
                'job_id' => 76,
                'created_at' => '2024-02-07 21:58:06',
                'updated_at' => '2024-11-22 03:41:16',
            ),
            224 => 
            array (
                'id' => 225,
            'descripcion' => 'Manejo e instalación de paqueterías (Office, Google Workspace).',
                'job_id' => 4,
                'created_at' => '2024-02-08 21:53:24',
                'updated_at' => '2024-11-20 09:01:44',
            ),
            225 => 
            array (
                'id' => 226,
            'descripcion' => 'Conocimientos básicos en ASPEL (COI/SAE).',
                'job_id' => 4,
                'created_at' => '2024-02-08 21:53:24',
                'updated_at' => '2024-11-20 09:01:44',
            ),
            226 => 
            array (
                'id' => 227,
                'descripcion' => 'Instalación y configuración de CCTV.',
                'job_id' => 4,
                'created_at' => '2024-02-08 21:53:24',
                'updated_at' => '2024-11-20 09:01:44',
            ),
            227 => 
            array (
                'id' => 228,
                'descripcion' => 'Manejo de mantenimiento y reparación de equipos de cómputo y telefonía móvil.',
                'job_id' => 4,
                'created_at' => '2024-02-08 21:53:24',
                'updated_at' => '2024-11-20 09:01:44',
            ),
            228 => 
            array (
                'id' => 229,
                'descripcion' => 'Conocimientos en Android y IOS.',
                'job_id' => 4,
                'created_at' => '2024-02-08 21:53:24',
                'updated_at' => '2024-11-20 09:01:44',
            ),
            229 => 
            array (
                'id' => 230,
            'descripcion' => 'Manejo de sistemas operativos (Windows, OSX).',
                'job_id' => 4,
                'created_at' => '2024-02-08 21:53:24',
                'updated_at' => '2024-11-20 09:01:44',
            ),
            230 => 
            array (
                'id' => 231,
                'descripcion' => 'Configuración e instalación de redes, direccionamiento IP, configuración de routers, instalación de cableado estructurado.',
                'job_id' => 4,
                'created_at' => '2024-02-08 21:53:24',
                'updated_at' => '2024-11-20 09:01:44',
            ),
            231 => 
            array (
                'id' => 232,
                'descripcion' => 'Sin llenar',
                'job_id' => 4,
                'created_at' => '2024-02-08 21:53:24',
                'updated_at' => '2024-02-08 21:53:24',
            ),
            232 => 
            array (
                'id' => 233,
                'descripcion' => 'Cotizaciones.',
                'job_id' => 48,
                'created_at' => '2024-02-08 21:54:07',
                'updated_at' => '2024-11-19 02:40:39',
            ),
            233 => 
            array (
                'id' => 234,
                'descripcion' => 'Evaluación de proveedores.',
                'job_id' => 48,
                'created_at' => '2024-02-08 21:54:07',
                'updated_at' => '2024-11-19 02:40:39',
            ),
            234 => 
            array (
                'id' => 235,
                'descripcion' => 'Negociación.',
                'job_id' => 48,
                'created_at' => '2024-02-08 21:54:07',
                'updated_at' => '2024-11-19 02:40:39',
            ),
            235 => 
            array (
                'id' => 236,
            'descripcion' => 'ERP (SAE).',
                'job_id' => 48,
                'created_at' => '2024-02-08 21:54:07',
                'updated_at' => '2024-11-19 02:40:39',
            ),
            236 => 
            array (
                'id' => 237,
                'descripcion' => 'Excel.',
                'job_id' => 48,
                'created_at' => '2024-02-08 21:54:07',
                'updated_at' => '2024-11-19 02:40:39',
            ),
            237 => 
            array (
                'id' => 238,
                'descripcion' => 'Sin llenar',
                'job_id' => 48,
                'created_at' => '2024-02-08 21:54:07',
                'updated_at' => '2024-02-08 21:54:07',
            ),
            238 => 
            array (
                'id' => 239,
                'descripcion' => 'Sin llenar',
                'job_id' => 48,
                'created_at' => '2024-02-08 21:54:07',
                'updated_at' => '2024-02-08 21:54:07',
            ),
            239 => 
            array (
                'id' => 240,
                'descripcion' => 'Sin llenar',
                'job_id' => 48,
                'created_at' => '2024-02-08 21:54:07',
                'updated_at' => '2024-02-08 21:54:07',
            ),
            240 => 
            array (
                'id' => 241,
                'descripcion' => 'Sin llenar',
                'job_id' => 77,
                'created_at' => '2024-02-18 19:50:18',
                'updated_at' => '2024-02-18 19:50:18',
            ),
            241 => 
            array (
                'id' => 242,
                'descripcion' => 'Sin llenar',
                'job_id' => 77,
                'created_at' => '2024-02-18 19:50:18',
                'updated_at' => '2024-02-18 19:50:18',
            ),
            242 => 
            array (
                'id' => 243,
                'descripcion' => 'Sin llenar',
                'job_id' => 77,
                'created_at' => '2024-02-18 19:50:18',
                'updated_at' => '2024-02-18 19:50:18',
            ),
            243 => 
            array (
                'id' => 244,
                'descripcion' => 'Sin llenar',
                'job_id' => 77,
                'created_at' => '2024-02-18 19:50:18',
                'updated_at' => '2024-02-18 19:50:18',
            ),
            244 => 
            array (
                'id' => 245,
                'descripcion' => 'Sin llenar',
                'job_id' => 77,
                'created_at' => '2024-02-18 19:50:18',
                'updated_at' => '2024-02-18 19:50:18',
            ),
            245 => 
            array (
                'id' => 246,
                'descripcion' => 'Sin llenar',
                'job_id' => 77,
                'created_at' => '2024-02-18 19:50:18',
                'updated_at' => '2024-02-18 19:50:18',
            ),
            246 => 
            array (
                'id' => 247,
                'descripcion' => 'Sin llenar',
                'job_id' => 77,
                'created_at' => '2024-02-18 19:50:18',
                'updated_at' => '2024-02-18 19:50:18',
            ),
            247 => 
            array (
                'id' => 248,
                'descripcion' => 'Sin llenar',
                'job_id' => 77,
                'created_at' => '2024-02-18 19:50:18',
                'updated_at' => '2024-02-18 19:50:18',
            ),
            248 => 
            array (
                'id' => 249,
                'descripcion' => 'Sin llenar',
                'job_id' => 24,
                'created_at' => '2024-03-10 22:26:40',
                'updated_at' => '2024-03-10 22:26:40',
            ),
            249 => 
            array (
                'id' => 250,
                'descripcion' => 'Sin llenar',
                'job_id' => 24,
                'created_at' => '2024-03-10 22:26:40',
                'updated_at' => '2024-03-10 22:26:40',
            ),
            250 => 
            array (
                'id' => 251,
                'descripcion' => 'Sin llenar',
                'job_id' => 24,
                'created_at' => '2024-03-10 22:26:40',
                'updated_at' => '2024-03-10 22:26:40',
            ),
            251 => 
            array (
                'id' => 252,
                'descripcion' => 'Sin llenar',
                'job_id' => 24,
                'created_at' => '2024-03-10 22:26:40',
                'updated_at' => '2024-03-10 22:26:40',
            ),
            252 => 
            array (
                'id' => 253,
                'descripcion' => 'Sin llenar',
                'job_id' => 24,
                'created_at' => '2024-03-10 22:26:40',
                'updated_at' => '2024-03-10 22:26:40',
            ),
            253 => 
            array (
                'id' => 254,
                'descripcion' => 'Sin llenar',
                'job_id' => 24,
                'created_at' => '2024-03-10 22:26:40',
                'updated_at' => '2024-03-10 22:26:40',
            ),
            254 => 
            array (
                'id' => 255,
                'descripcion' => 'Sin llenar',
                'job_id' => 24,
                'created_at' => '2024-03-10 22:26:40',
                'updated_at' => '2024-03-10 22:26:40',
            ),
            255 => 
            array (
                'id' => 256,
                'descripcion' => 'Sin llenar',
                'job_id' => 24,
                'created_at' => '2024-03-10 22:26:40',
                'updated_at' => '2024-03-10 22:26:40',
            ),
            256 => 
            array (
                'id' => 257,
                'descripcion' => 'Sin llenar',
                'job_id' => 64,
                'created_at' => '2024-03-10 22:27:53',
                'updated_at' => '2024-03-10 22:27:53',
            ),
            257 => 
            array (
                'id' => 258,
                'descripcion' => 'Sin llenar',
                'job_id' => 64,
                'created_at' => '2024-03-10 22:27:53',
                'updated_at' => '2024-03-10 22:27:53',
            ),
            258 => 
            array (
                'id' => 259,
                'descripcion' => 'Sin llenar',
                'job_id' => 64,
                'created_at' => '2024-03-10 22:27:53',
                'updated_at' => '2024-03-10 22:27:53',
            ),
            259 => 
            array (
                'id' => 260,
                'descripcion' => 'Sin llenar',
                'job_id' => 64,
                'created_at' => '2024-03-10 22:27:53',
                'updated_at' => '2024-03-10 22:27:53',
            ),
            260 => 
            array (
                'id' => 261,
                'descripcion' => 'Sin llenar',
                'job_id' => 64,
                'created_at' => '2024-03-10 22:27:53',
                'updated_at' => '2024-03-10 22:27:53',
            ),
            261 => 
            array (
                'id' => 262,
                'descripcion' => 'Sin llenar',
                'job_id' => 64,
                'created_at' => '2024-03-10 22:27:53',
                'updated_at' => '2024-03-10 22:27:53',
            ),
            262 => 
            array (
                'id' => 263,
                'descripcion' => 'Sin llenar',
                'job_id' => 64,
                'created_at' => '2024-03-10 22:27:53',
                'updated_at' => '2024-03-10 22:27:53',
            ),
            263 => 
            array (
                'id' => 264,
                'descripcion' => 'Sin llenar',
                'job_id' => 64,
                'created_at' => '2024-03-10 22:27:53',
                'updated_at' => '2024-03-10 22:27:53',
            ),
            264 => 
            array (
                'id' => 265,
                'descripcion' => 'Control de insumos.',
                'job_id' => 3,
                'created_at' => '2024-03-13 20:48:38',
                'updated_at' => '2024-11-20 08:59:56',
            ),
            265 => 
            array (
                'id' => 266,
                'descripcion' => 'Seguimiento a requsiciones.',
                'job_id' => 3,
                'created_at' => '2024-03-13 20:48:38',
                'updated_at' => '2024-11-20 08:59:56',
            ),
            266 => 
            array (
                'id' => 267,
                'descripcion' => 'Manejo de PowerPoint.',
                'job_id' => 3,
                'created_at' => '2024-03-13 20:48:38',
                'updated_at' => '2024-11-20 08:59:56',
            ),
            267 => 
            array (
                'id' => 268,
                'descripcion' => 'Manejo de Excel.',
                'job_id' => 3,
                'created_at' => '2024-03-13 20:48:38',
                'updated_at' => '2024-11-20 08:59:56',
            ),
            268 => 
            array (
                'id' => 269,
            'descripcion' => 'Portales de servicios (combustible, uber, etc).',
                'job_id' => 3,
                'created_at' => '2024-03-13 20:48:38',
                'updated_at' => '2024-11-20 08:59:56',
            ),
            269 => 
            array (
                'id' => 270,
                'descripcion' => 'Banca electrónica.',
                'job_id' => 3,
                'created_at' => '2024-03-13 20:48:38',
                'updated_at' => '2024-11-20 08:59:56',
            ),
            270 => 
            array (
                'id' => 271,
                'descripcion' => 'Reportería.',
                'job_id' => 3,
                'created_at' => '2024-03-13 20:48:38',
                'updated_at' => '2024-11-20 08:59:56',
            ),
            271 => 
            array (
                'id' => 272,
                'descripcion' => 'Sin llenar',
                'job_id' => 3,
                'created_at' => '2024-03-13 20:48:38',
                'updated_at' => '2024-03-13 20:48:38',
            ),
            272 => 
            array (
                'id' => 273,
                'descripcion' => 'Análisis de costos.',
                'job_id' => 43,
                'created_at' => '2024-03-31 20:04:26',
                'updated_at' => '2024-11-15 07:03:08',
            ),
            273 => 
            array (
                'id' => 274,
                'descripcion' => 'Finanzas.',
                'job_id' => 43,
                'created_at' => '2024-03-31 20:04:26',
                'updated_at' => '2024-11-15 07:03:08',
            ),
            274 => 
            array (
                'id' => 275,
                'descripcion' => 'Excel avanzado.',
                'job_id' => 43,
                'created_at' => '2024-03-31 20:04:26',
                'updated_at' => '2024-11-15 07:03:08',
            ),
            275 => 
            array (
                'id' => 276,
                'descripcion' => 'Contabilidad.',
                'job_id' => 43,
                'created_at' => '2024-03-31 20:04:26',
                'updated_at' => '2024-11-15 07:03:08',
            ),
            276 => 
            array (
                'id' => 277,
                'descripcion' => 'Administración de proyectos.',
                'job_id' => 43,
                'created_at' => '2024-03-31 20:04:26',
                'updated_at' => '2024-11-15 07:03:08',
            ),
            277 => 
            array (
                'id' => 278,
                'descripcion' => 'Sin llenar',
                'job_id' => 43,
                'created_at' => '2024-03-31 20:04:26',
                'updated_at' => '2024-03-31 20:04:26',
            ),
            278 => 
            array (
                'id' => 279,
                'descripcion' => 'Sin llenar',
                'job_id' => 43,
                'created_at' => '2024-03-31 20:04:26',
                'updated_at' => '2024-03-31 20:04:26',
            ),
            279 => 
            array (
                'id' => 280,
                'descripcion' => 'Sin llenar',
                'job_id' => 43,
                'created_at' => '2024-03-31 20:04:26',
                'updated_at' => '2024-03-31 20:04:26',
            ),
            280 => 
            array (
                'id' => 281,
                'descripcion' => 'Costos administrativos.',
                'job_id' => 42,
                'created_at' => '2024-03-31 20:04:53',
                'updated_at' => '2024-11-19 09:05:11',
            ),
            281 => 
            array (
                'id' => 282,
                'descripcion' => 'Conocimientos en indirectos, nómina y obra en ejecución.',
                'job_id' => 42,
                'created_at' => '2024-03-31 20:04:53',
                'updated_at' => '2024-11-19 09:05:11',
            ),
            282 => 
            array (
                'id' => 283,
                'descripcion' => 'Elaboración de catálogos de conceptos.',
                'job_id' => 42,
                'created_at' => '2024-03-31 20:04:53',
                'updated_at' => '2024-11-19 09:05:11',
            ),
            283 => 
            array (
                'id' => 284,
                'descripcion' => 'Análisis de precios unitarios.',
                'job_id' => 42,
                'created_at' => '2024-03-31 20:04:53',
                'updated_at' => '2024-11-19 09:05:11',
            ),
            284 => 
            array (
                'id' => 285,
                'descripcion' => 'Costos y presupuestos de obras.',
                'job_id' => 42,
                'created_at' => '2024-03-31 20:04:53',
                'updated_at' => '2024-11-19 09:05:11',
            ),
            285 => 
            array (
                'id' => 286,
                'descripcion' => 'Elaboración de presupuestos.',
                'job_id' => 42,
                'created_at' => '2024-03-31 20:04:53',
                'updated_at' => '2024-11-19 09:05:11',
            ),
            286 => 
            array (
                'id' => 287,
                'descripcion' => 'Sin llenar',
                'job_id' => 42,
                'created_at' => '2024-03-31 20:04:53',
                'updated_at' => '2024-03-31 20:04:53',
            ),
            287 => 
            array (
                'id' => 288,
                'descripcion' => 'Sin llenar',
                'job_id' => 42,
                'created_at' => '2024-03-31 20:04:53',
                'updated_at' => '2024-03-31 20:04:53',
            ),
            288 => 
            array (
                'id' => 289,
                'descripcion' => 'Paquetería Office',
                'job_id' => 78,
                'created_at' => '2024-05-24 00:29:14',
                'updated_at' => '2024-05-26 20:14:07',
            ),
            289 => 
            array (
                'id' => 290,
                'descripcion' => 'Elaboración de reportes',
                'job_id' => 78,
                'created_at' => '2024-05-24 00:29:14',
                'updated_at' => '2024-05-26 20:14:07',
            ),
            290 => 
            array (
                'id' => 291,
                'descripcion' => 'Inglés intermedio',
                'job_id' => 78,
                'created_at' => '2024-05-24 00:29:14',
                'updated_at' => '2024-05-26 20:14:07',
            ),
            291 => 
            array (
                'id' => 292,
                'descripcion' => ' Ley Federal de Responsabilidades Administrativas de los Servidores Públicos ',
                'job_id' => 78,
                'created_at' => '2024-05-24 00:29:14',
                'updated_at' => '2024-05-26 20:14:07',
            ),
            292 => 
            array (
                'id' => 293,
                'descripcion' => 'Ley Federal del Trabajo ',
                'job_id' => 78,
                'created_at' => '2024-05-24 00:29:14',
                'updated_at' => '2024-05-26 20:14:07',
            ),
            293 => 
            array (
                'id' => 294,
                'descripcion' => 'Constitución de los Estados Unidos Mexicanos ',
                'job_id' => 78,
                'created_at' => '2024-05-24 00:29:14',
                'updated_at' => '2024-05-26 20:14:56',
            ),
            294 => 
            array (
                'id' => 295,
                'descripcion' => 'Ley General del Sistema Nacional Anticorrupción ',
                'job_id' => 78,
                'created_at' => '2024-05-24 00:29:14',
                'updated_at' => '2024-05-26 20:14:07',
            ),
            295 => 
            array (
                'id' => 296,
                'descripcion' => 'Ley General de Sociedades Mercantiles ',
                'job_id' => 78,
                'created_at' => '2024-05-24 00:29:14',
                'updated_at' => '2024-05-26 20:14:07',
            ),
            296 => 
            array (
                'id' => 297,
                'descripcion' => 'Avanzados en contabilidad general.',
                'job_id' => 46,
                'created_at' => '2024-05-30 20:36:58',
                'updated_at' => '2024-11-20 06:04:32',
            ),
            297 => 
            array (
                'id' => 298,
                'descripcion' => 'Solidos en facturación 4.0',
                'job_id' => 46,
                'created_at' => '2024-05-30 20:36:58',
                'updated_at' => '2024-11-20 06:04:32',
            ),
            298 => 
            array (
                'id' => 299,
                'descripcion' => 'Avanzados en impuestos de S.A.  De C.V',
                'job_id' => 46,
                'created_at' => '2024-05-30 20:36:58',
                'updated_at' => '2024-11-20 06:04:32',
            ),
            299 => 
            array (
                'id' => 300,
            'descripcion' => 'Software administrativo (COI y SAE).',
                'job_id' => 46,
                'created_at' => '2024-05-30 20:36:58',
                'updated_at' => '2024-11-20 06:04:32',
            ),
            300 => 
            array (
                'id' => 301,
                'descripcion' => 'Excel Intermedio.',
                'job_id' => 46,
                'created_at' => '2024-05-30 20:36:58',
                'updated_at' => '2024-11-20 06:04:32',
            ),
            301 => 
            array (
                'id' => 302,
                'descripcion' => 'Estructura de estados financieros.',
                'job_id' => 46,
                'created_at' => '2024-05-30 20:36:58',
                'updated_at' => '2024-11-20 06:04:32',
            ),
            302 => 
            array (
                'id' => 303,
                'descripcion' => 'Determinación de impuestos.',
                'job_id' => 46,
                'created_at' => '2024-05-30 20:36:58',
                'updated_at' => '2024-11-20 06:02:15',
            ),
            303 => 
            array (
                'id' => 304,
                'descripcion' => 'Sin llenar',
                'job_id' => 46,
                'created_at' => '2024-05-30 20:36:58',
                'updated_at' => '2024-05-30 20:36:58',
            ),
            304 => 
            array (
                'id' => 305,
                'descripcion' => 'Obligaciones en materia de capacitación ante la STPS.',
                'job_id' => 45,
                'created_at' => '2024-05-30 20:38:44',
                'updated_at' => '2024-11-25 04:23:55',
            ),
            305 => 
            array (
                'id' => 306,
                'descripcion' => 'Entrevistas por competencias.',
                'job_id' => 45,
                'created_at' => '2024-05-30 20:38:44',
                'updated_at' => '2024-11-25 04:23:55',
            ),
            306 => 
            array (
                'id' => 307,
                'descripcion' => 'REPSE.',
                'job_id' => 45,
                'created_at' => '2024-05-30 20:38:44',
                'updated_at' => '2024-11-25 04:23:55',
            ),
            307 => 
            array (
                'id' => 308,
                'descripcion' => 'Pruebas psicométricas.',
                'job_id' => 45,
                'created_at' => '2024-05-30 20:38:44',
                'updated_at' => '2024-11-25 04:23:55',
            ),
            308 => 
            array (
                'id' => 309,
            'descripcion' => 'Nóminas(salarios fijos, variables y en especie).',
                'job_id' => 45,
                'created_at' => '2024-05-30 20:38:44',
                'updated_at' => '2024-11-25 04:23:55',
            ),
            309 => 
            array (
                'id' => 310,
                'descripcion' => 'Ley Federal de Trabajo.',
                'job_id' => 45,
                'created_at' => '2024-05-30 20:38:44',
                'updated_at' => '2024-11-25 04:23:55',
            ),
            310 => 
            array (
                'id' => 311,
                'descripcion' => 'Valuación de puestos.',
                'job_id' => 45,
                'created_at' => '2024-05-30 20:38:44',
                'updated_at' => '2024-11-25 04:23:55',
            ),
            311 => 
            array (
                'id' => 312,
                'descripcion' => 'Sin llenar',
                'job_id' => 45,
                'created_at' => '2024-05-30 20:38:44',
                'updated_at' => '2024-05-30 20:38:44',
            ),
            312 => 
            array (
                'id' => 313,
                'descripcion' => 'Sin llenar',
                'job_id' => 79,
                'created_at' => '2024-05-30 20:39:08',
                'updated_at' => '2024-05-30 20:39:08',
            ),
            313 => 
            array (
                'id' => 314,
                'descripcion' => 'Sin llenar',
                'job_id' => 79,
                'created_at' => '2024-05-30 20:39:08',
                'updated_at' => '2024-05-30 20:39:08',
            ),
            314 => 
            array (
                'id' => 315,
                'descripcion' => 'Sin llenar',
                'job_id' => 79,
                'created_at' => '2024-05-30 20:39:08',
                'updated_at' => '2024-05-30 20:39:08',
            ),
            315 => 
            array (
                'id' => 316,
                'descripcion' => 'Sin llenar',
                'job_id' => 79,
                'created_at' => '2024-05-30 20:39:08',
                'updated_at' => '2024-05-30 20:39:08',
            ),
            316 => 
            array (
                'id' => 317,
                'descripcion' => 'Sin llenar',
                'job_id' => 79,
                'created_at' => '2024-05-30 20:39:08',
                'updated_at' => '2024-05-30 20:39:08',
            ),
            317 => 
            array (
                'id' => 318,
                'descripcion' => 'Sin llenar',
                'job_id' => 79,
                'created_at' => '2024-05-30 20:39:08',
                'updated_at' => '2024-05-30 20:39:08',
            ),
            318 => 
            array (
                'id' => 319,
                'descripcion' => 'Sin llenar',
                'job_id' => 79,
                'created_at' => '2024-05-30 20:39:08',
                'updated_at' => '2024-05-30 20:39:08',
            ),
            319 => 
            array (
                'id' => 320,
                'descripcion' => 'Sin llenar',
                'job_id' => 79,
                'created_at' => '2024-05-30 20:39:08',
                'updated_at' => '2024-05-30 20:39:08',
            ),
            320 => 
            array (
                'id' => 321,
                'descripcion' => 'Sin llenar',
                'job_id' => 80,
                'created_at' => '2024-05-30 20:39:21',
                'updated_at' => '2024-05-30 20:39:21',
            ),
            321 => 
            array (
                'id' => 322,
                'descripcion' => 'Sin llenar',
                'job_id' => 80,
                'created_at' => '2024-05-30 20:39:21',
                'updated_at' => '2024-05-30 20:39:21',
            ),
            322 => 
            array (
                'id' => 323,
                'descripcion' => 'Sin llenar',
                'job_id' => 80,
                'created_at' => '2024-05-30 20:39:21',
                'updated_at' => '2024-05-30 20:39:21',
            ),
            323 => 
            array (
                'id' => 324,
                'descripcion' => 'Sin llenar',
                'job_id' => 80,
                'created_at' => '2024-05-30 20:39:21',
                'updated_at' => '2024-05-30 20:39:21',
            ),
            324 => 
            array (
                'id' => 325,
                'descripcion' => 'Sin llenar',
                'job_id' => 80,
                'created_at' => '2024-05-30 20:39:21',
                'updated_at' => '2024-05-30 20:39:21',
            ),
            325 => 
            array (
                'id' => 326,
                'descripcion' => 'Sin llenar',
                'job_id' => 80,
                'created_at' => '2024-05-30 20:39:21',
                'updated_at' => '2024-05-30 20:39:21',
            ),
            326 => 
            array (
                'id' => 327,
                'descripcion' => 'Sin llenar',
                'job_id' => 80,
                'created_at' => '2024-05-30 20:39:21',
                'updated_at' => '2024-05-30 20:39:21',
            ),
            327 => 
            array (
                'id' => 328,
                'descripcion' => 'Sin llenar',
                'job_id' => 80,
                'created_at' => '2024-05-30 20:39:21',
                'updated_at' => '2024-05-30 20:39:21',
            ),
            328 => 
            array (
                'id' => 329,
                'descripcion' => 'Sin llenar',
                'job_id' => 81,
                'created_at' => '2024-05-30 20:39:38',
                'updated_at' => '2024-05-30 20:39:38',
            ),
            329 => 
            array (
                'id' => 330,
                'descripcion' => 'Sin llenar',
                'job_id' => 81,
                'created_at' => '2024-05-30 20:39:38',
                'updated_at' => '2024-05-30 20:39:38',
            ),
            330 => 
            array (
                'id' => 331,
                'descripcion' => 'Sin llenar',
                'job_id' => 81,
                'created_at' => '2024-05-30 20:39:38',
                'updated_at' => '2024-05-30 20:39:38',
            ),
            331 => 
            array (
                'id' => 332,
                'descripcion' => 'Sin llenar',
                'job_id' => 81,
                'created_at' => '2024-05-30 20:39:38',
                'updated_at' => '2024-05-30 20:39:38',
            ),
            332 => 
            array (
                'id' => 333,
                'descripcion' => 'Sin llenar',
                'job_id' => 81,
                'created_at' => '2024-05-30 20:39:38',
                'updated_at' => '2024-05-30 20:39:38',
            ),
            333 => 
            array (
                'id' => 334,
                'descripcion' => 'Sin llenar',
                'job_id' => 81,
                'created_at' => '2024-05-30 20:39:38',
                'updated_at' => '2024-05-30 20:39:38',
            ),
            334 => 
            array (
                'id' => 335,
                'descripcion' => 'Sin llenar',
                'job_id' => 81,
                'created_at' => '2024-05-30 20:39:38',
                'updated_at' => '2024-05-30 20:39:38',
            ),
            335 => 
            array (
                'id' => 336,
                'descripcion' => 'Sin llenar',
                'job_id' => 81,
                'created_at' => '2024-05-30 20:39:38',
                'updated_at' => '2024-05-30 20:39:38',
            ),
            336 => 
            array (
                'id' => 337,
                'descripcion' => 'Equipos y Herramientas.',
                'job_id' => 25,
                'created_at' => '2024-06-02 21:43:09',
                'updated_at' => '2024-11-25 03:35:31',
            ),
            337 => 
            array (
                'id' => 338,
                'descripcion' => 'Mantenimiento Preventivo y Correctivo.',
                'job_id' => 25,
                'created_at' => '2024-06-02 21:43:09',
                'updated_at' => '2024-11-25 03:35:31',
            ),
            338 => 
            array (
                'id' => 339,
                'descripcion' => 'Conocimiento Técnico de Materiales.',
                'job_id' => 25,
                'created_at' => '2024-06-02 21:43:09',
                'updated_at' => '2024-11-25 03:35:31',
            ),
            339 => 
            array (
                'id' => 340,
                'descripcion' => 'Lectura e Interpretación de Planos.',
                'job_id' => 25,
                'created_at' => '2024-06-02 21:43:09',
                'updated_at' => '2024-11-25 03:35:31',
            ),
            340 => 
            array (
                'id' => 341,
                'descripcion' => 'Ensayos Básicos y Gestión de documentación.',
                'job_id' => 25,
                'created_at' => '2024-06-02 21:43:09',
                'updated_at' => '2024-11-25 03:50:21',
            ),
            341 => 
            array (
                'id' => 342,
                'descripcion' => 'Normas, Procedimientos gestión de seguridad.',
                'job_id' => 25,
                'created_at' => '2024-06-02 21:43:09',
                'updated_at' => '2024-11-25 03:50:21',
            ),
            342 => 
            array (
                'id' => 343,
                'descripcion' => 'Operación Básica.',
                'job_id' => 25,
                'created_at' => '2024-06-02 21:43:09',
                'updated_at' => '2024-11-25 03:35:31',
            ),
            343 => 
            array (
                'id' => 344,
                'descripcion' => 'Inspección visual.',
                'job_id' => 25,
                'created_at' => '2024-06-02 21:43:09',
                'updated_at' => '2024-11-25 03:50:21',
            ),
            344 => 
            array (
                'id' => 345,
                'descripcion' => 'ISO 14001:2015, 9001:2015, 45001:2018 37001:2016.',
                'job_id' => 82,
                'created_at' => '2024-06-10 04:23:32',
                'updated_at' => '2024-11-20 06:33:24',
            ),
            345 => 
            array (
                'id' => 346,
                'descripcion' => 'Procesos de auditorias ISO 19011:2018.',
                'job_id' => 82,
                'created_at' => '2024-06-10 04:23:32',
                'updated_at' => '2024-11-20 06:33:24',
            ),
            346 => 
            array (
                'id' => 347,
                'descripcion' => 'Mapeo de procesos.',
                'job_id' => 82,
                'created_at' => '2024-06-10 04:23:32',
                'updated_at' => '2024-11-20 06:33:24',
            ),
            347 => 
            array (
                'id' => 348,
            'descripcion' => 'Normativas STPS (aplicable).',
                'job_id' => 82,
                'created_at' => '2024-06-10 04:23:32',
                'updated_at' => '2024-11-20 06:33:24',
            ),
            348 => 
            array (
                'id' => 349,
                'descripcion' => 'Manejo de no conformidades.',
                'job_id' => 82,
                'created_at' => '2024-06-10 04:23:32',
                'updated_at' => '2024-11-20 06:33:24',
            ),
            349 => 
            array (
                'id' => 350,
                'descripcion' => 'Paquetería Office.',
                'job_id' => 82,
                'created_at' => '2024-06-10 04:23:32',
                'updated_at' => '2024-11-20 06:33:24',
            ),
            350 => 
            array (
                'id' => 351,
                'descripcion' => 'Ingeniería de Procesos.',
                'job_id' => 82,
                'created_at' => '2024-06-10 04:23:32',
                'updated_at' => '2024-11-20 06:33:24',
            ),
            351 => 
            array (
                'id' => 352,
            'descripcion' => 'Ingeniería de Indicadores de Rendimiento (KPI´s).',
                'job_id' => 82,
                'created_at' => '2024-06-10 04:23:32',
                'updated_at' => '2024-11-20 06:33:24',
            ),
            352 => 
            array (
                'id' => 353,
                'descripcion' => 'Gestión de proyectos.',
                'job_id' => 83,
                'created_at' => '2024-07-03 03:51:09',
                'updated_at' => '2024-11-19 04:38:26',
            ),
            353 => 
            array (
                'id' => 354,
                'descripcion' => 'Obra civil.',
                'job_id' => 83,
                'created_at' => '2024-07-03 03:51:09',
                'updated_at' => '2024-11-19 04:38:26',
            ),
            354 => 
            array (
                'id' => 355,
                'descripcion' => 'Servicios de Hot Tapping & Line Stopping',
                'job_id' => 83,
                'created_at' => '2024-07-03 03:51:09',
                'updated_at' => '2024-11-19 04:38:26',
            ),
            355 => 
            array (
                'id' => 356,
                'descripcion' => 'Servicios de Onshore y Offshore',
                'job_id' => 83,
                'created_at' => '2024-07-03 03:51:09',
                'updated_at' => '2024-11-19 04:38:26',
            ),
            356 => 
            array (
                'id' => 357,
                'descripcion' => 'Control documental.',
                'job_id' => 83,
                'created_at' => '2024-07-03 03:51:09',
                'updated_at' => '2024-11-19 04:38:26',
            ),
            357 => 
            array (
                'id' => 358,
                'descripcion' => 'Sin llenar',
                'job_id' => 83,
                'created_at' => '2024-07-03 03:51:09',
                'updated_at' => '2024-07-03 03:51:09',
            ),
            358 => 
            array (
                'id' => 359,
                'descripcion' => 'Sin llenar',
                'job_id' => 83,
                'created_at' => '2024-07-03 03:51:09',
                'updated_at' => '2024-07-03 03:51:09',
            ),
            359 => 
            array (
                'id' => 360,
                'descripcion' => 'Sin llenar',
                'job_id' => 83,
                'created_at' => '2024-07-03 03:51:09',
                'updated_at' => '2024-07-03 03:51:09',
            ),
            360 => 
            array (
                'id' => 361,
                'descripcion' => 'Seguros y fianzas.',
                'job_id' => 84,
                'created_at' => '2024-07-25 05:00:55',
                'updated_at' => '2024-11-25 04:41:59',
            ),
            361 => 
            array (
                'id' => 362,
                'descripcion' => 'REPSE.',
                'job_id' => 84,
                'created_at' => '2024-07-25 05:00:55',
                'updated_at' => '2024-11-25 04:41:59',
            ),
            362 => 
            array (
                'id' => 363,
                'descripcion' => 'Excel avanzado.',
                'job_id' => 84,
                'created_at' => '2024-07-25 05:00:55',
                'updated_at' => '2024-11-14 09:14:41',
            ),
            363 => 
            array (
                'id' => 364,
                'descripcion' => 'Administración de Proyectos.',
                'job_id' => 84,
                'created_at' => '2024-07-25 05:00:55',
                'updated_at' => '2024-11-25 04:41:59',
            ),
            364 => 
            array (
                'id' => 365,
                'descripcion' => 'Negociación.',
                'job_id' => 84,
                'created_at' => '2024-07-25 05:00:55',
                'updated_at' => '2024-11-25 04:41:59',
            ),
            365 => 
            array (
                'id' => 366,
                'descripcion' => 'Trato al cliente.',
                'job_id' => 84,
                'created_at' => '2024-07-25 05:00:55',
                'updated_at' => '2024-11-25 04:41:59',
            ),
            366 => 
            array (
                'id' => 367,
                'descripcion' => 'Análisis de Costos.',
                'job_id' => 84,
                'created_at' => '2024-07-25 05:00:55',
                'updated_at' => '2024-11-25 04:41:59',
            ),
            367 => 
            array (
                'id' => 368,
                'descripcion' => 'Sin llenar',
                'job_id' => 84,
                'created_at' => '2024-07-25 05:00:55',
                'updated_at' => '2024-07-25 05:00:55',
            ),
            368 => 
            array (
                'id' => 369,
                'descripcion' => 'Sin llenar',
                'job_id' => 85,
                'created_at' => '2024-08-19 07:36:51',
                'updated_at' => '2024-08-19 07:36:51',
            ),
            369 => 
            array (
                'id' => 370,
                'descripcion' => 'Sin llenar',
                'job_id' => 85,
                'created_at' => '2024-08-19 07:36:51',
                'updated_at' => '2024-08-19 07:36:51',
            ),
            370 => 
            array (
                'id' => 371,
                'descripcion' => 'Sin llenar',
                'job_id' => 85,
                'created_at' => '2024-08-19 07:36:51',
                'updated_at' => '2024-08-19 07:36:51',
            ),
            371 => 
            array (
                'id' => 372,
                'descripcion' => 'Sin llenar',
                'job_id' => 85,
                'created_at' => '2024-08-19 07:36:51',
                'updated_at' => '2024-08-19 07:36:51',
            ),
            372 => 
            array (
                'id' => 373,
                'descripcion' => 'Sin llenar',
                'job_id' => 85,
                'created_at' => '2024-08-19 07:36:51',
                'updated_at' => '2024-08-19 07:36:51',
            ),
            373 => 
            array (
                'id' => 374,
                'descripcion' => 'Sin llenar',
                'job_id' => 85,
                'created_at' => '2024-08-19 07:36:51',
                'updated_at' => '2024-08-19 07:36:51',
            ),
            374 => 
            array (
                'id' => 375,
                'descripcion' => 'Sin llenar',
                'job_id' => 85,
                'created_at' => '2024-08-19 07:36:51',
                'updated_at' => '2024-08-19 07:36:51',
            ),
            375 => 
            array (
                'id' => 376,
                'descripcion' => 'Sin llenar',
                'job_id' => 85,
                'created_at' => '2024-08-19 07:36:51',
                'updated_at' => '2024-08-19 07:36:51',
            ),
            376 => 
            array (
                'id' => 377,
                'descripcion' => 'Sistemas de Gestión Integrales.',
                'job_id' => 86,
                'created_at' => '2024-08-19 07:55:15',
                'updated_at' => '2024-10-17 03:44:06',
            ),
            377 => 
            array (
                'id' => 378,
                'descripcion' => 'ISO 14001:2015, 9001:2015, 45001:2018.',
                'job_id' => 86,
                'created_at' => '2024-08-19 07:55:15',
                'updated_at' => '2024-10-17 03:44:06',
            ),
            378 => 
            array (
                'id' => 379,
                'descripcion' => 'Procesos de auditorias.',
                'job_id' => 86,
                'created_at' => '2024-08-19 07:55:15',
                'updated_at' => '2024-10-17 03:44:06',
            ),
            379 => 
            array (
                'id' => 380,
                'descripcion' => 'Manejo de no conformidades.',
                'job_id' => 86,
                'created_at' => '2024-08-19 07:55:15',
                'updated_at' => '2024-10-17 03:44:06',
            ),
            380 => 
            array (
                'id' => 381,
                'descripcion' => 'Planeación y control organizacional',
                'job_id' => 86,
                'created_at' => '2024-08-19 07:55:15',
                'updated_at' => '2025-07-17 04:26:47',
            ),
            381 => 
            array (
                'id' => 382,
                'descripcion' => 'Gestión de proyectos.',
                'job_id' => 86,
                'created_at' => '2024-08-19 07:55:15',
                'updated_at' => '2025-07-17 04:24:06',
            ),
            382 => 
            array (
                'id' => 383,
                'descripcion' => 'Interpretación de planos, especificaciones técnicas y normas.',
                'job_id' => 86,
                'created_at' => '2024-08-19 07:55:15',
                'updated_at' => '2025-07-17 04:24:06',
            ),
            383 => 
            array (
                'id' => 384,
                'descripcion' => 'Planeación y control de la producción.',
                'job_id' => 86,
                'created_at' => '2024-08-19 07:55:15',
                'updated_at' => '2025-07-17 04:24:06',
            ),
            384 => 
            array (
                'id' => 385,
                'descripcion' => 'Proceso de importación.',
                'job_id' => 87,
                'created_at' => '2024-08-28 06:24:45',
                'updated_at' => '2024-11-20 08:50:35',
            ),
            385 => 
            array (
                'id' => 386,
            'descripcion' => 'ERP (Satech).',
                'job_id' => 87,
                'created_at' => '2024-08-28 06:24:45',
                'updated_at' => '2024-11-20 08:50:35',
            ),
            386 => 
            array (
                'id' => 387,
                'descripcion' => 'Cotizaciones.',
                'job_id' => 87,
                'created_at' => '2024-08-28 06:24:45',
                'updated_at' => '2024-11-20 08:50:35',
            ),
            387 => 
            array (
                'id' => 388,
                'descripcion' => 'Negociación.',
                'job_id' => 87,
                'created_at' => '2024-08-28 06:24:45',
                'updated_at' => '2024-11-20 08:50:35',
            ),
            388 => 
            array (
                'id' => 389,
                'descripcion' => 'Evaluación de proveedores.',
                'job_id' => 87,
                'created_at' => '2024-08-28 06:24:45',
                'updated_at' => '2024-11-20 08:50:35',
            ),
            389 => 
            array (
                'id' => 390,
                'descripcion' => 'Ahorros.',
                'job_id' => 87,
                'created_at' => '2024-08-28 06:24:45',
                'updated_at' => '2024-11-20 08:50:35',
            ),
            390 => 
            array (
                'id' => 391,
                'descripcion' => 'Toma de decisiones basadas en métricas.',
                'job_id' => 87,
                'created_at' => '2024-08-28 06:24:45',
                'updated_at' => '2024-11-20 08:50:35',
            ),
            391 => 
            array (
                'id' => 392,
                'descripcion' => 'Sin llenar',
                'job_id' => 87,
                'created_at' => '2024-08-28 06:24:45',
                'updated_at' => '2024-08-28 06:24:45',
            ),
            392 => 
            array (
                'id' => 393,
                'descripcion' => 'Obra civil.',
                'job_id' => 88,
                'created_at' => '2024-08-28 06:28:34',
                'updated_at' => '2024-11-19 05:47:06',
            ),
            393 => 
            array (
                'id' => 394,
                'descripcion' => 'Metodología PMI.',
                'job_id' => 88,
                'created_at' => '2024-08-28 06:28:34',
                'updated_at' => '2024-11-19 05:47:06',
            ),
            394 => 
            array (
                'id' => 395,
                'descripcion' => 'Integridad de ductos.',
                'job_id' => 88,
                'created_at' => '2024-08-28 06:28:34',
                'updated_at' => '2024-11-19 05:47:06',
            ),
            395 => 
            array (
                'id' => 396,
                'descripcion' => 'Análisis de precios unitarios.',
                'job_id' => 88,
                'created_at' => '2024-08-28 06:28:34',
                'updated_at' => '2024-11-19 05:47:06',
            ),
            396 => 
            array (
                'id' => 397,
                'descripcion' => 'Normatividad ASEA, ASME, API Y otras apicables.',
                'job_id' => 88,
                'created_at' => '2024-08-28 06:28:34',
                'updated_at' => '2024-11-19 05:47:06',
            ),
            397 => 
            array (
                'id' => 398,
                'descripcion' => 'Servicios de Hot Tapping & Line Stopping.',
                'job_id' => 88,
                'created_at' => '2024-08-28 06:28:34',
                'updated_at' => '2024-11-19 05:47:06',
            ),
            398 => 
            array (
                'id' => 399,
                'descripcion' => 'Servicios de Onshore Y Offshore.',
                'job_id' => 88,
                'created_at' => '2024-08-28 06:28:34',
                'updated_at' => '2024-11-19 05:47:06',
            ),
            399 => 
            array (
                'id' => 400,
                'descripcion' => 'Sin llenar',
                'job_id' => 88,
                'created_at' => '2024-08-28 06:28:34',
                'updated_at' => '2024-08-28 06:28:34',
            ),
            400 => 
            array (
                'id' => 401,
                'descripcion' => 'Sin llenar',
                'job_id' => 89,
                'created_at' => '2024-08-28 06:31:04',
                'updated_at' => '2024-08-28 06:31:04',
            ),
            401 => 
            array (
                'id' => 402,
                'descripcion' => 'Sin llenar',
                'job_id' => 89,
                'created_at' => '2024-08-28 06:31:04',
                'updated_at' => '2024-08-28 06:31:04',
            ),
            402 => 
            array (
                'id' => 403,
                'descripcion' => 'Sin llenar',
                'job_id' => 89,
                'created_at' => '2024-08-28 06:31:04',
                'updated_at' => '2024-08-28 06:31:04',
            ),
            403 => 
            array (
                'id' => 404,
                'descripcion' => 'Sin llenar',
                'job_id' => 89,
                'created_at' => '2024-08-28 06:31:04',
                'updated_at' => '2024-08-28 06:31:04',
            ),
            404 => 
            array (
                'id' => 405,
                'descripcion' => 'Sin llenar',
                'job_id' => 89,
                'created_at' => '2024-08-28 06:31:04',
                'updated_at' => '2024-08-28 06:31:04',
            ),
            405 => 
            array (
                'id' => 406,
                'descripcion' => 'Sin llenar',
                'job_id' => 89,
                'created_at' => '2024-08-28 06:31:04',
                'updated_at' => '2024-08-28 06:31:04',
            ),
            406 => 
            array (
                'id' => 407,
                'descripcion' => 'Sin llenar',
                'job_id' => 89,
                'created_at' => '2024-08-28 06:31:04',
                'updated_at' => '2024-08-28 06:31:04',
            ),
            407 => 
            array (
                'id' => 408,
                'descripcion' => 'Sin llenar',
                'job_id' => 89,
                'created_at' => '2024-08-28 06:31:04',
                'updated_at' => '2024-08-28 06:31:04',
            ),
            408 => 
            array (
                'id' => 409,
                'descripcion' => 'Sin llenar',
                'job_id' => 90,
                'created_at' => '2024-08-28 06:35:43',
                'updated_at' => '2024-08-28 06:35:43',
            ),
            409 => 
            array (
                'id' => 410,
                'descripcion' => 'Sin llenar',
                'job_id' => 90,
                'created_at' => '2024-08-28 06:35:43',
                'updated_at' => '2024-08-28 06:35:43',
            ),
            410 => 
            array (
                'id' => 411,
                'descripcion' => 'Sin llenar',
                'job_id' => 90,
                'created_at' => '2024-08-28 06:35:43',
                'updated_at' => '2024-08-28 06:35:43',
            ),
            411 => 
            array (
                'id' => 412,
                'descripcion' => 'Sin llenar',
                'job_id' => 90,
                'created_at' => '2024-08-28 06:35:43',
                'updated_at' => '2024-08-28 06:35:43',
            ),
            412 => 
            array (
                'id' => 413,
                'descripcion' => 'Sin llenar',
                'job_id' => 90,
                'created_at' => '2024-08-28 06:35:43',
                'updated_at' => '2024-08-28 06:35:43',
            ),
            413 => 
            array (
                'id' => 414,
                'descripcion' => 'Sin llenar',
                'job_id' => 90,
                'created_at' => '2024-08-28 06:35:43',
                'updated_at' => '2024-08-28 06:35:43',
            ),
            414 => 
            array (
                'id' => 415,
                'descripcion' => 'Sin llenar',
                'job_id' => 90,
                'created_at' => '2024-08-28 06:35:43',
                'updated_at' => '2024-08-28 06:35:43',
            ),
            415 => 
            array (
                'id' => 416,
                'descripcion' => 'Sin llenar',
                'job_id' => 90,
                'created_at' => '2024-08-28 06:35:43',
                'updated_at' => '2024-08-28 06:35:43',
            ),
            416 => 
            array (
                'id' => 417,
                'descripcion' => 'Metodología PMI.',
                'job_id' => 91,
                'created_at' => '2024-08-28 06:39:51',
                'updated_at' => '2024-11-20 06:29:09',
            ),
            417 => 
            array (
                'id' => 418,
                'descripcion' => 'Servicios y Mecánica  de Hot Tapping & Line Stopping.',
                'job_id' => 91,
                'created_at' => '2024-08-28 06:39:51',
                'updated_at' => '2024-11-20 06:29:09',
            ),
            418 => 
            array (
                'id' => 419,
                'descripcion' => 'Integridad de Ductos',
                'job_id' => 91,
                'created_at' => '2024-08-28 06:39:51',
                'updated_at' => '2024-11-20 06:29:09',
            ),
            419 => 
            array (
                'id' => 420,
                'descripcion' => 'Conocimiento del sector OiI & Gas.',
                'job_id' => 91,
                'created_at' => '2024-08-28 06:39:51',
                'updated_at' => '2024-11-20 06:29:09',
            ),
            420 => 
            array (
                'id' => 421,
            'descripcion' => 'Soldadura (básico y teórico).',
                'job_id' => 91,
                'created_at' => '2024-08-28 06:39:51',
                'updated_at' => '2024-11-20 06:29:09',
            ),
            421 => 
            array (
                'id' => 422,
                'descripcion' => 'Ingeniería de Costos Industriales.',
                'job_id' => 91,
                'created_at' => '2024-08-28 06:39:51',
                'updated_at' => '2024-11-20 06:29:09',
            ),
            422 => 
            array (
                'id' => 423,
                'descripcion' => 'Procesos de Investigación Documental y Tecnológico.',
                'job_id' => 91,
                'created_at' => '2024-08-28 06:39:51',
                'updated_at' => '2024-11-20 06:29:09',
            ),
            423 => 
            array (
                'id' => 424,
            'descripcion' => 'Regulación energética (emisión de gases)',
                'job_id' => 91,
                'created_at' => '2024-08-28 06:39:51',
                'updated_at' => '2024-11-20 06:29:09',
            ),
            424 => 
            array (
                'id' => 425,
                'descripcion' => 'Procesos de manufactura.',
                'job_id' => 92,
                'created_at' => '2024-08-28 06:51:55',
                'updated_at' => '2024-11-25 03:13:12',
            ),
            425 => 
            array (
                'id' => 426,
                'descripcion' => 'Mecánica, Hidráulica, Neumática.',
                'job_id' => 92,
                'created_at' => '2024-08-28 06:51:55',
                'updated_at' => '2024-11-25 03:13:12',
            ),
            426 => 
            array (
                'id' => 427,
                'descripcion' => 'Normatividad ASEA, ASME, API.',
                'job_id' => 92,
                'created_at' => '2024-08-28 06:51:55',
                'updated_at' => '2024-11-25 03:13:12',
            ),
            427 => 
            array (
                'id' => 428,
                'descripcion' => 'Simuladores.',
                'job_id' => 92,
                'created_at' => '2024-08-28 06:51:55',
                'updated_at' => '2024-11-25 03:13:12',
            ),
            428 => 
            array (
                'id' => 429,
                'descripcion' => 'Manejo de software de diseño mecánico- Solidworks.',
                'job_id' => 92,
                'created_at' => '2024-08-28 06:51:55',
                'updated_at' => '2024-11-25 03:13:12',
            ),
            429 => 
            array (
                'id' => 430,
                'descripcion' => 'Integridad de ductos.',
                'job_id' => 92,
                'created_at' => '2024-08-28 06:51:55',
                'updated_at' => '2024-11-25 03:13:12',
            ),
            430 => 
            array (
                'id' => 431,
                'descripcion' => 'Análisis de costo.',
                'job_id' => 92,
                'created_at' => '2024-08-28 06:51:55',
                'updated_at' => '2024-11-25 03:13:12',
            ),
            431 => 
            array (
                'id' => 432,
                'descripcion' => 'Sin llenar',
                'job_id' => 92,
                'created_at' => '2024-08-28 06:51:55',
                'updated_at' => '2024-08-28 06:51:55',
            ),
            432 => 
            array (
                'id' => 433,
                'descripcion' => 'Sustancias Químicas Peligrosas.',
                'job_id' => 33,
                'created_at' => '2024-10-16 05:34:45',
                'updated_at' => '2024-11-25 04:02:06',
            ),
            433 => 
            array (
                'id' => 434,
            'descripcion' => 'Inspección de piezas (Deseable)',
                'job_id' => 33,
                'created_at' => '2024-10-16 05:34:45',
                'updated_at' => '2025-08-27 03:56:22',
            ),
            434 => 
            array (
                'id' => 435,
                'descripcion' => 'Procesos de manufactura.',
                'job_id' => 33,
                'created_at' => '2024-10-16 05:34:45',
                'updated_at' => '2024-11-25 04:02:06',
            ),
            435 => 
            array (
                'id' => 436,
            'descripcion' => 'Mantenimiento preventivo de maquinas y herramientas (Deseable)',
                'job_id' => 33,
                'created_at' => '2024-10-16 05:34:45',
                'updated_at' => '2025-08-27 03:56:22',
            ),
            436 => 
            array (
                'id' => 437,
            'descripcion' => 'Mecánica (básica).',
                'job_id' => 33,
                'created_at' => '2024-10-16 05:34:45',
                'updated_at' => '2024-11-25 04:02:06',
            ),
            437 => 
            array (
                'id' => 438,
            'descripcion' => 'Manejo de instrumentos de medición (Deseable)',
                'job_id' => 33,
                'created_at' => '2024-10-16 05:34:45',
                'updated_at' => '2025-08-27 03:56:22',
            ),
            438 => 
            array (
                'id' => 439,
            'descripcion' => 'Herramientas utilizadas para operación de maquinas-herramientas (básicas).',
                'job_id' => 33,
                'created_at' => '2024-10-16 05:34:45',
                'updated_at' => '2024-11-25 04:02:06',
            ),
            439 => 
            array (
                'id' => 440,
                'descripcion' => 'Paquetería Office.',
                'job_id' => 33,
                'created_at' => '2024-10-16 05:34:45',
                'updated_at' => '2025-08-27 03:56:22',
            ),
            440 => 
            array (
                'id' => 441,
                'descripcion' => 'Sin llenar',
                'job_id' => 54,
                'created_at' => '2024-10-24 07:43:11',
                'updated_at' => '2024-10-24 07:43:11',
            ),
            441 => 
            array (
                'id' => 442,
                'descripcion' => 'Sin llenar',
                'job_id' => 54,
                'created_at' => '2024-10-24 07:43:11',
                'updated_at' => '2024-10-24 07:43:11',
            ),
            442 => 
            array (
                'id' => 443,
                'descripcion' => 'Sin llenar',
                'job_id' => 54,
                'created_at' => '2024-10-24 07:43:11',
                'updated_at' => '2024-10-24 07:43:11',
            ),
            443 => 
            array (
                'id' => 444,
                'descripcion' => 'Sin llenar',
                'job_id' => 54,
                'created_at' => '2024-10-24 07:43:11',
                'updated_at' => '2024-10-24 07:43:11',
            ),
            444 => 
            array (
                'id' => 445,
                'descripcion' => 'Sin llenar',
                'job_id' => 54,
                'created_at' => '2024-10-24 07:43:11',
                'updated_at' => '2024-10-24 07:43:11',
            ),
            445 => 
            array (
                'id' => 446,
                'descripcion' => 'Sin llenar',
                'job_id' => 54,
                'created_at' => '2024-10-24 07:43:11',
                'updated_at' => '2024-10-24 07:43:11',
            ),
            446 => 
            array (
                'id' => 447,
                'descripcion' => 'Sin llenar',
                'job_id' => 54,
                'created_at' => '2024-10-24 07:43:11',
                'updated_at' => '2024-10-24 07:43:11',
            ),
            447 => 
            array (
                'id' => 448,
                'descripcion' => 'Sin llenar',
                'job_id' => 54,
                'created_at' => '2024-10-24 07:43:11',
                'updated_at' => '2024-10-24 07:43:11',
            ),
            448 => 
            array (
                'id' => 449,
            'descripcion' => 'Inglés (capaz de mantener conversaciones).',
                'job_id' => 93,
                'created_at' => '2024-11-05 04:56:39',
                'updated_at' => '2024-11-26 09:00:14',
            ),
            449 => 
            array (
                'id' => 450,
                'descripcion' => 'Soldadura especializada.',
                'job_id' => 93,
                'created_at' => '2024-11-05 04:56:39',
                'updated_at' => '2024-11-26 09:00:14',
            ),
            450 => 
            array (
                'id' => 451,
                'descripcion' => 'Sector Energético y la industria de Oil & Gas.',
                'job_id' => 93,
                'created_at' => '2024-11-05 04:56:39',
                'updated_at' => '2024-11-26 09:00:14',
            ),
            451 => 
            array (
                'id' => 452,
                'descripcion' => 'Válvulas.',
                'job_id' => 93,
                'created_at' => '2024-11-05 04:56:39',
                'updated_at' => '2024-11-26 09:00:14',
            ),
            452 => 
            array (
                'id' => 453,
                'descripcion' => 'Servicios de Hot Tapping & Line Stopping..',
                'job_id' => 93,
                'created_at' => '2024-11-05 04:56:39',
                'updated_at' => '2024-11-26 09:00:14',
            ),
            453 => 
            array (
                'id' => 454,
                'descripcion' => 'Soldadura.',
                'job_id' => 93,
                'created_at' => '2024-11-05 04:56:39',
                'updated_at' => '2024-11-26 09:00:14',
            ),
            454 => 
            array (
                'id' => 455,
                'descripcion' => 'Integridad de ductos.',
                'job_id' => 93,
                'created_at' => '2024-11-05 04:56:39',
                'updated_at' => '2024-11-26 09:00:14',
            ),
            455 => 
            array (
                'id' => 456,
                'descripcion' => 'Sin llenar',
                'job_id' => 93,
                'created_at' => '2024-11-05 04:56:39',
                'updated_at' => '2024-11-05 04:56:39',
            ),
            456 => 
            array (
                'id' => 457,
                'descripcion' => 'Uso y manejo básico de Office.',
                'job_id' => 7,
                'created_at' => '2024-11-13 06:55:41',
                'updated_at' => '2024-11-13 08:11:31',
            ),
            457 => 
            array (
                'id' => 458,
                'descripcion' => 'Control documental y captura de datos.',
                'job_id' => 7,
                'created_at' => '2024-11-13 06:55:41',
                'updated_at' => '2024-11-13 08:11:31',
            ),
            458 => 
            array (
                'id' => 459,
                'descripcion' => 'Conocimientos de herramienta básica.',
                'job_id' => 7,
                'created_at' => '2024-11-13 06:55:41',
                'updated_at' => '2024-11-13 08:11:31',
            ),
            459 => 
            array (
                'id' => 460,
                'descripcion' => 'Manejo de inventarios.',
                'job_id' => 7,
                'created_at' => '2024-11-13 06:55:41',
                'updated_at' => '2024-11-13 08:11:31',
            ),
            460 => 
            array (
                'id' => 461,
                'descripcion' => 'Primeras entradas y primeras salidas.',
                'job_id' => 7,
                'created_at' => '2024-11-13 06:55:41',
                'updated_at' => '2024-11-13 08:11:31',
            ),
            461 => 
            array (
                'id' => 462,
                'descripcion' => 'Acomodo de almacén.',
                'job_id' => 7,
                'created_at' => '2024-11-13 06:55:41',
                'updated_at' => '2024-11-13 08:11:31',
            ),
            462 => 
            array (
                'id' => 463,
                'descripcion' => 'Elaboración de reportes.',
                'job_id' => 7,
                'created_at' => '2024-11-13 06:55:41',
                'updated_at' => '2024-11-13 08:11:31',
            ),
            463 => 
            array (
                'id' => 464,
                'descripcion' => 'Sin llenar',
                'job_id' => 7,
                'created_at' => '2024-11-13 06:55:41',
                'updated_at' => '2024-11-13 06:55:41',
            ),
            464 => 
            array (
                'id' => 465,
                'descripcion' => 'Soporte y mantenimiento',
                'job_id' => 9,
                'created_at' => '2024-11-14 03:12:30',
                'updated_at' => '2024-11-20 09:09:57',
            ),
            465 => 
            array (
                'id' => 466,
                'descripcion' => 'Windows 10',
                'job_id' => 9,
                'created_at' => '2024-11-14 03:12:30',
                'updated_at' => '2024-11-20 09:09:57',
            ),
            466 => 
            array (
                'id' => 467,
            'descripcion' => 'Manejo e instalación de paqueterías (Office, Google Workspace).',
                'job_id' => 9,
                'created_at' => '2024-11-14 03:12:30',
                'updated_at' => '2024-11-20 09:09:57',
            ),
            467 => 
            array (
                'id' => 468,
                'descripcion' => 'Lenguaje de programación PHP.',
                'job_id' => 9,
                'created_at' => '2024-11-14 03:12:30',
                'updated_at' => '2024-11-20 09:09:57',
            ),
            468 => 
            array (
                'id' => 469,
                'descripcion' => 'Manejo de programación móvil.',
                'job_id' => 9,
                'created_at' => '2024-11-14 03:12:30',
                'updated_at' => '2024-11-20 09:09:57',
            ),
            469 => 
            array (
                'id' => 470,
                'descripcion' => 'Base de datos.',
                'job_id' => 9,
                'created_at' => '2024-11-14 03:12:30',
                'updated_at' => '2024-11-20 09:09:57',
            ),
            470 => 
            array (
                'id' => 471,
                'descripcion' => 'Desarrollo web.',
                'job_id' => 9,
                'created_at' => '2024-11-14 03:12:30',
                'updated_at' => '2024-11-20 09:09:57',
            ),
            471 => 
            array (
                'id' => 472,
                'descripcion' => 'Sin llenar',
                'job_id' => 9,
                'created_at' => '2024-11-14 03:12:30',
                'updated_at' => '2024-11-14 03:12:30',
            ),
            472 => 
            array (
                'id' => 473,
                'descripcion' => 'Mantenimiento preventivo.',
                'job_id' => 2,
                'created_at' => '2024-11-14 03:48:08',
                'updated_at' => '2024-11-20 08:58:14',
            ),
            473 => 
            array (
                'id' => 474,
                'descripcion' => 'Hidráulica Industrial.',
                'job_id' => 2,
                'created_at' => '2024-11-14 03:48:08',
                'updated_at' => '2024-11-20 08:58:14',
            ),
            474 => 
            array (
                'id' => 475,
                'descripcion' => 'Mecánica.',
                'job_id' => 2,
                'created_at' => '2024-11-14 03:48:08',
                'updated_at' => '2024-11-20 08:58:14',
            ),
            475 => 
            array (
                'id' => 476,
                'descripcion' => 'Conocimientos de herramientas básicas.',
                'job_id' => 2,
                'created_at' => '2024-11-14 03:48:08',
                'updated_at' => '2024-11-20 08:58:14',
            ),
            476 => 
            array (
                'id' => 477,
                'descripcion' => 'Inspección visual.',
                'job_id' => 2,
                'created_at' => '2024-11-14 03:48:08',
                'updated_at' => '2024-11-20 08:58:14',
            ),
            477 => 
            array (
                'id' => 478,
                'descripcion' => 'Mantenimiento correctivo.',
                'job_id' => 2,
                'created_at' => '2024-11-14 03:48:08',
                'updated_at' => '2024-11-20 08:58:14',
            ),
            478 => 
            array (
                'id' => 479,
                'descripcion' => 'Mecánica de equipo HT&LS..',
                'job_id' => 2,
                'created_at' => '2024-11-14 03:48:08',
                'updated_at' => '2024-11-20 08:58:14',
            ),
            479 => 
            array (
                'id' => 480,
                'descripcion' => 'Sin llenar.',
                'job_id' => 2,
                'created_at' => '2024-11-14 03:48:08',
                'updated_at' => '2024-11-20 08:58:14',
            ),
            480 => 
            array (
                'id' => 481,
                'descripcion' => 'Limpieza de los componentes de una oficina.',
                'job_id' => 10,
                'created_at' => '2024-11-14 06:03:24',
                'updated_at' => '2024-11-21 03:05:26',
            ),
            481 => 
            array (
                'id' => 482,
                'descripcion' => 'Registro de inventario de insumos.',
                'job_id' => 10,
                'created_at' => '2024-11-14 06:03:24',
                'updated_at' => '2024-11-21 03:05:26',
            ),
            482 => 
            array (
                'id' => 483,
                'descripcion' => 'Medidas de seguridad.',
                'job_id' => 10,
                'created_at' => '2024-11-14 06:03:24',
                'updated_at' => '2024-11-21 03:05:26',
            ),
            483 => 
            array (
                'id' => 484,
                'descripcion' => 'Control de insumos.',
                'job_id' => 10,
                'created_at' => '2024-11-14 06:03:24',
                'updated_at' => '2024-11-21 03:05:26',
            ),
            484 => 
            array (
                'id' => 485,
                'descripcion' => 'Atención al cliente.',
                'job_id' => 10,
                'created_at' => '2024-11-14 06:03:24',
                'updated_at' => '2024-11-21 03:05:26',
            ),
            485 => 
            array (
                'id' => 486,
                'descripcion' => 'Manejo de líquidos y sustancias químicas.',
                'job_id' => 10,
                'created_at' => '2024-11-14 06:03:24',
                'updated_at' => '2024-11-21 03:05:26',
            ),
            486 => 
            array (
                'id' => 487,
                'descripcion' => 'Sin llenar',
                'job_id' => 10,
                'created_at' => '2024-11-14 06:03:24',
                'updated_at' => '2024-11-21 03:05:26',
            ),
            487 => 
            array (
                'id' => 488,
                'descripcion' => 'Sin llenar',
                'job_id' => 10,
                'created_at' => '2024-11-14 06:03:24',
                'updated_at' => '2024-11-14 06:03:24',
            ),
            488 => 
            array (
                'id' => 489,
                'descripcion' => 'Uso y manejo de izajes.',
                'job_id' => 6,
                'created_at' => '2024-11-14 06:30:30',
                'updated_at' => '2024-11-21 03:25:10',
            ),
            489 => 
            array (
                'id' => 490,
                'descripcion' => 'Maniobras de salvamento y arrastre.',
                'job_id' => 6,
                'created_at' => '2024-11-14 06:30:30',
                'updated_at' => '2024-11-21 03:25:10',
            ),
            490 => 
            array (
                'id' => 491,
                'descripcion' => 'Reglamento de tránsito y federal.',
                'job_id' => 6,
                'created_at' => '2024-11-14 06:30:30',
                'updated_at' => '2024-11-21 03:25:10',
            ),
            491 => 
            array (
                'id' => 492,
                'descripcion' => 'Manejo de grúa 15 TON o más.',
                'job_id' => 6,
                'created_at' => '2024-11-14 06:30:30',
                'updated_at' => '2024-11-21 03:25:10',
            ),
            492 => 
            array (
                'id' => 493,
                'descripcion' => 'Maniobra de equipos y accesorios.',
                'job_id' => 6,
                'created_at' => '2024-11-14 06:30:30',
                'updated_at' => '2024-11-21 03:25:10',
            ),
            493 => 
            array (
                'id' => 494,
                'descripcion' => 'Manejo de vehículos hasta 3 ejes.',
                'job_id' => 6,
                'created_at' => '2024-11-14 06:30:30',
                'updated_at' => '2024-11-21 03:25:10',
            ),
            494 => 
            array (
                'id' => 495,
                'descripcion' => 'Reglamentos de transporte y carga.',
                'job_id' => 6,
                'created_at' => '2024-11-14 06:30:30',
                'updated_at' => '2024-11-21 03:25:10',
            ),
            495 => 
            array (
                'id' => 496,
                'descripcion' => 'Sin llenar',
                'job_id' => 6,
                'created_at' => '2024-11-14 06:30:30',
                'updated_at' => '2024-11-14 06:30:30',
            ),
            496 => 
            array (
                'id' => 497,
                'descripcion' => 'Manejo de Automóvil.',
                'job_id' => 11,
                'created_at' => '2024-11-14 06:46:23',
                'updated_at' => '2024-11-21 03:08:45',
            ),
            497 => 
            array (
                'id' => 498,
                'descripcion' => 'Materiales de construcción.',
                'job_id' => 11,
                'created_at' => '2024-11-14 06:46:23',
                'updated_at' => '2024-11-21 03:08:45',
            ),
            498 => 
            array (
                'id' => 499,
                'descripcion' => 'Carpintería, Plomería.',
                'job_id' => 11,
                'created_at' => '2024-11-14 06:46:23',
                'updated_at' => '2024-11-21 03:17:04',
            ),
            499 => 
            array (
                'id' => 500,
                'descripcion' => 'Electricidad.',
                'job_id' => 11,
                'created_at' => '2024-11-14 06:46:23',
                'updated_at' => '2024-11-21 03:17:04',
            ),
        ));
        \DB::table('puesto_conocimientos')->insert(array (
            0 => 
            array (
                'id' => 501,
                'descripcion' => 'Mantenimiento de instalaciones.',
                'job_id' => 11,
                'created_at' => '2024-11-14 06:46:23',
                'updated_at' => '2024-11-21 03:16:34',
            ),
            1 => 
            array (
                'id' => 502,
                'descripcion' => 'Manejo de Sustancias Químicas Peligrosas.',
                'job_id' => 11,
                'created_at' => '2024-11-14 06:46:23',
                'updated_at' => '2024-11-21 03:16:34',
            ),
            2 => 
            array (
                'id' => 503,
                'descripcion' => 'Manejo de equipo electromecánico.',
                'job_id' => 11,
                'created_at' => '2024-11-14 06:46:23',
                'updated_at' => '2024-11-21 03:16:34',
            ),
            3 => 
            array (
                'id' => 504,
                'descripcion' => 'Reparación de Equipos de Manufactura.',
                'job_id' => 11,
                'created_at' => '2024-11-14 06:46:23',
                'updated_at' => '2024-11-21 03:17:04',
            ),
            4 => 
            array (
                'id' => 505,
                'descripcion' => 'Carpintería',
                'job_id' => 8,
                'created_at' => '2024-11-14 06:59:43',
                'updated_at' => '2024-11-20 09:04:22',
            ),
            5 => 
            array (
                'id' => 506,
                'descripcion' => 'Plomería',
                'job_id' => 8,
                'created_at' => '2024-11-14 06:59:43',
                'updated_at' => '2024-11-20 09:04:22',
            ),
            6 => 
            array (
                'id' => 507,
                'descripcion' => 'Materiales de construcción.',
                'job_id' => 8,
                'created_at' => '2024-11-14 06:59:43',
                'updated_at' => '2024-11-20 09:04:22',
            ),
            7 => 
            array (
                'id' => 508,
                'descripcion' => 'Mantenimiento de instalaciones.',
                'job_id' => 8,
                'created_at' => '2024-11-14 06:59:43',
                'updated_at' => '2024-11-14 07:33:36',
            ),
            8 => 
            array (
                'id' => 509,
                'descripcion' => 'Materiales de construcción.',
                'job_id' => 8,
                'created_at' => '2024-11-14 06:59:43',
                'updated_at' => '2024-11-14 07:33:36',
            ),
            9 => 
            array (
                'id' => 510,
                'descripcion' => 'Manejo de Sustancias Químicas Peligrosas.',
                'job_id' => 8,
                'created_at' => '2024-11-14 06:59:43',
                'updated_at' => '2024-11-20 09:04:22',
            ),
            10 => 
            array (
                'id' => 511,
                'descripcion' => 'Electricidad.',
                'job_id' => 8,
                'created_at' => '2024-11-14 06:59:43',
                'updated_at' => '2024-11-20 09:04:22',
            ),
            11 => 
            array (
                'id' => 512,
                'descripcion' => 'Manejo de Automóvil.',
                'job_id' => 8,
                'created_at' => '2024-11-14 06:59:43',
                'updated_at' => '2024-11-20 09:04:22',
            ),
            12 => 
            array (
                'id' => 513,
                'descripcion' => 'Manejo de presupuestos.',
                'job_id' => 94,
                'created_at' => '2024-11-14 07:39:45',
                'updated_at' => '2024-11-22 03:23:29',
            ),
            13 => 
            array (
                'id' => 514,
                'descripcion' => 'Mantenimiento de infraestructura.',
                'job_id' => 94,
                'created_at' => '2024-11-14 07:39:45',
                'updated_at' => '2024-11-22 03:23:29',
            ),
            14 => 
            array (
                'id' => 515,
                'descripcion' => 'Manejo de inventarios.',
                'job_id' => 94,
                'created_at' => '2024-11-14 07:39:45',
                'updated_at' => '2024-11-22 03:23:29',
            ),
            15 => 
            array (
                'id' => 516,
                'descripcion' => 'Manejo de ERP.',
                'job_id' => 94,
                'created_at' => '2024-11-14 07:39:45',
                'updated_at' => '2024-11-22 03:23:29',
            ),
            16 => 
            array (
                'id' => 517,
                'descripcion' => 'Trámites aduanales y mercantiles.',
                'job_id' => 94,
                'created_at' => '2024-11-14 07:39:45',
                'updated_at' => '2024-11-22 03:23:29',
            ),
            17 => 
            array (
                'id' => 518,
                'descripcion' => 'Diseño e interpretación de planos.',
                'job_id' => 94,
                'created_at' => '2024-11-14 07:39:45',
                'updated_at' => '2024-11-22 03:23:29',
            ),
            18 => 
            array (
                'id' => 519,
                'descripcion' => 'Cadena de suministros.',
                'job_id' => 94,
                'created_at' => '2024-11-14 07:39:45',
                'updated_at' => '2024-11-22 03:23:29',
            ),
            19 => 
            array (
                'id' => 520,
                'descripcion' => 'Sin llenar.',
                'job_id' => 94,
                'created_at' => '2024-11-14 07:39:45',
                'updated_at' => '2024-11-22 03:23:29',
            ),
            20 => 
            array (
                'id' => 521,
                'descripcion' => 'Cotizaciones.',
                'job_id' => 49,
                'created_at' => '2024-11-15 07:22:12',
                'updated_at' => '2024-11-15 07:37:21',
            ),
            21 => 
            array (
                'id' => 522,
                'descripcion' => 'Evaluación de proveedores.',
                'job_id' => 49,
                'created_at' => '2024-11-15 07:22:12',
                'updated_at' => '2024-11-15 07:37:21',
            ),
            22 => 
            array (
                'id' => 523,
                'descripcion' => 'Nogociación.',
                'job_id' => 49,
                'created_at' => '2024-11-15 07:22:12',
                'updated_at' => '2024-11-15 07:37:21',
            ),
            23 => 
            array (
                'id' => 524,
            'descripcion' => 'ERP (SAE)',
                'job_id' => 49,
                'created_at' => '2024-11-15 07:22:12',
                'updated_at' => '2024-11-15 07:37:21',
            ),
            24 => 
            array (
                'id' => 525,
                'descripcion' => 'Proceso de importación.',
                'job_id' => 49,
                'created_at' => '2024-11-15 07:22:12',
                'updated_at' => '2024-11-15 07:37:21',
            ),
            25 => 
            array (
                'id' => 526,
                'descripcion' => 'Sin llenar',
                'job_id' => 49,
                'created_at' => '2024-11-15 07:22:12',
                'updated_at' => '2024-11-15 07:22:12',
            ),
            26 => 
            array (
                'id' => 527,
                'descripcion' => 'Sin llenar',
                'job_id' => 49,
                'created_at' => '2024-11-15 07:22:12',
                'updated_at' => '2024-11-15 07:22:12',
            ),
            27 => 
            array (
                'id' => 528,
                'descripcion' => 'Sin llenar',
                'job_id' => 49,
                'created_at' => '2024-11-15 07:22:12',
                'updated_at' => '2024-11-15 07:22:12',
            ),
            28 => 
            array (
                'id' => 529,
                'descripcion' => 'Entrevistas por competencias.',
                'job_id' => 52,
                'created_at' => '2024-11-19 06:29:51',
                'updated_at' => '2024-11-25 04:30:50',
            ),
            29 => 
            array (
                'id' => 530,
                'descripcion' => 'Pruebas psicométricas.',
                'job_id' => 52,
                'created_at' => '2024-11-19 06:29:51',
                'updated_at' => '2024-11-25 04:30:50',
            ),
            30 => 
            array (
                'id' => 531,
                'descripcion' => 'Onboarding.',
                'job_id' => 52,
                'created_at' => '2024-11-19 06:29:51',
                'updated_at' => '2024-11-25 04:30:50',
            ),
            31 => 
            array (
                'id' => 532,
            'descripcion' => 'Impartición de cursos (presenciales y en línea).',
                'job_id' => 52,
                'created_at' => '2024-11-19 06:29:51',
                'updated_at' => '2024-11-25 04:30:50',
            ),
            32 => 
            array (
                'id' => 533,
                'descripcion' => 'Ley Federal de Trabajo.',
                'job_id' => 52,
                'created_at' => '2024-11-19 06:29:51',
                'updated_at' => '2024-11-25 04:30:50',
            ),
            33 => 
            array (
                'id' => 534,
                'descripcion' => 'Fuentes de reclutamiento. ',
                'job_id' => 52,
                'created_at' => '2024-11-19 06:29:51',
                'updated_at' => '2024-11-25 04:30:50',
            ),
            34 => 
            array (
                'id' => 535,
                'descripcion' => 'Elaboración de indicadores.',
                'job_id' => 52,
                'created_at' => '2024-11-19 06:29:51',
                'updated_at' => '2024-11-25 04:30:50',
            ),
            35 => 
            array (
                'id' => 536,
                'descripcion' => 'Sin llenar',
                'job_id' => 52,
                'created_at' => '2024-11-19 06:29:51',
                'updated_at' => '2024-11-19 06:29:51',
            ),
            36 => 
            array (
                'id' => 537,
                'descripcion' => 'Sistemas de Gestión Integrales.',
                'job_id' => 57,
                'created_at' => '2024-11-19 07:29:15',
                'updated_at' => '2024-11-19 07:42:37',
            ),
            37 => 
            array (
                'id' => 538,
                'descripcion' => 'ISO 14001:2015, 9001:2015, 45001:2018.',
                'job_id' => 57,
                'created_at' => '2024-11-19 07:29:15',
                'updated_at' => '2024-11-19 07:42:37',
            ),
            38 => 
            array (
                'id' => 539,
                'descripcion' => 'Procesos de auditorias.',
                'job_id' => 57,
                'created_at' => '2024-11-19 07:29:15',
                'updated_at' => '2024-11-19 07:42:37',
            ),
            39 => 
            array (
                'id' => 540,
                'descripcion' => 'Manejo de no conformidades.',
                'job_id' => 57,
                'created_at' => '2024-11-19 07:29:15',
                'updated_at' => '2024-11-19 07:42:37',
            ),
            40 => 
            array (
                'id' => 541,
                'descripcion' => 'Mapeo de procesos.',
                'job_id' => 57,
                'created_at' => '2024-11-19 07:29:15',
                'updated_at' => '2024-11-19 07:42:37',
            ),
            41 => 
            array (
                'id' => 542,
                'descripcion' => 'Herramientas de calidad.',
                'job_id' => 57,
                'created_at' => '2024-11-19 07:29:15',
                'updated_at' => '2024-11-19 07:42:37',
            ),
            42 => 
            array (
                'id' => 543,
            'descripcion' => 'Análisis Causa-Raíz (ACR).',
                'job_id' => 57,
                'created_at' => '2024-11-19 07:29:15',
                'updated_at' => '2024-11-19 07:42:37',
            ),
            43 => 
            array (
                'id' => 544,
                'descripcion' => 'Sin llenar',
                'job_id' => 57,
                'created_at' => '2024-11-19 07:29:15',
                'updated_at' => '2024-11-19 07:29:15',
            ),
            44 => 
            array (
                'id' => 545,
                'descripcion' => 'Normativa ASME.',
                'job_id' => 28,
                'created_at' => '2024-11-19 07:45:04',
                'updated_at' => '2024-11-25 03:37:02',
            ),
            45 => 
            array (
                'id' => 546,
                'descripcion' => 'Manejo de software de diseño - Solidworks.',
                'job_id' => 28,
                'created_at' => '2024-11-19 07:45:04',
                'updated_at' => '2024-11-25 03:37:02',
            ),
            46 => 
            array (
                'id' => 547,
                'descripcion' => 'Simbología y procesos de soldadura.',
                'job_id' => 28,
                'created_at' => '2024-11-19 07:45:04',
                'updated_at' => '2024-11-25 03:37:02',
            ),
            47 => 
            array (
                'id' => 548,
                'descripcion' => 'Metrología.',
                'job_id' => 28,
                'created_at' => '2024-11-19 07:45:04',
                'updated_at' => '2024-11-25 03:37:02',
            ),
            48 => 
            array (
                'id' => 549,
                'descripcion' => 'Materiales.',
                'job_id' => 28,
                'created_at' => '2024-11-19 07:45:04',
                'updated_at' => '2024-11-25 03:37:02',
            ),
            49 => 
            array (
                'id' => 550,
                'descripcion' => 'Trato con proveedores.',
                'job_id' => 28,
                'created_at' => '2024-11-19 07:45:04',
                'updated_at' => '2024-11-25 03:37:02',
            ),
            50 => 
            array (
                'id' => 551,
                'descripcion' => 'Procesos de manufactura.',
                'job_id' => 28,
                'created_at' => '2024-11-19 07:45:04',
                'updated_at' => '2024-11-19 08:01:22',
            ),
            51 => 
            array (
                'id' => 552,
                'descripcion' => 'SolidWorks Nivel Intermedio.',
                'job_id' => 28,
                'created_at' => '2024-11-19 07:45:04',
                'updated_at' => '2025-07-15 06:13:03',
            ),
            52 => 
            array (
                'id' => 553,
                'descripcion' => 'Tolerancias dimensionales.',
                'job_id' => 26,
                'created_at' => '2024-11-19 08:02:16',
                'updated_at' => '2024-11-25 03:30:23',
            ),
            53 => 
            array (
                'id' => 554,
                'descripcion' => 'Pruebas de corte.',
                'job_id' => 26,
                'created_at' => '2024-11-19 08:02:16',
                'updated_at' => '2024-11-25 03:30:23',
            ),
            54 => 
            array (
                'id' => 555,
                'descripcion' => 'Metrología.',
                'job_id' => 26,
                'created_at' => '2024-11-19 08:02:16',
                'updated_at' => '2024-11-25 03:30:23',
            ),
            55 => 
            array (
                'id' => 556,
                'descripcion' => 'Mecánica.',
                'job_id' => 26,
                'created_at' => '2024-11-19 08:02:16',
                'updated_at' => '2024-11-19 08:20:03',
            ),
            56 => 
            array (
                'id' => 557,
                'descripcion' => 'Normativa ASME, API, NACE, ANSI, ASTM e ISO.',
                'job_id' => 26,
                'created_at' => '2024-11-19 08:02:16',
                'updated_at' => '2024-11-25 03:30:23',
            ),
            57 => 
            array (
                'id' => 558,
                'descripcion' => 'Diseño e interpretación de planos.',
                'job_id' => 26,
                'created_at' => '2024-11-19 08:02:16',
                'updated_at' => '2024-11-25 03:30:23',
            ),
            58 => 
            array (
                'id' => 559,
                'descripcion' => 'Manejo de software de diseño y simuladores.',
                'job_id' => 26,
                'created_at' => '2024-11-19 08:02:16',
                'updated_at' => '2024-11-25 03:30:23',
            ),
            59 => 
            array (
                'id' => 560,
                'descripcion' => 'Sin llenar',
                'job_id' => 26,
                'created_at' => '2024-11-19 08:02:16',
                'updated_at' => '2024-11-19 08:02:16',
            ),
            60 => 
            array (
                'id' => 561,
                'descripcion' => 'Sin llenar',
                'job_id' => 29,
                'created_at' => '2024-11-19 09:13:13',
                'updated_at' => '2024-11-19 09:13:13',
            ),
            61 => 
            array (
                'id' => 562,
                'descripcion' => 'Sin llenar',
                'job_id' => 29,
                'created_at' => '2024-11-19 09:13:13',
                'updated_at' => '2024-11-19 09:13:13',
            ),
            62 => 
            array (
                'id' => 563,
                'descripcion' => 'Sin llenar',
                'job_id' => 29,
                'created_at' => '2024-11-19 09:13:13',
                'updated_at' => '2024-11-19 09:13:13',
            ),
            63 => 
            array (
                'id' => 564,
                'descripcion' => 'Sin llenar',
                'job_id' => 29,
                'created_at' => '2024-11-19 09:13:13',
                'updated_at' => '2024-11-19 09:13:13',
            ),
            64 => 
            array (
                'id' => 565,
                'descripcion' => 'Sin llenar',
                'job_id' => 29,
                'created_at' => '2024-11-19 09:13:13',
                'updated_at' => '2024-11-19 09:13:13',
            ),
            65 => 
            array (
                'id' => 566,
                'descripcion' => 'Sin llenar',
                'job_id' => 29,
                'created_at' => '2024-11-19 09:13:13',
                'updated_at' => '2024-11-19 09:13:13',
            ),
            66 => 
            array (
                'id' => 567,
                'descripcion' => 'Sin llenar',
                'job_id' => 29,
                'created_at' => '2024-11-19 09:13:13',
                'updated_at' => '2024-11-19 09:13:13',
            ),
            67 => 
            array (
                'id' => 568,
                'descripcion' => 'Sin llenar',
                'job_id' => 29,
                'created_at' => '2024-11-19 09:13:13',
                'updated_at' => '2024-11-19 09:13:13',
            ),
            68 => 
            array (
                'id' => 569,
                'descripcion' => 'Paquetería Office.',
                'job_id' => 95,
                'created_at' => '2024-11-20 06:34:52',
                'updated_at' => '2024-11-20 07:13:56',
            ),
            69 => 
            array (
                'id' => 570,
                'descripcion' => 'Gestión de la cadena de suministros.',
                'job_id' => 95,
                'created_at' => '2024-11-20 06:34:52',
                'updated_at' => '2024-11-20 07:13:56',
            ),
            70 => 
            array (
                'id' => 571,
            'descripcion' => 'Administración de Proyectos (básico).',
                'job_id' => 95,
                'created_at' => '2024-11-20 06:34:52',
                'updated_at' => '2024-11-20 07:13:56',
            ),
            71 => 
            array (
                'id' => 572,
                'descripcion' => 'Control Documental.',
                'job_id' => 95,
                'created_at' => '2024-11-20 06:34:52',
                'updated_at' => '2024-11-20 07:13:56',
            ),
            72 => 
            array (
                'id' => 573,
                'descripcion' => 'Gestión Administrativa.',
                'job_id' => 95,
                'created_at' => '2024-11-20 06:34:52',
                'updated_at' => '2024-11-20 07:13:56',
            ),
            73 => 
            array (
                'id' => 574,
            'descripcion' => 'Sistemas de Gestión de Calidad (básico).',
                'job_id' => 95,
                'created_at' => '2024-11-20 06:34:52',
                'updated_at' => '2024-11-20 07:13:56',
            ),
            74 => 
            array (
                'id' => 575,
                'descripcion' => 'Conocimiento del sector OiI & Gas.',
                'job_id' => 95,
                'created_at' => '2024-11-20 06:34:52',
                'updated_at' => '2024-11-20 07:13:56',
            ),
            75 => 
            array (
                'id' => 576,
            'descripcion' => 'Metrología (básico).',
                'job_id' => 95,
                'created_at' => '2024-11-20 06:34:52',
                'updated_at' => '2024-11-20 07:13:56',
            ),
            76 => 
            array (
                'id' => 577,
                'descripcion' => 'Fundamentos de Hot Tapping y Conocimientos Técnicos Específicos.',
                'job_id' => 20,
                'created_at' => '2024-11-22 06:36:26',
                'updated_at' => '2024-11-25 02:38:35',
            ),
            77 => 
            array (
                'id' => 578,
                'descripcion' => 'Sistemas de tuberías.',
                'job_id' => 20,
                'created_at' => '2024-11-22 06:36:26',
                'updated_at' => '2024-11-25 02:38:35',
            ),
            78 => 
            array (
                'id' => 579,
                'descripcion' => 'Seguridad Industrial y Gestión de Riesgos.',
                'job_id' => 20,
                'created_at' => '2024-11-22 06:36:26',
                'updated_at' => '2024-11-25 02:38:35',
            ),
            79 => 
            array (
                'id' => 580,
            'descripcion' => 'Normas y regulaciones (API 2201, 1104, ASME B31.3, ASME-PCC-2_2022, NOM-ASEA-007-2016, ASME Section V 2019 Y  CNC PEMEX-EST-IC-187-2018).',
                'job_id' => 20,
                'created_at' => '2024-11-22 06:36:26',
                'updated_at' => '2024-11-25 02:38:35',
            ),
            80 => 
            array (
                'id' => 581,
                'descripcion' => 'Seguridad industrial',
                'job_id' => 20,
                'created_at' => '2024-11-22 06:36:26',
                'updated_at' => '2024-11-25 02:38:35',
            ),
            81 => 
            array (
                'id' => 582,
                'descripcion' => 'Procesos de trabajo.',
                'job_id' => 20,
                'created_at' => '2024-11-22 06:36:26',
                'updated_at' => '2024-11-25 02:38:35',
            ),
            82 => 
            array (
                'id' => 583,
                'descripcion' => ' Habilidades prácticas (Medición y calibración, Inspección visual, Manejo de herramientas.',
                    'job_id' => 20,
                    'created_at' => '2024-11-22 06:36:26',
                    'updated_at' => '2024-11-25 02:38:35',
                ),
                83 => 
                array (
                    'id' => 584,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 20,
                    'created_at' => '2024-11-22 06:36:26',
                    'updated_at' => '2024-11-22 06:36:26',
                ),
                84 => 
                array (
                    'id' => 585,
                    'descripcion' => 'Conocimiento en válvulas.',
                    'job_id' => 16,
                    'created_at' => '2024-11-22 06:55:07',
                    'updated_at' => '2024-11-25 02:36:17',
                ),
                85 => 
                array (
                    'id' => 586,
                    'descripcion' => 'Pruebas hidrostáticas.',
                    'job_id' => 16,
                    'created_at' => '2024-11-22 06:55:07',
                    'updated_at' => '2024-11-25 02:36:17',
                ),
                86 => 
                array (
                    'id' => 587,
                    'descripcion' => 'Servicios de Onshore y Offshore.',
                    'job_id' => 16,
                    'created_at' => '2024-11-22 06:55:07',
                    'updated_at' => '2024-11-25 02:36:17',
                ),
                87 => 
                array (
                    'id' => 588,
                    'descripcion' => 'Normatividad ASEA, ASME, API y otras aplicables.',
                    'job_id' => 16,
                    'created_at' => '2024-11-22 06:55:07',
                    'updated_at' => '2024-11-25 02:36:17',
                ),
                88 => 
                array (
                    'id' => 589,
                    'descripcion' => 'Mecánica de equipo HT&LS.',
                    'job_id' => 16,
                    'created_at' => '2024-11-22 06:55:07',
                    'updated_at' => '2024-11-25 02:36:17',
                ),
                89 => 
                array (
                    'id' => 590,
                    'descripcion' => 'Soldadura.',
                    'job_id' => 16,
                    'created_at' => '2024-11-22 06:55:07',
                    'updated_at' => '2024-11-25 02:36:17',
                ),
                90 => 
                array (
                    'id' => 591,
                    'descripcion' => 'Normas y Procedimientos.',
                    'job_id' => 16,
                    'created_at' => '2024-11-22 06:55:07',
                    'updated_at' => '2024-11-25 02:36:17',
                ),
                91 => 
                array (
                    'id' => 592,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 16,
                    'created_at' => '2024-11-22 06:55:07',
                    'updated_at' => '2024-11-22 06:55:07',
                ),
                92 => 
                array (
                    'id' => 593,
                'descripcion' => 'Posiciones de soldadura (básicas).',
                    'job_id' => 21,
                    'created_at' => '2024-11-22 07:24:09',
                    'updated_at' => '2024-11-25 05:03:27',
                ),
                93 => 
                array (
                    'id' => 594,
                    'descripcion' => 'Instrumentos de medición de tipo digital.',
                    'job_id' => 21,
                    'created_at' => '2024-11-22 07:24:09',
                    'updated_at' => '2024-11-25 05:03:27',
                ),
                94 => 
                array (
                    'id' => 595,
                    'descripcion' => 'Instrumentos de medición de tipo análogo.',
                    'job_id' => 21,
                    'created_at' => '2024-11-22 07:24:09',
                    'updated_at' => '2024-11-25 05:03:27',
                ),
                95 => 
                array (
                    'id' => 596,
                'descripcion' => 'Soldadura SMAW (básica).',
                    'job_id' => 21,
                    'created_at' => '2024-11-22 07:24:09',
                    'updated_at' => '2024-11-22 08:21:42',
                ),
                96 => 
                array (
                    'id' => 597,
                    'descripcion' => 'Procedimientos de soldadura.',
                    'job_id' => 21,
                    'created_at' => '2024-11-22 07:24:09',
                    'updated_at' => '2024-11-25 05:03:27',
                ),
                97 => 
                array (
                    'id' => 598,
                    'descripcion' => 'Símbolos de soldadura. ',
                    'job_id' => 21,
                    'created_at' => '2024-11-22 07:24:09',
                    'updated_at' => '2024-11-25 05:03:27',
                ),
                98 => 
                array (
                    'id' => 599,
                    'descripcion' => 'Interpretación de planos de fabricación e isométricos..',
                    'job_id' => 21,
                    'created_at' => '2024-11-22 07:24:09',
                    'updated_at' => '2024-11-25 05:03:27',
                ),
                99 => 
                array (
                    'id' => 600,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 21,
                    'created_at' => '2024-11-22 07:24:09',
                    'updated_at' => '2024-11-22 07:24:09',
                ),
                100 => 
                array (
                    'id' => 601,
                'descripcion' => 'Conocimiento e interpretación de Código API 1104 y ASME B31.8 (en los numerales de soldadura).',
                    'job_id' => 15,
                    'created_at' => '2024-11-22 08:25:13',
                    'updated_at' => '2024-11-28 08:50:55',
                ),
                101 => 
                array (
                    'id' => 602,
                'descripcion' => 'Teoría y práctica en Soldadura  (SMAW, GTAW) y su tipo (raíz abierta en servicio y/u otros).',
                    'job_id' => 15,
                    'created_at' => '2024-11-22 08:25:13',
                    'updated_at' => '2024-11-28 08:50:55',
                ),
                102 => 
                array (
                    'id' => 603,
                'descripcion' => 'Cálculos de Volúmenes de Soldadura y consumibles (BOM y BOE).',
                    'job_id' => 15,
                    'created_at' => '2024-11-22 08:25:13',
                    'updated_at' => '2024-11-28 08:50:55',
                ),
                103 => 
                array (
                    'id' => 604,
                'descripcion' => 'Preparación, fabricación y reparación de ensambles metal - mecánicos (tubero).',
                    'job_id' => 15,
                    'created_at' => '2024-11-22 08:25:13',
                    'updated_at' => '2024-11-28 08:50:55',
                ),
                104 => 
                array (
                    'id' => 605,
                    'descripcion' => 'Interpretación de planos de fabricación e isométricos.',
                    'job_id' => 15,
                    'created_at' => '2024-11-22 08:25:13',
                    'updated_at' => '2024-11-28 08:50:55',
                ),
                105 => 
                array (
                    'id' => 606,
                    'descripcion' => 'Inspección de instalaciones, material, equipo y superficies.',
                    'job_id' => 15,
                    'created_at' => '2024-11-22 08:25:13',
                    'updated_at' => '2024-11-25 05:08:09',
                ),
                106 => 
                array (
                    'id' => 607,
                'descripcion' => 'Uso y operación de equipo de servicios auxiliares (PH y Torque).',
                    'job_id' => 15,
                    'created_at' => '2024-11-22 08:25:13',
                    'updated_at' => '2024-11-28 08:50:55',
                ),
                107 => 
                array (
                    'id' => 608,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 15,
                    'created_at' => '2024-11-22 08:25:13',
                    'updated_at' => '2024-11-22 08:25:13',
                ),
                108 => 
                array (
                    'id' => 609,
                    'descripcion' => 'Instrumentos de tipo análogo y digital de medición para medición.',
                    'job_id' => 17,
                    'created_at' => '2024-11-22 08:52:43',
                    'updated_at' => '2024-11-28 08:53:16',
                ),
                109 => 
                array (
                    'id' => 610,
                    'descripcion' => 'Soldadura línea nueva/ raíz abierta/ en caliente.',
                    'job_id' => 17,
                    'created_at' => '2024-11-22 08:52:43',
                    'updated_at' => '2024-11-28 08:53:16',
                ),
                110 => 
                array (
                    'id' => 611,
                    'descripcion' => 'Soldadura SMAW, GTAW.',
                    'job_id' => 17,
                    'created_at' => '2024-11-22 08:52:43',
                    'updated_at' => '2024-11-25 05:06:45',
                ),
                111 => 
                array (
                    'id' => 612,
                    'descripcion' => 'Inspección de instalaciones, material, equipo y superficies.',
                    'job_id' => 17,
                    'created_at' => '2024-11-22 08:52:43',
                    'updated_at' => '2024-11-28 08:53:16',
                ),
                112 => 
                array (
                    'id' => 613,
                    'descripcion' => 'Interpretación de planos de fabricación e isométricos.',
                    'job_id' => 17,
                    'created_at' => '2024-11-22 08:52:43',
                    'updated_at' => '2024-11-28 08:53:16',
                ),
                113 => 
                array (
                    'id' => 614,
                'descripcion' => 'Preparación, fabricación y reparación de ensambles metal - mecánicos (tubero).',
                    'job_id' => 17,
                    'created_at' => '2024-11-22 08:52:43',
                    'updated_at' => '2024-11-28 08:53:16',
                ),
                114 => 
                array (
                    'id' => 615,
                    'descripcion' => 'Procedimientos, estándares y posiciones de soldadura.',
                    'job_id' => 17,
                    'created_at' => '2024-11-22 08:52:43',
                    'updated_at' => '2024-11-28 08:53:16',
                ),
                115 => 
                array (
                    'id' => 616,
                'descripcion' => 'Uso y operación  de equipo de servicios auxiliares (Torque).',
                    'job_id' => 17,
                    'created_at' => '2024-11-22 08:52:43',
                    'updated_at' => '2024-11-28 08:56:20',
                ),
                116 => 
                array (
                    'id' => 617,
                    'descripcion' => 'Operación de maquinas-herramientas.',
                    'job_id' => 23,
                    'created_at' => '2024-11-25 03:14:30',
                    'updated_at' => '2024-11-25 03:21:57',
                ),
                117 => 
                array (
                    'id' => 618,
                    'descripcion' => 'Conocimiento en el mantenimiento de maquinas - herramientas.',
                    'job_id' => 23,
                    'created_at' => '2024-11-25 03:14:30',
                    'updated_at' => '2024-11-25 03:21:57',
                ),
                118 => 
                array (
                    'id' => 619,
                    'descripcion' => 'Clasificación de materiales.',
                    'job_id' => 23,
                    'created_at' => '2024-11-25 03:14:30',
                    'updated_at' => '2024-11-25 03:58:45',
                ),
                119 => 
                array (
                    'id' => 620,
                    'descripcion' => 'Manejo de instrumentos de medición.',
                    'job_id' => 23,
                    'created_at' => '2024-11-25 03:14:30',
                    'updated_at' => '2024-11-25 03:58:45',
                ),
                120 => 
                array (
                    'id' => 621,
                    'descripcion' => 'Interpretación de planos y simbología.',
                    'job_id' => 23,
                    'created_at' => '2024-11-25 03:14:30',
                    'updated_at' => '2024-11-25 03:21:57',
                ),
                121 => 
                array (
                    'id' => 622,
                    'descripcion' => 'Inspección de piezas.',
                    'job_id' => 23,
                    'created_at' => '2024-11-25 03:14:30',
                    'updated_at' => '2024-11-25 03:21:57',
                ),
                122 => 
                array (
                    'id' => 623,
                    'descripcion' => 'Conocimiento de Herramientas para la operación de maquinas-herramientas.',
                    'job_id' => 23,
                    'created_at' => '2024-11-25 03:14:30',
                    'updated_at' => '2024-11-25 03:21:57',
                ),
                123 => 
                array (
                    'id' => 624,
                    'descripcion' => 'Sin llenar.',
                    'job_id' => 23,
                    'created_at' => '2024-11-25 03:14:30',
                    'updated_at' => '2024-11-25 03:21:57',
                ),
                124 => 
                array (
                    'id' => 625,
                    'descripcion' => 'Mecánica, Hidráulica y Neumática.',
                    'job_id' => 27,
                    'created_at' => '2024-11-25 03:37:33',
                    'updated_at' => '2024-11-25 03:44:36',
                ),
                125 => 
                array (
                    'id' => 626,
                    'descripcion' => 'Metrología.',
                    'job_id' => 27,
                    'created_at' => '2024-11-25 03:37:33',
                    'updated_at' => '2024-11-25 03:44:36',
                ),
                126 => 
                array (
                    'id' => 627,
                    'descripcion' => 'Procesos de manufactura.',
                    'job_id' => 27,
                    'created_at' => '2024-11-25 03:37:33',
                    'updated_at' => '2024-11-25 03:44:36',
                ),
                127 => 
                array (
                    'id' => 628,
                    'descripcion' => 'Control de la productividad.',
                    'job_id' => 27,
                    'created_at' => '2024-11-25 03:37:33',
                    'updated_at' => '2024-11-25 03:44:36',
                ),
                128 => 
                array (
                    'id' => 629,
                    'descripcion' => 'Normatividad ASEA, ASME.',
                    'job_id' => 27,
                    'created_at' => '2024-11-25 03:37:33',
                    'updated_at' => '2024-11-25 03:44:36',
                ),
                129 => 
                array (
                    'id' => 630,
                    'descripcion' => 'Básico en válvulas.',
                    'job_id' => 27,
                    'created_at' => '2024-11-25 03:37:33',
                    'updated_at' => '2024-11-25 03:44:36',
                ),
                130 => 
                array (
                    'id' => 631,
                    'descripcion' => 'Simbología y especificaciones de soldadura.',
                    'job_id' => 27,
                    'created_at' => '2024-11-25 03:37:33',
                    'updated_at' => '2024-11-25 03:44:36',
                ),
                131 => 
                array (
                    'id' => 632,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 27,
                    'created_at' => '2024-11-25 03:37:33',
                    'updated_at' => '2024-11-25 03:37:33',
                ),
                132 => 
                array (
                    'id' => 633,
                    'descripcion' => 'Equipos y herramientas.',
                    'job_id' => 30,
                    'created_at' => '2024-11-25 04:03:50',
                    'updated_at' => '2024-11-25 08:01:10',
                ),
                133 => 
                array (
                    'id' => 634,
                    'descripcion' => 'Mantenimiento preventivo y correctivo.',
                    'job_id' => 30,
                    'created_at' => '2024-11-25 04:03:50',
                    'updated_at' => '2024-11-25 08:01:10',
                ),
                134 => 
                array (
                    'id' => 635,
                    'descripcion' => 'Conocimiento técnico de materiales.',
                    'job_id' => 30,
                    'created_at' => '2024-11-25 04:03:50',
                    'updated_at' => '2024-11-25 08:01:10',
                ),
                135 => 
                array (
                    'id' => 636,
                    'descripcion' => 'Lectura e interpretación de planos.',
                    'job_id' => 30,
                    'created_at' => '2024-11-25 04:03:50',
                    'updated_at' => '2024-11-25 08:01:10',
                ),
                136 => 
                array (
                    'id' => 637,
                    'descripcion' => 'Operación básica.',
                    'job_id' => 30,
                    'created_at' => '2024-11-25 04:03:50',
                    'updated_at' => '2024-11-25 08:01:10',
                ),
                137 => 
                array (
                    'id' => 638,
                    'descripcion' => 'Normas y Procedimientos.',
                    'job_id' => 30,
                    'created_at' => '2024-11-25 04:03:50',
                    'updated_at' => '2024-11-25 08:01:10',
                ),
                138 => 
                array (
                    'id' => 639,
                    'descripcion' => 'Ensayos básicos.',
                    'job_id' => 30,
                    'created_at' => '2024-11-25 04:03:50',
                    'updated_at' => '2024-11-25 08:01:10',
                ),
                139 => 
                array (
                    'id' => 640,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 30,
                    'created_at' => '2024-11-25 04:03:50',
                    'updated_at' => '2024-11-25 04:03:50',
                ),
                140 => 
                array (
                    'id' => 641,
                    'descripcion' => 'Normatividad ASEA, ASME, API y otras aplicables.',
                    'job_id' => 96,
                    'created_at' => '2024-11-25 08:14:33',
                    'updated_at' => '2024-11-25 08:50:02',
                ),
                141 => 
                array (
                    'id' => 642,
                    'descripcion' => 'Integridad de ductos.',
                    'job_id' => 96,
                    'created_at' => '2024-11-25 08:14:33',
                    'updated_at' => '2024-11-25 08:50:02',
                ),
                142 => 
                array (
                    'id' => 643,
                    'descripcion' => 'Metodología PMI.',
                    'job_id' => 96,
                    'created_at' => '2024-11-25 08:14:33',
                    'updated_at' => '2024-11-25 08:50:02',
                ),
                143 => 
                array (
                    'id' => 644,
                    'descripcion' => 'Servicios de Hot Tapping & Line Stopping..',
                    'job_id' => 96,
                    'created_at' => '2024-11-25 08:14:33',
                    'updated_at' => '2024-11-25 08:50:02',
                ),
                144 => 
                array (
                    'id' => 645,
                    'descripcion' => 'Obra civil.',
                    'job_id' => 96,
                    'created_at' => '2024-11-25 08:14:33',
                    'updated_at' => '2024-11-25 08:50:02',
                ),
                145 => 
                array (
                    'id' => 646,
                    'descripcion' => 'Análisis de precios unitarios.',
                    'job_id' => 96,
                    'created_at' => '2024-11-25 08:14:33',
                    'updated_at' => '2024-11-25 08:50:02',
                ),
                146 => 
                array (
                    'id' => 647,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 96,
                    'created_at' => '2024-11-25 08:14:33',
                    'updated_at' => '2024-11-25 08:14:33',
                ),
                147 => 
                array (
                    'id' => 648,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 96,
                    'created_at' => '2024-11-25 08:14:33',
                    'updated_at' => '2024-11-25 08:14:33',
                ),
                148 => 
                array (
                    'id' => 649,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 14,
                    'created_at' => '2024-11-26 07:54:55',
                    'updated_at' => '2024-11-26 07:54:55',
                ),
                149 => 
                array (
                    'id' => 650,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 14,
                    'created_at' => '2024-11-26 07:54:55',
                    'updated_at' => '2024-11-26 07:54:55',
                ),
                150 => 
                array (
                    'id' => 651,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 14,
                    'created_at' => '2024-11-26 07:54:55',
                    'updated_at' => '2024-11-26 07:54:55',
                ),
                151 => 
                array (
                    'id' => 652,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 14,
                    'created_at' => '2024-11-26 07:54:55',
                    'updated_at' => '2024-11-26 07:54:55',
                ),
                152 => 
                array (
                    'id' => 653,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 14,
                    'created_at' => '2024-11-26 07:54:55',
                    'updated_at' => '2024-11-26 07:54:55',
                ),
                153 => 
                array (
                    'id' => 654,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 14,
                    'created_at' => '2024-11-26 07:54:55',
                    'updated_at' => '2024-11-26 07:54:55',
                ),
                154 => 
                array (
                    'id' => 655,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 14,
                    'created_at' => '2024-11-26 07:54:55',
                    'updated_at' => '2024-11-26 07:54:55',
                ),
                155 => 
                array (
                    'id' => 656,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 14,
                    'created_at' => '2024-11-26 07:54:55',
                    'updated_at' => '2024-11-26 07:54:55',
                ),
                156 => 
                array (
                    'id' => 657,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 62,
                    'created_at' => '2024-11-26 07:54:58',
                    'updated_at' => '2024-11-26 07:54:58',
                ),
                157 => 
                array (
                    'id' => 658,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 62,
                    'created_at' => '2024-11-26 07:54:58',
                    'updated_at' => '2024-11-26 07:54:58',
                ),
                158 => 
                array (
                    'id' => 659,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 62,
                    'created_at' => '2024-11-26 07:54:58',
                    'updated_at' => '2024-11-26 07:54:58',
                ),
                159 => 
                array (
                    'id' => 660,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 62,
                    'created_at' => '2024-11-26 07:54:58',
                    'updated_at' => '2024-11-26 07:54:58',
                ),
                160 => 
                array (
                    'id' => 661,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 62,
                    'created_at' => '2024-11-26 07:54:58',
                    'updated_at' => '2024-11-26 07:54:58',
                ),
                161 => 
                array (
                    'id' => 662,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 62,
                    'created_at' => '2024-11-26 07:54:58',
                    'updated_at' => '2024-11-26 07:54:58',
                ),
                162 => 
                array (
                    'id' => 663,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 62,
                    'created_at' => '2024-11-26 07:54:58',
                    'updated_at' => '2024-11-26 07:54:58',
                ),
                163 => 
                array (
                    'id' => 664,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 62,
                    'created_at' => '2024-11-26 07:54:58',
                    'updated_at' => '2024-11-26 07:54:58',
                ),
                164 => 
                array (
                    'id' => 665,
                    'descripcion' => 'Cuentas por pagar.',
                    'job_id' => 51,
                    'created_at' => '2024-11-26 08:01:09',
                    'updated_at' => '2024-12-16 04:54:34',
                ),
                165 => 
                array (
                    'id' => 666,
                    'descripcion' => 'Excel basico.',
                    'job_id' => 51,
                    'created_at' => '2024-11-26 08:01:09',
                    'updated_at' => '2024-12-16 04:54:34',
                ),
                166 => 
                array (
                    'id' => 667,
                    'descripcion' => 'Registros Contables.',
                    'job_id' => 51,
                    'created_at' => '2024-11-26 08:01:09',
                    'updated_at' => '2024-12-16 04:54:34',
                ),
                167 => 
                array (
                    'id' => 668,
                    'descripcion' => 'Naturaleza de las Cuentas.',
                    'job_id' => 51,
                    'created_at' => '2024-11-26 08:01:09',
                    'updated_at' => '2024-12-16 04:54:34',
                ),
                168 => 
                array (
                    'id' => 669,
                    'descripcion' => 'Conciliaciones bancarias.',
                    'job_id' => 51,
                    'created_at' => '2024-11-26 08:01:09',
                    'updated_at' => '2024-12-16 04:54:34',
                ),
                169 => 
                array (
                    'id' => 670,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 51,
                    'created_at' => '2024-11-26 08:01:09',
                    'updated_at' => '2024-11-26 08:01:09',
                ),
                170 => 
                array (
                    'id' => 671,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 51,
                    'created_at' => '2024-11-26 08:01:09',
                    'updated_at' => '2024-11-26 08:01:09',
                ),
                171 => 
                array (
                    'id' => 672,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 51,
                    'created_at' => '2024-11-26 08:01:09',
                    'updated_at' => '2024-11-26 08:01:09',
                ),
                172 => 
                array (
                    'id' => 673,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 22,
                    'created_at' => '2024-11-28 08:15:52',
                    'updated_at' => '2024-11-28 08:15:52',
                ),
                173 => 
                array (
                    'id' => 674,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 22,
                    'created_at' => '2024-11-28 08:15:52',
                    'updated_at' => '2024-11-28 08:15:52',
                ),
                174 => 
                array (
                    'id' => 675,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 22,
                    'created_at' => '2024-11-28 08:15:52',
                    'updated_at' => '2024-11-28 08:15:52',
                ),
                175 => 
                array (
                    'id' => 676,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 22,
                    'created_at' => '2024-11-28 08:15:52',
                    'updated_at' => '2024-11-28 08:15:52',
                ),
                176 => 
                array (
                    'id' => 677,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 22,
                    'created_at' => '2024-11-28 08:15:52',
                    'updated_at' => '2024-11-28 08:15:52',
                ),
                177 => 
                array (
                    'id' => 678,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 22,
                    'created_at' => '2024-11-28 08:15:52',
                    'updated_at' => '2024-11-28 08:15:52',
                ),
                178 => 
                array (
                    'id' => 679,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 22,
                    'created_at' => '2024-11-28 08:15:52',
                    'updated_at' => '2024-11-28 08:15:52',
                ),
                179 => 
                array (
                    'id' => 680,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 22,
                    'created_at' => '2024-11-28 08:15:52',
                    'updated_at' => '2024-11-28 08:15:52',
                ),
                180 => 
                array (
                    'id' => 681,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 32,
                    'created_at' => '2024-11-28 08:15:55',
                    'updated_at' => '2024-11-28 08:15:55',
                ),
                181 => 
                array (
                    'id' => 682,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 32,
                    'created_at' => '2024-11-28 08:15:55',
                    'updated_at' => '2024-11-28 08:15:55',
                ),
                182 => 
                array (
                    'id' => 683,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 32,
                    'created_at' => '2024-11-28 08:15:55',
                    'updated_at' => '2024-11-28 08:15:55',
                ),
                183 => 
                array (
                    'id' => 684,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 32,
                    'created_at' => '2024-11-28 08:15:55',
                    'updated_at' => '2024-11-28 08:15:55',
                ),
                184 => 
                array (
                    'id' => 685,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 32,
                    'created_at' => '2024-11-28 08:15:55',
                    'updated_at' => '2024-11-28 08:15:55',
                ),
                185 => 
                array (
                    'id' => 686,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 32,
                    'created_at' => '2024-11-28 08:15:55',
                    'updated_at' => '2024-11-28 08:15:55',
                ),
                186 => 
                array (
                    'id' => 687,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 32,
                    'created_at' => '2024-11-28 08:15:55',
                    'updated_at' => '2024-11-28 08:15:55',
                ),
                187 => 
                array (
                    'id' => 688,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 32,
                    'created_at' => '2024-11-28 08:15:55',
                    'updated_at' => '2024-11-28 08:15:55',
                ),
                188 => 
                array (
                    'id' => 689,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 36,
                    'created_at' => '2024-11-28 08:15:59',
                    'updated_at' => '2024-11-28 08:15:59',
                ),
                189 => 
                array (
                    'id' => 690,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 36,
                    'created_at' => '2024-11-28 08:15:59',
                    'updated_at' => '2024-11-28 08:15:59',
                ),
                190 => 
                array (
                    'id' => 691,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 36,
                    'created_at' => '2024-11-28 08:15:59',
                    'updated_at' => '2024-11-28 08:15:59',
                ),
                191 => 
                array (
                    'id' => 692,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 36,
                    'created_at' => '2024-11-28 08:15:59',
                    'updated_at' => '2024-11-28 08:15:59',
                ),
                192 => 
                array (
                    'id' => 693,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 36,
                    'created_at' => '2024-11-28 08:15:59',
                    'updated_at' => '2024-11-28 08:15:59',
                ),
                193 => 
                array (
                    'id' => 694,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 36,
                    'created_at' => '2024-11-28 08:15:59',
                    'updated_at' => '2024-11-28 08:15:59',
                ),
                194 => 
                array (
                    'id' => 695,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 36,
                    'created_at' => '2024-11-28 08:15:59',
                    'updated_at' => '2024-11-28 08:15:59',
                ),
                195 => 
                array (
                    'id' => 696,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 36,
                    'created_at' => '2024-11-28 08:15:59',
                    'updated_at' => '2024-11-28 08:15:59',
                ),
                196 => 
                array (
                    'id' => 697,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 31,
                    'created_at' => '2024-11-28 08:20:27',
                    'updated_at' => '2024-11-28 08:20:27',
                ),
                197 => 
                array (
                    'id' => 698,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 31,
                    'created_at' => '2024-11-28 08:20:27',
                    'updated_at' => '2024-11-28 08:20:27',
                ),
                198 => 
                array (
                    'id' => 699,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 31,
                    'created_at' => '2024-11-28 08:20:27',
                    'updated_at' => '2024-11-28 08:20:27',
                ),
                199 => 
                array (
                    'id' => 700,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 31,
                    'created_at' => '2024-11-28 08:20:27',
                    'updated_at' => '2024-11-28 08:20:27',
                ),
                200 => 
                array (
                    'id' => 701,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 31,
                    'created_at' => '2024-11-28 08:20:27',
                    'updated_at' => '2024-11-28 08:20:27',
                ),
                201 => 
                array (
                    'id' => 702,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 31,
                    'created_at' => '2024-11-28 08:20:27',
                    'updated_at' => '2024-11-28 08:20:27',
                ),
                202 => 
                array (
                    'id' => 703,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 31,
                    'created_at' => '2024-11-28 08:20:27',
                    'updated_at' => '2024-11-28 08:20:27',
                ),
                203 => 
                array (
                    'id' => 704,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 31,
                    'created_at' => '2024-11-28 08:20:27',
                    'updated_at' => '2024-11-28 08:20:27',
                ),
                204 => 
                array (
                    'id' => 705,
                    'descripcion' => 'Servicios de Hot Tapping & Line Stopping.',
                    'job_id' => 53,
                    'created_at' => '2024-11-28 08:20:37',
                    'updated_at' => '2025-07-16 07:13:00',
                ),
                205 => 
                array (
                    'id' => 706,
                    'descripcion' => 'Servicios de Onshore y Offshore.',
                    'job_id' => 53,
                    'created_at' => '2024-11-28 08:20:37',
                    'updated_at' => '2025-07-16 07:13:00',
                ),
                206 => 
                array (
                    'id' => 707,
                    'descripcion' => 'Sector Energético y la industria de Oil & Gas.',
                    'job_id' => 53,
                    'created_at' => '2024-11-28 08:20:37',
                    'updated_at' => '2025-07-16 07:13:00',
                ),
                207 => 
                array (
                    'id' => 708,
                    'descripcion' => 'Integridad de ductos.',
                    'job_id' => 53,
                    'created_at' => '2024-11-28 08:20:37',
                    'updated_at' => '2025-07-16 07:13:00',
                ),
                208 => 
                array (
                    'id' => 709,
                    'descripcion' => 'Válvulas',
                    'job_id' => 53,
                    'created_at' => '2024-11-28 08:20:37',
                    'updated_at' => '2025-07-16 07:13:00',
                ),
                209 => 
                array (
                    'id' => 710,
                    'descripcion' => 'Soldadura especializada',
                    'job_id' => 53,
                    'created_at' => '2024-11-28 08:20:37',
                    'updated_at' => '2025-07-16 07:13:00',
                ),
                210 => 
                array (
                    'id' => 711,
                    'descripcion' => 'Ciclo general de ventas',
                    'job_id' => 53,
                    'created_at' => '2024-11-28 08:20:37',
                    'updated_at' => '2025-07-16 07:13:00',
                ),
                211 => 
                array (
                    'id' => 712,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 53,
                    'created_at' => '2024-11-28 08:20:37',
                    'updated_at' => '2024-11-28 08:20:37',
                ),
                212 => 
                array (
                    'id' => 713,
                'descripcion' => 'Teoría y práctica en Soldadura  (SMAW, GTAW) y su tipo (raíz abierta en servicio y/u otros).',
                    'job_id' => 18,
                    'created_at' => '2024-11-28 08:43:00',
                    'updated_at' => '2024-11-28 09:10:52',
                ),
                213 => 
                array (
                    'id' => 714,
                'descripcion' => 'Cálculos de Volúmenes de Soldadura y consumibles (BOM y BOE).',
                    'job_id' => 18,
                    'created_at' => '2024-11-28 08:43:00',
                    'updated_at' => '2024-11-28 09:10:52',
                ),
                214 => 
                array (
                    'id' => 715,
                'descripcion' => 'Preparación, fabricación y reparación de ensambles metal - mecánicos (tubero).',
                    'job_id' => 18,
                    'created_at' => '2024-11-28 08:43:00',
                    'updated_at' => '2024-11-28 09:10:52',
                ),
                215 => 
                array (
                    'id' => 716,
                    'descripcion' => 'Procedimientos, estándares y posiciones de soldadura.',
                    'job_id' => 18,
                    'created_at' => '2024-11-28 08:43:00',
                    'updated_at' => '2024-11-28 09:10:52',
                ),
                216 => 
                array (
                    'id' => 717,
                    'descripcion' => 'Inspección de instalaciones, materiales, equipos y superficies.',
                    'job_id' => 18,
                    'created_at' => '2024-11-28 08:43:00',
                    'updated_at' => '2024-11-28 09:10:52',
                ),
                217 => 
                array (
                    'id' => 718,
                    'descripcion' => 'Interpretación de planos de fabricación.',
                    'job_id' => 18,
                    'created_at' => '2024-11-28 08:43:00',
                    'updated_at' => '2024-11-28 09:10:52',
                ),
                218 => 
                array (
                    'id' => 719,
                'descripcion' => 'Cálculos de Volúmenes de Soldadura y consumibles (BOM y BOE).',
                    'job_id' => 18,
                    'created_at' => '2024-11-28 08:43:00',
                    'updated_at' => '2024-11-28 09:10:52',
                ),
                219 => 
                array (
                    'id' => 720,
                    'descripcion' => 'Sin llenar.',
                    'job_id' => 18,
                    'created_at' => '2024-11-28 08:43:00',
                    'updated_at' => '2024-11-28 09:10:52',
                ),
                220 => 
                array (
                    'id' => 729,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 37,
                    'created_at' => '2024-12-31 06:03:49',
                    'updated_at' => '2024-12-31 06:03:49',
                ),
                221 => 
                array (
                    'id' => 730,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 37,
                    'created_at' => '2024-12-31 06:03:49',
                    'updated_at' => '2024-12-31 06:03:49',
                ),
                222 => 
                array (
                    'id' => 731,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 37,
                    'created_at' => '2024-12-31 06:03:49',
                    'updated_at' => '2024-12-31 06:03:49',
                ),
                223 => 
                array (
                    'id' => 732,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 37,
                    'created_at' => '2024-12-31 06:03:49',
                    'updated_at' => '2024-12-31 06:03:49',
                ),
                224 => 
                array (
                    'id' => 733,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 37,
                    'created_at' => '2024-12-31 06:03:49',
                    'updated_at' => '2024-12-31 06:03:49',
                ),
                225 => 
                array (
                    'id' => 734,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 37,
                    'created_at' => '2024-12-31 06:03:49',
                    'updated_at' => '2024-12-31 06:03:49',
                ),
                226 => 
                array (
                    'id' => 735,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 37,
                    'created_at' => '2024-12-31 06:03:49',
                    'updated_at' => '2024-12-31 06:03:49',
                ),
                227 => 
                array (
                    'id' => 736,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 37,
                    'created_at' => '2024-12-31 06:03:49',
                    'updated_at' => '2024-12-31 06:03:49',
                ),
                228 => 
                array (
                    'id' => 737,
                    'descripcion' => 'Tolerancias dimensionales.',
                    'job_id' => 97,
                    'created_at' => '2024-12-31 06:07:57',
                    'updated_at' => '2025-05-28 04:04:29',
                ),
                229 => 
                array (
                    'id' => 738,
                    'descripcion' => 'Pruebas de corte.',
                    'job_id' => 97,
                    'created_at' => '2024-12-31 06:07:57',
                    'updated_at' => '2025-05-28 04:04:29',
                ),
                230 => 
                array (
                    'id' => 739,
                    'descripcion' => 'Metrología.',
                    'job_id' => 97,
                    'created_at' => '2024-12-31 06:07:57',
                    'updated_at' => '2025-05-28 04:04:29',
                ),
                231 => 
                array (
                    'id' => 740,
                    'descripcion' => 'Mecánica.',
                    'job_id' => 97,
                    'created_at' => '2024-12-31 06:07:57',
                    'updated_at' => '2025-05-28 04:04:29',
                ),
                232 => 
                array (
                    'id' => 741,
                    'descripcion' => 'Normativa ASME, API, NACE, ANSI, ASTM e ISO.',
                    'job_id' => 97,
                    'created_at' => '2024-12-31 06:07:57',
                    'updated_at' => '2025-05-28 04:04:29',
                ),
                233 => 
                array (
                    'id' => 742,
                    'descripcion' => 'Diseño e interpretación de planos.',
                    'job_id' => 97,
                    'created_at' => '2024-12-31 06:07:57',
                    'updated_at' => '2025-05-28 04:04:29',
                ),
                234 => 
                array (
                    'id' => 743,
                    'descripcion' => 'Manejo de software de diseño y simuladores.',
                    'job_id' => 97,
                    'created_at' => '2024-12-31 06:07:57',
                    'updated_at' => '2025-05-28 04:04:29',
                ),
                235 => 
                array (
                    'id' => 744,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 97,
                    'created_at' => '2024-12-31 06:07:57',
                    'updated_at' => '2024-12-31 06:07:57',
                ),
                236 => 
                array (
                    'id' => 745,
                    'descripcion' => 'Obra civil',
                    'job_id' => 98,
                    'created_at' => '2024-12-31 06:15:41',
                    'updated_at' => '2025-07-16 02:56:36',
                ),
                237 => 
                array (
                    'id' => 746,
                    'descripcion' => 'Metodología PMI',
                    'job_id' => 98,
                    'created_at' => '2024-12-31 06:15:41',
                    'updated_at' => '2025-07-16 02:56:36',
                ),
                238 => 
                array (
                    'id' => 747,
                    'descripcion' => 'Integridad de ductos',
                    'job_id' => 98,
                    'created_at' => '2024-12-31 06:15:41',
                    'updated_at' => '2025-07-16 02:56:36',
                ),
                239 => 
                array (
                    'id' => 748,
                    'descripcion' => 'Análisis de precios unitarios.',
                    'job_id' => 98,
                    'created_at' => '2024-12-31 06:15:41',
                    'updated_at' => '2025-07-16 02:56:36',
                ),
                240 => 
                array (
                    'id' => 749,
                    'descripcion' => 'Normatividad ASEA, ASME, API y otras aplicables',
                    'job_id' => 98,
                    'created_at' => '2024-12-31 06:15:41',
                    'updated_at' => '2025-07-16 02:56:36',
                ),
                241 => 
                array (
                    'id' => 750,
                    'descripcion' => 'Servicios de Hot Tapping & Line Stopping.',
                    'job_id' => 98,
                    'created_at' => '2024-12-31 06:15:41',
                    'updated_at' => '2025-07-16 02:56:36',
                ),
                242 => 
                array (
                    'id' => 751,
                    'descripcion' => 'Servicios de Onshore y Offshore.',
                    'job_id' => 98,
                    'created_at' => '2024-12-31 06:15:41',
                    'updated_at' => '2025-07-16 02:56:36',
                ),
                243 => 
                array (
                    'id' => 752,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 98,
                    'created_at' => '2024-12-31 06:15:41',
                    'updated_at' => '2024-12-31 06:15:41',
                ),
                244 => 
                array (
                    'id' => 753,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 99,
                    'created_at' => '2024-12-31 06:16:13',
                    'updated_at' => '2024-12-31 06:16:13',
                ),
                245 => 
                array (
                    'id' => 754,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 99,
                    'created_at' => '2024-12-31 06:16:13',
                    'updated_at' => '2024-12-31 06:16:13',
                ),
                246 => 
                array (
                    'id' => 755,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 99,
                    'created_at' => '2024-12-31 06:16:13',
                    'updated_at' => '2024-12-31 06:16:13',
                ),
                247 => 
                array (
                    'id' => 756,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 99,
                    'created_at' => '2024-12-31 06:16:13',
                    'updated_at' => '2024-12-31 06:16:13',
                ),
                248 => 
                array (
                    'id' => 757,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 99,
                    'created_at' => '2024-12-31 06:16:13',
                    'updated_at' => '2024-12-31 06:16:13',
                ),
                249 => 
                array (
                    'id' => 758,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 99,
                    'created_at' => '2024-12-31 06:16:13',
                    'updated_at' => '2024-12-31 06:16:13',
                ),
                250 => 
                array (
                    'id' => 759,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 99,
                    'created_at' => '2024-12-31 06:16:13',
                    'updated_at' => '2024-12-31 06:16:13',
                ),
                251 => 
                array (
                    'id' => 760,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 99,
                    'created_at' => '2024-12-31 06:16:13',
                    'updated_at' => '2024-12-31 06:16:13',
                ),
                252 => 
                array (
                    'id' => 761,
                    'descripcion' => 'Obra civil.',
                    'job_id' => 100,
                    'created_at' => '2024-12-31 06:16:44',
                    'updated_at' => '2025-07-16 02:48:19',
                ),
                253 => 
                array (
                    'id' => 762,
                    'descripcion' => 'Metodología PMI.',
                    'job_id' => 100,
                    'created_at' => '2024-12-31 06:16:44',
                    'updated_at' => '2025-07-16 02:48:19',
                ),
                254 => 
                array (
                    'id' => 763,
                    'descripcion' => 'Integridad de ductos.',
                    'job_id' => 100,
                    'created_at' => '2024-12-31 06:16:44',
                    'updated_at' => '2025-07-16 02:48:19',
                ),
                255 => 
                array (
                    'id' => 764,
                    'descripcion' => 'Análisis de precios unitarios.',
                    'job_id' => 100,
                    'created_at' => '2024-12-31 06:16:44',
                    'updated_at' => '2025-07-16 02:48:19',
                ),
                256 => 
                array (
                    'id' => 765,
                    'descripcion' => 'Normatividad ASEA, ASME, API y otras aplicables.',
                    'job_id' => 100,
                    'created_at' => '2024-12-31 06:16:44',
                    'updated_at' => '2025-07-16 02:48:19',
                ),
                257 => 
                array (
                    'id' => 766,
                    'descripcion' => 'Servicios de Hot Tapping & Line Stopping.',
                    'job_id' => 100,
                    'created_at' => '2024-12-31 06:16:44',
                    'updated_at' => '2025-07-16 02:48:19',
                ),
                258 => 
                array (
                    'id' => 767,
                    'descripcion' => 'Servicios de Onshore y Offshore.',
                    'job_id' => 100,
                    'created_at' => '2024-12-31 06:16:44',
                    'updated_at' => '2025-07-16 02:48:19',
                ),
                259 => 
                array (
                    'id' => 768,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 100,
                    'created_at' => '2024-12-31 06:16:44',
                    'updated_at' => '2024-12-31 06:16:44',
                ),
                260 => 
                array (
                    'id' => 769,
                    'descripcion' => 'Obra civil',
                    'job_id' => 101,
                    'created_at' => '2024-12-31 06:17:11',
                    'updated_at' => '2025-07-18 06:14:35',
                ),
                261 => 
                array (
                    'id' => 770,
                    'descripcion' => 'Metodología PMI',
                    'job_id' => 101,
                    'created_at' => '2024-12-31 06:17:11',
                    'updated_at' => '2025-07-18 06:14:35',
                ),
                262 => 
                array (
                    'id' => 771,
                    'descripcion' => 'Integridad de ductos',
                    'job_id' => 101,
                    'created_at' => '2024-12-31 06:17:11',
                    'updated_at' => '2025-07-18 06:14:35',
                ),
                263 => 
                array (
                    'id' => 772,
                    'descripcion' => 'Análisis de precios unitarios.',
                    'job_id' => 101,
                    'created_at' => '2024-12-31 06:17:11',
                    'updated_at' => '2025-07-18 06:14:35',
                ),
                264 => 
                array (
                    'id' => 773,
                    'descripcion' => 'Normatividad ASEA, ASME, API y otras aplicables',
                    'job_id' => 101,
                    'created_at' => '2024-12-31 06:17:11',
                    'updated_at' => '2025-07-18 06:14:35',
                ),
                265 => 
                array (
                    'id' => 774,
                    'descripcion' => 'Servicios de Hot Tapping & Line Stopping.',
                    'job_id' => 101,
                    'created_at' => '2024-12-31 06:17:11',
                    'updated_at' => '2025-07-18 06:14:35',
                ),
                266 => 
                array (
                    'id' => 775,
                    'descripcion' => 'Servicios de Onshore y Offshore.',
                    'job_id' => 101,
                    'created_at' => '2024-12-31 06:17:11',
                    'updated_at' => '2025-07-18 06:14:35',
                ),
                267 => 
                array (
                    'id' => 776,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 101,
                    'created_at' => '2024-12-31 06:17:11',
                    'updated_at' => '2024-12-31 06:17:11',
                ),
                268 => 
                array (
                    'id' => 777,
                'descripcion' => 'Inglés (capaz de entablar una conversación de negocios)',
                    'job_id' => 102,
                    'created_at' => '2024-12-31 06:17:42',
                    'updated_at' => '2025-07-16 06:44:40',
                ),
                269 => 
                array (
                    'id' => 778,
                'descripcion' => 'Conocimiento de los procesos involucrados e infraestructura requerida en el sector energético, petróleo, gas y petroquímica (upstream, medstream y downstream)',
                    'job_id' => 102,
                    'created_at' => '2024-12-31 06:17:42',
                    'updated_at' => '2025-07-16 06:44:40',
                ),
                270 => 
                array (
                    'id' => 779,
                    'descripcion' => 'Conocimiento en válvulas',
                    'job_id' => 102,
                    'created_at' => '2024-12-31 06:17:42',
                    'updated_at' => '2025-07-16 06:44:40',
                ),
                271 => 
                array (
                    'id' => 780,
                    'descripcion' => 'Servicios de Hot Tapping & Line Stopping.',
                    'job_id' => 102,
                    'created_at' => '2024-12-31 06:17:42',
                    'updated_at' => '2025-07-16 06:44:40',
                ),
                272 => 
                array (
                    'id' => 781,
                    'descripcion' => 'Integridad de ductos',
                    'job_id' => 102,
                    'created_at' => '2024-12-31 06:17:42',
                    'updated_at' => '2025-07-16 06:44:40',
                ),
                273 => 
                array (
                    'id' => 782,
                    'descripcion' => 'Soldadura',
                    'job_id' => 102,
                    'created_at' => '2024-12-31 06:17:42',
                    'updated_at' => '2025-07-16 06:44:40',
                ),
                274 => 
                array (
                    'id' => 783,
                    'descripcion' => 'Desarrollo de negocios',
                    'job_id' => 102,
                    'created_at' => '2024-12-31 06:17:42',
                    'updated_at' => '2025-07-16 06:44:40',
                ),
                275 => 
                array (
                    'id' => 784,
                    'descripcion' => 'Normatividad ASEA, ASME, API y otras aplicables',
                    'job_id' => 102,
                    'created_at' => '2024-12-31 06:17:42',
                    'updated_at' => '2025-07-16 06:44:40',
                ),
                276 => 
                array (
                    'id' => 785,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 103,
                    'created_at' => '2024-12-31 06:18:07',
                    'updated_at' => '2024-12-31 06:18:07',
                ),
                277 => 
                array (
                    'id' => 786,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 103,
                    'created_at' => '2024-12-31 06:18:07',
                    'updated_at' => '2024-12-31 06:18:07',
                ),
                278 => 
                array (
                    'id' => 787,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 103,
                    'created_at' => '2024-12-31 06:18:07',
                    'updated_at' => '2024-12-31 06:18:07',
                ),
                279 => 
                array (
                    'id' => 788,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 103,
                    'created_at' => '2024-12-31 06:18:07',
                    'updated_at' => '2024-12-31 06:18:07',
                ),
                280 => 
                array (
                    'id' => 789,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 103,
                    'created_at' => '2024-12-31 06:18:07',
                    'updated_at' => '2024-12-31 06:18:07',
                ),
                281 => 
                array (
                    'id' => 790,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 103,
                    'created_at' => '2024-12-31 06:18:07',
                    'updated_at' => '2024-12-31 06:18:07',
                ),
                282 => 
                array (
                    'id' => 791,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 103,
                    'created_at' => '2024-12-31 06:18:07',
                    'updated_at' => '2024-12-31 06:18:07',
                ),
                283 => 
                array (
                    'id' => 792,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 103,
                    'created_at' => '2024-12-31 06:18:07',
                    'updated_at' => '2024-12-31 06:18:07',
                ),
                284 => 
                array (
                    'id' => 793,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 104,
                    'created_at' => '2025-01-06 04:08:07',
                    'updated_at' => '2025-01-06 04:08:07',
                ),
                285 => 
                array (
                    'id' => 794,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 104,
                    'created_at' => '2025-01-06 04:08:07',
                    'updated_at' => '2025-01-06 04:08:07',
                ),
                286 => 
                array (
                    'id' => 795,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 104,
                    'created_at' => '2025-01-06 04:08:07',
                    'updated_at' => '2025-01-06 04:08:07',
                ),
                287 => 
                array (
                    'id' => 796,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 104,
                    'created_at' => '2025-01-06 04:08:07',
                    'updated_at' => '2025-01-06 04:08:07',
                ),
                288 => 
                array (
                    'id' => 797,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 104,
                    'created_at' => '2025-01-06 04:08:07',
                    'updated_at' => '2025-01-06 04:08:07',
                ),
                289 => 
                array (
                    'id' => 798,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 104,
                    'created_at' => '2025-01-06 04:08:07',
                    'updated_at' => '2025-01-06 04:08:07',
                ),
                290 => 
                array (
                    'id' => 799,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 104,
                    'created_at' => '2025-01-06 04:08:07',
                    'updated_at' => '2025-01-06 04:08:07',
                ),
                291 => 
                array (
                    'id' => 800,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 104,
                    'created_at' => '2025-01-06 04:08:07',
                    'updated_at' => '2025-01-06 04:08:07',
                ),
                292 => 
                array (
                    'id' => 801,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 105,
                    'created_at' => '2025-03-03 03:02:42',
                    'updated_at' => '2025-03-03 03:02:42',
                ),
                293 => 
                array (
                    'id' => 802,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 105,
                    'created_at' => '2025-03-03 03:02:42',
                    'updated_at' => '2025-03-03 03:02:42',
                ),
                294 => 
                array (
                    'id' => 803,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 105,
                    'created_at' => '2025-03-03 03:02:42',
                    'updated_at' => '2025-03-03 03:02:42',
                ),
                295 => 
                array (
                    'id' => 804,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 105,
                    'created_at' => '2025-03-03 03:02:42',
                    'updated_at' => '2025-03-03 03:02:42',
                ),
                296 => 
                array (
                    'id' => 805,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 105,
                    'created_at' => '2025-03-03 03:02:42',
                    'updated_at' => '2025-03-03 03:02:42',
                ),
                297 => 
                array (
                    'id' => 806,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 105,
                    'created_at' => '2025-03-03 03:02:42',
                    'updated_at' => '2025-03-03 03:02:42',
                ),
                298 => 
                array (
                    'id' => 807,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 105,
                    'created_at' => '2025-03-03 03:02:42',
                    'updated_at' => '2025-03-03 03:02:42',
                ),
                299 => 
                array (
                    'id' => 808,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 105,
                    'created_at' => '2025-03-03 03:02:42',
                    'updated_at' => '2025-03-03 03:02:42',
                ),
                300 => 
                array (
                    'id' => 809,
                'descripcion' => 'Lenguajes de Programación: Java, Python, JavaScript, C#, PHP, TypeScript, Ruby, Kotlin, Swift (según el rol).',
                    'job_id' => 106,
                    'created_at' => '2025-04-08 07:21:49',
                    'updated_at' => '2025-07-20 06:25:25',
                ),
                301 => 
                array (
                    'id' => 810,
                    'descripcion' => 'Conocimiento de buenas prácticas de codificación y principios SOLID.',
                    'job_id' => 106,
                    'created_at' => '2025-04-08 07:21:49',
                    'updated_at' => '2025-07-20 06:25:25',
                ),
                302 => 
                array (
                    'id' => 811,
                    'descripcion' => ' Desarrollo Web: Frontend: HTML5, CSS3, JavaScript, Bootstrap, frameworks como React, Angular, Vue.js.',
                    'job_id' => 106,
                    'created_at' => '2025-04-08 07:21:49',
                    'updated_at' => '2025-07-20 06:25:25',
                ),
                303 => 
                array (
                    'id' => 812,
                    'descripcion' => ' Desarrollo Web: Backend: Node.js, Express, Django, Flask, Laravel, .NET, Spring Boot.',
                    'job_id' => 106,
                    'created_at' => '2025-04-08 07:21:49',
                    'updated_at' => '2025-07-20 06:25:25',
                ),
                304 => 
                array (
                    'id' => 813,
                'descripcion' => 'Modelado y manejo de bases de datos relacionales (MySQL, PostgreSQL, SQL Server).',
                    'job_id' => 106,
                    'created_at' => '2025-04-08 07:21:49',
                    'updated_at' => '2025-07-20 06:25:25',
                ),
                305 => 
                array (
                    'id' => 814,
                    'descripcion' => 'Uso de bases de datos ',
                    'job_id' => 106,
                    'created_at' => '2025-04-08 07:21:49',
                    'updated_at' => '2025-07-20 06:25:25',
                ),
                306 => 
                array (
                    'id' => 815,
                    'descripcion' => '.',
                    'job_id' => 106,
                    'created_at' => '2025-04-08 07:21:49',
                    'updated_at' => '2025-07-20 06:25:25',
                ),
                307 => 
                array (
                    'id' => 816,
                    'descripcion' => '.',
                    'job_id' => 106,
                    'created_at' => '2025-04-08 07:21:49',
                    'updated_at' => '2025-07-20 06:25:25',
                ),
                308 => 
                array (
                    'id' => 817,
                    'descripcion' => 'Uso y manejo básico de Office.',
                    'job_id' => 107,
                    'created_at' => '2025-05-06 01:16:16',
                    'updated_at' => '2025-07-16 07:29:21',
                ),
                309 => 
                array (
                    'id' => 818,
                    'descripcion' => 'Control documental / captura de datos.',
                    'job_id' => 107,
                    'created_at' => '2025-05-06 01:16:16',
                    'updated_at' => '2025-07-16 07:29:21',
                ),
                310 => 
                array (
                    'id' => 819,
                    'descripcion' => 'Elaboración de reportes.',
                    'job_id' => 107,
                    'created_at' => '2025-05-06 01:16:16',
                    'updated_at' => '2025-07-16 07:29:21',
                ),
                311 => 
                array (
                    'id' => 820,
                    'descripcion' => 'Uso y manejo de herramientas de Google.',
                    'job_id' => 107,
                    'created_at' => '2025-05-06 01:16:16',
                    'updated_at' => '2025-07-16 07:29:21',
                ),
                312 => 
                array (
                    'id' => 821,
                    'descripcion' => 'Elaboración de registros.',
                    'job_id' => 107,
                    'created_at' => '2025-05-06 01:16:16',
                    'updated_at' => '2025-07-16 07:29:21',
                ),
                313 => 
                array (
                    'id' => 822,
                    'descripcion' => 'Uso y manejo de computadora.',
                    'job_id' => 107,
                    'created_at' => '2025-05-06 01:16:16',
                    'updated_at' => '2025-07-16 07:29:21',
                ),
                314 => 
                array (
                    'id' => 823,
                    'descripcion' => 'Uso y manejo de impresora.',
                    'job_id' => 107,
                    'created_at' => '2025-05-06 01:16:16',
                    'updated_at' => '2025-07-16 07:29:21',
                ),
                315 => 
                array (
                    'id' => 824,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 107,
                    'created_at' => '2025-05-06 01:16:16',
                    'updated_at' => '2025-05-06 01:16:16',
                ),
                316 => 
                array (
                    'id' => 825,
                    'descripcion' => 'Manejo de PC.',
                    'job_id' => 108,
                    'created_at' => '2025-05-27 09:40:24',
                    'updated_at' => '2025-05-27 10:02:33',
                ),
                317 => 
                array (
                    'id' => 826,
                'descripcion' => 'Manejo de Normas de Gestión en materia de Seguridad, salud ocupacional y medio ambiente (ISO 14001-ISO45001,9001, 37001)',
                    'job_id' => 108,
                    'created_at' => '2025-05-27 09:40:24',
                    'updated_at' => '2025-05-27 10:02:33',
                ),
                318 => 
                array (
                    'id' => 827,
                    'descripcion' => 'Manejo de Leyes, Reglamentos y Estatutos relativos al área de seguridad industrial, protección ambiental y salud ocupacional.',
                    'job_id' => 108,
                    'created_at' => '2025-05-27 09:40:24',
                    'updated_at' => '2025-05-27 10:02:33',
                ),
                319 => 
                array (
                    'id' => 828,
                    'descripcion' => 'Experiencia en atencion de Auditorias, inspecciones y gestion de tramites',
                    'job_id' => 108,
                    'created_at' => '2025-05-27 09:40:24',
                    'updated_at' => '2025-05-27 10:02:33',
                ),
                320 => 
                array (
                    'id' => 829,
                    'descripcion' => 'Políticas, Normas y Procedimientos en materia de seguridad industrial, protección ambiental y salud ocupacional.',
                    'job_id' => 108,
                    'created_at' => '2025-05-27 09:40:24',
                    'updated_at' => '2025-05-27 10:02:33',
                ),
                321 => 
                array (
                    'id' => 830,
                    'descripcion' => 'Métodos de prevención y registros de accidentes, inspecciones y otros',
                    'job_id' => 108,
                    'created_at' => '2025-05-27 09:40:24',
                    'updated_at' => '2025-05-27 10:02:33',
                ),
                322 => 
                array (
                    'id' => 831,
                'descripcion' => 'Equipos de evaluación ambiental (Detector de Gases, sonometro, luxometro etc)',
                    'job_id' => 108,
                    'created_at' => '2025-05-27 09:40:24',
                    'updated_at' => '2025-05-27 10:02:33',
                ),
                323 => 
                array (
                    'id' => 832,
                    'descripcion' => 'Conocimiento en elaboración de procedimientos ',
                    'job_id' => 108,
                    'created_at' => '2025-05-27 09:40:24',
                    'updated_at' => '2025-05-27 10:02:33',
                ),
                324 => 
                array (
                    'id' => 833,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 109,
                    'created_at' => '2025-06-02 06:42:40',
                    'updated_at' => '2025-06-02 06:42:40',
                ),
                325 => 
                array (
                    'id' => 834,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 109,
                    'created_at' => '2025-06-02 06:42:40',
                    'updated_at' => '2025-06-02 06:42:40',
                ),
                326 => 
                array (
                    'id' => 835,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 109,
                    'created_at' => '2025-06-02 06:42:40',
                    'updated_at' => '2025-06-02 06:42:40',
                ),
                327 => 
                array (
                    'id' => 836,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 109,
                    'created_at' => '2025-06-02 06:42:40',
                    'updated_at' => '2025-06-02 06:42:40',
                ),
                328 => 
                array (
                    'id' => 837,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 109,
                    'created_at' => '2025-06-02 06:42:40',
                    'updated_at' => '2025-06-02 06:42:40',
                ),
                329 => 
                array (
                    'id' => 838,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 109,
                    'created_at' => '2025-06-02 06:42:40',
                    'updated_at' => '2025-06-02 06:42:40',
                ),
                330 => 
                array (
                    'id' => 839,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 109,
                    'created_at' => '2025-06-02 06:42:40',
                    'updated_at' => '2025-06-02 06:42:40',
                ),
                331 => 
                array (
                    'id' => 840,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 109,
                    'created_at' => '2025-06-02 06:42:40',
                    'updated_at' => '2025-06-02 06:42:40',
                ),
                332 => 
                array (
                    'id' => 841,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 110,
                    'created_at' => '2025-06-02 06:43:06',
                    'updated_at' => '2025-06-02 06:43:06',
                ),
                333 => 
                array (
                    'id' => 842,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 110,
                    'created_at' => '2025-06-02 06:43:06',
                    'updated_at' => '2025-06-02 06:43:06',
                ),
                334 => 
                array (
                    'id' => 843,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 110,
                    'created_at' => '2025-06-02 06:43:06',
                    'updated_at' => '2025-06-02 06:43:06',
                ),
                335 => 
                array (
                    'id' => 844,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 110,
                    'created_at' => '2025-06-02 06:43:06',
                    'updated_at' => '2025-06-02 06:43:06',
                ),
                336 => 
                array (
                    'id' => 845,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 110,
                    'created_at' => '2025-06-02 06:43:06',
                    'updated_at' => '2025-06-02 06:43:06',
                ),
                337 => 
                array (
                    'id' => 846,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 110,
                    'created_at' => '2025-06-02 06:43:06',
                    'updated_at' => '2025-06-02 06:43:06',
                ),
                338 => 
                array (
                    'id' => 847,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 110,
                    'created_at' => '2025-06-02 06:43:06',
                    'updated_at' => '2025-06-02 06:43:06',
                ),
                339 => 
                array (
                    'id' => 848,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 110,
                    'created_at' => '2025-06-02 06:43:06',
                    'updated_at' => '2025-06-02 06:43:06',
                ),
                340 => 
                array (
                    'id' => 849,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 111,
                    'created_at' => '2025-06-13 07:12:02',
                    'updated_at' => '2025-06-13 07:12:02',
                ),
                341 => 
                array (
                    'id' => 850,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 111,
                    'created_at' => '2025-06-13 07:12:02',
                    'updated_at' => '2025-06-13 07:12:02',
                ),
                342 => 
                array (
                    'id' => 851,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 111,
                    'created_at' => '2025-06-13 07:12:02',
                    'updated_at' => '2025-06-13 07:12:02',
                ),
                343 => 
                array (
                    'id' => 852,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 111,
                    'created_at' => '2025-06-13 07:12:02',
                    'updated_at' => '2025-06-13 07:12:02',
                ),
                344 => 
                array (
                    'id' => 853,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 111,
                    'created_at' => '2025-06-13 07:12:02',
                    'updated_at' => '2025-06-13 07:12:02',
                ),
                345 => 
                array (
                    'id' => 854,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 111,
                    'created_at' => '2025-06-13 07:12:02',
                    'updated_at' => '2025-06-13 07:12:02',
                ),
                346 => 
                array (
                    'id' => 855,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 111,
                    'created_at' => '2025-06-13 07:12:02',
                    'updated_at' => '2025-06-13 07:12:02',
                ),
                347 => 
                array (
                    'id' => 856,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 111,
                    'created_at' => '2025-06-13 07:12:02',
                    'updated_at' => '2025-06-13 07:12:02',
                ),
                348 => 
                array (
                    'id' => 857,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 112,
                    'created_at' => '2025-06-13 07:15:00',
                    'updated_at' => '2025-06-13 07:15:00',
                ),
                349 => 
                array (
                    'id' => 858,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 112,
                    'created_at' => '2025-06-13 07:15:00',
                    'updated_at' => '2025-06-13 07:15:00',
                ),
                350 => 
                array (
                    'id' => 859,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 112,
                    'created_at' => '2025-06-13 07:15:00',
                    'updated_at' => '2025-06-13 07:15:00',
                ),
                351 => 
                array (
                    'id' => 860,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 112,
                    'created_at' => '2025-06-13 07:15:00',
                    'updated_at' => '2025-06-13 07:15:00',
                ),
                352 => 
                array (
                    'id' => 861,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 112,
                    'created_at' => '2025-06-13 07:15:00',
                    'updated_at' => '2025-06-13 07:15:00',
                ),
                353 => 
                array (
                    'id' => 862,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 112,
                    'created_at' => '2025-06-13 07:15:00',
                    'updated_at' => '2025-06-13 07:15:00',
                ),
                354 => 
                array (
                    'id' => 863,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 112,
                    'created_at' => '2025-06-13 07:15:00',
                    'updated_at' => '2025-06-13 07:15:00',
                ),
                355 => 
                array (
                    'id' => 864,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 112,
                    'created_at' => '2025-06-13 07:15:00',
                    'updated_at' => '2025-06-13 07:15:00',
                ),
                356 => 
                array (
                    'id' => 865,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 113,
                    'created_at' => '2025-06-13 07:15:23',
                    'updated_at' => '2025-06-13 07:15:23',
                ),
                357 => 
                array (
                    'id' => 866,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 113,
                    'created_at' => '2025-06-13 07:15:23',
                    'updated_at' => '2025-06-13 07:15:23',
                ),
                358 => 
                array (
                    'id' => 867,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 113,
                    'created_at' => '2025-06-13 07:15:23',
                    'updated_at' => '2025-06-13 07:15:23',
                ),
                359 => 
                array (
                    'id' => 868,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 113,
                    'created_at' => '2025-06-13 07:15:23',
                    'updated_at' => '2025-06-13 07:15:23',
                ),
                360 => 
                array (
                    'id' => 869,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 113,
                    'created_at' => '2025-06-13 07:15:23',
                    'updated_at' => '2025-06-13 07:15:23',
                ),
                361 => 
                array (
                    'id' => 870,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 113,
                    'created_at' => '2025-06-13 07:15:23',
                    'updated_at' => '2025-06-13 07:15:23',
                ),
                362 => 
                array (
                    'id' => 871,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 113,
                    'created_at' => '2025-06-13 07:15:23',
                    'updated_at' => '2025-06-13 07:15:23',
                ),
                363 => 
                array (
                    'id' => 872,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 113,
                    'created_at' => '2025-06-13 07:15:23',
                    'updated_at' => '2025-06-13 07:15:23',
                ),
                364 => 
                array (
                    'id' => 873,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 114,
                    'created_at' => '2025-06-30 02:15:09',
                    'updated_at' => '2025-06-30 02:15:09',
                ),
                365 => 
                array (
                    'id' => 874,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 114,
                    'created_at' => '2025-06-30 02:15:09',
                    'updated_at' => '2025-06-30 02:15:09',
                ),
                366 => 
                array (
                    'id' => 875,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 114,
                    'created_at' => '2025-06-30 02:15:09',
                    'updated_at' => '2025-06-30 02:15:09',
                ),
                367 => 
                array (
                    'id' => 876,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 114,
                    'created_at' => '2025-06-30 02:15:09',
                    'updated_at' => '2025-06-30 02:15:09',
                ),
                368 => 
                array (
                    'id' => 877,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 114,
                    'created_at' => '2025-06-30 02:15:09',
                    'updated_at' => '2025-06-30 02:15:09',
                ),
                369 => 
                array (
                    'id' => 878,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 114,
                    'created_at' => '2025-06-30 02:15:09',
                    'updated_at' => '2025-06-30 02:15:09',
                ),
                370 => 
                array (
                    'id' => 879,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 114,
                    'created_at' => '2025-06-30 02:15:09',
                    'updated_at' => '2025-06-30 02:15:09',
                ),
                371 => 
                array (
                    'id' => 880,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 114,
                    'created_at' => '2025-06-30 02:15:09',
                    'updated_at' => '2025-06-30 02:15:09',
                ),
                372 => 
                array (
                    'id' => 881,
                    'descripcion' => 'KPI\'s',
                    'job_id' => 115,
                    'created_at' => '2025-07-01 05:13:01',
                    'updated_at' => '2025-07-18 05:59:34',
                ),
                373 => 
                array (
                    'id' => 882,
                    'descripcion' => 'Costos y presupuestos',
                    'job_id' => 115,
                    'created_at' => '2025-07-01 05:13:01',
                    'updated_at' => '2025-07-18 05:59:34',
                ),
                374 => 
                array (
                    'id' => 883,
                    'descripcion' => 'Interpretación de planos',
                    'job_id' => 115,
                    'created_at' => '2025-07-01 05:13:01',
                    'updated_at' => '2025-07-18 05:59:34',
                ),
                375 => 
                array (
                    'id' => 884,
                    'descripcion' => 'Normas y cumplimiento de seguridad e higiene.',
                    'job_id' => 115,
                    'created_at' => '2025-07-01 05:13:01',
                    'updated_at' => '2025-07-18 05:59:34',
                ),
                376 => 
                array (
                    'id' => 885,
                    'descripcion' => 'Estimaciones',
                    'job_id' => 115,
                    'created_at' => '2025-07-01 05:13:01',
                    'updated_at' => '2025-07-18 05:59:34',
                ),
                377 => 
                array (
                    'id' => 886,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 115,
                    'created_at' => '2025-07-01 05:13:01',
                    'updated_at' => '2025-07-01 05:13:01',
                ),
                378 => 
                array (
                    'id' => 887,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 115,
                    'created_at' => '2025-07-01 05:13:01',
                    'updated_at' => '2025-07-01 05:13:01',
                ),
                379 => 
                array (
                    'id' => 888,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 115,
                    'created_at' => '2025-07-01 05:13:01',
                    'updated_at' => '2025-07-01 05:13:01',
                ),
                380 => 
                array (
                    'id' => 889,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 116,
                    'created_at' => '2025-07-14 01:59:05',
                    'updated_at' => '2025-07-14 01:59:05',
                ),
                381 => 
                array (
                    'id' => 890,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 116,
                    'created_at' => '2025-07-14 01:59:05',
                    'updated_at' => '2025-07-14 01:59:05',
                ),
                382 => 
                array (
                    'id' => 891,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 116,
                    'created_at' => '2025-07-14 01:59:05',
                    'updated_at' => '2025-07-14 01:59:05',
                ),
                383 => 
                array (
                    'id' => 892,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 116,
                    'created_at' => '2025-07-14 01:59:05',
                    'updated_at' => '2025-07-14 01:59:05',
                ),
                384 => 
                array (
                    'id' => 893,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 116,
                    'created_at' => '2025-07-14 01:59:05',
                    'updated_at' => '2025-07-14 01:59:05',
                ),
                385 => 
                array (
                    'id' => 894,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 116,
                    'created_at' => '2025-07-14 01:59:05',
                    'updated_at' => '2025-07-14 01:59:05',
                ),
                386 => 
                array (
                    'id' => 895,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 116,
                    'created_at' => '2025-07-14 01:59:05',
                    'updated_at' => '2025-07-14 01:59:05',
                ),
                387 => 
                array (
                    'id' => 896,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 116,
                    'created_at' => '2025-07-14 01:59:05',
                    'updated_at' => '2025-07-14 01:59:05',
                ),
                388 => 
                array (
                    'id' => 897,
                    'descripcion' => 'Mecánica, Hidráulica y Neumática.',
                    'job_id' => 117,
                    'created_at' => '2025-07-14 07:39:37',
                    'updated_at' => '2025-07-15 06:56:45',
                ),
                389 => 
                array (
                    'id' => 898,
                    'descripcion' => 'Metrología.',
                    'job_id' => 117,
                    'created_at' => '2025-07-14 07:39:37',
                    'updated_at' => '2025-07-15 06:56:45',
                ),
                390 => 
                array (
                    'id' => 899,
                    'descripcion' => 'Procesos de manufactura.',
                    'job_id' => 117,
                    'created_at' => '2025-07-14 07:39:37',
                    'updated_at' => '2025-07-15 06:56:45',
                ),
                391 => 
                array (
                    'id' => 900,
                    'descripcion' => 'Control de la productividad.',
                    'job_id' => 117,
                    'created_at' => '2025-07-14 07:39:37',
                    'updated_at' => '2025-07-15 06:56:45',
                ),
                392 => 
                array (
                    'id' => 901,
                    'descripcion' => 'Normatividad ASEA, ASME.',
                    'job_id' => 117,
                    'created_at' => '2025-07-14 07:39:37',
                    'updated_at' => '2025-07-15 06:56:45',
                ),
                393 => 
                array (
                    'id' => 902,
                    'descripcion' => 'Básico en válvulas.',
                    'job_id' => 117,
                    'created_at' => '2025-07-14 07:39:37',
                    'updated_at' => '2025-07-15 06:56:45',
                ),
                394 => 
                array (
                    'id' => 903,
                    'descripcion' => 'Simbología y especificaciones de soldadura.',
                    'job_id' => 117,
                    'created_at' => '2025-07-14 07:39:37',
                    'updated_at' => '2025-07-15 06:56:45',
                ),
                395 => 
                array (
                    'id' => 904,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 117,
                    'created_at' => '2025-07-14 07:39:37',
                    'updated_at' => '2025-07-14 07:39:37',
                ),
                396 => 
                array (
                    'id' => 905,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 118,
                    'created_at' => '2025-07-15 01:33:48',
                    'updated_at' => '2025-07-15 01:33:48',
                ),
                397 => 
                array (
                    'id' => 906,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 118,
                    'created_at' => '2025-07-15 01:33:48',
                    'updated_at' => '2025-07-15 01:33:48',
                ),
                398 => 
                array (
                    'id' => 907,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 118,
                    'created_at' => '2025-07-15 01:33:48',
                    'updated_at' => '2025-07-15 01:33:48',
                ),
                399 => 
                array (
                    'id' => 908,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 118,
                    'created_at' => '2025-07-15 01:33:48',
                    'updated_at' => '2025-07-15 01:33:48',
                ),
                400 => 
                array (
                    'id' => 909,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 118,
                    'created_at' => '2025-07-15 01:33:48',
                    'updated_at' => '2025-07-15 01:33:48',
                ),
                401 => 
                array (
                    'id' => 910,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 118,
                    'created_at' => '2025-07-15 01:33:48',
                    'updated_at' => '2025-07-15 01:33:48',
                ),
                402 => 
                array (
                    'id' => 911,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 118,
                    'created_at' => '2025-07-15 01:33:48',
                    'updated_at' => '2025-07-15 01:33:48',
                ),
                403 => 
                array (
                    'id' => 912,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 118,
                    'created_at' => '2025-07-15 01:33:48',
                    'updated_at' => '2025-07-15 01:33:48',
                ),
                404 => 
                array (
                    'id' => 913,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 119,
                    'created_at' => '2025-08-04 05:19:57',
                    'updated_at' => '2025-08-04 05:19:57',
                ),
                405 => 
                array (
                    'id' => 914,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 119,
                    'created_at' => '2025-08-04 05:19:57',
                    'updated_at' => '2025-08-04 05:19:57',
                ),
                406 => 
                array (
                    'id' => 915,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 119,
                    'created_at' => '2025-08-04 05:19:57',
                    'updated_at' => '2025-08-04 05:19:57',
                ),
                407 => 
                array (
                    'id' => 916,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 119,
                    'created_at' => '2025-08-04 05:19:57',
                    'updated_at' => '2025-08-04 05:19:57',
                ),
                408 => 
                array (
                    'id' => 917,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 119,
                    'created_at' => '2025-08-04 05:19:57',
                    'updated_at' => '2025-08-04 05:19:57',
                ),
                409 => 
                array (
                    'id' => 918,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 119,
                    'created_at' => '2025-08-04 05:19:57',
                    'updated_at' => '2025-08-04 05:19:57',
                ),
                410 => 
                array (
                    'id' => 919,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 119,
                    'created_at' => '2025-08-04 05:19:57',
                    'updated_at' => '2025-08-04 05:19:57',
                ),
                411 => 
                array (
                    'id' => 920,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 119,
                    'created_at' => '2025-08-04 05:19:57',
                    'updated_at' => '2025-08-04 05:19:57',
                ),
                412 => 
                array (
                    'id' => 921,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 120,
                    'created_at' => '2025-08-11 04:53:39',
                    'updated_at' => '2025-08-11 04:53:39',
                ),
                413 => 
                array (
                    'id' => 922,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 120,
                    'created_at' => '2025-08-11 04:53:39',
                    'updated_at' => '2025-08-11 04:53:39',
                ),
                414 => 
                array (
                    'id' => 923,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 120,
                    'created_at' => '2025-08-11 04:53:39',
                    'updated_at' => '2025-08-11 04:53:39',
                ),
                415 => 
                array (
                    'id' => 924,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 120,
                    'created_at' => '2025-08-11 04:53:39',
                    'updated_at' => '2025-08-11 04:53:39',
                ),
                416 => 
                array (
                    'id' => 925,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 120,
                    'created_at' => '2025-08-11 04:53:39',
                    'updated_at' => '2025-08-11 04:53:39',
                ),
                417 => 
                array (
                    'id' => 926,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 120,
                    'created_at' => '2025-08-11 04:53:39',
                    'updated_at' => '2025-08-11 04:53:39',
                ),
                418 => 
                array (
                    'id' => 927,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 120,
                    'created_at' => '2025-08-11 04:53:39',
                    'updated_at' => '2025-08-11 04:53:39',
                ),
                419 => 
                array (
                    'id' => 928,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 120,
                    'created_at' => '2025-08-11 04:53:39',
                    'updated_at' => '2025-08-11 04:53:39',
                ),
                420 => 
                array (
                    'id' => 929,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 121,
                    'created_at' => '2025-09-01 01:09:56',
                    'updated_at' => '2025-09-01 01:09:56',
                ),
                421 => 
                array (
                    'id' => 930,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 121,
                    'created_at' => '2025-09-01 01:09:56',
                    'updated_at' => '2025-09-01 01:09:56',
                ),
                422 => 
                array (
                    'id' => 931,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 121,
                    'created_at' => '2025-09-01 01:09:56',
                    'updated_at' => '2025-09-01 01:09:56',
                ),
                423 => 
                array (
                    'id' => 932,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 121,
                    'created_at' => '2025-09-01 01:09:56',
                    'updated_at' => '2025-09-01 01:09:56',
                ),
                424 => 
                array (
                    'id' => 933,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 121,
                    'created_at' => '2025-09-01 01:09:56',
                    'updated_at' => '2025-09-01 01:09:56',
                ),
                425 => 
                array (
                    'id' => 934,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 121,
                    'created_at' => '2025-09-01 01:09:56',
                    'updated_at' => '2025-09-01 01:09:56',
                ),
                426 => 
                array (
                    'id' => 935,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 121,
                    'created_at' => '2025-09-01 01:09:56',
                    'updated_at' => '2025-09-01 01:09:56',
                ),
                427 => 
                array (
                    'id' => 936,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 121,
                    'created_at' => '2025-09-01 01:09:56',
                    'updated_at' => '2025-09-01 01:09:56',
                ),
                428 => 
                array (
                    'id' => 937,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 122,
                    'created_at' => '2025-09-30 02:28:07',
                    'updated_at' => '2025-09-30 02:28:07',
                ),
                429 => 
                array (
                    'id' => 938,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 122,
                    'created_at' => '2025-09-30 02:28:07',
                    'updated_at' => '2025-09-30 02:28:07',
                ),
                430 => 
                array (
                    'id' => 939,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 122,
                    'created_at' => '2025-09-30 02:28:07',
                    'updated_at' => '2025-09-30 02:28:07',
                ),
                431 => 
                array (
                    'id' => 940,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 122,
                    'created_at' => '2025-09-30 02:28:07',
                    'updated_at' => '2025-09-30 02:28:07',
                ),
                432 => 
                array (
                    'id' => 941,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 122,
                    'created_at' => '2025-09-30 02:28:07',
                    'updated_at' => '2025-09-30 02:28:07',
                ),
                433 => 
                array (
                    'id' => 942,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 122,
                    'created_at' => '2025-09-30 02:28:07',
                    'updated_at' => '2025-09-30 02:28:07',
                ),
                434 => 
                array (
                    'id' => 943,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 122,
                    'created_at' => '2025-09-30 02:28:07',
                    'updated_at' => '2025-09-30 02:28:07',
                ),
                435 => 
                array (
                    'id' => 944,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 122,
                    'created_at' => '2025-09-30 02:28:07',
                    'updated_at' => '2025-09-30 02:28:07',
                ),
                436 => 
                array (
                    'id' => 945,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 123,
                    'created_at' => '2025-09-30 02:40:55',
                    'updated_at' => '2025-09-30 02:40:55',
                ),
                437 => 
                array (
                    'id' => 946,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 123,
                    'created_at' => '2025-09-30 02:40:55',
                    'updated_at' => '2025-09-30 02:40:55',
                ),
                438 => 
                array (
                    'id' => 947,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 123,
                    'created_at' => '2025-09-30 02:40:55',
                    'updated_at' => '2025-09-30 02:40:55',
                ),
                439 => 
                array (
                    'id' => 948,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 123,
                    'created_at' => '2025-09-30 02:40:55',
                    'updated_at' => '2025-09-30 02:40:55',
                ),
                440 => 
                array (
                    'id' => 949,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 123,
                    'created_at' => '2025-09-30 02:40:55',
                    'updated_at' => '2025-09-30 02:40:55',
                ),
                441 => 
                array (
                    'id' => 950,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 123,
                    'created_at' => '2025-09-30 02:40:55',
                    'updated_at' => '2025-09-30 02:40:55',
                ),
                442 => 
                array (
                    'id' => 951,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 123,
                    'created_at' => '2025-09-30 02:40:55',
                    'updated_at' => '2025-09-30 02:40:55',
                ),
                443 => 
                array (
                    'id' => 952,
                    'descripcion' => 'Sin llenar',
                    'job_id' => 123,
                    'created_at' => '2025-09-30 02:40:55',
                    'updated_at' => '2025-09-30 02:40:55',
                ),
                444 => 
                array (
                    'id' => 953,
                'descripcion' => 'Operación de máquinas-herramientas y centro de maquinado CNC (Control Fanuc y Mitsubishi).',
                    'job_id' => 124,
                    'created_at' => '2025-10-14 05:37:49',
                    'updated_at' => '2025-10-16 07:14:29',
                ),
                445 => 
                array (
                    'id' => 954,
                    'descripcion' => 'Conocimiento en el mantenimiento preventivo de máquinas-herramientas y centro de maquinado CNC.',
                    'job_id' => 124,
                    'created_at' => '2025-10-14 05:37:49',
                    'updated_at' => '2025-10-16 07:14:29',
                ),
                446 => 
                array (
                    'id' => 955,
                    'descripcion' => 'Clasificación de materiales.',
                    'job_id' => 124,
                    'created_at' => '2025-10-14 05:37:49',
                    'updated_at' => '2025-10-14 06:45:45',
                ),
                447 => 
                array (
                    'id' => 956,
                    'descripcion' => 'Manejo de instrumentos de medición.',
                    'job_id' => 124,
                    'created_at' => '2025-10-14 05:37:49',
                    'updated_at' => '2025-10-14 06:45:45',
                ),
                448 => 
                array (
                    'id' => 957,
                    'descripcion' => 'Interpretación de planos y simbología.',
                    'job_id' => 124,
                    'created_at' => '2025-10-14 05:37:49',
                    'updated_at' => '2025-10-14 06:45:45',
                ),
                449 => 
                array (
                    'id' => 958,
                    'descripcion' => 'Inspección de piezas.',
                    'job_id' => 124,
                    'created_at' => '2025-10-14 05:37:49',
                    'updated_at' => '2025-10-14 06:45:45',
                ),
                450 => 
                array (
                    'id' => 959,
                    'descripcion' => 'Conocimiento de herramientas de corte para la operación de máquinas-herramientas y centro de maquinado CNC.',
                    'job_id' => 124,
                    'created_at' => '2025-10-14 05:37:49',
                    'updated_at' => '2025-10-16 07:14:29',
                ),
                451 => 
                array (
                    'id' => 960,
                'descripcion' => ' Programación CNC a pie de máquina (códigos G y M).',
                    'job_id' => 124,
                    'created_at' => '2025-10-14 05:37:49',
                    'updated_at' => '2025-10-16 07:14:29',
                ),
            ));
        
        
    }
}