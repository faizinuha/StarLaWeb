<?php
session_start();
require_once __DIR__ . '/../allkoneksi/koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Proses form jika ada pengiriman data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $uploaded_by = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $status = $_POST['status'];

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
    $allowedFormats = ['jpg', 'png', 'jpeg', 'gif', 'webp'];
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
            $sql = "INSERT INTO posts (title, content, tags, image, uploaded_by, user_id, status) 
                    VALUES ('$title', '$content', '$tags', '$unique_name', '$uploaded_by', '$user_id', '$status')";
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
    <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/modules/bootstrap-social/bootstrap-social.css">
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
    <div class="container">
        <a href="../index.php" class="btn btn-danger btn-kembali">Kembali</a>
        <div class="alert alert-danger text-center alert-custom" role="alert">
            Mohon Upload gambar yang Positif
        </div>
        <h1 class="mt-4">Tambah Posting Baru</h1>
        <form action="" method="post" enctype="multipart/form-data" class="mt-4" id="myForm" onsubmit="return validateform()">
            <div class="form-group">
                <label for="title">Judul:</label>
                <input type="text" id="title" name="title" class="form-control"  required>
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
                <label for="status">Status:</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="uploads">Uploads</option>
                </select>
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
    <script src="../assets/modules/jquery.min.js"></script>
    <script src="../assets/modules/popper.js"></script>
    <script src="../assets/modules/tooltip.js"></script>
    <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="../assets/modules/moment.min.js"></script>
    <script src="../assets/js/stisla.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script>             
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
        function validateform(){
            var title = document.getElementById("title").value;
            if(title.includes("h1","h2","h3","h4")){
                alert('Maaf Kata2 Blokir');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
