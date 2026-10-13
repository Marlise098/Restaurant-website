<?php
require_once __DIR__ . '/admin-auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && admin_verify_csrf()) {
    $_SESSION = [];
    session_regenerate_id(true);
}

header('Location: login.php');
exit;
