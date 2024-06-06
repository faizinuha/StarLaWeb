<?php
require_once __DIR__ . '/koneksi.php';

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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons CSS -->
    <link href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body class="py-5">
    <div class="container">
        <h1 class="text-center mb-5">Selamat Tinggal</h1>
        <h3 class="text-center mb-4">Akun Lain</h3>
        <div class="row">
            <?php foreach ($users as $user) : ?>
                <div class="col-md-5">
                    <div class="card mb-5">
                        <a href="../login1/password.php?id=<?php echo $user['id']; ?>">
                            <?php 
                            $profile_image_path = !empty($user['profile_image_path']) ? 'upload/' . $user['profile_image_path'] : "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGst2EJfEU4M83w0oCJ0mpZ1O_n8jpiuvjOO4IvOFgRA&s"; 
                            ?>
                            <img src="<?php echo htmlspecialchars($profile_image_path); ?>" alt="avatar" class="card-img-top mx-auto d-block" style="width: 160px; height: 160px;">
                            <div class="card-body text-center">
                                <p class="card-text font-weight-bold"><?php echo htmlspecialchars($user['name']); ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center">
            <a href="../login1/login.php" class="btn btn-primary"><i class='bx bx-log-in'></i> Login Lagi</a>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Boxicons JS -->
    <script src="https://cdn.jsdelivr.net/boxicons/2.0.7/boxicons.min.js"></script>
</body>

</html>
