<?php include('layouts/navbar-templet.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icons" href="https://t4.ftcdn.net/jpg/04/92/55/37/360_F_492553733_M1ewmNvrx917YggK3b6IQjiqKzbCpufW.jpg">
    <title>Blogger</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="styles.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->

    <!-- partilas -->
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
        .cursor {
            cursor: pointer;
        }

        .text {
            border: 2px solid red;
            position: relative;
            top: 100;
            
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
    <!-- pesan berhasil login -->
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12">
                        <?php if (isset($_GET['login_success'])) : ?>
                            <div class="alert alert-success" role="alert">
                                <div id="toast-simple" class="flex items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800" role="alert">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-500 rotate-45" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9" />
                                    </svg>
                                    <div class="ps-4 text-sm font-normal">Selamat datang:<?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <h1 id="time">Selamat datang di halaman utama!</h1>
                        <!-- Konten lainnya di sini -->
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Particles container -->
    <div id="particles-js"></div>

    <div class="content">
        <!-- <div id="alert" onclick="valida()"></div> -->
        <div class="container main">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="card mt-2">
                        <div class="card-header text border">
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
                                        echo '<li class="list-group-item"><a href="category.php?Tags=' . $row['Tags'] . '">#' . htmlspecialchars($row['Tags']) . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-8">
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
                                <div class="card mt-4">
                                    <div class="w-150">
                                        <div class="position-relative">
                                            <img src="blogs/uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top post-image mt-3 img-fluid" style="border-radius: 10px;" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                            <div class="card-body">
                                                <div class="profile-container cursor">
                                                    <?php if (!empty($row['profile_image_path'])) : ?>
                                                        <img onclick="window.location = './profile/profile-pengguna.php?id=<?= htmlspecialchars($row['user_id']); ?>'" src="profile/<?php echo htmlspecialchars($row['profile_image_path']); ?>" alt="avatar" class="profile-image">
                                                    <?php else : ?>
                                                        <img onclick="window.location = './profile/profile-pengguna.php?id=<?php echo htmlspecialchars($row['user_id']); ?>'" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGst2EJfEU4M83w0oCJ0mpZ1O_n8jpiuvjOO4IvOFgRA&s" alt="avatar" class="profile-image">
                                                    <?php endif; ?>
                                                    <span><?php echo htmlspecialchars($row['uploaded_by']); ?></span>
                                                </div>
                                                <h5 class="card-title"><strong>Judul:</strong> <?php echo htmlspecialchars($row['title']); ?></h5>
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
                                                            <li><a class="dropdown-item " href="edit_post.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit <i class="bi bi-pencil-square"></i></a></li>
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
    <!-- stisla -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
    <script>
        setTimeout(function() {
            document.getElementById('app').setAttribute('style', 'display:none;')
        }, 5000)
    </script>
</body>

</html>