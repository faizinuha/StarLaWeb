<?php
// Termasuk file koneksi
include_once "koneksi.php";

// Memulai sesi
session_start();

// Memeriksa apakah user_id telah diatur
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Memeriksa apakah data formulir telah dikirimkan
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_image"])) {
        // Path untuk menyimpan gambar
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Memeriksa apakah file gambar valid
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Memeriksa apakah file gambar sudah ada
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Memeriksa ukuran file
        if ($_FILES["profile_image"]["size"] > 900000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Izinkan hanya format gambar tertentu
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Jika semua validasi terpenuhi, simpan file gambar
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                // Simpan path gambar ke database
                $image_path = $target_file;
                $query = "UPDATE users SET profile_image_path=? WHERE id=?";
                $stmt = mysqli_prepare($koneksi, $query);
                mysqli_stmt_bind_param($stmt, "si", $image_path, $user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                echo "The file " . basename($_FILES["profile_image"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
} else {
    // Jika user_id tidak diatur
    echo "User ID tidak ditemukan.";
}

// Tutup koneksi ke database (jika tidak menggunakan koneksi persistent)
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Edit Profil</title>
</head>

<body>
    <div class="container">
        <h1>Edit Profil</h1>
        <div class="card">
            <div class="card-body">
                <!-- Tambahkan tautan ke halaman pengeditan foto profil -->
                <a href="#">
                    <img src="upload/<?php echo $row['profile_image_path'] ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                </a>
                <!-- Form untuk mengunggah foto profil -->
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-group mt-3">
                        <label for="profile_image">Pilih foto baru:</label>
                        <input type="file" class="form-control-file" id="profile_image" name="profile_image">
                    </div>
                    <input type="submit" value="Upload Image" name="submit" class="btn btn-primary">
                    <a href="profile_user.php" class="btn btn-danger ">Back</a>
                </form>
            </div>
        </div>
    </div>
</body>
<!-- https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp -->
</html>
