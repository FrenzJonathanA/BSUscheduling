<?php

// Include database connection
include 'database/con_db.php';

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send verification code
function sendVerificationCode($email, $verification_code) {
    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configure SMTP server
        $mail->SMTPDebug = 0; // Enable verbose debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'bsuevent.scheduling@gmail.com'; // SMTP username
        $mail->Password = 'dlko mvgy wiul fshr'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable SSL encryption, 'tls' also accepted
        $mail->Port = 587; // TCP port to connect to

        // Set email sender and recipient
        $mail->setFrom('bsuevent.scheduling@gmail.com', 'Registration System');
        $mail->addAddress($email);

        // Set email subject and body
        $mail->Subject = 'Verification Code for Registration';
        $mail->Body = 'Your verification code is: '. $verification_code;

        // Send email
        if ($mail->send()) {
            return true; // Email sent successfully
        } else {
            return false; // Error in sending email
        }
    } catch (Exception $e) {
        return false; // Exception occurred
    }
}

?>