<?php
session_start();
require '../src/config/database.php';

// Check if intern is logged in
if (!isset($_SESSION['intern_logged_in']) || !$_SESSION['intern_logged_in']) {
    header("Location: intern_login.php");
    exit();
}

$intern_id = $_SESSION['id'];
$message = "";

// Fetch current intern data
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

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);

    // Simple validation
    if (empty($name) || empty($email) || empty($phone_number)) {
        $message = "All fields are required.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE Interns SET name = ?, email = ?, phone_number = ? WHERE id = ?");
            $stmt->execute([$name, $email, $phone_number, $intern_id]);
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
    <title>Edit Profile</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Your Profile</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($intern['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($intern['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" value="<?php echo htmlspecialchars($intern['phone_number']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="intern_dashboard.php" class="btn btn-secondary">Go Back</a>
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
