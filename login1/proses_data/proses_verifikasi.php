<?php
session_start();
include('koneksi.php');

$verification_code = $_POST['verification_code'];

// Memeriksa apakah kode verifikasi cocok dengan yang ada di database
$stmt = $koneksi->prepare("SELECT id, username FROM users WHERE verification_code=?");
$stmt->bind_param("s", $verification_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Menghapus kode verifikasi setelah berhasil diverifikasi
    $stmt = $koneksi->prepare("UPDATE users SET verification_code='' WHERE id=?");
    $stmt->bind_param("i", $row['id']);
    $stmt->execute();

    $_SESSION['username'] = $row['username'];
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['login_success'] = "Berhasil verifikasi dan login";
    // Redirect ke halaman dashboard atau home
    header("Location: /index.php?login_success=true");
    exit();
} else {
    $_SESSION['verification_error'] = "Kode verifikasi salah";
    // Redirect ke halaman verifikasi dengan pesan error
    header("Location: verify_code.php?verification_error=true");
    exit();
}

$stmt->close();
$koneksi->close();
?>
