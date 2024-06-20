<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "blog");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$action = isset($_GET['action']) ? $_GET['action'] : null;
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;

$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$current_user_id) {
    // die("Anda harus login untuk melakukan like/dislike.");
    echo "<script>window.location.href='../login1/login.php';</script>";
}

if ($action == 'like' || $action == 'dislike') {
    // Lanjutkan dengan operasi like/dislike
    $check_user_query = "SELECT * FROM users WHERE id = $current_user_id";
    $result_check_user = $conn->query($check_user_query);

    if ($result_check_user->num_rows > 0) {
        // User valid, lanjutkan dengan operasi like/dislike
        $check_action_query = "SELECT * FROM " . ($action == 'like' ? 'likes' : 'dislikes') . " WHERE post_id = $post_id AND user_id = $current_user_id";
        $result_check_action = $conn->query($check_action_query);

        if ($result_check_action->num_rows > 0) {
            // echo "Anda sudah memberikan " . ($action == 'like' ? 'like' : 'dislike') . " pada posting ini.";
            echo "<script>window.location.href='../index.php';</script>";
        } else {
            // Update tabel posts
            $update_posts_query = "UPDATE posts SET " . ($action == 'like' ? 'likes = likes + 1' : 'dislikes = dislikes + 1') . " WHERE id = $post_id";
            $conn->query($update_posts_query);

            // Simpan like/dislike ke dalam tabel likes atau dislikes
            $insert_action_query = "INSERT INTO " . ($action == 'like' ? 'likes' : 'dislikes') . " (post_id, user_id) VALUES ($post_id, $current_user_id)";
            if ($conn->query($insert_action_query) === TRUE) {
                echo ucfirst($action) . " berhasil ditambahkan.";
            } else {
                echo "Error saat menyimpan " . $action . ": " . $conn->error;
            }

            header("Location: $_SERVER[HTTP_REFERER]");
        }
    } else {
        echo "User tidak valid.";
    }
} else {
    echo "Parameter 'action' (like atau dislike) tidak diberikan.";
}

$conn->close();
?>
