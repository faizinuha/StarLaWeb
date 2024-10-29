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
// require_once __DIR__ . '/../admin/componen.php';

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

if ($koneksi) {
    // Ambil ID pengguna yang sedang login
    $user_id = $_SESSION['user_id'] ?? 0; // Gunakan default jika user_id tidak tersedia

    // Ambil jumlah notifikasi belum dibaca
    $query = "SELECT COUNT(*) as unread_count FROM notifications WHERE user_id = ? AND is_read = 0";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $unread_count = $result->fetch_assoc()['unread_count'] ?? 0;

    // Menutup statement setelah selesai
    $stmt->close();
}

// Siapkan query untuk mengambil notifikasi
$notif_query = "SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC LIMIT 5";
$notif_stmt = $koneksi->prepare($notif_query);
$notif_stmt->bind_param("i", $user_id);
$notif_stmt->execute();
$notif_result = $notif_stmt->get_result();

?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('notificationCount').textContent = '<?= $unread_count ?>';
    });
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter</title>
    <link rel="icon" href="../asset/img/paimon-genshin-impact.avif">
    <!-- Bootstrap CSS -->
    <?php
    include_once 'link.php';
    include_once 'script.php';
    ?>
    <style>
        * {
            scroll-behavior: smooth;
            margin: 0;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #343a40;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
        }

        .navbar-brand span {
            color: red;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: rgba(255, 255, 255, 1);
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container mx-auto">
            <a class="navbar-brand" href="#">BLO<span>G</span>ER</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto space-x-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i> Notifications
                            <span id="notificationCount" class="badge bg-danger rounded-pill">
                                <?= $unread_count ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                            <?php while ($notif = $notif_result->fetch_assoc()) { ?>
                                <li><a class='dropdown-item' href='#'><?= $notif['message'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link cursor" href="blogs/upload.php"><i class="bi bi-plus-circle"></i> Upload</a>
                    </li>
                    <?php if (isset($_SESSION['username'])) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> <?= $name; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
                            <a class="nav-link" href="auth/login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="auth/register.php"><i class="bi bi-pencil-square"></i> Register</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Scripts -->
    <?php
    // Menutup koneksi setelah semua query dieksekusi
    mysqli_close($koneksi);
    ?>
</body>

</html>
