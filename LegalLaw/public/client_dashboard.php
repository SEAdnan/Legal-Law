<?php
session_start();

// Check if the client is logged in
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true) {
    header("Location: client_login.php");
    exit();
}

// Example data retrieval logic for a client
require '../src/config/database.php';

$client_id = $_SESSION['client_id'];

try {
    // Fetch client details
    $stmt = $pdo->prepare("SELECT * FROM Clients WHERE id = ?");
    $stmt->execute([$client_id]);
    $client = $stmt->fetch();

    if (!$client) {
        echo "Client not found!";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Client Dashboard</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">LegalLaw</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Welcome, <?php echo htmlspecialchars($client['name']); ?>!</h1>
        <p>Email: <?php echo htmlspecialchars($client['email']); ?></p>
        <p>Phone: <?php echo htmlspecialchars($client['phone_number']); ?></p>
        <p>Address: <?php echo htmlspecialchars($client['address']); ?></p>

        <h2>Dashboard Options</h2>
        <ul>
            <li class="list-group-item"><a href="filter_lawyers.php">Find a Lawyer</a></li>
            <li class="list-group-item"><a href="view_appointments.php">View Your Appointments</a></li>
            <li class="list-group-item"><a href="edit_profile.php">Edit Your Profile</a></li>
            <li class="list-group-item"><a href="logout.php">Logout</a></li>
            <li class="list-group-item"><a href="contact_us.php">Contact Us</a></li>
        </ul>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> LegalLaw. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
