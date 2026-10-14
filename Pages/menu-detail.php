<?php
require_once __DIR__ . '/includes/dbh.inc.php';

// Lees het gerecht-id uit de URL
// Alleen positieve gehele getallen zijn geldig.
$menuItemId = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$menuItem = false;

// Haal alleen een beschikbaar gerecht op
if ($menuItemId !== false && $menuItemId !== null) {
    $menuQuery = $pdo->prepare('SELECT name, description, price, category, image FROM menu WHERE id = :id AND available = 1');
    $menuQuery->execute(['id' => $menuItemId]);
    $menuItem = $menuQuery->fetch(PDO::FETCH_ASSOC);
}

$pageTitle = $menuItem ? $menuItem['name'] : 'Dish not found';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/Koi Logo.png" type="image/png">
    <title><?= htmlspecialchars($pageTitle) ?> | KŌI</title>
</head>
<body class="dish-page">
    <?php include __DIR__ . '/header.php'; ?>
    <main class="dish-main">
        <a class="menu-detail-link dish-back" href="index.php#menu">&larr; Back to menu</a>
        <?php if ($menuItem): ?>
            <article class="dish-detail fade-in">
                <img class="dish-image"
                     src="../images/<?= htmlspecialchars(rawurlencode(basename($menuItem['image']))) ?>"
                     alt="<?= htmlspecialchars($menuItem['name']) ?>">
                <div class="dish-content">
                    <p class="menu-label"><?= htmlspecialchars($menuItem['category']) ?></p>
                    <h1><?= htmlspecialchars($menuItem['name']) ?></h1>
                    <p class="dish-description"><?= nl2br(htmlspecialchars($menuItem['description'])) ?></p>
                    <p class="dish-price">&euro;<?= number_format((float) $menuItem['price'], 2, ',', '.') ?></p>
                    <a class="dish-reserve" href="index.php#reservation">Reserve a table</a>
                </div>
            </article>
        <?php else: ?>
            <section class="dish-content dish-empty">
                <p class="menu-label">OUR MENU</p>
                <h1>Dish not found</h1>
                <p class="dish-description">This dish is currently unavailable. Explore our menu to find something else to enjoy.</p>
            </section>
        <?php endif; ?>
    </main>
    <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
