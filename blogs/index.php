<?php
// Mulai sesi

session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "blog_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil posting terbaru dari database
$sql = "SELECT * FROM posts ORDER BY upload_date DESC LIMIT 5"; // Mengambil 5 posting terbaru
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .post-content {
            overflow-wrap: break-word;
        }

        .post-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-4 mb-4">Selamat Datang di Blog Kami</h1>
        <a href="blogs/upload.php" class="btn btn-primary mb-4">Unggah Posting Baru</a>
        <hr>

        <?php
        // Tampilkan posting terbaru
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class='card mb-4'>
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $row['title']; ?></h2>
                        <p class="card-text post-content"><?php echo $row['content']; ?></p>
                    </div>
                    <img src='uploads/<?php echo $row['image']; ?>' class='card-img-bottom post-image' alt=''>
                    <div class="card-footer text-muted">
                        Diposting oleh: <?php echo $row['uploaded_by']; ?> pada <?php echo $row['upload_date']; ?>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <p>Belum ada posting.</p>
        <?php
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Tutup koneksi
$conn->close();
?>
