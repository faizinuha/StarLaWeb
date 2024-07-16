<?php
session_start();

// Periksa apakah pengguna sudah masuk
if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login terlebih dahulu.";
    exit();
}

// Sambungkan ke database
require_once __DIR__ . '/../allkoneksi/koneksi.php';

// Ambil data dari permintaan POST
$photo_id = isset($_POST['photo_id']) ? intval($_POST['photo_id']) : 0;
$image_name = isset($_POST['image_name']) ? $_POST['image_name'] : '';

// Validasi ID dan nama gambar
if ($photo_id <= 0 || empty($image_name)) {
    echo "Data tidak valid.";
    exit();
}

// Periksa apakah pengguna yang login adalah pemilik foto
$stmt = $koneksi->prepare("SELECT * FROM posts WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $photo_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Hapus foto dari database
    $stmt = $koneksi->prepare("DELETE FROM posts WHERE id=?");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Hapus file gambar dari direktori
        $image_path = __DIR__ . '/../blogs/uploads/' . $image_name;
        if (file_exists($image_path) && unlink($image_path)) {
            echo "success";
        } else {
            echo "Gagal menghapus gambar.";
        }
    } else {
        echo "Gagal menghapus foto.";
    }
} else {
    echo "Anda tidak memiliki izin untuk menghapus foto ini.";
}

// Tutup statement dan koneksi
$stmt->close();
$koneksi->close();
?>
