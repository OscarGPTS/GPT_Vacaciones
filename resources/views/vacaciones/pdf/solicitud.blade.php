<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Solicitud de Vacaciones</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            line-height: 1.2;
            color: #000;
        }

        .container {
            width: 100%;
            padding-left: 80px;
            padding-right: 40px;
        }

        /* Header con logo y tabla */
        .header-section {
            display: flex; /* Usar flexbox para alinear horizontalmente */
            align-items: center; /* Centrar verticalmente */
            justify-content: space-between; /* Espaciado entre logo y tabla */
            margin-bottom: 15px;
        }

        .logo-container {
            width: 20%; /* Ajustar el tamaño del contenedor del logo */
            text-align: center; /* Centrar el logo dentro del contenedor */
        }

        .logo-container img {
            width: 150px;
            height: auto;
        }

        .header-table-container {
            width: 75%; /* Ajustar el tamaño de la tabla */
        }



        .header-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
        }

        .header-table th,
        .header-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            font-size: 8pt;
        }

        .header-table th {
            background-color: #fff;
            font-weight: bold;
        }

        .header-title {
            background-color: #fff;
            font-weight: bold;
            font-size: 11.5pt;
            text-align: center;
            padding: 5px;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .date-box {
            margin-right: 140px;
            text-align: right;
            margin-bottom: 15px;
            font-size: 11.5pt;
        }

        .date-box table {
            float: right;
            border-collapse: collapse;
        }

        .date-box td {
            padding: 0 8px;
            text-align: center;
        }

        /* Sección de empresa con checkbox */
        .company-section {
            margin-bottom: 12px;
        }

        .company-box {
            border: 1px solid #000;
            padding: 8px;
            display: inline-block;
            width: 70%;
            text-align: center;
        }

        .company-table {
            margin: 0 auto 20px; 
            border: 1px solid red;
            border-collapse: collapse;
        }

        .company-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center; 
        }

        .checkbox {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 2px solid #000;
            vertical-align: middle;
            margin-right: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 11.5pt;
        }

        .info-label {
            font-weight: normal;
        }

        /* Tabla de días hábiles */
        .days-table {
            width: 85%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .days-table th {
            padding-top: 10px;
            background-color: #1e3a8a;
            color: white;
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            font-weight: bold;
            font-size: 11.5pt;
        }

        .days-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 11.5pt;
        }

        /* Texto de solicitud */
        .request-text {
            width: 85%;
            margin-bottom: 15px;
            font-size: 11.5pt;
            line-height: 1.5;
            text-align: justify;
        }

        /* Fechas del período */
        .period-dates {
            margin-top: 15px;
            margin-bottom: 20px;
            font-size: 11.5pt;
        }

        .period-dates table {
            border-collapse: collapse;
        }

        .period-dates td {
            padding: 3px -2px;
        }

        .signatures-table {
            width: 85%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 15px;
        }

        .signatures-table th {
            background-color: #1e3a8a;
            color: white;
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            font-size: 11.5pt;
        }

        .signatures-table td {
            border: 1px solid #000;
            padding: 30px 10px 10px 10px;
            text-align: center;
            font-size: 8pt;
            height: 80px;
            vertical-align: bottom;
        }

        .signature-label {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .signature-name {
            font-size: 11pt;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 7pt;
            color: #ff0000;
        }

        .bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .mb-10 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div style="padding:40px 10px 8px 10px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width:100px; height:80px;text-align:center; vertical-align:middle;">
                    <img src="{{ public_path('assets/images/logo/logo_GPT.png') }}"
                        style="width:100%; height:auto; object-fit:contain;">
                </td>
                <td style="width: 85%; text-align: center; padding: 5px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td colspan="6" style="border: 1px solid #000; font-weight: bold; font-size: 11.5pt; text-align: center;">SOLICITUD DE VACACIONES</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="border: 1px solid #000; font-weight: bold; padding: 0; font-size: 11.5pt; text-align: center;"><br> TIPO DE DOCUMENTO</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">TIPO DE<br>DOCUMENTO</th>
                            <th style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">REVISIÓN</th>
                            <th style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">FECHA DE<br>APROBACIÓN</th>
                            <th style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">DEPARTAMENTO</th>
                            <th style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">CÓDIGO</th>
                            <th style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">PÁGINA</th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">Formato</td>
                            <td style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">02</td>
                            <td style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">Agosto-22</td>
                            <td style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">Recursos Humanos</td>
                            <td style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">FO-GPT-RH-04-A</td>
                            <td style="border: 1px solid #000; font-size: 11.5pt; text-align: center;">1</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="container">
        <!-- Fecha en la esquina superior derecha -->
        <div class="date-box clearfix">
            <table>
                <tr>
                    <td style="font-size: 11.5pt;">{{ $fechaGeneracion->format('d') }}</td>
                    <td>/</td>
                    <td style="font-size: 11.5pt;">{{ $fechaGeneracion->format('m') }}</td>
                    <td>/</td>
                    <td style="font-size: 11.5pt;">{{ $fechaGeneracion->format('Y') }}</td>
                </tr>
                <tr>
                    <td style="font-size: 11.5pt;"><strong>DD</strong></td>
                    <td></td>
                    <td style="font-size: 11.5pt;"><strong>MM</strong></td>
                    <td></td>
                    <td style="font-size: 11.5pt;"><strong>AAAA</strong></td>
                </tr>
            </table>
        </div>

        <!-- Sección de Compañía -->

        <div style="font-size: 11.5pt;" class="company-section">
            Compañía:<br><br>

        </div>
        <table class="company-table">
            <tr>
                @foreach($companies as $company)
                <td style="width:20px; text-align:center;">
                    @if($company->id == $user->business_name_id)
                        <p style="padding: 0 4px 0 4px; font-weight:bold;">X</p>
                    @else
                        <p style="padding: 0 4px 0 4px;">&nbsp;</p>
                    @endif
                </td>
                <td>{{ $company->short_name }}</td>
                @endforeach
            </tr>
        </table>

        <div>
            <p style="font-size:11.5pt;">Nombre del colaborador: {{ $user->first_name }} {{ $user->last_name }}</p> 
            <p style="font-size:11.5pt;">Departamento: {{ $departamento->name ?? 'N/A' }}</p>
            <p style="font-size:11.5pt;">Fecha de Ingreso: {{ Carbon\Carbon::parse($user->admission)->format('d \d\e F Y') }}</p>
            <p style="font-size:11.5pt;">Antigüedad: {{ $antiguedad }} año{{ $antiguedad != 1 ? 's' : '' }} {{ $antiguedad > 0 ? Carbon\Carbon::parse($user->admission)->diff(Carbon\Carbon::now())->m : '' }} {{ $antiguedad > 0 && Carbon\Carbon::parse($user->admission)->diff(Carbon\Carbon::now())->m > 0 ? 'meses' : '' }}</p>
            <p style="font-size:11.5pt;">Período del: {{ date('Y') }} – {{ date('Y') + 1 }}</p>
        </div>
        <br>
        <!-- Tabla de Días Hábiles -->
        <table class="days-table">
            <thead>
                <tr>
                    <th>1) Días hábiles que le<br>corresponden este<br>período</th>
                    <th>2) Disfrutados</th>
                    <th>3) Pendientes<br>por disfrutar</th>
                    <th>4) Solicitados</th>
                    <th>5) Restantes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ number_format($diasDisponibles + $totalDias, 0) }}</td>
                    <td>0</td>
                    <td>{{ number_format($diasDisponibles + $totalDias, 0) }}</td>
                    <td>{{ $totalDias }}</td>
                    <td>{{ number_format($diasDisponibles, 0) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Texto de Solicitud -->
        <div class="request-text">
            Me permito solicitar a la compañía Tech Energy Control S.A. De C.V. / GPT Ingeniería y Manufactura
            las vacaciones que me corresponden por el periodo aquí indicado esperando la autorización de las
            siguientes fechas:
        </div>

        <br> <br>
        <div class="period-dates">
           
            <table style="display: inline-table; margin: 0 5px;">
                <tr>
                    <td>Del</td>
                    <td style="padding-left: 4px;">{{ $fechaInicio ? $fechaInicio->format('d') : '__' }}</td>
                    <td>/</td>
                    <td>{{ $fechaInicio ? $fechaInicio->format('m') : '__' }}</td>
                    <td>/</td>
                    <td>{{ $fechaInicio ? $fechaInicio->format('Y') : '____' }}</td>
                </tr>
                <tr style="font-size: 5pt;">
                    <td></td>
                    <td style="padding-left: 4px;">DD</td>
                    <td>/</td>
                    <td>MM</td>
                    <td>/</td>
                    <td>AAAA</td>
                </tr>
            </table>
            
            <table style="display: inline-table; margin: 0 5px;">
                <tr>
                    <td>al</td>
                    <td style="padding-left: 4px;">{{ $fechaFin ? $fechaFin->format('d') : '__' }}</td>
                    <td>/</td>
                    <td>{{ $fechaFin ? $fechaFin->format('m') : '__' }}</td>
                    <td>/</td>
                    <td>{{ $fechaFin ? $fechaFin->format('Y') : '____' }}</td>
                </tr>
                <tr style="font-size: 5pt;">
                    <td></td>
                    <td style="padding-left: 4px;">DD</td>
                    <td>/</td>
                    <td>MM</td>
                    <td>/</td>
                    <td>AAAA</td>
                </tr>
            </table>
        </div>
        <br>

        <table class="signatures-table">
            <thead>
                <tr>
                    <th>Firma del colaborador</th>
                    <th>Jefe inmediato</th>
                    <th>RRHH</th>
                    <th>Gerente/Dirección<br>General</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    {{-- Colaborador --}}
                    <td>
                        @if($sigColaborador && $sigColaborador->signature_url && file_exists(public_path($sigColaborador->signature_url)))
                            <img src="{{ public_path($sigColaborador->signature_url) }}" style="max-height:55px; max-width:130px;">
                        @else
                            <span style="font-size:9pt; color:#888;">Sin firma</span>
                        @endif
                    </td>
                    {{-- Jefe inmediato --}}
                    <td>
                        @if($sigJefe && $sigJefe->signature_url && file_exists(public_path($sigJefe->signature_url)))
                            <img src="{{ public_path($sigJefe->signature_url) }}" style="max-height:55px; max-width:130px;">
                        @else
                            <span style="font-size:9pt; color:#888;">Sin firma</span>
                        @endif
                    </td>
                    {{-- RRHH — no se almacena el usuario que aprobó --}}
                    <td>
                        @if($sigRRHH && $sigRRHH->signature_url && file_exists(public_path($sigRRHH->signature_url)))
                            <img src="{{ public_path($sigRRHH->signature_url) }}" style="max-height:55px; max-width:130px;">
                        @else
                            <span style="font-size:9pt; color:#888;">Sin firma</span>
                        @endif
                    </td>
                    {{-- Gerente / Dirección --}}
                    <td>
                        @if($sigDireccion && $sigDireccion->signature_url && file_exists(public_path($sigDireccion->signature_url)))
                            <img src="{{ public_path($sigDireccion->signature_url) }}" style="max-height:55px; max-width:130px;">
                        @else
                            <span style="font-size:9pt; color:#888;">Sin firma</span>
                        @endif
                    </td>
                </tr>
            </tbody>
            <thead>
                <tr>
                    <th style="font-size: 10pt; padding:0; margin:0;">Responsable/Solicita</th>
                    <th style="font-size: 10pt; padding:0; margin:0;">Autoridad/Autoriza</th>
                    <th style="font-size: 10pt; padding:0; margin:0;">Consultado/Recibe</th>
                    <th style="font-size: 10pt; padding:0; margin:0;">Autoridad/Recibe</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="footer">
        Los documentos impresos son "COPIAS NO CONTROLADAS".
    </div>
</body>
</html>
