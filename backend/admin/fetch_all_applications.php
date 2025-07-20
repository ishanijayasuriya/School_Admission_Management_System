<?php
require_once '../db_config.php'; // database connection

header('Content-Type: application/json');

try {
    $allApplications = [];

    $tables = [
        'grade_1_applications' => 'Grade 1',
        'grade_2_11_applications' => 'Grade 2-11',
        'grade_6_applications' => 'Grade 6',
        'grade_12_applications' => 'Grade 12'
    ];

    foreach ($tables as $table => $grade) {
        $stmt = $pdo->query("SELECT id, student_name, status, '$grade' as grade FROM $table");
        $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allApplications = array_merge($allApplications, $apps);
    }

    echo json_encode(['success' => true, 'applications' => $allApplications]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
