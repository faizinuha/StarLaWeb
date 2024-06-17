<?php
session_start(); // Starting the session

// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'users';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Verify Account</h2>
                <form action="proses_data/proses_verify.php" method="post" novalidate>
                    <div class="mb-3">
                        <label class="form-label" for="verification_code">Verification Code</label>
                        <input required name="verification_code" id="verification_code" class="form-control" type="text">
                        <div class="invalid-feedback">Please enter the verification code.</div>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Verify</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
