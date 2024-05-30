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

// Memeriksa apakah email sudah digunakan
$stmt = $koneksi->prepare("SELECT id FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $_SESSION['form_data'] = $_POST; // Simpan data form di session
    echo '<script>alert("Email sudah digunakan. Silakan gunakan email lain."); window.location.href = "register.php";</script>';
    exit();
}

// Memeriksa apakah username sudah digunakan
$stmt = $koneksi->prepare("SELECT id FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $new_username = $username . rand(100, 999); // Menghasilkan username rekomendasi
    $_SESSION['form_data'] = $_POST; // Simpan data form di session
    echo '<script>alert("Username sudah digunakan. Silakan gunakan username lain. Contoh: '.$new_username.'"); window.location.href = "register.php";</script>';
    exit();
}

// Memeriksa panjang password
if (strlen($password) < 2) { // Ubah dari 2 menjadi 5
    $_SESSION['form_data'] = $_POST; // Simpan data form di session
    echo '<script>alert("Password harus memiliki minimal 5 karakter."); window.location.href = "register.php";</script>';
    exit();
}

// Hashing password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Menyiapkan dan mem-binding query untuk memasukkan data pengguna baru
$stmt = $koneksi->prepare("INSERT INTO users (name, email, username, password, TikTok, instagram, Twitter, about_me, profile_image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $name, $email, $username, $hashed_password, $tiktok_value, $instagram_value, $twitter_value, $about_me, $profile_image_path);

if ($stmt->execute()) {
    // Hapus data form dari session setelah berhasil
    unset($_SESSION['form_data']);
    header("Location: login.php");
    exit(); 
} else {
    $_SESSION['form_data'] = $_POST; // Simpan data form di session
    echo '<script>alert("Registrasi gagal. Mohon coba lagi."); window.location.href = "register.php";</script>';
}

// Menutup statement dan koneksi
$stmt->close();
$koneksi->close();
?>
