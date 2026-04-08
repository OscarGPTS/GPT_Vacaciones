<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="GPT Services">
    <title>Credencial</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/pdf_credencial.css') }}">
    <style>
        @page {
            size: 210mm 335mm portrait;
            margin: 0;
            padding: 0;
        }

        * {
            font-family: "Roboto", "Source Sans Pro", sans-serif;
        }

        .container_num {
            width: 60%;
            height: 70%;
            border: 10px solid;
            background-color: #c8102e;
            border-color: transparent #f6be00 #f6be00 transparent;
            border-radius: 0 0 100px 0;
            position: relative;
        }

        .num {
            color: #ffffff;
            margin: 0;
            letter-spacing: -1px;
            font-size: 400px;
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .title {
            color: #ffffff;
            font-weight: bold;
            margin: 0;
            font-size: 70px;
            position: absolute;
            top: 85%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .title_2 {
            color: #00000;
            font-weight: bold;
            writing-mode: vertical-lr;
            margin: 0;
            font-size: 100px;
            position: absolute;
            top: 30%;
            left: 95%;
            transform: rotate(90deg);
        }

        .logo {
            width: 400px;
            position: absolute;
            bottom: -310px;
            left: 68%;
        }

        .page-break {
            page-break-after: always;
        }

        .container {
            text-align: left;
            font-size: 30px;
            padding: 100px 50px;
        }
    </style>
</head>

<body>
    {{-- <div class="container_num">
        <p class="num"></p>
        <p class="title_2">VISITAS</p>
        <img src="https://res.cloudinary.com/gpt-services/image/upload/v1677776233/logotipo_GPT-HD_kavejf.png"
            class="logo" alt="">
    </div> --}}
    {{--
    <div class="page-break"></div>
    <div class="container_num">
        <p class="num">10</p>
        <p class="title">Visitas</p>
        <p class="title_2">ESTACIONAMIENTO</p>
        <img src="https://res.cloudinary.com/gpt-services/image/upload/v1677776233/logotipo_GPT-HD_kavejf.png"
        class="logo" alt="">
    </div>
    <div class="page-break"></div>
    <div class="container_num">
        <p class="num">10</p>
        <p class="title">Flotilla</p>
        <p class="title_2">ESTACIONAMIENTO</p>
        <img src="https://res.cloudinary.com/gpt-services/image/upload/v1677776233/logotipo_GPT-HD_kavejf.png"
            class="logo" alt="">
    </div> --}}

    <div class="container">
        <div style="text-align:center;">
            <strong>Políticas de acceso</strong>
        </div>

        <ol>
            <li>Transitar por pasos peatonales o vehiculares señalizados según sea el caso </li>
            <li>Para cualquier vehículo, no rebasar el límite de velocidad de 10 kmh </li>
            <li>Utilizar los espacios de estacionamiento o lugares asignados para los vehículos </li>
            <li>Queda prohibido tirar basura, cualquier tipo de sustancias u otros materiales en tambos no identificados </li>
            <li>No tomar fotografías ni video </li>
            <li>Prohibido fumar</li>
            <li>Ingerir alimentos solo áreas permitidas </li>
            <li>Queda prohibido, dañar o usar incorrectamente las instalaciones </li>
            <li>Portar el EEP en todo momento dentro del área operativa</li>
            <li>Prohibido bloquear pasos de acceso establecidos</li>
        </ol>
    </div>

</body>

</html>
