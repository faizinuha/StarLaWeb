<?php

$host = "localhost"; 
$username = "root";
$password = "";
$database = "blog";
// $database = "users";

// Buat koneksi ke database
$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
