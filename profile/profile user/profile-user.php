<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
</head>
<body>
    <?php
    // Koneksi ke database
    include_once "../koneksi.php";
    $conn = new mysqli("localhost", "root", "", "users");

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mengambil data profil
    $sql = "SELECT * FROM users WHERE id = 1"; // asumsi mengambil user dengan id 1
    $result = $conn->query($sql);

    // Cek apakah ada data profil
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <div class="profile-container">
            <h1>Profil Pengguna</h1>
            <p>Nama: <?php echo $row['name']; ?></p>
            <p>Email: <?php echo $row['email']; ?></p>
            <p>Alamat: <?php echo $row['address']; ?></p>
        </div>
        <?php
    } else {
        echo "<p>Profil tidak ditemukan.</p>";
    }

    // Tutup koneksi
    $conn->close();
    ?>
</body>
</html>