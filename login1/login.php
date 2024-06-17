<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #e9ecef;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #17a2b8;
            border-radius: 15px 15px 0 0;
            color: white;
            text-align: center;
        }
        .card-body {
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Login</h2>
                    </div>
                    <div class="card-body">
                        <form id="loginForm" action="proses_data/proses_login.php" method="post">
                            <div class="mb-3">
                                <label for="emailOrUsername" class="form-label">Username or Email</label>
                                <input type="text" class="form-control" name="emailOrUsername" id="emailOrUsername" placeholder="Enter Email or Username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
                            </div>
                            <p class="text-center">Forgot code? Contact Customer Service</p>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="register.php" class="btn-link">Register</a>
                            <span class="mx-2">|</span>
                            <a href="forgot_reset_password.php" class="btn-link">Forgot Password?</a>
                            <span class="mx-2">|</span>
                            <a href="javascript/kontak.php">Customer Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert Script -->
    <script>
        // Check if there's an error message passed via URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const loginError = urlParams.get('login_error');

        // Function to show SweetAlert
        function showAlert(icon, title, text) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        }

        // Show appropriate alert based on login error
        if (loginError) {
            showAlert('error', 'Login Error', 'Invalid email/username or password.');
        }
    </script>
</body>
</html>
