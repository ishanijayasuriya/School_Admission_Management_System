<?php
require_once '../db_config.php';

try {
    $stmt = $pdo->query("SELECT * FROM user_profiles ORDER BY created_at DESC");
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($profiles);
} catch (PDOException $e) {
    echo json_encode([]);
}
?>
