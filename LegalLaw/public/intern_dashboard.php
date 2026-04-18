<?php
session_start();
require '../src/config/database.php';

// Check if intern is logged in
if (!isset($_SESSION['intern_logged_in']) || !$_SESSION['intern_logged_in']) {
    header("Location: intern_login.php");
    exit();
}

$intern_id = $_SESSION['id'];

// Fetch intern details from the database
try {
    $stmt = $pdo->prepare("SELECT name, email, phone_number FROM Interns WHERE id = ?");
    $stmt->execute([$intern_id]);
    $intern = $stmt->fetch();

    if (!$intern) {
        echo "Intern not found!";
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
    <title>Intern Dashboard</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to the Intern Dashboard</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($intern['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($intern['email']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($intern['phone_number']); ?></p>

        <!-- Dashboard Options -->
        <div class="d-flex justify-content-center mt-4">
            <a href="intern_messages.php" class="btn btn-primary btn-lg mx-2">Messages</a>
            <a href="view_tasks.php" class="btn btn-success btn-lg mx-2">View Assigned Tasks</a>
            <a href="I_profile_edit.php" class="btn btn-info btn-lg mx-2">View/Update Profile</a>
            <a href="logout.php" class="btn btn-danger btn-lg mx-2">Logout</a>
        </div>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> LegalLaw. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
