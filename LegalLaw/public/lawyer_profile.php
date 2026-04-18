<?php
require '../src/config/database.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>No lawyer specified.</div>";
    exit();
}

$lawyerId = $_GET['id'];

// Fetch lawyer details
$stmt = $pdo->prepare("SELECT * FROM Lawyers WHERE id = ?");
$stmt->execute([$lawyerId]);
$lawyer = $stmt->fetch();

if (!$lawyer) {
    echo "<div class='alert alert-danger'>Lawyer not found.</div>";
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
    <title>Lawyer Profile</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Lawyer Profile</h1>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title"><?php echo htmlspecialchars($lawyer['name']); ?></h2>
                <p class="card-text"><strong>Type:</strong> <?php echo htmlspecialchars($lawyer['type']); ?></p>
                <p class="card-text"><strong>Years of Experience:</strong> <?php echo htmlspecialchars($lawyer['years_of_experience']); ?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($lawyer['email']); ?></p>
                <p class="card-text"><strong>Address:</strong> <?php echo htmlspecialchars($lawyer['address']); ?></p>
                <p class="card-text"><strong>Law Firm:</strong> <?php echo htmlspecialchars($lawyer['law_firm']); ?></p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <div class="mt-4">
            <a href="book_appointment.php?lawyer_id=<?php echo $lawyer['id']; ?>" class="btn btn-primary">Book Appointment</a>
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
