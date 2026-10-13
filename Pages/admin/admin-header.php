<?php
admin_require_login();
$activePage = $activePage ?? 'dashboard';
$pageTitle = $pageTitle ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../images/Koi Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="admin.css">
    <title><?= admin_escape($pageTitle) ?> | KŌI Admin</title>
</head>
<body class="admin-body">
    <header class="admin-header">
        <a class="admin-brand" href="admin.php">KŌI <span>ADMIN</span></a>
        <nav class="admin-nav" aria-label="Admin navigation">
            <a class="is-active" href="admin.php">Overview</a>
            <a href="admin.php#menu">Menu</a>
            <a href="admin.php#messages">Messages</a>
            <a href="admin.php#reservations">Reservations</a>
        </nav>
        <div class="admin-account">
            <span><?= admin_escape($_SESSION['admin_username'] ?? 'Admin') ?></span>
            <form method="post" action="logout.php">
                <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
                <button class="admin-logout" type="submit">Sign out</button>
            </form>
        </div>
    </header>
    <main class="admin-main">
