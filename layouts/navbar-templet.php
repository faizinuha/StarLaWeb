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

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT name FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
    } else {
        $name = "Guest";
    }
} else {
    $name = "Guest";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Navbar Design</title>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
     <!-- Bootstrap Icons -->
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
     .cursor{
          cursor: cell;
     }
     </style>
</head>

<body>
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg sticky-top ">
          <div class="container-fluid">
               <a class="navbar-brand" href="#">Bloger</a>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                         <?php if (isset($_SESSION['username'])) { ?>
                         <li class="nav-item">
                         </li>
                         <li class="nav-item dropdown">

                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                   <i class="bi bi-person-circle"></i> <?php echo $name; ?>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                   <li><a class="dropdown-item" href="profile/profile_user.php"><i
                                                  class="bi bi-person"></i> Your Profile</a></li>
                                   <a href="blogs/upload.php" class="nav-link m-2 cursor"><i class="bi bi-plus-circle"></i>
                                        Upload</a>

                                   <li>
                                        <hr class="dropdown-divider">
                                   </li>
                                   <li><a class="dropdown-item" href="in/logout.php"><i
                                                  class="bi bi-box-arrow-right"></i> Sign out</a></li>
                              </ul>
                         </li>
                         <?php } else { ?>
                         <li class="nav-item">
                              <a class="nav-link" href="login1/login.php"><i class="bi bi-box-arrow-in-right"></i>
                                   Login</a>
                         </li>
                         <li class="nav-item">
                              <a class="nav-link" href="login1/register.php"><i class="bi bi-pencil-square"></i>
                                   Register</a>
                         </li>
                         <?php } ?>
                         <li class="nav-item">
                              <a href="https://discord.gg/rvaNTU63s3" class="btn btn-primary hover"><i
                                        class="bi bi-discord"></i> Join Discord</a>
                         </li>
                    </ul>
               </div>
          </div>
     </nav>
     <!-- End Navbar -->
                              <style>
                                   .hover{
                                        
                                        border-radius: 50px;
                                   }
                                   .hover:hover{
                                        border-radius: 20px;
                                        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
                                        transition: 0.5s;
                                        background-color: rgba(0, 0, 0, 0.1);
                                        color: white;
                                       
                                   }
                              </style>
     <!-- Bootstrap JS (Optional) -->
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
          integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
     </script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
          integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
     </script>
</body>

</html>