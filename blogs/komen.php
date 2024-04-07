<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login1/login.php");
    exit();
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "blog_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $content = trim($_POST['content']);

    $sql = "INSERT INTO comments (author, content, created_at) VALUES (?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['username'], $content);
    $stmt->execute();

    $stmt->close();

    // Redirect to prevent form resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Fetch comments from database
$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_image_path"])) {
    // Path untuk menyimpan gambar
    $target_dir = "../profile/upload/";
    $target_file = $target_dir . basename($_FILES["profile_image_path"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Memeriksa ukuran file
    if ($_FILES["profile_image_path"]["size"] > 900000) {
        echo "Maaf, file Anda terlalu besar.";
        $uploadOk = 0;
    }

    // Izinkan hanya format gambar tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Jika semua validasi terpenuhi, simpan file gambar
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["profile_image_path"]["tmp_name"], $target_file)) {
            // Simpan path gambar ke database
            $image_path = $target_file;
            $query = "UPDATE users SET profile_image_path=? WHERE id=?";
            $stmt = mysqli_prepare($koneksi, $query);
            mysqli_stmt_bind_param($stmt, "si", $image_path, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo "File " . basename($_FILES["profile_image_path"]["name"]) . " telah diunggah.";
        } else {
            echo "User ID tidak ditemukan.";
            echo "Maaf, terjadi kesalahan saat mengunggah file Anda.";
        }
    }
}

// Jika user_id tidak diatur
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .comment-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
            margin-bottom: 20px;
        }

        .comment-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment-content {
            border-radius: 10px;
            background-color: #f0f2f5;
            padding: 10px;
            margin-top: 5px;
        }

        .comment-actions {
            margin-top: 5px;
        }

        .comment-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Form untuk menambah komentar -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="comment" class="form-label">Tambah Komentar:</label>
                        <textarea class="form-control" id="comment" name="content" rows="3" required></textarea>
                    </div>
                    <div class="m-1">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
                        <a href="../index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </form>

                <div class="scroll-container">
                    <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <div class="card mb-3 comment-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                    <a href="../profile/profile_user.php">
                                        <img src="<?php echo $row['profile_image_path']; ?>" alt="Avatar" class="comment-avatar"></a>
                                        <div>
                                            <h6 class="card-title mb-0"><?php echo $row['author']; ?></h6>
                                            <p class="card-text mb-0"><?php echo $row['content']; ?></p>
                                            <p class="text-muted mb-0"><?php echo $row['created_at']; ?></p>
                                        </div>
                                        <div class="ms-auto comment-actions">
                                            <a href="hapuschat.php?hapus=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>Tidak ada komentar.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
