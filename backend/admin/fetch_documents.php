<?php
require_once '../db_config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM documents ORDER BY upload_date DESC");
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'documents' => $documents]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
