<?php
session_start();
require '../src/config/database.php';

// Check if lawyer is logged in
if (!isset($_SESSION['lawyer_logged_in']) || !$_SESSION['lawyer_logged_in']) {
    header("Location: lawyer_login.php");
    exit();
}

$lawyerId = $_SESSION['id'];
$appointments = [];

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM Appointments WHERE id = ? AND lawyer_id = ?");
    $stmt->execute([$deleteId, $lawyerId]);
    $message = $stmt->rowCount() ? "Appointment deleted successfully." : "Failed to delete or unauthorized.";
}

// Fetch appointments for logged-in lawyer
$stmt = $pdo->prepare("SELECT id, client_email, payment_amount, appointment_date FROM Appointments WHERE lawyer_id = ? ORDER BY appointment_date DESC");
$stmt->execute([$lawyerId]);
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Your Appointments</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Your Appointments</h1>

        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if (!empty($appointments)): ?>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Client Email</th>
                        <th>Payment Amount</th>
                        <th>Appointment Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['client_email']); ?></td>
                            <td><?php echo number_format($appointment['payment_amount'], 2); ?> BDT</td>
                            <td><?php echo date('F j, Y, g:i A', strtotime($appointment['appointment_date'])); ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $appointment['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No appointments found.</p>
        <?php endif; ?>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> Legal Help. All rights reserved.</p>
    </footer>
</body>
</html>
