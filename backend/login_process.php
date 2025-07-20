<?php
session_start();
require 'db_config.php'; // Database connection

// Validate input
if (!isset($_POST['role'], $_POST['username'], $_POST['password'])) {
    die('Missing required fields.');
}

$role = $_POST['role'];
$username = trim($_POST['username']);
$password = $_POST['password'];

// Choose the correct table
$table = $role === 'admin' ? 'admins' : 'users';

// Prepare query
$stmt = $pdo->prepare("SELECT * FROM $table WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // Store in session
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirect to dashboard
    if ($role === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit();
} else {
    echo "Invalid login. Please check your username or password.";
}
?>
