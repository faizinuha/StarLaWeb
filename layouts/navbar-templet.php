<?php
session_start();
// Default name if not logged in
$name = "Not Logged In";
// Check if there's an alert in session
$alert_message = "";
if (isset($_SESSION['alert'])) {
    $alert_message = '<div class="alert alert-' . $_SESSION['alert']['type'] . '" role="alert">' . $_SESSION['alert']['message'] . '</div>';
    unset($_SESSION['alert']); // Clear alert after displaying
}

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
    <title>Twitter</title>
    <link rel="icon" href="../asset/img/paimon-genshin-impact.avif">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../node_modules/egalink-toasty.js/dist/toasty.min.css" rel="stylesheet">
    <script src="../node_modules/egalink-toasty.js/dist/toasty.min.js"></script>
    <style>
        .navbar {
            position: sticky;
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

        .cursor {
            cursor: pointer;
        }

        .list-group {
            margin-top: 20px;
        }

        .translate-container {
            display: flex;
            gap: 10px;
        }

        /* Styling for color swapper */
        .color-swapper {
            display: flex;
            gap: 10px;
        }

        .color-swapper .color-box {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .color-swapper .color-box:hover {
            transform: scale(1.2);
        }

        /* Offcanvas customization */
        .offcanvas {
            width: 250px !important;
        }

        .offcanvas-bottom {
            height: 250px;
            bottom: 0;
            left: 0;
            right: auto;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container mx-auto">
            <a class="navbar-brand text-xl font-bold text-gray-800" href="#">Bloger</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto space-x-4">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-bell"></i> Notifications</a>
                    </li>
                    <?php if (isset($_SESSION['username'])) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> <?php echo $name; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item cursor" href="blogs/upload.php"><i class="bi bi-plus-circle"></i> Upload</a></li>
                                <li><a class="dropdown-item" href="profile/profile_user.php"><i class="bi bi-person"></i> Your Profile</a></li>
                                <li><a class="dropdown-item cursor1" href="Private/setting.php"><i class="bi bi-gear-wide"></i> Setting</a></li>
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Color Swapper -->
    <a class="btn btn-primary color-swapper" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        Icons Air
    </a>
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Icons Air</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                Percantik Background dengan warna
            </div>
            <div class="color-swapper">
                <div class="color-box" style="background-color: white;" onclick="swapColor('white')"></div>
                <div class="color-box" style="background-color: #1e90ff;" onclick="swapColor('#1e90ff')"></div>
                <div class="color-box" style="background-color: #2ed573;" onclick="swapColor('#2ed573')"></div>
                <div class="color-box" style="background-color: #ffa502;" onclick="swapColor('#ffa502')"></div>
                <div class="color-box" style="background-color: #ff6348;" onclick="swapColor('#ff6348')"></div>
                <div class="color-box" style="background-color: #3742fa;" onclick="swapColor('#3742fa')"></div>
            </div>
            <!-- Alert Message -->
            <?php if ($alert_message) {
                echo $alert_message;
            } ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        function swapColor(color) {
            document.body.style.transition = "background-color 0.5s ease";
            document.body.style.backgroundColor = color;
        }
    </script>
</body>

</html>
