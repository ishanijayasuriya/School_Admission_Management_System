<?php
require_once '../db_config.php';

try {
    // Count total applications from all 4 grade tables
    $total = 0;
    $approved = 0;
    $pending = 0;
    $rejected = 0;

    $tables = ['grade_1_applications', 'grade_2_11_applications', 'grade_6_applications', 'grade_12_applications'];
    
    foreach ($tables as $table) {
        $total += $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
        $approved += $pdo->query("SELECT COUNT(*) FROM $table WHERE status = 'approved'")->fetchColumn();
        $pending += $pdo->query("SELECT COUNT(*) FROM $table WHERE status = 'pending'")->fetchColumn();
        $rejected += $pdo->query("SELECT COUNT(*) FROM $table WHERE status = 'rejected'")->fetchColumn();
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
            'rejected' => $rejected
        ]
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
