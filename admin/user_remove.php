<?php
    require __DIR__ . '/../database/con_db.php';

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if (isset($_POST['user_id'])) {
        $userID = $_POST['user_id'];

        $sql = "UPDATE user SET user_status = 'Rejected' WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);

        if ($stmt->execute()) {
            // Send approval notification email
            sendEmailDeclinedNotification($userID, 'Rejected');
            echo 'success';
        } else {
            echo 'error';
        }

        $stmt->close();
    // $conn->close();
    } else {
        echo 'error';
    }


    // Function to send email notification
    function sendEmailDeclinedNotification($userID, $status) {
        global $conn;

        // Fetch event details
        $sql = "SELECT user.*, department.department_name
                FROM user
                INNER JOIN department ON user.department_ID = department.department_ID
                WHERE user_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Create and send email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'frenzjonathan5958@gmail.com';
            $mail->Password = 'kdxr onib hnoc nldy';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('frenzjonathan5958@gmail.com', 'FRENZ JONATHAN V. ALULOD');
            $mail->addAddress($user['email']); // User's email address
            $mail->addReplyTo('frenzjonathan5958@gmail.com', 'FRENZ JONATHAN V. ALULOD');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Account Registration Status Notification';
            $mail->Body = 'Dear ' . $user['first_name'] . ' ' . $user['last_name'] . ',' . "<br><br>"; 
            $mail->Body .= 'Your account registration has been ' . $status . '.' . "<br><br>";
            $mail->Body .= 'Registration Details:' . "<br>";
            $mail->Body .= 'NAME: ' . $user['first_name'] . ' ' . $user['last_name'] . "<br>";
            $mail->Body .= 'EMAIL: ' . $user['email'] . "<br>";
            $mail->Body .= 'CONTACT NUMBER: ' . $user['contact_number'] . "<br>";
            $mail->Body .= 'EMPLOYEE ID: ' . $user['employee_ID'] . "<br>";
            $mail->Body .= 'DEPARTMENT: ' . $user['department_name'] . "<br><br>";
            $mail->Body .= 'Thank you.' . "<br><br>";
            $mail->Body .= 'Best regards,' . "<br>";
            $mail->Body .= 'Event Management System';
            
            $mail->send();
            echo 'Email sent successfully';
            //console.log('Email sent successfully');
        
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
           // console.log('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');
        
        }
    }
?>
