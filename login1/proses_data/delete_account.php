<?php
session_start();
include_once "../../allkoneksi/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan user sudah login dan sesi user_id tersedia
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Lakukan query untuk menghapus akun
        $query = "DELETE FROM users WHERE id = $userId";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            // Jika penghapusan berhasil, kembalikan respons yang sesuai
            echo "Akun berhasil dihapus.";
        } else {
            // Jika terjadi kesalahan dalam penghapusan akun
            echo "Terjadi kesalahan saat menghapus akun. Silakan coba lagi.";
        }
    } else {
        // Jika user belum login atau sesi user_id tidak tersedia
        echo "Sesi tidak valid. Silakan login kembali.";
    }
} else {
    // Jika metode permintaan tidak valid
    echo "Metode permintaan tidak valid.";
}
?>
