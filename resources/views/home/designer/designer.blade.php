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

    @if (session()->has('error'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast show bg-danger text-white" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="toast-body">
                    <div class="d-flex justify-content-between">
                        {{ session()->get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container bg-green d-block m-auto rounded rounded-5">

        <div class="container">
            <div class="row w-75 m-auto p-3">

                <div class="col-12 col-sm-6 text-center">
                    <img src="/fee-logo/1.png" class="w-50 m-auto" alt="">
                </div>

                <div class="col-12 col-sm-6 mt-3 mt-sm-0 d-flex align-items-center">
                    <h1 class="fw-bold text-light">Enter new password to complete registration!</h1>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12 text-start my-3 px-5">

                <form id="passwordForm" method="POST" action="{{url('submit-designer/' . $hashed_id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-5">

                        <div class="col-12 text-center">
                        <div class="w-sm-50 w-100 m-auto">
                                <label class="form-label text-center text-light">Profile Image</label>
                                <input type="file" name="img" class="form-control form-control-lg text-dark rounded border border-0 rounded-5 bg-light" required>
                        </div>
                        </div>

                    </div>

                    <div class="row mt-5">

                            <div class="col-12 col-sm-6 text-center">
                                <label class="form-label text-center text-light">First Name</label>
                                <input type="text" class="form-control form-control-lg text-white rounded border border-0 rounded-5 bg-secondary" value="{{$designer->f_name}}" readonly>
                            </div>

                            <div class="col-12 col-sm-6 text-center">
                                <label class="form-label text-center text-light">Last Name</label>
                                <input type="text" class="form-control form-control-lg text-white rounded border border-0 rounded-5 bg-secondary" value="{{$designer->l_name}}" readonly>
                            </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-12 col-sm-6 text-center">
                            <label class="form-label text-center text-light">Email</label>
                            <input type="text" class="form-control form-control-lg text-white rounded border border-0 rounded-5 bg-secondary" value="{{$designer->email}}" readonly>
                        </div>

                        <div class="col-12 col-sm-6 text-center">
                            <label class="form-label text-center text-light">Username</label>
                            <input type="text" class="form-control form-control-lg text-white rounded border border-0 rounded-5 bg-secondary" value="{{$designer->username}}" readonly>
                        </div>

                    </div>


                    <div class="row mt-3">
                        <div class="col-12 col-sm-6 text-center position-relative">
                            <label class="form-label text-center text-light">Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg text-dark rounded border border-0 rounded-5 bg-light" placeholder="Enter Password" required>
                        </div>

                        <div class="col-12 col-sm-6 text-center position-relative">
                            <label class="form-label text-center text-light">Verify Password</label>
                            <input type="password" id="verifyPassword" class="form-control form-control-lg text-dark rounded border border-0 rounded-5 bg-light" placeholder="Verify Password" required>
                            <span id="passwordIcon" class="position-absolute top-50 end-0 translate-middle-y me-3"></span> <!-- Icon for feedback -->
                        </div>
                    </div>
                    <div class="col-12 mt-3 text-center">
                        <button type="submit" class="btn btn-dark boutton mt-3 btn-lg">Submit</button>
                        <p id="error-message" class="text-danger mt-3" style="display: none;">Passwords do not match!</p>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <script>
        // Function to check if passwords match and show icon
        function checkPasswords() {
            var password = document.getElementById('password');
            var verifyPassword = document.getElementById('verifyPassword');
            var errorMessage = document.getElementById('error-message');
            var passwordIcon = document.getElementById('passwordIcon');

            // Check if passwords match
            if (password.value !== verifyPassword.value) {
                password.classList.add('is-invalid');
                verifyPassword.classList.add('is-invalid');
                errorMessage.style.display = 'block';  // Show error message

                // Set the icon to a red "X"
                passwordIcon.innerHTML = '<i class="fas fa-times text-danger"></i>';
            } else {
                password.classList.remove('is-invalid');
                verifyPassword.classList.remove('is-invalid');
                errorMessage.style.display = 'none';  // Hide error message

                // Set the icon to a green check
                passwordIcon.innerHTML = '<i class="fas fa-check text-success"></i>';
            }
        }

        // Add real-time validation
        document.getElementById('verifyPassword').addEventListener('input', checkPasswords);
        document.getElementById('password').addEventListener('input', checkPasswords);

        // Prevent form submission if passwords don't match
        document.getElementById('passwordForm').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var verifyPassword = document.getElementById('verifyPassword').value;
            if (password !== verifyPassword) {
                event.preventDefault();  // Prevent form submission
                alert("Passwords do not match!");  // Optional small alert message
            }
        });

    </script>

    <style>
        .is-invalid {
            border-color: red !important;
        }
    </style>
</body>
</html>
