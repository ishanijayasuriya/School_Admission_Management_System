 <?php
session_start();
require 'db_config.php'; // database connection



if (!isset($_POST['role'], $_POST['username'], $_POST['password'])) {
    die('Missing required fields.');
}


$role = $_POST['role']; // 'admin' or 'user'
$username = $_POST['username'];
$password = $_POST['password'];

if ($role === 'admin') {
    $query = "SELECT * FROM admins WHERE username = ?";
} else {
    $query = "SELECT * FROM users WHERE username = ?";
}

$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
$user = $stmt->fetch();
print_r($user);
if ($user && ($password== $user['password'])) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $role;

    if ($role === 'admin') {
        header("Location: ../Front-end/admin/dashboard.html");
    } else {
        header("Location: ../Front-end/user/dashboard.html");
    }
    exit();
} else {
    echo "Invalid login.";
}
?>