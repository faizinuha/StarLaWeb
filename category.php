<?php
// Start session

// Establish database connection
require_once __DIR__ . '/allkoneksi/koneksi.php';

// Fetch tag from query string
if (isset($_GET['Tags'])) {
    $Tags = $_GET['Tags'];

    // Sanitize the tag
    $Tags = htmlspecialchars($Tags, ENT_QUOTES, 'UTF-8');

    // Query to get posts based on tag
    $sql_images = "SELECT * FROM posts WHERE posts.Tags = ?";
    $stmt = $koneksi->prepare($sql_images);
    $stmt->bind_param("s", $Tags); 
    $stmt->execute();
    $result_images = $stmt->get_result();
} else {
    // Handle case where tag parameter is not provided
    header("Location: index.php"); // Redirect to home page or other default page
    exit;
}
include ('layouts/navbar-templet.php');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Detail - <?php echo htmlspecialchars($Tags); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .card-img-top {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-4">Category: <?php echo htmlspecialchars($Tags); ?></h2>
        <div class="row">
            <?php
            // Display images based on the query result
            if ($result_images->num_rows > 0) {
                while ($row = $result_images->fetch_assoc()) {
                    echo '<div class="col-md-6 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="blogs/uploads/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="Image">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">Judul:' . htmlspecialchars($row['title']) . '</h5>';
                    echo '<p class="card-text">Deskripsi:' . htmlspecialchars($row['content']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="alert alert-dark text-center">No posts found in this category</p>';
            }
            
            echo '<div class="text-center"><a href="index.php" class="btn btn-primary">Kembali</a></div>';
            
            // Close statement and connection
            $stmt->close();
           
            ?>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
