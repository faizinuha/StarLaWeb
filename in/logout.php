<?php
session_start();

// Hapus semua variabel session
session_unset();

// Hancurkan session
session_destroy();

// Redirect ke halaman login atau halaman lainnya
header("Location: ../profile/tampilan-logout.php");
exit();
?>
