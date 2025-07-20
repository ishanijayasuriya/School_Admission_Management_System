<?php
$host = 'localhost';     // or 127.0.0.1
$dbname = 'school_admission_db';
$username = 'root';      // default XAMPP username
$password = '';          // default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>

