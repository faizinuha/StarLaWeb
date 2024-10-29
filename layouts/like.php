<?php
session_start();

// Koneksi ke database
require_once __DIR__ . '/../allkoneksi/koneksi.php';
$action = isset($_GET['action']) ? $_GET['action'] : null;
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;

$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$current_user_id) {
    echo "<script>window.location.href='../auth/login.php';</script>";
    exit();
}

if ($action == 'like' || $action == 'dislike') {
    $check_user_query = "SELECT * FROM users WHERE id = $current_user_id";
    $result_check_user = $koneksi->query($check_user_query);

    if ($result_check_user->num_rows > 0) {
        $check_like_query = "SELECT * FROM likes WHERE post_id = $post_id AND user_id = $current_user_id";
        $result_check_like = $koneksi->query($check_like_query);

        $check_dislike_query = "SELECT * FROM dislikes WHERE post_id = $post_id AND user_id = $current_user_id";
        $result_check_dislike = $koneksi->query($check_dislike_query);

        // Mendapatkan ID pemilik post
        $post_owner_query = "SELECT user_id FROM posts WHERE id = $post_id";
        $result_post_owner = $koneksi->query($post_owner_query);
        $post_owner = $result_post_owner->fetch_assoc();
        $post_owner_id = $post_owner['user_id'];

        if ($result_check_like->num_rows > 0) {
            if ($action == 'like') {
                // Hapus like
                $koneksi->query("DELETE FROM likes WHERE post_id = $post_id AND user_id = $current_user_id");
                $koneksi->query("UPDATE posts SET likes = likes - 1 WHERE id = $post_id");
            } else {
                // Hapus like sebelumnya, tambahkan dislike
                $koneksi->query("DELETE FROM likes WHERE post_id = $post_id AND user_id = $current_user_id");
                $koneksi->query("UPDATE posts SET likes = likes - 1 WHERE id = $post_id");

                $update_posts_query = "UPDATE posts SET dislikes = dislikes + 1 WHERE id = $post_id";
                $koneksi->query($update_posts_query);

                $insert_action_query = "INSERT INTO dislikes (post_id, user_id) VALUES ($post_id, $current_user_id)";
                $koneksi->query($insert_action_query);
            }
        } elseif ($result_check_dislike->num_rows > 0) {
            if ($action == 'dislike') {
                // Hapus dislike
                $koneksi->query("DELETE FROM dislikes WHERE post_id = $post_id AND user_id = $current_user_id");
                $koneksi->query("UPDATE posts SET dislikes = dislikes - 1 WHERE id = $post_id");
            } else {
                // Hapus dislike sebelumnya, tambahkan like
                $koneksi->query("DELETE FROM dislikes WHERE post_id = $post_id AND user_id = $current_user_id");
                $koneksi->query("UPDATE posts SET dislikes = dislikes - 1 WHERE id = $post_id");

                $update_posts_query = "UPDATE posts SET likes = likes + 1 WHERE id = $post_id";
                $koneksi->query($update_posts_query);

                $insert_action_query = "INSERT INTO likes (post_id, user_id) VALUES ($post_id, $current_user_id)";
                $koneksi->query($insert_action_query);
            }
        } else {
            // Tambahkan like atau dislike baru
            $update_posts_query = "UPDATE posts SET " . ($action == 'like' ? 'likes = likes + 1' : 'dislikes = dislikes + 1') . " WHERE id = $post_id";
            $koneksi->query($update_posts_query);

            $insert_action_query = "INSERT INTO " . ($action == 'like' ? 'likes' : 'dislikes') . " (post_id, user_id) VALUES ($post_id, $current_user_id)";
            $koneksi->query($insert_action_query);
        }

        // Tambahkan notifikasi hanya jika aksi adalah 'like' dan pemilik post bukan pengguna saat ini
        if ($action == 'like' && $post_owner_id != $current_user_id) {
            $message = "Seseorang  $current_user_id menyukai postingan  Anda.";
            $notification_query = "INSERT INTO notifications (user_id, sender_id, post_id, type, message) VALUES ($post_owner_id, $current_user_id, $post_id, 'like', '$message')";
            $koneksi->query($notification_query);
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "User tidak valid.";
    }
} else {
    echo "Parameter 'action' (like atau dislike) tidak diberikan.";
}

$koneksi->close();
?>
