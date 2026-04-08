<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RRHH</title>
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <style>
        body {
            background-color: #1C2127;
        }

        .contenido {
            width: 100%;
            padding-right: 40px;
            padding-left: 40px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .animacion {}

        .message {
            font-size: 30px;
            color: white;
            font-weight: 500;
        }

        .message2 {
            font-size: 18px;
            color: white;
            font-weight: 300;
            width: 360px;
        }

        .neon {
            text-align: center;
            width: 300px;
            margin-top: 30px;
            margin-bottom: 10px;
            font-family: 'Varela Round', sans-serif;
            font-size: 90px;
            color: #5BE0B3;
            letter-spacing: 3px;
            text-shadow: 0 0 5px #6EECC1;
            animation: flux 2s linear infinite;

        }

        .trash {
            width: 170px;
            height: 220px;
            background-color: #585F67;
            top: 300px;
        }

        .can {
            width: 190px;
            height: 30px;
            background-color: #6B737C;
            border-radius: 15px 15px 0 0;
        }

        .door-frame {
            height: 495px;
            width: 295px;
            border-radius: 90px 90px 0 0;
            background-color: #8594A5;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .door {
            height: 450px;
            width: 250px;
            border-radius: 70px 70px 0 0;
            background-color: #A0AEC0;
        }

        .eye {
            top: 15px;
            left: 25px;
            height: 5px;
            width: 15px;
            border-radius: 50%;
            background-color: white;
            animation: eye 7s ease-in-out infinite;
            position: absolute;
        }

        .eye2 {
            left: 65px;
        }

        .window {
            height: 40px;
            width: 130px;
            background-color: #1C2127;
            border-radius: 3px;
            margin: 80px auto;
            position: relative;
        }

        .leaf {
            height: 40px;
            width: 130px;
            background-color: #8594A5;
            border-radius: 3px;
            margin: 80px auto;
            animation: leaf 7s infinite;
            transform-origin: right;
        }

        .handle {
            height: 8px;
            width: 50px;
            border-radius: 4px;
            background-color: #EBF3FC;
            position: absolute;
            margin-top: 250px;
            margin-left: 30px;
        }

        .rectangle {
            height: 70px;
            width: 25px;
            background-color: #CBD8E6;
            border-radius: 4px;
            position: absolute;
            margin-top: 220px;
            margin-left: 20px;
        }

        @keyframes leaf {
            0% {
                transform: scaleX(1);
            }

            5% {
                transform: scaleX(0.2);
            }

            70% {
                transform: scaleX(0.2);
            }

            75% {
                transform: scaleX(1);
            }

            100% {
                transform: scaleX(1);
            }
        }

        @keyframes eye {
            0% {
                opacity: 0;
                transform: translateX(0)
            }

            5% {
                opacity: 0;
            }

            15% {
                opacity: 1;
                transform: translateX(0)
            }

            20% {
                transform: translateX(15px)
            }

            35% {
                transform: translateX(15px)
            }

            40% {
                transform: translateX(-15px)
            }

            60% {
                transform: translateX(-15px)
            }

            65% {
                transform: translateX(0)
            }
        }

        @keyframes flux {

            0%,
            100% {
                text-shadow: 0 0 5px #00FFC6, 0 0 15px #00FFC6, 0 0 50px #00FFC6, 0 0 50px #00FFC6, 0 0 2px #B9FFE8, 2px 2px 3px #12E29C;
                color: #4BFFEF;
            }

            50% {
                text-shadow: 0 0 3px #00B58D, 0 0 7px #00B58D, 0 0 25px #00B58D, 0 0 25px #00B58D, 0 0 2px #00B58D, 2px 2px 3px #006A60;
                color: #63D3AE;
            }
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="contenido">
            <div>
                <div class="message">No está autorizado.</div>
                <div class="message2">Ha intentado acceder a una página para la que no tenía autorización previa.
                </div>
                 <a class="btn btn-primary mt-3" href="{{ route('home') }}">VOLVER A LA PÁGINA DE INICIO</a>
            </div>
            <div class="animacion">
                <div class="neon">403</div>
                <div class="door-frame">
                    <div class="door">
                        <div class="rectangle">
                        </div>
                        <div class="handle">
                        </div>
                        <div class="window">
                            <div class="eye">
                            </div>
                            <div class="eye eye2">
                            </div>
                            <div class="leaf">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
