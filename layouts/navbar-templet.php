<?php
session_start();

// Default name if not logged in
$name = "Not Logged In";

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
    <title>Bloger</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #343a40;
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-size: 1.75rem;
            font-weight: bold;
            color: #fff;
        }

        .nav-link {
            color: #ddd;
            font-weight: 500;
            padding: 0.75rem 1rem;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #fff;
        }

        .btn-discord {
            background-color: #5865F2;
            color: #fff;
            font-weight: 500;
        }

        .btn-discord:hover {
            background-color: #4752C4;
        }

        .dropdown-menu {
            background-color: #343a40;
            border: none;
        }

        .dropdown-item {
            color: #ddd;
            transition: color 0.3s, background-color 0.3s;
        }

        .dropdown-item:hover {
            color: #fff;
            background-color: #495057;
        }

        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Bloger</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="bi bi-info"></i>
                        </button>
                    </li>
                    <?php if (isset($_SESSION['username'])) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"> HI,</i> <?php echo $name; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item cursor" href="blogs/upload.php"><i class="bi bi-plus-circle"></i> Upload</a></li>
                                <li><a class="dropdown-item" href="profile/profile_user.php"><i class="bi bi-person"></i> Your Profile</a></li>
                                <li><a class="dropdown-item cursor" href="Private/setting.php"> <i class="bi bi-gear-wide"></i> Setting</a></li>
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
                        <a href="https://discord.gg/rvaNTU63s3" class="btn btn-discord"><i class="bi bi-discord"></i> Join Discord</a>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+8C/5r3qy/p1WQ68BOJ3COd9XYQ2A" crossorigin="anonymous"></script>
</body>

</html>