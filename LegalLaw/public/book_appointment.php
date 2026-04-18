<?php
require '../src/config/database.php';

if (!isset($_GET['lawyer_id'])) {
    echo "<div class='alert alert-danger'>No lawyer specified.</div>";
    exit();
}

$lawyerId = $_GET['lawyer_id'];

// Fetch lawyer details
$stmt = $pdo->prepare("SELECT * FROM Lawyers WHERE id = ?");
$stmt->execute([$lawyerId]);
$lawyer = $stmt->fetch();

if (!$lawyer) {
    echo "<div class='alert alert-danger'>Lawyer not found.</div>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clientEmail = $_POST['email'];
    $clientPassword = $_POST['password'];
    $paymentAmount = $_POST['payment_amount'];
    $appointmentDate = $_POST['appointment_date'];
    $appointmentTime = $_POST['appointment_time'];
    $pin = $_POST['pin'];
    $correctPIN = "6363";

    // Validate inputs
    if ($pin !== $correctPIN) {
        $error = "Invalid PIN.";
    } elseif ($paymentAmount <= 0) {
        $error = "Invalid payment amount.";
    } elseif (empty($appointmentDate) || empty($appointmentTime)) {
        $error = "Please select a valid date and time for your appointment.";
    } else {
        // Combine date and time
        $appointmentDateTime = $appointmentDate . ' ' . $appointmentTime;

        // Insert appointment into the database
        $stmt = $pdo->prepare("INSERT INTO Appointments (lawyer_id, client_email, payment_amount, appointment_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$lawyerId, $clientEmail, $paymentAmount, $appointmentDateTime]);

        // Redirect to confirmation page
        header("Location: appointment_confirmation.php");
        exit();
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
    <title>Book Appointment</title>
    <style>
        .card { margin: 20px auto; max-width: 600px; }
        .payment-section { display: none; }
    </style>
    <script>
        function showPaymentSection() {
            document.querySelector('.payment-section').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1>Book Appointment</h1>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title"><?php echo htmlspecialchars($lawyer['name']); ?></h2>
                <p class="card-text"><strong>Type:</strong> <?php echo htmlspecialchars($lawyer['type']); ?></p>
                <p class="card-text"><strong>Years of Experience:</strong> <?php echo htmlspecialchars($lawyer['years_of_experience']); ?></p>
                <p class="card-text"><strong>Law Firm:</strong> <?php echo htmlspecialchars($lawyer['law_firm']); ?></p>
                <button onclick="showPaymentSection()" class="btn btn-primary">Proceed to Payment</button>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="payment-section card">
            <div class="card-body">
                <h3>Payment Gateway</h3>
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Your Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_amount">Payment Amount (BDT)</label>
                        <input type="number" id="payment_amount" name="payment_amount" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="appointment_date">Appointment Date</label>
                        <input type="date" id="appointment_date" name="appointment_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="appointment_time">Appointment Time</label>
                        <input type="time" id="appointment_time" name="appointment_time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pin">Enter PIN</label>
                        <input type="password" id="pin" name="pin" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Complete Payment</button>
                </form>
            </div>
        </div>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> LegalLaw. All rights reserved.</p>
    </footer>
</body>
</html>
