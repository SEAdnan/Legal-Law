<?php
require '../src/config/database.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];

    $tableMap = [
        'lawyers' => 'Lawyers',
        'clients' => 'Clients',
        'interns' => 'Interns',
    ];

    if (isset($tableMap[$type])) {
        $stmt = $pdo->prepare("DELETE FROM " . $tableMap[$type] . " WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: view_users.php?type=$type");
        exit();
    } else {
        echo "Invalid user type!";
    }
}
?>
