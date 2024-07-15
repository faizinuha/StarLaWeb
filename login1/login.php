<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash;</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../../assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link rel="stylesheet" href="../../assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="../asset/img/paimon-genshin-impact.avif" alt="logo" width="100" class="shadow-light ">
            </div>

            <!-- Login Error Message -->
            <?php if (isset($_GET['login_error'])) : ?>
              <div class="alert alert-danger" role="alert">Invalid email/username or password.</div>
            <?php endif; ?>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="proses_data/proses_login.php" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="emailOrUsername" class="form-label">Username or Email</label>
                    <div class="float-right">
                      <a href="register.php" class="text-small">
                        Register
                      </a>
                    </div>
                    <input type="text" class="form-control" name="emailOrUsername" id="emailOrUsername" placeholder="Enter Email or Username" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="form-label">Password</label>
                      <div class="float-right">
                        <a href="forgot_reset_password.php" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                      
                    </div>
                  </div>

                  <div class="form-group">
                  <div class="float-right">
                        <a href="../index.php" class="text-small" onclick="bahaya()">
                          Not Login?
                        </a>
                      </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
                <div class="text-center mt-4 mb-3">
                  <div class="text-job text-muted">Login With Social</div>
                </div>

                <div class="col-6">
                  <a class="btn btn-block btn-social btn-twitter">
                    <span class="fab fa-discord"></span> discord
                  </a>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
<!-- script -->
<script>
  function bahaya() {
    var aku;
    alert('Yakin gak mau Login😭 Nanti Gak ada Fitur Loh?');

    document.getElementById('aku').addEventListener('click',function(){
      windows.location.href ('register.php')
    })
  }
 // Disable form submissions if there are invalid fields
</script>
  <!-- General JS Scripts -->
  <script src="../assets/modules/jquery.min.js"></script>
  <script src="../assets/modules/popper.js"></script>
  <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>
</body>

</html>
