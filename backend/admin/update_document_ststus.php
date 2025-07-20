<?php
require_once '../db_config.php';
require_once '../send_email.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = $_POST['id'];
    $status = $_POST['status'];
    $email  = $_POST['email'];
    $name   = $_POST['full_name'];
    $notes  = $_POST['notes'];

    // Update status in DB
    $stmt = $pdo->prepare("UPDATE grade_1_applications SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $status, 'id' => $id]);

    // Email content
    $subject = "Your Application has been $status";
    $message = "Dear $name,<br><br>Your application (ID: $id) has been <b>$status</b>.<br>";
    if (!empty($notes)) {
        $message .= "<strong>Admin Note:</strong> $notes<br>";
    }
    $message .= "<br>Thank you for using the Gloveman School Admission System.";

    // Send email
    sendEmail($email, $subject, $message);

    // Redirect to application view
    header("Location: ../../Front-end/admin/application_view.php");
    exit();
}
?>
