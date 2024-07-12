<?php
session_start();
require_once __DIR__ . '/../allkoneksi/koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: ../login1/login.php');
    exit();
}

// Proses form jika ada pengiriman data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $uploaded_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    // Upload gambar
    $target_dir = "uploads/";
    $unique_name = uniqid() . '_' . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $unique_name;
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
    $allowedFormats = ['jpg', 'png', 'jpeg', 'gif', 'webp', 'anvi'];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG, GIF, and WEBP files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Simpan posting ke database
            $sql = "INSERT INTO posts (title, content, tags, image, uploaded_by, user_id) 
                    VALUES ('$title', '$content', '$tags', '$unique_name', '$uploaded_by', '$user_id')";
            if ($koneksi->query($sql) === TRUE) {
                header("Location: ../index.php");
                echo "Posting berhasil ditambahkan.";
            } else {
                echo "Error: " . $sql . "<br>" . $koneksi->error;
            }

            $koneksi->close();
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
     <!-- General CSS Files -->
    <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../assets/modules/bootstrap-social/bootstrap-social.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/components.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .preview-image {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
        }
        .btn-kembali {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .alert-custom {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- sidebars -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- end sidebar -->
    <div class="container">
        <a href="../index.php" class="btn btn-danger btn-kembali">Kembali</a>
        <div class="alert alert-danger text-center alert-custom" role="alert">
            Mohon Upload gambar yang Positif
        </div>
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
                <label for="tags">Tags:</label>
                <input type="text" id="tags" name="tags" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="image" class="form-group">Gambar:</label>
                <input type="file" id="image" name="image" class="form-control-file" onchange="previewImage(this)" required>
                <img id="imagePreview" class="img-fluid mt-2" src="#" alt="Preview Image" style="display: none;">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Unggah</button>
        </form>
    </div>
    <style>
        .ryu:hover {
            border-radius: 20px;
            transition: 0.2s ease-in-out;
            background-color: rgba(0, 0, 0, 0.1);
            color: white;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        }
    </style>
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
