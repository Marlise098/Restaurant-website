<?php

 $dsn = "mysql:host=u250404.gluwebsite.nl;dbname=u250404_gluwebsite";
 $dbusername = "u250404_gluwebsite";
 $dbpassword = "";

 try {
   $pdo = new PDO($dsn, $dbusername, $dbpassword);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
 }