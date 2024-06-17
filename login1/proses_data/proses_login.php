<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$database = "users";
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOrUsername = $_POST['emailOrUsername'];
    $password = $_POST['password'];
    $verification_code = $_POST['verification_code'];

    $stmt = $conn->prepare("SELECT id, name, username, password, verification_code FROM users WHERE email=? OR username=?");
    $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
    $stmt->execute();
    $stmt->bind_result($id, $name, $username, $hashed_password, $stored_code);
    $stmt->fetch();
    $stmt->close();

    if ($id && password_verify($password, $hashed_password)) {
        if ($verification_code == $stored_code) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            header("Location: /index.php?login_success=true");
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid verification code.";
            header("Location: ../login.php?login_error=true");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Invalid email/username or password.";
        header("Location: ../login.php?login_error=true");
        exit();
    }
}
$conn->close();
?>
