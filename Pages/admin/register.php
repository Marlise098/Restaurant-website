<?php
require_once __DIR__ . '/admin-auth.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: admin.php');
    exit;
}

// Registration is available only until the first admin account exists.
$adminCount = (int) $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && // Registration is available only until the first admin account exists.
$adminCount === 0) {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

    if (!admin_verify_csrf()) {
        $error = 'Your session expired. Please try again.';
    } elseif (strlen($username) < 3 || strlen($username) > 100) {
        $error = 'Username must be between 3 and 100 characters.';
    } elseif (strlen($password) < 8) {
        $error = 'Use a password with at least 8 characters.';
    } elseif ($password !== $confirmPassword) {
        $error = 'The passwords do not match.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (:username, :password_hash)');
        $stmt->execute([
            'username' => $username,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int) $pdo->lastInsertId();
        $_SESSION['admin_username'] = $username;
        header('Location: admin.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="admin.css">
    <title>Create Admin | KŌI</title>
</head>
<body class="admin-body">
    <main class="admin-auth-card">
        <a class="admin-brand" href="../index.php">KŌI <span>ADMIN</span></a>
        <?php if ($adminCount > 0): ?>
            <h1>Registration closed</h1>
            <p class="admin-muted">An admin account already exists. Ask an administrator to manage access.</p>
            <a class="admin-button admin-button-link" href="login.php">Go to sign in</a>
        <?php else: ?>
            <h1>Create admin account</h1>
            <p class="admin-muted">Registration is only available for the first admin account.</p>
            <?php if ($error): ?><p class="admin-alert" role="alert"><?= admin_escape($error) ?></p><?php endif; ?>
            <form method="post" class="admin-form">
                <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
                <label>Username<input name="username" minlength="3" maxlength="100" autocomplete="username" required></label>
                <label>Password<input type="password" name="password" minlength="8" autocomplete="new-password" required></label>
                <label>Confirm password<input type="password" name="confirm_password" minlength="8" autocomplete="new-password" required></label>
                <button class="admin-button" type="submit">Create account</button>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>
