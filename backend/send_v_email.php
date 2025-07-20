<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Correct path to autoload.php

// ✅ 1. Registration Email
function send_registration_email($to, $system_id, $username, $role) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'glovemansystem@gmail.com';
        $mail->Password   = 'bkye vcve rogp ubwr'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('glovemansystem@gmail.com', 'School Admission System');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = 'Registration Successful - Government School Admission System';
        $mail->Body    = "
            <h3>Registration Successful!</h3>
            <p><strong>User ID:</strong> {$system_id}</p>
            <p><strong>Username:</strong> {$username}</p>
            <p><strong>Role:</strong> {$role}</p>
            <p>You can now login using your credentials.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// 2. Application Status Email
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'glovemansystem@gmail.com';
        $mail->Password   = 'bkye vcve rogp ubwr'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('glovemansystem@gmail.com', 'School Admission System');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
