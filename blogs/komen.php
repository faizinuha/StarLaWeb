<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login1/login.php");
    exit();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Connect to database
    $conn = new mysqli("localhost", "root", "", "blog");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the post_id from the URL
    if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
        $post_id = intval($_GET['post_id']);
    } else {
        die("Invalid post_id.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input
        $content = trim($_POST['content']);
        $post_id = intval($_POST['post_id']); // Assuming post_id is passed as a hidden input

        // Debug output
        echo "post_id: " . htmlspecialchars($post_id) . "<br>";

        // Check if the post_id exists in the posts table
        $check_post_sql = "SELECT id FROM posts WHERE id = ?";
        $check_stmt = $conn->prepare($check_post_sql);
        $check_stmt->bind_param("i", $post_id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Prepare the SQL statement
            $sql = "INSERT INTO comments (post_id, author, content, created_at) VALUES (?, ?, ?, NOW())";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $post_id, $_SESSION['username'], $content);

            if ($stmt->execute()) {
                // Redirect to prevent form resubmission
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Invalid post_id.";
        }

        $check_stmt->close();
    }

    // Fetch comments from database
    $sql = "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .comment-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
            margin-bottom: 20px;
        }

        .comment-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment-content {
            border-radius: 10px;
            background-color: #f0f2f5;
            padding: 10px;
            margin-top: 5px;
        }

        .comment-actions {
            margin-top: 5px;
        }

        .comment-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Form untuk menambah komentar -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?post_id=' . htmlspecialchars($post_id); ?>" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
                        <label for="comment" class="form-label">Tambah Komentar:</label>
                        <textarea class="form-control" id="comment" name="content" rows="3" required></textarea>
                    </div>
                    <div class="m-1">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
                        <a href="../index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </form>

                <div class="scroll-container">
                    <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <div class="card mb-3 comment-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <a href="../profile/profile-pengguna.php?username=<?php echo htmlspecialchars($row['author']); ?>">
                                                <h6 class="card-title mb-0 btn btn-outline-primary"><?php echo htmlspecialchars($row['author']); ?></h6>
                                            </a>
                                            <p class="card-text mb-0">Chat:<?php echo htmlspecialchars($row['content']); ?></p>
                                            <p class="text-muted mb-0">Date:<?php echo htmlspecialchars($row['created_at']); ?></p>
                                        </div>
                                        <div class="ms-auto comment-actions">
                                            <a href="hapuschat.php?hapus=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>Tidak ada komentar.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
        <?php 
          include('../footer/footer.php');
        ?>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>