<?php
session_start();
require_once '../db_config.php'; // Correct DB config
//require '../../Front-end/vendor/autoload.php'; // PHPMailer path
require __DIR__ . '/../../vendor/autoload.php'; // Correct path to autoload.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    try {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Generate token
            $token = bin2hex(random_bytes(16));
            $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

            // Save token in password_resets table
            $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)");
            $stmt->execute([
                'user_id' => $user['id'],
                'token' => $token,
                'expires_at' => $expiry
            ]);

            // Build reset link
            
            $resetLink = "http://localhost/GSAMS/backend/user/reset_password.php?token=$token";
            print($resetLink);

            // PHPMailer setup
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'glovemansystem@gmail.com';  //  your Gmail
            $mail->Password = 'bkye vcve rogp ubwr';       //  your Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('glovemansystem@gmail.com', 'Gloveman Admission');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Click the link below to reset your password:<br><a href='$resetLink'>$resetLink</a>";

            // Send
            if ($mail->send()) {
                echo "<script>
                    alert('Password reset link sent to your email. Please check your inbox.');
                    window.location.href = '../../Front-end/home.html';
                </script>";
                exit();
            } else {
                echo "Failed to send email. Try again later.";
            }
        } else {
            echo "<script>alert('No user found with that email.');window.history.back();</script>";
        }

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>
