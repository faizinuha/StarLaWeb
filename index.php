<?php include('layouts/navbar-templet.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://t4.ftcdn.net/jpg/04/92/55/37/360_F_492553733_M1ewmNvrx917YggK3b6IQjiqKzbCpufW.jpg">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0"></script>

    <style>
        .post-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 15px;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .button-container a {
            margin-left: 10px;
        }

        #particles-js {
            cursor: default !important;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }
    </style>
</head>

<body>
    <!-- Particles container -->
    <div id="particles-js"></div>

    <div class="container">
        <!-- Add your navigation bar here if needed -->
    </div>
    <div class="content">
        <div id="alert" onclick="valida()"></div>
        <!-- <div class="text-center">
            <h1 class="text-center">Wii Lose</h1>
        </div> -->

        <div class="container main">
            <hr>
            <div class="row">
                <?php
                // Koneksi ke database
                $conn = new mysqli("localhost", "root", "", "blog");

                // Periksa koneksi
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                // Memeriksa apakah ada pengguna yang login
                $current_user = isset($_SESSION['username']) ? $_SESSION['username'] : '';

                // Query untuk mengambil data posting
                $sql = "SELECT * FROM posts ORDER BY upload_date DESC LIMIT 9999";
                $result = $conn->query($sql);

                // Cek apakah ada postingan
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card mb-3">
                                <div class="position-relative">
                                    <div class="card-body">
                                        <h2 class="card-title">Judul: <?php echo htmlspecialchars($row['title']); ?></h2>
                                        <p class="card-text">Deskripsi: <?php echo htmlspecialchars($row['content']); ?></p>
                                        <p><strong>Tags:</strong> <?php echo htmlspecialchars($row['Tags']); ?></p>
                                    </div>
                                    <img src="blogs/uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top post-image" alt="<?php echo htmlspecialchars($row['title']); ?>">

                                    <div class="overlay position-absolute top-0 end-0 m-2">
                                        <?php if ($current_user == $row['uploaded_by']) { ?>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-gear-wide"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="edit_post.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit <i class="bi bi-pencil-square"></i></a></li>
                                                    <li><a class="dropdown-item" href="delete_post.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">Delete <i class="bi bi-trash"></i></a></li>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="card-footer text-muted d-flex justify-content-between align-items-center">
                                    <div>
                                        Diposting oleh: <?php echo htmlspecialchars($row['uploaded_by']); ?> pada <?php echo htmlspecialchars($row['upload_date']); ?>
                                    </div>

                                    <div class="button-container">
                                        <a href="blogs/komen.php?post_id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary"><i class="bi bi-chat-left"></i></a>
                                        <a href="in/download.php?gambar=<?php echo htmlspecialchars($row['image']); ?>" class="btn btn-primary"><i class="bi bi-download"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <p class="alert alert-dark mr-3">Tidak ada gambar</p>
                    <a href="blogs/upload.php" class="alert alert-dark me-1">Klik di sini untuk post</a>
                <?php
                }

                // Tutup koneksi
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <script>
        particlesJS.load('particles-js', 'particles-config.json', function() {
            console.log('particles.js loaded - callback');
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+0pEd5eY1z4+cBB+z8V+W9CKMpYW4" crossorigin="anonymous"></script>
</body>

</html>
