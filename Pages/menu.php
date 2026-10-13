<?php

require_once "includes/dbh.inc.php";

$stmt = $pdo->query("
    SELECT *
    FROM menu
    WHERE available = 1
    ORDER BY id ASC
");

$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="menu-section fade-in" id="menu">

    <div class="menu-header">
        <p class="menu-label">A TASTE OF JAPAN</p>
        <h2>OUR MENU</h2>
        <p class="menu-subtitle">
            Carefully crafted sushi, sashimi and signature rolls.
        </p>
    </div>

    <div class="menu-filter">
        <button class="filter-btn active" data-filter="all">All</button>
        <button class="filter-btn" data-filter="Nigiri">Nigiri</button>
        <button class="filter-btn" data-filter="Sashimi">Sashimi</button>
        <button class="filter-btn" data-filter="Sushi">Signature Rolls</button>
    </div>

    <div class="menu-grid">
    
        <?php foreach ($menuItems as $item): ?>

            <div class ="menu-card" data-category="<?= htmlspecialchars($item['category']) ?>">

               <img 
                 src="../images/<?= htmlspecialchars($item['image']) ?>"
                 alt="<?= htmlspecialchars($item['name']) ?>"
               >

                <div class="menu-card-content">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p><?= htmlspecialchars($item['description']) ?></p>
                    
                    <span>

                       €<?= number_format($item['price'], 2, ',', '.') ?>
                    </span>
                </div>

            </div>
        <?php endforeach; ?>

    </div>

</div>


