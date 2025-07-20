<?php
require_once '../db_config.php'; // database connection
require '../../Front-end/vendor/autoload.php'; // PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate token
        $token = bin2hex(random_bytes(16));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Save token to database
        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (:user_id, :token, :expires)");
        $stmt->execute([
            'user_id' => $user['id'],
            'token' => $token,
            'expires' => $expires
        ]);

        // Send email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'glovemansystem@gmail.com';
            $mail->Password = 'bkye vcve rogp ubwr';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('glovemansystem@gmail.com', 'Gloveman System');
            $mail->addAddress($email);

            $mail->Subject = 'Password Reset Request';
            $resetLink = 'http://localhost/GSAMS/backend/user/reset_password.php?token=' . $token;
            $mail->Body = "Click the link below to reset your password:\n\n$resetLink";

            $mail->send();
            echo "Reset link sent to your email.";
        } catch (Exception $e) {
            echo "Mail Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found in our system.";
    }
}
?>
