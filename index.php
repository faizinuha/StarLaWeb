<?php include('layouts/navbar-templet.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icons" href="https://t4.ftcdn.net/jpg/04/92/55/37/360_F_492553733_M1ewmNvrx917YggK3b6IQjiqKzbCpufW.jpg">
    <title>Blogger</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0"></script>

    <style>
        .post-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
            max-height: 300px;
            object-fit: cover;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .zoom {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .profile-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
        }

        .profile-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        /* cursor */
        .cursor{
            cursor: pointer;
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
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- col-md-4 -->
                    <div class="card">
                        <div class="card-header">
                            Categories
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <?php
                                include 'allkoneksi/koneksi.php';
                                $sql = "SELECT DISTINCT Tags FROM posts";
                                $result = $koneksi->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<li class="list-group-item"><a href="category.php?Tags=' . $row['Tags']. '">#' . htmlspecialchars($row['Tags']) . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-9">
                    <hr>
                    <div class="row">
                        <?php
                        // Koneksi ke database
                        include 'allkoneksi/koneksi.php';
                        // Buat koneksi ke database
                        $koneksi = new mysqli($host, $username, $password, $database);

                        // Periksa koneksi
                        if ($koneksi->connect_error) {
                            die("Koneksi gagal: " . $koneksi->connect_error);
                        }

                        // Memeriksa apakah ada pengguna yang login
                        $current_user = isset($_SESSION['username']) ? $_SESSION['username'] : '';

                        $sql = "SELECT posts.*, users.profile_image_path FROM posts 
                                JOIN users ON posts.uploaded_by = users.username 
                                ORDER BY upload_date DESC LIMIT 9999";

                        $result = $koneksi->query($sql);

                        // Cek apakah ada postingan
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <div class="card mb-5">
                                    <div class="w-100">
                                        <div class="position-relative">
                                            <img src="blogs/uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top post-image mt-4 img-fluid" style="border-radius: 10px;" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                            <div class="card-body">
                                                <div class="profile-container cursor " >
                                                    <?php if (!empty($row['profile_image_path'])) : ?>
                                                        <img onclick="window.location = './profile/profile-pengguna.php?id=<?= htmlspecialchars($row['user_id']); ?>'" src="profile/<?php echo htmlspecialchars($row['profile_image_path']); ?>" alt="avatar" class="profile-image">
                                                    <?php else : ?>
                                                        <img onclick="window.location = './profile/profile-pengguna.php?id=<?php echo htmlspecialchars($row['user_id']); ?>'" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGst2EJfEU4M83w0oCJ0mpZ1O_n8jpiuvjOO4IvOFgRA&s" alt="avatar" class="profile-image">
                                                    <?php endif; ?>
                                                    <span><?php echo htmlspecialchars($row['uploaded_by']); ?></span>
                                                </div>
                                                <h5 class="card-title">Judul: <?php echo htmlspecialchars($row['title']); ?></h5>
                                                <p class="card-text">Deskripsi: <?php echo htmlspecialchars($row['content']); ?></p>
                                                <p><strong>Tags:</strong> <?php echo htmlspecialchars($row['Tags']); ?></p>
                                            </div>
                                            <div class="overlay position-absolute top-0 end-0 m-2">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-gear-wide"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php if ($current_user == $row['uploaded_by']) { ?>
                                                            <li><a class="dropdown-item" href="edit_post.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit <i class="bi bi-pencil-square"></i></a></li>
                                                            <li><a class="dropdown-item" href="delete_post.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">Delete <i class="bi bi-trash"></i></a></li>
                                                        <?php } ?>
                                                        <li><a href="in/download.php?gambar=<?php echo htmlspecialchars($row['image']); ?>" class="dropdown-item">Simpan Foto <i class="bi bi-download"></i></a></li>
                                                        <li><a href="Private/report.html" class="dropdown-item">Report <i class="bi bi-exclamation-triangle"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div>
                                                    Diposting pada <?php echo htmlspecialchars($row['upload_date']); ?>
                                                </div>
                                                <div class="button-container">
                                                    <a href="blogs/komen.php?post_id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary"><i class="bi bi-chat-left"></i></a>
                                                    <a href="layouts/like.php?action=like&post_id=<?php echo htmlspecialchars($row['id']); ?>&type=like" class="btn btn-primary"><i class="bi bi-hand-thumbs-up"></i> <span id="likeCount<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['likes']); ?></span></a>
                                                    <a href="layouts/dislike.php?action=dislike&post_id=<?php echo htmlspecialchars($row['id']); ?>&type=dislike" class="btn btn-danger"><i class="bi bi-hand-thumbs-down"></i> <span id="dislikeCount<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['dislikes']); ?></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <p class="alert alert-dark mr-3 text-center underline-danger">Tidak ada gambar</p>
                            <a href="blogs/upload.php" class="alert alert-dark me-1">Klik di sini untuk post</a>
                        <?php
                        }

                        // Tutup koneksi
                        $koneksi->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        particlesJS.load('particles-js', 'particles-config.json', function() {
            console.log('particles.js loaded - callback');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7pL+0pEd5eY1z4+cBB+z8V+W9CKMpYW4" crossorigin="anonymous"></script>
</body>

</html>
