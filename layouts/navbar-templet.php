<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$database = "blog";

// Create connection to database
$koneksi = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Default name if not logged in
$name = "Not Loggin";

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
    <title>Navbar Design</title>
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

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

        .cursor {
            cursor: pointer;
        }

        .list-group {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
  <!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top bg-gray-100">
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
                           <i class="bi bi-person-circle"></i> <?php echo $name; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile/profile_user.php"><i class="bi bi-person"></i> Your Profile</a></li>
                            <li><a class="dropdown-item cursor" href="blogs/upload.php"><i class="bi bi-plus-circle"></i> Upload</a></li>
                            <li><a class="dropdown-item cursor1" href="Private/setting.php">  <i class="bi bi-gear-wide"></i> Setting</a></li>
                            <li><a class="dropdown-item cursor1" href="Private/contant.php">  <i class="bi bi-gear-wide"></i> Akses Contct</a></li>
                            <li><hr class="dropdown-divider"></li>
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

    <!-- Categories -->
    <!-- <div class="container">
        <ul class="list-group list-group-flush">
            <h3 class="alert alert-danger">Category</h3>
            <?php
            // Establish database connection
            $conn = new mysqli("localhost", "root", "", "blog");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch unique tag categories
            $sql_tags = "SELECT DISTINCT Tags FROM posts";
            $result_tags = $conn->query($sql_tags);

            // Display tags if available
            if ($result_tags->num_rows > 0) {
                while ($row_tags = $result_tags->fetch_assoc()) {
                    // Get the tag name
                    $tags = explode(',', $row_tags['Tags']);
                    foreach ($tags as $tag) {
                        $tag = htmlspecialchars(trim($tag), ENT_QUOTES, 'UTF-8');
                        // Prepare the URL with query string
                        $url = 'category_detail.php?tag=' . urlencode($tag);
                        echo '<li class="list-group-item"><a href="' . $url . '">' . $tag . '</a></li>';
                    }
                }
            } else {
                echo '<li class="list-group-item">No tags available</li>';
            }

            // Close database connection
            $conn->close();
            ?>
        </ul>
    </div> -->

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
