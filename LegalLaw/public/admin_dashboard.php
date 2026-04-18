<?php
require '../src/config/database.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch counts
$lawyersCount = $pdo->query("SELECT COUNT(*) FROM Lawyers")->fetchColumn();
$clientsCount = $pdo->query("SELECT COUNT(*) FROM Clients")->fetchColumn();
$internsCount = $pdo->query("SELECT COUNT(*) FROM Interns")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Admin Dashboard</title>
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
                    <a class="nav-link" href="admin_logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Welcome, Admin!</h1>
        <p><strong>Lawyers Registered:</strong> <?php echo $lawyersCount; ?></p>
        <p><strong>Clients Registered:</strong> <?php echo $clientsCount; ?></p>
        <p><strong>Interns Registered:</strong> <?php echo $internsCount; ?></p>

        <h2>Dashboard Options</h2>
        <ul class="list-group">
            <li class="list-group-item"><a href="view_users.php?type=lawyers">View/Delete Lawyers</a></li>
            <li class="list-group-item"><a href="view_users.php?type=clients">View/Delete Clients</a></li>
            <li class="list-group-item"><a href="view_users.php?type=interns">View/Delete Interns</a></li>
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
