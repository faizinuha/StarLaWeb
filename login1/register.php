  <?php
  session_start();
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Register &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../assets/modules/jquery-selectric/selectric.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/components.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() { dataLayer.push(arguments); }
      gtag('js', new Date());
      gtag('config', 'UA-94034622-3');
    </script>
  </head>

  <body>
    <div id="app">
      <section class="section">
        <div class="container mt-5">
          <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
              <div class="login-brand">
                <img src="../asset/img/Lumine.jpeg" alt="logo" width="100" class="shadow-light rounded-circle">
              </div>

              <div class="card card-primary">
                <div class="card-header">
                  <h5 style="color: blue; text-decoration: underline;">Register</h5>
                </div>

                <div class="card-body">
                  <form id="registerForm" method="POST" action="proses_data/proses_register.php">
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama" autofocus>
                      </div>
                      <div class="form-group col-6">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" name="username" placeholder="Masukkan Username">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="email" class="form-label">Email:</label>
                      <input type="email" class="form-control" name="email" placeholder="Masukkan Email">
                    </div>

                    <div class="row">
                      <div class="form-group col-6">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan Password" minlength="6">
                      </div>
                      <div class="form-group col-6">
                        <label class="form-label">&nbsp;</label>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="showPassword">
                          <label class="form-check-label" for="showPassword">
                            Show Password
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-6">
                        <button id="registerBtn" type="submit" class="btn btn-primary btn-block">Register</button>
                      </div>
                      <div class="form-group col-6">
                        <a href="login.php" class="btn btn-secondary btn-block">Login</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- General JS Scripts -->
    <script src="../assets/modules/jquery.min.js"></script>
    <script src="../assets/modules/popper.js"></script>
    <script src="../assets/modules/tooltip.js"></script>
    <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="../assets/modules/moment.min.js"></script>
    <script src="../assets/js/stisla.js"></script>

    <!-- JS Libraries -->
    <script src="../assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="../assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

    <!-- Template JS File -->
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/custom.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      $(document).ready(function() {
        $('#registerForm').on('submit', function(event) {
          event.preventDefault(); // Prevent the default form submission

          let nama = $('input[name="nama"]').val().trim();
          let username = $('input[name="username"]').val().trim();
          let email = $('input[name="email"]').val().trim();
          let password = $('input[name="password"]').val().trim();

          let isValid = true;

          if (nama === "") {
            $('input[name="nama"]').addClass('is-invalid');
            isValid = false;
          } else {
            $('input[name="nama"]').removeClass('is-invalid').addClass('is-valid');
          }

          if (username === "") {
            $('input[name="username"]').addClass('is-invalid');
            isValid = false;
          } else {
            $('input[name="username"]').removeClass('is-invalid').addClass('is-valid');
          }

          if (email === "") {
            $('input[name="email"]').addClass('is-invalid');
            isValid = false;
          } else if (!validateEmail(email)) {
            $('input[name="email"]').addClass('is-invalid');
            isValid = false;
          } else {
            $('input[name="email"]').removeClass('is-invalid').addClass('is-valid');
          }

          if (password === "") {
            $('input[name="password"]').addClass('is-invalid');
            isValid = false;
          } else if (password.length < 6) {
            $('input[name="password"]').addClass('is-invalid');
            isValid = false;
          } else {
            $('input[name="password"]').removeClass('is-invalid').addClass('is-valid');
          }
        });

        $('#showPassword').on('change', function() {
          let passwordField = $('input[name="password"]');
          let type = $(this).is(':checked') ? 'text' : 'password';
          passwordField.attr('type', type);
        });

        function validateEmail(email) {
          const re = /^(([^<>()\[\]\.,;:\s@"]+(\.[^<>()\[\]\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\.,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,})$/i;
          return re.test(String(email).toLowerCase());
        }

        <?php if (isset($_SESSION['registration_success'])): ?>
          Swal.fire({
            title: "Good job!",
            text: "Registrasi berhasil. Kode konfirmasi Anda adalah: <?php echo $_SESSION['verification_code']; ?>. Mohon di jaga kode tersebut.",
            icon: "success"
          }).then(function() {
            window.location.href = "login.php";
          });
          <?php 
          unset($_SESSION['registration_success']);
          unset($_SESSION['verification_code']); 
          ?>
        <?php endif; ?>
      });
    </script>
  </body>

  </html>
