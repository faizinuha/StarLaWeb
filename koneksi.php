<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "blog";


// Membuat koneksi ke database
$koneksi = mysqli_connect($server, $username, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
