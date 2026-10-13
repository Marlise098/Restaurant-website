<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/Koi Logo.png" type="image/x-icon">
    <title>Restaurant HomePage</title>
</head>
<body id="index">
    <?php
    // Share one database connection across the menu and forms.
    require_once __DIR__ . '/includes/dbh.inc.php';

    include __DIR__ . '/header.php';
    include __DIR__ . '/hero.php';
    include __DIR__ . '/menu.php';
    include __DIR__ . '/about.php';
    include __DIR__ . '/reservation.php';
    include __DIR__ . '/contact.php';
    include __DIR__ . '/footer.php';
    ?>
    <script src="../js/script.js"></script>
</body>
</html>
