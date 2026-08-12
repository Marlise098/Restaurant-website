<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Restaurant HomePage</title>
</head>
<body>

 <?php
require_once __DIR__ . '/includes/dbh.inc.php';

var_dump($pdo);
?>
    <!-- Include the header.php file -->
    <?php
      include 'header.php';
    ?>
    <!-- Include the hero.php file -->
    <?php
      include 'hero.php';
    ?>

    <!-- Include the menu.php file -->
    <?php
      include 'menu.php';
    ?>
</body>

 <script src="../js/script.js"></script>

</html>