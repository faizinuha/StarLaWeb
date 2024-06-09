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

     .form-label {
          font-weight: bold;
     }

     .form-control {
          border-radius: 8px;
     }

     .btn-primary {
          background-color: #17a2b8;
          border: none;
          border-radius: 8px;
          transition: all 0.3s ease;
     }

     .btn-primary:hover {
          background-color: #138496;
     }

     .btn-link {
          color: #17a2b8;
          text-decoration: none;
     }

     .btn-link:hover {
          text-decoration: underline;
     }

     @media (max-width: 767px) {
          .card {
               margin: 0 10px;
          }

          .card-body {
               padding: 20px;
          }
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
                              <form id="loginForm" action="proses_login.php" method="post" onsubmit="return validateForm()">
                                   <div class="mb-3">
                                        <label for="emailOrUsername" class="form-label">Username or Email</label>
                                        <input type="text" class="form-control" name="emailOrUsername"
                                             id="emailOrUsername" placeholder="Enter your Email or Username" required>
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
     <!-- <script>
     function validateForm() {
          const emailOrUsername = document.getElementById('emailOrUsername').value;
          const password = document.getElementById('password').value;

          if (emailOrUsername === '' || password === '') {
               Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill in both the email/username and password fields.',
               });
               return false;
          }

          return true;
     }

     // Function to show SweetAlert if there's a login error
     function showLoginErrorAlert() {
          let error = '<?php echo isset($_GET['login_error']) ? $_GET['login_error'] : ''; ?>';
          if (error === 'true') {
               Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo isset($_SESSION['login_error']) ? $_SESSION['login_error'] : ''; ?>',
                    footer: '<a href="forgot_reset_password.php">Forgot your password?</a>'
               });
          }
     }

     // Show SweetAlert when page loads
     window.onload = function() {
          showLoginErrorAlert();
     };
     </script> -->
</body>

</html>
