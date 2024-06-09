<?php
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
    $message = trim($_POST['message']);
    $user_id = intval($_POST['user_id']); // Pastikan ini adalah ID pengguna yang valid

    if (!empty($message) && $user_id > 0) {
        $message = htmlspecialchars($message);

        // Verifikasi apakah ID pengguna ada di tabel users
        $user_check_query = $koneksi->prepare("SELECT id FROM users WHERE id = ?");
        $user_check_query->bind_param("i", $user_id);
        $user_check_query->execute();
        $result = $user_check_query->get_result();

        if ($result->num_rows > 0) {
            // ID pengguna valid
            $stmt = $koneksi->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $message);
            if ($stmt->execute()) {
                // Pesan berhasil disimpan
                header('Location: index.php');
                exit();
            } else {
                // Kesalahan saat menyimpan pesan
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // Debugging output
            echo "Invalid user ID: " . $user_id;
        }

        $user_check_query->close();
    } else {
        // Debugging output
        echo "Message or user ID is invalid.";
    }
}

$koneksi->close();
