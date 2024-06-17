<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <style>
        /* CSS untuk elemen loading screen */
        #loading-screen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 9999;
        }

        /* CSS untuk elemen alert */
        .alert {
            display: none;
            padding: 0.5rem 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
            border: 1px solid transparent;
        }

        .alert-success {
            background-color: #d1e7dd;
            border-color: #badbcc;
            color: #0f5132;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>

    <div id="loading-screen" class="flex items-center justify-center">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
            <h3 class="text-center text-2xl font-bold mb-6">Reset Kata Sandi</h3>

            <!-- Alert -->
            <div id="alert" class="alert"></div>

            <!-- Form untuk "Reset Password" -->
            <form id="resetForm" method="post" action="proses_data/proses_reset.php">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold mb-2">Email:</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-semibold mb-2">Kata Sandi Baru:</label>
                    <input type="password" name="new_password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
                </div>
                <button type="submit" name="reset_password" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Atur Ulang
                    Kata Sandi</button>
            </form>
        </div>
    </div>

    <!-- JavaScript untuk menampilkan pesan kesalahan atau kesuksesan -->
    <script>
        // Ambil query parameter dari URL jika ada
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success');
        const errorMessage = urlParams.get('error');

        // Fungsi untuk menampilkan pesan kesalahan atau kesuksesan
        function showAlert(message, type) {
            const alertElement = document.getElementById('alert');
            alertElement.innerText = message;
            alertElement.classList.add('alert-' + type);
            alertElement.style.display = 'block';
        }

        // Tampilkan pesan kesalahan jika ada
        if (errorMessage) {
            showAlert(errorMessage, 'danger');
        }

        // Tampilkan pesan kesuksesan jika ada
        if (successMessage) {
            showAlert(successMessage, 'success');
        }
    </script>
</body>

</html>
