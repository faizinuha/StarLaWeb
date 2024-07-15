<?php
session_start();
// Default name if not logged in
$name = "Not Loggin";

// Gunakan __DIR__ untuk jalur absolut
include (__DIR__ . '/../../allkoneksi/koneksi.php');

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
?>

<!DOCTYPE html>
<!-- Coding by CodingNepal || www.codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hoverable Sidebar Menu HTML CSS & JavaScript</title>
    <link rel="stylesheet" href="styles.css" />
    <!-- Boxicons CSS -->
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="index.js" defer></script>
</head>
<body>
    <nav class="sidebar locked">
        <div class="logo_items flex">
            <span class="nav_image">
                <img src="images/logo.png" alt="logo_img" />
            </span>
            <span class="logo_name">CodingNepal</span>
            <i class="bx bx-lock-alt" id="lock-icon" title="Unlock Sidebar"></i>
            <i class="bx bx-x" id="sidebar-close"></i>
        </div>

        <div class="menu_container">
            <div class="menu_items">
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Dashboard</span>
                        <span class="line"></span>
                    </div>
                    <li class="item">
                        <a href="../../Admin/index.php" class="link flex">
                            <i class="bx bx-home-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>

                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Editor</span>
                        <span class="line"></span>
                    </div>
                    <li class="item">
                        <a href="#" class="link flex">
                            <i class="bx bx-cloud-upload"></i>
                            <span>Upload New</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar_profile flex">
                <span class="nav_image">
                    <img src="images/profile.jpg" alt="logo_img" />
                </span>
                <div class="data_text">
                    <span class="name"><?php echo $name ?></span>
                    <span class="username">@<?php echo $username ?></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Navbar -->
    <nav class="navbar flex">
        <i class="bx bx-menu" id="sidebar-open"></i>
        <input type="text" placeholder="Search..." class="search_box" />
        <div class="profile-dropdown">
            <span class="nav_image">
                <img src="images/profile.jpg" alt="profile_img" />
            </span>
            <div class="dropdown-content">
                <a href="#">Profile</a>
                <a href="#">Settings</a>
                <a href="#">Logout</a>
            </div>
        </div>
    </nav>
</body>
</html>
