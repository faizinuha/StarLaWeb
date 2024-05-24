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

$stmt = $koneksi->prepare("SELECT id FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<script>alert("Email sudah digunakan. Silakan gunakan email lain."); window.location.href = "register.php";</script>';
} else {
    if (strlen($password) < 2) {
        echo '<script>alert("Password harus memiliki minimal 5 karakter."); window.location.href = "register.php";</script>';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menyiapkan dan mem-binding
        $stmt = $koneksi->prepare("INSERT INTO users (name, email, username, password, TikTok, instagram, Twitter, about_me, profile_image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $name, $email, $username, $hashed_password, $tiktok_value, $instagram_value, $twitter_value, $about_me, $profile_image_path); // Menyediakan nilai untuk profile_image_path

        if ($stmt->execute()) {
            header("Location: login.php");
            exit(); 
        } else {
            echo '<script>alert("Registrasi gagal. Mohon coba lagi."); window.location.href = "register.php";</script>';
        }

        $stmt->close();
    }
}

// Menutup koneksi
$koneksi->close();
?>
