
<?php
session_start();
require '../src/config/database.php';


$name = '';
$email = '';
$password = '';
$years_of_experience = '';
$law_firm = '';
$phone_number = '';
$university = '';
$address = '';
$error = '';
$success = '';

//form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $years_of_experience = $_POST['years_of_experience'];
    $law_firm = $_POST['law_firm'];
    $phone_number = $_POST['phone_number'];
    $university = $_POST['university'];
    $address = $_POST['address'];

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($years_of_experience) || empty($law_firm) || empty($phone_number) || empty($university) || empty($address)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM Interns WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = "Email is already registered.";
        } else {
            // Insert new intern into the database
            $stmt = $pdo->prepare("INSERT INTO Interns (name, email, password, years_of_experience, law_firm, phone_number, university, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $password, $years_of_experience, $law_firm, $phone_number, $university, $address])) {
                $success = "Registration successful! You can now log in.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
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
    <title>Register as Intern</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Register as Intern</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" action="register_intern.php">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="years_of_experience">Years of Experience</label>
                <input type="number" class="form-control" id="years_of_experience" name="years_of_experience" value="<?php echo htmlspecialchars($years_of_experience); ?>" required>
            </div>
            <div class="form-group">
                <label for="law_firm">Law Firm</label>
                <input type="text" class="form-control" id="law_firm" name="law_firm" value="<?php echo htmlspecialchars($law_firm); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required>
            </div>
            <div class="form-group">
                <label for="university">University</label>
                <input type="text" class="form-control" id="university" name="university" value="<?php echo htmlspecialchars($university); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <p class="mt-3">Already have an account? <a href="intern_login.php">Login here</a>.</p>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> LegalLaw. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
