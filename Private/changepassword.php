<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$database = "blog";

// Membuat koneksi ke database
$koneksi = mysqli_connect($server, $username, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
// Function to clean input
function cleanInput($data) {
    global $koneksi;
    if (!$koneksi) {
        die("Database connection error: " . mysqli_connect_error());
    }
    return mysqli_real_escape_string($koneksi, $data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $email = cleanInput($_POST['email']);
    $resetCode = cleanInput($_POST['reset_code']);
    $newPassword = $_POST['new_password'];

    // Check if the email and verification code match
    $query = "SELECT * FROM users WHERE email='$email' AND verification_code='$resetCode'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in the database without clearing the verification code
        $updateQuery = "UPDATE users SET password='$hashedPassword' WHERE email='$email'";
        $updateResult = mysqli_query($koneksi, $updateQuery);

        if ($updateResult) {
            echo "<script>alert('Jangan Lupa Ya Terima Kasih.'); window.location.href = 'setting.php';</script>";
        } else {
            echo "Error updating password: " . mysqli_error($koneksi);
        }
    } else {
        echo "<script>alert('Kode reset tidak valid atau email tidak ditemukan.'); window.location.href = '../reset_password.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?php include('setting.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
            <h3 class="text-center text-2xl font-bold mb-6">Reset Kata Sandi</h3>

            <!-- Alert -->
            <div id="alert" class="alert"></div>

            <!-- Form untuk "Reset Password" -->
            <form id="resetForm" method="post">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold mb-2">Email:</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="reset_code" class="block text-sm font-semibold mb-2">Kode Reset:</label>
                    <input type="text" name="reset_code" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-semibold mb-2">Kata Sandi Baru:</label>
                    <input type="password" name="new_password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                </div>
                <button type="submit" name="reset_password" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Atur Ulang Kata Sandi</button>
            </form>
        </div>
    </div>
</body>
</html>

</body>
</html>