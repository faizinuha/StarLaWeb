<?php
// Misalkan kita sudah punya ID pengguna yang sedang login di $_SESSION['user_id']
$user_id = $_SESSION['user_id'];

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'blog');

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mendapatkan followers dari user yang sedang login
$sql = "SELECT u.id, u.name, u.username 
        FROM blog_followers f
        JOIN blog_users u ON f.follower_id = u.id
        WHERE f.followed_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$followers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $followers[] = $row;
    }
} else {
    echo "Belum ada followers.";
}

$stmt->close();
$conn->close();
?>
