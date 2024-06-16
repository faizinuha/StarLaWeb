<?php
session_start();
include('koneksi.php');

// Ambil data dari form registrasi
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
    $_SESSION['registration_error'] = "Email sudah digunakan. Silakan gunakan email lain.";
    header("Location: ../register.php");
    exit();
}

// Memeriksa apakah username sudah digunakan
$stmt = $koneksi->prepare("SELECT id FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $new_username = $username . rand(100, 999); // Menghasilkan username rekomendasi
    $_SESSION['registration_error'] = "Username sudah digunakan. Silakan gunakan username lain. Contoh: $new_username";
    header("Location: ../register.php");
    exit();
}

// Memeriksa panjang password
if (strlen($password) < 8) {
    $_SESSION['registration_error'] = "Password harus memiliki minimal 8 karakter.";
    header("Location: ../register.php");
    exit();
}

// Hashing password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Menyiapkan dan mem-binding query untuk memasukkan data pengguna baru
$stmt = $koneksi->prepare("INSERT INTO users (name, email, username, password, verification_code, TikTok, instagram, Twitter, about_me, profile_image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $name, $email, $username, $hashed_password, $verification_code, $tiktok_value, $instagram_value, $twitter_value, $about_me, $profile_image_path);

if ($stmt->execute()) {
    $_SESSION['registration_success'] = "Registrasi berhasil. Silakan verifikasi email Anda.";

    // Mengirim email verifikasi menggunakan EmailJS
    echo '<script src="https://cdn.jsdelivr.net/npm/emailjs-com@2.6.4/dist/email.min.js"></script>';
    echo '<script>
        (function(){
            emailjs.init("kvsky5c4Es4-4iGzr"); // Gantilah kvsky5c4Es4-4iGzr dengan ID pengguna EmailJS Anda
        })();

        emailjs.send("service_aic6p9j", "template_1yu5gv2", {
            to_name: "' . $name . '",
            to_email: "' . $email . '",
            verification_code: "' . $verification_code . '"
        }).then(function(response) {
            console.log("Email terkirim!", response.status, response.text);
            window.location.href = "../verify_code.php";
        }, function(error) {
            console.error("Gagal mengirim email", error);
            alert("Gagal mengirim email verifikasi. Silakan coba lagi.");
            window.location.href = "../register.php";
        });
    </script>';
    exit();
} else {
    $_SESSION['registration_error'] = "Registrasi gagal. Mohon coba lagi.";
    header("Location: ../register.php");
    exit();
}

// Menutup statement dan koneksi
$stmt->close();
$koneksi->close();
?>
