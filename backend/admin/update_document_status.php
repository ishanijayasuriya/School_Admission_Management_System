<?php
require_once 'db_config.php';
require_once 'send_email.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = $_POST['id'];
    $status = $_POST['status'];
    $email  = $_POST['email'];
    $name   = $_POST['full_name'];
    $notes  = $_POST['notes'];
    $table  = $_POST['table'];

    // Update the application's status
    $stmt = $pdo->prepare("UPDATE $table SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $status, 'id' => $id]);

    // Send email if email is present
    if (!empty($email)) {
        $subject = "Your Application Has Been $status";
        $message = "Dear $name,<br><br>Your application (ID: $id) has been <b>$status</b>.<br>";
        if (!empty($notes)) {
            $message .= "<strong>Admin Note:</strong> $notes<br>";
        }
        $message .= "<br>Thank you for using the Gloveman School Admission System.";

        sendEmail($email, $subject, $message);
    }

    // Redirect back to the correct grade view
    $grade_param = '';
    switch ($table) {
        case 'grade_1_applications': $grade_param = '1'; break;
        case 'grade_6_applications': $grade_param = '6'; break;
        case 'grade_12_applications': $grade_param = '12'; break;
        case 'grade_2_11_applications': $grade_param = '2_11'; break;
    }

    header("Location: ../Front-end/admin/applications_view.php?grade=$grade_param");
    exit();
}
?>
