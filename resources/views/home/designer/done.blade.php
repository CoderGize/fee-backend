<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Designer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        :root {
            --main-color: #4c6042;
        }

        .bg-green {
            background-color: var(--main-color);
        }

        .boutton
        {
            width: 300px;
            height: 75px;
            border-radius: 75px
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-dark p-2 p-sm-0" style="max-height: 100vh !important;">

    <div class="container bg-green d-block m-auto rounded rounded-5">

        <div class="container">
            <div class="row m-auto p-3">

                <div class="col-12 text-center mb-5">
                    <img src="/fee-logo/1.png" class="w-25 m-auto" alt="">
                </div>

                <div class="col-12 mt-5 mt-sm-0 text-center">
                    <h1 class="fw-bold text-center text-light">
                        Welcome to the Family!
                    </h1>
                </div>

                <div class="col-12 mt-5 mb-3">
                    <a href="{{env('WEBSITE_LINK')}}" class="m-auto d-flex justify-content-center align-items-center btn btn-dark boutton">
                        Go To Website
                    </a>
                </div>

            </div>
        </div>

    </div>


    <style>
        .is-invalid {
            border-color: red !important;
        }
    </style>
</body>
</html>
