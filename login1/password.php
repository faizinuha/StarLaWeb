<?php
session_start();

// Jika tidak ada ID pengguna yang diberikan, alihkan kembali ke halaman logout
if (!isset($_GET['id'])) {
     header("Location: ../profile/tampilan-logout.php");
     exit();
}

// Tangkap ID pengguna dari URL
$user_id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <style>
          /* CSS styling */
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
                              <form id="loginForm" action="proses_login2.php" method="post">
                                   <!-- Action menuju proses_login2.php -->
                                   <!-- Menyertakan ID pengguna sebagai input tersembunyi -->
                                   <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                   <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                                        <div class="invalid-feedback">Please enter your password.</div>
                                   </div>
                                   <button type="submit" class="btn btn-primary w-100">Login</button>
                                   <div class="mt-3 text-center">
                                        <span class="mx-2">|</span>
                                        <a href="forgot_reset_password.php" class="btn-link">Forgot Password?</a>
                                        <span class="mx-2">|</span>
                                   </div>
                              </form>
                              <!-- #region -->
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script>
          
     </script>
</body>

</html>