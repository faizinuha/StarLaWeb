<?php
session_start();
// Default name if not logged in
$name = "Not Loggin";

require_once __DIR__ . '/../allkoneksi/koneksi.php';
// Fetch user's name if logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT name FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
    }
}

// Close database connection
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="navigation">
    <ul>
      <li class="list">
        <span class="icon" ></span>
        <span class="text">Home</span>
      </li>
      <li class="list">
        <span class="icon" ></span>
        <span class="text">Name</span>
      </li>
      <li class="list">
        <span class="icon" ></span>
        <span class="text">Setting</span>
      </li>
      <li class="list">
        <span clas="icon"></span>
        <span class="text">Uplods</span>
      </li>
    </ul>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>