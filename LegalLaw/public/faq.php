<?php
require '../src/config/database.php'; // Ensure this path is correct for your setup

// Initialize search variables
$search_section = '';
$results = [];
$laws = [
    "Car Law" => "Car-related laws and regulations.",
    "Uncertain Arrest Law" => "Laws regarding uncertain arrests.",
    "Harresment Law" => "Laws protecting against harassment.",
    "Human Rights Law" => "Laws ensuring human rights.",
    "Customer Right Law" => "Laws protecting customer rights."
];
$matched_law = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_section = $_POST['section'];

    // Query the database
    $stmt = $pdo->prepare("SELECT * FROM basic_law WHERE section LIKE ? ORDER BY section ASC");
    $stmt->execute(["%$search_section%"]);
    $results = $stmt->fetchAll();

    // Match search term with predefined laws
    foreach ($laws as $law => $description) {
        if (stripos($law, $search_section) !== false || stripos($description, $search_section) !== false) {
            $matched_law[$law] = $description;
        }
    }
}

// Check if the user is visiting the help page
if (isset($_GET['page']) && $_GET['page'] === 'help') {
    $message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : "We are here to help you";
    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: black;
            color: white;
        }
        h1 {
            color: #ab8e40;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">$message</h1>
        <p class="text-center mt-4">Feel free to explore the resources or reach out for assistance.</p>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Back to Search</a>
        </div>
    </div>
</body>
</html>
HTML;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Search Laws</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: black;
            color: white;
        }
        h1, h2 {
            color: #ab8e40;
        }
        .form-control {
            background-color: #333;
            color: white;
            border: 1px solid #555;
        }
        .form-control::placeholder {
            color: #aaa;
        }
        .btn-primary {
            background-color: #ab8e40;
            border-color: #ab8e40;
        }
        .btn-primary:hover {
            background-color: #916e30;
            border-color: #916e30;
        }
        .list-group-item {
            background-color: #222;
            color: white;
            border: 1px solid #555;
        }
        a {
            color: #ab8e40;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        footer {
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Search Laws by Section</h1>
        
        <!-- Search Form -->
        <form method="POST" action="" class="mt-4">
            <div class="form-group">
                <label for="section">Enter Section</label>
                <input type="text" name="section" id="section" class="form-control" placeholder="e.g., 123" value="<?php echo htmlspecialchars($search_section); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Quick Links -->
        <div class="mt-4">
            <h3>Quick Links</h3>
            <ul class="list-group">
                <?php if (!empty($matched_law)): ?>
                    <?php foreach ($matched_law as $law => $description): ?>
                        <li class="list-group-item">
                            <a href="?page=help&message=We%20will%20help%20you"><?php echo htmlspecialchars($law); ?></a><br>
                            <small><?php echo htmlspecialchars($description); ?></small>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">No matching laws found. Please try a different search term.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Results Section -->
        <div class="mt-5">
            <h2 class="text-center">Results</h2>
            <?php if (!empty($results)): ?>
                <ul class="list-group">
                    <?php foreach ($results as $law): ?>
                        <li class="list-group-item">
                            <strong>Section:</strong> <?php echo htmlspecialchars($law['section']); ?><br>
                            <strong>Description:</strong> <?php echo htmlspecialchars($law['description']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-center">Here is you searched LAW.</p>
            <?php endif; ?>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
