<?php
include_once "koneksi.php"; // Menggunakan file koneksi.php

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $username);
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
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body text-center">
                                <img src="<?php echo $profile_image_path; ?>" alt="avatar" class="rounded-5 mb-3" style="width: 150px;">
                                <h5 class="card-title">Name:<?php echo htmlspecialchars($name); ?></h5>
                                <p class="text-muted">@<?php echo htmlspecialchars($username); ?></p>
                                <div class="d-flex justify-content-center mb-3">
                                    <button onclick="back()" class="btn btn-secondary me-2"><i class="bi bi-arrow-left"></i> Back</button>
                                    <button onclick="logout()" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Edit</button>
                                    <!-- <div class="col-md-auto left ">
                                        <a href="../message-player/index.php" type="button" class="btn btn-outline-danger"><i class="bi bi-chat-right-text"></i></a>
                                    </div> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Nama Lengkap</h6>
                                <p class="card-text"><?php echo htmlspecialchars($name); ?></p>
                                <p class="card-text"><a href="../SpeedTyping/index.html">Latihan Ngetik</a></p>
                                <h6 class="card-subtitle mb-2 text-muted">Tentang Saya</h6>
                                <p class="card-text"><?php echo htmlspecialchars($about_me); ?></p>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Media Sosial</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-instagram text-danger me-2"></i>
                                        <a href="<?php echo htmlspecialchars($instagram); ?>" class="text-decoration-none"><?php echo htmlspecialchars($instagram); ?></a>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-tiktok text-dark me-2"></i>
                                        <a href="<?php echo htmlspecialchars($TikTok); ?>" class="text-decoration-none"><?php echo htmlspecialchars($TikTok); ?></a>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-twitter text-info me-2"></i>
                                        <a href="<?php echo htmlspecialchars($Twitter); ?>" class="text-decoration-none"><?php echo htmlspecialchars($Twitter); ?></a>
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