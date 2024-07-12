<?php
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
            <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

            <!-- CSS Libraries -->

            <!-- Template CSS -->
            <link rel="stylesheet" href="../assets/css/style.css">
            <link rel="stylesheet" href="../assets/css/components.css">
            <!-- Start GA -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
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
                                <h5 class="card-title">Name: <?php echo htmlspecialchars($name); ?></h5>
                                <p class="text-muted">@<?php echo htmlspecialchars($username); ?></p>
                            </div>
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted font-bold">Nama Lengkap</h6>
                                <p class="card-text font-bold"><?php echo htmlspecialchars($name); ?></p>
                                <h6 class="card-subtitle mb-2 text-muted">Tentang Saya</h6>
                                <p class="card-text"><?php echo htmlspecialchars($about_me); ?></p>
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