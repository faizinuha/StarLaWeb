<?php
session_start();
require_once __DIR__ . '/../../allkoneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    // Prepared statement untuk memilih user berdasarkan password
    $stmt = $koneksi->prepare("SELECT id, name, username, password, role FROM users WHERE password=?");
    $stmt->bind_param("s", $password);
    $stmt->execute();
    $stmt->bind_result($id, $name, $username, $hashed_password, $role);
    $stmt->fetch();
    $stmt->close();

    // Cek jika user ditemukan dan password cocok
    if ($id && password_verify($password, $hashed_password)) {
        // Set session
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['role'] = $role;

        // Redirect berdasarkan peran pengguna
        if ($role === 'admin') {
            header("Location: ../../admin/index.php");
        } else {
            header("Location: ../../index.php");
        }
        exit();
    } else {
        // Jika login gagal
        $_SESSION['login_error'] = "Invalid password.";
        header("Location: ../login.php?login_error=true");
        exit();
    }
}
$koneksi->close();
?>
