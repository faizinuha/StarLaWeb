<?php
include_once "../koneksi.php"; // Menggunakan file koneksi.php

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
        $email = $row['email'];
        $TikTok = $row['TikTok'];
        $instagram = $row['instagram'];
        $Twitter = $row['Twitter'];
        $about_me = $row['about_me'];
        $profile_image_path = !empty($row['profile_image_path']) ? $row['profile_image_path'] : "https://via.placeholder.com/150";
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <title>Profil Pengguna</title>
        </head>
        <body>
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <img src="<?php echo $profile_image_path; ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                <h5 class="my-3"><?php echo htmlspecialchars($name); ?></h5>
                                <p class="text-muted mb-1"><?php echo htmlspecialchars($username); ?></p>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nama Lengkap</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo htmlspecialchars($name); ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo htmlspecialchars($email); ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Tentang Saya</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo htmlspecialchars($about_me); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush rounded-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fa fa-instagram" style="color: #C13584;"></i>
                                        <p class="mb-0"><a href="<?php echo htmlspecialchars($instagram); ?>" class="text-primary" target="_blank"><?php echo htmlspecialchars($instagram); ?></a></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fa fa-tiktok" style="color: #000000;"></i>
                                        <p class="mb-0"><a href="<?php echo htmlspecialchars($TikTok); ?>" class="text-primary" target="_blank"><?php echo htmlspecialchars($TikTok); ?></a></p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fa fa-twitter" style="color: #1DA1F2;"></i>
                                        <p class="mb-0"><a href="<?php echo htmlspecialchars($Twitter); ?>" class="text-primary" target="_blank"><?php echo htmlspecialchars($Twitter); ?></a></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
