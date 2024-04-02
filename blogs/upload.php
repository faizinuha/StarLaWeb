<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: ../login1/login.php');
    exit();
}

// Proses form jika ada pengiriman data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $uploaded_by = $_SESSION['username'];

    // Upload gambar
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 9999999) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Koneksi ke database
            $conn = new mysqli("localhost", "root", "", "blog_db");

            // Periksa koneksi
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Simpan posting ke database
            $sql = "INSERT INTO posts (title, content, image, uploaded_by) VALUES ('$title', '$content', '" . basename($_FILES["image"]["name"]) . "', '$uploaded_by')";
            if ($conn->query($sql) === TRUE) {
                header("Location: ../index.php");
                echo "Posting berhasil ditambahkan.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Posting</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tambahan gaya kustom di sini jika diperlukan */
        .preview-image {
            max-width: 100%;
            max-height: 200px;
            /* Atur tinggi maksimum sesuai kebutuhan */
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- sidebars -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Custom CSS for Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            background-color: #343a40;
            padding-top: 3.5rem;
            /* Height of navbar */
            overflow-x: hidden;
            transition: all 0.3s;
        }

        .sidebar-nav {
            padding: 0;
        }

        .sidebar-nav .nav-item {
            margin: 0;
        }

        .sidebar-nav .nav-link {
            padding: 10px 15px;
            text-align: left;
            color: rgba(255, 255, 255, 0.75);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
            }
        }
    </style>
    </head>

    <body>
        <div class="sidebar">
            <ul class="sidebar-nav nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Beranda</a>
                </li>
                <?php
                // Periksa apakah pengguna sudah login
                if (isset($_SESSION['username'])) { ?>
                    <!-- <li class="nav-item">
                        <a href="in/logout.php" class="nav-link">Log Out</a>
                    </li> -->
                    <li class="nav-item">
                        <a href="upload.php" class="nav-link">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../profile/profile_user.php">Profile</a>
                    </li>
                <?php
                } else {
                    // Jika belum login, tampilkan menu login dan registrasi
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login1/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login1/register.php">Registrasi</a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>

        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Blog</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main content -->
            <div class="container-fluid">
                <!-- Content here -->
            </div>
        </div>

        <!-- Bootstrap JS (Optional) -->
      

<!-- end sidebar -->
<div class="container">
    <h1 class="mt-4">Tambah Posting Baru</h1>
    <form action="" method="post" enctype="multipart/form-data" class="mt-4">
        <div class="form-group">
            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">Konten:</label>
            <textarea id="content" name="content" rows="4" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="image" class="form-group">Gambar:</label>
            <input type="file" id="image" name="image" class="form-control-file" onchange="previewImage(this)" required>
            <img id="imagePreview" class="preview-image" src="#" alt="Preview Image" style="display: none;">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Unggah</button>
        <div class="alert alert-danger text-center mt-1" role="alert">
            Mohon Upload gambar yang Positif
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Function to preview the selected image
    function previewImage(input) {
        var preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]); // Convert to base64 string
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>
</body>

</html>