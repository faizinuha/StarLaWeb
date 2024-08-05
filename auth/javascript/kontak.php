<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Service</title>
  <link rel="stylesheet" href="../style/kontak.css">
</head>
<body>
  <form id="form">
    <div class="field">
      <label for="from_name">Nama</label>
      <input type="text" name="from_name" id="from_name" required>
    </div>
    <div class="field">
      <label for="to_name">Email</label>
      <input type="email" name="to_name" id="to_name" required>
    </div>
    <div class="field">
      <label for="message">Message</label>
      <textarea name="message" id="message" rows="5" required></textarea>
    </div>
    <div class="field">
      <label for="reply_to">Reply To</label>
      <input type="text" name="reply_to" id="reply_to" required>
    </div>

    <input type="submit" id="button" value="Send Email">
  </form>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/emailjs-com@2.6.4/dist/email.min.js"></script>
  <script src="kontank.js"></script>
  <script type="text/javascript">
    emailjs.init('vUGaw61dBrDK4gX5K');
  </script>
</body>
</html>
