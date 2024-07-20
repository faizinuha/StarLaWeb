<?php
require_once __DIR__ . '/../allkoneksi/koneksi.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql = "SELECT * FROM posts WHERE posts.Tags LIKE '%$query%'";
    $result = mysqli_query($koneksi, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Display the search results
            echo "<p>" . $row['posts.Tags'] . "</p>";
        }
    } else {
        echo "No results found.";
    }
}

mysqli_close($koneksi);
?>
