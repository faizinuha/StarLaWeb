<?php
include('layouts/navbar-templet.php')
?>
<!-- Alert -->
<div id="alert" onclick="valida()"></div>
<div class="container">
    <h1 class="text-center">Selamat Datang di Blog Kami</h1>
    <hr>
    <div class="row">
        <?php
        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "blog");

        // Periksa koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk mengambil data posting
        $sql = "SELECT * FROM posts ORDER BY upload_date DESC LIMIT 9999";
        $result = $conn->query($sql);

        // Cek apakah ada postingan
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

        ?>
                <!-- image -->
                <div class="card mb-5  ">
                    <div class="position-relative">
                        <!-- class imga -->
                        <img src="blogs/uploads/<?php echo $row['image']; ?>" class=" card-img-top mt-4 post-image m-6 img-fluid" style="border-radius: 15px;" alt="<?php echo $row['title']; ?>">
                        <div class="overlay"></div> <!-- overlay untuk efek bayangan -->
                    </div>
                    <div class="card-body mb-4">
                        <h2 class="card-title"><?php echo $row['title']; ?></h2>
                        <p class="card-text post-content"><?php echo $row['content']; ?></p>
                    </div>

                    <div class="card-footer text-muted d-flex justify-content-between align-items-center">
                        <div>
                            Diposting oleh: <?php echo $row['uploaded_by']; ?>
                             Tanggal:<?php echo $row['upload_date']; ?>
                        </div>

                        <div>
                           
                            <a href="blogs/komen.php?post_id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="bi bi-chat-left"></i></a>
                            <a href="download.php?gambar=<?php echo $row['image']; ?>" class="btn btn-primary"><i class="bi bi-download"></i></a>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <p class="alert alert-dark mr-3">Noter Image</p>
            <a href="blogs/upload.php" class="alert alert-dark me-1">Klik di sini Untuk Post</a>
        <?php
        }

        // Tutup koneksi
        $conn->close();

        include('footer/footer.php');
        ?>
    </div>


</div>