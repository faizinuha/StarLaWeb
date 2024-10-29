<?php

session_start();
require_once __DIR__ . '/../allkoneksi/koneksi.php';
require_once __DIR__ . '/../layouts/sidebars.php';
// Menggunakan file koneksi.php
$logged_in_user_id = $_SESSION['user_id'];  // Assuming you have the logged-in user ID in the session
$profile_user_id = $_GET['id'];

$is_following = false;

// Check if the logged-in user follows the profile user
$check_follow_query = "SELECT * FROM followers WHERE follower_id = ? AND followed_id = ?";
$stmt = $koneksi->prepare($check_follow_query);
$stmt->bind_param("ii", $logged_in_user_id, $profile_user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $is_following = true;
}

// Fungsi untuk mendapatkan total data dari query yang diberikan
function getTotalData($koneksi, $query)
{
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0;
    }
}

$total_data = getTotalData($koneksi, "SELECT COUNT(*) as total FROM followers");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);  // id harus integer, jadi gunakan "i"
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $TikTok = $row['TikTok'];
        $instagram = $row['instagram'];
        $Twitter = $row['Twitter'];
        $about_me = $row['about_me'];
        $profile_image_path = !empty($row['profile_image_path']) ? $row['profile_image_path'] : "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGst2EJfEU4M83w0oCJ0mpZ1O_n8jpiuvjOO4IvOFgRA&s";


        // Menghitung jumlah followers untuk pengguna ini
        $follower_count_query = "SELECT COUNT(*) as total_followers FROM followers WHERE followed_id = ?";
        $stmt = $koneksi->prepare($follower_count_query);
        $stmt->bind_param("i", $profile_user_id);  // bind parameter untuk profile_user_id
        $stmt->execute();
        $follower_count_result = $stmt->get_result();
        $follower_count = $follower_count_result->fetch_assoc()['total_followers']; // ambil total followers
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Profil Pengguna</title>
            <link rel="stylesheet" href="../assets/css/style.css">
            <link rel="stylesheet" href="../assets/css/components.css">
            <!-- Start GA -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        </head>

        <body class="bg-light">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Profil Pengguna</h5>
                                <button onclick="back()" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</button>
                            </div>
                            <div class="card-body text-center">
                                <img src="<?php echo $profile_image_path; ?>" alt="avatar" class="rounded-5 mb-3" style="width: 150px;">
                                <a href="../daftar_follow/daftar_follwo.php" style="color:black;">
                                <p class="small">Followers: <?php echo $follower_count; ?></p>
                            </a>
                                <?php if ($is_following): ?>
                                    <button class="btn btn-danger" onclick="toggleFollow(<?php echo $profile_user_id; ?>, 'unfollow')">Unfollow</button>
                                <?php else: ?>
                                    <button class="btn btn-primary" onclick="toggleFollow(<?php echo $profile_user_id; ?>, 'follow')">Follow</button>
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Nama Lengkap</h6>
                                <p class="card-text"><?php echo htmlspecialchars($name); ?></p>
                                <h6 class="card-subtitle mb-2 text-muted">Tentang Saya</h6>
                                <p class="card-text"><?php echo htmlspecialchars($about_me); ?></p>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Media Sosial</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-instagram text-danger me-2"></i>
                                        <a href="<?php echo !empty($instagram) ? $instagram : '#'; ?>" target="_blank" class="text-decoration-none">
                                            <?php echo !empty($instagram) ? $instagram : 'Instagram tidak tersedia'; ?>
                                        </a>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-tiktok text-dark me-2"></i>
                                        <a href="<?php echo !empty($TikTok) ? $TikTok : '#'; ?>" target="_blank" class="text-decoration-none">
                                            <?php echo !empty($TikTok) ? $TikTok : 'TikTok tidak tersedia'; ?>
                                        </a>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-twitter text-info me-2"></i>
                                        <a href="<?php echo !empty($Twitter) ? $Twitter : '#'; ?>" target="_blank" class="text-decoration-none">
                                            <?php echo !empty($Twitter) ? $Twitter : 'Twitter tidak tersedia'; ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function back() {
                    window.history.back();
                }

                function toggleFollow(userId, action) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'follow_action.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            location.reload(); // Reload page setelah aksi follow/unfollow
                        }
                    };
                    xhr.send('user_id=' + userId + '&action=' + action);
                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo "Informasi pengguna tidak ditemukan.";
    }
} else {
    echo "ID pengguna tidak valid.";
}
?>