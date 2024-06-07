<?php
session_start();

// Koneksi database
$host = "localhost";
$user = "root";
$password = "";
$database = "users";
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengambil data dari form login
$emailOrUsername = $_POST['emailOrUsername'];
$password = $_POST['password'];

// Persiapan dan eksekusi statement untuk mengambil data pengguna berdasarkan email atau username
$stmt = $conn->prepare("SELECT id, name, username, password FROM users WHERE email=? OR username=?");
$stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['login_success'] = "Berhasil login";
        // Redirect ke halaman dashboard atau home
        header("Location: ../index.php?login_success=true");
        exit();
    } else {
        $_SESSION['login_error'] = "Username atau password salah";
        // Redirect ke halaman login dengan pesan error
        header("Location: login.php?login_error=true");
        exit();
    }
} else {
    // Pengguna tidak ditemukan
    $_SESSION['login_error'] = "Pengguna tidak ditemukan";
    // Redirect ke halaman register
    header("Location: register.php?login_error=true");
    exit();
}

$stmt->close();
mysqli_close($conn);
?>
