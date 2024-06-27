<?php
session_start();
require_once __DIR__ . '/../../allkoneksi/koneksi.php'; // Memasukkan file koneksi.php yang berisi konfigurasi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $verification_code = $_POST['verification_code'];

    // Debug log
    error_log("Received POST request for email verification with email: $email");

    // Memeriksa apakah kode konfirmasi sesuai
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE email=? AND verification_code=?");
    $stmt->bind_param("ss", $email, $verification_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Menghapus kode konfirmasi setelah verifikasi berhasil
        $stmt = $koneksi->prepare("UPDATE users SET verification_code=NULL WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        echo '<script>alert("Verifikasi berhasil. Akun Anda telah diaktifkan."); window.location.href = "../login.php";</script>';
        // Debug log
        error_log("User $email successfully verified.");
    } else {
        echo '<script>alert("Kode konfirmasi salah atau email tidak ditemukan."); window.location.href = "../verify.php";</script>';
        // Debug log
        error_log("Failed verification attempt for email $email.");
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $koneksi->close();
}
?>
