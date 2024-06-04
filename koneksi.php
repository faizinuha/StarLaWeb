<?php 
  $conn = new mysqli("localhost", "root", "", "blog");

  // Periksa koneksi
  if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
  }