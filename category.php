<?php
// Start session
session_start();

// Establish database connection
require_once __DIR__ . '/allkoneksi/koneksi.php';
// require_once __DIR__ . '/Admin/componen.php';

// Fetch tag from query string
if (isset($_GET['Tags'])) {
    $Tags = $_GET['Tags'];

    // Sanitize the tag
    $Tags = htmlspecialchars($Tags, ENT_QUOTES, 'UTF-8');

    // Query to get posts based on tag and status 'uploads'
    $sql_images = "SELECT * FROM posts WHERE posts.Tags = ? AND posts.status = 'uploads'";
    $stmt = $koneksi->prepare($sql_images);
    $stmt->bind_param("s", $Tags); 
    $stmt->execute();
    $result_images = $stmt->get_result();
} else {
    // Handle case where tag parameter is not provided
    header("Location: index.php"); // Redirect to home page or other default page
    exit;
}
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
            height: 200px;
            object-fit: cover;
        }

        .gallery {
            display: flex;
            margin: 0.1em;
            flex-wrap: wrap;
            gap: 15px;
        }

        .gallery-item {
            width: calc(33.333% - 15px);
            margin-bottom: 20px;
        }

        .gallery-item img {
            width: 100%;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .gallery-item {
                width: calc(50% - 15px);
            }
        }

        @media (max-width: 576px) {
            .gallery-item {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-4">Category: <?php echo htmlspecialchars($Tags); ?></h2>
        <div class="gallery">
            <?php
            // Display images based on the query result
            if ($result_images->num_rows > 0) {
                while ($row = $result_images->fetch_assoc()) {
                    echo '<div class="gallery-item">';
                    echo '<div class="card">';
                    echo '<img src="blogs/uploads/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="Image">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">Judul: ' . htmlspecialchars($row['title']) . '</h5>';
                    echo '<p class="card-text">Deskripsi: ' . htmlspecialchars($row['content']) . '</p>';
                    echo '<p class="card-text">Uploads: ' . htmlspecialchars($row['upload_date']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="alert alert-dark text-center">No posts found in this category</p>';
            }
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
