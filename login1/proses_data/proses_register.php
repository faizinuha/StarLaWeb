<?php
session_start();
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Generate a verification code
    $verification_code = rand(100000, 999999); 

    $tiktok_value = "";
    $instagram_value = "";
    $twitter_value = "";
    $about_me = "";
    $profile_image_path = "";

    // Debug log
    error_log("Received POST request with email: $email, username: $username");

    // Memeriksa apakah email sudah digunakan
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<script>alert("Email sudah digunakan. Silakan gunakan email lain."); window.location.href = "../register.php";</script>';
        exit();
    }

    // Memeriksa apakah username sudah digunakan
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $new_username = $username . rand(100, 999); // Menghasilkan username rekomendasi
        echo '<script>alert("Username sudah digunakan. Silakan gunakan username lain. Contoh: ' . $new_username . '"); window.location.href = "../register.php";</script>';
        exit();
    }

    // Memeriksa panjang password
    if (strlen($password) < 2) {
        echo '<script>alert("Password harus memiliki minimal 8 karakter."); window.location.href = "../register.php";</script>';
        exit();
    }

    // Hashing password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Menyiapkan dan mem-binding query untuk memasukkan data pengguna baru
    $stmt = $koneksi->prepare("INSERT INTO users (name, email, username, password, verification_code, TikTok, instagram, Twitter, about_me, profile_image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $name, $email, $username, $hashed_password, $verification_code, $tiktok_value, $instagram_value, $twitter_value, $about_me, $profile_image_path);

    if ($stmt->execute()) {
        // Debug log
        error_log("User $username successfully registered, preparing to send email.");
        
        // echo '<script>alert("Registrasi berhasil. Kode konfirmasi Anda adalah:.Mohon di Jaga Kode Ya ' . $verification_code . '"); window.location.href = "../login.php";</script>';
        echo '<script>alert("Registrasi berhasil. Kode konfirmasi Anda adalah:.Mohon di Jaga Kode Ya ' . $verification_code . '"); window.location.href = "../login.php";</script>';
        // Debug log
        error_log("Confirmation email simulated for $email.");
    } else {
        echo '<script>alert("Registrasi gagal. Mohon coba lagi."); window.location.href = "../register.php";</script>';
        // Debug log
        error_log("Failed to register user $username.");
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $koneksi->close();
}
?>
