<?php
session_start();
require_once '../db_config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

// Optional: Validate data

try {
    // Check if profile exists
    $stmt = $pdo->prepare("SELECT id FROM user_profiles WHERE user_id = ?");
    $stmt->execute([$user_id]);

    if ($stmt->fetch()) {
        // Update
        $sql = "UPDATE user_profiles SET first_name = ?, last_name = ?, email = ?, phone = ?, date_of_birth = ?, gender = ?, address = ?, photo = ? WHERE user_id = ?";
        $pdo->prepare($sql)->execute([
            $data['firstName'], $data['lastName'], $data['email'], $data['phone'],
            $data['dateOfBirth'], $data['gender'], $data['address'], $data['photo'], $user_id
        ]);
    } else {
        // Insert
        $sql = "INSERT INTO user_profiles (user_id, first_name, last_name, email, phone, date_of_birth, gender, address, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([
            $user_id, $data['firstName'], $data['lastName'], $data['email'], $data['phone'],
            $data['dateOfBirth'], $data['gender'], $data['address'], $data['photo']
        ]);
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
