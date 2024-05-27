<?php 
session_start();

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "users";
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve data from login form
$emailOrUsername = $_POST['emailOrUsername'];
$password = $_POST['password'];

// Fetch user data from the database based on the provided email or username
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
        // Redirect to dashboard or home page
        header("Location: ../index.php");
        exit(); 
    } else {
        $_SESSION['login_error'] = "Invalid username or password";
        // Redirect to login page with error message
        header("Location: login.php?login_error=true");
        exit(); 
    }
} else {
    // User not found
    $_SESSION['login_error'] = "User not found";
    // Redirect to register page
    header("Location: register.php?login_error=true");
    exit(); // Exit to prevent further execution
} 

$stmt->close();
mysqli_close($conn);
?>
