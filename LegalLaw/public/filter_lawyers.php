<?php
session_start();
require '../src/config/database.php';

$lawyers = [];
$type = '';
$min_experience = 0;
$sort_by = 'rating';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $min_experience = $_POST['min_experience'];
    $sort_by = $_POST['sort_by'];
}

$query = "SELECT * FROM Lawyers WHERE 1=1";
$params = [];

// Filter by type
if (!empty($type)) {
    $query .= " AND type = ?";
    $params[] = $type;
}

// Filter by minimum years of experience
if ($min_experience > 0) {
    $query .= " AND years_of_experience >= ?";
    $params[] = $min_experience;
}

// Sort by rating or years of experience
if ($sort_by === 'experience') {
    $query .= " ORDER BY years_of_experience DESC";
} else {
    $query .= " ORDER BY (SELECT AVG(rating) FROM Ratings WHERE lawyer_id = Lawyers.id) DESC";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$lawyers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Find a Lawyer</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Find a Lawyer</h1>
        <form method="POST" action="filter_lawyers.php">
            <div class="form-group">
                <label for="type">Type of Lawyer</label>
                <select class="form-control" id="type" name="type">
                    <option value="">All</option>
                    <option value="Advocate" <?php echo ($type === 'Advocate') ? 'selected' : ''; ?>>Advocate</option>
                    <option value="Barrister" <?php echo ($type === 'Barrister') ? 'selected' : ''; ?>>Barrister</option>
                </select>
            </div>
            <div class="form-group">
                <label for="min_experience">Minimum Years of Experience</label>
                <input type="number" class="form-control" id="min_experience" name="min_experience" 
                    value="<?php echo htmlspecialchars($min_experience); ?>" min="0">
            </div>
            <div class="form-group">
                <label for="sort_by">Sort By</label>
                <select class="form-control" id="sort_by" name="sort_by">
                    <option value="rating" <?php echo ($sort_by === 'rating') ? 'selected' : ''; ?>>Rating</option>
                    <option value="experience" <?php echo ($sort_by === 'experience') ? 'selected' : ''; ?>>
                        Years of Experience
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <h2 class="mt-4">Lawyers List</h2>
        <div class="list-group">
            <?php if ($lawyers): ?>
                <?php foreach ($lawyers as $lawyer): ?>
                    <div class="list-group-item">
                        <h5><?php echo htmlspecialchars($lawyer['name']); ?></h5>
                        <p>Type: <?php echo htmlspecialchars($lawyer['type']); ?></p>
                        <p>Years of Experience: <?php echo htmlspecialchars($lawyer['years_of_experience']); ?></p>
                        <p>Average Rating: 
                            <?php 
                            // Calculate average rating
                            $rating_stmt = $pdo->prepare(
                                "SELECT AVG(rating) as avg_rating FROM Ratings WHERE lawyer_id = ?"
                            );
                            $rating_stmt->execute([$lawyer['id']]);
                            $rating = $rating_stmt->fetchColumn();
                            echo $rating ? htmlspecialchars(number_format($rating, 2)) : 'No ratings yet';
                            ?>
                        </p>
                        <a href="lawyer_profile.php?id=<?php echo $lawyer['id']; ?>" 
                            class="btn btn-info">View Profile</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning">No lawyers found matching your criteria.</div>
            <?php endif; ?>
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
