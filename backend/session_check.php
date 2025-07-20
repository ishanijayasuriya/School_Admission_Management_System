<?php
session_start();

// If user is not logged in at all
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../../Front-end/user/login.html");
    exit();
}

// If user is logged in but trying to access wrong area
$currentFile = basename($_SERVER['PHP_SELF']);

// Redirect users to correct login if role doesn't match the section
if (strpos($currentFile, 'admin') !== false && $_SESSION['role'] !== 'school_admin') {
    header("Location: ../../Front-end/admin/login.html");
    exit();
}

if (strpos($currentFile, 'user') !== false && $_SESSION['role'] === 'school_admin') {
    header("Location: ../../Front-end/admin/dashboard.html");
    exit();
}
?>
