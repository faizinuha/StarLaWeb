<?php
// Termasuk file koneksi
include_once "koneksi.php";

// Memulai sesi
session_start();

// Memeriksa apakah user_id telah diatur
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Memeriksa apakah data formulir telah dikirimkan
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mengambil data yang dikirimkan dari formulir
        $name = $_POST['name'];
        $email = $_POST['email'];
        $TikTok = $_POST['TikTok']; // Tambahkan ini untuk mengambil data media sosial
        $instagram = $_POST['instagram'];
        $Twitter = $_POST['Twitter'];

        // Menghindari SQL Injection dengan menggunakan parameterized query
        $query = "UPDATE users SET name=?, email=?, TikTok=?, instagram=?, Twitter=? WHERE id=?";
        $stmt = mysqli_prepare($koneksi, $query);
        
        // Binding parameters
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $TikTok, $instagram, $Twitter, $user_id);
        
        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect ke halaman profil dengan pesan sukses
            header("Location: profile_user.php?edit_success=true");
            exit(); 
        } else {
            // Jika terjadi kesalahan saat pengeditan, tangani sesuai kebutuhan aplikasi Anda
            echo "Gagal mengupdate profil.";
        }
        
        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        // Jika data formulir tidak dikirimkan, tampilkan pesan yang sesuai
        echo "Data formulir tidak ditemukan.";
    }
} else {
    // Jika user_id tidak diatur
    echo "User ID tidak ditemukan.";
}

// Tutup koneksi ke database (jika tidak menggunakan koneksi persistent)
mysqli_close($koneksi);
?>
