<?php
session_start();
require 'src/config/database.php';

// User login
function login($email, $password) {
    global $pdo;

    //if laywer
    $stmt = $pdo->prepare("SELECT * FROM Lawyers WHERE email = ?");
    $stmt->execute([$email]);
    $lawyer = $stmt->fetch();

    if ($lawyer && password_verify($password, $lawyer['password'])) {
        $_SESSION['user_id'] = $lawyer['Lawyer_id'];
        $_SESSION['user_type'] = 'lawyer';
        return true;
    }

    //if client
    $stmt = $pdo->prepare("SELECT * FROM Clients WHERE email = ?");
    $stmt->execute([$email]);
    $client = $stmt->fetch();

    if ($client && password_verify($password, $client['password'])) {
        $_SESSION['user_id'] = $client['Client_id'];
        $_SESSION['user_type'] = 'client';
        return true;
    }

    // if intern
    $stmt = $pdo->prepare("SELECT * FROM Interns WHERE email = ?");
    $stmt->execute([$email]);
    $intern = $stmt->fetch();

    if ($intern && password_verify($password, $intern['password'])) {
        $_SESSION['user_id'] = $intern['Intern_id'];
        $_SESSION['user_type'] = 'intern';
        return true;
    }

    return false;
}

// logout
function logout() {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// user authentication
function isAuthenticated() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_type']);
}

// type check
function getUserType() {
    return isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;
}

// user id
function getUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}
