<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Interface</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .chat-container {
      background-color: #fff;
      width: 300px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 5px;
    }
    .messages {
      max-height: 200px;
      overflow-y: auto;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 5px;
    }
    .messages div {
      margin-bottom: 5px;
    }
    .form-control {
      width: calc(100% - 20px);
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .send-button {
      padding: 10px 20px;
      border: none;
      background-color: #28a745;
      color: white;
      cursor: pointer;
      border-radius: 5px;
      margin-top: 10px;
    }
    .user-img {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <div class="chat-container">
    <div class="messages" id="messages">
      <?php
      // Set up database connection
      $server = "localhost";
      $username = "root";
      $password = "";
      $database = "users";

      $koneksi = mysqli_connect($server, $username, $password, $database);

      if (!$koneksi) {
          die("Connection failed: " . mysqli_connect_error());
      }

      $query = "SELECT users.username, users.profile_image_path, messages.message, messages.timestamp FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.timestamp DESC";
      $result = mysqli_query($koneksi, $query);

      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<div><img src='../profile/upload/" . htmlspecialchars($row['profile_image_path']) . "' class='user-img'>";
              echo "<strong>" . htmlspecialchars($row['username']) . "</strong>: " . htmlspecialchars($row['message']) . " <small>(" . $row['timestamp'] . ")</small></div>";
          }
      } else {
          echo "No messages yet.";
      }

      // Close the connection
      mysqli_close($koneksi);
      ?>
    </div>
    <form action="../message-player/message_send.php" method="post">
      <input type="text" class="form-control" name="message" placeholder="Type your message here..." required>
      <!-- Inisiasi ID pengguna -->
      <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>" > <!-- Ganti dengan ID pengguna yang sesuai -->
      <button type="submit" class="send-button">Send</button>
    </form>
  </div>
</body>
</html>
