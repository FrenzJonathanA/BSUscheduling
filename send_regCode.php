<?php
    require 'register.php'; 

    $result = sendVerificationEmail($email, $verificationCode);

    if ($result) {
        echo "Verification code sent successfully.";
    } else {
        echo "Failed to send verification code. Please try again later.";
    }
?>