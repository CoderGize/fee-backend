<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Designer Registration</title>
</head>

<body>

    <h3>
        Hello {{ $designerData['Fname'] }},
    </h3>
    <h3>
        You have been added to the Fee Designer Program.
    </h3>
    <h5>Press the button below to finish the registration</h5>

    <a href="{{ $designerData['Link'] }}" class="btn btn-dark">
        Finish Registration
    </a>

    <h6 class="text-secondary text-sm">
        if the button is not working press this link
        <a href="{{ $designerData['Link'] }}">{{ $designerData['Link'] }}</a>
    </h6>
</body>

</html>
