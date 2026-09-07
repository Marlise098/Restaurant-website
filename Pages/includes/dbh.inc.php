<?php

 $dsn = "mysql:host=localhost;dbname=u250404_gluwebsite";
 $dbusername = "u250404_gluwebsite";
 $dbpassword = "R@@mweg3";

 try {
   $pdo = new PDO($dsn, $dbusername, $dbpassword);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
 }