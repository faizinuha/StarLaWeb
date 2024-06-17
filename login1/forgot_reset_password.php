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
            <form id="resetForm" method="post" action="proses_data/proses_reset.php">
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
