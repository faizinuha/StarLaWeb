<?php
// Mulai sesi PHP
session_start();

// Periksa apakah pengguna sudah masuk atau belum
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Sambungkan ke database Anda
include_once "koneksi.php";

// Ambil informasi pengguna dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($koneksi, $query);

// Periksa apakah pengguna ditemukan
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $name = $row['name'];
  $username = $row['username'];
  // $email = $row['email'];
  $TikTok = $row['TikTok'];
  $instagram = $row['instagram'];
  $Twitter = $row['Twitter'];
  $about_me = $row['about_me'];
} else {
  echo "Informasi pengguna tidak ditemukan.";
}
?>
<!-- bosstraps -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- sweealert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<section style="background-color: #eee;">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="profile_user.php">User</a></li>
            <li class="breadcrumb-item"><a href="../in/logout.php" id="logout" >Log Out</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $name ?></li>
          </ol>
        </nav>
      </div>
    </div>
    <script>
  // Dapatkan elemen tautan logout
  var logoutLink = document.getElementById('logout');

  // Tambahkan event listener klik ke tautan logout
  logoutLink.addEventListener('click', function(event) {
    // Mencegah tindakan default dari tautan
    event.preventDefault();

    // Panggil fungsi logout
    logout();
  });

  // Tentukan fungsi logout
  function logout() {
    // Gunakan SweetAlert untuk mengonfirmasi logout
    Swal.fire({
      title: "Apakah Anda yakin?",
      text: "Anda tidak akan dapat mengembalikannya!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, keluar!"
    }).then((result) => {
      // Jika pengguna mengonfirmasi, tampilkan pesan berhasil (Anda bisa melakukan redirect di sini)
      if (result.isConfirmed) {
        Swal.fire({
          title: "Berhasil Keluar!",
          text: "Anda telah keluar.",
          icon: "success"
        });

        // Arahkan pengguna ke halaman logout setelah beberapa waktu
        setTimeout(function() {
          window.location.href = "../in/logout.php";
        }, 2000); // 2000 milidetik = 2 detik
      }
    });
  }
</script>

    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <!-- foto -->
            <!-- foto -->
            <a href="upload.php">
              <?php if (!empty($row['profile_image_path'])) : ?>
                <img src="<?php echo $row['profile_image_path']; ?>" alt="avatar" class="rounded float-start" style="width: 150px;">
              <?php else : ?>
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGst2EJfEU4M83w0oCJ0mpZ1O_n8jpiuvjOO4IvOFgRA&s" alt="avatar" class="rounded float-start" style="width: 150px;">
              <?php endif; ?>
            </a>
            <!-- akhir -->

            <!-- akhir -->
            <h5 class="my-3"><?php echo $name ?></h5>
            <p class="text-muted mb-1"><?php echo $username ?></p>

            <div class="row justify-content-center mt-lg-5">
              <div class="col-md-auto">
                <a href="edit.php" type="button" class="btn btn-primary me-2"><i class="bi bi-pencil-square"></i></a>
              </div>
              <div class="col-md-auto">
                <a href="../chatapp/home.php" type="button" class="btn btn-outline-danger "><i class="bi bi-chat-right-text"></i></a>
              </div>
            </div>



          </div>
        </div>
        <!-- target ganti -->
        <div class="card mb-4 mb-lg-0">
          <div class="card-body p-0">
            <ul class="list-group list-group-flush rounded-3">
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="bi bi-instagram" style="color: #55acee;"></i>
                <p class="mb-0"><a href="<?php echo $instagram; ?>" class="text-primary" target="_blank"><?php echo $instagram ?></a></p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="bi bi-tiktok" style="color: #333333;"></i>
                <p class="mb-0"><a href="<?php echo $Twitter; ?>" class="text-primary" target="_top"><?php echo $Twitter ?></a></p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="bi bi-twitter-x" style="color: #55acee;"></i>
                <p class="mb-0"><a href="<?php echo $TikTok; ?>" class="text-primary" target="_top"><?php echo $TikTok ?></a></p>
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
                <p class="text-muted mb-0"><?php echo $name ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $username ?></p>
              </div>
            </div>
            <hr>

            <!-- <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $email ?></p>
              </div>
            </div>
            <hr> -->
          </div>

          <div class="row justify-content-center  text-center">
            <div class="col-md-6">
              <div class="card mb-4 mb-md-0">
                <div class="card-body">
                  <p class="mb-4"><span class="text-primary font-italic me-1">About</span>Me
                  </p>
                  <div class="card">
                    <p class="m-2"><?php echo $about_me ?></p>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="col-md-6">
              <div class="card mb-4 mb-md-0">
                <div class="card-body">
                  <p class="mb-4"><span class="text-primary font-italic me-1">Status </span>
                  </p>
                  <div class="card">
                    <p class="m-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis unde libero
                      assumenda totam et nulla dolorum omnis deleniti rem! Illo?</p>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
</section>