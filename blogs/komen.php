<?php
session_start();
require_once __DIR__ . '/../allkoneksi/koneksi.php';

// Check if user is logged in
$is_logged_in = isset($_SESSION['username']);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

// Get the post_id from the URL
if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
    $post_id = intval($_GET['post_id']);
} else {
    die("Invalid post_id.");
}
// edit Pesan 
// Verify if the post_id exists in the database
$post_sql = "SELECT * FROM posts WHERE id = ?";
$post_stmt = $koneksi->prepare($post_sql);
$post_stmt->bind_param("i", $post_id);
$post_stmt->execute();
$post_result = $post_stmt->get_result();

if ($post_result->num_rows == 0) {
    die("Invalid post_id.");
}

$post = $post_result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && $is_logged_in) {
    // Validate and sanitize input
    $content = trim($_POST['content']);
    // edit pesan Users
    if (isset($_POST['comment_id'])) {
        $comment_id = intval($_POST['comment_id']);
    }

    // Check if it's a new comment or an edit
    if (isset($comment_id)) {
        // Edit the comment
        $edit_sql = "UPDATE comments SET content = ? WHERE id = ? AND author = ?";
        $stmt = $koneksi->prepare($edit_sql);
        $stmt->bind_param("sis", $content, $comment_id, $_SESSION['username']);

        if ($stmt->execute()) {
            // Redirect to prevent form resubmission
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // New comment logic
        $post_id = intval($_POST['post_id']); // Assuming post_id is passed as a hidden input
// mengcheck peesan post_id
        // Check if the post_id exists in the posts table
        $check_post_sql = "SELECT id FROM posts WHERE id = ?";
        $check_stmt = $koneksi->prepare($check_post_sql);
        $check_stmt->bind_param("i", $post_id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Prepare the SQL statement
            $sql = "INSERT INTO comments (post_id, author, content, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $koneksi->prepare($sql);
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
}

// Fetch comments from database
$sql = "SELECT c.*, u.profile_image_path FROM comments c LEFT JOIN users u ON c.author = u.username WHERE c.post_id = ? ORDER BY c.created_at DESC";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
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
            flex-grow: 1;
        }

        .comment-actions {
            margin-top: 5px;
        }

        .comment-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        .post-image {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .post-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .comment-row {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .comment-row img {
            margin-right: 10px;
        }

        .comment-content a {
            font-weight: bold;
            color: #000;
        }

        .comment-content p {
            margin-bottom: 0.25rem;
        }

        .comment-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .comment-actions .btn {
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <!-- Display the post image -->
                <?php if (!empty($post['image'])) : ?>
                    <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" class="post-image" alt="Post Image">
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <!-- Display the post details -->
                <div class="post-details">
                    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                    <p><strong>Tags:</strong> <?php echo htmlspecialchars($post['Tags']); ?></p>
                </div>

                <!-- Form untuk menambah komentar, hanya jika user login -->
                <?php if ($is_logged_in) : ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?post_id=' . htmlspecialchars($post_id); ?>" method="POST">
                        <div class="form-group">
                            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
                            <label for="comment" class="form-label">Tambah Komentar:</label>
                            <textarea class="form-control" id="comment" name="content" rows="3" required></textarea>
                        </div>
                        <div class="m-1">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                            <a href="../index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
                        </div>
                    </form>
                <?php else : ?>
                    <p>Silakan <a href="../login1/login.php">login</a> untuk menambahkan komentar.</p>
                <?php endif; ?>

                <div class="scroll-container">
                    <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <div class="comment-row">
                                <div class="comment-content">
                                    <img src="../profile/<?php echo htmlspecialchars($row['profile_image_path']); ?>" class="comment-avatar" alt="Avatar">
                                    <a href="../profile/profile-pengguna.php?username=<?php echo htmlspecialchars($row['author']); ?>">
                                        <?php echo htmlspecialchars($row['author']); ?>
                                    </a>
                                    <p>Pesan: <?php echo htmlspecialchars($row['content']); ?></p>
                                    <p class="text-muted"><?php echo isset($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A'; ?></p>
                                </div>
                                <?php if ($is_logged_in && $_SESSION['username'] == $row['author']) : ?>
                                    <div class="comment-actions">
                                        <!-- Edit button triggers the modal -->
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCommentModal" data-comment-id="<?php echo htmlspecialchars($row['id']); ?>" data-comment-content="<?php echo htmlspecialchars($row['content']); ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="hapuschat.php?hapus=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>Tidak ada komentar.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>
    <!-- Edit Comment Modal -->
    <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editCommentForm" action="#" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCommentModalLabel">Edit Comment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="comment_id" id="edit-comment-id">
                        <div class="mb-3">
                            <label for="edit-comment-content" class="form-label">Comment</label>
                            <textarea class="form-control" id="edit-comment-content" name="content" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editCommentModal = document.getElementById('editCommentModal');
            editCommentModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var commentId = button.getAttribute('data-comment-id');
                var commentContent = button.getAttribute('data-comment-content');

                var modalCommentIdInput = editCommentModal.querySelector('#edit-comment-id');
                var modalCommentContentTextarea = editCommentModal.querySelector('#edit-comment-content');

                modalCommentIdInput.value = commentId;
                modalCommentContentTextarea.value = commentContent;
            });
        });
    </script>

</body>

</html>
