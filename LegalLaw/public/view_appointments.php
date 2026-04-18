<?php
require '../src/config/database.php';

$appointments = [];
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientEmail = trim($_POST['email']);

    if (empty($clientEmail)) {
        $error = "Please enter your email address.";
    } else {
        // Fetch appointments for the client
        $stmt = $pdo->prepare("SELECT a.id, a.payment_amount, a.appointment_date, l.name AS lawyer_name, l.type AS lawyer_type 
                               FROM Appointments a 
                               JOIN Lawyers l ON a.lawyer_id = l.id 
                               WHERE a.client_email = ? 
                               ORDER BY a.appointment_date DESC");
        $stmt->execute([$clientEmail]);
        $appointments = $stmt->fetchAll();

        if (empty($appointments)) {
            $error = "No appointments found for this email address.";
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
    <title>View Appointments</title>
    <style>
        .appointment-card {
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">View Appointments</h1>
        <div class="card appointment-card">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Enter Your Email to View Appointments</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">View Appointments</button>
                </form>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($appointments)): ?>
            <div class="mt-4">
                <h3>Appointments:</h3>
                <?php foreach ($appointments as $appointment): ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Lawyer: <?php echo htmlspecialchars($appointment['lawyer_name']); ?></h5>
                            <p class="card-text"><strong>Type:</strong> <?php echo htmlspecialchars($appointment['lawyer_type']); ?></p>
                            <p class="card-text"><strong>Payment Amount:</strong> <?php echo number_format($appointment['payment_amount'], 2); ?> BDT</p>
                            <p class="card-text"><strong>Appointment Date:</strong> <?php echo date('F j, Y, g:i A', strtotime($appointment['appointment_date'])); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> Legal Help. All rights reserved.</p>
    </footer>
</body>
</html>
