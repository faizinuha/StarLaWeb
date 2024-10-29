<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* Adjust sidebar width and styles */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            overflow-x: hidden;
            transition: all 0.3s;
            padding-top: 60px;
        }

        .sidebar.sticky {
            width: 250px;
            transition: all 0.3s;
        }

        .content {
            margin-left: 250px;
            transition: all 0.3s;
            padding: 20px;
        }
    </style>
</head>

<body>
    <!-- Bootstrap sidebar -->
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark text-white sidebar" id="sidebar-wrapper">

            <div class="list-group list-group-flush">
                <a href="../index.php" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-envelope"></i> Home
                </a>
                <a href="../blogs/upload.php" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-envelope"></i> Beranda
                </a>
                <!-- <a href="changepassword.php" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-cog"></i> Change Password
                </a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white"  onclick="Alert()">
                    <i class="fas fa-globe"></i> Change Language
                </a> -->
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" class="content">
            <div class="container-fluid">
                <h1 class="mt-4 font-bold ">Settings Page</h1>
                <p class="font-bold">Ini adalah halaman pengaturan dengan fitur Change Password, Change Email, dan navigasi sidebar.</p>
                <!-- Content here -->
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- animation sweee -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toggle sidebar script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    <script>
        function Alert() {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Masih Berkembang!",
                footer: '<a href="https://saweria.co/C02V" target="_blank">Donate Me?</a>'
            });
        }
    </script>
</body>

</html>