<html>

<head>
    <meta name="author" content="GPT Services">
    <title>Requisición de curso</title>
    <link rel="stylesheet" href="{{ asset('assets/css/pdf_puesto.css') }}">
    <style>
        .history{
            font-size: 10px;
        }
    </style>
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
                <th scope="col" colspan="6" class="p-0 mt-1"> <small><b>REQUISICIÓN DE CURSO</b></small> </th>
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
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>0</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>jul 18</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>Recursos Humanos</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>FO-GPT-RH-02-C</small></td>
                <td scope="col" class="p-0" style="vertical-align:middle;"><small>&nbsp;</small></td>
            </tr>
        </table>
    </header>
    <footer id="pdf-footer">
        <table class="table p-0 table-sm">
            <tr>
                <td width="80%" style="background-color: #5b5a5f; color: #ffffff;">
                    <p class="m-0 font-weight-bold font-italic">TECH ENERGY CONTROL, S.A. DE C.V.</p>
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
                                <strong>Solicitante:</strong> {{ $solicitante->nombre() }}
                            </td>
                        </tr>
                        <tr style="text-align:left;">
                            <td><strong> Puesto -
                                    {{ $solicitante->job->name }} </strong> </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr class="text-right" style="text-align: right;">
                            <td class="text-right" style="text-align: right;"><strong>Folio:</strong>
                                {{ $requisicion->id }} </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td valign="top" style=" width: 50%;">
                    <p class="mb-1"><b>Fecha de solicitud:</b></p>
                    <p class="form-control">
                        {{ $requisicion->created_at->format('d-m-Y') }}
                    </p>
                    <p class="mb-1"><b>Nombre del curso:</b></p>
                    <p class="form-control">{{ $requisicion->nombre }}</p>
                </td>
                <td valign="top" style=" width: 50%;">
                    <p class="mb-1"><b>Tipo de capacitacion:</b></p>
                    <p class="form-control"> {{ $requisicion->tipo_capacitacion }}</p>
                    <p class="mb-1"><b>Motivo:</b></p>
                    <p class="form-control"> {{ $requisicion->motivo }} </p>
                </td>
            </tr>
        </table>

        @if (filled($participantes))
            <table width="100%" class="my-3">
                <thead>
                    <tr>
                        <th scope="col" style="text-align: left;">Participantes:</small></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($participantes as $participante)
                        <tr>
                            <td>
                                <div class="form-control"> {{ $participante->nombre() }} </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <table width="100%" class="my-3">
            <tr>
                <td valign="top">
                    <p class="mb-1"><b>Beneficios:</b></p>
                    <p class="mb-1 form-control">
                        {{ $requisicion->beneficio }}
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <p class="mb-1"><b>Justificacion:</b></p>
                    <p class="mb-1 form-control">
                        {{ $requisicion->justificacion }}
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <p class="mb-1"><b>Comentarios:</b></p>
                    <p class="mb-1 form-control">
                        {{ $requisicion->comentarios }}
                    </p>
                </td>
            </tr>
        </table>
        <div>
            <p class="pb-1 m-0">Historial</p>
            <table style="border: 1px solid black;border-collapse: collapse;width: 100%;" class="history">
                <thead>
                    <tr>
                        <th  class="p-1" style="border: 1px solid black;border-collapse: collapse;">
                            Fecha
                        </th>
                        <th  class="p-1" style="border: 1px solid black;border-collapse: collapse;">
                            Desde
                        </th>
                        <th  class="p-1" style="border: 1px solid black;border-collapse: collapse;">
                            Hasta
                        </th>
                        <th  class="p-1" style="border: 1px solid black;border-collapse: collapse;">
                            Responsable
                        </th>
                        <th  class="p-1" style="border: 1px solid black;border-collapse: collapse;">
                            Observaciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requisicion->status()->history()->get() as $item)
                        <tr>
                            <th style="border: 1px solid black;border-collapse: collapse;"  class="p-1">
                                {{ $item->created_at->isoFormat('LL') }}
                            </th>
                            <td style="border: 1px solid black;border-collapse: collapse;"  class="p-1">
                                {{ $item->from }}
                            </td>
                            <td style="border: 1px solid black;border-collapse: collapse;"  class="p-1">
                                {{ $item->to }}
                            </td>
                            <td style="border: 1px solid black;border-collapse: collapse;"  class="p-1">
                                {{ $item->responsible->nombre() }}
                            </td>
                            <td style="border: 1px solid black;border-collapse: collapse;"  class="p-1">
                                @if (isset($item->custom_properties['observaciones']))
                                    {{ $item->custom_properties['observaciones'] }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
