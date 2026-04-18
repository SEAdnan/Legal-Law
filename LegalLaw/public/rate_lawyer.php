<?php
session_start();
require '../src/config/database.php';
require '../src/helpers/auth.php';

// User authentication
if (!isAuthenticated() || $_SESSION['user_type'] !== 'client') {
    header("Location: login.php");
    exit();
}

$lawyer_id = $_GET['id'] ?? null;
$rating = '';
$error = '';
$success = '';

// Check if the lawyer ID
if (!$lawyer_id) {
    $error = "No lawyer ID provided.";
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rating = $_POST['rating'];

        if (empty($rating) || !is_numeric($rating) || $rating < 1 || $rating > 5) {
            $error = "Please provide a valid rating between 1 and 5.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO Ratings (lawyer_id, client_id, rating) VALUES (?, ?, ?)");
            if ($stmt->execute([$lawyer_id, $_SESSION['user_id'], $rating])) {
                $success = "Thank you for rating the lawyer!";
            } else {
                $error = "Failed to submit your rating. Please try again.";
            }
        }
    }
}

// Fetch lawyer information
$stmt = $pdo->prepare("SELECT * FROM Lawyers WHERE id = ?");
$stmt->execute([$lawyer_id]);
$lawyer = $stmt->fetch();

if (!$lawyer) {
    $error = "Lawyer not found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Rate Lawyer</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Rate Lawyer: <?php echo htmlspecialchars($lawyer['name']); ?></h1>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="rate_lawyer.php?id=<?php echo htmlspecialchars($lawyer_id); ?>">
            <div class="form-group">
                <label for="rating">Rating (1 to 5)</label>
                <input type="number" class="form-control" id="rating" name="rating" value="<?php echo htmlspecialchars($rating); ?>" min="1" max="5" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Rating</button>
        </form>

        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> LegalLaw. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
