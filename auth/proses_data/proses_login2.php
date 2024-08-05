<?php
session_start();

require_once __DIR__ . '/../../allkoneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    // Cek apakah ID pengguna valid
    $stmt = $koneksi->prepare("SELECT id, name, username, password, role FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $username, $hashed_password, $role);
    $stmt->fetch();
    $stmt->close();

    if ($id && password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['role'] = $role; // Tambahkan role ke sesi
        
        if ($role === 'admin') {
            header("Location: ../../admin/index.php");
        } else {
            header("Location: ../../index.php");
        }
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid email/username or password.";
        header("Location: ../login.php?login_error=true&id=$user_id");
        exit();
    }
}

$koneksi->close();
?>
