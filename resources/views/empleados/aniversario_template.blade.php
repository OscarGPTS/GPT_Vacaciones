<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Aniversario</title>
    <style>
        @page {
            margin: 0;
            padding: 30px;
        }

        @font-face {
            font-family: 'Dancing Script';
            src: url({{ storage_path('fonts/DancingScript-Regular.ttf') }}) format("truetype");
        }

        * {
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            height: 100%;
            background-image: url({{ asset('aniversario/fondo.png') }});
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            text-align: center;
        }

        .empleado {
            text-align: center;
            margin: 0 140px;
        }

        .aniversario-numero {
            background-color: #ffffff;
            width: 2000px;
            margin-top: 600px;
        }

        .nombre {
            margin-top: 100px;
            margin-bottom: 200px;
            font-family: 'Dancing Script', cursive;
            font-size: 300px;
            line-height: 80%;
        }

        .depto {
            font-family: Arial, sans-serif;
            font-style: italic;
            font-size: 130px;
        }

        .aniversario {
            font-family: Arial, sans-serif;
            font-size: 130px;
            font-weight: bold;
        }

        .mensaje {
            font-family: Arial, sans-serif;
            font-style: italic;
            margin: 200px 0;
            font-size: 100px;
            padding: 0 50px;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div class="container" style="position: relative">
        <img src="{{ $empleado['imagen'] }}" alt="aniversario-numero" class="aniversario-numero">
        <div class="empleado">
            <p class="nombre">{{ $empleado['nombre'] }}</p>
            <p class="depto">{{$empleado['departamento']}}</p>
            <p class="mensaje">Un año más nos encuentra celebrando éxitos y experiencias compartidas, agradecemos tu
                dedicación y compromiso.<br> ¡Es un gusto contar contigo en la organización!</p>
            <p class="aniversario"> ¡Feliz Aniversario!</p>
        </div>
    </div>
</body>

</html>
