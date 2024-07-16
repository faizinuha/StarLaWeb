<?php
session_start();

// Periksa apakah pengguna sudah masuk atau belum
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Sambungkan ke database Anda
require_once __DIR__ . '/../allkoneksi/koneksi.php';

// Ambil informasi pengguna dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $name = $row['name'];
  $username = $row['username'];
  $TikTok = $row['TikTok'];
  $instagram = $row['instagram'];
  $Twitter = $row['Twitter'];
  $about_me = $row['about_me'];
} else {
  echo "Informasi pengguna tidak ditemukan.";
}

// Ambil foto-foto yang telah diupload oleh pengguna
$query_photos = "SELECT * FROM posts WHERE user_id = $user_id ORDER BY uploaded_by DESC";
$result_photos = mysqli_query($koneksi, $query_photos);

// Tutup koneksi ke database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
</head>

<body>
  <section style="background-color: #eee;">
    <div class="container py-5">
      <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="profile_user.php">User</a></li>
              <li class="breadcrumb-item"><a href="../in/logout.php" id="logout">Log Out</a></li>
              <li class="breadcrumb-item"><a href="../blogs/upload.php">Uploads</a></li>
              <li class="breadcrumb-item active" aria-current="page">HI, <?php echo htmlspecialchars($name); ?></li>
            </ol>
          </nav>
        </div>
      </div>
      <script>
        var logoutLink = document.getElementById('logout');
        logoutLink.addEventListener('click', function(event) {
          event.preventDefault();
          logout();
        });

        function logout() {
          Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Anda tidak akan dapat mengembalikannya!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, keluar!"
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Berhasil Keluar!",
                text: "Anda telah keluar.",
                icon: "success"
              });
              setTimeout(function() {
                window.location.href = "../in/logout.php";
              }, 2000);
            }
          });
        }
      </script>

      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center">
              <a href="upload.php">
                <?php if (!empty($row['profile_image_path'])) : ?>
                  <img src="<?php echo htmlspecialchars($row['profile_image_path']); ?>" alt="avatar" class="rounded float-start" style="width: 150px;">
                <?php else : ?>
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGst2EJfEU4M83w0oCJ0mpZ1O_n8jpiuvjOO4IvOFgRA&s" alt="avatar" class="rounded float-start" style="width: 150px;">
                <?php endif; ?>
              </a>
              <h5 class="my-3"><?php echo htmlspecialchars($name); ?></h5>
              <p class="text-muted mb-1"><?php echo htmlspecialchars($username); ?></p>
              <div class="row justify-content-center mt-lg-5">
                <div class="col-md-auto">
                  <a href="edit.php" type="button" class="btn btn-primary me-2"><i class="bi bi-pencil-square"></i></a>
                  <a href="../SpeedTyping/index.html" class="btn btn-danger me-2 " target="_blank"><i class="bi bi-braces"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="card mb-4 mb-lg-0">
            <div class="card-body p-0">
              <ul class="list-group list-group-flush rounded-3">
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="bi bi-instagram" style="color: #55acee;"></i>
                  <p class="mb-0"><a href="<?php echo htmlspecialchars($instagram); ?>" class="text-primary" target="_blank"><?php echo htmlspecialchars($instagram); ?></a></p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="bi bi-tiktok" style="color: #333333;"></i>
                  <p class="mb-0"><a href="<?php echo htmlspecialchars($Twitter); ?>" class="text-primary" target="_top"><?php echo htmlspecialchars($Twitter); ?></a></p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="bi bi-twitter" style="color: #55acee;"></i>
                  <p class="mb-0"><a href="<?php echo htmlspecialchars($TikTok); ?>" class="text-primary" target="_top"><?php echo htmlspecialchars($TikTok); ?></a></p>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Name</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?php echo htmlspecialchars($name); ?></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Full Name</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?php echo htmlspecialchars($username); ?></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">About Me</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?php echo htmlspecialchars($about_me); ?></p>
                </div>
              </div>
              <hr>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Uploaded Photos</h5>
              <div class="row">
                <?php while ($photo = mysqli_fetch_assoc($result_photos)) : ?>
                  <div class="col-md-3 mb-4">
                    <div class="card">
                      <img src="../blogs/uploads/<?php echo htmlspecialchars($photo['image']); ?>" class="card-img-top" alt="User Photo">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="badge <?php echo $photo['status'] == 'pending' ? 'bg-warning' : 'bg-success'; ?>">
                            <?php echo ucfirst(htmlspecialchars($photo['status'])); ?>
                          </span>
                          <!-- Tombol hapus -->
                          <button class="btn btn-danger" onclick="deletePhoto(<?php echo $photo['id']; ?>, '<?php echo htmlspecialchars($photo['image']); ?>')">
                            <i class="bi bi-trash"></i> Delete
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endwhile; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Include JS scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function deletePhoto(photoId, imageName) {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Foto akan dihapus secara permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'delete_photo.php',
            type: 'POST',
            data: {
              photo_id: photoId,
              image_name: imageName
            },
            success: function(response) {
              if (response.trim() === 'success') {
                Swal.fire(
                  'Terhapus!',
                  'Foto berhasil dihapus.',
                  'success'
                ).then(() => {
                  location.reload(); // Refresh halaman setelah berhasil menghapus
                });
              } else {
                Swal.fire(
                  'Error!',
                  'Gagal menghapus foto.',
                  'error'
                );
              }
            },
            error: function() {
              Swal.fire(
                'Error!',
                'Terjadi kesalahan saat menghapus foto.',
                'error'
              );
            }
          });
        }
      });
    }
  </script>
</body>

</html>