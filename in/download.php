<?php
// Pastikan parameter gambar telah diterima
if (isset($_GET['gambar'])) {
    // Nama file gambar yang akan diunduh
    $nama_file = $_GET['gambar'];

    // Lokasi folder uploads
    $lokasi_folder = '../blogs/uploads/';

    // Tentukan path lengkap file gambar
    $path_gambar = $lokasi_folder . $nama_file;

    // Cek apakah file gambar ada
    if (file_exists($path_gambar)) {
        // Set header untuk memastikan browser mengenali file sebagai gambar
        header("Content-Type: image/jpeg");
        header("Content-Disposition: attachment; filename=" . $nama_file);

        // Baca dan kirimkan file gambar kepada pengguna
        readfile($path_gambar);
        exit; // Keluar dari skrip setelah mengirim file
    } else {
        // Jika file tidak ditemukan, tampilkan pesan error atau redirect ke halaman lain
        echo "Gambar tidak ditemukan";
    }
} else {
    // Jika parameter gambar tidak ada, tampilkan pesan error atau redirect ke halaman lain
    echo "Parameter gambar tidak valid";
}
?>
