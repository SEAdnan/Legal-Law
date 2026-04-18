<?php
require '../src/config/database.php';

$error = '';
$success = '';

// Fetch interns for the dropdown menu
$interns = $pdo->query("SELECT id, name FROM Interns")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender_email = trim($_POST['sender_email']);
    $sender_phone = trim($_POST['sender_phone']);
    $receiver_id = $_POST['receiver_id'];
    $message_body = trim($_POST['message_body']);

    if (empty($sender_email) || empty($sender_phone) || empty($receiver_id) || empty($message_body)) {
        $error = "Please fill out all fields.";
    } elseif (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $sender_phone)) {
        $error = "Please enter a valid phone number (10-15 digits, optional + at the start).";
    } else {
        $stmt = $pdo->prepare("INSERT INTO Messages (sender_email, sender_phone, receiver_id, message_body) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$sender_email, $sender_phone, $receiver_id, $message_body])) {
            $success = "Message sent successfully!";
        } else {
            $error = "Failed to send the message.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Contact Us</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Contact Us</h1>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="contact_us.php">
            <div class="form-group">
                <label for="sender_email">Your Email</label>
                <input type="email" class="form-control" id="sender_email" name="sender_email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="sender_phone">Your Phone Number</label>
                <input type="text" class="form-control" id="sender_phone" name="sender_phone" placeholder="Enter your phone number" required>
            </div>
            <div class="form-group">
                <label for="receiver_id">Send to Intern</label>
                <select class="form-control" id="receiver_id" name="receiver_id" required>
                    <option value="">Select an Intern</option>
                    <?php foreach ($interns as $intern): ?>
                        <option value="<?php echo $intern['id']; ?>">
                            <?php echo htmlspecialchars($intern['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="message_body">Message</label>
                <textarea class="form-control" id="message_body" name="message_body" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> LegalLaw. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
