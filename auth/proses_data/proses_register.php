<?php
session_start();
require_once __DIR__ . '/../../allkoneksi/koneksi.php';

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

    // Check if email already exists
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<script>alert("Email sudah digunakan. Silakan gunakan email lain."); window.location.href = "../register.php";</script>';
        exit();
    }

    // Check if username already exists
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $new_username = $username . rand(100, 999); // Suggest alternative username
        echo '<script>alert("Username sudah digunakan. Silakan gunakan username lain. Contoh: ' . $new_username . '"); window.location.href = "../register.php";</script>';
        exit();
    }

    // Check password length
    if (strlen($password) < 8) {
        echo '<script>alert("Password harus memiliki minimal 8 karakter."); window.location.href = "../register.php";</script>';
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind query for new user insertion
    $stmt = $koneksi->prepare("INSERT INTO users (name, email, username, password, verification_code, TikTok, instagram, Twitter, about_me, profile_image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $name, $email, $username, $hashed_password, $verification_code, $tiktok_value, $instagram_value, $twitter_value, $about_me, $profile_image_path);

    if ($stmt->execute()) {
        // Debug log
        error_log("User $username successfully registered, preparing to send email.");
        
        $_SESSION['registration_success'] = true;
        $_SESSION['verification_code'] = $verification_code;

        echo '<script>window.location.href = "../register.php";</script>';
    } else {
        echo '<script>alert("Registrasi gagal. Mohon coba lagi."); window.location.href = "../register.php";</script>';
        // Debug log
        error_log("Failed to register user $username.");
    }

    // Close statement and connection
    $stmt->close();
    $koneksi->close();
}
?>
