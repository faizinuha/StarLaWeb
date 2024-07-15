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
    <!-- Bootstrap CSS -->
    <!-- General CSS Files -->
    <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../assets/modules/bootstrap-social/bootstrap-social.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/components.css">
    <!-- Start GA -->
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

        .login-brand img {
            width: 100px;
            border-radius: 50%;
        }
    </style>
</head>

<body class="py-5">
    <div class="container">
        <header class="d-flex justify-content-between align-items-center py-3">
            <h3 class="text-center">Good Bye!</h3>
        </header>
        <div class="row mt-5">
            <!-- Daftar Pengguna -->
            <div class="col-md-8">
                <div class="row">
                    <?php foreach ($users as $user) : ?>
                        <div class="col-md-4 mb-4">
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
            </div>

            <!-- Form Login -->
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="login-brand">
                        <img src="../asset/img/paimon-genshin-impact.avif" alt="logo" class="shadow-light">
                    </div>
                    <div class="card-header">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST"class="needs-validation" action="../login1/proses_data/proses_login.php" novalidate="">
                            <div class="form-group">
                                <label for="emailOrUsername" class="form-label">Username or Email</label>
                                <div class="float-right">
                                    <a href="../login1/register.php" class="text-small">Register</a>
                                </div>
                                <input type="text" class="form-control" name="emailOrUsername" id="emailOrUsername" placeholder="Enter Email or Username" required autofocus>
                                <div class="invalid-feedback">Please fill in your email</div>
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="float-right">
                                        <a href="../login1/forgot_reset_password.php" class="text-small">Forgot Password?</a>
                                    </div>
                                </div>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" tabindex="2" required>
                                <div class="invalid-feedback">Please fill in your password</div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">Login</button>
                            </div>
                        </form>
                        <div class="text-center mt-4 mb-3">
                            <div class="text-job text-muted">Login With Social</div>
                        </div>
                        <div class="row sm-gutters">
                            <div class="col-6">
                                <a class="btn btn-block btn-social btn-twitter">
                                    <span class="fab fa-discord"></span> Discord
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <!-- Boxicons JS -->
    <script src="https://cdn.jsdelivr.net/boxicons/2.0.7/js/boxicons.min.js"></script>
</body>

</html>