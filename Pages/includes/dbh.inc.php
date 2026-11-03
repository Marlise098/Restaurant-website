<?php

// Select the connection settings for Docker, XAMPP, or live hosting.
$isDocker = in_array(
    gethostname(),
    ['apache.container', 'fpm.container'],
    true
);
if ($isDocker) {
    // Lokaal in Docker
    $host = 'mysql_db';
    $databaseName = 'reservations';
    $username = 'root';
    $password = 'root';
} elseif (PHP_OS_FAMILY === 'Windows') {
    // Lokaal in XAMPP
    $host = 'localhost';
    $databaseName = 'reservations';
    $username = 'root';
    $password = 'root';
} else {
    // Live hosting
    $host = 'localhost'; 
    $databaseName = 'u250404_gluwebsite';
    $username = 'u250404_gluwebsite';
    $password = 'R@@mweg3';
}

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$databaseName;charset=utf8mb4",
        $username,
        $password,
        [
            // Throw exceptions and use native prepared statements.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    error_log($e->getMessage());
    exit('De databaseverbinding is mislukt.');
}
