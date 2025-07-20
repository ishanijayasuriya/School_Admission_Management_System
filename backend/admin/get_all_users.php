<?php
require_once '../db_config.php';

$stmt = $pdo->query("SELECT * FROM user_profiles");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
?>
