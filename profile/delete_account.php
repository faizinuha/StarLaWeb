<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$database = "users";


// Membuat koneksi ke database
$koneksi = mysqli_connect($server, $username, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan ID pengguna dari sesi
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];

        // Debug: menampilkan ID pengguna
        error_log("User ID: " . $userId);

        // Menyiapkan pernyataan SQL untuk menghapus pengguna berdasarkan ID
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Jika akun berhasil dihapus, hancurkan sesi
            session_destroy();
            unset($_SESSION['id']); // Hapus variabel sesi spesifik jika diperlukan
            echo "Akun berhasil dihapus.";
        } else {
            echo "Terjadi kesalahan saat menghapus akun. Silakan coba lagi.";
        }
    } else {
        echo "ID pengguna tidak ditemukan.";
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>
