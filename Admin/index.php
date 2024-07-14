<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>General Dashboard &mdash; Stisla</title>

    <?php
    include 'link.php';

    ?>
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
        <!-- main content -->
    <?php
    
    // Koneksi ke database
    include 'navbar.admin.php';
    // require_once __DIR__ . 'footer.php'
    ?>

    <?php
    // Koneksi ke database
    include 'footer.php';
    // require_once __DIR__ . 'footer.php'
    ?>
</body>

</html>