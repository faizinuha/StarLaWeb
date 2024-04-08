<?php
// Termasuk file koneksi
include_once "koneksi.php";

// Memulai sesi
session_start();

// Memeriksa apakah user_id telah diatur
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  // Memeriksa apakah data formulir telah dikirimkan
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data yang dikirimkan dari formulir
    $name = $_POST['name'];
    $email = $_POST['email'];
    $TikTok = $_POST['TikTok'];
    $instagram = $_POST['instagram'];
    $Twitter = $_POST['Twitter'];
    $about_me = $_POST['about_me'];

    // Validasi input
    if (empty($name) || empty($email) || empty($TikTok) || empty($instagram) || empty($Twitter)) {
      echo "Semua kolom harus diisi.";
    } else {
      // Menghindari SQL Injection dengan menggunakan parameterized query
      $query = "UPDATE users SET name=?, email=?, instagram=?, TikTok=?, Twitter=?, about_me=? WHERE id=?";
      $stmt = mysqli_prepare($koneksi, $query);

      // Binding parameters
      mysqli_stmt_bind_param($stmt, "ssssssi", $name, $email, $instagram, $TikTok, $Twitter, $about_me, $user_id);

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
    $query = "SELECT name, email, instagram, TikTok, Twitter, about_me FROM users WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $email, $instagram, $TikTok, $Twitter, $about_me);
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
        <form id="editForm"  method="POST">
          <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
          </div>
          <div class="form-group">
            <label for="instagram">Instagram:</label>
            <input type="text" class="form-control" id="instagram" name="instagram" value="<?php echo isset($instagram) ? $instagram : ''; ?>">
          </div>
          <div class="form-group">
            <label for="TikTok">TikTok:</label>
            <input type="text" class="form-control" id="TikTok" name="TikTok" value="<?php echo isset($TikTok) ? $TikTok : ''; ?>">
          </div>
          <div class="form-group">
            <label for="Twitter">Twitter:</label>
            <input type="text" class="form-control" id="Twitter" name="Twitter" value="<?php echo isset($Twitter) ? $Twitter : '' ?>">
          </div>
          <div class="form-group">
            <label for="about_me">Tentang Saya:</label>
            <textarea class="form-control" id="about_me" name="about_me"><?php echo isset($about_me) ? $about_me : ''; ?></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-primary" onclick="cancelEdit()">Cancel</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function cancelEdit() {
      if (confirm("Apakah Anda yakin ingin membatalkan pengeditan profil?")) {
        window.location.href = "profile_user.php";
      }
    }
  </script>
</body>

</html>