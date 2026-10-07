<?php


$isDocker = in_array(
    gethostname(),
    ['apache.container', 'fpm.container'],
    true
);
if ($isDocker) {
    // Lokaal in Docker
    $host = 'mysql_db';
    $dbname = 'reservations';
    $username = 'root';
    $password = 'root';
} else {
    // Live hosting
    $host = 'localhost'; 
    $dbname = 'u250404_gluwebsite';
    $username = 'u250404_gluwebsite';
    $password = 'R@@mweg3';
}


try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
}   catch (PDOException $e) {
    error_log($e->getMessage());
    exit('De databaseverbinding is mislukt.');
}
