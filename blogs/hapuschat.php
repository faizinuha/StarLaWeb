<?php 
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once __DIR__ . '/../allkoneksi/koneksi.php';

// Pastikan hanya request method GET yang diizinkan
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['hapus'])) {
    // Ambil parameter hapus dari URL dan validasi
    $hapus_id = intval($_GET['hapus']);

    if ($hapus_id > 0) {
        // Ambil informasi pengguna yang sedang login
        $pengguna_login = $_SESSION['username'];

        // Ambil user_id dari sesi
        $query_user = $koneksi->prepare("SELECT id FROM users WHERE username = ?");
        $query_user->bind_param("s", $pengguna_login);
        $query_user->execute();
        $query_user->bind_result($user_id_login);
        $query_user->fetch();
        $query_user->close();

        // Ambil user_id yang menulis komentar yang akan dihapus
        $query = $koneksi->prepare("SELECT user_id FROM comments WHERE id = ?");
        $query->bind_param("i", $hapus_id);
        $query->execute();
        $query->bind_result($user_id_komentar);
        $query->fetch();
        $query->close();

        // Periksa apakah user_id yang sedang login adalah pemilik komentar
        if ($user_id_komentar === $user_id_login) {
            // Eksekusi query untuk menghapus komentar berdasarkan id
            $query_hapus = $koneksi->prepare("DELETE FROM comments WHERE id = ?");
            $query_hapus->bind_param("i", $hapus_id);
            $query_hapus->execute();

            // Periksa apakah query berhasil dijalankan
            if ($query_hapus->affected_rows > 0) {
                echo "<script>alert('Komentar berhasil dihapus.'); window.history.back();</script>";
            } else {
                echo "<script>alert('Gagal menghapus komentar.'); window.history.back();</script>";
            }

            $query_hapus->close();
        } else {
            echo "<script>alert('Anda tidak memiliki izin untuk menghapus komentar ini.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('ID komentar tidak valid.'); window.history.back();</script>";
    }

    $koneksi->close();
} else {
    // Jika request method bukan GET, atau parameter hapus tidak ada, tampilkan pesan kesalahan
    echo "<script>alert('Metode request tidak valid atau parameter hapus tidak ditemukan.'); window.history.back();</script>";
}
?>
