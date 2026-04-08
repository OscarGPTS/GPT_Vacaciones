<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RequisicionesCursoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('requisiciones_curso')->delete();
        
        \DB::table('requisiciones_curso')->insert(array (
            0 => 
            array (
                'id' => 1,
            'nombre' => 'Administración de proyectos con Microsoft Project (15 PDUs)',
                'tipo_capacitacion' => 'Curso',
                'justificacion' => 'Mejora en la gestión de proyectos y uso eficiente de Project de Microsoft',
            'motivo' => 'Solicitud de curso (Internas ó Externas)',
                'beneficio' => 'Mejora en la programación, ejecución y control de proyectos usando Microsoft Project
Mejora en el análisis y aplicación de técnicas de análisis de costeo, nivelación de recursos y análisis de riesgos en uno y varios proyectos corriendo de manera simultánea
Incremento en la habilidad para el manejo de holguras, rutas críticas y tiempos sobre asignados dentro de un proyecto para tener un mejor manejo del presupuesto y asignación de recursos monetarios',
                'comentarios' => 'https://www.udemy.com/course/administracion-de-proyectos-con-microsoft-project/?couponCode=ST11MT170325G2 ',
                'status' => 'En revisión por gerente',
                'created_at' => '2025-03-19 09:12:30',
                'updated_at' => '2025-03-19 09:12:30',
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'Cálculo de huella de carbono',
                'tipo_capacitacion' => 'Curso',
                'justificacion' => 'Atención a la enmienda de ISO 9001:2015 y la alineación de la organización con los ODS',
                'motivo' => 'Sistema de Gestión Integral',
                'beneficio' => 'Generar conciencia acerca del cuidado del medio ambiente',
                'comentarios' => 'https://capacitateparaelempleo.org/cursos/view/217',
                'status' => 'Cerrada',
                'created_at' => '2025-04-24 07:05:40',
                'updated_at' => '2025-08-15 07:43:35',
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'Cálculo de huella ecológica',
                'tipo_capacitacion' => 'Curso',
                'justificacion' => 'Atención a la enmienda de ISO 9001:2015 y la alineación de la organización con los ODS',
                'motivo' => 'Sistema de Gestión Integral',
                'beneficio' => 'Crear conciencia acerca del cuidado del medio ambiente ',
                'comentarios' => 'https://capacitateparaelempleo.org/cursos/view/218',
                'status' => 'Cerrada',
                'created_at' => '2025-04-24 07:09:07',
                'updated_at' => '2025-08-15 07:42:35',
            ),
            3 => 
            array (
                'id' => 4,
                'nombre' => 'Cálculo de huella hídrica',
                'tipo_capacitacion' => 'Curso',
                'justificacion' => 'Atención a la enmienda de ISO 9001:2015 y la alineación de la organización con los ODS',
                'motivo' => 'Sistema de Gestión Integral',
                'beneficio' => 'Crear conciencia acerca del cuidado del medio ambiente ',
                'comentarios' => 'https://capacitateparaelempleo.org/cursos/view/233',
                'status' => 'Cerrada',
                'created_at' => '2025-04-24 07:11:22',
                'updated_at' => '2025-08-15 07:43:28',
            ),
            4 => 
            array (
                'id' => 5,
                'nombre' => 'Economía circular',
                'tipo_capacitacion' => 'Curso',
                'justificacion' => 'Atención a la enmienda de ISO 9001:2015 y la alineación de la organización con los ODS
',
                'motivo' => 'Sistema de Gestión Integral',
                'beneficio' => 'Crear conciencia acerca del cuidado del medio ambiente
',
                'comentarios' => 'https://capacitateparaelempleo.org/cursos/view/323',
                'status' => 'Cerrada',
                'created_at' => '2025-04-24 07:13:06',
                'updated_at' => '2025-08-15 07:43:09',
            ),
            5 => 
            array (
                'id' => 6,
                'nombre' => 'Cultura ambiental',
                'tipo_capacitacion' => 'Curso',
                'justificacion' => 'Atención a la enmienda de ISO 9001:2015 y la alineación de la organización con los ODS
',
                'motivo' => 'Sistema de Gestión Integral',
                'beneficio' => 'Crear conciencia acerca del cuidado del medio ambiente
',
                'comentarios' => 'https://capacitateparaelempleo.org/cursos/view/275',
                'status' => 'Aceptada por dirección general',
                'created_at' => '2025-04-24 07:14:28',
                'updated_at' => '2025-04-28 13:51:00',
            ),
            6 => 
            array (
                'id' => 7,
                'nombre' => 'Agenda 2030',
                'tipo_capacitacion' => 'Curso',
                'justificacion' => 'Atención a la enmienda de ISO 9001:2015 y la alineación de la organización con los ODS
',
                'motivo' => 'Sistema de Gestión Integral',
                'beneficio' => 'Crear conciencia acerca del cuidado del medio ambiente
',
                'comentarios' => 'https://www.itcilo.org/es/courses/la-agenda-2030-el-trabajo-decente-y-el-dialogo-social',
                'status' => 'Aceptada por dirección general',
                'created_at' => '2025-04-24 07:21:44',
                'updated_at' => '2025-04-28 13:51:48',
            ),
            7 => 
            array (
                'id' => 8,
                'nombre' => 'Debida diligencia en materia de derechos humanos para el trabajo decente',
                'tipo_capacitacion' => 'Curso',
                'justificacion' => 'Atención a la enmienda de ISO 9001:2015 y la alineación de la organización con los ODS
',
                'motivo' => 'Sistema de Gestión Integral',
                'beneficio' => 'Crear conciencia acerca del cuidado del medio ambiente
',
                'comentarios' => 'https://www.itcilo.org/es/courses/debida-diligencia-en-materia-de-derechos-humanos-para-el-trabajo-decente',
                'status' => 'Aceptada por dirección general',
                'created_at' => '2025-04-24 07:23:28',
                'updated_at' => '2025-04-28 13:51:56',
            ),
            8 => 
            array (
                'id' => 9,
                'nombre' => 'Uso y manejo de grúa viajera',
                'tipo_capacitacion' => 'Curso',
                'justificacion' => 'El personal del área de proyectos y de SSGG lleva a cabo actividades que involucran el uso y manejo de izajes y manejo de cargas mediante el uso de grúa viajera',
            'motivo' => 'Solicitud de curso (Internas ó Externas)',
                'beneficio' => 'Operación con seguridad hacia el personal y equipos',
                'comentarios' => 'El personal debe de contar con un curso que acredite su conocimiento en el uso de grúa viajera',
                'status' => 'En revisión por dirección general',
                'created_at' => '2025-06-24 09:40:29',
                'updated_at' => '2025-09-01 02:26:47',
            ),
            9 => 
            array (
                'id' => 10,
            'nombre' => 'Manejo de Equipos de Respiración Autónoma (ERA)',
                'tipo_capacitacion' => 'Curso',
                'justificacion' => 'El personal en cuestión es personal ocupacionalmente expuesto, en caso de alguna situación mayor como un accidente durante la investigación causa raíz, se deberá de presentar como primera instancia la capacitación para uso de equipos de Respiración Autónoma, en caso de no contar con este, se considera una negligencia a quien dio la orden de ejecución y a la empresa quien tiene al personal expuesto.',
            'motivo' => 'Solicitud de curso (Internas ó Externas)',
                'beneficio' => 'Dar cumplimiento a regulaciones de clientes y legales.
Personal ocupacionalmente expuesta ejecute sus actividades de manera exitosa
Prevenir accidentes laborales.
Permitir que el personal ejecute actividades se le asigne la ejecución de actividades de manera segura.
Al término del curso el participante estará en condiciones de utilizar de manera segura y eficaz un equipo de respiración autónomo (ERA) en labores tales como:
Trabajos en espacios confinados
Manejo de sustancias peligrosas, Incendios, etc.
Aprender a utilizar e interpretar los equipos de medida de gases. Señalización y EPI´s.
Capacitar en el uso y mantenimiento básico de los ERA´s',
                'comentarios' => 'Como supervisor de campo, no me permito asignar esta actividad a personal que no cuente con esta capacitación, pues es un acto negligente de mi parte.',
                'status' => 'En revisión por gerente',
                'created_at' => '2025-09-03 02:09:21',
                'updated_at' => '2025-09-03 02:09:21',
            ),
            10 => 
            array (
                'id' => 11,
                'nombre' => 'LEAK TEST NII',
                'tipo_capacitacion' => 'Otro',
                'justificacion' => 'Durante el procedimiento de ejecución de Hot Tapping, en la preparación de actividades previo a la ejecución, es necesario que se lleve a cabo una Pruebas de hermeticidad en campo al arreglo de perforación, así mismo, una vez llevadas a cabo las soldaduras de línea regular, previo a la puesta en operación tanto de bypass, como de tubería, se requiere ejecutar una Pruebas de hermeticidad, misma que debiera ser desarrollada por un Técnico NII en LT.',
            'motivo' => 'Solicitud de curso (Internas ó Externas)',
            'beneficio' => 'GPT Services, lleva a cabo alcances de pruebas de hermeticidad, algunos son desarrollados de manera interna sin contar con la capacitación, ni con la documentación de cumplimiento requerida, por lo que queda incompleto el expediente, otras son subcontratadas, generando costos adicionales, por ello el contar con este alcance en el personal de campo (supervisor y/o técnicos), podríamos tomar esos alcances.',
                'comentarios' => 'Es una área de oportunidad que parte no solo de un requerimiento normativo, sino de una oportunidad de negocio.',
                'status' => 'En revisión por gerente',
                'created_at' => '2025-09-03 02:53:20',
                'updated_at' => '2025-09-03 02:53:20',
            ),
        ));
        
        
    }
}