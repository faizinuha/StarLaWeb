<?php
require_once __DIR__ . '/../allkoneksi/koneksi.php';

// Memulai sesi dan menghancurkannya
session_start();
session_unset();
session_destroy();

// Query untuk mendapatkan data pengguna
$sql = "SELECT id, name, profile_image_path FROM users";
$result = $koneksi->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Boxicons CSS -->
    <link href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .kpi {
            border-radius: 40px;
            width: 200px !important;
            position: relative;
            right: -450px;
        }

        .avatar {
            position: relative;
            top: 20px;
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>

<body class="py-5">
    <div class="container">
        <header class="d-flex justify-content-between align-items-center py-3">
            <img src="../assets/img/com.nexon.bluearchive.png" class="kpi" alt="Logo">
            <h3 class="text-center">Good Bye!</h3>
        </header>
        <div class="row mt-5">
            <?php foreach ($users as $user) : ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <a href="../login1/password.php?id=<?php echo $user['id']; ?>">
                            <?php if (!empty($user['profile_image_path'])) : ?>
                                <img src="<?php echo htmlspecialchars($user['profile_image_path']); ?>" alt="avatar" class="card-img-top mx-auto d-block avatar">
                            <?php else : ?>
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGst2EJfEU4M83w0oCJ0mpZ1O_n8jpiuvjOO4IvOFgRA&s" alt="avatar" class="card-img-top mx-auto d-block avatar">
                            <?php endif; ?>
                        </a>
                        <div class="card-body text-center m-2">
                            <p class="card-text font-weight-bold"><?php echo htmlspecialchars($user['name']); ?></p>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="../login1/login.php" class="btn btn-primary"><i class='bx bx-log-in'></i> Login Lagi</a>
        </div>
        <!-- <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Login</h2>
                    </div>
                    <div class="card-body">
                        <form id="loginForm" action="../login1/proses_data/proses_login.php" method="post">
                            <div class="mb-3">
                                <label for="emailOrUsername" class="form-label">Username or Email</label>
                                <input type="text" class="form-control" name="emailOrUsername" id="emailOrUsername" placeholder="Enter Email or Username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
                            </div>
                            <p class="text-center">Forgot code? Contact Customer Service</p>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="/index.php">Not Loggin</a>
                            <span class="mx-2">|</span>
                            <a href="register.php" class="btn-link">Register</a>
                            <span class="mx-2">|</span>
                            <a href="forgot_reset_password.php" class="btn-link">Forgot Password?</a>
                            <span class="mx-2">|</span>
                            <a href="javascript/kontak.php">Customer Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <!-- Boxicons JS -->
    <script src="https://cdn.jsdelivr.net/boxicons/2.0.7/js/boxicons.min.js"></script>
    
</body>

</html>

<!-- <?php
require_once __DIR__ . '/../allkoneksi/koneksi.php';
// Menggunakan file koneksi.php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        // Hapus bagian email
        $TikTok = $row['TikTok'];
        $instagram = $row['instagram'];
        $Twitter = $row['Twitter'];
        $about_me = $row['about_me'];
        $profile_image_path = !empty($row['profile_image_path']) ? $row['profile_image_path'] :
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGst2EJfEU4M83w0oCJ0mpZ1O_n8jpiuvjOO4IvOFgRA&s";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
<section class="h-100 gradient-custom-2">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center">
      <div class="col col-lg-9 col-xl-8">
        <div class="card">
          <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
              <img src="<?php echo $profile_image_path; ?>" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
              <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-dark text-body" data-mdb-ripple-color="dark" style="z-index: 1;">
                Edit profile
              </button>
            </div>
            <div class="ms-3" style="margin-top: 130px;">
              <h5><?php echo htmlspecialchars($name); ?></h5>
              <p>Location Info</p>
            </div>
          </div>
          <div class="p-4 text-black bg-body-tertiary">
            <div class="d-flex justify-content-end text-center py-1 text-body">
              <div>
                <p class="mb-1 h5">253</p>
                <p class="small text-muted mb-0">Photos</p>
              </div>
              <div class="px-3">
                <p class="mb-1 h5">1026</p>
                <p class="small text-muted mb-0">Followers</p>
              </div>
              <div>
                <p class="mb-1 h5">478</p>
                <p class="small text-muted mb-0">Following</p>
              </div>
            </div>
          </div>
          <div class="card-body p-4 text-black">
            <div class="mb-5 text-body">
              <p class="lead fw-normal mb-1">About</p>
              <div class="p-4 bg-body-tertiary">
                <p class="font-italic mb-1">Web Developer</p>
                <p class="font-italic mb-1">Lives in New York</p>
                <p class="font-italic mb-0"><?php echo htmlspecialchars($about_me); ?></p>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4 text-body">
              <p class="lead fw-normal mb-0">Recent photos</p>
              <p class="mb-0"><a href="#!" class="text-muted">Show all</a></p>
            </div>
            <div class="row g-2">
              <div class="col mb-2">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(112).webp" alt="image 1" class="w-100 rounded-3">
              </div>
              <div class="col mb-2">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(107).webp" alt="image 1" class="w-100 rounded-3">
              </div>
            </div>
            <div class="row g-2">
              <div class="col">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(108).webp" alt="image 1" class="w-100 rounded-3">
              </div>
              <div class="col">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(114).webp" alt="image 1" class="w-100 rounded-3">
              </div>
            </div>
          </div>
          <div class="card-body">
              <h5 class="card-title">Media Sosial</h5>
              <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex align-items-center">
                      <i class="bi bi-instagram text-danger me-2"></i>
                      <a href="<?php echo $instagram ?>" target="_blank" class="text-decoration-none"><?php echo $instagram ?></a>
                  </li>
                  <li class="list-group-item d-flex align-items-center">
                      <i class="bi bi-tiktok text-dark me-2"></i>
                      <a href="<?php echo $TikTok; ?>" target="_blank" class="text-decoration-none"><?php echo $TikTok; ?></a>
                  </li>
                  <li class="list-group-item d-flex align-items-center">
                      <i class="bi bi-twitter text-info me-2"></i>
                      <a href="<?php echo $Twitter ?>" target="_blank" class="text-decoration-none"><?php echo $Twitter ?></a>
                  </li>
              </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    function back() {
        window.history.back();
    }

    function logout() {
        window.location.href = 'profile_user.php';
    }
</script>
</body>
</html>

<?php
    } else {
        echo "Informasi pengguna tidak ditemukan.";
    }
} else {
    echo "Username tidak valid.";
}
?>
 -->