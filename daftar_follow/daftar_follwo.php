<?php
include('follow.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Followers</title>
</head>
<body>
    <h1>Daftar Followers</h1>
    
    <?php if (!empty($followers)): ?>
        <ul>
            <?php foreach ($followers as $follower): ?>
                <li><?php echo htmlspecialchars($follower['name']) . " (" . htmlspecialchars($follower['username']) . ")"; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Kamu belum memiliki followers.</p>
    <?php endif; ?>
</body>
</html>
