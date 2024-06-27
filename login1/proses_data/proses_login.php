<?php
session_start();

require_once __DIR__ . '/../../allkoneksi/koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOrUsername = $_POST['emailOrUsername'];
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT id, name, username, password FROM users WHERE email=? OR username=?");
    $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
    $stmt->execute();
    $stmt->bind_result($id, $name, $username, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    if ($id && password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        header("Location: /index.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid email/username or password.";
        header("Location: ../login.php?login_error=true");
        exit();
    }
}
$koneksi->close();
?>
