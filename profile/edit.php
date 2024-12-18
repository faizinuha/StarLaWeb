<?php
// Termasuk file koneksi
require_once __DIR__ . '/../allkoneksi/koneksi.php';

// Memulai sesi
session_start();

// Memeriksa apakah user_id telah diatur
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  // Memeriksa apakah data formulir telah dikirimkan
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data yang dikirimkan dari formulir
    $name = $_POST['name'];
    $TikTok = $_POST['TikTok'];
    $instagram = $_POST['instagram'];
    $Twitter = $_POST['Twitter'];
    $about_me = $_POST['about_me'];

    // Validasi input
    if (empty($name) || empty($TikTok) || empty($instagram) || empty($Twitter)) {
      echo "Semua kolom harus diisi.";
    } else {
      // Menghindari SQL Injection dengan menggunakan parameterized query
      $query = "UPDATE users SET name=?, instagram=?, TikTok=?, Twitter=?, about_me=? WHERE id=?";
      $stmt = mysqli_prepare($koneksi, $query);

      // Binding parameters
      mysqli_stmt_bind_param($stmt, "sssssi", $name, $instagram, $TikTok, $Twitter, $about_me, $user_id);

      // Eksekusi statement
      if (mysqli_stmt_execute($stmt)) {
        // Redirect ke halaman profil dengan pesan sukses
        header("Location: profile_user.php?edit_success=true");
        exit();
      } else {
        // Jika terjadi kesalahan saat pengeditan, tangani sesuai kebutuhan aplikasi Anda
        echo "Gagal mengupdate profil.";
      }

      // Tutup statement
      mysqli_stmt_close($stmt);
    }
  } else {
    // Jika data formulir tidak dikirimkan, ambil data dari database
    $query = "SELECT name, instagram, TikTok, Twitter, about_me FROM users WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $instagram, $TikTok, $Twitter, $about_me);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
  }
} else {
  // Jika user_id tidak diatur
  echo "User ID tidak ditemukan.";
}

// Tutup koneksi ke database (jika tidak menggunakan koneksi persistent)
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil</title>
  <!-- Tambahkan stylesheet Bootstrap -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tambahkan stylesheet tambahan untuk menyesuaikan tampilan -->
  <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <style>
  body {
    background-color: #f8f9fa;
  }

  .container {
    margin-top: 50px;
  }

  .card {
    border-radius: 15px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
  }

  .card-body {
    padding: 40px;
  }

  .form-group {
    margin-bottom: 20px;
  }

  label {
    font-weight: bold;
  }

  textarea.form-control {
    min-height: 100px;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    margin-top: 20px;
    /* tambahkan margin top agar tombol submit terpisah dari input */
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }
  </style>
</head>

<body>
  <div class="container">
    <h1>Edit Profil</h1>
    <div class="card">
      <div class="card-body">
        <form class="row g-3" method="POST">
          <div class="col-md-4">
            <label for="name" class="form-label">Nama:</label>
            <input type="text" class="form-control" id="name" name="name"
              value="<?php echo isset($name) ? $name : ''; ?>">
          </div>
          <!-- <div class="col-md-4">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email"
              value="<?php echo isset($email) ? $email : ''; ?>">
          </div> -->
          <div class="col-md-4">
            <label for="instagram" class="form-label">Instagram:</label>
            <input type="text" class="form-control" id="instagram" name="instagram"
              value="<?php echo isset($instagram) ? $instagram : ''; ?>">
          </div>
          <div class="col-md-4">
            <label for="TikTok" class="form-label">TikTok:</label>
            <input type="text" class="form-control" id="TikTok" name="TikTok"
              value="<?php echo isset($TikTok) ? $TikTok : ''; ?>">
          </div>
          <div class="col-md-4">
            <label for="Twitter" class="form-label">Twitter:</label>
            <input type="text" class="form-control" id="Twitter" name="Twitter"
              value="<?php echo isset($Twitter) ? $Twitter : ''; ?>">
          </div>
          <div class="col-12">
            <label for="about_me" class="form-label">Tentang Saya:</label>
            <textarea class="form-control" id="about_me" name="about_me"
              rows="3"><?php echo isset($about_me) ? $about_me : ''; ?></textarea>
          </div>
          <div class="col-12">
            <button class="btn btn-primary" type="submit">Simpan</button>
            <button class="btn btn-primary" type="button" onclick="cancelEdit()">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
  function cancelEdit() {
  //   if (confirm("Apakah Anda yakin ingin membatalkan pengeditan profil?")) {
  //   }
  window.location.href = "profile_user.php";
  }
  </script>
</body>

</html>