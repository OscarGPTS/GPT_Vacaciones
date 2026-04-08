<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="GPT Services">
    <title>Documentos de contratación</title>
    <link rel="stylesheet" href="{{ asset('assets/css/pdf_puesto.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <style>
        @page {
            margin: 0;
        }

        *,
        *::after,
        *::before {
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            /* background-image: url("{{ asset('cv/fondo.jpg') }}");
            background-repeat: no-repeat;
            background-size: cover; */
            padding: 30px 40px 80px 40px;
            font-size: 12px;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.5cm;
        }

        .container {
            padding: 0px 60px;
        }

        .container_all {
            padding: 10px 0;
        }

        .header {
            width: 100%;
            border-collapse: collapse;
        }

        .left,
        .right {
            width: 50%;
        }

        .right {
            text-align: right;
        }

        .foto_colaborador {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            border: 5px solid #edc33c;
        }

        .formacion {
            width: 100%;
            border-collapse: collapse;

        }

        table.historial {
            width: 100%;
            border-width: 1px;
            border-spacing: 2px;
            border-style: outset;
            border-color: black;
            border-collapse: collapse;
            background-color: white;
            max-height: 500px;
            /* Establece una altura máxima para la tabla */
            page-break-inside: auto;
        }



        table.historial td {
            border-width: 1px;
            padding: 5px;
            font-size: 11px;
            border-style: inset;
            border-color: black;
            background-color: white;
            -moz-border-radius: ;
        }
    </style>
</head>

<body class="pdf-body">
    <header id="pdf-header" style="padding: 20px;">
        <table class="table p-0 table-sm table-bordered">
            <tr class="p-0 text-center">
                <th scope="col" rowspan="4" style="vertical-align:middle; padding:0; width: 140px;"><img
                        src="https://res.cloudinary.com/gpt-services/image/upload/v1653666316/logos/logotipo_GPT_kzifqo.png"
                        alt="Brand" width="120" /></th>
                <th scope="col" colspan="6" class="p-0" style="color:#1f4e79;"> <small><b>TECH ENERGY CONTROL
                            S.A DE C.V</b></small> </th>
            </tr>
            <tr class="p-0 text-center">
                <th scope="col" colspan="6" style="text-transform: uppercase;" class="p-0 mt-1"> <small><b>Documentos de contratación</b></small>
                </th>
            </tr>
            <tr class="text-center">
                <th scope="col" class="p-0" style="vertical-align:middle;"><small><b>TIPO DE
                            DOCUMENTO</b></small></th>
                <th scope="col" class="p-0" style="vertical-align:middle; width: 80px;">
                    <small><b>REVISIÓN</b></small>
                </th>
                <th scope="col" class="p-0" style="vertical-align:middle;"><small><b>FECHA DE
                            APROBACIÓN</b></small></th>
                <th scope="col" class="p-0" style="vertical-align:middle;"><small><b>DEPARTAMENTO</b></small></th>
                <th scope="col" class="p-0" style="vertical-align:middle; width: 130px;">
                    <small><b>CÓDIGO</b></small>
                </th>
                <th scope="col" class="p-0" style="vertical-align:middle; width: 80px;">
                    <small><b>PÁGINA</b></small>
                </th>
            </tr>
            <tr class="text-center">
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>Formato</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>02</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>Jun 24</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>Recursos Humanos</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>FO-GPT-RH-01-I</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>&nbsp;</small></td>
            </tr>
        </table>
    </header>
    {{-- <footer>
        <div style="width:30%;text-align: center;font-size: 10px;font-weight: bold;">
            <p>FO-GPT-RH-09-A</p>
            <p>Rev.00</p>
            <p>Fecha de aprobación: Ago-23</p>
        </div>
    </footer> --}}
    <div style="padding:0 10px;">
        <div style="margin-bottom: 10px;">
            <table>
                <tr>
                    <td style="text-transform: uppercase;">Número de empleado:</td>
                    <td style="text-transform: uppercase;">{{ $check['Colaborador'] }}</td>
                </tr>
                <tr>
                    <td style="text-transform: uppercase;">nombre de empleado:</td>
                    <td style="text-transform: uppercase;">{{ $check['Colaborador nombre'] }}</td>
                </tr>
                <tr>
                    <td style="text-transform: uppercase;">fecha ingreso:</td>
                    <td style="text-transform: uppercase;">{{ $check['Fecha ingreso'] }}</td>
                </tr>
            </table>
        </div>

        <table class="historial" style="border:1px solid black;">
            <thead>
                <tr>
                    <td style="text-transform: uppercase;text-align: center;" colspan="2">
                        check list
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-transform: uppercase;font-weight: bold;" colspan="2">
                        capítulo 1
                    </td>
                </tr>
                <tr>
                    <td>
                        NOTIFICACIÓN DE SUELDO, PUESTO, DEPARTAMENTOS, EVALUACION DE DESEMPEÑO
                    </td>
                    <td>
                        {{ $check['Evaluación de desempeño'] }}
                    </td>
                </tr>
                <tr>
                    <td>
                        EVALUCIÓN DE ENTREVISTA
                    </td>
                    <td>
                        {{ $check['Evaluación de entrevista'] }}
                    </td>
                </tr>
                <tr>
                    <td>
                        EVALUCIÓN PERIODO DE PRUEBA (90 DÍAS)
                    </td>
                    <td>
                        {{ $check['Evaluación del período de prueba (90 días)'] }}
                    </td>
                </tr>
                <tr>
                    <td style="text-transform: uppercase;font-weight: bold;" colspan="2">
                        capítulo 2
                    </td>
                </tr>
                <tr>
                    <td>
                        CONVENIOS ESPECIALES O PROMOCIONES
                    </td>
                    <td>
                        {{ $check['Convenios especiales o promociones'] }}
                    </td>
                </tr>
                <tr>
                    <td>
                        KIT CONTRATACIÓN
                    </td>
                    <td>
                        {{ $check['Kit contratación'] }}
                    </td>
                </tr>
                <tr>
                    <td>
                        CARTA COMPROMISO CÓDIGO DE ÉTICA
                    </td>
                    <td>
                        {{ $check['Carta compromiso código de ética'] }}
                    </td>
                </tr>
                <tr>
                    <td>
                        CUESTIONARIO ANTICORRUPCIÓN
                    </td>
                    <td>
                        {{ $check['Cuestionario anticorrupción'] }}
                    </td>
                </tr>
                <tr>
                    <td>
                        REGLAMENTO INTERNO DE TRABAJO FIRMADO
                    </td>
                    <td>
                        {{ $check['Reglamento interno de trabajo firmado'] }}
                    </td>
                </tr>
                <tr>
                    <td>
                        CÓDIGO DE ÉTICA Y CONDUCTA
                    </td>
                    <td>
                        {{ $check['Código de ética y conducta'] }}
                    </td>
                </tr>
                <tr>
                    <td style="text-transform: uppercase;font-weight: bold;" colspan="2">
                        capítulo 3
                    </td>
                </tr>
                <tr>
                    <td>
                        SOLICITUD DE VACACIONES
                    </td>
                    <td>
                        {{ $check['Solicitud de vacaciones'] }}
                    </td>
                </tr>
                <tr>
                    <td>
                        PERMISOS (PAGO TIEMPO POR TIEMPO)
                    </td>
                    <td>
                        {{ $check['Permisos (pago tiempo por tiempo)'] }}
                    </td>
                </tr>
                <tr>
                    <td>
                        INCAPACIDADES
                    </td>
                    <td>
                        {{ $check['Incapacidades'] }}
                    </td>
                </tr>
                <tr>
                    <td style="text-transform: uppercase;font-weight: bold;" colspan="2">
                        capítulo 4
                    </td>
                </tr>
                <tr>
                    <td>
                        CAPACITACIÓN
                    </td>
                    <td>
                        {{ $check['Capacitación'] }}
                    </td>
                </tr>
                <tr>
                    <td>
                        OTROS DOCUMENTOS (bonos, finiquitos, etc.)
                    </td>
                    <td>
                        {{ $check['Otros documentos (bonos, finiquitos, etc.)'] }}
                    </td>
                </tr>
                <tr>
                    <td style="text-transform: uppercase;font-weight: bold;" colspan="2">
                        capítulo 5
                    </td>
                </tr>
                <tr>
                    <td>CARTA OFERTA</td>
                    <td>{{ $check['Carta oferta'] }}</td>
                </tr>
                <tr>
                    <td> CV O SOLICITUD DE EMPLEO</td>
                    <td>{{ $check['CV / solicitud de empleo'] }}</td>
                </tr>
                <tr>
                    <td> ACTA DE NACIMIENTO</td>
                    <td>{{ $check['Acta de nacimiento'] }}</td>
                </tr>
                <tr>
                    <td> ACTA DE MATRIMONIO</td>
                    <td>
                        {{ $check['Acta de matrimonio'] }}
                    </td>
                </tr>
                <tr>
                    <td> ACTA DE NACIMIENTO DE ESPOSA E HIJOS</td>
                    <td>
                        {{ $check['Acta de nacimiento de esposa e hijos'] }}
                    </td>
                </tr>
                <tr>
                    <td> IDENTIFICACIÓN OFICIAL</td>
                    <td>
                        {{ $check['Identificación oficial'] }}
                    </td>
                </tr>
                <tr>
                    <td>CARTAS DE RECOMENDACIÓN</td>
                    <td>{{ $check['Cartas de recomendación'] }}</td>
                </tr>
                <tr>
                    <td> COMPROBANTE DE ESTUDIOS (ÚLTIMO)</td>
                    <td>
                        {{ $check['Comprobante de estudios (último)'] }}
                    </td>
                </tr>
                <tr>
                    <td> COMPROBANTE DE DOMICILIO (NO MAYOR A TRES MESES)</td>
                    <td>
                        {{ $check['Comprobante de domicilio (no mayor a tres meses)'] }}
                    </td>
                </tr>
                <tr>
                    <td> NÚMERO DE SEGURO SOCIAL</td>
                    <td>
                        {{ $check['Número de seguro social'] }}
                    </td>
                </tr>
                <tr>
                    <td> AVISO DE RETENCIÓN DE INFONAVIT</td>
                    <td>
                        {{ $check['Aviso de retención de Infonavit'] }}
                    </td>
                </tr>
                <tr>
                    <td> AVISO DE RETENCIÓN FONACOT</td>
                    <td>
                        {{ $check['Aviso de retención FONACOT'] }}
                    </td>
                </tr>
                <tr>
                    <td> CURP</td>
                    <td>
                        {{ $check['CURP'] }}
                    </td>
                </tr>
                <tr>
                    <td> CONSTANCIA DE SITUACION FISCAL</td>
                    <td>
                        {{ $check['Constancia de situación fiscal'] }}
                    </td>
                </tr>
                <tr>
                    <td> COMPROBANTE DE BANCO</td>
                    <td>
                        {{ $check['Comprobante de banco'] }}
                    </td>
                </tr>
                <tr>
                    <td> ANTECEDENTES CLÍNICOS</td>
                    <td>{{ $check['Antecedentes clínicos'] }}</td>
                </tr>
                <tr>
                    <td> FORMATO DE APTITUD</td>
                    <td>
                        {{ $check['Formato de aptitud'] }}
                    </td>
                </tr>
                <tr>
                    <td> CERTIFICADO MÉDICO</td>
                    <td>{{ $check['Certificado médico'] }}</td>
                </tr>
                <tr>
                    <td> ACTUALIZACION DE DATOS (ÚLTIMO)</td>
                    <td>
                        {{ $check['Actualización de datos (último)'] }}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <script type="text/php">
        if (isset($pdf)) {
                    $x = 537;
                    $y = 60;
                    $text = "{PAGE_NUM} de {PAGE_COUNT}";
                    $font = "Source Sans Pro, open sans";
                    $size = 9;
                    $color = array(0,0,0);
                    $word_space = 0.0;  //  default
                    $char_space = 0.0;  //  default
                    $angle = 0.0;   //  default
                    $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
                    }
                    </script>
</body>

</html>
