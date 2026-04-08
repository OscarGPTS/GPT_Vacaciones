<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            padding-top: 30px;
        }

        * {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            text-align: justify;
        }

        .encabezado {
            text-align: right;
            padding-top: 40px;
            padding: 30px 30px 0 0;
        }

        .titulo {
            padding: 150px 80px 0 80px;
            text-align: center;
        }

        .nombre {
            font-weight: bold;
            font-size: 20px;
            padding: 120px 80px 20px 80px;
            text-decoration: underline;
        }

        .texto {
            padding: 10px 80px 0 80px;
        }

        .firma {
            text-align: center;
            padding: 120px 100px 0 100px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .firma_nombre {
            border-top: 1px solid black;
        }

        .cell-1 {
            text-align: center;
            width: 50%;
        }

        .cell-2 {
            width: 50%;
        }

        .firma_img> {
            width: 100%;
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
            bottom: 0;
            left: 0;
            right: 0;
            height: 400px;
        }

        .footer_img {
            width: 300px;
            height: 330px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .footer_text {
            position: absolute;
            bottom: 0;
            right: 50px;
            width: 440px;
            padding-bottom: 40px;
            font-size: 14.5px;
            text-align: justify;
        }

        .header_logo {
            margin: 30px 0 0 30px;
            width: 200px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ asset('certificado/logo.jpg') }}" class="header_logo">
    </header>
    <footer>
        <img class="footer_img" src="{{ asset('certificado/footer.png') }}">
        <span class="footer_text">Toda la documentación que avala el presente certificado se encuentra en los expedientes
            de <strong>Tech Energy Control S.A. de C.V.</strong>
            Este documento no será válido sin firma y sello. Está prohibido la reproducción parcial o total de este
            documento sin la autorización escrita de <strong>GPT Services&#174;</strong> </span>
    </footer>

    <div class="container">
        <div class="encabezado">
            <p><strong>No. De Certificado:</strong> {{ $folio }}
            </p>
            <p>Tlalnepantla de Baz, Estado de México, a 16 de septiembre 2025</p>
            <p><strong>Vigencia:</strong>16 de septiembre de 2026</p>
        </div>
        <div class="titulo">
            <p>Tech Energy Control S.A. de C.V.</p>
            <p>GPT Services&#174;</p>
            <p style="margin-top:20px;">Emite el presente certificado a:</p>
        </div>
        <div class="nombre">
            <center>
                <p> {{ $user->nombre() }}</p>
            </center>
        </div>
        <p class="texto">
            @if ($user->id == 270)
                Por haber concluido satisfactoriamente el programa de capacitación y entrenamiento de operación y
                mantenimiento de equipos, con grado de: <strong>"Técnico Especialista en HT & LS Nivel III '</strong>.
            @elseif ($user->id == 50)
                Por haber concluido satisfactoriamente el programa de capacitación y entrenamiento para <strong>"Técnico
                    Especialista en HT & LS Nivel II"</strong> para la realización de servicios “Hot Tapping & Line
                Stopping” en
                alcance de <strong>perforaciones de ½” hasta 24” – Obturaciones de 2” hasta 20”</strong>. Basado en los
                requerimientos
                del API 2201 SAFE HOT TAPPING PRACTICES IN THE PETROLEUM & PETROCHEMICAL INDUSTRIES SECCIÓN 8.3'.
            @elseif ($user->id == 205||$user->id == 212 || $user->id == 157)
                Por haber concluido satisfactoriamente el programa de capacitación y entrenamiento para <strong>"Técnico
                Especialista en HT & LS Nivel I"</strong> para la realización de servicios “Hot Tapping & Line Stopping” <strong>en
                alcance de perforaciones de ½” hasta 12” - (No se permite la ejecución de obturaciones)</strong>. Basado en los
                requerimientos del API 2201 SAFE HOT TAPPING PRACTICES IN THE PETROLEUM & PETROCHEMICAL INDUSTRIES
                SECCIÓN 8.3'.
            @else
                Por haber concluido satisfactoriamente el programa de capacitación y entrenamiento para
                <strong>"{{ $user->job->name }}"</strong> para la realización de servicios <strong>“Hot Tapping & Line
                    Stopping”</strong>
                @if (filled($user->CertificadoCv->alcance))
                    {{ $user->CertificadoCv->alcance }}
                @else
                    en alcances desde ½” hasta 48” de diámetro
                @endif
                Basado en los requerimientos del API2201 SAFE HOT TAPPING PRACTICES
                IN THE PETROLEUM & PETROCHEMICAL INDUSTRIES SECCIÓN 8.3.
            @endif
        </p>
        <div class="firma">
            @if ($user->id !== 22)
                <table class="table">
                    <tr>
                        <td class="cell-1" ALIGN=RIGHT VALIGN=BOTTOM>
                            <div class="firma_img">
                                <img src="{{ asset('certificado/firma_ivan.png') }}" alt="qr">
                            </div>
                        </td>
                        <td class="cell-2" ALIGN=CENTER VALIGN=BOTTOM>
                            <img src="{{ $qr }}" alt="qr">
                            <p>Historial de servicios</p>
                        </td>
                    </tr>
                </table>
            @else
                <table class="table">
                    <tr>
                        <td class="cell-1" ALIGN=RIGHT VALIGN=BOTTOM>
                            <div class="firma_nombre">
                                Agustín Antonio Briceño Martínez Técnico Máster Internacional
                            </div>
                        </td>
                        <td class="cell-2" ALIGN=CENTER VALIGN=BOTTOM>
                            <img src="{{ $qr }}" alt="qr">
                            <p>Historial de servicios</p>
                        </td>
                    </tr>
            @endif
        </div>
    </div>
</body>

</html>
