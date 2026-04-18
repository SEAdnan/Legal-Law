<?php
require '../src/config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $specialization = trim($_POST['specialization']);
    $years_of_experience = (int)$_POST['years_of_experience'];
    $law_firm = trim($_POST['law_firm']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $degrees = trim($_POST['degrees']);
    $type = $_POST['type'];

    // Basic validation
    if (
        empty($name) || empty($email) || empty($password) || empty($specialization) || 
        empty($years_of_experience) || empty($phone_number) || empty($address) || 
        empty($degrees) || empty($type)
    ) {
        echo "All fields are required!";
        exit;
    }

    try {
        // Check for existing email
        $checkEmail = $pdo->prepare("SELECT email FROM Lawyers WHERE email = ?");
        $checkEmail->execute([$email]);

        if ($checkEmail->rowCount() > 0) {
            echo "Email already registered!";
        } else {
            // Insert the new lawyer record
            $stmt = $pdo->prepare("
                INSERT INTO Lawyers 
                (name, email, password, specialization, years_of_experience, law_firm, phone_number, address, degrees, type) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $name, $email, $password, $specialization, $years_of_experience, 
                $law_firm, $phone_number, $address, $degrees, $type
            ]);

            echo "Registration successful!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- Registration Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Register as Lawyer</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Register as Lawyer</h1>
        <form method="POST" action="register_lawyer.php">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="specialization">Specialization</label>
                <input type="text" class="form-control" id="specialization" name="specialization" required>
            </div>
            <div class="form-group">
                <label for="years_of_experience">Years of Experience</label>
                <input type="number" class="form-control" id="years_of_experience" name="years_of_experience" min="0" required>
            </div>
            <div class="form-group">
                <label for="law_firm">Law Firm</label>
                <input type="text" class="form-control" id="law_firm" name="law_firm">
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="degrees">Degrees</label>
                <input type="text" class="form-control" id="degrees" name="degrees" required>
            </div>
            <div class="form-group">
                <label for="type">Type of Lawyer</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="Advocate">Advocate</option>
                    <option value="Barrister">Barrister</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <p class="mt-3">Already have an account? <a href="lawyer_login.php">Login here</a>.</p>
    </div>
</body>
</html>
