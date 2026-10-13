<?php
// Authentication
require_once __DIR__ . '/admin-auth.php';
require_once __DIR__ . '/../includes/upload.inc.php';
admin_require_login();

$error = '';
$editItem = null;
$editingReservation = null;

// Check the session token before changing restaurant records.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!admin_verify_csrf()) {
        $error = 'Your session expired. Please try again.';
    } else {
        $action = (string) ($_POST['action'] ?? '');
        $id = (int) ($_POST['id'] ?? 0);

        try {
            if ($action === 'save_menu') {
                // Read the form fields
                $name = trim((string) ($_POST['name'] ?? ''));
                $description = trim((string) ($_POST['description'] ?? ''));
                $category = trim((string) ($_POST['category'] ?? ''));
                $price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_FLOAT);
                $image = trim((string) ($_POST['existing_image'] ?? ''));

                // Upload a new image
                if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $uploadResult = admin_upload_image($_FILES['image_file']);
                    if ($uploadResult['image'] !== '') {
                        $image = $uploadResult['image'];
                    } else {
                        $error = $uploadResult['error'];
                        $editItem = $_POST;
                    }
                }

                if ($error === '' && ($name === '' || $category === '' || $image === '' || $price === false || $price < 0)) {
                    $error = 'Enter a name, category, dish image, and valid price.';
                    $editItem = $_POST;
                }

                if ($error === '') {
                    $values = [
                        'name' => $name,
                        'description' => $description,
                        'category' => $category,
                        'price' => $price,
                        'image' => basename($image),
                        'available' => isset($_POST['available']) ? 1 : 0,
                    ];

                    if ($id > 0) {
                        $currentImage = trim((string) ($_POST['existing_image'] ?? ''));
                        if ($currentImage !== '' && $currentImage !== $values['image']) {
                            $oldImagePath = dirname(__DIR__, 2) . '/images/' . basename($currentImage);
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }

                        $values['id'] = $id;
                        $stmt = $pdo->prepare('UPDATE menu SET name = :name, description = :description, category = :category, price = :price, image = :image, available = :available WHERE id = :id');
                        $stmt->execute($values);
                    } else {
                        $stmt = $pdo->prepare('INSERT INTO menu (name, description, category, price, image, available) VALUES (:name, :description, :category, :price, :image, :available)');
                        $stmt->execute($values);
                    }

                    header('Location: admin.php#menu');
                    exit;
                }
            } elseif ($action === 'save_reservation' && $id > 0) {
                $name = trim((string) ($_POST['name'] ?? ''));
                $email = trim((string) ($_POST['email'] ?? ''));
                $phone = trim((string) ($_POST['phone'] ?? ''));
                $reservationDate = trim((string) ($_POST['reservation_date'] ?? ''));
                $reservationTime = trim((string) ($_POST['reservation_time'] ?? ''));
                $guests = filter_var($_POST['guests'] ?? null, FILTER_VALIDATE_INT);
                $message = trim((string) ($_POST['message'] ?? ''));

                if ($name === '' || $email === '' || $phone === '' || $reservationDate === '' || $reservationTime === '' || $guests === false || $guests < 1) {
                    $error = 'Please complete all reservation fields before saving.';
                    $editingReservation = $_POST;
                    $editingReservation['id'] = $id;
                } else {
                    $stmt = $pdo->prepare('UPDATE reservations SET name = :name, email = :email, phone = :phone, reservation_date = :reservation_date, reservation_time = :reservation_time, guests = :guests, message = :message WHERE id = :id');
                    $stmt->execute([
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'reservation_date' => $reservationDate,
                        'reservation_time' => $reservationTime,
                        'guests' => $guests,
                        'message' => $message,
                        'id' => $id,
                    ]);

                    header('Location: admin.php#reservations');
                    exit;
                }
            } elseif ($action === 'delete_menu' && $id > 0) {
                $stmt = $pdo->prepare('DELETE FROM menu WHERE id = :id');
                $stmt->execute(['id' => $id]);
                header('Location: admin.php#menu');
                exit;
            } elseif ($action === 'delete_contact' && $id > 0) {
                $stmt = $pdo->prepare('DELETE FROM contact WHERE id = :id');
                $stmt->execute(['id' => $id]);
                header('Location: admin.php#messages');
                exit;
            } elseif ($action === 'delete_reservation' && $id > 0) {
                $stmt = $pdo->prepare('DELETE FROM reservations WHERE id = :id');
                $stmt->execute(['id' => $id]);
                header('Location: admin.php#reservations');
                exit;
            } elseif ($action === 'edit_reservation' && $id > 0) {
                $stmt = $pdo->prepare('SELECT id, name, email, phone, reservation_date, reservation_time, guests, message FROM reservations WHERE id = :id');
                $stmt->execute(['id' => $id]);
                $editingReservation = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

                if (!$editingReservation) {
                    $error = 'Reservation not found.';
                }
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $error = 'That change could not be saved.';
        }
    }
}

if ($editItem === null && isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT id, name, description, category, price, image, available FROM menu WHERE id = :id');
    $stmt->execute(['id' => (int) $_GET['edit']]);
    $editItem = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

$menuItems = $pdo->query('SELECT id, name, description, category, price, image, available FROM menu ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
$messages = $pdo->query('SELECT id, name, email, message FROM contact ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
$reservations = $pdo->query('SELECT id, name, email, phone, reservation_date, reservation_time, guests, message FROM reservations ORDER BY reservation_date DESC, reservation_time DESC')->fetchAll(PDO::FETCH_ASSOC);

// Load the records displayed in the dashboard.
$pageTitle = 'Admin panel';
require __DIR__ . '/admin-header.php';
?>

<div class="admin-page-heading">
    <div>
        <p class="admin-eyebrow">RESTAURANT MANAGEMENT</p>
        <h1>Admin panel</h1>
    </div>
    <p class="admin-muted">Signed in as <?= admin_escape($_SESSION['admin_username'] ?? 'Admin') ?></p>
</div>

<section class="admin-stat-grid" aria-label="Record totals">
    <a class="admin-stat" href="#menu">
        <span>
            Menu items
        </span>
        <strong>
            <?= count($menuItems) ?>
        </strong>
        <small>
            Edit dishes
        </small>
    </a>
    <a class="admin-stat" href="#messages">
        <span>
            Contact messages
        </span>
        <strong>
            <?= count($messages) ?>
        </strong>
        <small>
            View inquiries
        </small>
    </a>
    <a class="admin-stat" href="#reservations">
        <span>
            Reservations
        </span>
        <strong>
            <?= count($reservations) ?>
        </strong>
        <small>
            View bookings
        </small>
    </a>
</section>
<?php if ($error): ?>
    <p class="admin-alert" role="alert"><?= admin_escape($error) ?></p>
<?php endif; ?>

<section class="admin-panel-section" id="menu">
    <h2>
        Menu
        <span class="admin-count"><?= count($menuItems) ?> items</span>
    </h2>
    <form method="post" action="admin.php#menu" class="admin-form admin-menu-form" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
        <input type="hidden" name="action" value="save_menu">
        <input type="hidden" name="id" value="<?= admin_escape($editItem['id'] ?? '') ?>">
        <input type="hidden" name="existing_image" value="<?= admin_escape($editItem['image'] ?? '') ?>">
        <label>
            Dish name
            <input name="name" value="<?= admin_escape($editItem['name'] ?? '') ?>" required>
        </label>
        <label>
            Category
            <input name="category" value="<?= admin_escape($editItem['category'] ?? '') ?>" required>
        </label>
        <label>
            Price (€)
            <input type="number" name="price" min="0" step="0.01" value="<?= admin_escape($editItem['price'] ?? '') ?>" required>
        </label>
        <label>
            Dish image
            <input type="file" name="image_file" accept="image/*" <?= $editItem ? '' : 'required' ?>>
            <?php if (!empty($editItem['image'])): ?>
                <small>Current file: <?= admin_escape($editItem['image']) ?></small>
            <?php endif; ?>
        </label>
        <label class="admin-field-wide">
            Description
            <textarea name="description" rows="3"><?= admin_escape($editItem['description'] ?? '') ?></textarea>
        </label>
        <label class="admin-checkbox">
            <input type="checkbox" name="available" value="1" <?= !isset($editItem['available']) || $editItem['available'] ? 'checked' : '' ?>>
            Available on public menu
        </label>
        <div class="admin-form-actions">
            <button class="admin-button" type="submit">
                <?= $editItem ? 'Save changes' : 'Add dish' ?>
            </button>
            <?php if ($editItem): ?>
                <a class="admin-text-link" href="admin.php#menu">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>
                        Dish
                    </th>
                    <th>
                        Category
                    </th>
                    <th>
                        Price
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menuItems as $item): ?>
                    <tr>
                        <td>
                            <strong>
                                <?= admin_escape($item['name']) ?>
                            </strong>
                            <small>
                                <?= admin_escape($item['description']) ?>
                            </small>
                        </td>
                        <td><?= admin_escape($item['category']) ?></td>
                        <td>€ <?= number_format((float) $item['price'], 2, ',', '.') ?></td>
                        <td>
                            <span class="admin-status <?= $item['available'] ? 'is-available' : '' ?>">
                                <?= $item['available'] ? 'Available' : 'Hidden' ?>
                            </span>
                        </td>
                        <td class="admin-row-actions">
                            <?php if ($item['available']): ?>
                                <a class="admin-text-link" href="../menu-detail.php?id=<?= (int) $item['id'] ?>">View</a>
                            <?php endif; ?>
                            <a class="admin-text-link" href="?edit=<?= (int) $item['id'] ?>#menu">
                                Edit
                            </a>
                            <form method="post" action="admin.php#menu" onsubmit="return confirm('Delete this dish?')">
                                <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
                                <input type="hidden" name="action" value="delete_menu">
                                <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                <button class="admin-danger-link" type="submit">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$menuItems): ?>
                    <tr>
                        <td colspan="5" class="admin-empty">No menu items yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="admin-panel-section" id="messages">
    <h2>
        Contact messages
        <span class="admin-count"><?= count($messages) ?> total</span>
    </h2>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>
                        From
                    </th>
                    <th>
                        Message
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td>
                            <strong>
                                <?= admin_escape($message['name']) ?>
                            </strong>
                            <a class="admin-email" href="mailto:<?= admin_escape($message['email']) ?>">
                                <?= admin_escape($message['email']) ?>
                            </a>
                        </td>
                        <td class="admin-message-cell"><?= nl2br(admin_escape($message['message'])) ?></td>
                        <td>
                            <form method="post" action="admin.php#messages" onsubmit="return confirm('Delete this message?')">
                                <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
                                <input type="hidden" name="action" value="delete_contact">
                                <input type="hidden" name="id" value="<?= (int) $message['id'] ?>">
                                <button class="admin-danger-link" type="submit">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$messages): ?>
                    <tr>
                        <td colspan="3" class="admin-empty">No contact messages yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="admin-panel-section" id="reservations">
    <h2>
        Reservations
        <span class="admin-count"><?= count($reservations) ?> total</span>
    </h2>

    <?php if ($editingReservation): ?>
        <form method="post" action="admin.php#reservations" class="admin-form">
            <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
            <input type="hidden" name="action" value="save_reservation">
            <input type="hidden" name="id" value="<?= (int) ($editingReservation['id'] ?? 0) ?>">

            <label>
                Guest name
                <input type="text" name="name" value="<?= admin_escape($editingReservation['name'] ?? '') ?>" required>
            </label>
            <label>
                Email
                <input type="email" name="email" value="<?= admin_escape($editingReservation['email'] ?? '') ?>" required>
            </label>
            <label>
                Phone
                <input type="tel" name="phone" value="<?= admin_escape($editingReservation['phone'] ?? '') ?>" required>
            </label>
            <label>
                Reservation date
                <input type="date" name="reservation_date" value="<?= admin_escape($editingReservation['reservation_date'] ?? '') ?>" required>
            </label>
            <label>
                Reservation time
                <input type="time" name="reservation_time" value="<?= admin_escape($editingReservation['reservation_time'] ?? '') ?>" required>
            </label>
            <label>
                Guests
                <input type="number" name="guests" min="1" max="20" value="<?= (int) ($editingReservation['guests'] ?? 1) ?>" required>
            </label>
            <label class="admin-field-wide">
                Message
                <textarea name="message" rows="3"><?= admin_escape($editingReservation['message'] ?? '') ?></textarea>
            </label>

            <div class="admin-form-actions">
                <button class="admin-button" type="submit">Save reservation</button>
                <a class="admin-text-link" href="admin.php#reservations">Cancel</a>
            </div>
        </form>
    <?php endif; ?>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>
                        Guest
                    </th>
                    <th>
                        Date &amp; time
                    </th>
                    <th>
                        Guests
                    </th>
                    <th>
                        Message
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td>
                            <strong>
                                <?= admin_escape($reservation['name']) ?>
                            </strong>
                            <a class="admin-email" href="mailto:<?= admin_escape($reservation['email']) ?>">
                                <?= admin_escape($reservation['email']) ?>
                            </a>
                            <small>
                                <?= admin_escape($reservation['phone']) ?>
                            </small>
                        </td>
                        <td>
                            <?= admin_escape($reservation['reservation_date']) ?>
                            <small>
                                <?= admin_escape($reservation['reservation_time']) ?>
                            </small>
                        </td>
                        <td><?= (int) $reservation['guests'] ?></td>
                        <td class="admin-message-cell"><?= nl2br(admin_escape($reservation['message'])) ?></td>
                        <td class="admin-row-actions">
                            <form method="post" action="admin.php#reservations">
                                <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
                                <input type="hidden" name="action" value="edit_reservation">
                                <input type="hidden" name="id" value="<?= (int) $reservation['id'] ?>">
                                <button class="admin-text-link" type="submit" >
                                    Edit
                                </button>
                            </form>
                            <form method="post" action="admin.php#reservations" onsubmit="return confirm('Delete this reservation?')">
                                <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
                                <input type="hidden" name="action" value="delete_reservation">
                                <input type="hidden" name="id" value="<?= (int) $reservation['id'] ?>">
                                <button class="admin-danger-link" type="submit">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$reservations): ?>
                    <tr>
                        <td colspan="5" class="admin-empty">No reservations yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
</main>
<?php require __DIR__ . '/../footer.php'; ?>
</body>
</html>
