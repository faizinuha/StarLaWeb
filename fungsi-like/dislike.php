<?php
$conn = new mysqli("localhost", "root", "", "blog");

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
$post_id = $_GET['$post_id'];
$sql = "UPDATE posts SET dislikes = dislikes + 1 WHERE id = $post_id";
$conn->query($sql);

$conn->close();

header("Location: ../index.php");
