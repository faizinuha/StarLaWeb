<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Include database connection file
require_once "koneksi.php";

// Check if comment data has been submitted from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture comment data from the form
    $comment = $_POST['comment'];
    // Capture user ID and username from session
    $userId  = $_SESSION['user_id'];
    $author  = $_SESSION['username'];


    // Validate input
    if (empty($comment)) {
        // If comment is empty, redirect back to the previous page with an error message
        header("Location: index.php?error=emptycomment");
        exit();
    }

    // Prepare SQL statement to insert comment into the database
    $sql = "INSERT INTO comments (user_id, author, comment, created_at) VALUES (?, ?, ?, NOW())";

    // Prepare the prepared statement
    $stmt = $conn->prepare($sql);

    // Check if the statement is prepared successfully
    if ($stmt) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("iss", $userId, $author, $comment);

        // Execute the SQL statement
        $stmt->execute();

        // Redirect to index.php with success message
        header("Location: komen.php?comment=success");
        exit();
    } else {
        // Redirect back to index.php with error message
        header("Location: komen.php?error=sqlerror");
        exit();
    }
} else {
    // If no comment data is submitted, redirect back to the previous page without taking any action
    header("Location: komen.php");
    exit();
}

// Close database connection
$stmt->close();
$conn->close();
