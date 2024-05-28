<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$database = "users";

// Membuat koneksi ke database
$koneksi = mysqli_connect($server, $username, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Design</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .navbar {
            position: sticky-top;
            top: 0;
            z-index: 1000;
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .nav-link {
            color: #555;
            font-weight: 500;
            padding: 0.75rem 1rem;
        }

        .nav-link:hover {
            color: #000;
        }

        .btn-discord {
            background-color: #5865F2;
            color: #fff;
            font-weight: 500;
        }

        .btn-discord:hover {
            background-color: #4752C4;
        }

      
    </style>
</head>

<body>
    <div class="container-fluid">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg ">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Bloger</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">

                        <?php
                        if (isset($_SESSION['username'])) { ?>
                            <li class="nav-item">
                                <a href="in/logout.php" class="nav-link">Log Out</a>
                            </li>
                            <li class="nav-item">
                                <a href="blogs/upload.php" class="nav-link">Upload</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile/profile_user.php">Profile</a>
                            </li>

                        <?php

                        } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login1/login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="login1/register.php">Registrasi</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a href="https://discord.gg/rvaNTU63s3" class="btn btn-discord "><i class="bi bi-discord"></i> Join Discord</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <!-- Main content -->
        <div class="container">
            <!-- Content here -->
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>