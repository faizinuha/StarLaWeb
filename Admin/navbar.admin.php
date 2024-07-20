<?php
include 'link.php';
session_start();

$name = "Guest";

require_once __DIR__ . '/../allkoneksi/koneksi.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT name FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
    }
}


?>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>


<!-- General CSS Files -->

<link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

<!-- CSS Libraries -->
<link rel="stylesheet" href="../assets/modules/jqvmap/dist/jqvmap.min.css">
<link rel="stylesheet" href="../assets/modules/weather-icon/css/weather-icons.min.css">
<link rel="stylesheet" href="../assets/modules/weather-icon/css/weather-icons-wind.min.css">
<link rel="stylesheet" href="../assets/modules/summernote/summernote-bs4.css">

<!-- Template CSS -->
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/components.css">
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
</script>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                </ul>
                <div class="search-element">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                    <div class="search-backdrop"></div>
                    <div class="search-result">
                        <div class="search-header">
                            Histories
                        </div>
                        <div class="search-item">
                            <a href="#">How to hack NASA using CSS</a>
                            <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                        </div>
                        <div class="search-item">
                            <a href="#">Kodinger.com</a>
                            <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                        </div>
                        <div class="search-item">
                            <a href="#">#Stisla</a>
                            <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                        </div>
                        <div class="search-header">
                            Result
                        </div>
                        <div class="search-item">
                            <a href="#">
                                <img class="mr-3 rounded" width="30" src="../assets/img/products/product-3-50.png" alt="product">
                                oPhone S9 Limited Edition
                            </a>
                        </div>
                        <div class="search-item">
                            <a href="#">
                                <img class="mr-3 rounded" width="30" src="../assets/img/products/product-2-50.png" alt="product">
                                Drone X2 New Gen-7
                            </a>
                        </div>
                        <div class="search-item">
                            <a href="#">
                                <img class="mr-3 rounded" width="30" src="../assets/img/products/product-1-50.png" alt="product">
                                Headphone Blitz
                            </a>
                        </div>
                        <div class="search-header">
                            Projects
                        </div>
                        <div class="search-item">
                            <a href="#">
                                <div class="search-icon bg-danger text-white mr-3">
                                    <i class="fas fa-code"></i>
                                </div>
                                Stisla Admin Template
                            </a>
                        </div>
                        <div class="search-item">
                            <a href="#">
                                <div class="search-icon bg-primary text-white mr-3">
                                    <i class="fas fa-laptop"></i>
                                </div>
                                Create a new Homepage Design
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">Messages
                            <div class="float-right">
                                <a href="#">Mark All As Read</a>
                            </div>
                        </div>

                        <div class="dropdown-footer text-center">
                            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </li>
                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">Notifications
                            <div class="float-right">
                                <a href="#">Mark All As Read</a>
                            </div>
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </li>
                <?php if (isset($_SESSION['username'])) { ?>
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block"><?php echo $name; ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Logged in 5 min ago</div>
                            <a href="../profile/profile_user.php" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="features-settings.html" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="../in/logout.php" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
            </ul>
        <?php } else { ?>
            <li class="nav-item">
                <a href="../login1/login.php" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
            </li>
            </li>
            <li class="nav-item">
                <a href="../login1/register.php" class="nav-link"><i class="fas fa-user-plus"></i> Register</a>
            </li>
        <?php } ?>
        </nav>
        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="#">Stisla</a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="index.html">St</a>
                </div>
                <ul class="sidebar-menu">
                    <li class="menu-header">Dashboard</li>
                    <li class="dropdown active">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                        <ul class="dropdown-menu">
                            <li class=active><a class="nav-link" href="../index.php"></a></li>
                            <li><a class="nav-link" href="../index.php">Total Users</a></li>
                        </ul>
                    </li>
                    <!-- menu -->
                    <li class="menu-header">Menu Lain</li>
                    <li class="nav-link"><a href="../blogs/upload.php"><i class="fa-sharp fa-solid fa-upload"></i></a></li>
                </ul>

            </aside>
        </div>

        <!-- Main Content -->
    </div>
</div>
    </div>
    </div>

    <!-- General JS Scripts -->
    <script src="../assets/modules/jquery.min.js"></script>
    <script src="../assets/modules/popper.js"></script>
    <script src="../assets/modules/tooltip.js"></script>
    <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="../assets/modules/moment.min.js"></script>
    <script src="../assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="../assets/modules/simple-weather/jquery.simpleWeather.min.js"></script>
    <script src="../assets/modules/chart.min.js"></script>
    <script src="../assets/modules/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="../assets/modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../assets/modules/summernote/summernote-bs4.js"></script>
    <script src="../assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="../assets/js/page/index-0.js"></script>

    <!-- Template JS File -->
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/custom.js"></script>
    <?php
    include 'footer.php';
    ?>