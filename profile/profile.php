<?php
// Mulai sesi PHP
session_start();

// Periksa apakah pengguna sudah masuk atau belum
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sambungkan ke database Anda
require_once __DIR__ . '/../allkoneksi/koneksi.php';


// Ambil informasi pengguna dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($koneksi, $query);

// Periksa apakah pengguna ditemukan
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $username = $row['username'];
    // $email = $row['email'];
    $TikTok = $row['TikTok'];
    $instagram = $row['instagram'];
    $Twitter = $row['Twitter'];
    // $profile_photo = $row['profile_photo'];
} else {
    echo "Informasi pengguna tidak ditemukan.";
}
?>
<?php

require_once __DIR__ . "/koneksi.php";

// Function to clean input
function cleanInput($data)
{
    global $koneksi;
    if (!$koneksi) {
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
        echo "<script>alert('Kata sandi berhasil diubah');</script>";
        header("Location: profile_user.php");
        exit();
    } else {
        echo "Error updating password: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $name; ?></h5>
                        <p class="card-text">@<?php echo $username; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown d-flex justify-content-end mb-4">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="edit.php">Settings</a></li>
                                <li><a class="dropdown-item" href="../in/logout.php">Log Out</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../index.php">Menu</a></li>
                            </ul>
                        </div>
                        <h2 class="card-title">Personal Information</h2>
                        <p class="card-text"><span class="font-weight-bold">Name:</span> <?php echo $name; ?></p>
                        <p class="card-text"><span class="font-weight-bold">Username:</span> <?php echo $username; ?></p>
                        <h3 class="card-title">Change Password</h3>
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password:</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>
                            <button type="submit" name="reset_password" class="btn btn-primary">Reset Password</button>
                        </form>
                        <h2 class="card-title mt-4">Social Media Links</h2>
                        <div class="card-text">
                            <p><span class="font-weight-bold">Instagram:</span><a href="<?php echo $instagram; ?>" class="text-primary" target="_BLANK"><?php echo $instagram; ?></a></p>
                            <p><span class="font-weight-bold">TikTok:</span> <a href="<?php echo $TikTok; ?>" class="text-danger"><?php echo $TikTok; ?></a></p>
                            <p><span class="font-weight-bold">Twitter:</span> <a href="<?php echo $Twitter; ?>" class="text-primary"><?php echo $Twitter; ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>
 