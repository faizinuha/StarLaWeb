<?php
// Ambil status login dari URL
$error = isset($_GET['login_error']) ? $_GET['login_error'] : '';
$login_success = isset($_GET['login_success']) ? $_GET['login_success'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <style>
     body {
          background-color: #f8f9fa;
     }

     .card {
          border: none;
          border-radius: 10px;
          box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
     }

     .card-header {
          background-color: #007bff;
          border-radius: 10px 10px 0 0;
          color: white;
     }

     .card-body {
          padding: 30px;
     }

     .form-label {
          font-weight: bold;
     }

     .btn-primary {
          background-color: #007bff;
          border: none;
          transition: all 0.3s ease;
     }

     .btn-primary:hover {
          background-color: #0056b3;
     }

     .btn-link {
          color: #007bff;
          text-decoration: none;
     }

     .btn-link:hover {
          text-decoration: underline;
     }
     </style>
</head>

<body>
     <div class="container mt-5">
          <div class="row justify-content-center">
               <div class="col-md-6">
                    <div class="card">
                         <div class="card-header text-center">
                              <h2 class="mb-0">Login</h2>
                         </div>
                         <div class="card-body">
                              <form id="loginForm" action="proses_login.php" method="post">
                                   <div class="mb-3">
                                        <label for="emailOrUsername" class="form-label">Username or Email</label>
                                        <input type="text" class="form-control" name="emailOrUsername"
                                             id="emailOrUsername" placeholder="Enter your Email!" required>
                                        <div class="invalid-feedback">Please enter your email or username.</div>
                                   </div>
                                   <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                             placeholder="Enter your password" required>
                                        <div class="invalid-feedback">Please enter your password.</div>
                                   </div>
                                   <button type="submit" class="btn btn-primary w-100">Login</button>
                              </form>
                              <div class="mt-3 text-center">
                                   <a href="register.php" class="btn-link">Register</a>
                                   <span class="mx-2">|</span>
                                   <a href="forgot_reset_password.php" class="btn-link">Forgot Password?</a>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script>
     function showLoginErrorAlert() {
          let error = '<?php echo $error; ?>';
          if (error === 'true') {
               Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo isset($_SESSION['login_error']) ? $_SESSION['login_error'] : ''; ?>',
                    footer: '<a href="forgot_reset_password.php">Forgot your password?</a>'
               });
          }
     }

     function showLoginSuccessAlert() {
          let loginSuccess = '<?php echo $login_success; ?>';
          if (loginSuccess === 'true') {
               Swal.fire({
                    title: "Good job!",
                    text: "You clicked the button!",
                    icon: "success"
               });
          }
     }

     // Show SweetAlert when page loads
     window.onload = function() {
          showLoginErrorAlert();
          showLoginSuccessAlert();
     };
     </script>

</body>

</html>