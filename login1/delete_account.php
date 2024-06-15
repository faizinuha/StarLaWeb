<?php
session_start();




// Membuat koneksi ke database


// Periksa koneksi


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mendapatkan ID pengguna dari sesi
  $server = "localhost";
  $username = "root";
  $password = "";
  $database = "users";

  $koneksi = mysqli_connect($server, $username, $password, $database);
  if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
  }
  if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // Debug: menampilkan ID pengguna
    error_log("User ID: " . $userId);

    // Menyiapkan pernyataan SQL untuk menghapus pengguna berdasarkan ID
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bindParam('i', $userId);
    $stmt->execute();

    if ($stmt->execute()) {
      // Jika akun berhasil dihapus, hancurkan sesi
      session_destroy();
      unset($_SESSION['id']); // Hapus variabel sesi spesifik jika diperlukan
      echo "Akun berhasil dihapus.";
    } else {
      echo "Terjadi kesalahan saat menghapus akun. Silakan coba lagi.";
    }
  } else {
    echo "ID pengguna tidak ditemukan.";
  }
  $koneksi->close();
} else {
  echo "Metode permintaan tidak valid.";
}
