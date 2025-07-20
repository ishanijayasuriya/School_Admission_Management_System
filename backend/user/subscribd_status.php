<?php
require_once '../../db_config.php';
require_once '../../ssend_email.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if user exists in application tables (example: grade_1_applications)
    $stmt = $pdo->prepare("
        SELECT full_name, status FROM grade_1_applications 
        WHERE email = :email 
        ORDER BY created_at DESC LIMIT 1
    ");
    $stmt->execute(['email' => $email]);
    $application = $stmt->fetch();

    if ($application) {
        $name = $application['full_name'];
        $status = $application['status'];

        // Compose email
        $subject = "Your Application Status - Gloveman School Admission";
        $message = "Dear $name,<br><br>";
        $message .= "Your application status is currently: <strong>$status</strong>.<br><br>";
        $message .= "We will update you when your application is reviewed.<br><br>";
        $message .= "Thank you for using the Gloveman School Admission System.";

        // Send email
        if (sendEmail($email, $subject, $message)) {
            echo json_encode(['success' => true, 'message' => 'Email sent successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send email.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No application found for this email.']);
    }
}
?>
