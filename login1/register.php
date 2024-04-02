<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #95a5a6;
            --background-color: rgba(255, 255, 255, 0.7);
            --button-hover-color: #2980b9;
            --button-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            max-width: 500px;
            margin: auto;
            margin-top: 5%;
            background-color: var(--background-color);
            border-radius: 10px;
            box-shadow: var(--button-shadow);
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--button-hover-color);
            border-color: var(--button-hover-color);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: var(--button-hover-color);
            border-color: var(--button-hover-color);
        }

        .progress-container {
            margin-top: 20px;
        }

        /* Style untuk progress bar */
        .progress {
            height: 10px;
            border-radius: 5px;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            transition: width 0.5s ease-in-out;
        }

        /* Style untuk tampilan kesalahan */
        .error-feedback {
            color: #dc3545;
            font-size: 0.8rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center font-monospace mb-4">Registrasi Pengguna</h2>
                <form id="registerForm" action="proses_register.php" method="post" novalidate>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" class="form-control" name="nama" required placeholder="Masukkan Nama">
                        <div class="error-feedback">Masukkan Nama.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" required placeholder="Masukkan Email">
                        <div class="error-feedback">Masukkan Email yang valid.</div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" name="username" required placeholder="Masukkan Username">
                        <div class="error-feedback">Masukkan Username.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" required placeholder="Masukkan Password">
                        <div class="error-feedback">Masukkan Password.</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button id="registerBtn" type="submit" class="btn btn-primary">Register</button>
                        <a href="login.php" class="btn btn-secondary">Login</a>
                    </div>
                </form>
                <div class="progress-container">
                    <div class="progress">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registerBtn').addEventListener('click', function() {
            var form = document.getElementById('registerForm');
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');

            // Reset progress bar
            document.getElementById('progressBar').style.width = '0%';

            // Style progress
            setTimeout(function() {
                document.getElementById('progressBar').style.width = '25%';
            }, 500);

            setTimeout(function() {
                document.getElementById('progressBar').style.width = '50%';
            }, 1000);

            setTimeout(function() {
                document.getElementById('progressBar').style.width = '75%';
            }, 1500);

            setTimeout(function() {
                document.getElementById('progressBar').style.width = '100%';
            }, 2000);

            // Reset form after submission
            setTimeout(function() {
                form.reset();
                form.classList.remove('was-validated');
                document.getElementById('progressBar').style.width = '0%';
            }, 2500);
        });
    </script>
</body>

</html>
