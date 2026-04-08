<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Cumpleaños</title>
</head>

<body style="background-color: #f5f7fb;">
    <div class="container">
        <div class="align-items-center justify-content-center row vh-100 d-flex">
            <div class="col-lg-10 col-md-12">
                <div class="shadow-lg card">
                    <div class="row g-0">
                        <div class="col-md-6 col-sm-12 col-xs-12 d-flex justify-content-center align-items-center">

                            <img src="{{ asset('assets/images/birthday_fondo.png') }}" class="img-fluid rounded-start"
                                alt="birthday">

                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="text-center card-body">
                                <h5 class="card-title fs-1">¡Muchas felicidades!</h5>
                                <h4 class="my-4 text-danger">{{ $user->nombre() }}</h4>
                                <p class="fs-4 fw-light">Las palabras no pueden sustituir un abrazo, pero sirven para
                                    hacerte llegar nuestros mejores deseos en este día tan especial.</p>
                                <p class="fs-5"><strong class="text-muted">Con cariño tu familia de GPT
                                        Services&#174;</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->

    <script type="module">
        import confetti from "https://cdn.skypack.dev/canvas-confetti";
        const doItNow = (evt, hard) => {
            const direction = Math.sign(lastX - evt.clientX);
            lastX = evt.clientX;
            const particleCount = hard ? r(122, 245) : r(2, 15);
            confetti({
                particleCount,
                angle: r(90, 90 + direction * 30),
                spread: r(45, 80),
                origin: {
                    x: evt.clientX / window.innerWidth,
                    y: evt.clientY / window.innerHeight
                }
            });
        };
        const doIt = (evt) => {
            doItNow(evt, false);
        };

        const doItHard = (evt) => {
            doItNow(evt, true);
        };

        let lastX = 0;

        const butt = document.querySelector("body");
        butt.addEventListener("mousemove", doIt);
        butt.addEventListener("click", doItHard);

        function r(mi, ma) {
            return parseInt(Math.random() * (ma - mi) + mi);
        }
    </script>
</body>

</html>
