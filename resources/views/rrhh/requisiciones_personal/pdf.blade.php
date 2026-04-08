<html>

<head>
    <meta name="author" content="GPT Services">
    <title>Requisición de personal</title>
    <link rel="stylesheet" href="{{ asset('assets/css/pdf_puesto.css') }}">
</head>

<body class="pdf-body">
    <header id="pdf-header">
        <table class="table p-0 table-sm table-bordered">
            <tr class="p-0 text-center">
                <th scope="col" rowspan="4" style="vertical-align:middle; padding:0; width: 140px;"><img
                        src="https://res.cloudinary.com/gpt-services/image/upload/v1653666316/logos/logotipo_GPT_kzifqo.png"
                        alt="Brand" width="120" /></th>
                <th scope="col" colspan="6" class="p-0" style="color:#1f4e79;"> <small><b>TECH ENERGY CONTROL
                            S.A DE C.V</b></small> </th>
            </tr>
            <tr class="p-0 text-center">
                <th scope="col" colspan="6" class="p-0 mt-1"> <small><b>REQUISICIÓN DE PERSONAL</b></small> </th>
            </tr>
            <tr class="text-center">
                <th scope="col" class="p-0" style="vertical-align:middle;"><small><b>TIPO DE
                            DOCUMENTO</b></small></th>
                <th scope="col" class="p-0" style="vertical-align:middle; width: 80px;">
                    <small><b>REVISIÓN</b></small>
                </th>
                <th scope="col" class="p-0" style="vertical-align:middle;"><small><b>FECHA DE APROBACIÓN</b></small></th>
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
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>01</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>Sep 21</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>Recursos Humanos</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>FO-GPT-RH-01-D</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>&nbsp;</small></td>
            </tr>
        </table>
    </header>
    <footer id="pdf-footer">
        <table class="table table-sm p-0">
            <tr>
                <td width="80%" style="background-color: #5b5a5f; color: #ffffff;">
                    <p class="font-weight-bold font-italic m-0">TECH ENERGY CONTROL, S.A. DE C.V.</p>
                    <p class="m-0 small">Av. Santa M&oacute;nica 33, Col. El Mirador, C.P. 54080, Tlalnepantla de Baz,
                        Estado de M&eacute;xico, M&eacute;xico.</p>
                    <p class="m-0 small" style="margin-bottom: .6rem;">
                        www.gptservices.com&nbsp;&nbsp;|&nbsp;&nbsp;direccioncomercial@gptservices.com</p>
                </td>
                <td align="center" width="20%" style="background-color: #000000;vertical-align:middle;">
                    <img src="" width="92%" />
                </td>
            </tr>
        </table>
    </footer>
    <main>
        <table width="100%" class="my-3">
            <tr style="text-align: right;">
                <td>
                    <table width="100%">
                        <tr style="text-align:left;">
                            <td>
                                <strong>Solicitante:</strong> {{ $requisicion->solicitante->nombre() }}
                            </td>
                        </tr>
                        <tr style="text-align:left;">
                            <td><strong>{{ $requisicion->solicitante->job->name }} -
                                    {{ $requisicion->solicitante->job->departamento->area->name }}</strong> </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr class="text-right" style="text-align: right;">
                            <td class="text-right" style="text-align: right;"><strong>Folio:</strong>{{ $requisicion->folio() }}</td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td valign="top" style="padding: 0px 10px 24px; width: 50%;">
                    <p class="mb-1"><b>Puesto solicitado:</b></p>
                    <p class="form-control">
                        {{ isset($requisicion->puesto_solicitado) ? $requisicion->puesto->name : $requisicion->puesto_nuevo }}
                    </p>
                    <p class="mb-1"><b>Motivo de la requisici&oacute;n:</b></p>
                    <p class="form-control">{{ $requisicion->motivo }}</p>
                    <p class="mb-1"><b>Personas requeridas:</b></p>
                    <p class="form-control">{{ $requisicion->personas_requeridas }}</p>
                </td>
                <td valign="top" style="padding: 0px 10px 24px; width: 50%;">
                    <p class="mb-1"><b>Tipo de personal:</b></p>
                    <p class="form-control">{{ $requisicion->tipo_personal }}</p>
                    <p class="mb-1"><b>Horario:</b></p>
                    <p class="form-control">{{ $requisicion->horario }}</p>
                </td>
            </tr>
            <tr>
                <td valign="top" style="padding: 0px 10px 24px; width: 50%;">
                    <div class="pdf-card">
                        <p class="mb-1"><b>&Uacute;ltimo grado de estudios:</b></p>
                        <p class="form-control">{{ $requisicion->grado_escolar }}</p>
                        <p class="mb-1"><b>A&ntilde;os de experiencia:</b></p>
                        <p class="form-control">{{ $requisicion->experiencia_years }}</p>
                        <p class="mb-1"><b>¿Se requiere licencia de conducir?</b></p>
                        <p class="form-control">{{ $requisicion->licencia_conducir == false ? 'No' : 'Si' }}</p>
                        @if ($requisicion->licencia_conducir == true)
                            <p class="mb-1"><b>¿Tipo de  licencia de conducir?</b></p>
                            <p class="form-control">{{ $requisicion->licencia_tipo }}</p>
                        @endif
                    </div>
                </td>
                <td valign="top" style="padding: 0px 10px 24px; width: 50%;">
                    <div class="pdf-card">
                        <p class="mb-1"><b>¿Realizará trabajo en campo?</b></p>
                        <p class="form-control">{{ $requisicion->trabajo_campo == false ? 'No' : 'Si' }}</p>
                        <p class="mb-1"><b>¿Tendrá trato con clientes o proveedores?</b></p>
                        <p class="form-control">{{ $requisicion->trato_clientes == false ? 'No' : 'Si' }}</p>
                        <p class="mb-1"><b>¿Deberá tener la capacidad para el manejo de personal?</b></p>
                        <p class="form-control">{{ $requisicion->manejo_personal == false ? 'No' : 'Si' }}</p>
                    </div>
                </td>
            </tr>
        </table>
        @if (!empty($requisicion->puesto_nuevo))
            {{-- Conocimientos --}}
            <table class="w-100 table table-sm table-striped pb-4 page-break-inside">
                <thead>
                    <tr class="table-active">
                        <th scope="col" colspan="2" class="p-1">Principales
                            conocimientos<br><small>Principales
                                conocimientos que deber&aacute; poseer el candidato</small></th>
                    </tr>
                    <tr>
                        <th scope="col" class="w-35 text-center" style="width: 35px;">No.</th>
                        <th scope="col" class="w-65">Concepto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requisicion->conocimientos as $conocimiento)
                        <tr>
                            <th scope="row" class="w-35 text-center" style="vertical-align:middle;">
                                <b>{{ $loop->iteration }}</b>
                            </th>
                            <td class="w-65">
                                <div class="form-control">{{ $conocimiento }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Competencias --}}
            <table class="w-100 table table-sm table-striped pb-4 page-break-inside">
                <thead>
                    <tr class="table-active">
                        <th scope="col" colspan="2" class="p-1">Competencias<br><small>Competencias que
                                deber&aacute; poseer el candidato</small></th>
                    </tr>
                    <tr>
                        <th scope="col" class="w-35 text-center" style="width: 35px;">No.</th>
                        <th scope="col" class="w-65">Concepto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requisicion->competencias as $competencia)
                        <tr>
                            <th scope="row" class="w-35 text-center" style="vertical-align:middle;">
                                <b>{{ $loop->iteration }}</b>
                            </th>
                            <td class="w-65">
                                <div class="form-control">{{ $competencia }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Actividades --}}
            <table class="w-100 table table-sm table-striped pb-4 page-break-inside">
                <thead>
                    <tr class="table-active">
                        <th scope="col" colspan="2" class="p-1">Principales
                            actividades<br><small>Principales actividades que va a realizar el candidato</small></th>
                    </tr>
                    <tr>
                        <th scope="col" class="w-35 text-center" style="width: 35px;">No.</th>
                        <th scope="col" class="w-65">Concepto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requisicion->actividades as $actividad)
                        <tr>
                            <th scope="row" class="w-35 text-center" style="vertical-align:middle;">
                                <b>{{ $loop->iteration }}</b>
                            </th>
                            <td class="w-65">
                                <div class="form-control">{{ $actividad }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
         <script type="text/php">
            if (isset($pdf)) {
                        $x = 530;
                        $y = 114;
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
    </main>

</body>

</html>
