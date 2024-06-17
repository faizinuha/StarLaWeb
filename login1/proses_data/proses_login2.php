<?php
require_once __DIR__ . "/koneksi.php";

// Start session
session_start();

// Tangkap ID pengguna dan kata sandi dari formulir
$user_id = $_POST['user_id']; // Ambil dari input tersembunyi di password.php
$password = $_POST['password'];

error_log("User ID: $user_id");
error_log("Password: $password");

// Query untuk mendapatkan data pengguna berdasarkan ID
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    error_log("Database Password: " . $row['password']);
    
    // Lakukan otentikasi berdasarkan kata sandi
    if (password_verify($password, $row['password'])) {
        // Otentikasi berhasil, simpan sesi dan alihkan ke halaman beranda atau dashboard
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        header("Location: ../index.php"); // Ganti dengan halaman beranda atau dashboard
        exit();
    } else {
        // Password salah, kembalikan ke halaman login dengan pesan kesalahan
        $_SESSION['login_error'] = "Invalid password";
        header("Location: password.php?id=$user_id&login_error=true");
        exit();
    }
} else {
    // Pengguna tidak ditemukan, kembalikan ke halaman login dengan pesan kesalahan
    $_SESSION['login_error'] = "User not found";
    header("Location: password.php?id=$user_id&login_error=true");
    exit();
} 
?>
