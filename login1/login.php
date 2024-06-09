<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0"></script>
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

          #particles-js {
               cursor: default !important;
               position: absolute;
               width: 100%;
               height: 100%;
               top: 0;
               left: 0;
               z-index: -1;
               /* Perubahan: z-index diturunkan agar di belakang elemen lain */
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
                                        <input type="text" class="form-control" name="emailOrUsername" id="emailOrUsername" placeholder="Enter your Email or Username" required>
                                        <div class="invalid-feedback">Please enter your email or username.</div>
                                   </div>
                                   <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
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
     <script>
    particlesJS.load('particles-js', 'particles-config.json', function() {
        console.log('particles.js loaded - callback');
    });
</script>

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+0pEd5eY1z4+cBB+z8V+W9CKMpYW4" crossorigin="anonymous"></script>
</body>

</html>