<?php
session_start();
require '../src/config/database.php';

// Check if lawyer is logged in
if (!isset($_SESSION['lawyer_logged_in']) || !$_SESSION['lawyer_logged_in']) {
    header("Location: lawyer_login.php");
    exit();
}

$lawyer_id = $_SESSION['id'];

// Fetch lawyer details from the database
try {
    $stmt = $pdo->prepare("SELECT name, email, phone_number FROM Lawyers WHERE id = ?");
    $stmt->execute([$lawyer_id]);
    $lawyer = $stmt->fetch();

    if (!$lawyer) {
        echo "Lawyer not found!";
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
    <title>Lawyer Dashboard</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to the Lawyer Dashboard</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($lawyer['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($lawyer['email']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($lawyer['phone_number']); ?></p>

        <!-- Options -->
        <ul class="list-group mt-4">
            <li class="list-group-item"><a href="view_cases.php">View Assigned Cases</a></li>
            <li class="list-group-item"><a href="L_profile_edit.php">View/Update Profile</a></li>
            <li class="list-group-item"><a href="logout.php">Logout</a></li>
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
