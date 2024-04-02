<?php
// Mulai sesi PHP
session_start();

// Periksa apakah pengguna sudah masuk atau belum
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sambungkan ke database Anda
include_once "koneksi.php";

// Ambil informasi pengguna dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($koneksi, $query);

// Periksa apakah pengguna ditemukan
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $username = $row['username'];
    $email = $row['email'];
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .profile-card {
            width: 100%;
            max-width: 350px;
        }

        .profile-image {
            width: 100%;
            height: auto;
            border-radius: 50%;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card profile-card">
                    <div class="card-body">
                        
                        <h5 class="card-title"><?php echo $name; ?></h5>
                        <p class="card-text">@<?php echo $username; ?></p>
                    </div>
                </div>
            </div>
            <!-- Informasi profil di sebelah kanan -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-cloud"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-white dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <!-- <li><a class="dropdown-item" href="upload.php">Change Profile</a></li> -->
                                    <li><a class="dropdown-item" href="edit.php">Settings</a></li>
                                    <li><a class="dropdown-item" href="../in/logout.php">Log Out</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../index.php">Menu</a></li>
                                </ul>
                            </div>
                        </div>
                        <h2 class="card-title mb-3">Personal Information</h2>
                        <p class="card-text">Name: <?php echo $name; ?></p>
                        <p class="card-text">Username: <?php echo $username; ?></p>
                        <h3 class="mt-5 mb-3">Change Password</h3>
                        <form method="post" action="" class="mb-5">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password:</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>
                            <button type="submit" name="reset_password" class="btn btn-primary mt-3">Reset Password</button>
                        </form>
                        <!-- Tampilkan link media sosial -->
                        <h2 class="card-title mt-5 mb-3">Social Media Links</h2>
                        <div class="card-text">
                            <p class="mb-2">Instagram: <a href="<?php echo $instagram; ?>" class="text-primary" target="_BLANK"><?php echo $instagram; ?></a></p>
                            <p class="mb-2">TikTok: <a href="<?php echo $TikTok; ?>" class="text-danger"><?php echo $TikTok; ?></a></p>
                            <p>Twitter: <a href="<?php echo $Twitter; ?>" class="text-primary"><?php echo $Twitter; ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>