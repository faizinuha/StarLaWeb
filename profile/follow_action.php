<?php
require_once __DIR__ . '/../allkoneksi/koneksi.php';

session_start();
$logged_in_user_id = $_SESSION['user_id']; // Logged-in user's ID

if (isset($_POST['user_id']) && isset($_POST['action'])) {
    $profile_user_id = $_POST['user_id'];
    $action = $_POST['action'];

    if ($action == 'follow') {
        // Add follow entry in the followers table
        $query = "INSERT INTO followers (follower_id, followed_id) VALUES (?, ?)";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ii", $logged_in_user_id, $profile_user_id);
        $stmt->execute();
    } elseif ($action == 'unfollow') {
        // Remove follow entry from the followers table
        $query = "DELETE FROM followers WHERE follower_id = ? AND followed_id = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ii", $logged_in_user_id, $profile_user_id);
        $stmt->execute();
    }

    echo 'success';
}
?>
