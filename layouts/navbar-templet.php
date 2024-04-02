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
    <title>Sidebar Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Custom CSS for Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 200;
            background-color: #343a40;
            padding-top: 3.5rem; /* Height of navbar */
            overflow-x: hidden;
            transition: all 0.3s;
        }

        .sidebar-nav {
            padding: 0;
        }

        .sidebar-nav .nav-item {
            margin: 20;
        }

        .sidebar-nav .nav-link {
            padding: 10px 25px;
            text-align: left;
            color: rgba(255, 255, 255, 0.75);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
            }
        }
        .profile-image {
            max-width: 100px; /* Maksimum lebar gambar */
            max-height: 100px; /* Maksimum tinggi gambar */
        }
    
    </style>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Brand</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Blog</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <div class="sidebar">
            <ul class="sidebar-nav nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Beranda</a>
                </li>
                <?php
                // Periksa apakah pengguna sudah login
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
                } else {
                    // Jika belum login, tampilkan menu login dan registrasi
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login1/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login1/register.php">Registrasi</a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <!-- End Sidebar -->

        <!-- Main content -->
        <div class="container-fluid">
            <!-- Content here -->
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
