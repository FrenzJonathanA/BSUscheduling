<?php
require 'database/con_db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        $resetCode = generateResetCode(); 

        $expiration_time = time() + (60 * 5); // reset code expires in 5 minutes
        $stmt = $conn->prepare("UPDATE user SET reset_code = ?, reset_expiration = ? WHERE email = ?");
        $stmt->bind_param("sis", $resetCode, $expiration_time, $email);
        $stmt->execute();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'frenzjonathan5958@gmail.com';
            $mail->Password = 'kdxr onib hnoc nldy';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('frenzjonathan5958@gmail.com', 'BSU Scheduling');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $mail->Body = 'Your verification code is: ' . $resetCode;

            $mail->send();
            header("Location: verify_reset_code.php?email=" . $email);
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found.";
    }
}

function generateResetCode() {
    return rand(100000, 999999);
}
?>