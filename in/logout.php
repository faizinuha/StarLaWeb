<?php

session_start();


session_unset();

session_destroy();


header("Location: ../profile/tampilan-logout.php"); // Ganti dengan halaman login atau halaman lainnya
echo '<script>alert("berhasil log out");</script>';
exit();
?>