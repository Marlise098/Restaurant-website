<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Admin Panel</title>
</head>
<body>
    <div class="admin-panel">
        <h1 class="admin-title">Admin Panel</h1>
        <p class="admin-description">Welcome, Admin!</p>
        <a href="logout.php" class="admin-logout">Logout</a>
    </div>

    <?php
    // Include the database connection file
    require_once __DIR__ . '/../includes/dbh.inc.php';
    ?>
    <?php
    // Include the footer.php file
    include __DIR__ . '/../footer.php';
    ?>
</body>
</html>