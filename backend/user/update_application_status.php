<?php
require '../../db_config.php';
require '../../vendor/autoload.php'; // PHPMailer path

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $applicationId = $_POST['application_id'];
    $newStatus = $_POST['status'];

    // 1. Update application status in the DB
    $stmt = $pdo->prepare("UPDATE applications SET status = :status WHERE id = :id");
    $stmt->execute([
        'status' => $newStatus,
        'id' => $applicationId
    ]);

    // 2. Get user email related to the application
    $stmt = $pdo->prepare("SELECT u.email, u.full_name FROM users u JOIN applications a ON u.id = a.user_id WHERE a.id = :id");
    $stmt->execute(['id' => $applicationId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $email = $user['email'];
        $fullName = $user['full_name'];

        // 3. Send email
        $mail = new PHPMailer(true);
        try {
            //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Replace with your mail server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'glovemansystem@gmail.com'; // Replace with your Gmail
        $mail->Password   = 'bkye vcve rogp ubwr';    // Use App Password, not Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

            //Recipients
            $mail->setFrom('your@email.com', 'Gloveman Admissions');
            $mail->addAddress($email, $fullName);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Application Status Has Been Updated';
            $mail->Body    = "Dear $fullName,<br><br>Your school admission application has been <strong>$newStatus</strong>.<br><br>Thank you for using our system.<br><br>Gloveman School Admission System";

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Status updated and email sent.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
    }
}
?>
