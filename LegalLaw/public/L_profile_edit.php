<?php
session_start();
require '../src/config/database.php';

// Check if lawyer is logged in
if (!isset($_SESSION['lawyer_logged_in']) || !$_SESSION['lawyer_logged_in']) {
    header("Location: lawyer_login.php");
    exit();
}

$lawyer_id = $_SESSION['id'];
$message = "";

// Fetch current lawyer data
try {
    $stmt = $pdo->prepare("SELECT * FROM Lawyers WHERE id = ?");
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

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);  // Corrected here

    // Simple validation
    if (empty($name) || empty($email) || empty($phone_number)) {
        $message = "All fields are required.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE Lawyers SET name = ?, email = ?, phone_number = ? WHERE id = ?");
            $stmt->execute([$name, $email, $phone_number, $lawyer_id]);
            $message = "Profile updated successfully!";
        } catch (PDOException $e) {
            $message = "Error updating profile: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Lawyer Profile</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Update Your Profile</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($lawyer['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($lawyer['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" value="<?php echo htmlspecialchars($lawyer['phone_number']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="lawyer_dashboard.php" class="btn btn-secondary">Go Back</a>
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
