<?php
require_once __DIR__ . '/admin-auth.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: admin.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!admin_verify_csrf()) {
        $error = 'Your session expired. Please try again.';
    } else {
        $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admin_users WHERE username = :username');
        $stmt->execute(['username' => trim((string) ($_POST['username'] ?? ''))]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify((string) ($_POST['password'] ?? ''), $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: admin.php');
            exit;
        }

        $error = 'Invalid username or password.';
    }
}

$adminCount = (int) $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Login | KŌI</title>
</head>
<body class="admin-body">
    <main class="admin-auth-card">
        <a class="admin-brand" href="../index.php">KŌI <span>ADMIN</span></a>
        <h1>Welcome back</h1>
        <p class="admin-muted">Sign in to manage the restaurant.</p>
        <?php if ($error): ?><p class="admin-alert" role="alert"><?= admin_escape($error) ?></p><?php endif; ?>
        <form method="post" class="admin-form">
            <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
            <label>Username<input name="username" autocomplete="username" required></label>
            <label>Password<input type="password" name="password" autocomplete="current-password" required></label>
            <button class="admin-button" type="submit">Sign in</button>
        </form>
        <?php if ($adminCount === 0): ?>
            <p class="admin-auth-switch">First time here? <a href="register.php">Create Your New Account</a></p>
        <?php endif; ?>
    </main>
</body>
</html>