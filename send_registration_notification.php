<?php

// Function to send registration notification email
function sendRegistrationNotification($email) {
    // Retrieve user's personal information from the database
    $sql = "SELECT first_name, last_name, contact_number, employee_ID, department_ID FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // // Retrieve admin email address from the database
    // $sql = "SELECT email FROM admin WHERE id = 1";
    // $stmt = $conn->prepare($sql);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $admin_email = $result->fetch_assoc()['email'];

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configure SMTP server
        $mail->SMTPDebug = 0; // Enable verbose debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'frenzjonathan5958@gmail.com'; // SMTP username
        $mail->Password = 'kdxr onib hnoc nldy'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable SSL encryption, 'tls' also accepted
        $mail->Port = 587; // TCP port to connect to

        // Set email sender and recipient
        $mail->setFrom('frenzjonathan5958@gmail.com', 'Registration System');
        $mail->addAddress($email, $row['first_name'] . ' ' . $row['last_name']);
        $mail->addAddress('frenzjonathan5958@gmail.com');

        // Set email subject and body
        $mail->Subject = 'Registration Notification';
        $mail->Body = 'Dear ' . $row['first_name'] . ' ' . $row['last_name'] . ',' . "\n\n";
        $mail->Body .= 'Your registration is successful. Your account details are as follows:' . "\n\n";
        $mail->Body .= 'NAME: ' . $row['first_name'] . ' ' . $row['last_name'] . "\n";
        $mail->Body .= 'EMAIL: ' . $email . "\n";
        $mail->Body .= 'CONTACT NUMBER: ' . $row['contact_number'] . "\n";
        $mail->Body .= 'EMPLOYEE ID: ' . $row['employee_ID'] . "\n";
        $mail->Body .= 'DEPARTMENT: ' . $row['department_ID'] . "\n\n";
        $mail->Body .= 'Thank you for registering with us.' . "\n\n";
        $mail->Body .= 'Best regards,' . "\n";
        $mail->Body .= 'Registration System';

        // Send email
        if ($mail->send()) {
            return true; // Email sent successfully
            header('Location: cal-sample.php');
        } else {
            return false; // Error in sending email
        }
    } catch (Exception $e) {
        return false; // Exception occurred
    }
}

?>