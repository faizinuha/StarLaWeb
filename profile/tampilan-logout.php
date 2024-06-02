<?php
require_once __DIR__ . '/koneksi.php';

// Start session and destroy it
session_start();
session_unset();
session_destroy();

// Query to get user data
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
<html lang="en">
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
        <h1 class="text-center mb-5">Welcome to Logout</h1>
        <h3 class="text-center mb-4">Other Accounts</h3>
        <div class="row">
            <?php foreach ($users as $user): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                    <a href="../login1/password.php?id=<?php echo $user['id']; ?>">
                            <img src="<?php echo $user['profile_image_path']; ?>" alt="avatar" class="card-img-top rounded-circle mx-auto d-block" style="width: 150px; height: 150px;">
                            <div class="card-body text-center">
                                <p class="card-text font-weight-bold"><?php echo htmlspecialchars($user['name']); ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center">
            <a href="../login1/login.php" class="btn btn-primary"><i class='bx bx-log-in'></i> Login Again</a>
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
