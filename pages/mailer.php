<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require '../vendor/autoload.php'; // If using Composer
// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php'; // Uncomment if not using Composer

function sendMail($to, $subject, $body, $fromEmail = 'partpurja123@gmail.com', $fromName = 'Part Purja') {
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server (change for different providers)
        $mail->SMTPAuth = true;
        $mail->Username = 'partpurja123@gmail.com'; // Your email
        $mail->Password = 'ypdv prah oatg hhuw'; // Use an app password if using Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS encryption
        $mail->Port = 587;

        // Sender & Recipient
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to); // Recipient email

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body); // Fallback for non-HTML clients

        // Send Email
        if ($mail->send()) {
            return "Email sent successfully to $to";
        } else {
            return "Mailer Error: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        return "Mailer Exception: " . $mail->ErrorInfo;
    }
}

// Example usage
// echo sendMail('recipient@example.com', 'Test Subject', 'This is a test email.');
?>
