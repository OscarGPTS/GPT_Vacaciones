<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CvCursoCertificacionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cv_curso_certificacions')->delete();
        
        \DB::table('cv_curso_certificacions')->insert(array (
            0 => 
            array (
                'id' => 20,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 10,
                'created_at' => '2023-08-23 00:06:29',
                'updated_at' => '2023-09-26 20:18:22',
            ),
            1 => 
            array (
                'id' => 313,
            'nombre' => 'Inspección Visual Nivel I y II (SNT-TC-1A)',
                'tipo' => 'externo',
                'year' => '2018',
                'user_id' => 36,
                'created_at' => '2023-10-24 02:40:47',
                'updated_at' => '2023-10-24 02:40:47',
            ),
            2 => 
            array (
                'id' => 314,
                'nombre' => 'Nueva NOM-007-ASEA-2016: Operación de Ductos para Gas Natural, Etano y Asociados',
                'tipo' => 'externo',
                'year' => '2019',
                'user_id' => 36,
                'created_at' => '2023-10-24 02:41:58',
                'updated_at' => '2023-10-24 02:41:58',
            ),
            3 => 
            array (
                'id' => 315,
                'nombre' => 'Teoría, Práctica de Vuelo con Drone DJI Mavic Air 2',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 36,
                'created_at' => '2023-10-24 02:43:21',
                'updated_at' => '2023-10-24 02:43:21',
            ),
            4 => 
            array (
                'id' => 316,
                'nombre' => 'Manejo Defensivo Teórico Práctico',
                'tipo' => 'externo',
                'year' => '2018',
                'user_id' => 36,
                'created_at' => '2023-10-24 02:47:28',
                'updated_at' => '2023-10-24 02:47:28',
            ),
            5 => 
            array (
                'id' => 325,
                'nombre' => 'NOM-019-STPS-2011, Constitución, integración, organización y funcionamiento de las comisiones de seguridad e higiene.',
                'tipo' => 'externo',
                'year' => '2011',
                'user_id' => 205,
                'created_at' => '2023-11-05 00:53:09',
                'updated_at' => '2023-11-05 00:53:09',
            ),
            6 => 
            array (
                'id' => 326,
                'nombre' => 'Curso teórico de recubrimientos industriales, NERVION PINTURAS.',
                'tipo' => 'externo',
                'year' => '2019',
                'user_id' => 205,
                'created_at' => '2023-11-05 00:55:07',
                'updated_at' => '2023-11-05 00:55:07',
            ),
            7 => 
            array (
                'id' => 327,
                'nombre' => 'Certificación de operador de grúa hidráulica, OSHA SA. DE CV.',
                'tipo' => 'externo',
                'year' => '2008',
                'user_id' => 157,
                'created_at' => '2023-11-07 00:45:38',
                'updated_at' => '2023-11-07 00:45:38',
            ),
            8 => 
            array (
                'id' => 328,
                'nombre' => 'Seguridad y maniobras de izajes. DC-3',
                'tipo' => 'externo',
                'year' => '2020',
                'user_id' => 157,
                'created_at' => '2023-11-07 00:49:02',
                'updated_at' => '2023-11-07 00:49:02',
            ),
            9 => 
            array (
                'id' => 329,
                'nombre' => 'COVID. Protocolos de seguridad. DC-3',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 157,
                'created_at' => '2023-11-07 00:50:04',
                'updated_at' => '2023-11-07 00:50:04',
            ),
            10 => 
            array (
                'id' => 330,
                'nombre' => 'Seguridad en andamios. DC-3',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 157,
                'created_at' => '2023-11-07 00:50:46',
                'updated_at' => '2023-11-07 00:50:46',
            ),
            11 => 
            array (
                'id' => 337,
                'nombre' => 'Manejo de máquinas 760,1200.101,660,360,1448',
                'tipo' => 'externo',
                'year' => '2017',
                'user_id' => 50,
                'created_at' => '2023-11-08 01:35:17',
                'updated_at' => '2023-11-14 00:13:35',
            ),
            12 => 
            array (
                'id' => 338,
                'nombre' => 'Curso básico de seguridad industrial',
                'tipo' => 'externo',
                'year' => '2018',
                'user_id' => 50,
                'created_at' => '2023-11-08 01:35:59',
                'updated_at' => '2023-11-14 00:15:41',
            ),
            13 => 
            array (
                'id' => 340,
            'nombre' => 'Curso Sistema de Gestión de Operaciones de TC Energía (TOMS)',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 50,
                'created_at' => '2023-11-08 01:39:43',
                'updated_at' => '2023-11-14 00:19:07',
            ),
            14 => 
            array (
                'id' => 341,
                'nombre' => 'Curso Básico de Seguridad en Plataformas y Barcazas COCAMAR S.C',
                'tipo' => 'externo',
                'year' => '2019',
                'user_id' => 50,
                'created_at' => '2023-11-08 01:44:44',
                'updated_at' => '2023-11-14 00:20:47',
            ),
            15 => 
            array (
                'id' => 342,
                'nombre' => 'Practica  para inyección de grasa en válvulas de bola TRUNNION y compuerta plana.',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 50,
                'created_at' => '2023-11-14 00:05:32',
                'updated_at' => '2023-11-14 00:24:29',
            ),
            16 => 
            array (
                'id' => 343,
                'nombre' => 'test',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 199,
                'created_at' => '2023-11-21 21:13:17',
                'updated_at' => '2023-11-21 21:13:17',
            ),
            17 => 
            array (
                'id' => 344,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 13,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            18 => 
            array (
                'id' => 345,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 13,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            19 => 
            array (
                'id' => 346,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 13,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            20 => 
            array (
                'id' => 347,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 13,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            21 => 
            array (
                'id' => 348,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 13,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            22 => 
            array (
                'id' => 349,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 13,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            23 => 
            array (
                'id' => 350,
                'nombre' => 'Soldadura en servicio con proceso GTAW',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 14,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            24 => 
            array (
                'id' => 351,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 14,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            25 => 
            array (
                'id' => 352,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 14,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            26 => 
            array (
                'id' => 353,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 14,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            27 => 
            array (
                'id' => 354,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 14,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            28 => 
            array (
                'id' => 355,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 18,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            29 => 
            array (
                'id' => 356,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 18,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            30 => 
            array (
                'id' => 357,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 18,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            31 => 
            array (
                'id' => 358,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 18,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            32 => 
            array (
                'id' => 359,
                'nombre' => 'Satech proceso de aprobación de requisiciones y ordenes de compra',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 19,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            33 => 
            array (
                'id' => 360,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 22,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            34 => 
            array (
                'id' => 361,
                'nombre' => 'Práctica para la inyección de grasa en válvulas de bola trunnion y compuerta plana ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 22,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            35 => 
            array (
                'id' => 362,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 22,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            36 => 
            array (
                'id' => 363,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 22,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            37 => 
            array (
                'id' => 364,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 22,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            38 => 
            array (
                'id' => 365,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 22,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            39 => 
            array (
                'id' => 366,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 26,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            40 => 
            array (
                'id' => 367,
                'nombre' => 'Soldadura en servicio con proceso GTAW',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 26,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            41 => 
            array (
                'id' => 368,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 26,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            42 => 
            array (
                'id' => 369,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 26,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            43 => 
            array (
                'id' => 370,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 26,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            44 => 
            array (
                'id' => 372,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 26,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            45 => 
            array (
                'id' => 373,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 26,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            46 => 
            array (
                'id' => 374,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 26,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            47 => 
            array (
                'id' => 375,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 26,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            48 => 
            array (
                'id' => 376,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 26,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            49 => 
            array (
                'id' => 378,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 36,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            50 => 
            array (
                'id' => 381,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 37,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            51 => 
            array (
                'id' => 382,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 37,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            52 => 
            array (
                'id' => 383,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 37,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            53 => 
            array (
                'id' => 384,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 37,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            54 => 
            array (
                'id' => 385,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 37,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            55 => 
            array (
                'id' => 386,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 38,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            56 => 
            array (
                'id' => 387,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 38,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            57 => 
            array (
                'id' => 388,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 38,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            58 => 
            array (
                'id' => 389,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 38,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            59 => 
            array (
                'id' => 390,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 38,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            60 => 
            array (
                'id' => 391,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 38,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            61 => 
            array (
                'id' => 392,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 40,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            62 => 
            array (
                'id' => 393,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 40,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            63 => 
            array (
                'id' => 394,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 40,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            64 => 
            array (
                'id' => 395,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 40,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            65 => 
            array (
                'id' => 396,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 40,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            66 => 
            array (
                'id' => 397,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 40,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            67 => 
            array (
                'id' => 398,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 40,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            68 => 
            array (
                'id' => 399,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 46,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            69 => 
            array (
                'id' => 400,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 50,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            70 => 
            array (
                'id' => 401,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 50,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            71 => 
            array (
                'id' => 402,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 50,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            72 => 
            array (
                'id' => 403,
                'nombre' => 'Práctica para la inyección de grasa en válvulas de bola trunnion y compuerta plana ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 50,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            73 => 
            array (
                'id' => 404,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 50,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            74 => 
            array (
                'id' => 405,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 50,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            75 => 
            array (
                'id' => 406,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 50,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2025-08-29 02:25:44',
            ),
            76 => 
            array (
                'id' => 408,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 50,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            77 => 
            array (
                'id' => 409,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 50,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            78 => 
            array (
                'id' => 410,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 50,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            79 => 
            array (
                'id' => 411,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            80 => 
            array (
                'id' => 412,
                'nombre' => 'Fundamentos de la negociación efectiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            81 => 
            array (
                'id' => 413,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            82 => 
            array (
                'id' => 414,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            83 => 
            array (
                'id' => 415,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            84 => 
            array (
                'id' => 416,
                'nombre' => 'Capacitación y difusión para comercio de bienes para pymes ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            85 => 
            array (
                'id' => 417,
                'nombre' => 'Satech - Módulo de configuración ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            86 => 
            array (
                'id' => 418,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            87 => 
            array (
                'id' => 419,
                'nombre' => 'Satech elaboración y revisión de ordenes de compra',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            88 => 
            array (
                'id' => 420,
                'nombre' => 'Satech proceso de aprobación de requisiciones y ordenes de compra',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            89 => 
            array (
                'id' => 421,
                'nombre' => 'Satech Módulo de proveedores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            90 => 
            array (
                'id' => 422,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            91 => 
            array (
                'id' => 423,
                'nombre' => 'Modificaciones a las reglas generales de comercio exterior 2023',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 52,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            92 => 
            array (
                'id' => 424,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 53,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            93 => 
            array (
                'id' => 425,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 53,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            94 => 
            array (
                'id' => 426,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 54,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            95 => 
            array (
                'id' => 427,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 54,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            96 => 
            array (
                'id' => 428,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 64,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            97 => 
            array (
                'id' => 429,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 64,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            98 => 
            array (
                'id' => 430,
                'nombre' => 'Práctica para la inyección de grasa en válvulas de bola trunnion y compuerta plana ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 64,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            99 => 
            array (
                'id' => 431,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 64,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            100 => 
            array (
                'id' => 432,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 64,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            101 => 
            array (
                'id' => 433,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 64,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            102 => 
            array (
                'id' => 435,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 89,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            103 => 
            array (
                'id' => 436,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 89,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            104 => 
            array (
                'id' => 437,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 89,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            105 => 
            array (
                'id' => 438,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 89,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            106 => 
            array (
                'id' => 439,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 89,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            107 => 
            array (
                'id' => 440,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 89,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            108 => 
            array (
                'id' => 441,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 89,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            109 => 
            array (
                'id' => 442,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            110 => 
            array (
                'id' => 443,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            111 => 
            array (
                'id' => 444,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            112 => 
            array (
                'id' => 445,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            113 => 
            array (
                'id' => 446,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            114 => 
            array (
                'id' => 447,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            115 => 
            array (
                'id' => 448,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            116 => 
            array (
                'id' => 449,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            117 => 
            array (
                'id' => 450,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            118 => 
            array (
                'id' => 451,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            119 => 
            array (
                'id' => 452,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 99,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            120 => 
            array (
                'id' => 453,
                'nombre' => 'Soldadura en servicio con proceso GTAW',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 99,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            121 => 
            array (
                'id' => 454,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 99,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            122 => 
            array (
                'id' => 455,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 99,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            123 => 
            array (
                'id' => 456,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 99,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            124 => 
            array (
                'id' => 457,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 99,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            125 => 
            array (
                'id' => 458,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 99,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            126 => 
            array (
                'id' => 459,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 99,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            127 => 
            array (
                'id' => 460,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 99,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            128 => 
            array (
                'id' => 461,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 99,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            129 => 
            array (
                'id' => 462,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 106,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            130 => 
            array (
                'id' => 463,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 114,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            131 => 
            array (
                'id' => 464,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 114,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            132 => 
            array (
                'id' => 465,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 114,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            133 => 
            array (
                'id' => 466,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 120,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            134 => 
            array (
                'id' => 467,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 120,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            135 => 
            array (
                'id' => 468,
                'nombre' => 'Obligaciones de Capacitación para empresas ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 123,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            136 => 
            array (
                'id' => 469,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 123,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            137 => 
            array (
                'id' => 470,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 123,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            138 => 
            array (
                'id' => 471,
                'nombre' => 'Satech proceso de aprobación de requisiciones y ordenes de compra',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 123,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            139 => 
            array (
                'id' => 472,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 123,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            140 => 
            array (
                'id' => 473,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 123,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            141 => 
            array (
                'id' => 474,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 123,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            142 => 
            array (
                'id' => 475,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 123,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            143 => 
            array (
                'id' => 476,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            144 => 
            array (
                'id' => 477,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            145 => 
            array (
                'id' => 478,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            146 => 
            array (
                'id' => 479,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            147 => 
            array (
                'id' => 480,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            148 => 
            array (
                'id' => 481,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2025-08-29 02:56:21',
            ),
            149 => 
            array (
                'id' => 482,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            150 => 
            array (
                'id' => 483,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            151 => 
            array (
                'id' => 484,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            152 => 
            array (
                'id' => 485,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            153 => 
            array (
                'id' => 486,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 131,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            154 => 
            array (
                'id' => 487,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 132,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            155 => 
            array (
                'id' => 488,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 132,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            156 => 
            array (
                'id' => 489,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 132,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            157 => 
            array (
                'id' => 490,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 132,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            158 => 
            array (
                'id' => 491,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 132,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            159 => 
            array (
                'id' => 492,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 132,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2025-08-29 03:12:07',
            ),
            160 => 
            array (
                'id' => 494,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 132,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            161 => 
            array (
                'id' => 495,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 132,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            162 => 
            array (
                'id' => 496,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 132,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            163 => 
            array (
                'id' => 497,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 137,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            164 => 
            array (
                'id' => 498,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 137,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            165 => 
            array (
                'id' => 499,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 137,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            166 => 
            array (
                'id' => 500,
                'nombre' => 'Práctica para la inyección de grasa en válvulas de bola trunnion y compuerta plana ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 137,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            167 => 
            array (
                'id' => 501,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 137,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            168 => 
            array (
                'id' => 502,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 137,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            169 => 
            array (
                'id' => 503,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 137,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            170 => 
            array (
                'id' => 504,
                'nombre' => 'Precios Unitarios Básico',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 142,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            171 => 
            array (
                'id' => 505,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 142,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            172 => 
            array (
                'id' => 506,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 142,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            173 => 
            array (
                'id' => 507,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 142,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            174 => 
            array (
                'id' => 508,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 142,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            175 => 
            array (
                'id' => 509,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 142,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            176 => 
            array (
                'id' => 510,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 142,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            177 => 
            array (
                'id' => 511,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 152,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            178 => 
            array (
                'id' => 512,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 152,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            179 => 
            array (
                'id' => 513,
                'nombre' => 'Nom-018-STPS-2015',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 153,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            180 => 
            array (
                'id' => 514,
                'nombre' => 'Nom-005-STPS-1998',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 153,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            181 => 
            array (
                'id' => 515,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 153,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            182 => 
            array (
                'id' => 516,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 153,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            183 => 
            array (
                'id' => 518,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 157,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            184 => 
            array (
                'id' => 519,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 157,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            185 => 
            array (
                'id' => 520,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 157,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            186 => 
            array (
                'id' => 521,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 157,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            187 => 
            array (
                'id' => 523,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 158,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            188 => 
            array (
                'id' => 524,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 158,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            189 => 
            array (
                'id' => 525,
                'nombre' => 'Nuevo Marco conceptual de las NIIF',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 158,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            190 => 
            array (
                'id' => 526,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 158,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            191 => 
            array (
                'id' => 527,
                'nombre' => 'Satech proceso de aprobación de requisiciones y ordenes de compra',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 158,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            192 => 
            array (
                'id' => 528,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 158,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            193 => 
            array (
                'id' => 529,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 158,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            194 => 
            array (
                'id' => 530,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 158,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            195 => 
            array (
                'id' => 531,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 166,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            196 => 
            array (
                'id' => 532,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 166,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            197 => 
            array (
                'id' => 533,
                'nombre' => 'Nuevo Marco conceptual de las NIIF',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 166,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            198 => 
            array (
                'id' => 534,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 166,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            199 => 
            array (
                'id' => 535,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 166,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            200 => 
            array (
                'id' => 536,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 166,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            201 => 
            array (
                'id' => 537,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 179,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            202 => 
            array (
                'id' => 538,
                'nombre' => 'Fundamentos de la negociación efectiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 179,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            203 => 
            array (
                'id' => 539,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 179,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            204 => 
            array (
                'id' => 540,
                'nombre' => 'Desarrollo de proveedores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 179,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            205 => 
            array (
                'id' => 541,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 179,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            206 => 
            array (
                'id' => 542,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 179,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            207 => 
            array (
                'id' => 543,
                'nombre' => 'Capacitación y difusión para comercio de bienes para pymes ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 179,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            208 => 
            array (
                'id' => 544,
                'nombre' => 'Satech Módulo de proveedores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 179,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            209 => 
            array (
                'id' => 545,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 179,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            210 => 
            array (
                'id' => 546,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 180,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            211 => 
            array (
                'id' => 547,
                'nombre' => 'Fundamentos de la negociación efectiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 180,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            212 => 
            array (
                'id' => 548,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 180,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            213 => 
            array (
                'id' => 549,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 180,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            214 => 
            array (
                'id' => 550,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 183,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            215 => 
            array (
                'id' => 551,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 183,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            216 => 
            array (
                'id' => 552,
                'nombre' => 'Práctica para la inyección de grasa en válvulas de bola trunnion y compuerta plana ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 183,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            217 => 
            array (
                'id' => 553,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 183,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            218 => 
            array (
                'id' => 554,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 183,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            219 => 
            array (
                'id' => 555,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 183,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            220 => 
            array (
                'id' => 556,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 183,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            221 => 
            array (
                'id' => 557,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 183,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            222 => 
            array (
                'id' => 558,
                'nombre' => 'ASME Sección V Artículo 6 - Líquidos Penetrantes',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 183,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            223 => 
            array (
                'id' => 559,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 183,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            224 => 
            array (
                'id' => 560,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 187,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            225 => 
            array (
                'id' => 561,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 187,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            226 => 
            array (
                'id' => 563,
                'nombre' => 'Nom-018-STPS-2015',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 187,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            227 => 
            array (
                'id' => 564,
                'nombre' => 'Nom-005-STPS-1998',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 187,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            228 => 
            array (
                'id' => 565,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 187,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            229 => 
            array (
                'id' => 566,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 187,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            230 => 
            array (
                'id' => 567,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 187,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            231 => 
            array (
                'id' => 569,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 191,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            232 => 
            array (
                'id' => 571,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 191,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            233 => 
            array (
                'id' => 572,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 191,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            234 => 
            array (
                'id' => 574,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            235 => 
            array (
                'id' => 575,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            236 => 
            array (
                'id' => 576,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            237 => 
            array (
                'id' => 577,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            238 => 
            array (
                'id' => 578,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            239 => 
            array (
                'id' => 579,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            240 => 
            array (
                'id' => 580,
                'nombre' => 'Anexo SSPA ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            241 => 
            array (
                'id' => 581,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            242 => 
            array (
                'id' => 582,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            243 => 
            array (
                'id' => 583,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            244 => 
            array (
                'id' => 584,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            245 => 
            array (
                'id' => 585,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            246 => 
            array (
                'id' => 586,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 192,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            247 => 
            array (
                'id' => 587,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 193,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            248 => 
            array (
                'id' => 588,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 193,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            249 => 
            array (
                'id' => 589,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 193,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            250 => 
            array (
                'id' => 590,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 193,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            251 => 
            array (
                'id' => 591,
                'nombre' => 'Nom-018-STPS-2015',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 193,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            252 => 
            array (
                'id' => 592,
                'nombre' => 'Nom-005-STPS-1998',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 193,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            253 => 
            array (
                'id' => 593,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 193,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            254 => 
            array (
                'id' => 594,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 199,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            255 => 
            array (
                'id' => 595,
                'nombre' => 'Desarrollo móvil en línea',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 199,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            256 => 
            array (
                'id' => 596,
                'nombre' => 'Satech - Módulo de configuración ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 199,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            257 => 
            array (
                'id' => 597,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 200,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            258 => 
            array (
                'id' => 598,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 200,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            259 => 
            array (
                'id' => 600,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 200,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            260 => 
            array (
                'id' => 601,
                'nombre' => 'ASME Sección V Artículo 6 - Líquidos Penetrantes',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 200,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            261 => 
            array (
                'id' => 602,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 202,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            262 => 
            array (
                'id' => 603,
                'nombre' => 'Nom-018-STPS-2015',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 202,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            263 => 
            array (
                'id' => 604,
                'nombre' => 'Nom-005-STPS-1998',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 202,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            264 => 
            array (
                'id' => 605,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 202,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            265 => 
            array (
                'id' => 606,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 202,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            266 => 
            array (
                'id' => 607,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 202,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            267 => 
            array (
                'id' => 608,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 205,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            268 => 
            array (
                'id' => 610,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 205,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            269 => 
            array (
                'id' => 611,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 205,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            270 => 
            array (
                'id' => 612,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 205,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2025-08-29 02:21:48',
            ),
            271 => 
            array (
                'id' => 614,
                'nombre' => 'Facilitador de grupos',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 211,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            272 => 
            array (
                'id' => 615,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 211,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            273 => 
            array (
                'id' => 616,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 211,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            274 => 
            array (
                'id' => 617,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 211,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            275 => 
            array (
                'id' => 618,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 211,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            276 => 
            array (
                'id' => 619,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 211,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            277 => 
            array (
                'id' => 620,
                'nombre' => 'Partículas Magnéticas ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            278 => 
            array (
                'id' => 621,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            279 => 
            array (
                'id' => 622,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            280 => 
            array (
                'id' => 623,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            281 => 
            array (
                'id' => 624,
                'nombre' => 'Práctica para la inyección de grasa en válvulas de bola trunnion y compuerta plana ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            282 => 
            array (
                'id' => 625,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            283 => 
            array (
                'id' => 626,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            284 => 
            array (
                'id' => 628,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            285 => 
            array (
                'id' => 629,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            286 => 
            array (
                'id' => 630,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            287 => 
            array (
                'id' => 631,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2025-08-29 02:24:02',
            ),
            288 => 
            array (
                'id' => 633,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 212,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            289 => 
            array (
                'id' => 634,
                'nombre' => 'Obligaciones de Capacitación para empresas ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 218,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            290 => 
            array (
                'id' => 635,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 218,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            291 => 
            array (
                'id' => 636,
                'nombre' => 'NOM-019-stps-2011 Constitución, organización y funcionamiento de las comisiones de seguridad e higiene en los centros de trabajo',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 218,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            292 => 
            array (
                'id' => 637,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 218,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            293 => 
            array (
                'id' => 638,
                'nombre' => 'Plan de detección de necesidades de capacitación ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 218,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            294 => 
            array (
                'id' => 639,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 218,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            295 => 
            array (
                'id' => 640,
                'nombre' => 'Normas Oficiales Mexicanas STPS',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 218,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            296 => 
            array (
                'id' => 641,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 218,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            297 => 
            array (
                'id' => 642,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 218,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            298 => 
            array (
                'id' => 643,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 223,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            299 => 
            array (
                'id' => 644,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 223,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            300 => 
            array (
                'id' => 645,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 227,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            301 => 
            array (
                'id' => 646,
                'nombre' => 'Práctica para la inyección de grasa en válvulas de bola trunnion y compuerta plana ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 227,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            302 => 
            array (
                'id' => 647,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 227,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            303 => 
            array (
                'id' => 648,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 227,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            304 => 
            array (
                'id' => 649,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 227,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            305 => 
            array (
                'id' => 650,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 227,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            306 => 
            array (
                'id' => 651,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 227,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            307 => 
            array (
                'id' => 652,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 227,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            308 => 
            array (
                'id' => 653,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 227,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            309 => 
            array (
                'id' => 654,
                'nombre' => 'ASME Sección V Artículo 6 - Líquidos Penetrantes',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 227,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            310 => 
            array (
                'id' => 655,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 230,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            311 => 
            array (
                'id' => 656,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 230,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            312 => 
            array (
                'id' => 657,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 230,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            313 => 
            array (
                'id' => 658,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 230,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            314 => 
            array (
                'id' => 659,
                'nombre' => 'Nom-018-STPS-2015',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 230,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            315 => 
            array (
                'id' => 660,
                'nombre' => 'Nom-005-STPS-1998',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 230,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            316 => 
            array (
                'id' => 661,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 230,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            317 => 
            array (
                'id' => 662,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 230,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            318 => 
            array (
                'id' => 663,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 233,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            319 => 
            array (
                'id' => 664,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 235,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            320 => 
            array (
                'id' => 665,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 235,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            321 => 
            array (
                'id' => 666,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 235,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            322 => 
            array (
                'id' => 667,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 235,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            323 => 
            array (
                'id' => 668,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 235,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            324 => 
            array (
                'id' => 669,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 236,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            325 => 
            array (
                'id' => 670,
                'nombre' => 'Fundamentos de la negociación efectiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 236,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            326 => 
            array (
                'id' => 671,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 236,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            327 => 
            array (
                'id' => 672,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 236,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            328 => 
            array (
                'id' => 673,
                'nombre' => 'Capacitación y difusión para comercio de bienes para pymes ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 236,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            329 => 
            array (
                'id' => 674,
                'nombre' => 'Satech - Módulo de configuración ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 236,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            330 => 
            array (
                'id' => 675,
                'nombre' => 'Satech Módulo de proveedores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 236,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            331 => 
            array (
                'id' => 676,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 236,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            332 => 
            array (
                'id' => 677,
                'nombre' => 'Modificaciones a las reglas generales de comercio exterior 2023',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 236,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            333 => 
            array (
                'id' => 678,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 238,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            334 => 
            array (
                'id' => 679,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 240,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            335 => 
            array (
                'id' => 680,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 240,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            336 => 
            array (
                'id' => 681,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 240,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            337 => 
            array (
                'id' => 682,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 240,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            338 => 
            array (
                'id' => 683,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 242,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            339 => 
            array (
                'id' => 684,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 244,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            340 => 
            array (
                'id' => 685,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 244,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            341 => 
            array (
                'id' => 686,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 244,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            342 => 
            array (
                'id' => 687,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 244,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            343 => 
            array (
                'id' => 688,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 244,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            344 => 
            array (
                'id' => 689,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 244,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            345 => 
            array (
                'id' => 690,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 244,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            346 => 
            array (
                'id' => 691,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 244,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            347 => 
            array (
                'id' => 692,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 244,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            348 => 
            array (
                'id' => 693,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 246,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            349 => 
            array (
                'id' => 694,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 246,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            350 => 
            array (
                'id' => 695,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 246,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            351 => 
            array (
                'id' => 696,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 247,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            352 => 
            array (
                'id' => 697,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 247,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            353 => 
            array (
                'id' => 698,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 247,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            354 => 
            array (
                'id' => 699,
                'nombre' => 'Facilitador de grupos',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 247,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            355 => 
            array (
                'id' => 700,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 247,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            356 => 
            array (
                'id' => 701,
                'nombre' => 'Nuevo Marco conceptual de las NIIF',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 247,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            357 => 
            array (
                'id' => 702,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 247,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            358 => 
            array (
                'id' => 703,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 247,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            359 => 
            array (
                'id' => 704,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 249,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            360 => 
            array (
                'id' => 705,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 249,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            361 => 
            array (
                'id' => 706,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 249,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            362 => 
            array (
                'id' => 707,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 249,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            363 => 
            array (
                'id' => 708,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 249,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            364 => 
            array (
                'id' => 709,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 249,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            365 => 
            array (
                'id' => 710,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 249,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            366 => 
            array (
                'id' => 711,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 250,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            367 => 
            array (
                'id' => 712,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 250,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            368 => 
            array (
                'id' => 713,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 250,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            369 => 
            array (
                'id' => 714,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 250,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            370 => 
            array (
                'id' => 715,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 250,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            371 => 
            array (
                'id' => 716,
                'nombre' => 'Nom-018-STPS-2015',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 250,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            372 => 
            array (
                'id' => 717,
                'nombre' => 'Nom-005-STPS-1998',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 250,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            373 => 
            array (
                'id' => 718,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 250,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            374 => 
            array (
                'id' => 719,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 250,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            375 => 
            array (
                'id' => 720,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 250,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            376 => 
            array (
                'id' => 722,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 251,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            377 => 
            array (
                'id' => 724,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 251,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            378 => 
            array (
                'id' => 725,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 251,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            379 => 
            array (
                'id' => 726,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 251,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            380 => 
            array (
                'id' => 727,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 252,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            381 => 
            array (
                'id' => 728,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 252,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            382 => 
            array (
                'id' => 729,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 252,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            383 => 
            array (
                'id' => 730,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 252,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            384 => 
            array (
                'id' => 731,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 252,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            385 => 
            array (
                'id' => 732,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 252,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            386 => 
            array (
                'id' => 733,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 252,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            387 => 
            array (
                'id' => 734,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 252,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            388 => 
            array (
                'id' => 735,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 252,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            389 => 
            array (
                'id' => 736,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 253,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            390 => 
            array (
                'id' => 737,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 253,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            391 => 
            array (
                'id' => 738,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 253,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            392 => 
            array (
                'id' => 739,
                'nombre' => 'Medidas de Seguridad en grúas y polipastos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 253,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            393 => 
            array (
                'id' => 740,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 253,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            394 => 
            array (
                'id' => 741,
                'nombre' => 'Práctica para la inyección de grasa en válvulas de bola trunnion y compuerta plana ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 253,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            395 => 
            array (
                'id' => 742,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 253,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            396 => 
            array (
                'id' => 743,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 253,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            397 => 
            array (
                'id' => 744,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 253,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            398 => 
            array (
                'id' => 745,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 253,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            399 => 
            array (
                'id' => 746,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            400 => 
            array (
                'id' => 747,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            401 => 
            array (
                'id' => 748,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            402 => 
            array (
                'id' => 749,
                'nombre' => 'Fundamentos de la negociación efectiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            403 => 
            array (
                'id' => 750,
                'nombre' => 'NOM-019-stps-2011 Constitución, organización y funcionamiento de las comisiones de seguridad e higiene en los centros de trabajo',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            404 => 
            array (
                'id' => 751,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            405 => 
            array (
                'id' => 752,
                'nombre' => 'Plan de detección de necesidades de capacitación ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            406 => 
            array (
                'id' => 753,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            407 => 
            array (
                'id' => 754,
                'nombre' => 'Normas Oficiales Mexicanas STPS',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            408 => 
            array (
                'id' => 755,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            409 => 
            array (
                'id' => 756,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            410 => 
            array (
                'id' => 757,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            411 => 
            array (
                'id' => 758,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 255,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            412 => 
            array (
                'id' => 759,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 256,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            413 => 
            array (
                'id' => 760,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 256,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            414 => 
            array (
                'id' => 761,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 256,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            415 => 
            array (
                'id' => 762,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 256,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            416 => 
            array (
                'id' => 763,
                'nombre' => 'Nom-018-STPS-2015',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 256,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            417 => 
            array (
                'id' => 764,
                'nombre' => 'Nom-005-STPS-1998',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 256,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            418 => 
            array (
                'id' => 765,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 256,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            419 => 
            array (
                'id' => 766,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 256,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            420 => 
            array (
                'id' => 767,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 257,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            421 => 
            array (
                'id' => 768,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 257,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            422 => 
            array (
                'id' => 769,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 257,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            423 => 
            array (
                'id' => 770,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 257,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            424 => 
            array (
                'id' => 771,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 257,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            425 => 
            array (
                'id' => 772,
                'nombre' => 'Nom-018-STPS-2015',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 257,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            426 => 
            array (
                'id' => 773,
                'nombre' => 'Nom-005-STPS-1998',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 257,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            427 => 
            array (
                'id' => 774,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 257,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            428 => 
            array (
                'id' => 775,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 257,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            429 => 
            array (
                'id' => 776,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 258,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            430 => 
            array (
                'id' => 777,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 258,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            431 => 
            array (
                'id' => 778,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 258,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            432 => 
            array (
                'id' => 779,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 258,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            433 => 
            array (
                'id' => 780,
                'nombre' => 'Nom-018-STPS-2015',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 258,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            434 => 
            array (
                'id' => 781,
                'nombre' => 'Nom-005-STPS-1998',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 258,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            435 => 
            array (
                'id' => 782,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 258,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            436 => 
            array (
                'id' => 783,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 258,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            437 => 
            array (
                'id' => 784,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 258,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            438 => 
            array (
                'id' => 787,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 260,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            439 => 
            array (
                'id' => 788,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 260,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            440 => 
            array (
                'id' => 790,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 260,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            441 => 
            array (
                'id' => 791,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 260,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            442 => 
            array (
                'id' => 792,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 260,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            443 => 
            array (
                'id' => 793,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 262,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            444 => 
            array (
                'id' => 794,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 262,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            445 => 
            array (
                'id' => 795,
                'nombre' => 'Práctica para la inyección de grasa en válvulas de bola trunnion y compuerta plana ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 262,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            446 => 
            array (
                'id' => 796,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 262,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            447 => 
            array (
                'id' => 797,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 262,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            448 => 
            array (
                'id' => 798,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 262,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            449 => 
            array (
                'id' => 799,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 263,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            450 => 
            array (
                'id' => 800,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 263,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            451 => 
            array (
                'id' => 801,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 263,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            452 => 
            array (
                'id' => 802,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 263,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            453 => 
            array (
                'id' => 803,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 263,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            454 => 
            array (
                'id' => 804,
                'nombre' => 'Normas Oficiales Mexicanas STPS',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 263,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            455 => 
            array (
                'id' => 805,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 263,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            456 => 
            array (
                'id' => 806,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 263,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            457 => 
            array (
                'id' => 807,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 263,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            458 => 
            array (
                'id' => 808,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 263,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            459 => 
            array (
                'id' => 809,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 264,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            460 => 
            array (
                'id' => 810,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 264,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            461 => 
            array (
                'id' => 811,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 264,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            462 => 
            array (
                'id' => 812,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 264,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            463 => 
            array (
                'id' => 813,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 264,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            464 => 
            array (
                'id' => 814,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 264,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            465 => 
            array (
                'id' => 815,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 264,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            466 => 
            array (
                'id' => 816,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 264,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            467 => 
            array (
                'id' => 817,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 264,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            468 => 
            array (
                'id' => 818,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 264,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            469 => 
            array (
                'id' => 819,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 265,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            470 => 
            array (
                'id' => 820,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 265,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            471 => 
            array (
                'id' => 821,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 265,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            472 => 
            array (
                'id' => 822,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 265,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            473 => 
            array (
                'id' => 823,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 265,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            474 => 
            array (
                'id' => 824,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 265,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            475 => 
            array (
                'id' => 825,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 265,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            476 => 
            array (
                'id' => 826,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 265,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            477 => 
            array (
                'id' => 827,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            478 => 
            array (
                'id' => 828,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            479 => 
            array (
                'id' => 829,
                'nombre' => 'Manejo a la defensiva',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            480 => 
            array (
                'id' => 830,
                'nombre' => 'Sistema de Gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            481 => 
            array (
                'id' => 831,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            482 => 
            array (
                'id' => 832,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            483 => 
            array (
                'id' => 833,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            484 => 
            array (
                'id' => 834,
                'nombre' => 'Brigada de prevención y combate contra incendios',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            485 => 
            array (
                'id' => 835,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            486 => 
            array (
                'id' => 836,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            487 => 
            array (
                'id' => 837,
                'nombre' => 'ASME Sección V Artículo 6 - Líquidos Penetrantes',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            488 => 
            array (
                'id' => 838,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 266,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            489 => 
            array (
                'id' => 839,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 267,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            490 => 
            array (
                'id' => 840,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 267,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            491 => 
            array (
                'id' => 841,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 267,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            492 => 
            array (
                'id' => 842,
                'nombre' => 'Inducción Sistema de gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 267,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            493 => 
            array (
                'id' => 843,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 267,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            494 => 
            array (
                'id' => 844,
                'nombre' => 'Nuevo Marco conceptual de las NIIF',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 267,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            495 => 
            array (
                'id' => 845,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 267,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            496 => 
            array (
                'id' => 846,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 267,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            497 => 
            array (
                'id' => 847,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 267,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            498 => 
            array (
                'id' => 848,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 268,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            499 => 
            array (
                'id' => 849,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 268,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
        ));
        \DB::table('cv_curso_certificacions')->insert(array (
            0 => 
            array (
                'id' => 850,
                'nombre' => 'Inducción Sistema de gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 268,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            1 => 
            array (
                'id' => 851,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 268,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            2 => 
            array (
                'id' => 852,
                'nombre' => 'Manejo seguro de la maquinaria ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 268,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            3 => 
            array (
                'id' => 853,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 268,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            4 => 
            array (
                'id' => 854,
                'nombre' => 'Brigada de primeros auxilios ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 268,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            5 => 
            array (
                'id' => 858,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 269,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            6 => 
            array (
                'id' => 859,
                'nombre' => 'ASME Sección V Artículo 6 - Líquidos Penetrantes',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 269,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            7 => 
            array (
                'id' => 863,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 270,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2025-08-29 02:24:41',
            ),
            8 => 
            array (
                'id' => 864,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 270,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            9 => 
            array (
                'id' => 865,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 271,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            10 => 
            array (
                'id' => 866,
                'nombre' => 'Inducción Sistema de gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 271,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            11 => 
            array (
                'id' => 867,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 271,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            12 => 
            array (
                'id' => 868,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 271,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            13 => 
            array (
                'id' => 869,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 271,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            14 => 
            array (
                'id' => 870,
                'nombre' => 'Brigada de búsqueda y rescate ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 271,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            15 => 
            array (
                'id' => 871,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 272,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            16 => 
            array (
                'id' => 872,
                'nombre' => 'Manejo Manual de cargas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 272,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            17 => 
            array (
                'id' => 873,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 272,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            18 => 
            array (
                'id' => 874,
                'nombre' => 'Inducción Sistema de gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 272,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            19 => 
            array (
                'id' => 875,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 272,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            20 => 
            array (
                'id' => 876,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 273,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            21 => 
            array (
                'id' => 877,
                'nombre' => 'Satech Módulo de proveedores',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 273,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            22 => 
            array (
                'id' => 878,
                'nombre' => 'Inducción Sistema de gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 273,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            23 => 
            array (
                'id' => 879,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 273,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            24 => 
            array (
                'id' => 880,
                'nombre' => 'Requisitos fiscales de CFDI personas físicas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 273,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            25 => 
            array (
                'id' => 881,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 273,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            26 => 
            array (
                'id' => 882,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 274,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            27 => 
            array (
                'id' => 883,
                'nombre' => 'Inducción Sistema de gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 274,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            28 => 
            array (
                'id' => 884,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 274,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            29 => 
            array (
                'id' => 885,
                'nombre' => 'Declaraciones informativas de REPSE, ICSOE Y SISUB ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 274,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            30 => 
            array (
                'id' => 886,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 275,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            31 => 
            array (
                'id' => 887,
                'nombre' => 'Inducción Sistema de gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 275,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            32 => 
            array (
                'id' => 888,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 275,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            33 => 
            array (
                'id' => 893,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 277,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            34 => 
            array (
                'id' => 894,
                'nombre' => 'Inducción Sistema de gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 277,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            35 => 
            array (
                'id' => 895,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 277,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            36 => 
            array (
                'id' => 896,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 277,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            37 => 
            array (
                'id' => 897,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 278,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            38 => 
            array (
                'id' => 898,
                'nombre' => 'Inducción Sistema de gestión Integral ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 278,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            39 => 
            array (
                'id' => 899,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 278,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            40 => 
            array (
                'id' => 900,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 278,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            41 => 
            array (
                'id' => 901,
                'nombre' => 'Brigada de evacuación de inmueble ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 278,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            42 => 
            array (
                'id' => 902,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 279,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            43 => 
            array (
                'id' => 903,
                'nombre' => 'Manejo y almacenamiento de residuos peligrosos ',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 279,
                'created_at' => '2023-11-22 20:29:33',
                'updated_at' => '2023-11-22 20:29:33',
            ),
            44 => 
            array (
                'id' => 904,
                'nombre' => 'SSPA PEMEX',
                'tipo' => 'externo',
                'year' => '2018',
                'user_id' => 270,
                'created_at' => '2023-11-24 01:52:46',
                'updated_at' => '2023-11-24 02:00:03',
            ),
            45 => 
            array (
                'id' => 905,
                'nombre' => 'Selección de barrenas de perforación BAKER HUGHES ',
                'tipo' => 'externo',
                'year' => '2012',
                'user_id' => 270,
                'created_at' => '2023-11-24 01:56:48',
                'updated_at' => '2023-11-24 02:00:46',
            ),
            46 => 
            array (
                'id' => 906,
                'nombre' => 'Curso de seguridad en plataformas y barcazas COCAMAR',
                'tipo' => 'externo',
                'year' => '2018',
                'user_id' => 270,
                'created_at' => '2023-11-24 01:58:33',
                'updated_at' => '2023-11-24 01:59:02',
            ),
            47 => 
            array (
                'id' => 907,
                'nombre' => 'COSHH AWARENESS ',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-24 02:06:30',
                'updated_at' => '2023-11-24 02:06:30',
            ),
            48 => 
            array (
                'id' => 908,
                'nombre' => 'Manual Handling Training. ',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2023-11-24 02:06:59',
                'updated_at' => '2023-11-24 02:06:59',
            ),
            49 => 
            array (
                'id' => 909,
                'nombre' => 'IADC RigPass Offshore/Onshore. ',
                'tipo' => 'externo',
                'year' => '2017',
                'user_id' => 92,
                'created_at' => '2023-11-24 02:07:36',
                'updated_at' => '2023-11-24 02:07:36',
            ),
            50 => 
            array (
                'id' => 910,
                'nombre' => 'Hot Tapping and Line Stopping Level II, ½” – 36” • GPT Services.',
                'tipo' => 'externo',
                'year' => '2020',
                'user_id' => 92,
                'created_at' => '2023-11-24 02:09:14',
                'updated_at' => '2023-11-24 02:09:14',
            ),
            51 => 
            array (
                'id' => 911,
                'nombre' => 'Hot Tapping and Line Stopping Level I, ½” – 10” • GPT Services.',
                'tipo' => 'externo',
                'year' => '2019',
                'user_id' => 92,
                'created_at' => '2023-11-24 02:09:38',
                'updated_at' => '2023-11-24 02:09:38',
            ),
            52 => 
            array (
                'id' => 912,
                'nombre' => 'Hot Tapping and Line Stopping Trainee • GPT Services.',
                'tipo' => 'externo',
                'year' => '2017',
                'user_id' => 92,
                'created_at' => '2023-11-24 02:10:03',
                'updated_at' => '2023-11-24 02:10:03',
            ),
            53 => 
            array (
                'id' => 913,
                'nombre' => 'Diplomado, Habilidades Directivas',
                'tipo' => 'externo',
                'year' => '2017',
                'user_id' => 92,
                'created_at' => '2023-11-24 02:15:05',
                'updated_at' => '2023-11-24 02:15:05',
            ),
            54 => 
            array (
                'id' => 917,
                'nombre' => 'Diplomado En Derecho Ambiental, Escuela Superior de Leyes ',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:05:38',
                'updated_at' => '2024-02-20 21:05:38',
            ),
            55 => 
            array (
                'id' => 918,
                'nombre' => 'Six Sigma-Leanprogress ',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:06:32',
                'updated_at' => '2024-02-20 21:06:32',
            ),
            56 => 
            array (
                'id' => 919,
                'nombre' => 'X Congreso Internacional De Seguridad Integral. Instituto internacional de Administración de Riesgos, S.A. de C.V.',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:06:58',
                'updated_at' => '2024-02-20 21:06:58',
            ),
            57 => 
            array (
                'id' => 920,
                'nombre' => 'Seminario de Gas LP Cumplimiento Normativo. Grupo CIITA ',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:07:18',
                'updated_at' => '2024-02-20 21:07:18',
            ),
            58 => 
            array (
                'id' => 921,
                'nombre' => 'Extracción, procesamiento y distribución y estudio de mercado del Gas natural.  ESIQIE-IPN ',
                'tipo' => 'externo',
                'year' => '2020',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:07:46',
                'updated_at' => '2024-02-20 21:07:46',
            ),
            59 => 
            array (
                'id' => 922,
                'nombre' => 'Curso básico sobre Análisis de Riesgos. Consultoría Sustentable G2H ',
                'tipo' => 'externo',
                'year' => '2020',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:08:01',
                'updated_at' => '2024-02-20 21:08:01',
            ),
            60 => 
            array (
                'id' => 923,
                'nombre' => 'ALOHA - Áreas de riesgo químico ',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:08:17',
                'updated_at' => '2024-02-20 21:08:17',
            ),
            61 => 
            array (
                'id' => 924,
                'nombre' => 'Sistema de información geográfica utilizando QGIS ',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:08:33',
                'updated_at' => '2024-02-20 21:08:33',
            ),
            62 => 
            array (
                'id' => 925,
                'nombre' => 'Usos y Aplicaciones del Atlas Nacional de Riesgo',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:08:52',
                'updated_at' => '2024-02-20 21:08:52',
            ),
            63 => 
            array (
                'id' => 926,
                'nombre' => 'Seguridad para trabajo en Alturas y Prevención de Caídas. ZOSTENTA',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:09:56',
                'updated_at' => '2024-02-20 21:09:56',
            ),
            64 => 
            array (
                'id' => 927,
                'nombre' => 'Manejo e Interpretación en equipos detectores de gases inflamables y tóxicos',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 227,
                'created_at' => '2024-02-20 21:12:40',
                'updated_at' => '2024-02-20 21:12:40',
            ),
            65 => 
            array (
                'id' => 928,
                'nombre' => 'SEMINARIO SISTEMA DE GESTIÓN DE CALIDAD CON BASE EN LA NORMA ISO 9001:2015',
                'tipo' => 'externo',
                'year' => '2020',
                'user_id' => 183,
                'created_at' => '2024-02-21 10:44:36',
                'updated_at' => '2024-02-21 10:44:36',
            ),
            66 => 
            array (
                'id' => 929,
                'nombre' => 'Administración de proyectos con Project',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 183,
                'created_at' => '2024-02-21 10:45:57',
                'updated_at' => '2024-02-21 10:45:57',
            ),
            67 => 
            array (
                'id' => 930,
                'nombre' => 'Seminario de Evaluación de Calidad de Combustibles',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:21:47',
                'updated_at' => '2024-02-23 02:21:47',
            ),
            68 => 
            array (
                'id' => 931,
                'nombre' => 'Master Online Bussines & Entrepreneurship',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:23:00',
                'updated_at' => '2024-02-23 02:23:00',
            ),
            69 => 
            array (
                'id' => 932,
                'nombre' => 'Project Management Professional',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:23:26',
                'updated_at' => '2024-02-23 02:23:26',
            ),
            70 => 
            array (
                'id' => 933,
                'nombre' => 'Six Sigma Black Belt',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:23:57',
                'updated_at' => '2024-02-23 02:23:57',
            ),
            71 => 
            array (
                'id' => 934,
                'nombre' => 'Calidad en el Servicio',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:24:25',
                'updated_at' => '2024-02-23 02:24:25',
            ),
            72 => 
            array (
                'id' => 935,
                'nombre' => 'Controles Volumétricos de Hidrocarburos & Petrolíferos',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:26:05',
                'updated_at' => '2024-02-23 02:26:05',
            ),
            73 => 
            array (
                'id' => 936,
                'nombre' => 'Manejo e interpretación en equipos detectores de gases inflamables y tóxicos',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:26:50',
                'updated_at' => '2024-02-23 02:26:50',
            ),
            74 => 
            array (
                'id' => 937,
                'nombre' => 'Learning Hack Marketing Digital',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:28:02',
                'updated_at' => '2024-02-23 02:28:02',
            ),
            75 => 
            array (
                'id' => 938,
                'nombre' => 'Seguridad para Trabajos en Alturas y Prevención de Caídas',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:28:52',
                'updated_at' => '2024-02-23 02:28:52',
            ),
            76 => 
            array (
                'id' => 939,
                'nombre' => 'Las 7 herramientas de la calidad',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:30:04',
                'updated_at' => '2024-02-23 02:30:04',
            ),
            77 => 
            array (
                'id' => 940,
            'nombre' => 'Análisis de Modo y Efecto de Falla (AMEF)',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:30:38',
                'updated_at' => '2024-02-23 02:30:38',
            ),
            78 => 
            array (
                'id' => 941,
                'nombre' => 'Control Plan',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:31:06',
                'updated_at' => '2024-02-23 02:31:06',
            ),
            79 => 
            array (
                'id' => 942,
            'nombre' => 'Diseño de Experimentos (DOE)',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:31:33',
                'updated_at' => '2024-02-23 02:31:33',
            ),
            80 => 
            array (
                'id' => 943,
                'nombre' => 'Mapeo de Procesos',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:31:55',
                'updated_at' => '2024-02-23 02:31:55',
            ),
            81 => 
            array (
                'id' => 944,
                'nombre' => 'Análisis de Repetibilidad & Reproductibilidad',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:32:53',
                'updated_at' => '2024-02-23 02:32:53',
            ),
            82 => 
            array (
                'id' => 945,
                'nombre' => 'Six Sigma Green Belt',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:33:23',
                'updated_at' => '2024-02-23 02:33:23',
            ),
            83 => 
            array (
                'id' => 946,
                'nombre' => 'Six Sigma Yellow Belt',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:33:46',
                'updated_at' => '2024-02-23 02:33:46',
            ),
            84 => 
            array (
                'id' => 947,
            'nombre' => 'Control Estadístico de Procesos (SPC)',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 269,
                'created_at' => '2024-02-23 02:34:20',
                'updated_at' => '2024-02-23 02:34:20',
            ),
            85 => 
            array (
                'id' => 948,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            86 => 
            array (
                'id' => 950,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            87 => 
            array (
                'id' => 952,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            88 => 
            array (
                'id' => 954,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 288,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            89 => 
            array (
                'id' => 955,
                'nombre' => 'Cálculo anual de sueldos y salarios',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            90 => 
            array (
                'id' => 956,
                'nombre' => 'Cálculo anual de sueldos y salarios',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 263,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            91 => 
            array (
                'id' => 957,
                'nombre' => 'Cálculo anual de sueldos y salarios',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 255,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            92 => 
            array (
                'id' => 958,
                'nombre' => 'Seguridad y Salud en el trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 192,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            93 => 
            array (
                'id' => 959,
                'nombre' => 'Seguridad y Salud en el trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 211,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            94 => 
            array (
                'id' => 960,
                'nombre' => 'Seguridad y Salud en el trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 276,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            95 => 
            array (
                'id' => 961,
                'nombre' => 'Seguridad y Salud en el trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 132,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            96 => 
            array (
                'id' => 962,
                'nombre' => 'Seguridad y Salud en el trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            97 => 
            array (
                'id' => 963,
                'nombre' => 'Seguridad y Salud en el trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            98 => 
            array (
                'id' => 964,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            99 => 
            array (
                'id' => 965,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 288,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            100 => 
            array (
                'id' => 966,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            101 => 
            array (
                'id' => 968,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 290,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            102 => 
            array (
                'id' => 969,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            103 => 
            array (
                'id' => 970,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            104 => 
            array (
                'id' => 971,
                'nombre' => 'Seguridad y Salud en el trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 52,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            105 => 
            array (
                'id' => 972,
                'nombre' => 'Seguridad y Salud en el trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            106 => 
            array (
                'id' => 973,
                'nombre' => 'Seguridad y Salud en el trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 273,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            107 => 
            array (
                'id' => 974,
                'nombre' => 'Seguridad y Salud en el trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 236,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            108 => 
            array (
                'id' => 975,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 227,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            109 => 
            array (
                'id' => 976,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 50,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            110 => 
            array (
                'id' => 977,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 205,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            111 => 
            array (
                'id' => 978,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 157,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            112 => 
            array (
                'id' => 979,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 53,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            113 => 
            array (
                'id' => 980,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 132,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            114 => 
            array (
                'id' => 981,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 253,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            115 => 
            array (
                'id' => 982,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 54,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            116 => 
            array (
                'id' => 983,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 276,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            117 => 
            array (
                'id' => 984,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 279,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            118 => 
            array (
                'id' => 985,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 36,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            119 => 
            array (
                'id' => 986,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 252,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            120 => 
            array (
                'id' => 987,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 287,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            121 => 
            array (
                'id' => 988,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 200,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            122 => 
            array (
                'id' => 989,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 265,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            123 => 
            array (
                'id' => 990,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 142,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            124 => 
            array (
                'id' => 991,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            125 => 
            array (
                'id' => 992,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 187,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            126 => 
            array (
                'id' => 993,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 250,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            127 => 
            array (
                'id' => 994,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 272,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            128 => 
            array (
                'id' => 995,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            129 => 
            array (
                'id' => 996,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 236,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            130 => 
            array (
                'id' => 998,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            131 => 
            array (
                'id' => 999,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 191,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            132 => 
            array (
                'id' => 1000,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 40,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            133 => 
            array (
                'id' => 1001,
                'nombre' => 'Seminario: Introducción al sellado estático',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 273,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            134 => 
            array (
                'id' => 1002,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            135 => 
            array (
                'id' => 1003,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            136 => 
            array (
                'id' => 1004,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 290,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            137 => 
            array (
                'id' => 1006,
                'nombre' => 'Las Obligaciones Patronales en Seguridad e Higiene',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            138 => 
            array (
                'id' => 1007,
                'nombre' => 'Las Obligaciones Patronales en Seguridad e Higiene',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            139 => 
            array (
                'id' => 1008,
                'nombre' => 'Las Obligaciones Patronales en Seguridad e Higiene',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 211,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            140 => 
            array (
                'id' => 1009,
                'nombre' => 'Las Obligaciones Patronales en Seguridad e Higiene',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 293,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            141 => 
            array (
                'id' => 1010,
                'nombre' => 'Las Obligaciones Patronales en Seguridad e Higiene',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 192,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            142 => 
            array (
                'id' => 1011,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            143 => 
            array (
                'id' => 1013,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 290,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            144 => 
            array (
                'id' => 1014,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            145 => 
            array (
                'id' => 1015,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            146 => 
            array (
                'id' => 1016,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            147 => 
            array (
                'id' => 1018,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 290,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            148 => 
            array (
                'id' => 1019,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            149 => 
            array (
                'id' => 1020,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            150 => 
            array (
                'id' => 1021,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 294,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            151 => 
            array (
                'id' => 1022,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 294,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            152 => 
            array (
                'id' => 1023,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 294,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            153 => 
            array (
                'id' => 1024,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 294,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            154 => 
            array (
                'id' => 1025,
                'nombre' => 'Facilitador de grupos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            155 => 
            array (
                'id' => 1027,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 294,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            156 => 
            array (
                'id' => 1028,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            157 => 
            array (
                'id' => 1029,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 288,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            158 => 
            array (
                'id' => 1030,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            159 => 
            array (
                'id' => 1031,
                'nombre' => 'Satech Proceso de elaboración, revisión y aprobación de requisiciones ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 257,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            160 => 
            array (
                'id' => 1032,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 290,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            161 => 
            array (
                'id' => 1033,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 52,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            162 => 
            array (
                'id' => 1034,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 273,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            163 => 
            array (
                'id' => 1035,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            164 => 
            array (
                'id' => 1036,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 18,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            165 => 
            array (
                'id' => 1037,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 282,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            166 => 
            array (
                'id' => 1038,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 261,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            167 => 
            array (
                'id' => 1039,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 280,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            168 => 
            array (
                'id' => 1040,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 180,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            169 => 
            array (
                'id' => 1041,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 38,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            170 => 
            array (
                'id' => 1042,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 255,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            171 => 
            array (
                'id' => 1044,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 192,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            172 => 
            array (
                'id' => 1045,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            173 => 
            array (
                'id' => 1046,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 199,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            174 => 
            array (
                'id' => 1047,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            175 => 
            array (
                'id' => 1048,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            176 => 
            array (
                'id' => 1049,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 52,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            177 => 
            array (
                'id' => 1050,
                'nombre' => 'Capacitación CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 263,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            178 => 
            array (
                'id' => 1051,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            179 => 
            array (
                'id' => 1052,
                'nombre' => 'Deformaciones en materiales sometidos a tratamientos térmicos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 52,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            180 => 
            array (
                'id' => 1053,
                'nombre' => 'Deformaciones en materiales sometidos a tratamientos térmicos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            181 => 
            array (
                'id' => 1054,
                'nombre' => 'Deformaciones en materiales sometidos a tratamientos térmicos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 273,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            182 => 
            array (
                'id' => 1055,
                'nombre' => 'Deformaciones en materiales sometidos a tratamientos térmicos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 19,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            183 => 
            array (
                'id' => 1056,
                'nombre' => 'Deformaciones en materiales sometidos a tratamientos térmicos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 106,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            184 => 
            array (
                'id' => 1057,
                'nombre' => 'Deformaciones en materiales sometidos a tratamientos térmicos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 53,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            185 => 
            array (
                'id' => 1058,
            'nombre' => 'Curso: CWI WAS (soldadura)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 14,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            186 => 
            array (
                'id' => 1062,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            187 => 
            array (
                'id' => 1064,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            188 => 
            array (
                'id' => 1065,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 297,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            189 => 
            array (
                'id' => 1066,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            190 => 
            array (
                'id' => 1067,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            191 => 
            array (
                'id' => 1068,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 297,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            192 => 
            array (
                'id' => 1071,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 300,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            193 => 
            array (
                'id' => 1072,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 300,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            194 => 
            array (
                'id' => 1073,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 300,
                'created_at' => '2024-05-08 18:43:28',
                'updated_at' => '2024-05-08 18:43:28',
            ),
            195 => 
            array (
                'id' => 1075,
                'nombre' => 'NOM-030-STPS-2009, Servicios preventivos de seguridad y salud en el trabajo.',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 293,
                'created_at' => '2024-06-20 09:40:47',
                'updated_at' => '2024-06-20 09:44:54',
            ),
            196 => 
            array (
                'id' => 1076,
                'nombre' => 'NOM-029-STPSS-2011, Mantenimiento de las instalaciones eléctricas en los centros de trabajo - Condiciones de seguridad.',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 293,
                'created_at' => '2024-06-20 09:42:12',
                'updated_at' => '2024-06-20 09:45:01',
            ),
            197 => 
            array (
                'id' => 1077,
                'nombre' => 'NOM-025-STPS-2008, Condiciones de iluminación en los centros de trabajo.',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 293,
                'created_at' => '2024-06-20 09:43:35',
                'updated_at' => '2024-06-20 09:43:35',
            ),
            198 => 
            array (
                'id' => 1078,
                'nombre' => 'Auditor interno en ISO 45001:2018, ISO 9001:2015, ISO 14001:2015',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 192,
                'created_at' => '2024-06-20 09:55:47',
                'updated_at' => '2024-06-20 09:55:47',
            ),
            199 => 
            array (
                'id' => 1079,
            'nombre' => 'SCRUM Fundamentals Certified (Success 876572)',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 36,
                'created_at' => '2024-06-21 03:39:31',
                'updated_at' => '2024-06-21 03:39:31',
            ),
            200 => 
            array (
                'id' => 1080,
                'nombre' => 'Diplomado en Administración de Proyectos',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 36,
                'created_at' => '2024-06-21 03:40:01',
                'updated_at' => '2024-06-21 03:40:01',
            ),
            201 => 
            array (
                'id' => 1081,
                'nombre' => 'Fundamentos e Integración de Precios Unitarios',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 36,
                'created_at' => '2024-06-21 03:40:25',
                'updated_at' => '2024-06-21 03:40:25',
            ),
            202 => 
            array (
                'id' => 1082,
                'nombre' => 'Ingeniería de Costos Industriales',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 36,
                'created_at' => '2024-06-21 03:40:42',
                'updated_at' => '2024-06-21 03:40:42',
            ),
            203 => 
            array (
                'id' => 1083,
                'nombre' => 'Pruebas de Fuga y Cambios de Presión Nivel II',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 36,
                'created_at' => '2024-06-21 03:42:13',
                'updated_at' => '2024-06-21 03:42:13',
            ),
            204 => 
            array (
                'id' => 1084,
                'nombre' => 'COSHH Awareness',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 270,
                'created_at' => '2024-06-28 04:49:22',
                'updated_at' => '2024-06-28 04:49:22',
            ),
            205 => 
            array (
                'id' => 1086,
                'nombre' => 'Habilidades de negociación',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            206 => 
            array (
                'id' => 1087,
                'nombre' => 'Habilidades de negociación',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 273,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            207 => 
            array (
                'id' => 1088,
                'nombre' => 'Habilidades de negociación',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            208 => 
            array (
                'id' => 1089,
                'nombre' => 'Habilidades de negociación',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 52,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            209 => 
            array (
                'id' => 1090,
                'nombre' => 'Facilitador de grupos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 293,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            210 => 
            array (
                'id' => 1091,
                'nombre' => 'Facilitador de grupos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            211 => 
            array (
                'id' => 1092,
                'nombre' => 'Facilitador de grupos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 200,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            212 => 
            array (
                'id' => 1093,
                'nombre' => 'Facilitador de grupos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 36,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            213 => 
            array (
                'id' => 1095,
                'nombre' => 'NOM-029-STPS-2011',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 192,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            214 => 
            array (
                'id' => 1096,
                'nombre' => 'NOM-029-STPS-2011',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 193,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            215 => 
            array (
                'id' => 1097,
                'nombre' => 'NOM-029-STPS-2011',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            216 => 
            array (
                'id' => 1098,
                'nombre' => 'NOM-029-STPS-2011',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            217 => 
            array (
                'id' => 1100,
                'nombre' => 'NOM-029-STPS-2011',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 192,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            218 => 
            array (
                'id' => 1101,
                'nombre' => 'NOM-029-STPS-2011',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 193,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            219 => 
            array (
                'id' => 1102,
                'nombre' => 'NOM-029-STPS-2011',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            220 => 
            array (
                'id' => 1103,
                'nombre' => 'NOM-029-STPS-2011',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            221 => 
            array (
                'id' => 1104,
                'nombre' => 'Taller: Rugosidad',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 200,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            222 => 
            array (
                'id' => 1105,
                'nombre' => 'Taller: Rugosidad',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            223 => 
            array (
                'id' => 1106,
                'nombre' => 'Taller: Rugosidad',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 187,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            224 => 
            array (
                'id' => 1107,
                'nombre' => 'Taller: Rugosidad',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 260,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            225 => 
            array (
                'id' => 1108,
                'nombre' => 'Taller: Rugosidad',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 276,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            226 => 
            array (
                'id' => 1109,
                'nombre' => 'Taller: Rugosidad',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            227 => 
            array (
                'id' => 1110,
                'nombre' => 'Taller: Rugosidad',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 287,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            228 => 
            array (
                'id' => 1111,
                'nombre' => 'Taller: Rugosidad',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 191,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            229 => 
            array (
                'id' => 1112,
                'nombre' => ' CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            230 => 
            array (
                'id' => 1113,
                'nombre' => ' CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            231 => 
            array (
                'id' => 1114,
                'nombre' => ' CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            232 => 
            array (
                'id' => 1115,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 279,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            233 => 
            array (
                'id' => 1116,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 89,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            234 => 
            array (
                'id' => 1117,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 299,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            235 => 
            array (
                'id' => 1118,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 297,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            236 => 
            array (
                'id' => 1119,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            237 => 
            array (
                'id' => 1120,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            238 => 
            array (
                'id' => 1121,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 157,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            239 => 
            array (
                'id' => 1122,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 50,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            240 => 
            array (
                'id' => 1123,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            241 => 
            array (
                'id' => 1124,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 205,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            242 => 
            array (
                'id' => 1125,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 99,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            243 => 
            array (
                'id' => 1126,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 252,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            244 => 
            array (
                'id' => 1127,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            245 => 
            array (
                'id' => 1128,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 13,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            246 => 
            array (
                'id' => 1129,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 131,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            247 => 
            array (
                'id' => 1130,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 26,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            248 => 
            array (
                'id' => 1131,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 137,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            249 => 
            array (
                'id' => 1132,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 14,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            250 => 
            array (
                'id' => 1133,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 270,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            251 => 
            array (
                'id' => 1134,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 212,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            252 => 
            array (
                'id' => 1135,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 64,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            253 => 
            array (
                'id' => 1136,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 92,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            254 => 
            array (
                'id' => 1137,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 293,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            255 => 
            array (
                'id' => 1138,
                'nombre' => 'Uso y cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 271,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-22 07:26:05',
            ),
            256 => 
            array (
                'id' => 1139,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 251,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            257 => 
            array (
                'id' => 1140,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 253,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            258 => 
            array (
                'id' => 1141,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 268,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            259 => 
            array (
                'id' => 1142,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            260 => 
            array (
                'id' => 1143,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 120,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            261 => 
            array (
                'id' => 1144,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 37,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            262 => 
            array (
                'id' => 1145,
                'nombre' => 'Uso y Cuidado de equipo de protección personal',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            263 => 
            array (
                'id' => 1146,
                'nombre' => 'Taller: Herramientas para la aplicación exitosa de entrevistas de trabajo',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            264 => 
            array (
                'id' => 1147,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 287,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            265 => 
            array (
                'id' => 1148,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 187,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            266 => 
            array (
                'id' => 1149,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 120,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            267 => 
            array (
                'id' => 1150,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            268 => 
            array (
                'id' => 1151,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            269 => 
            array (
                'id' => 1152,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            270 => 
            array (
                'id' => 1153,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            271 => 
            array (
                'id' => 1154,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            272 => 
            array (
                'id' => 1155,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 191,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            273 => 
            array (
                'id' => 1156,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            274 => 
            array (
                'id' => 1157,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 260,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            275 => 
            array (
                'id' => 1158,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 276,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            276 => 
            array (
                'id' => 1159,
                'nombre' => 'Curso: Cementado / Carburizado',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 288,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            277 => 
            array (
                'id' => 1160,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 293,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            278 => 
            array (
                'id' => 1161,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 199,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            279 => 
            array (
                'id' => 1162,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 200,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            280 => 
            array (
                'id' => 1163,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            281 => 
            array (
                'id' => 1164,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            282 => 
            array (
                'id' => 1165,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            283 => 
            array (
                'id' => 1166,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 19,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            284 => 
            array (
                'id' => 1167,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 36,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            285 => 
            array (
                'id' => 1168,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            286 => 
            array (
                'id' => 1169,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 240,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            287 => 
            array (
                'id' => 1170,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 192,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            288 => 
            array (
                'id' => 1171,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 263,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            289 => 
            array (
                'id' => 1172,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            290 => 
            array (
                'id' => 1173,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 13,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            291 => 
            array (
                'id' => 1174,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            292 => 
            array (
                'id' => 1175,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            293 => 
            array (
                'id' => 1176,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            294 => 
            array (
                'id' => 1177,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 53,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            295 => 
            array (
                'id' => 1178,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 191,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            296 => 
            array (
                'id' => 1179,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            297 => 
            array (
                'id' => 1180,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            298 => 
            array (
                'id' => 1181,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 37,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            299 => 
            array (
                'id' => 1182,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 260,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            300 => 
            array (
                'id' => 1183,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            301 => 
            array (
                'id' => 1184,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            302 => 
            array (
                'id' => 1185,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 120,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            303 => 
            array (
                'id' => 1186,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            304 => 
            array (
                'id' => 1187,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 287,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            305 => 
            array (
                'id' => 1188,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 276,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            306 => 
            array (
                'id' => 1189,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 187,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            307 => 
            array (
                'id' => 1190,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 157,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            308 => 
            array (
                'id' => 1191,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 268,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            309 => 
            array (
                'id' => 1192,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 137,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            310 => 
            array (
                'id' => 1193,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 253,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            311 => 
            array (
                'id' => 1194,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 212,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            312 => 
            array (
                'id' => 1195,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 92,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            313 => 
            array (
                'id' => 1196,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 265,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            314 => 
            array (
                'id' => 1197,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 50,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            315 => 
            array (
                'id' => 1198,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 22,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            316 => 
            array (
                'id' => 1199,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            317 => 
            array (
                'id' => 1200,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 202,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            318 => 
            array (
                'id' => 1201,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 252,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            319 => 
            array (
                'id' => 1202,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 131,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            320 => 
            array (
                'id' => 1203,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 26,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            321 => 
            array (
                'id' => 1204,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 297,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            322 => 
            array (
                'id' => 1205,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 258,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            323 => 
            array (
                'id' => 1206,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 256,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            324 => 
            array (
                'id' => 1207,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 271,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            325 => 
            array (
                'id' => 1208,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 279,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            326 => 
            array (
                'id' => 1209,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 269,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            327 => 
            array (
                'id' => 1210,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 132,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            328 => 
            array (
                'id' => 1211,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            329 => 
            array (
                'id' => 1212,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 250,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            330 => 
            array (
                'id' => 1213,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 257,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            331 => 
            array (
                'id' => 1214,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 294,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            332 => 
            array (
                'id' => 1215,
                'nombre' => ' NOM-031-STPS-2011- Medidas de prevención protección y control de riesgos, en la construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 50,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            333 => 
            array (
                'id' => 1216,
                'nombre' => ' NOM-031-STPS-2011- Construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 92,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-25 02:48:36',
            ),
            334 => 
            array (
                'id' => 1217,
                'nombre' => ' NOM-031-STPS-2011- Medidas de prevención protección y control de riesgos, en la construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 279,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            335 => 
            array (
                'id' => 1218,
                'nombre' => ' NOM-031-STPS-2011- Medidas de prevención protección y control de riesgos, en la construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 297,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            336 => 
            array (
                'id' => 1219,
                'nombre' => ' NOM-031-STPS-2011- Medidas de prevención protección y control de riesgos, en la construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 157,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            337 => 
            array (
                'id' => 1220,
                'nombre' => ' NOM-031-STPS-2011- Construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 252,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-30 08:48:23',
            ),
            338 => 
            array (
                'id' => 1221,
                'nombre' => ' NOM-031-STPS-2011- Construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 299,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-25 02:15:56',
            ),
            339 => 
            array (
                'id' => 1222,
                'nombre' => ' NOM-031-STPS-2011- Construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 131,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-30 08:14:48',
            ),
            340 => 
            array (
                'id' => 1223,
                'nombre' => ' NOM-031-STPS-2011- Construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 26,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-25 00:57:37',
            ),
            341 => 
            array (
                'id' => 1224,
                'nombre' => ' NOM-031-STPS-2011- Medidas de prevención protección y control de riesgos, en la construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 22,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            342 => 
            array (
                'id' => 1225,
                'nombre' => ' NOM-031-STPS-2011- Medidas de prevención protección y control de riesgos, en la construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 36,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            343 => 
            array (
                'id' => 1226,
                'nombre' => ' NOM-031-STPS-2011- Medidas de prevención protección y control de riesgos, en la construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 192,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            344 => 
            array (
                'id' => 1227,
                'nombre' => ' NOM-031-STPS-2011- Medidas de prevención protección y control de riesgos, en la construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            345 => 
            array (
                'id' => 1228,
                'nombre' => ' NOM-031-STPS-2011- Construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 40,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-25 04:03:23',
            ),
            346 => 
            array (
                'id' => 1229,
                'nombre' => ' NOM-031-STPS-2011- Medidas de prevención protección y control de riesgos, en la construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            347 => 
            array (
                'id' => 1230,
                'nombre' => ' NOM-031-STPS-2011- Medidas de prevención protección y control de riesgos, en la construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 280,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            348 => 
            array (
                'id' => 1231,
                'nombre' => 'EMPRESAS REPSE - NUEVO RÉGIMEN DE SERVICIOS
ESPECIALIZADOS',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            349 => 
            array (
                'id' => 1232,
                'nombre' => 'EMPRESAS REPSE - NUEVO RÉGIMEN DE SERVICIOS
ESPECIALIZADOS',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            350 => 
            array (
                'id' => 1233,
                'nombre' => 'EMPRESAS REPSE - NUEVO RÉGIMEN DE SERVICIOS
ESPECIALIZADOS',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 263,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            351 => 
            array (
                'id' => 1234,
                'nombre' => 'EMPRESAS REPSE - NUEVO RÉGIMEN DE SERVICIOS
ESPECIALIZADOS',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            352 => 
            array (
                'id' => 1236,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            353 => 
            array (
                'id' => 1238,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            354 => 
            array (
                'id' => 1239,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            355 => 
            array (
                'id' => 1240,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            356 => 
            array (
                'id' => 1241,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            357 => 
            array (
                'id' => 1242,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            358 => 
            array (
                'id' => 1243,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            359 => 
            array (
                'id' => 1244,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            360 => 
            array (
                'id' => 1245,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 120,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            361 => 
            array (
                'id' => 1246,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 37,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            362 => 
            array (
                'id' => 1247,
                'nombre' => 'Brigadas Munltifuncionales en Protección Civil',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 131,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-30 08:14:30',
            ),
            363 => 
            array (
                'id' => 1248,
                'nombre' => 'Multibragadas de emergencia.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 36,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2025-06-05 06:43:44',
            ),
            364 => 
            array (
                'id' => 1249,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 26,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            365 => 
            array (
                'id' => 1250,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 279,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            366 => 
            array (
                'id' => 1251,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 50,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            367 => 
            array (
                'id' => 1252,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 297,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            368 => 
            array (
                'id' => 1253,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 240,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            369 => 
            array (
                'id' => 1254,
                'nombre' => 'Multibragadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 293,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2025-06-05 06:40:59',
            ),
            370 => 
            array (
                'id' => 1255,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 192,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            371 => 
            array (
                'id' => 1256,
                'nombre' => 'Brigadas Multifuncional en Protección Civil',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 89,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-30 08:41:44',
            ),
            372 => 
            array (
                'id' => 1257,
                'nombre' => 'Brigadas Multifuncional en Protección Civil',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 270,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-25 02:51:58',
            ),
            373 => 
            array (
                'id' => 1258,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 166,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            374 => 
            array (
                'id' => 1259,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            375 => 
            array (
                'id' => 1260,
                'nombre' => 'Brigadas Multifuncional en Protección Civil',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 92,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-25 02:48:57',
            ),
            376 => 
            array (
                'id' => 1261,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 227,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            377 => 
            array (
                'id' => 1262,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            378 => 
            array (
                'id' => 1263,
                'nombre' => 'Multibrigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 269,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2025-07-16 02:39:11',
            ),
            379 => 
            array (
                'id' => 1264,
                'nombre' => 'Brigadas Multifuncional en Protección Civil',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 40,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-25 04:03:39',
            ),
            380 => 
            array (
                'id' => 1265,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            381 => 
            array (
                'id' => 1266,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 193,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            382 => 
            array (
                'id' => 1267,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 132,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            383 => 
            array (
                'id' => 1268,
                'nombre' => 'Brigadas Multifuncional en Protección Civil',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 299,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-10-25 02:13:34',
            ),
            384 => 
            array (
                'id' => 1269,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 157,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            385 => 
            array (
                'id' => 1270,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 22,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            386 => 
            array (
                'id' => 1271,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 14,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            387 => 
            array (
                'id' => 1272,
                'nombre' => 'Multibrigadas en Protección Civil',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 252,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2025-06-17 05:48:38',
            ),
            388 => 
            array (
                'id' => 1273,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 205,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            389 => 
            array (
                'id' => 1274,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 212,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            390 => 
            array (
                'id' => 1276,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 288,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            391 => 
            array (
                'id' => 1277,
                'nombre' => 'Brigadas de emergencia',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 271,
                'created_at' => '2024-07-19 05:14:24',
                'updated_at' => '2024-07-19 05:14:24',
            ),
            392 => 
            array (
                'id' => 1278,
                'nombre' => 'Licencia para conducir Tipo E',
                'tipo' => 'externo',
                'year' => '2004',
                'user_id' => 271,
                'created_at' => '2024-07-22 01:29:42',
                'updated_at' => '2024-07-22 01:29:42',
            ),
            393 => 
            array (
                'id' => 1279,
                'nombre' => 'DC-3  Seguridad en el manejo de herramientas manuales y de potencia.',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 271,
                'created_at' => '2024-07-22 07:13:37',
                'updated_at' => '2024-07-22 07:13:37',
            ),
            394 => 
            array (
                'id' => 1280,
                'nombre' => 'DC-3  Seguridad, mantenimiento y operación de grúa.',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 271,
                'created_at' => '2024-07-22 07:19:23',
                'updated_at' => '2024-07-22 07:19:23',
            ),
            395 => 
            array (
                'id' => 1281,
                'nombre' => 'Licencia de conducir Federal tipo B',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 271,
                'created_at' => '2024-08-07 04:15:20',
                'updated_at' => '2024-08-07 04:15:20',
            ),
            396 => 
            array (
                'id' => 1282,
                'nombre' => 'Excel para el desarrollo ejecutivo',
                'tipo' => 'externo',
                'year' => '2019',
                'user_id' => 18,
                'created_at' => '2024-08-15 00:39:35',
                'updated_at' => '2024-08-15 00:39:35',
            ),
            397 => 
            array (
                'id' => 1283,
            'nombre' => 'Pruebas de Fuga I y II (LT)',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 22,
                'created_at' => '2024-08-20 01:08:25',
                'updated_at' => '2024-08-20 01:08:25',
            ),
            398 => 
            array (
                'id' => 1284,
                'nombre' => 'Plan de acción para el hogar ante COVID-19',
                'tipo' => 'externo',
                'year' => '2020',
                'user_id' => 22,
                'created_at' => '2024-08-20 01:11:50',
                'updated_at' => '2024-08-20 01:11:50',
            ),
            399 => 
            array (
                'id' => 1285,
                'nombre' => 'Todo sobre la prevención del COVID-19',
                'tipo' => 'externo',
                'year' => '2020',
                'user_id' => 22,
                'created_at' => '2024-08-20 01:12:19',
                'updated_at' => '2024-08-20 01:12:19',
            ),
            400 => 
            array (
                'id' => 1286,
                'nombre' => 'Manejo e Instalación de Sistemas Stopper Bag ',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 22,
                'created_at' => '2024-08-20 01:15:52',
                'updated_at' => '2024-08-20 01:15:52',
            ),
            401 => 
            array (
                'id' => 1287,
                'nombre' => 'Recertificación para Técnicos en operaciones y Mantenimiento de de equipos Ht & LS',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 22,
                'created_at' => '2024-08-20 01:17:09',
                'updated_at' => '2024-08-20 01:17:09',
            ),
            402 => 
            array (
                'id' => 1288,
                'nombre' => 'Líder ISO 9001:2015 + Auditor Interno ISO 19011',
                'tipo' => 'externo',
                'year' => '2004',
                'user_id' => 301,
                'created_at' => '2024-08-20 02:34:30',
                'updated_at' => '2024-08-20 02:34:30',
            ),
            403 => 
            array (
                'id' => 1289,
                'nombre' => 'Implementación 9001:2015',
                'tipo' => 'externo',
                'year' => '2004',
                'user_id' => 301,
                'created_at' => '2024-08-20 02:35:02',
                'updated_at' => '2024-08-20 02:35:02',
            ),
            404 => 
            array (
                'id' => 1290,
                'nombre' => 'Sistemas Integrados 9001, 14001 y 45001',
                'tipo' => 'externo',
                'year' => '2004',
                'user_id' => 301,
                'created_at' => '2024-08-20 02:45:02',
                'updated_at' => '2024-08-20 02:45:02',
            ),
            405 => 
            array (
                'id' => 1291,
                'nombre' => 'NOM-031-STPS-2011 - Construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 14,
                'created_at' => '2024-10-24 01:27:06',
                'updated_at' => '2024-10-24 01:27:06',
            ),
            406 => 
            array (
                'id' => 1292,
                'nombre' => 'Brigadas Multifuncionales en Protección Civil',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 14,
                'created_at' => '2024-10-24 01:28:30',
                'updated_at' => '2024-10-24 01:28:30',
            ),
            407 => 
            array (
                'id' => 1294,
                'nombre' => '“Sistema Anticorrosivo ViscoElástico Viscowrap”',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 26,
                'created_at' => '2024-10-25 00:57:11',
                'updated_at' => '2024-10-25 00:57:11',
            ),
            408 => 
            array (
                'id' => 1300,
                'nombre' => 'NOM-031-STPS-2011- Construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 99,
                'created_at' => '2024-10-25 01:05:33',
                'updated_at' => '2024-10-25 01:05:33',
            ),
            409 => 
            array (
                'id' => 1301,
                'nombre' => 'Multibirgadas en Protección Civil',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 99,
                'created_at' => '2024-10-25 01:06:36',
                'updated_at' => '2025-06-17 05:45:58',
            ),
            410 => 
            array (
                'id' => 1302,
                'nombre' => 'Operación segura de Montacargas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 99,
                'created_at' => '2024-10-25 01:07:55',
                'updated_at' => '2024-10-25 01:07:55',
            ),
            411 => 
            array (
                'id' => 1306,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancías químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 299,
                'created_at' => '2024-10-25 02:16:51',
                'updated_at' => '2024-10-25 02:16:51',
            ),
            412 => 
            array (
                'id' => 1307,
                'nombre' => 'Inducción Sistema de Gestión Antisoborno',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 299,
                'created_at' => '2024-10-25 02:17:29',
                'updated_at' => '2024-10-25 02:17:29',
            ),
            413 => 
            array (
                'id' => 1308,
            'nombre' => 'Leak Test (Pruebas de fuga básico)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 92,
                'created_at' => '2024-10-25 02:49:35',
                'updated_at' => '2024-10-25 02:49:35',
            ),
            414 => 
            array (
                'id' => 1310,
                'nombre' => 'NOM-031-STPS-2011 - Construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 270,
                'created_at' => '2024-10-25 02:52:51',
                'updated_at' => '2024-10-25 02:52:51',
            ),
            415 => 
            array (
                'id' => 1311,
            'nombre' => 'Leak Test (Pruebas de fugas básico)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 270,
                'created_at' => '2024-10-25 02:53:14',
                'updated_at' => '2024-10-25 02:53:24',
            ),
            416 => 
            array (
                'id' => 1312,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 40,
                'created_at' => '2024-10-25 04:04:34',
                'updated_at' => '2024-10-25 04:04:34',
            ),
            417 => 
            array (
                'id' => 1313,
                'nombre' => 'Sistema armonizado de sustancias químicas peligrosas.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 40,
                'created_at' => '2024-10-25 04:05:04',
                'updated_at' => '2024-10-25 04:05:04',
            ),
            418 => 
            array (
                'id' => 1314,
                'nombre' => 'Workshop: ASME Sección V Artículo 6 - Líquidos Penetrantes',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 40,
                'created_at' => '2024-10-25 04:15:54',
                'updated_at' => '2024-10-25 04:15:54',
            ),
            419 => 
            array (
                'id' => 1315,
                'nombre' => 'Básico de seguridad para plataformas y barcazas',
                'tipo' => 'interno',
                'year' => '2023',
                'user_id' => 92,
                'created_at' => '2024-10-25 04:24:45',
                'updated_at' => '2024-10-25 04:24:45',
            ),
            420 => 
            array (
                'id' => 1316,
                'nombre' => 'Sistema Anticorrosivo ViscoElástico Viscowrap',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 131,
                'created_at' => '2024-10-30 08:31:27',
                'updated_at' => '2024-10-30 08:31:27',
            ),
            421 => 
            array (
                'id' => 1319,
                'nombre' => 'Sistema Anticorrosivo ViscoElástico Viscowrap',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 89,
                'created_at' => '2024-10-30 08:41:20',
                'updated_at' => '2024-10-30 08:41:20',
            ),
            422 => 
            array (
                'id' => 1320,
                'nombre' => 'NOM-031-STPS-2011- Construcción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 89,
                'created_at' => '2024-10-30 08:42:15',
                'updated_at' => '2024-10-30 08:42:15',
            ),
            423 => 
            array (
                'id' => 1321,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 89,
                'created_at' => '2024-10-30 08:43:06',
                'updated_at' => '2024-10-30 08:43:06',
            ),
            424 => 
            array (
                'id' => 1325,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 252,
                'created_at' => '2024-10-30 08:49:43',
                'updated_at' => '2024-10-30 08:49:43',
            ),
            425 => 
            array (
                'id' => 1326,
            'nombre' => 'Diplomado en Contribuciones fiscales (15a generación)',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 247,
                'created_at' => '2024-11-01 03:12:29',
                'updated_at' => '2024-11-01 03:12:29',
            ),
            426 => 
            array (
                'id' => 1327,
                'nombre' => 'Anexo SSPA',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 266,
                'created_at' => '2024-11-07 07:26:24',
                'updated_at' => '2024-11-07 07:26:24',
            ),
            427 => 
            array (
                'id' => 1328,
                'nombre' => 'CLASIFICACION Y USO DE EQUIPO DE PROTECCION  PERSONAL',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2024-11-07 07:27:56',
                'updated_at' => '2024-11-07 07:27:56',
            ),
            428 => 
            array (
                'id' => 1329,
                'nombre' => 'SEGURIDAD EN TRABAJOS EN  ALTURAS',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2024-11-07 07:28:22',
                'updated_at' => '2024-11-07 07:28:22',
            ),
            429 => 
            array (
                'id' => 1330,
                'nombre' => 'TRABAJO EN ESPACIOS CONFINADOS Y RESCATE  INDUSTRIAL',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2024-11-07 07:28:39',
                'updated_at' => '2024-11-07 07:28:39',
            ),
            430 => 
            array (
                'id' => 1331,
                'nombre' => 'SUPERVISION EN SEGURIDAD INDUSTRIAL PARA LIDERES DE EQUIPOS DE TRABAJO',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2024-11-07 07:28:55',
                'updated_at' => '2024-11-07 07:28:55',
            ),
            431 => 
            array (
                'id' => 1333,
                'nombre' => 'Trabajo en Alturas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 157,
                'created_at' => '2024-11-19 03:30:08',
                'updated_at' => '2024-11-19 03:30:08',
            ),
            432 => 
            array (
                'id' => 1334,
                'nombre' => 'Trabajos en Altura',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 205,
                'created_at' => '2024-11-19 03:31:16',
                'updated_at' => '2024-11-19 03:31:16',
            ),
            433 => 
            array (
                'id' => 1335,
                'nombre' => 'Trabajos en altura',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 270,
                'created_at' => '2024-11-19 03:32:38',
                'updated_at' => '2024-11-19 03:32:38',
            ),
            434 => 
            array (
                'id' => 1336,
                'nombre' => 'Trabajos en Altura',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 92,
                'created_at' => '2024-11-19 03:33:29',
                'updated_at' => '2024-11-19 03:33:29',
            ),
            435 => 
            array (
                'id' => 1337,
            'nombre' => 'LEAK TEST (Pruebas de fuga).',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 304,
                'created_at' => '2024-12-04 08:32:19',
                'updated_at' => '2024-12-04 08:32:19',
            ),
            436 => 
            array (
                'id' => 1338,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            437 => 
            array (
                'id' => 1339,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            438 => 
            array (
                'id' => 1340,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            439 => 
            array (
                'id' => 1341,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 120,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            440 => 
            array (
                'id' => 1342,
                'nombre' => 'Mecánica Básica',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 37,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            441 => 
            array (
                'id' => 1343,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 305,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            442 => 
            array (
                'id' => 1344,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            443 => 
            array (
                'id' => 1345,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 305,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            444 => 
            array (
                'id' => 1346,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            445 => 
            array (
                'id' => 1347,
                'nombre' => 'Interpretación de Planos y Simbología',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 120,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            446 => 
            array (
                'id' => 1348,
                'nombre' => 'Interpretación de Planos y Simbología',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            447 => 
            array (
                'id' => 1349,
                'nombre' => 'Interpretación de Planos y Simbología',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            448 => 
            array (
                'id' => 1350,
                'nombre' => 'Interpretación de Planos y Simbología',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            449 => 
            array (
                'id' => 1351,
                'nombre' => 'Interpretación de Planos y Simbología',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            450 => 
            array (
                'id' => 1352,
                'nombre' => 'Interpretación de Planos y Simbología',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            451 => 
            array (
                'id' => 1353,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 305,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            452 => 
            array (
                'id' => 1354,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            453 => 
            array (
                'id' => 1356,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            454 => 
            array (
                'id' => 1357,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 304,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            455 => 
            array (
                'id' => 1358,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 305,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            456 => 
            array (
                'id' => 1359,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            457 => 
            array (
                'id' => 1360,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            458 => 
            array (
                'id' => 1361,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 53,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            459 => 
            array (
                'id' => 1362,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 276,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            460 => 
            array (
                'id' => 1363,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 187,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            461 => 
            array (
                'id' => 1364,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 269,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            462 => 
            array (
                'id' => 1365,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 191,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            463 => 
            array (
                'id' => 1369,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 132,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            464 => 
            array (
                'id' => 1370,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 120,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            465 => 
            array (
                'id' => 1371,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 40,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            466 => 
            array (
                'id' => 1372,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 287,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            467 => 
            array (
                'id' => 1373,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            468 => 
            array (
                'id' => 1374,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            469 => 
            array (
                'id' => 1376,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            470 => 
            array (
                'id' => 1377,
                'nombre' => 'Curso: Equipo HyTorc N-01',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 280,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            471 => 
            array (
                'id' => 1378,
                'nombre' => 'Tolerancias Geometricas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 53,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            472 => 
            array (
                'id' => 1379,
                'nombre' => 'Tolerancias Geometricas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 287,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            473 => 
            array (
                'id' => 1380,
                'nombre' => 'Tolerancias Geometricas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 260,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            474 => 
            array (
                'id' => 1381,
                'nombre' => 'Tolerancias Geometricas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 191,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            475 => 
            array (
                'id' => 1382,
                'nombre' => 'Tolerancias Geometricas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 187,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            476 => 
            array (
                'id' => 1383,
                'nombre' => 'Tolerancias Geometricas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            477 => 
            array (
                'id' => 1384,
                'nombre' => 'Tolerancias Geometricas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 276,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            478 => 
            array (
                'id' => 1385,
                'nombre' => 'Tolerancias Geometricas',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            479 => 
            array (
                'id' => 1386,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            480 => 
            array (
                'id' => 1387,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            481 => 
            array (
                'id' => 1388,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            482 => 
            array (
                'id' => 1389,
                'nombre' => 'Facilitador de grupos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 18,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            483 => 
            array (
                'id' => 1390,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 268,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            484 => 
            array (
                'id' => 1391,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 253,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            485 => 
            array (
                'id' => 1392,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 265,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            486 => 
            array (
                'id' => 1395,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 200,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            487 => 
            array (
                'id' => 1396,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            488 => 
            array (
                'id' => 1397,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 227,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            489 => 
            array (
                'id' => 1398,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 50,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            490 => 
            array (
                'id' => 1399,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 205,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            491 => 
            array (
                'id' => 1401,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            492 => 
            array (
                'id' => 1403,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 137,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            493 => 
            array (
                'id' => 1404,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            494 => 
            array (
                'id' => 1405,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            495 => 
            array (
                'id' => 1408,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            496 => 
            array (
                'id' => 1410,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 157,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            497 => 
            array (
                'id' => 1412,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 212,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            498 => 
            array (
                'id' => 1414,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            499 => 
            array (
                'id' => 1415,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
        ));
        \DB::table('cv_curso_certificacions')->insert(array (
            0 => 
            array (
                'id' => 1416,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 268,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            1 => 
            array (
                'id' => 1418,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 265,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            2 => 
            array (
                'id' => 1419,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            3 => 
            array (
                'id' => 1420,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 137,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            4 => 
            array (
                'id' => 1423,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 308,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            5 => 
            array (
                'id' => 1424,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            6 => 
            array (
                'id' => 1425,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 308,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            7 => 
            array (
                'id' => 1426,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            8 => 
            array (
                'id' => 1427,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 308,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            9 => 
            array (
                'id' => 1428,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            10 => 
            array (
                'id' => 1429,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 308,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            11 => 
            array (
                'id' => 1430,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            12 => 
            array (
                'id' => 1431,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            13 => 
            array (
                'id' => 1432,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            14 => 
            array (
                'id' => 1433,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            15 => 
            array (
                'id' => 1435,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 305,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            16 => 
            array (
                'id' => 1436,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            17 => 
            array (
                'id' => 1437,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            18 => 
            array (
                'id' => 1438,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 52,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            19 => 
            array (
                'id' => 1440,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 158,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            20 => 
            array (
                'id' => 1442,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            21 => 
            array (
                'id' => 1443,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 199,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            22 => 
            array (
                'id' => 1444,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            23 => 
            array (
                'id' => 1445,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 263,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            24 => 
            array (
                'id' => 1446,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 166,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            25 => 
            array (
                'id' => 1447,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 282,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            26 => 
            array (
                'id' => 1448,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 247,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            27 => 
            array (
                'id' => 1449,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 290,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            28 => 
            array (
                'id' => 1450,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            29 => 
            array (
                'id' => 1451,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            30 => 
            array (
                'id' => 1452,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 240,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            31 => 
            array (
                'id' => 1453,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            32 => 
            array (
                'id' => 1455,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 120,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            33 => 
            array (
                'id' => 1456,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            34 => 
            array (
                'id' => 1457,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 37,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            35 => 
            array (
                'id' => 1458,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            36 => 
            array (
                'id' => 1460,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            37 => 
            array (
                'id' => 1463,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 202,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            38 => 
            array (
                'id' => 1465,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 256,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            39 => 
            array (
                'id' => 1466,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            40 => 
            array (
                'id' => 1469,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            41 => 
            array (
                'id' => 1471,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            42 => 
            array (
                'id' => 1472,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            43 => 
            array (
                'id' => 1473,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 18,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            44 => 
            array (
                'id' => 1474,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            45 => 
            array (
                'id' => 1477,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            46 => 
            array (
                'id' => 1478,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 265,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            47 => 
            array (
                'id' => 1480,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 268,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            48 => 
            array (
                'id' => 1481,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            49 => 
            array (
                'id' => 1483,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 257,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            50 => 
            array (
                'id' => 1484,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            51 => 
            array (
                'id' => 1485,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 258,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            52 => 
            array (
                'id' => 1486,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            53 => 
            array (
                'id' => 1487,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 253,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            54 => 
            array (
                'id' => 1489,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            55 => 
            array (
                'id' => 1491,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            56 => 
            array (
                'id' => 1492,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            57 => 
            array (
                'id' => 1493,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 280,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            58 => 
            array (
                'id' => 1494,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 265,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            59 => 
            array (
                'id' => 1496,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 268,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            60 => 
            array (
                'id' => 1497,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 137,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            61 => 
            array (
                'id' => 1500,
            'nombre' => 'Curso: Leak Test (Pruebas de fuga)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            62 => 
            array (
                'id' => 1501,
                'nombre' => 'Facilitador de grupos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 132,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            63 => 
            array (
                'id' => 1502,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            64 => 
            array (
                'id' => 1503,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            65 => 
            array (
                'id' => 1504,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            66 => 
            array (
                'id' => 1507,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            67 => 
            array (
                'id' => 1508,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 258,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            68 => 
            array (
                'id' => 1509,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 256,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            69 => 
            array (
                'id' => 1510,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            70 => 
            array (
                'id' => 1513,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 257,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            71 => 
            array (
                'id' => 1514,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            72 => 
            array (
                'id' => 1515,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 250,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            73 => 
            array (
                'id' => 1516,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            74 => 
            array (
                'id' => 1517,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 223,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            75 => 
            array (
                'id' => 1520,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 279,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            76 => 
            array (
                'id' => 1521,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            77 => 
            array (
                'id' => 1522,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            78 => 
            array (
                'id' => 1523,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            79 => 
            array (
                'id' => 1524,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 240,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            80 => 
            array (
                'id' => 1525,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            81 => 
            array (
                'id' => 1526,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 305,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            82 => 
            array (
                'id' => 1527,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 52,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            83 => 
            array (
                'id' => 1529,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            84 => 
            array (
                'id' => 1530,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 199,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            85 => 
            array (
                'id' => 1531,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            86 => 
            array (
                'id' => 1533,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            87 => 
            array (
                'id' => 1538,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            88 => 
            array (
                'id' => 1539,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 18,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            89 => 
            array (
                'id' => 1545,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 37,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            90 => 
            array (
                'id' => 1546,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            91 => 
            array (
                'id' => 1547,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            92 => 
            array (
                'id' => 1548,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            93 => 
            array (
                'id' => 1549,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            94 => 
            array (
                'id' => 1550,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 202,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            95 => 
            array (
                'id' => 1552,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 310,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            96 => 
            array (
                'id' => 1553,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 310,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            97 => 
            array (
                'id' => 1554,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 310,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            98 => 
            array (
                'id' => 1555,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 310,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            99 => 
            array (
                'id' => 1556,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 296,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            100 => 
            array (
                'id' => 1557,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 26,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            101 => 
            array (
                'id' => 1559,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 252,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            102 => 
            array (
                'id' => 1560,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 199,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            103 => 
            array (
                'id' => 1561,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 271,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            104 => 
            array (
                'id' => 1562,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 264,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            105 => 
            array (
                'id' => 1563,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 230,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            106 => 
            array (
                'id' => 1564,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            107 => 
            array (
                'id' => 1565,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 257,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            108 => 
            array (
                'id' => 1566,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 193,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            109 => 
            array (
                'id' => 1567,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 250,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            110 => 
            array (
                'id' => 1568,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 152,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            111 => 
            array (
                'id' => 1569,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 99,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            112 => 
            array (
                'id' => 1570,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 202,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            113 => 
            array (
                'id' => 1571,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 13,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            114 => 
            array (
                'id' => 1572,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 258,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            115 => 
            array (
                'id' => 1573,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 256,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            116 => 
            array (
                'id' => 1574,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 131,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            117 => 
            array (
                'id' => 1575,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 279,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            118 => 
            array (
                'id' => 1576,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 293,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            119 => 
            array (
                'id' => 1577,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            120 => 
            array (
                'id' => 1578,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 244,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            121 => 
            array (
                'id' => 1579,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 301,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            122 => 
            array (
                'id' => 1580,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 249,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            123 => 
            array (
                'id' => 1581,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 37,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            124 => 
            array (
                'id' => 1582,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 120,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            125 => 
            array (
                'id' => 1583,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 275,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            126 => 
            array (
                'id' => 1584,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            127 => 
            array (
                'id' => 1585,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 289,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            128 => 
            array (
                'id' => 1586,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 137,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            129 => 
            array (
                'id' => 1587,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 253,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            130 => 
            array (
                'id' => 1588,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 40,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            131 => 
            array (
                'id' => 1589,
                'nombre' => 'Manejo, transporte y almacenamiento de sustancias químicas peligrosas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 265,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            132 => 
            array (
                'id' => 1590,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            133 => 
            array (
                'id' => 1591,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            134 => 
            array (
                'id' => 1592,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 240,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            135 => 
            array (
                'id' => 1593,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            136 => 
            array (
                'id' => 1594,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            137 => 
            array (
                'id' => 1595,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 52,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            138 => 
            array (
                'id' => 1597,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            139 => 
            array (
                'id' => 1598,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 199,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            140 => 
            array (
                'id' => 1600,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            141 => 
            array (
                'id' => 1602,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            142 => 
            array (
                'id' => 1606,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            143 => 
            array (
                'id' => 1608,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            144 => 
            array (
                'id' => 1609,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            145 => 
            array (
                'id' => 1610,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            146 => 
            array (
                'id' => 1611,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            147 => 
            array (
                'id' => 1612,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            148 => 
            array (
                'id' => 1616,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            149 => 
            array (
                'id' => 1617,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 271,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            150 => 
            array (
                'id' => 1620,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            151 => 
            array (
                'id' => 1622,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            152 => 
            array (
                'id' => 1623,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            153 => 
            array (
                'id' => 1624,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            154 => 
            array (
                'id' => 1625,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            155 => 
            array (
                'id' => 1626,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            156 => 
            array (
                'id' => 1627,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 250,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            157 => 
            array (
                'id' => 1628,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            158 => 
            array (
                'id' => 1629,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 257,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            159 => 
            array (
                'id' => 1630,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 193,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            160 => 
            array (
                'id' => 1634,
                'nombre' => 'Estrategia IMSS "Yo Puedo"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 137,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            161 => 
            array (
                'id' => 1637,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 26,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            162 => 
            array (
                'id' => 1638,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 131,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            163 => 
            array (
                'id' => 1639,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 299,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            164 => 
            array (
                'id' => 1640,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 252,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            165 => 
            array (
                'id' => 1641,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 250,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            166 => 
            array (
                'id' => 1642,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 257,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            167 => 
            array (
                'id' => 1643,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            168 => 
            array (
                'id' => 1644,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 193,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            169 => 
            array (
                'id' => 1645,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            170 => 
            array (
                'id' => 1646,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 202,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            171 => 
            array (
                'id' => 1647,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 89,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            172 => 
            array (
                'id' => 1648,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 258,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            173 => 
            array (
                'id' => 1649,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 256,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            174 => 
            array (
                'id' => 1650,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 244,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            175 => 
            array (
                'id' => 1651,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            176 => 
            array (
                'id' => 1652,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            177 => 
            array (
                'id' => 1653,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 37,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            178 => 
            array (
                'id' => 1654,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            179 => 
            array (
                'id' => 1655,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            180 => 
            array (
                'id' => 1656,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 268,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            181 => 
            array (
                'id' => 1657,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 253,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            182 => 
            array (
                'id' => 1658,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            183 => 
            array (
                'id' => 1659,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            184 => 
            array (
                'id' => 1660,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            185 => 
            array (
                'id' => 1661,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 40,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            186 => 
            array (
                'id' => 1662,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 265,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            187 => 
            array (
                'id' => 1663,
                'nombre' => 'Sistema armonizado para sustancias químicas en los centros de trabajo ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 137,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            188 => 
            array (
                'id' => 1664,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 311,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            189 => 
            array (
                'id' => 1665,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 311,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            190 => 
            array (
                'id' => 1666,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 311,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            191 => 
            array (
                'id' => 1667,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 311,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            192 => 
            array (
                'id' => 1668,
                'nombre' => 'Nom 035 Factores de riesgo psicosocial ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            193 => 
            array (
                'id' => 1669,
                'nombre' => 'Nom 035 Factores de riesgo psicosocial ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            194 => 
            array (
                'id' => 1670,
                'nombre' => 'Nom 035 Factores de riesgo psicosocial ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            195 => 
            array (
                'id' => 1671,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 299,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            196 => 
            array (
                'id' => 1672,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            197 => 
            array (
                'id' => 1673,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 191,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            198 => 
            array (
                'id' => 1674,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 53,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            199 => 
            array (
                'id' => 1675,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            200 => 
            array (
                'id' => 1676,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 187,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            201 => 
            array (
                'id' => 1677,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 287,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            202 => 
            array (
                'id' => 1678,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 276,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            203 => 
            array (
                'id' => 1679,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 260,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            204 => 
            array (
                'id' => 1680,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 200,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            205 => 
            array (
                'id' => 1681,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            206 => 
            array (
                'id' => 1682,
                'nombre' => 'NOM-027-STPS-2008 Actividades de soldadura y corte',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            207 => 
            array (
                'id' => 1683,
                'nombre' => ' CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            208 => 
            array (
                'id' => 1684,
                'nombre' => ' CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 305,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            209 => 
            array (
                'id' => 1685,
                'nombre' => ' CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            210 => 
            array (
                'id' => 1686,
                'nombre' => ' CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            211 => 
            array (
                'id' => 1687,
                'nombre' => ' CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 310,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            212 => 
            array (
                'id' => 1688,
                'nombre' => ' CFDI y Procesos de Pago',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            213 => 
            array (
                'id' => 1693,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 270,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            214 => 
            array (
                'id' => 1694,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 199,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            215 => 
            array (
                'id' => 1695,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            216 => 
            array (
                'id' => 1696,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 157,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            217 => 
            array (
                'id' => 1697,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 50,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            218 => 
            array (
                'id' => 1698,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 132,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            219 => 
            array (
                'id' => 1699,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            220 => 
            array (
                'id' => 1700,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 205,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            221 => 
            array (
                'id' => 1702,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            222 => 
            array (
                'id' => 1703,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 257,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            223 => 
            array (
                'id' => 1704,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 271,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            224 => 
            array (
                'id' => 1705,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 293,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            225 => 
            array (
                'id' => 1706,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            226 => 
            array (
                'id' => 1707,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            227 => 
            array (
                'id' => 1708,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            228 => 
            array (
                'id' => 1709,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            229 => 
            array (
                'id' => 1710,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            230 => 
            array (
                'id' => 1711,
            'nombre' => 'NOM-009  Seguridad para realizar trabajos en altura (Teorica y Practica)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 277,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            231 => 
            array (
                'id' => 1713,
                'nombre' => 'Inducción',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 314,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            232 => 
            array (
                'id' => 1714,
                'nombre' => 'Inducción Sistema de Gestión Integral',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 314,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            233 => 
            array (
                'id' => 1715,
            'nombre' => 'Inducción Sistema de gestión Integral (HSE)',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 314,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            234 => 
            array (
                'id' => 1716,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            235 => 
            array (
                'id' => 1717,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            236 => 
            array (
                'id' => 1718,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            237 => 
            array (
                'id' => 1719,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            238 => 
            array (
                'id' => 1721,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            239 => 
            array (
                'id' => 1722,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 52,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            240 => 
            array (
                'id' => 1723,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            241 => 
            array (
                'id' => 1724,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            242 => 
            array (
                'id' => 1725,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            243 => 
            array (
                'id' => 1727,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 240,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            244 => 
            array (
                'id' => 1728,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            245 => 
            array (
                'id' => 1729,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 199,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            246 => 
            array (
                'id' => 1732,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            247 => 
            array (
                'id' => 1736,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            248 => 
            array (
                'id' => 1737,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 314,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            249 => 
            array (
                'id' => 1738,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            250 => 
            array (
                'id' => 1740,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            251 => 
            array (
                'id' => 1741,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 257,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            252 => 
            array (
                'id' => 1742,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            253 => 
            array (
                'id' => 1743,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 271,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            254 => 
            array (
                'id' => 1744,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 223,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            255 => 
            array (
                'id' => 1745,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 253,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            256 => 
            array (
                'id' => 1746,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 250,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            257 => 
            array (
                'id' => 1747,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            258 => 
            array (
                'id' => 1748,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            259 => 
            array (
                'id' => 1751,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            260 => 
            array (
                'id' => 1752,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 202,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            261 => 
            array (
                'id' => 1753,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            262 => 
            array (
                'id' => 1754,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            263 => 
            array (
                'id' => 1755,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 37,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            264 => 
            array (
                'id' => 1756,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 256,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            265 => 
            array (
                'id' => 1757,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 258,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            266 => 
            array (
                'id' => 1759,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 266,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            267 => 
            array (
                'id' => 1760,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 305,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            268 => 
            array (
                'id' => 1761,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 52,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            269 => 
            array (
                'id' => 1762,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            270 => 
            array (
                'id' => 1763,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            271 => 
            array (
                'id' => 1764,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            272 => 
            array (
                'id' => 1766,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            273 => 
            array (
                'id' => 1768,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            274 => 
            array (
                'id' => 1772,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 263,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            275 => 
            array (
                'id' => 1773,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            276 => 
            array (
                'id' => 1774,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            277 => 
            array (
                'id' => 1775,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            278 => 
            array (
                'id' => 1776,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            279 => 
            array (
                'id' => 1778,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 240,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            280 => 
            array (
                'id' => 1780,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 256,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            281 => 
            array (
                'id' => 1782,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            282 => 
            array (
                'id' => 1784,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 13,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            283 => 
            array (
                'id' => 1785,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 193,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            284 => 
            array (
                'id' => 1786,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            285 => 
            array (
                'id' => 1787,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 120,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            286 => 
            array (
                'id' => 1788,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            287 => 
            array (
                'id' => 1789,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            288 => 
            array (
                'id' => 1790,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            289 => 
            array (
                'id' => 1791,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            290 => 
            array (
                'id' => 1792,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 37,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            291 => 
            array (
                'id' => 1793,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 292,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            292 => 
            array (
                'id' => 1794,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 307,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            293 => 
            array (
                'id' => 1795,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 268,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            294 => 
            array (
                'id' => 1796,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 271,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            295 => 
            array (
                'id' => 1797,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 265,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            296 => 
            array (
                'id' => 1799,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 258,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            297 => 
            array (
                'id' => 1801,
                'nombre' => 'Sistema de Gestión Antisoborno y Cumpliemnto legal.',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 314,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            298 => 
            array (
                'id' => 1802,
                'nombre' => 'Curso: Marketing Digital',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 240,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            299 => 
            array (
                'id' => 1803,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 123,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            300 => 
            array (
                'id' => 1804,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            301 => 
            array (
                'id' => 1805,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            302 => 
            array (
                'id' => 1806,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 298,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            303 => 
            array (
                'id' => 1807,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 274,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            304 => 
            array (
                'id' => 1808,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 305,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            305 => 
            array (
                'id' => 1809,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 306,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            306 => 
            array (
                'id' => 1810,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 240,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            307 => 
            array (
                'id' => 1811,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 152,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            308 => 
            array (
                'id' => 1815,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 114,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            309 => 
            array (
                'id' => 1817,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 166,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            310 => 
            array (
                'id' => 1818,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            311 => 
            array (
                'id' => 1819,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 263,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            312 => 
            array (
                'id' => 1820,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 290,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            313 => 
            array (
                'id' => 1821,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 247,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            314 => 
            array (
                'id' => 1823,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 303,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            315 => 
            array (
                'id' => 1824,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 256,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            316 => 
            array (
                'id' => 1825,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 258,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            317 => 
            array (
                'id' => 1826,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 120,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            318 => 
            array (
                'id' => 1827,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 249,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            319 => 
            array (
                'id' => 1828,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 275,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            320 => 
            array (
                'id' => 1829,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 289,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            321 => 
            array (
                'id' => 1830,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 223,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            322 => 
            array (
                'id' => 1831,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 235,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            323 => 
            array (
                'id' => 1832,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 268,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            324 => 
            array (
                'id' => 1833,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 230,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            325 => 
            array (
                'id' => 1834,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 202,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            326 => 
            array (
                'id' => 1835,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 271,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            327 => 
            array (
                'id' => 1836,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 264,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            328 => 
            array (
                'id' => 1838,
                'nombre' => 'Estrategia IMSS "Ella y Él"',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 286,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            329 => 
            array (
                'id' => 1839,
                'nombre' => 'Evaluació por competencias ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 263,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            330 => 
            array (
                'id' => 1840,
                'nombre' => 'Evaluació por competencias ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 296,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            331 => 
            array (
                'id' => 1841,
                'nombre' => 'Evaluación por competencias ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 302,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:59:18',
            ),
            332 => 
            array (
                'id' => 1842,
                'nombre' => 'Evaluació por competencias ',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 180,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            333 => 
            array (
                'id' => 1843,
                'nombre' => 'Facilitador de grupos',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 271,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            334 => 
            array (
                'id' => 1844,
                'nombre' => 'Curso: Comunicación y habilidades sociales',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 240,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            335 => 
            array (
                'id' => 1845,
                'nombre' => 'Amortizaciones y depreciaciones',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 282,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            336 => 
            array (
                'id' => 1846,
                'nombre' => 'Amortizaciones y depreciaciones',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 290,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            337 => 
            array (
                'id' => 1847,
                'nombre' => 'Auditor sistemas integrados de gestión hsea 9001 - 14001 - 45001',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 293,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            338 => 
            array (
                'id' => 1848,
                'nombre' => 'Auditor sistemas integrados de gestión hsea 9001 - 14001 - 45001',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 301,
                'created_at' => '2025-01-06 07:54:32',
                'updated_at' => '2025-01-06 07:54:32',
            ),
            339 => 
            array (
                'id' => 1849,
            'nombre' => 'CAPACITACION EN LA NOM-002-SECRE-2010 POR LA ASOCIACION MEXICANA DE GAS NATURAL (AMGN)',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 310,
                'created_at' => '2025-02-26 05:10:09',
                'updated_at' => '2025-02-26 08:01:30',
            ),
            340 => 
            array (
                'id' => 1850,
            'nombre' => 'CURSO DE CAIDA DE PRESION POR EL CENTRO ESPECIALIZADO DE CAPCITACION PARA EL SECTOR DE ENERGIA (CECSE)',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 310,
                'created_at' => '2025-02-26 05:16:34',
                'updated_at' => '2025-02-26 05:16:34',
            ),
            341 => 
            array (
                'id' => 1851,
                'nombre' => 'Certificación de manejo de tubería PE-AL-PE y calibración de equipo residencial por ENGIE MEXICO',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 310,
                'created_at' => '2025-02-26 05:18:24',
                'updated_at' => '2025-02-26 05:26:32',
            ),
            342 => 
            array (
                'id' => 1852,
                'nombre' => 'Brigadas para Emergencias ',
                'tipo' => 'externo',
                'year' => '2019',
                'user_id' => 309,
                'created_at' => '2025-03-03 06:30:54',
                'updated_at' => '2025-03-03 06:30:54',
            ),
            343 => 
            array (
                'id' => 1853,
                'nombre' => 'Inglés Intermedio B2',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 309,
                'created_at' => '2025-03-03 06:31:38',
                'updated_at' => '2025-03-03 06:31:38',
            ),
            344 => 
            array (
                'id' => 1854,
                'nombre' => 'Curso de Excel',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-03-03 06:32:22',
                'updated_at' => '2025-03-03 06:32:22',
            ),
            345 => 
            array (
                'id' => 1855,
                'nombre' => 'SolidWorks',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-03-03 06:32:37',
                'updated_at' => '2025-03-03 06:32:37',
            ),
            346 => 
            array (
                'id' => 1856,
                'nombre' => 'Power BI',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-03-03 06:32:53',
                'updated_at' => '2025-03-03 06:32:53',
            ),
            347 => 
            array (
                'id' => 1857,
            'nombre' => 'GD&T (Teórico)',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-03-03 06:33:20',
                'updated_at' => '2025-03-03 06:33:20',
            ),
            348 => 
            array (
                'id' => 1858,
                'nombre' => 'Lectura de Planos Isométricos de Tuberías Industriales',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 309,
                'created_at' => '2025-03-03 06:34:00',
                'updated_at' => '2025-03-03 06:34:00',
            ),
            349 => 
            array (
                'id' => 1859,
                'nombre' => ' Sistema De Permisos Para Trabajos Con Riego Julio 2020 Versión Segunda GO-SS-TC-10-20',
                'tipo' => 'externo',
                'year' => '2020',
                'user_id' => 304,
                'created_at' => '2025-03-27 09:45:10',
                'updated_at' => '2025-03-27 09:46:34',
            ),
            350 => 
            array (
                'id' => 1860,
                'nombre' => 'RigPass: Onshore & Offshore - Certificate ID:	SXX000068956',
                'tipo' => 'externo',
                'year' => '2019',
                'user_id' => 304,
                'created_at' => '2025-03-27 09:51:35',
                'updated_at' => '2025-03-27 09:51:35',
            ),
            351 => 
            array (
                'id' => 1861,
                'nombre' => 'Sistema Anticorrosivo ViscoElástico Viscowrap',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 14,
                'created_at' => '2025-04-02 00:52:56',
                'updated_at' => '2025-04-02 00:52:56',
            ),
            352 => 
            array (
                'id' => 1862,
                'nombre' => 'Sistema Anticorrosivo ViscoElástico ViscowraP',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 317,
                'created_at' => '2025-04-02 02:09:47',
                'updated_at' => '2025-04-02 02:09:47',
            ),
            353 => 
            array (
                'id' => 1863,
                'nombre' => 'Sistema Anticorrosivo ViscoElástico Viscowrap',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 318,
                'created_at' => '2025-04-02 02:10:12',
                'updated_at' => '2025-04-02 02:10:12',
            ),
            354 => 
            array (
                'id' => 1864,
                'nombre' => 'Sistema Anticorrosivo ViscoElástico Viscowrap',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 99,
                'created_at' => '2025-04-02 02:14:47',
                'updated_at' => '2025-04-02 02:14:47',
            ),
            355 => 
            array (
                'id' => 1865,
                'nombre' => 'Seminario Manejo Seguro de Cargas',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 50,
                'created_at' => '2025-04-02 03:32:41',
                'updated_at' => '2025-04-02 03:32:41',
            ),
            356 => 
            array (
                'id' => 1867,
                'nombre' => 'Cálculo de huella de carbono',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 293,
                'created_at' => '2025-06-05 06:41:52',
                'updated_at' => '2025-06-05 06:41:52',
            ),
            357 => 
            array (
                'id' => 1868,
                'nombre' => 'Trabajos en Alturas ',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 14,
                'created_at' => '2025-06-17 05:38:59',
                'updated_at' => '2025-06-17 05:38:59',
            ),
            358 => 
            array (
                'id' => 1869,
                'nombre' => 'Seguridad en Andamios',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 14,
                'created_at' => '2025-06-17 05:39:20',
                'updated_at' => '2025-06-17 05:39:20',
            ),
            359 => 
            array (
                'id' => 1870,
                'nombre' => 'Montaje y desmontaje de andamios',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 26,
                'created_at' => '2025-06-17 05:41:10',
                'updated_at' => '2025-06-17 05:41:10',
            ),
            360 => 
            array (
                'id' => 1871,
                'nombre' => 'Trabajos en Altura',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 26,
                'created_at' => '2025-06-17 05:41:45',
                'updated_at' => '2025-06-17 05:41:45',
            ),
            361 => 
            array (
                'id' => 1872,
                'nombre' => 'Montaje y desmontaje de andamios',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 89,
                'created_at' => '2025-06-17 05:44:10',
                'updated_at' => '2025-06-17 05:44:10',
            ),
            362 => 
            array (
                'id' => 1873,
                'nombre' => 'Trabajos en Alturas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 89,
                'created_at' => '2025-06-17 05:44:35',
                'updated_at' => '2025-06-17 05:44:35',
            ),
            363 => 
            array (
                'id' => 1874,
                'nombre' => 'Montaje y desmontaje de andamios',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 99,
                'created_at' => '2025-06-17 05:46:58',
                'updated_at' => '2025-06-17 05:46:58',
            ),
            364 => 
            array (
                'id' => 1875,
                'nombre' => 'Trabajos en Alturas',
                'tipo' => 'interno',
                'year' => '2021',
                'user_id' => 99,
                'created_at' => '2025-06-17 05:47:42',
                'updated_at' => '2025-06-17 05:47:42',
            ),
            365 => 
            array (
                'id' => 1876,
                'nombre' => 'Montaje y desmontaje de andamios',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 252,
                'created_at' => '2025-06-17 05:49:02',
                'updated_at' => '2025-06-17 05:49:02',
            ),
            366 => 
            array (
                'id' => 1877,
                'nombre' => 'Manejo manua de cargas- Criterios básicos de seguridad para izaje de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 252,
                'created_at' => '2025-06-17 05:50:20',
                'updated_at' => '2025-06-17 05:50:20',
            ),
            367 => 
            array (
                'id' => 1878,
                'nombre' => 'Manejo manual de cargas- Criterios basicos de seguridad para izaje de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 89,
                'created_at' => '2025-06-17 05:51:50',
                'updated_at' => '2025-06-17 05:51:50',
            ),
            368 => 
            array (
                'id' => 1879,
                'nombre' => 'Montaje y desmontaje de andamios',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 157,
                'created_at' => '2025-06-17 05:55:09',
                'updated_at' => '2025-06-17 05:55:09',
            ),
            369 => 
            array (
                'id' => 1880,
                'nombre' => 'Manejo seguro de cargas-Criterios basicos de seguridad para izaje de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 157,
                'created_at' => '2025-06-17 05:55:43',
                'updated_at' => '2025-06-17 05:55:43',
            ),
            370 => 
            array (
                'id' => 1881,
                'nombre' => 'Uso y cuidado de EPP',
                'tipo' => 'interno',
                'year' => '2024',
                'user_id' => 269,
                'created_at' => '2025-07-16 02:39:49',
                'updated_at' => '2025-07-16 02:39:49',
            ),
            371 => 
            array (
                'id' => 1882,
                'nombre' => 'Uso y manejo de herramientas manuales',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 269,
                'created_at' => '2025-07-16 02:40:25',
                'updated_at' => '2025-07-16 02:40:25',
            ),
            372 => 
            array (
                'id' => 1883,
                'nombre' => 'Uso y manejo de herramientas de poder',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 269,
                'created_at' => '2025-07-16 02:40:49',
                'updated_at' => '2025-07-16 02:40:49',
            ),
            373 => 
            array (
                'id' => 1884,
                'nombre' => 'NOM-031-STPS-2011 Condiciones de seguridad y salud en la construcción',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 269,
                'created_at' => '2025-07-16 02:41:48',
                'updated_at' => '2025-07-16 02:41:48',
            ),
            374 => 
            array (
                'id' => 1885,
                'nombre' => 'Hot Tapping in Pipeline and Piping Industries.',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 36,
                'created_at' => '2025-07-17 04:37:26',
                'updated_at' => '2025-07-17 04:37:26',
            ),
            375 => 
            array (
                'id' => 1886,
                'nombre' => 'Manejo Manual de Cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 157,
                'created_at' => '2025-08-29 02:19:34',
                'updated_at' => '2025-08-29 02:19:34',
            ),
            376 => 
            array (
                'id' => 1887,
                'nombre' => 'Manejo Manual de Cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 92,
                'created_at' => '2025-08-29 02:23:06',
                'updated_at' => '2025-08-29 02:23:06',
            ),
            377 => 
            array (
                'id' => 1888,
                'nombre' => 'Manejo manual de Cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 89,
                'created_at' => '2025-08-29 02:28:12',
                'updated_at' => '2025-08-29 02:28:12',
            ),
            378 => 
            array (
                'id' => 1889,
                'nombre' => 'Manejo manual de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 318,
                'created_at' => '2025-08-29 02:46:01',
                'updated_at' => '2025-08-29 02:46:01',
            ),
            379 => 
            array (
                'id' => 1890,
                'nombre' => 'Manejo manual de cargas',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 299,
                'created_at' => '2025-08-29 03:02:53',
                'updated_at' => '2025-08-29 03:02:53',
            ),
            380 => 
            array (
                'id' => 1891,
                'nombre' => 'Asertividad y manejo de conflictos',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 53,
                'created_at' => '2025-08-29 04:11:14',
                'updated_at' => '2025-08-29 04:11:14',
            ),
            381 => 
            array (
                'id' => 1892,
                'nombre' => 'Tácticas para fortalecer el trabajo en equipo',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 53,
                'created_at' => '2025-08-29 04:11:44',
                'updated_at' => '2025-08-29 04:11:44',
            ),
            382 => 
            array (
                'id' => 1893,
                'nombre' => 'Asertividad y manejo de conflictos',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 260,
                'created_at' => '2025-08-29 04:14:16',
                'updated_at' => '2025-08-29 04:14:16',
            ),
            383 => 
            array (
                'id' => 1894,
                'nombre' => 'Tácticas para fortalecer el trabajo en equipo',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 260,
                'created_at' => '2025-08-29 04:14:52',
                'updated_at' => '2025-08-29 04:14:52',
            ),
            384 => 
            array (
                'id' => 1895,
                'nombre' => 'Tácticas para fortalecer el trabajo en equipo',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 187,
                'created_at' => '2025-08-29 04:16:58',
                'updated_at' => '2025-08-29 04:16:58',
            ),
            385 => 
            array (
                'id' => 1896,
                'nombre' => 'Tácticas para fortalecer el trabajo en equipo',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 191,
                'created_at' => '2025-08-29 04:17:44',
                'updated_at' => '2025-08-29 04:17:44',
            ),
            386 => 
            array (
                'id' => 1897,
                'nombre' => 'Asertividad y manejo de conflictos',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 191,
                'created_at' => '2025-08-29 04:17:57',
                'updated_at' => '2025-08-29 04:17:57',
            ),
            387 => 
            array (
                'id' => 1898,
                'nombre' => 'Tácticas para fortalecer el trabajo en equipo',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 287,
                'created_at' => '2025-08-29 04:19:00',
                'updated_at' => '2025-08-29 04:19:00',
            ),
            388 => 
            array (
                'id' => 1899,
                'nombre' => 'Trabajos en alturas',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 276,
                'created_at' => '2025-08-29 04:29:03',
                'updated_at' => '2025-08-29 04:29:03',
            ),
            389 => 
            array (
                'id' => 1900,
                'nombre' => 'Extracción, procesamiento, transporte, distribución y estudio del mercado del gas natural',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 191,
                'created_at' => '2025-08-29 04:29:43',
                'updated_at' => '2025-08-29 04:29:43',
            ),
            390 => 
            array (
                'id' => 1901,
                'nombre' => 'Manejo de sustancias químicas ',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 276,
                'created_at' => '2025-08-29 04:29:44',
                'updated_at' => '2025-08-29 04:29:44',
            ),
            391 => 
            array (
                'id' => 1902,
                'nombre' => 'Líquidos penetrantes nivel 1 Y 2',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 191,
                'created_at' => '2025-08-29 04:30:03',
                'updated_at' => '2025-08-29 04:30:03',
            ),
            392 => 
            array (
                'id' => 1903,
                'nombre' => 'Trabajos en caliente',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 276,
                'created_at' => '2025-08-29 04:30:09',
                'updated_at' => '2025-08-29 04:30:09',
            ),
            393 => 
            array (
                'id' => 1904,
                'nombre' => 'Espacios confinados',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 276,
                'created_at' => '2025-08-29 04:30:32',
                'updated_at' => '2025-08-29 04:30:32',
            ),
            394 => 
            array (
                'id' => 1905,
                'nombre' => 'Partículas Magnéticas nivel 1 y 2',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 191,
                'created_at' => '2025-08-29 04:30:32',
                'updated_at' => '2025-08-29 04:30:32',
            ),
            395 => 
            array (
                'id' => 1906,
                'nombre' => 'Equipo de protección personal y análisis de riesgo',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 276,
                'created_at' => '2025-08-29 04:30:58',
                'updated_at' => '2025-08-29 04:31:19',
            ),
            396 => 
            array (
                'id' => 1907,
                'nombre' => 'Equipos básicos de un equipo de perforación rotatorios terrestres',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 191,
                'created_at' => '2025-08-29 04:31:24',
                'updated_at' => '2025-08-29 04:31:24',
            ),
            397 => 
            array (
                'id' => 1908,
                'nombre' => 'SolidWorks preparación CSWA',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 276,
                'created_at' => '2025-08-29 04:32:48',
                'updated_at' => '2025-08-29 04:32:48',
            ),
            398 => 
            array (
                'id' => 1909,
                'nombre' => 'Supervisor de seguridad e higiene en centros de trabajo',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 276,
                'created_at' => '2025-08-29 04:34:08',
                'updated_at' => '2025-08-29 04:34:08',
            ),
            399 => 
            array (
                'id' => 1910,
                'nombre' => 'Proceso de soldadura sanitaria TIG 1',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 276,
                'created_at' => '2025-08-29 04:34:58',
                'updated_at' => '2025-08-29 04:34:58',
            ),
            400 => 
            array (
                'id' => 1911,
                'nombre' => 'Técnico procesos industriales. ',
                'tipo' => 'externo',
                'year' => '2018',
                'user_id' => 276,
                'created_at' => '2025-08-29 04:36:28',
                'updated_at' => '2025-08-29 04:36:28',
            ),
            401 => 
            array (
                'id' => 1912,
                'nombre' => 'Certified solidworks associate',
                'tipo' => 'externo',
                'year' => '2020',
                'user_id' => 287,
                'created_at' => '2025-08-29 06:01:48',
                'updated_at' => '2025-08-29 06:01:48',
            ),
            402 => 
            array (
                'id' => 1913,
                'nombre' => 'Fundamentos de diseño mecánico en CATIA V5 3D EXPERIENCE',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 332,
                'created_at' => '2025-08-29 06:28:49',
                'updated_at' => '2025-08-29 06:28:49',
            ),
            403 => 
            array (
                'id' => 1914,
                'nombre' => 'Gestión de Proyectos y Fundamentos de Metodología Agile',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 332,
                'created_at' => '2025-08-29 06:29:31',
                'updated_at' => '2025-08-29 06:29:31',
            ),
            404 => 
            array (
                'id' => 1915,
                'nombre' => 'Liderazgo',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 332,
                'created_at' => '2025-08-29 06:29:45',
                'updated_at' => '2025-08-29 06:29:45',
            ),
            405 => 
            array (
                'id' => 1916,
                'nombre' => 'Técnicas de medición y usos de instrumentos de medición ',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 332,
                'created_at' => '2025-08-29 06:30:24',
                'updated_at' => '2025-08-29 06:30:24',
            ),
            406 => 
            array (
                'id' => 1917,
                'nombre' => 'Control Estadístico del proceso ',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 332,
                'created_at' => '2025-08-29 06:30:48',
                'updated_at' => '2025-08-29 06:30:48',
            ),
            407 => 
            array (
                'id' => 1918,
                'nombre' => 'Introducción a la Norma IATF 16949:2016',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 332,
                'created_at' => '2025-08-29 06:31:40',
                'updated_at' => '2025-08-29 06:31:40',
            ),
            408 => 
            array (
                'id' => 1919,
                'nombre' => 'Uso y manejo de herramientas de poder',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 26,
                'created_at' => '2025-09-02 07:17:26',
                'updated_at' => '2025-09-02 07:17:26',
            ),
            409 => 
            array (
                'id' => 1920,
                'nombre' => 'Uso y manejo de herramientas manuales',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 26,
                'created_at' => '2025-09-02 07:17:56',
                'updated_at' => '2025-09-02 07:17:56',
            ),
            410 => 
            array (
                'id' => 1921,
                'nombre' => 'Montaje y desmontaje de andamios',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 22,
                'created_at' => '2025-09-02 07:50:39',
                'updated_at' => '2025-09-02 07:50:39',
            ),
            411 => 
            array (
                'id' => 1922,
                'nombre' => 'Diplomado en comentencias tecnologicas en la industria de hidrocarburos',
                'tipo' => 'externo',
                'year' => '2019',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:38:43',
                'updated_at' => '2025-09-09 08:38:43',
            ),
            412 => 
            array (
                'id' => 1923,
                'nombre' => 'Curso integral Opus',
                'tipo' => 'externo',
                'year' => '2016',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:39:34',
                'updated_at' => '2025-09-09 08:39:34',
            ),
            413 => 
            array (
                'id' => 1924,
                'nombre' => 'Elaboracion de planos Autocad',
                'tipo' => 'externo',
                'year' => '2017',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:40:04',
                'updated_at' => '2025-09-09 08:40:04',
            ),
            414 => 
            array (
                'id' => 1925,
                'nombre' => 'Supervisor development workshop',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:40:51',
                'updated_at' => '2025-09-09 08:40:51',
            ),
            415 => 
            array (
                'id' => 1926,
                'nombre' => 'Gestion de mantenimiento predictivo',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:41:21',
                'updated_at' => '2025-09-09 08:41:21',
            ),
            416 => 
            array (
                'id' => 1927,
                'nombre' => 'Curso tecnologias predictivas en mantenimiento',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:41:59',
                'updated_at' => '2025-09-09 08:41:59',
            ),
            417 => 
            array (
                'id' => 1928,
                'nombre' => 'Curso intensivo de mantenimiento predictivo',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:42:40',
                'updated_at' => '2025-09-09 08:42:40',
            ),
            418 => 
            array (
                'id' => 1929,
                'nombre' => 'Confiabilidad en foco',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:43:08',
                'updated_at' => '2025-09-09 08:43:08',
            ),
            419 => 
            array (
                'id' => 1930,
                'nombre' => 'Toelfl ITP ',
                'tipo' => 'externo',
                'year' => '2017',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:43:44',
                'updated_at' => '2025-09-09 08:43:44',
            ),
            420 => 
            array (
                'id' => 1931,
                'nombre' => 'ANEXO SSPA',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:44:16',
                'updated_at' => '2025-09-09 08:44:16',
            ),
            421 => 
            array (
                'id' => 1932,
                'nombre' => 'SEGURIDAD, SALUD EN EL TRABAJO Y PROTECCIÓN AMBIENTAL',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:44:35',
                'updated_at' => '2025-09-09 08:44:35',
            ),
            422 => 
            array (
                'id' => 1933,
                'nombre' => 'REGLAMENTO FEDERAL DE SEGURIDAD HIGIENE Y MEDIO AMBIENTE DE TRABAJO',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:44:52',
                'updated_at' => '2025-09-09 08:44:52',
            ),
            423 => 
            array (
                'id' => 1934,
                'nombre' => 'REGLAMENTO DE SEGURIDAD E HIGIENE DE PETROLEOS MEXICANOS Y EMPRESAS PRODUCTIVAS SUBSIDIARIAS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:45:15',
                'updated_at' => '2025-09-09 08:45:15',
            ),
            424 => 
            array (
                'id' => 1935,
                'nombre' => 'CONCEPTOS BASICOS SOBRE PROTECCION AMBIENTAL',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:45:41',
                'updated_at' => '2025-09-09 08:45:41',
            ),
            425 => 
            array (
                'id' => 1936,
                'nombre' => 'MANEJO DE EXTINTORES',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:46:20',
                'updated_at' => '2025-09-09 08:46:20',
            ),
            426 => 
            array (
                'id' => 1937,
                'nombre' => 'SOBREVIVENCIA EN EL MAR',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:46:41',
                'updated_at' => '2025-09-09 08:46:41',
            ),
            427 => 
            array (
                'id' => 1938,
                'nombre' => 'HOJAS DE DATOS DE SEGURIDAD DE LAS SUSTANCIAS INVOLUCRADAS EN LOS TRABAJOS DEL CONTRATO',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:47:03',
                'updated_at' => '2025-09-09 08:47:03',
            ),
            428 => 
            array (
                'id' => 1939,
                'nombre' => 'LEY GENERAL PARA LA PREVENCIÓN Y GESTIÓN INTEGRAL DE LOS RESIDUOS Y SU REGLAMENTO',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:47:24',
                'updated_at' => '2025-09-09 08:47:24',
            ),
            429 => 
            array (
                'id' => 1940,
                'nombre' => 'RIESGOS ATMOSFERICOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:47:39',
                'updated_at' => '2025-09-09 08:47:39',
            ),
            430 => 
            array (
                'id' => 1941,
                'nombre' => 'RIESGOS EN ESPACIOS CONFINADOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:47:56',
                'updated_at' => '2025-09-09 08:47:56',
            ),
            431 => 
            array (
                'id' => 1942,
                'nombre' => 'IDENTIFICACION DE AREAS DE RIESGO EN EL TRABAJO',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:48:12',
                'updated_at' => '2025-09-09 08:48:12',
            ),
            432 => 
            array (
                'id' => 1943,
                'nombre' => 'PROCEDIMIENTOS CRITICOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:48:27',
                'updated_at' => '2025-09-09 08:48:27',
            ),
            433 => 
            array (
                'id' => 1944,
                'nombre' => 'AUDITORIAS EFECTIVAS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:48:44',
                'updated_at' => '2025-09-09 08:48:44',
            ),
            434 => 
            array (
                'id' => 1945,
                'nombre' => 'METODOLOGIA ANALISIS CAUSA RAIZ',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:49:04',
                'updated_at' => '2025-09-09 08:49:04',
            ),
            435 => 
            array (
                'id' => 1946,
                'nombre' => 'BASICO DE SEGURIDAD',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:49:20',
                'updated_at' => '2025-09-09 08:49:20',
            ),
            436 => 
            array (
                'id' => 1947,
            'nombre' => 'GENERALIDADES DE LOS PRIMEROS AUXILIOS, HEMORRAGIAS, REANIMACION CARDIOPULMONAR (RCP)',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:49:39',
                'updated_at' => '2025-09-09 08:49:39',
            ),
            437 => 
            array (
                'id' => 1948,
                'nombre' => 'EQUIPO DE RESPIRACION AUTONOMO',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:49:57',
                'updated_at' => '2025-09-09 08:49:57',
            ),
            438 => 
            array (
                'id' => 1949,
                'nombre' => 'USO DE EQUIPO DE DETECCION DE GASES: EXPLOSIMETRO, OXIGENO Y TOXICIDAD',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:50:14',
                'updated_at' => '2025-09-09 08:50:14',
            ),
            439 => 
            array (
                'id' => 1950,
            'nombre' => 'CLASIFICACION Y MANEJO DE RESIDUOS PELIGROSOS (NOM ´S)',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:50:29',
                'updated_at' => '2025-09-09 08:50:29',
            ),
            440 => 
            array (
                'id' => 1951,
                'nombre' => 'DISPOSITIVOS DE DETECCION Y PRIMEROS AUXILIOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:50:51',
                'updated_at' => '2025-09-09 08:50:51',
            ),
            441 => 
            array (
                'id' => 1952,
                'nombre' => 'LEY GENERAL DE EQUILIBRIO ECOLÓGICO Y LA PROTECCIÓN AL AMBIENTE Y SUS REGLAMENTOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:51:08',
                'updated_at' => '2025-09-09 08:51:08',
            ),
            442 => 
            array (
                'id' => 1953,
                'nombre' => 'TEORIA DE LA COMBUSTION',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:51:25',
                'updated_at' => '2025-09-09 08:51:25',
            ),
            443 => 
            array (
                'id' => 1954,
                'nombre' => 'CLASIFICACION Y USO DE EQUIPOS DE PROTECCION RESPIRATORIA',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:51:40',
                'updated_at' => '2025-09-09 08:51:40',
            ),
            444 => 
            array (
                'id' => 1955,
            'nombre' => 'ANALISIS DE SEGURIDAD EN EL TRABAJO (AST)',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:51:59',
                'updated_at' => '2025-09-09 08:51:59',
            ),
            445 => 
            array (
                'id' => 1956,
                'nombre' => 'CONCEPTOS BASICOS Y DEFINICIONES SOBRE PLANES DE RESPUESTA A EMERGENCIAS, QUE HACER DURANTE UNA EMERGENCIA',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:52:20',
                'updated_at' => '2025-09-09 08:52:20',
            ),
            446 => 
            array (
                'id' => 1957,
            'nombre' => 'MANEJO A LA DEFENSIVA (VEHICULOS)',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:52:40',
                'updated_at' => '2025-09-09 08:52:40',
            ),
            447 => 
            array (
                'id' => 1958,
                'nombre' => 'Programa de acreditación de control de pozos de la IADC WELLSHARP',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:54:05',
                'updated_at' => '2025-09-09 08:54:05',
            ),
            448 => 
            array (
                'id' => 1959,
                'nombre' => 'IADC programa de acreditación Rig Pass',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:54:47',
                'updated_at' => '2025-09-09 08:54:47',
            ),
            449 => 
            array (
                'id' => 1960,
                'nombre' => 'Curso basico de seguridad en plataformas y barcazas',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:55:27',
                'updated_at' => '2025-09-09 08:55:27',
            ),
            450 => 
            array (
                'id' => 1961,
                'nombre' => 'Libreta de mar tipo D',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:55:56',
                'updated_at' => '2025-09-09 08:55:56',
            ),
            451 => 
            array (
                'id' => 1962,
                'nombre' => 'Auditorias efectivas',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:56:25',
                'updated_at' => '2025-09-09 08:56:25',
            ),
            452 => 
            array (
                'id' => 1963,
                'nombre' => 'BÁSICO DE SEGURIDAD',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:57:29',
                'updated_at' => '2025-09-09 08:57:29',
            ),
            453 => 
            array (
                'id' => 1964,
                'nombre' => 'Basico de seguridad CMI',
                'tipo' => 'externo',
                'year' => '2018',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:57:57',
                'updated_at' => '2025-09-09 08:57:57',
            ),
            454 => 
            array (
                'id' => 1965,
                'nombre' => 'Curso contraincendios basico',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:58:26',
                'updated_at' => '2025-09-09 08:58:26',
            ),
            455 => 
            array (
                'id' => 1966,
                'nombre' => 'Analisis de seguridad en el trabajo AST',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:59:03',
                'updated_at' => '2025-09-09 08:59:03',
            ),
            456 => 
            array (
                'id' => 1967,
                'nombre' => 'Analisis causa raiz',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 324,
                'created_at' => '2025-09-09 08:59:37',
                'updated_at' => '2025-09-09 08:59:37',
            ),
            457 => 
            array (
                'id' => 1968,
                'nombre' => 'Auditorias efectivas ',
                'tipo' => 'externo',
                'year' => '2021',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:00:09',
                'updated_at' => '2025-09-09 09:00:09',
            ),
            458 => 
            array (
                'id' => 1969,
                'nombre' => 'NOM-005-STPS-1998',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:00:42',
                'updated_at' => '2025-09-09 09:00:42',
            ),
            459 => 
            array (
                'id' => 1970,
                'nombre' => 'Manejo integral de los residuos peligrosos, solidos urbanos, especiales y su impacto al medio ambiente',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:01:25',
                'updated_at' => '2025-09-09 09:01:25',
            ),
            460 => 
            array (
                'id' => 1971,
                'nombre' => 'NOM-006-STPS-2014',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:01:48',
                'updated_at' => '2025-09-09 09:01:48',
            ),
            461 => 
            array (
                'id' => 1972,
                'nombre' => 'NOM-017-STPS-2008',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:02:12',
                'updated_at' => '2025-09-09 09:02:12',
            ),
            462 => 
            array (
                'id' => 1973,
                'nombre' => 'Talller de formacion de supervisores',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:02:49',
                'updated_at' => '2025-09-09 09:02:49',
            ),
            463 => 
            array (
                'id' => 1974,
                'nombre' => 'Fundamentos de las finanzas: Control y reducción de costes',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:03:05',
                'updated_at' => '2025-09-09 09:03:05',
            ),
            464 => 
            array (
                'id' => 1975,
                'nombre' => 'Prompt Engineering: Aprende a hablar con una inteligencia artificial generativa',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:03:20',
                'updated_at' => '2025-09-09 09:03:20',
            ),
            465 => 
            array (
                'id' => 1976,
                'nombre' => 'Trucos de productividad con IA para reimaginar tu jornada laboral y tu carrera profesional',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:03:34',
                'updated_at' => '2025-09-09 09:03:34',
            ),
            466 => 
            array (
                'id' => 1977,
                'nombre' => 'Cómo administrar por objetivos',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:03:48',
                'updated_at' => '2025-09-09 09:03:48',
            ),
            467 => 
            array (
                'id' => 1978,
                'nombre' => 'Cómo atraer y retener talento en tiempos de crisis: Navegar la gran reorganización y la gran dimisión',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:04:03',
                'updated_at' => '2025-09-09 09:04:03',
            ),
            468 => 
            array (
                'id' => 1979,
                'nombre' => 'Fundamentos de la gestión de proyectos',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:04:17',
                'updated_at' => '2025-09-09 09:04:17',
            ),
            469 => 
            array (
                'id' => 1980,
                'nombre' => 'Involúcrate en lo que sucede a tu alrededor: De espectador a protagonista',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:04:28',
                'updated_at' => '2025-09-09 09:04:28',
            ),
            470 => 
            array (
                'id' => 1981,
                'nombre' => 'Liderazgo ágil: Cómo afrontar la nueva normalidad',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:04:45',
                'updated_at' => '2025-09-09 09:04:45',
            ),
            471 => 
            array (
                'id' => 1982,
                'nombre' => 'Liderazgo en tiempos de crisis',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:04:59',
                'updated_at' => '2025-09-09 09:04:59',
            ),
            472 => 
            array (
                'id' => 1983,
                'nombre' => 'Liderazgo y recursos humanos: Estrategia de ubicación para una fuerza de trabajo híbrida',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:05:31',
                'updated_at' => '2025-09-09 09:05:31',
            ),
            473 => 
            array (
                'id' => 1984,
                'nombre' => '¿Qué es el análisis de negocio o análisis empresarial?',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:05:45',
                'updated_at' => '2025-09-09 09:05:45',
            ),
            474 => 
            array (
                'id' => 1985,
                'nombre' => 'Aumenta el impacto de tu coaching con la IA generativa',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:06:00',
                'updated_at' => '2025-09-09 09:06:00',
            ),
            475 => 
            array (
                'id' => 1986,
                'nombre' => 'Empodera a tu equipo con la inteligencia artificial',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:06:14',
                'updated_at' => '2025-09-09 09:06:14',
            ),
            476 => 
            array (
                'id' => 1987,
                'nombre' => 'Fundamentos de la gestión de proyectos: Comunicación',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:06:31',
                'updated_at' => '2025-09-09 09:06:31',
            ),
            477 => 
            array (
                'id' => 1988,
                'nombre' => 'Gestiona y resuelve los conflictos de roles en tu equipo',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:06:45',
                'updated_at' => '2025-09-09 09:06:45',
            ),
            478 => 
            array (
                'id' => 1989,
                'nombre' => 'Guía del directivo para las conversaciones de carrera en la era de la IA',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:06:54',
                'updated_at' => '2025-09-09 09:06:54',
            ),
            479 => 
            array (
                'id' => 1990,
                'nombre' => 'IA responsable para directivos',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:07:06',
                'updated_at' => '2025-09-09 09:07:06',
            ),
            480 => 
            array (
                'id' => 1991,
                'nombre' => 'Inglés de negocios: Acuerdos y desacuerdos',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:07:19',
                'updated_at' => '2025-09-09 09:07:19',
            ),
            481 => 
            array (
                'id' => 1992,
                'nombre' => 'Fundamentos de la gestión de proyectos: Riesgos',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:07:31',
                'updated_at' => '2025-09-09 09:07:31',
            ),
            482 => 
            array (
                'id' => 1993,
                'nombre' => 'Fundamentos de la gestión de proyectos: Stakeholders',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:07:53',
                'updated_at' => '2025-09-09 09:07:53',
            ),
            483 => 
            array (
                'id' => 1994,
                'nombre' => 'Accede a la dirección con el impulso de la Inteligencia Artificial',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:08:08',
                'updated_at' => '2025-09-09 09:08:08',
            ),
            484 => 
            array (
                'id' => 1995,
                'nombre' => 'Amplifica tu pensamiento crítico con la IA generativa',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:08:19',
                'updated_at' => '2025-09-09 09:08:19',
            ),
            485 => 
            array (
                'id' => 1996,
                'nombre' => 'Cómo dirigir a dirigentes con experiencia',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:08:31',
                'updated_at' => '2025-09-09 09:08:31',
            ),
            486 => 
            array (
                'id' => 1997,
                'nombre' => 'Cómo hablar para que te escuchen',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:08:45',
                'updated_at' => '2025-09-09 09:08:45',
            ),
            487 => 
            array (
                'id' => 1998,
                'nombre' => 'Cómo liderar reuniones individuales productivas',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:08:58',
                'updated_at' => '2025-09-09 09:08:58',
            ),
            488 => 
            array (
                'id' => 1999,
                'nombre' => 'Cómo medir el rendimiento en la empresa',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:09:19',
                'updated_at' => '2025-09-09 09:09:19',
            ),
            489 => 
            array (
                'id' => 2000,
                'nombre' => 'Dar y recibir feedback o retroalimentación',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:09:33',
                'updated_at' => '2025-09-09 09:09:33',
            ),
            490 => 
            array (
                'id' => 2001,
                'nombre' => 'Fundamentos de la gestión de proyectos: Equipos',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:09:45',
                'updated_at' => '2025-09-09 09:09:45',
            ),
            491 => 
            array (
                'id' => 2002,
                'nombre' => 'Fundamentos de la gestión de proyectos: Ética',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:09:56',
                'updated_at' => '2025-09-09 09:09:56',
            ),
            492 => 
            array (
                'id' => 2003,
                'nombre' => 'Fundamentos de la gestión de proyectos: Calendarios',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:10:10',
                'updated_at' => '2025-09-09 09:10:10',
            ),
            493 => 
            array (
                'id' => 2004,
                'nombre' => 'Fundamentos de la gestión de proyectos: Presupuestos',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:10:22',
                'updated_at' => '2025-09-09 09:10:22',
            ),
            494 => 
            array (
                'id' => 2005,
                'nombre' => 'Habilidades de coaching para líderes y gerentes',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:10:34',
                'updated_at' => '2025-09-09 09:10:34',
            ),
            495 => 
            array (
                'id' => 2006,
                'nombre' => 'Habilidades de comunicación para la gerencia moderna',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:10:51',
                'updated_at' => '2025-09-09 09:10:51',
            ),
            496 => 
            array (
                'id' => 2007,
                'nombre' => 'Liderazgo transformador',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:11:03',
                'updated_at' => '2025-09-09 09:11:03',
            ),
            497 => 
            array (
                'id' => 2008,
                'nombre' => 'Sé el manager que nadie quiere dejar',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 324,
                'created_at' => '2025-09-09 09:11:14',
                'updated_at' => '2025-09-09 09:11:14',
            ),
            498 => 
            array (
                'id' => 2009,
                'nombre' => 'Liderazgo',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 328,
                'created_at' => '2025-09-11 01:30:56',
                'updated_at' => '2025-09-11 01:30:56',
            ),
            499 => 
            array (
                'id' => 2010,
                'nombre' => 'Combate Contra Incendios, Búsqueda y Rescate',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 328,
                'created_at' => '2025-09-11 01:32:03',
                'updated_at' => '2025-09-11 01:32:03',
            ),
        ));
        \DB::table('cv_curso_certificacions')->insert(array (
            0 => 
            array (
                'id' => 2011,
                'nombre' => 'Válvulas en General y Válvulas API 6D',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 328,
                'created_at' => '2025-09-11 01:32:49',
                'updated_at' => '2025-09-11 01:32:49',
            ),
            1 => 
            array (
                'id' => 2014,
                'nombre' => 'Buenas Prácticas en Intervención de Ductos',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 328,
                'created_at' => '2025-09-11 01:34:58',
                'updated_at' => '2025-09-11 01:34:58',
            ),
            2 => 
            array (
                'id' => 2015,
                'nombre' => 'PREVENCION Y COMBATE DE INCENDIO',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 605,
                'created_at' => '2025-09-24 07:59:24',
                'updated_at' => '2025-09-24 07:59:24',
            ),
            3 => 
            array (
                'id' => 2016,
                'nombre' => 'ANÁLISIS DE RIESGO EN LOS PROCESOS',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 605,
                'created_at' => '2025-09-24 07:59:43',
                'updated_at' => '2025-09-24 07:59:43',
            ),
            4 => 
            array (
                'id' => 2017,
                'nombre' => 'PLAN DE RESPUESTA A EMERGENCIA',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 605,
                'created_at' => '2025-09-24 07:59:58',
                'updated_at' => '2025-09-24 07:59:58',
            ),
            5 => 
            array (
                'id' => 2018,
                'nombre' => 'SEGURIDAD, SALUD EN EL TRABAJO Y PROTECCIÓN AMBIENTAL',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:00:21',
                'updated_at' => '2025-09-24 08:00:21',
            ),
            6 => 
            array (
                'id' => 2019,
            'nombre' => 'ANEXO SSPA (PRIMERA VERSIÓN)',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:00:43',
                'updated_at' => '2025-09-24 08:00:43',
            ),
            7 => 
            array (
                'id' => 2020,
                'nombre' => 'REGLAMENTO DE SEGURIDAD E HIGIENE DE PETROLEOS MEXICANOS Y ORGANISMOS SUBSIDIARIOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:01:12',
                'updated_at' => '2025-09-24 08:01:48',
            ),
            8 => 
            array (
                'id' => 2021,
                'nombre' => 'IDENTIFICACIÓN DE ÁREAS DE RIESGO EN EL TRABAJO',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:01:35',
                'updated_at' => '2025-09-24 08:01:35',
            ),
            9 => 
            array (
                'id' => 2022,
                'nombre' => 'AUDITORIAS EFECTIVAS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:02:03',
                'updated_at' => '2025-09-24 08:02:03',
            ),
            10 => 
            array (
                'id' => 2023,
                'nombre' => 'METODOLOGÍA ANÁLISIS CAUSA RAÍZ',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:02:32',
                'updated_at' => '2025-09-24 08:02:32',
            ),
            11 => 
            array (
                'id' => 2024,
                'nombre' => 'ANÁLISIS DE SEGURIDAD EN EL TRABAJO',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:02:47',
                'updated_at' => '2025-09-24 08:02:47',
            ),
            12 => 
            array (
                'id' => 2025,
                'nombre' => 'RIESGOS EN ESPACIOS COFINADOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:03:02',
                'updated_at' => '2025-09-24 08:03:02',
            ),
            13 => 
            array (
                'id' => 2026,
                'nombre' => 'CLASIFICACIÓN Y MANEJO DE RESIDUOS PELIGROSOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:03:17',
                'updated_at' => '2025-09-24 08:03:17',
            ),
            14 => 
            array (
                'id' => 2027,
                'nombre' => 'GENERALIDADES DE LOS PRIMEROS AUXILIOS, HEMORRAGIAS Y RCP',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:03:30',
                'updated_at' => '2025-09-24 08:03:30',
            ),
            15 => 
            array (
                'id' => 2028,
                'nombre' => '“CURSO DE PRIMEROS AUXILIOS Y RCP PARA ADULTOS”',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:03:43',
                'updated_at' => '2025-09-24 08:03:43',
            ),
            16 => 
            array (
                'id' => 2029,
                'nombre' => 'LEY GENERAL PARA LA PREVENCIÓN Y GESTIÓN INTEGRAL DE LOS RESIDUOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:03:55',
                'updated_at' => '2025-09-24 08:03:55',
            ),
            17 => 
            array (
                'id' => 2030,
                'nombre' => 'CURSO MANEJO DE H2S',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:04:04',
                'updated_at' => '2025-09-24 08:04:04',
            ),
            18 => 
            array (
                'id' => 2031,
                'nombre' => 'BÁSICO DE SEGURIDAD',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:04:09',
                'updated_at' => '2025-09-24 08:04:09',
            ),
            19 => 
            array (
                'id' => 2032,
                'nombre' => 'CURSO PALN DE RESPUESTA A EMERGENCIAS',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:04:24',
                'updated_at' => '2025-09-24 08:04:24',
            ),
            20 => 
            array (
                'id' => 2033,
                'nombre' => 'LEY GENERAL DE EQUILIBRIO ECOLÓGICO Y LA PROTECCIÓN AL AMBIENTE',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:04:37',
                'updated_at' => '2025-09-24 08:04:37',
            ),
            21 => 
            array (
                'id' => 2034,
                'nombre' => 'CURSO BASICA DE SEGURIDAD Y PROTECCION AMBIENTAL',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:04:45',
                'updated_at' => '2025-09-24 08:04:45',
            ),
            22 => 
            array (
                'id' => 2035,
                'nombre' => 'USO DE EQUIPOS DE DETECCIÓN DE GASES',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:04:51',
                'updated_at' => '2025-09-24 08:04:51',
            ),
            23 => 
            array (
                'id' => 2036,
                'nombre' => 'CURSO DE SIGNATARIO DE PERMISOS PARA TRABAJO CON RIESGO',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:05:06',
                'updated_at' => '2025-09-24 08:05:06',
            ),
            24 => 
            array (
                'id' => 2037,
                'nombre' => 'HOJAS DE DATOS DE SEGURIDAD DE LAS SUSTANCIAS INVOLUCRADAS EN LOS TRABAJOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:05:07',
                'updated_at' => '2025-09-24 08:05:07',
            ),
            25 => 
            array (
                'id' => 2038,
                'nombre' => 'PROCEDIMIENTOS CRITICOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:05:24',
                'updated_at' => '2025-09-24 08:05:24',
            ),
            26 => 
            array (
                'id' => 2039,
                'nombre' => 'CURSO IADC RIGPASS ID R93',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:05:27',
                'updated_at' => '2025-09-24 08:05:27',
            ),
            27 => 
            array (
                'id' => 2040,
                'nombre' => 'CONCEPTOS BASICOS Y DEFINICIONES SOBRE PLAN DE RESPUETA A EMERGENCIA',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:05:33',
                'updated_at' => '2025-09-24 08:05:33',
            ),
            28 => 
            array (
                'id' => 2041,
                'nombre' => 'MANEJO DE EXTINTORES',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:05:48',
                'updated_at' => '2025-09-24 08:05:48',
            ),
            29 => 
            array (
                'id' => 2042,
                'nombre' => 'CURSO DE VERIFICADOR DE GASES',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:05:49',
                'updated_at' => '2025-09-24 08:05:49',
            ),
            30 => 
            array (
                'id' => 2043,
                'nombre' => 'CONCEPTOS BASICOS SOBRE PROTECCIÓN AMBIENTAL',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:06:03',
                'updated_at' => '2025-09-24 08:06:03',
            ),
            31 => 
            array (
                'id' => 2044,
                'nombre' => 'CURSO DE PROSEDIMIENTOS CRITICOS',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:06:11',
                'updated_at' => '2025-09-24 08:06:11',
            ),
            32 => 
            array (
                'id' => 2045,
                'nombre' => 'CURSO DE RESIDUOS PELIGROSOS',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:06:32',
                'updated_at' => '2025-09-24 08:06:32',
            ),
            33 => 
            array (
                'id' => 2046,
                'nombre' => 'ATLAS NACIONAL DE RISGOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:06:43',
                'updated_at' => '2025-09-24 08:06:43',
            ),
            34 => 
            array (
                'id' => 2047,
                'nombre' => 'CURSO DE CONTRA INCENDIO',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:06:49',
                'updated_at' => '2025-09-24 08:06:49',
            ),
            35 => 
            array (
                'id' => 2048,
                'nombre' => 'CLASIFICACIÓN Y USO DE EQUIPOS DE PROTECCIÓN RESPIRATORIA',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:07:07',
                'updated_at' => '2025-09-24 08:07:07',
            ),
            36 => 
            array (
                'id' => 2049,
                'nombre' => 'CURSO DE INPORTANCIA DEL E.P.P',
                'tipo' => 'externo',
                'year' => '2014',
                'user_id' => 604,
                'created_at' => '2025-09-24 08:07:10',
                'updated_at' => '2025-09-24 08:07:10',
            ),
            37 => 
            array (
                'id' => 2050,
                'nombre' => 'DISPOSITIVOS DE DETECCIÓN Y PRIMEROS AUXILIOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:07:35',
                'updated_at' => '2025-09-24 08:07:35',
            ),
            38 => 
            array (
                'id' => 2051,
                'nombre' => 'EQUIPOS DE RESPIRACION AUTÓNOMOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:08:09',
                'updated_at' => '2025-09-24 08:08:09',
            ),
            39 => 
            array (
                'id' => 2052,
                'nombre' => 'REGLAMENTO FEDERAL DE SEGURIDA,HIGIENE Y MEDIO AMBIENTE',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:08:34',
                'updated_at' => '2025-09-24 08:08:34',
            ),
            40 => 
            array (
                'id' => 2053,
                'nombre' => 'RIESGOS ATMOSFÉIICOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:09:36',
                'updated_at' => '2025-09-24 08:09:36',
            ),
            41 => 
            array (
                'id' => 2054,
                'nombre' => 'TALLER ANEXO SSPA',
                'tipo' => 'externo',
                'year' => '2019',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:10:13',
                'updated_at' => '2025-09-24 08:10:13',
            ),
            42 => 
            array (
                'id' => 2055,
                'nombre' => 'BASICO DE SEGURIDAD EN PLATAFORMAS Y BARCAZAS',
                'tipo' => 'externo',
                'year' => '2017',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:10:28',
                'updated_at' => '2025-09-24 08:10:28',
            ),
            43 => 
            array (
                'id' => 2056,
                'nombre' => 'SISTEMA DE PERMISOS PARA TRABAJOS CON RIESGO',
                'tipo' => 'externo',
                'year' => '2017',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:10:45',
                'updated_at' => '2025-09-24 08:10:45',
            ),
            44 => 
            array (
                'id' => 2057,
                'nombre' => 'CLASIFICACIÓQN Y USO DE EQUIPO DE RESPIRACIÓN AUTÓNOMA',
                'tipo' => 'externo',
                'year' => '2016',
                'user_id' => 605,
                'created_at' => '2025-09-24 08:11:21',
                'updated_at' => '2025-09-24 08:11:21',
            ),
            45 => 
            array (
                'id' => 2058,
                'nombre' => 'SIGNATARIO',
                'tipo' => 'externo',
                'year' => '2022',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:24:01',
                'updated_at' => '2025-09-24 08:24:01',
            ),
            46 => 
            array (
                'id' => 2059,
                'nombre' => 'ANÁLISIS DE SEGURIDAD EN EL TRABAJO',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:24:14',
                'updated_at' => '2025-09-24 08:24:14',
            ),
            47 => 
            array (
                'id' => 2060,
                'nombre' => 'AUDITORIAS EFECTIVAS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:24:24',
                'updated_at' => '2025-09-24 08:24:24',
            ),
            48 => 
            array (
                'id' => 2061,
                'nombre' => 'SEGURIDAD, SALUD EN EL TRABAJO Y PROTECCIÓN AMBIENTAL',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:24:33',
                'updated_at' => '2025-09-24 08:24:33',
            ),
            49 => 
            array (
                'id' => 2062,
                'nombre' => 'CONCEPTOS BÁSICOS Y DEFINICIONES SOBRE PLANES DE RESPUESTA A EMERGENCIA, QUE HACER EN UNA EMERGENCIA',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:24:45',
                'updated_at' => '2025-09-24 08:24:45',
            ),
            50 => 
            array (
                'id' => 2063,
                'nombre' => 'REGLAMENTO DE SEGURIDAD DE HIGIENE DE PETRÓLEOS MEXICANOS Y ORGANISMO SUBSIDIADOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:24:58',
                'updated_at' => '2025-09-24 08:24:58',
            ),
            51 => 
            array (
                'id' => 2064,
                'nombre' => 'IDENTIFICACIÓN DE ÁREAS DE RIESGO EN EL TRABAJO',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:25:10',
                'updated_at' => '2025-09-24 08:25:10',
            ),
            52 => 
            array (
                'id' => 2065,
                'nombre' => 'NOM-017-STPS-2008 EQUIPO DE PROTECCIÓN PERSONALSELECCIÓN USOS Y MANEJO EN LOS CENTROS DE TRABAJO:',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:25:25',
                'updated_at' => '2025-09-24 08:25:25',
            ),
            53 => 
            array (
                'id' => 2066,
                'nombre' => 'BÁSICO DE SEGURIDAD:',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:25:35',
                'updated_at' => '2025-09-24 08:25:35',
            ),
            54 => 
            array (
                'id' => 2067,
                'nombre' => 'PROCEDIMIENTOS CRÍTICOS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:25:48',
                'updated_at' => '2025-09-24 08:25:48',
            ),
            55 => 
            array (
                'id' => 2068,
                'nombre' => 'VERIFICADOR DE GAS',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:26:04',
                'updated_at' => '2025-09-24 08:26:04',
            ),
            56 => 
            array (
                'id' => 2069,
                'nombre' => 'ANÁLISIS DE SEGURIDAD EN EL TRABAJO',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:26:20',
                'updated_at' => '2025-09-24 08:26:20',
            ),
            57 => 
            array (
                'id' => 2070,
                'nombre' => 'AUDITORIA EFECTIVAS',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:26:33',
                'updated_at' => '2025-09-24 08:26:33',
            ),
            58 => 
            array (
                'id' => 2071,
            'nombre' => 'CLASIFICACIÓN Y MANEJO DE RESIDUO PELIGROSO (NOM’S)',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:26:47',
                'updated_at' => '2025-09-24 08:26:47',
            ),
            59 => 
            array (
                'id' => 2072,
                'nombre' => 'CLASIFICACIÓN Y USO DE EQUIPOS DE PROTECCIÓN RESPIRATORIA',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:27:15',
                'updated_at' => '2025-09-24 08:27:15',
            ),
            60 => 
            array (
                'id' => 2073,
                'nombre' => 'DISPOSITIVOS DE PROTECCIÓN Y PRIMEROS AUXILIOS',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:27:40',
                'updated_at' => '2025-09-24 08:27:40',
            ),
            61 => 
            array (
                'id' => 2074,
                'nombre' => 'GENERALIDADES DE LOS PRIMEROS AUXILIOS, HEMORRAGIAS, RCP',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:27:59',
                'updated_at' => '2025-09-24 08:27:59',
            ),
            62 => 
            array (
                'id' => 2075,
                'nombre' => 'GUÍA OPERATIVA PARA LA APLICACIÓN DE SISTEMA DE PERMISOS PARA TRABAJO CON RIESGO',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:28:13',
                'updated_at' => '2025-09-24 08:28:13',
            ),
            63 => 
            array (
                'id' => 2076,
                'nombre' => 'MANEJO DE EXTINTORES',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:29:41',
                'updated_at' => '2025-09-24 08:29:41',
            ),
            64 => 
            array (
                'id' => 2077,
                'nombre' => 'METODOLOGÍA DE ANÁLISIS CAUSA RAÍZ',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:29:55',
                'updated_at' => '2025-09-24 08:29:55',
            ),
            65 => 
            array (
                'id' => 2078,
                'nombre' => 'PROCEDIMIENTOS CRÍTICOS',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:30:06',
                'updated_at' => '2025-09-24 08:30:06',
            ),
            66 => 
            array (
                'id' => 2079,
                'nombre' => 'REGLAMENTO DE SEGURIDAD E HIGIENE DE PETRÓLEOS MEXICANO Y ORGANISMOS SUBSIDIARIOS',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:30:19',
                'updated_at' => '2025-09-24 08:30:19',
            ),
            67 => 
            array (
                'id' => 2080,
                'nombre' => 'REGLAMENTO FEDERAL DE SEGURIDAD U SALUD EN EL TRABAJO',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:30:31',
                'updated_at' => '2025-09-24 08:30:31',
            ),
            68 => 
            array (
                'id' => 2081,
                'nombre' => 'RIESGOS ATMOSFÉRICOS',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:30:50',
                'updated_at' => '2025-09-24 08:30:50',
            ),
            69 => 
            array (
                'id' => 2082,
                'nombre' => 'RIESGO EN ESPACIOS CONFINADOS',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:30:59',
                'updated_at' => '2025-09-24 08:30:59',
            ),
            70 => 
            array (
                'id' => 2083,
                'nombre' => 'SOBREVIVENCIA EN EL MAR',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:31:12',
                'updated_at' => '2025-09-24 08:31:12',
            ),
            71 => 
            array (
                'id' => 2084,
                'nombre' => 'USOS DE EQUIPO DE DETECCIÓN DE GASES; EXPLOSÍMETRO, OXÍGENO Y TOXICIDAD',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 630,
                'created_at' => '2025-09-24 08:31:26',
                'updated_at' => '2025-09-24 08:31:26',
            ),
            72 => 
            array (
                'id' => 2085,
                'nombre' => 'Primeros Auxilios',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 603,
                'created_at' => '2025-09-24 08:34:46',
                'updated_at' => '2025-09-24 08:34:46',
            ),
            73 => 
            array (
                'id' => 2086,
                'nombre' => 'Trabajos con Atmosferas con H2S',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 603,
                'created_at' => '2025-09-24 08:35:47',
                'updated_at' => '2025-09-24 08:35:47',
            ),
            74 => 
            array (
                'id' => 2087,
                'nombre' => 'Sistemas de permisos para trabajos en riesgos ',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 603,
                'created_at' => '2025-09-24 08:36:40',
                'updated_at' => '2025-09-24 08:36:40',
            ),
            75 => 
            array (
                'id' => 2088,
                'nombre' => 'Verificador de Gas',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 603,
                'created_at' => '2025-09-24 08:37:05',
                'updated_at' => '2025-09-24 08:37:05',
            ),
            76 => 
            array (
                'id' => 2089,
                'nombre' => 'Plan de respuesta a emergencia ',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 603,
                'created_at' => '2025-09-24 08:37:29',
                'updated_at' => '2025-09-24 08:37:29',
            ),
            77 => 
            array (
                'id' => 2090,
                'nombre' => 'Trabajo en alturas ',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 603,
                'created_at' => '2025-09-24 08:37:50',
                'updated_at' => '2025-09-24 08:37:50',
            ),
            78 => 
            array (
                'id' => 2091,
                'nombre' => 'Riesgo en espacios confinados',
                'tipo' => 'externo',
                'year' => '2015',
                'user_id' => 603,
                'created_at' => '2025-09-24 08:38:42',
                'updated_at' => '2025-09-24 08:38:42',
            ),
            79 => 
            array (
                'id' => 2092,
                'nombre' => 'Trabajos en alturas',
                'tipo' => 'externo',
                'year' => '2017',
                'user_id' => 328,
                'created_at' => '2025-09-25 07:23:02',
                'updated_at' => '2025-09-25 07:23:02',
            ),
            80 => 
            array (
                'id' => 2093,
                'nombre' => 'Recipientes sujetos a presión y calderas',
                'tipo' => 'externo',
                'year' => '2018',
                'user_id' => 328,
                'created_at' => '2025-09-25 07:23:49',
                'updated_at' => '2025-09-25 07:23:49',
            ),
            81 => 
            array (
                'id' => 2094,
                'nombre' => 'Intervención en líneas de Polietileno',
                'tipo' => 'externo',
                'year' => '2018',
                'user_id' => 328,
                'created_at' => '2025-09-25 07:24:30',
                'updated_at' => '2025-09-25 07:24:30',
            ),
            82 => 
            array (
                'id' => 2095,
                'nombre' => 'Válvulas en General y Válvulas API 6D',
                'tipo' => 'interno',
                'year' => '2025',
                'user_id' => 40,
                'created_at' => '2025-09-25 07:31:19',
                'updated_at' => '2025-09-25 07:31:19',
            ),
            83 => 
            array (
                'id' => 2096,
                'nombre' => 'Válvulas en General y Válvulas API 6D',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:15:38',
                'updated_at' => '2025-09-26 01:15:38',
            ),
            84 => 
            array (
                'id' => 2097,
                'nombre' => 'Uso y manejo de equipo EPP',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:16:19',
                'updated_at' => '2025-09-26 01:16:19',
            ),
            85 => 
            array (
                'id' => 2098,
                'nombre' => 'Manejo y uso de SANDBLAST',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:17:21',
                'updated_at' => '2025-09-26 01:17:21',
            ),
            86 => 
            array (
                'id' => 2099,
                'nombre' => 'six sigma',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:18:11',
                'updated_at' => '2025-09-26 01:18:11',
            ),
            87 => 
            array (
                'id' => 2100,
                'nombre' => 'Lean Manufacturing',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:18:50',
                'updated_at' => '2025-09-26 01:18:50',
            ),
            88 => 
            array (
                'id' => 2101,
            'nombre' => 'Filosofia Kaizen (mejora continua)',
                'tipo' => 'externo',
                'year' => '2024',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:19:37',
                'updated_at' => '2025-09-26 01:19:37',
            ),
            89 => 
            array (
                'id' => 2102,
                'nombre' => 'Uso y manejo de extintores',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:21:40',
                'updated_at' => '2025-09-26 01:21:40',
            ),
            90 => 
            array (
                'id' => 2103,
                'nombre' => 'Inducción al Sistema de Gestión de Salud, Seguridad y Medio Ambiente',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:23:09',
                'updated_at' => '2025-09-26 01:23:09',
            ),
            91 => 
            array (
                'id' => 2104,
                'nombre' => 'Inducción al Sistema de Gestión Antisoborno',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:23:53',
                'updated_at' => '2025-09-26 01:23:53',
            ),
            92 => 
            array (
                'id' => 2105,
                'nombre' => 'Inducción al Sistema de Gestión Integral',
                'tipo' => 'externo',
                'year' => '2025',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:24:39',
                'updated_at' => '2025-09-26 01:24:39',
            ),
            93 => 
            array (
                'id' => 2106,
                'nombre' => 'NOM-015-STPS-2001: condiciones de seguridad e higiene en trabajos con temperaturas elevadas o abatidas',
                'tipo' => 'externo',
                'year' => '2023',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:26:21',
                'updated_at' => '2025-09-26 01:26:21',
            ),
            94 => 
            array (
                'id' => 2107,
                'nombre' => 'Inducción a Metrología',
                'tipo' => 'externo',
                'year' => '2020',
                'user_id' => 329,
                'created_at' => '2025-09-26 01:27:13',
                'updated_at' => '2025-09-26 01:27:13',
            ),
        ));
        
        
    }
}