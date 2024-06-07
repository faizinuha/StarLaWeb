<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login1/login.php");
    exit();
}

// Pastikan hanya request method GET yang diizinkan
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['hapus'])) {
    // Definisikan informasi koneksi ke database
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "blog";

    // Buat koneksi
    $koneksi = new mysqli($host, $user, $password, $database);

    // Periksa koneksi
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Ambil parameter hapus dari URL dan validasi
    $hapus_id = intval($_GET['hapus']);

    if ($hapus_id > 0) {
        // Ambil informasi pengguna yang sedang login
        $pengguna_login = $_SESSION['username'];

        // Ambil nama pengguna yang menulis komentar yang akan dihapus
        $query = $koneksi->prepare("SELECT author FROM comments WHERE id = ?");
        $query->bind_param("i", $hapus_id);
        $query->execute();
        $query->bind_result($nama_pengguna_komentar);
        $query->fetch();
        $query->close();

        // Periksa apakah pengguna yang sedang login adalah pemilik komentar
        if ($nama_pengguna_komentar === $pengguna_login) {
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
        } else {
            echo "<script>alert('Anda tidak memiliki izin untuk menghapus komentar ini.'); window.history.back();</script>";
        }
    } 

} else {
    // Jika request method bukan GET, atau parameter hapus tidak ada, tampilkan pesan kesalahan
    echo "<script>alert('Metode request tidak valid atau parameter hapus tidak ditemukan.'); window.history.back();</script>";
}
$query_hapus->close();
$koneksi->close();
?>
