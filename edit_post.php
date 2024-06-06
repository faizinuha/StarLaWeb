<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "blog");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah ada pengguna yang login
session_start();
$current_user = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $Tags = $_POST['Tags'];
    $uploaded_by = $current_user;

    // Memeriksa apakah ada file gambar yang diupload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "blogs/uploads/" . basename($image);

        // Memindahkan file yang diupload ke folder tujuan
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Menghapus gambar lama
            $sql = "SELECT image FROM posts WHERE id='$id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $old_image = $row['image'];
                if (file_exists("blogs/uploads/" . $old_image)) {
                    unlink("blogs/uploads/" . $old_image);
                }
            }

            // Update postingan dengan gambar baru
            $sql = "UPDATE posts SET title='$title', content='$content', Tags='$Tags', image='$image' WHERE id='$id'";
        }
    } else {
        // Update postingan tanpa mengubah gambar
        $sql = "UPDATE posts SET title='$title', content='$content', Tags='$Tags' WHERE id='$id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Post berhasil diperbarui!');</script>";
        echo "<script>location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Mengambil data postingan untuk di-edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id='$id' AND uploaded_by='$current_user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post tidak ditemukan atau Anda tidak memiliki izin untuk mengedit post ini.";
        exit;
    }
} else {
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Edit Post</h1>
        <form action="edit_post.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="content" name="content" rows="4" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="Tags" class="form-label">Tags</label>
                <input type="text" class="form-control" id="Tags" name="Tags" value="<?php echo htmlspecialchars($post['Tags']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="image" name="image">
                <img src="blogs/uploads/<?php echo htmlspecialchars($post['image']); ?>" class="img-fluid mt-2" alt="Current Image">
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
