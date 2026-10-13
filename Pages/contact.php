
<?php
require_once __DIR__ . '/includes/dbh.inc.php';

// Both forms post to the same page; handle only this form.
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["form_type"]) && $_POST["form_type"] === "contact") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $sql = "INSERT INTO contact (name, email, message)
            VALUES (:name, :email, :message)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":message" => $message
    ]);

    echo "<p>Thank you for your message! We will get back to you soon.</p>";
}
?>

<div class="contact" id="contact">

    <form method="POST">
        <input type="hidden" name="form_type" value="contact">

        <h2>Contact Us</h2>

        <p>Have questions or feedback? We'd love to hear from you!</p>

        <input
            type="text"
            name="name"
            placeholder="Your Name"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Your Email"
            required
        >

        <textarea
            name="message"
            placeholder="Your Message"
            required
        ></textarea>

        <button type="submit">Send Message</button>

    </form>

</div>
