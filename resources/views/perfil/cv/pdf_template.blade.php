<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="GPT Services">
    <title>Curriculum</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <style>
        @page {
            margin: 0;
        }

        * {
            padding: 0;
            margin: 0;
        }

        *,
        *::after,
        *::before {
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-image: url("{{ asset('cv/fondo.jpg') }}");
            background-repeat: no-repeat;
            background-size: cover;
            padding: 120px 0 80px 0;
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

        table.historial th {
            border-width: 1px;
            text-align: center;
            padding: 5px;
            font-size: 10px;
            font-weight: bold;
            border-style: inset;
            border-color: black;
            background-color: white;
            -moz-border-radius: ;
        }

        table.historial td {
            border-width: 1px;
            padding: 5px;
            font-size: 10px;
            border-style: inset;
            border-color: black;
            background-color: white;
            -moz-border-radius: ;
        }

        .historial>tbody>tr:nth-of-type(odd)>* {
            background-color: #eeeeee;
        }
    </style>
</head>

<body>
    <footer>
        <div style="width:30%;text-align: center;font-size: 10px;font-weight: bold;">
            <p>FO-GPT-RH-09-A</p>
            <p>Rev.00</p>
            <p>Fecha de aprobación: Ago-23</p>
        </div>
    </footer>
    {{-- Informacion del colaborador --}}
    <div class="container">
        <table class="header">
            <tbody>
                <tr>
                    <td class="left">
                        <p style="font-size:18px;text-transform:uppercase;font-weight:bold;">{{ $user->nombre() }}</p>
                        <p style="font-size:16px;">{{ $user->job->name }}</p>
                        <p style="font-size:16px;"><strong>Edad:</strong> {{ $user->personalData->birthday->age }}</p>
                        <p style="font-size:16px;"><strong>CURP:</strong> {{ $user->personalData->curp }}</p>
                        <p style="font-size:16px;"><strong>NSS:</strong> {{ $user->personalData->nss }}</p>
                        <p style="font-size:16px;"><strong>Libreta de mar:</strong> {{ $user->libreta_mar }}</p>
                        <p style="font-size:16px;"><strong>Contacto:</strong> {{ $user->email }}</p>
                    </td>
                    <td class="right">
                        <img class="foto_colaborador" src="{{ $user->profile_image }}" alt="colaborador">
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
    {{-- Formacion --}}
    @if ($user->cvFormatoTipo() !== 2)
        <div class="container_all" style="margin-top:10px;">
            <table class="formacion">
                <thead style="background-color:#eeeeee;border:1px solid #edc33c;">
                    <tr>
                        <th style="text-align:left;padding:5px;">
                            <p>FORMACIÓN</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding:10px 0 0 30px;">
                            <p>
                                @if (blank($user->escolaridad_nombre))
                                    {{ $user->escolaridad }}
                                @else
                                    {{ $user->escolaridad_nombre }}
                            </p>
    @endif
    </td>
    </tr>
@empty(!$user->cedula)
    <tr>
        <td style="padding:0 30px;">
            <p>Cédula profesional: {{ $user->cedula }}</p>
        </td>
    </tr>
@endempty
</tbody>
</table>
</div>
@endif
{{-- Experiencia --}}
<div class="container_all" style="margin-top:10px;">
    <table class="formacion">
        <thead style="background-color:#eeeeee;border:1px solid #edc33c;">
            <tr>
                <th style="text-align:left;padding:5px;">
                    <p>EXPERIENCIA</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($user->cvExperiencia->count() > 0)
                @foreach ($user->cvExperiencia as $experiencia)
                    <tr>
                        <td style="padding:10px 0 0 30px;">
                            @if ($experiencia->actualmente_laborando)
                                {{ $experiencia->fecha_inicio }} - Actualmente -
                            @else
                                {{ $experiencia->fecha_inicio }} - {{ $experiencia->fecha_final }} -
                            @endif
                            {{ $experiencia->puesto }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
{{-- Cursos y certificaciones --}}
<div class="container_all" style="margin-top:10px;">
    <table class="formacion">
        <thead style="background-color:#eeeeee;border:1px solid #edc33c;">
            <tr>
                <th style="text-align:left;padding:5px;">
                    <p>CURSOS / CERTIFICACIONES</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($user->cvCursoCertificacion->count() > 0)
                @foreach ($user->cvCursoCertificacion->sortByDesc('year') as $curso)
                    <tr>
                        <td style="padding:10px 0 0 30px;">
                            {{ $curso->nombre }}-{{ $curso->year }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
{{-- Cursos y certificaciones solo para personal de soldadura --}}
@if ($user->cvCursoSoldadura->count() > 0)
    <div style="page-break-before: always;"></div>
    <div class="container_all" style="margin-top:10px;">
        <table class="formacion">
            <thead style="background-color:#eeeeee;border:1px solid #edc33c;">
                <tr>
                    <th style="text-align:left;padding:5px;">
                        <p>CERTIFICACIONES DE SOLDADURA</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->cvCursoSoldadura as $curso)
                    <tr>
                        <td style="padding:10px 0 0 30px;">
                            <div>
                                <p>{{ $curso->nombre }}</p>
                            </div>
                            <div>
                                <strong>Proceso: </strong><span>{{ $curso->proceso }}</span>
                            </div>
                            @empty(!$curso->wps)
                                <div>
                                    <strong>Wps: </strong><span>{{ $curso->wps }}</span>
                                </div>
                            @endempty
                            <div>
                                <strong>Desde: </strong><span>{{ $curso->desde }}</span>
                            </div>
                            <div>
                                <strong>Hasta: </strong><span>{{ $curso->hasta }}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@if ($user->showHistorialServicios())
    {{-- Tabla Historial de servicios --}}
    <div style="page-break-before: always;"></div>
    <div class="container_all" style="margin-top:10px;">
        <table class="formacion" style="margin-bottom:20px;">
            <thead style="background-color:#eeeeee;border:1px solid #edc33c;">
                <tr>
                    <th style="text-align:left;padding:5px;">
                        <p>HISTORIAL DE SERVICIOS</p>
                    </th>
                </tr>
            </thead>

        </table>
    </div>
    <div style="padding:0 20px;">
        <table class="historial" style="border:1px solid black;">
            <thead>
                @if ($user->cvFormatoTipo() == 1)
                    <tr>
                        <th scope="col">
                            Cliente
                        </th>
                        <th scope="col">
                            Servicio
                        </th>
                        <th scope="col">
                            Alcance
                        </th>
                        <th scope="col">
                            Ramal
                        </th>
                        <th scope="col">
                            Año
                        </th>
                        <th scope="col">
                            Mes
                        </th>
                        <th scope="col">
                            Ubicación
                        </th>
                    </tr>
                @endif
                @if ($user->cvFormatoTipo() == 2)
                    <tr>
                        <th scope="col">
                            Cliente
                        </th>
                        <th scope="col">
                            Tipo de servicio
                        </th>
                        <th scope="col">
                            Cabezal
                        </th>
                        <th scope="col">
                            Ramal
                        </th>
                        <th scope="col">
                            Clase ANSI
                        </th>
                        <th scope="col">
                            Año
                        </th>
                        <th scope="col">
                            Ubicación
                        </th>
                    </tr>
                @endif
            </thead>

            <tbody>
                @if ($user->cvHistorialServicio->count() > 0)
                    @foreach ($user->cvHistorialServicio as $servicio)
                        @if ($user->cvFormatoTipo() == 1)
                            <tr class="">
                                <td scope="row" class="">
                                    {{ $servicio->cliente }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->servicio }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->alcance }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->ramal }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->year }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->mes }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->ubicacion }}
                                </td>
                            </tr>
                        @endif
                        @if ($user->cvFormatoTipo() == 2)
                            <tr class="">
                                <td scope="row" class="">
                                    {{ $servicio->cliente }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->servicio }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->cabezal }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->ramal }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->clase }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->year }}
                                </td>
                                <td scope="row" class="">
                                    {{ $servicio->ubicacion }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endif

{{-- <div>
    <div style="text-align: center;">
        <div style="width: 400px; text-align: center; margin: 0 auto;;">
            <p>Autoriza</p>
        </div>
        <br>
        <img src="{{ asset('assets/images/firma-drr.png') }}" alt="firma" style="width: 200px;">
        <br>
        <div>
            <div style="width: 300px; text-align: center; margin: 0 auto;;">
                <p style="border-top:1px solid black;">Dirección General</p>
            </div>
            <p>Denise Marisol Reyes Ramírez</p>
        </div>
    </div>
</div> --}}

</body>

</html>
