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
  
    // Include the database connection file
    include 'includes/dbh.inc.php';
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

    <!-- Include the about.php file -->
    <?php
      include 'about.php';
    ?>

    <!-- Include the reservation.php file -->
    <?php
      include 'reservation.php';
    ?>

    <!-- Include the contact.php file -->
    <?php
      include 'contact.php';
    ?>

    <!-- Include the footer.php file -->
    <?php
      include 'footer.php';
    ?>
</body>

 <script src="../js/script.js"></script>

</html>