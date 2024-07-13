<?php
session_start();

// Default name if not logged in
$name = "Not Loggin";

require_once __DIR__ . '/../allkoneksi/koneksi.php';
// Fetch user's name if logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT name FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
    }
}

// Close database connection
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twiiter</title>
    <!-- <link rel="icon" href="../assets/back_arrow_icon.png"> -->
    <!-- General CSS Files -->
    <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../assets/modules/bootstrap-social/bootstrap-social.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/components.css">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #4752C4;
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

        .cursor {
            cursor: pointer;
        }

        .list-group {
            margin-top: 20px;
        }

        .warna-bg {
            background-color: blue;
        }

        @media (max-width: 768px) {
            .navbar-nav.space-x-4 {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 320px) {
            .navbar-brand {
                font-size: 1rem;
            }
        }

        @media (max-width: 240px) {
            .navbar-brand {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 160px) {
            .navbar-brand {
                font-size: 0.6rem;
            }
        }
       
    </style>
</head>

<body>
    <!-- Navbar -->
         <nav class="navbar navbar-expand-lg warna-bg sticky-top">
            <div class="container mx-auto">
                <a class="navbar-brand text-xl font-bold text-gray-800" href="#">Bloger</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto space-x-4">
                        <li class="nav-item">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="bi bi-info"></i>
                            </button>
                        </li>
                        <?php if (isset($_SESSION['username'])) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle">HI,</i> <?php echo $name; ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item cursor" href="blogs/upload.php"><i class="bi bi-plus-circle"></i> Upload</a></li>
                                    <li><a class="dropdown-item" href="profile/profile_user.php"><i class="bi bi-person"></i> Your Profile</a></li>
                                    <li><a class="dropdown-item cursor1" href="Private/setting.php"> <i class="bi bi-gear-wide"></i> Setting</a></li>
                                    <!-- <li><a class="dropdown-item cursor1" href="Private/contant.php">  <i class="bi bi-gear-wide"></i> Akses Contct</a></li> -->
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="in/logout.php"><i class="bi bi-box-arrow-right"></i> Sign out</a></li>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login1/login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="login1/register.php"><i class="bi bi-pencil-square"></i> Register</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a href="https://discord.gg/rvaNTU63s3" class="btn btn-primary"><i class="bi bi-discord"></i> Join Discord</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="text-danger">Update 2024</h4>
                    <p>New features:</p>
                    <ul>
                        <li>Typing exercises (sourceCodes-&gt;Profile)</li>
                        <li>Dangerous page</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>