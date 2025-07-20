<?php
require_once '../db_config.php';

header('Content-Type: application/json');

// Read the JSON data from fetch
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($data['id'], $data['grade'], $data['status'])) {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
    exit;
}

$id = $data['id'];
$table = $data['grade'];
$status = $data['status'];

// Sanitize status
if (!in_array($status, ['pending', 'approved', 'rejected'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid status value']);
    exit;
}

try {
    // Use prepared statement to prevent SQL injection
    $stmt = $pdo->prepare("UPDATE `$table` SET status = :status WHERE id = :id");
    $stmt->execute([
        'status' => $status,
        'id' => $id
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>