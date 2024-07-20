<?php
// Konfigurasi koneksi ke database
include('../allkoneksi/koneksi.php');
// Memeriksa koneksi ke database
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Fungsi untuk mendapatkan total data dari tabel
function getTotalData($koneksi, $query) {
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0;
    }
}

$total_users = getTotalData($koneksi, "SELECT COUNT(*) as total FROM users");
$total_posts = getTotalData($koneksi, "SELECT COUNT(*) as total FROM posts");
$total_likes = getTotalData($koneksi, "SELECT COUNT(*) as total FROM likes");
$total_dislikes = getTotalData($koneksi, "SELECT COUNT(*) as total FROM dislikes");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>General Dashboard &mdash; Stisla</title>
    <?php
    include 'link.php';
    ?>
</head>

<body>
    <?php
    // Koneksi ke database
    include 'navbar.admin.php';
    // require_once __DIR__ . 'footer.php'
    ?>
    <!-- main content -->
    <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Count</h1>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Users</h4>
                                </div>
                                <div class="card-body">
                                    <?php echo $total_users; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="far fa-newspaper"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Posts</h4>
                                </div>
                                <div class="card-body">
                                    <?php echo $total_posts; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="far fa-thumbs-up"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Likes</h4>
                                </div>
                                <div class="card-body">
                                    <?php echo $total_likes; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="far fa-thumbs-down"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Dislikes</h4>
                                </div>
                                <div class="card-body">
                                    <?php echo $total_dislikes; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php
    // Koneksi ke database
    include 'footer.php';
    // require_once __DIR__ . 'footer.php'
    ?>
</body>

</html>
