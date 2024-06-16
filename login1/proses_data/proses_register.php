<?php
session_start();
include('koneksi.php');

$name = $_POST['nama'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$tiktok_value = ""; 
$instagram_value = ""; 
$twitter_value = ""; 
$about_me = ""; 
$profile_image_path = ""; 

// Generate verification code
$verification_code = rand(100000, 999999);

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
    echo '<script>alert("Username sudah digunakan. Silakan gunakan username lain. Contoh: '.$new_username.'"); window.location.href = "../register.php";</script>';
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
    // Send verification email with the code using EmailJS or any email service
    // ...

    // Redirect to a page that asks for the verification code
    header("Location: ../verify_code.php");
    exit();
} else {
    echo '<script>alert("Registrasi gagal. Mohon coba lagi."); window.location.href = "../register.php";</script>';
}

// Menutup statement dan koneksi
$stmt->close();
$koneksi->close();
?>
