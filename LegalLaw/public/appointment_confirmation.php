<?php
require '../src/config/database.php';

// Fetch the latest appointment
$stmt = $pdo->prepare("SELECT a.id, a.client_email, a.payment_amount, a.appointment_date, l.name AS lawyer_name 
                       FROM Appointments a 
                       JOIN Lawyers l ON a.lawyer_id = l.id 
                       ORDER BY a.id DESC 
                       LIMIT 1");
$stmt->execute();
$appointment = $stmt->fetch();

if (!$appointment) {
    echo "<div class='alert alert-danger'>No appointment found.</div>";
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
    <title>Appointment Confirmation</title>
    <style>
        .confirmation-card {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .confirmation-card h2 {
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="confirmation-card card">
            <div class="card-body text-center">
                <h2>Appointment Confirmed!</h2>
                <p>Your appointment has been successfully booked. Here are the details:</p>
                <hr>
                <p><strong>Lawyer:</strong> <?php echo htmlspecialchars($appointment['lawyer_name']); ?></p>
                <p><strong>Your Email:</strong> <?php echo htmlspecialchars($appointment['client_email']); ?></p>
                <p><strong>Payment Amount:</strong> <?php echo number_format($appointment['payment_amount'], 2); ?> BDT</p>
                <p><strong>Appointment Date:</strong> <?php echo date('F j, Y, g:i A', strtotime($appointment['appointment_date'])); ?></p>
                <hr>
                <a href="client_dashboard.php" class="btn btn-primary">Go to Dashboard</a>
            </div>
        </div>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> LegalLaw. All rights reserved.</p>
    </footer>
</body>
</html>
