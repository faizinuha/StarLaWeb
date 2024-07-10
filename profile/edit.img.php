<?php
require_once __DIR__ . '/allkoneksi/koneksi.php';
// Koneksi ke database

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
            $result = $koneksi->query($sql);
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
    }

    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Post berhasil diperbarui!');</script>";
        echo "<script>location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

// Mengambil data postingan untuk di-edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id='$id' AND uploaded_by='$current_user'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post tidak ditemukan atau Anda tidak memiliki izin untuk mengedit post ini.";
        exit;
    }
} else {
    exit;
}

$koneksi->close();
?>
