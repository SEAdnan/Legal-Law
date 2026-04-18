<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>LegalLaw</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">LegalLaw</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="registerDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Register
                    </a>
                    <div class="dropdown-menu" aria-labelledby="registerDropdown">
                        <a class="dropdown-item" href="register_lawyer.php">Register as Lawyer</a>
                        <a class="dropdown-item" href="register_client.php">Register as Client</a>
                        <a class="dropdown-item" href="register_intern.php">Register as Intern</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Login
                    </a>
                    <div class="dropdown-menu" aria-labelledby="loginDropdown">
                        <a class="dropdown-item" href="client_login.php">Client Login</a>
                        <a class="dropdown-item" href="lawyer_login.php">Lawyer Login</a>
                        <a class="dropdown-item" href="intern_login.php">Intern Login</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_login.php">Admin</a> 
                <li class="nav-item">
                    <a class="nav-link" href="faq.php">FAQ</a>
                <li class="nav-item">
                    <a class="nav-link" href="about_blog.php">About/Blog</a>    
                <li class="nav-item">
                    <a class="nav-link" href="filter_lawyers.php">Find a Lawyer</a>
                <li class="nav-item">
                    <a class="nav-link" href="contact_us.php">Contact Us</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Welcome to LegalLaw</h1>
        <p>Your one-stop solution for legal assistance. Whether you are looking for a lawyer, need legal advice, or want to understand the law better, we are here to help!</p>
        
        <h2>How It Works</h2>
        <ol>
            <li>Register as a Lawyer, Client, or Intern.</li>
            <li>Find and connect with lawyers based on your needs.</li>
            <li>Get legal advice and representation.</li>
            <li>Rate your experience and help others find the right lawyer.</li>
        </ol>

        <h2>Get Started</h2>
        <p>Choose an option from the navigation bar above to begin.</p>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> LegalLaw. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
