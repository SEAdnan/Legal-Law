<?php
require '../src/config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check for email and password in the Interns table
    $stmt = $pdo->prepare("SELECT * FROM Interns WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $intern = $stmt->fetch();

    if ($intern) {
        $_SESSION['intern_logged_in'] = true;
        $_SESSION['id'] = $intern['id']; 
        header("Location: intern_dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password!";
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
    <title>Intern Login</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Intern Login</h1>

        <!-- Error Message -->
        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="intern_login.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <!-- Registration Link -->
        <p class="mt-3">Don't have an account? <a href="register_intern.php">Register as Intern</a></p>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> LegalLaw. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
