<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #3498db;
      --secondary-color: #95a5a6;
      --background-color: rgba(255, 255, 255, 0.7);
      --button-hover-color: #2980b9;
      --button-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      --gradient-bg: linear-gradient(135deg, #81c784, #64b5f6);
    }

    body {
      font-family: 'Roboto', sans-serif;
      background: var(--gradient-bg);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .card {
      max-width: 500px;
      background-color: var(--background-color);
      border-radius: 10px;
      box-shadow: var(--button-shadow);
      padding: 20px;
      margin: 20px;
      animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    .form-label {
      font-weight: bold;
    }

    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: var(--button-hover-color);
      border-color: var(--button-hover-color);
    }

    .btn-secondary {
      background-color: var(--secondary-color);
      border-color: var(--secondary-color);
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-secondary:hover {
      background-color: var(--button-hover-color);
      border-color: var(--button-hover-color);
    }

    .spinner {
      margin: 20px auto;
    }

    .error-feedback {
      color: #dc3545;
      font-size: 0.8rem;
      display: none;
    }

    .was-validated .error-feedback {
      display: block;
    }
    .img{
      position: absolute;
      right: 300px;
      width: 500px;
      top: 200px;
    }
    .regi{
      position: relative;
      left: 230px ;
      top: -90px;
      font-size: 20px;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    .image{
      position: relative;
      top: var(--background-color);
      top: 30px;
      left: 20px;
    }
  </style>
</head>

<body>
<div class="img-thumbnail img">
<img class="image" src="../assets/img/com.nexon.bluearchive.png" >
<p class="regi">Selamat datang di Register</p>
</div>
  <div class="container">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title text-center font-monospace mb-4">Registrasi Pengguna</h2>
        <form id="registerForm" action="proses_register.php" method="post" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nama" class="form-label">Nama:</label>
              <input type="text" class="form-control" name="nama" required placeholder="Masukkan Nama">
              <div class="error-feedback">Masukkan Nama.</div>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" name="email" required placeholder="Masukkan Email">
              <div class="error-feedback">Masukkan Email yang valid.</div>
            </div>
            <div class="col-md-6">
              <label for="username" class="form-label">Username:</label>
              <input type="text" class="form-control" name="username" required placeholder="Masukkan Username">
              <div class="error-feedback">Masukkan Username.</div><hr>
            </div>
            <div class="col-md-6">
              <label for="password" class="form-label">Password:</label>
              <input type="password" class="form-control" name="password" required placeholder="Masukkan Password">
              <div class="error-feedback">Masukkan Password.</div><hr>
            </div>
          </div>
          <div class="d-grid gap-2">
            <button id="registerBtn" type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-secondary">Login</a>
          </div>
        </form>
        <div id="spinner" class="spinner-border text-primary visually-hidden" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
      var form = this;
      var spinner = document.getElementById('spinner');

      if (form.checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
        form.classList.add('was-validated');
      } else {
        spinner.classList.remove('visually-hidden');
      }
    });
  </script>
</body>

</html>
