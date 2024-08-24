<?php
session_start();
require_once __DIR__ . '/../allkoneksi/koneksi.php';

// Cek apakah user sudah login
$is_logged_in = isset($_SESSION['username']);

if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
}

// Mendapatkan post_id dari URL
if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
    $post_id = intval($_GET['post_id']);
} else {
    die("post_id tidak valid.");
}

// Verifikasi apakah post_id ada di database
$post_sql = "SELECT * FROM posts WHERE id = ?";
$post_stmt = $koneksi->prepare($post_sql);
$post_stmt->bind_param("i", $post_id);
$post_stmt->execute();
$post_result = $post_stmt->get_result();

if ($post_result->num_rows == 0) {
    die("post_id tidak valid.");
}

$post = $post_result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && $is_logged_in) {
    // Validasi dan sanitasi input
    $content = trim($_POST['content']);

    if (!empty($content)) {
        // Periksa apakah ini komentar baru atau edit
        if (isset($_POST['comment_id']) && is_numeric($_POST['comment_id'])) {
            // Edit komentar
            $comment_id = intval($_POST['comment_id']);
            $edit_sql = "UPDATE comments SET content = ? WHERE id = ? AND user_id = ?";
            $stmt = $koneksi->prepare($edit_sql);
            $stmt->bind_param("sis", $content, $comment_id, $_SESSION['user_id']);

            if ($stmt->execute()) {
                // Redirect untuk mencegah resubmission form
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            // Logika komentar baru
            $post_id = intval($_POST['post_id']); // Asumsi post_id dikirimkan sebagai input tersembunyi

            // Periksa apakah post_id ada di tabel posts
            $check_post_sql = "SELECT id FROM posts WHERE id = ?";
            $check_stmt = $koneksi->prepare($check_post_sql);
            $check_stmt->bind_param("i", $post_id);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                // Siapkan pernyataan SQL
                $sql = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
                $stmt = $koneksi->prepare($sql);
                $stmt->bind_param("iss", $post_id, $_SESSION['user_id'], $content);

                if ($stmt->execute()) {
                    // Redirect untuk mencegah resubmission form
                    header("Location: " . $_SERVER['REQUEST_URI']);
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "post_id tidak valid.";
            }

            $check_stmt->close();
        }
    } else {
        echo "Isi komentar tidak boleh kosong.";
    }
}

// Mengambil komentar dari database
$sql = "SELECT c.*, u.profile_image_path, u.username FROM comments c LEFT JOIN users u ON c.user_id = u.id WHERE c.post_id = ? ORDER BY c.created_at DESC";
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
    <!-- General CSS Files -->
    <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../assets/modules/bootstrap-social/bootstrap-social.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/components.css">
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
                <!-- Menampilkan gambar post -->
                <?php if (!empty($post['image'])) : ?>
                    <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" class="post-image" alt="Post Image">
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <!-- Menampilkan detail post -->
                <div class="post-details">
                    <h2>Name:<?php echo htmlspecialchars($post['title']); ?></h2>
                    <p>Deskripsi:<?php echo htmlspecialchars($post['content']); ?></p>
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
                    <p>Silakan <a href="../auth/login.php">login</a> untuk menambahkan komentar.</p>
                <?php endif; ?>

                <div class="scroll-container">
                    <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <div class="comment-row">
                                <div class="comment-content">
                                    <img src="../profile/<?php echo htmlspecialchars($row['profile_image_path']); ?>" class="comment-avatar" alt="Avatar">
                                    <a href="../profile/profile-pengguna.php?id=<?php echo htmlspecialchars($row['user_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                    <p>Pesan: <?php echo htmlspecialchars($row['content']); ?></p>
                                    <p class="text-muted"><?php echo isset($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A'; ?></p>
                                </div>
                                <?php if ($is_logged_in && $row['user_id'] == $user_id) : ?>
                                    <div class="comment-actions">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCommentModal" data-comment-id="<?php echo htmlspecialchars($row['id']); ?>" data-comment-content="<?php echo htmlspecialchars($row['content']); ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="hapuschat.php" method="get" style="display:inline;">
                                            <input type="hidden" name="hapus" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>Belum ada komentar.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit komentar -->
    <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCommentModalLabel">Edit Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?post_id=' . htmlspecialchars($post_id); ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="comment_id" id="editCommentId">
                        <div class="form-group">
                            <label for="editCommentContent">Edit Komentar:</label>
                            <textarea class="form-control" id="editCommentContent" name="content" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Pass data ke modal edit komentar
        var editCommentModal = document.getElementById('editCommentModal');
        editCommentModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var commentId = button.getAttribute('data-comment-id');
            var commentContent = button.getAttribute('data-comment-content');

            var modalCommentId = editCommentModal.querySelector('#editCommentId');
            var modalCommentContent = editCommentModal.querySelector('#editCommentContent');

            modalCommentId.value = commentId;
            modalCommentContent.value = commentContent;
        });
    </script>
    <!-- Penjelasan Perubahan:
Perubahan Query SQL: Query SQL diubah untuk menggabungkan tabel comments dan users sehingga dapat mengambil username dari tabel users.
Perubahan di Looping Komentar: Dalam while loop untuk menampilkan komentar, kita sekarang menggunakan username dari tabel users sebagai pengganti user_id.
Edit dan Hapus Komentar: Aksi edit dan hapus masih tersedia, dan ditampilkan hanya jika pengguna yang login adalah pemilik komentar.
Sekarang, komentar akan menampilkan username dari pengguna yang memberikan komentar, bukan user_id. Jika ada hal lain yang perlu diperbaiki atau ditambahkan, beri tahu saya! -->
</body>

</html>