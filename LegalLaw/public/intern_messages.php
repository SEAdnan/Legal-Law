<?php
session_start();
require '../src/config/database.php';

if (!isset($_SESSION['intern_logged_in'])) {
    header('Location: intern_login.php');
    exit();
}

// Use the correct session variable for the intern's ID
$intern_id = $_SESSION['id'];

// Fetch messages for the logged-in intern
$stmt = $pdo->prepare("SELECT m.message_body, m.sent_at, m.sender_email, m.sender_phone 
                       FROM Messages m
                       WHERE m.receiver_id = ?");
$stmt->execute([$intern_id]);
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Intern Dashboard - Messages</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Your Messages</h1>
        <?php if ($messages): ?>
            <?php foreach ($messages as $message): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">From: <?php echo htmlspecialchars($message['sender_email']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Phone: <?php echo htmlspecialchars($message['sender_phone'] ?? 'Not provided'); ?></h6>
                        <p class="card-text"><?php echo htmlspecialchars($message['message_body']); ?></p>
                        <p class="card-text">
                            <small class="text-muted">Sent at: <?php echo htmlspecialchars($message['sent_at']); ?></small>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning">No messages found.</div>
        <?php endif; ?>
        <a href="intern_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> LegalLaw. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
