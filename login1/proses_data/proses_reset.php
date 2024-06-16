<?php
session_start();
require_once __DIR__ . "/koneksi.php";

// Function to clean input
function cleanInput($data)
{
    global $koneksi;
    if(!$koneksi) {
        die("Database connection error: " . mysqli_connect_error());
    }
    return mysqli_real_escape_string($koneksi, $data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $email = cleanInput($_POST['email']);
    $newPassword = $_POST['new_password']; 

    
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password in the database
    $query = "UPDATE users SET password='$hashedPassword' WHERE email='$email'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('kata sandi berhasil di ubah anda di segerakan login'); window.location.href = 'login.php';</script>";
        // header("Location: login.php");
        exit();
    } else {
        echo "Error updating password: " . mysqli_error($koneksi);
    }
}
?>
