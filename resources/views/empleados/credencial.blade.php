<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="GPT Services">
    <title>Credencial {{ $empleado->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/pdf_credencial.css') }}">
</head>

<body>
    <section id="page1" class="page">
        <div class="cont w3-center">
            <img src="{{ $empleado->profile_image }}" alt="Avatar" class="user-photo w3-round">
            <div class="back w3-center w3-margin-top">
                <h1 class="first-name w3-text-white">{{ $empleado->last_name }}</h1>
                <h1 class="last-name w3-text-white">{{ $empleado->first_name }}</h1>
                <h2 class="job w3-text-white">{{ $empleado->job->name }}</h2>
            </div>
        </div>
        <div class="w3-modal"></div>
    </section>
    <section>
        <div id="page2" class="cont-b w3-center">
            <div class="back w3-center" style="margin-top:100px;">

                {{-- <h3 class="type-blood w3-text-white">
                    TIPO DE SANGRE: <span>O</span>
                </h3> --}}
                <h3 class="nss w3-text-white">
                    NSS:<span>{{ $empleado->personalData->nss }}</span>
                </h3>
                <h3 class="curp w3-text-white">
                    CURP:<span>{{ $empleado->personalData->curp }}</span>
                </h3>
                <div class="w3-center qr-code" style="width:100%;">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(256)->generate($url)) !!} ">
                </div>
                <p class="validity w3-text-white">VIGENCIA:<br><span>{{ $vigencia }}</span></p>
                <p class="num-emp w3-text-white">NÚMERO DE EMPLEADO: <span>{{ $empleado->id }}</span></p>
                <div style="padding:0px 40px;">
                    @if ($empleado->razonSocial->id <= 2)
                    <p class="text w3-text-white" style="text-align:justify;">
                        ESTA CREDENCIAL ACREDITA AL PORTADOR COMO EMPLEADO AL SERVICIO EXCLUSIVO DE {{ $empleado->razonSocial->name }}, NO CONSTITUYE UN DOCUMENTO LABORAL CON LAS EMPRESAS TITULARES DE LOS DERECHOS AL USO DE LA MARCA, IMAGEN O SÍMBOLOS DISTINTIVOS QUE APARECEN EN ELLA, SUS FILIALES SUBSIDIARIAS O PARTES RELACIONADAS Y NO GENERA NINGÚN VÍNCULO LABORAL ENTRE EL PORTADOR Y LA EMPRESA QUE SE MUESTRA EN ESTA CREDENCIAL
                    </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="w3-modal"></div>
    </section>
</body>

</html>
