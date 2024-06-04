<?php include('layouts/navbar-templet.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" href="https://t4.ftcdn.net/jpg/04/92/55/37/360_F_492553733_M1ewmNvrx917YggK3b6IQjiqKzbCpufW.jpg">
     <title>Document</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
     <link href="styles.css" rel="stylesheet">
     <style>
     .card-img-top {
          height: auto;
          width: 100%;
          max-height: 300px;
          object-fit: cover;
     }

     .post-content {
          display: -webkit-box;
      
          -webkit-box-orient: vertical;
          overflow: hidden;
     }
     </style>
</head>

<body>
     <div class="container mt-5">
     <h1 class="text-center d-block">Lah.com</h1><hr>
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
               <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                      
                         <div class="position-relative">
                              <img src="blogs/uploads/<?php echo $row['image']; ?>" class="card-img-top "
                                   alt="<?php echo $row['title']; ?>">
                              <div class="overlay"></div> <!-- overlay untuk efek bayangan -->
                         </div>
                         <div class="card-body">
                              <h5 class="card-title"><?php echo $row['title']; ?></h5>
                              <p class="card-text post-content"><?php echo $row['content']; ?></p>
                         </div>
                         <div class="card-footer text-muted d-flex justify-content-between align-items-center">
                              <div>
                                   Diposting oleh: <?php echo $row['uploaded_by']; ?><br>
                                   Tanggal: <?php echo $row['upload_date']; ?>
                              </div>
                              <div class="button-container">
                                   <a href="blogs/komen.php?post_id=<?php echo $row['id']; ?>"
                                        class="btn btn-primary"><i class="bi bi-chat-left"></i></a>
                                   <a href="download.php?gambar=<?php echo $row['image']; ?>" class="btn btn-primary"><i
                                             class="bi bi-download"></i></a>
                              </div>
                         </div>
                    </div>
               </div>
               <?php
                         }
                    } else {
               ?>
               <div class="alert alert-dark">
                    <p>Tidak ada gambar</p>
                    <a href="blogs/upload.php" class="btn btn-dark">Klik di sini untuk post</a>
               </div>
               <?php
                    }

                    // Tutup koneksi
                    $conn->close();
               ?>
          </div>
     </div>
     <!-- <?php include('footer/footer.php'); ?> -->

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+0pEd5eY1z4+cBB+z8V+W9CKMpYW4" crossorigin="anonymous">
     </script>
</body>

</html>
