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
<style>
    #myModal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0,0,0);
      background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }
    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
</style>
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
                      <a href="#" class="text-small" onclick="bahaya(); return false;">
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
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <p>Yakin gak mau Login😭 Nanti Gak ada Fitur Loh?</p>
      <button id="registerBtn">Register</button>
      <button id="okBtn">OK</button>
    </div>
  </div>
  <!-- script -->
  <script>
  function bahaya() {
    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    var registerBtn = document.getElementById("registerBtn");
    var okBtn = document.getElementById("okBtn");

    // Tampilkan modal
    modal.style.display = "block";

    // Ketika pengguna klik pada tombol Register
    registerBtn.onclick = function() {
      window.location.href = 'register.php';
    }

    // Ketika pengguna klik tombol OK
    okBtn.onclick = function() {
      modal.style.display = "none";
    }

    // Ketika pengguna klik di luar modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // Ketika pengguna tekan tombol Esc
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  }
</script>
  <!-- General JS Scripts -->
  <script src="../assets/modules/jquery.min.js"></script>
  <script src="../assets/modules/popper.js"></script>
  <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>
</body>

</html>