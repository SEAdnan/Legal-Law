<?php
require '../src/config/database.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$type = $_GET['type'] ?? 'lawyers';

$tableMap = [
    'lawyers' => 'Lawyers',
    'clients' => 'Clients',
    'interns' => 'Interns',
];

if (!isset($tableMap[$type])) {
    echo "Invalid user type!";
    exit();
}

$tableName = $tableMap[$type];
$users = $pdo->query("SELECT * FROM $tableName")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manage <?php echo ucfirst($type); ?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Legal Help</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">Back to Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Manage <?php echo ucfirst($type); ?></h1>

        <?php if ($users): ?>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <form method="POST" action="delete_user.php" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                    <input type="hidden" name="type" value="<?php echo $type; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">No users found for this type.</div>
        <?php endif; ?>

        <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> Legal Help. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
