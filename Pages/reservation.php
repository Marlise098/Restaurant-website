<div class="reservation-form" id="reservation"><form method="POST">
    <input type="hidden" name="form_type" value="reservation">

    <div class="form-group">
        <input type="text" name="name" placeholder="Name" required>
    </div>

    <div class="form-group">
        <input type="email" name="email" placeholder="Email" required>
    </div>

    <div class="form-group">
        <input type="tel" name="phone" placeholder="Phone" required>
    </div>

    <div class="form-group">
        <input type="date" name="reservation_date" required>
    </div>

    <div class="form-group">
        <input type="time" name="reservation_time" required>
    </div>

    <div class="form-group">
        <input type="number" name="guests" min="1" max="20"
               placeholder="Number of guests" required>
    </div>

    <div class="form-group form-group-message">
        <textarea name="message" placeholder="Message"></textarea>
    </div>

    <div class="submit-btn">
        <button type="submit">Reserve</button>
    </div>
<<<<<<< Updated upstream
    </form>
=======

</form>
>>>>>>> Stashed changes
</div>

<?php

require_once __DIR__ . '/includes/dbh.inc.php';
$message = "";

// Both forms post to the same page; only handle reservations here.
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["form_type"]) && $_POST["form_type"] === "reservation") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $reservation_date = $_POST["reservation_date"];
    $reservation_time = $_POST["reservation_time"];
    $guests = $_POST["guests"];
    $message = $_POST["message"];

    $sql = "INSERT INTO reservations
            (name, email, phone, reservation_date, reservation_time, guests, message)
            VALUES
            (:name, :email, :phone, :reservation_date, :reservation_time, :guests, :message)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":phone" => $phone,
        ":reservation_date" => $reservation_date,
        ":reservation_time" => $reservation_time,
        ":guests" => $guests,
        ":message" => $message
    ]);
    
    $message = "Reservation successfully created!";

}
?>

<?php if ($message): ?>
    <p class="reservation-success">
        <?php echo $message; ?>
    </p>
<?php endif; ?>
