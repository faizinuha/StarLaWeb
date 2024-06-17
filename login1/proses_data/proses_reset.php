<?php
session_start();
require_once __DIR__ . "/koneksi.php";

// Function to clean input
function cleanInput($data) {
    global $koneksi;
    if (!$koneksi) {
        die("Database connection error: " . mysqli_connect_error());
    }
    return mysqli_real_escape_string($koneksi, $data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $email = cleanInput($_POST['email']);
    $resetCode = cleanInput($_POST['reset_code']);
    $newPassword = $_POST['new_password'];

    // Check if the email and verification code match
    $query = "SELECT * FROM users WHERE email='$email' AND verification_code='$resetCode'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in the database without clearing the verification code
        $updateQuery = "UPDATE users SET password='$hashedPassword' WHERE email='$email'";
        $updateResult = mysqli_query($koneksi, $updateQuery);

        if ($updateResult) {
            echo "<script>alert('Kata sandi berhasil diubah. Silakan login.'); window.location.href = '../login.php';</script>";
        } else {
            echo "Error updating password: " . mysqli_error($koneksi);
        }
    } else {
        echo "<script>alert('Kode reset tidak valid atau email tidak ditemukan.'); window.location.href = '../reset_password.php';</script>";
    }
}
?>
