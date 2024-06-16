<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi Kode</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #e9ecef;
      font-family: 'Roboto', sans-serif;
    }

    .container {
      margin-top: 50px;
      max-width: 500px;
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-body {
      padding: 40px;
    }

    .card-title {
      font-weight: bold;
      color: #6a11cb;
      text-align: center;
    }

    .form-label {
      font-weight: bold;
      color: #6a11cb;
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

    .btn-secondary {
      border-radius: 8px;
    }

    .spinner-border {
      margin-top: 20px;
      display: none;
    }

    .was-validated .form-control:invalid {
      border-color: #dc3545;
    }

    .was-validated .form-control:invalid:focus {
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .was-validated .form-control:valid {
      border-color: #28a745;
    }

    .was-validated .form-control:valid:focus {
      box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
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
  <div class="container">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title">Verifikasi Kode</h2>
        <form id="verifyForm" action="proses_verify.php" method="post" novalidate>
          <div class="mb-3">
            <label for="verification_code" class="form-label">Kode Verifikasi:</label>
            <input type="text" class="form-control" name="verification_code" required placeholder="Masukkan Kode Verifikasi">
            <div class="invalid-feedback">Masukkan Kode Verifikasi yang valid.</div>
          </div>
          <div class="d-grid gap-2 mt-4">
            <button id="verifyBtn" type="submit" class="btn btn-primary">Verifikasi</button>
            <a href="register.php" class="btn btn-secondary">Kembali</a>
          </div>
        </form>
        <div id="spinner" class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('verifyForm').addEventListener('submit', function(event) {
      var form = this;
      if (form.checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
        form.classList.add('was-validated');
      }
    });
  </script>
</body>

</html>
