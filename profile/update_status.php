<?php
session_start();

// Periksa apakah pengguna sudah masuk atau belum
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Sambungkan ke database Anda
require_once __DIR__ . '../../allkoneksi/koneksi.php';

if (isset($_POST['photo_id']) && isset($_POST['status'])) {
  $photo_id = $_POST['photo_id'];
  $new_status = $_POST['status'];

  // Update status di database
  $query = "UPDATE posts SET status = '$new_status' WHERE id = $photo_id";
  if (mysqli_query($koneksi, $query)) {
    echo 'success';
  } else {
    echo 'error';
  }

  // Tutup koneksi ke database
  mysqli_close($koneksi);
} else {
  echo 'error';
}
?>
