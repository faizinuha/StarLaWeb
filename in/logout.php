<?php

session_start();


session_unset();

session_destroy();


header("Location: ../index.php"); // Ganti dengan halaman login atau halaman lainnya
exit();
?>