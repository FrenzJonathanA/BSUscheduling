<?php
    require __DIR__ . '/../database/con_db.php';


    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if (isset($_POST['event_id'])) {
        $eventID = $_POST['event_id'];

        $sql = "UPDATE event_booking SET event_status = 'declined' WHERE event_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $eventID);

        if ($stmt->execute()) {
            // Send decline notification email
            sendDeclineEmailNotification($eventID, 'declined');
            echo 'success';
        } else {
            echo 'error';
        }

        $stmt->close();
    // $conn->close();
    } else {
        echo 'error';
    }

    // Function to send email notification for decline
    function sendDeclineEmailNotification($eventID, $status) {
        global $conn;

        // Fetch event details
        $sql = "SELECT event_booking.*, user.*, facilities.facility_name
                FROM event_booking
                INNER JOIN user ON event_booking.user_ID = user.user_ID
                INNER JOIN facilities ON event_booking.facility_ID = facilities.facility_ID
                WHERE event_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $eventID);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();

        // Fetch admin email address based on role
        $adminRole = 'ADMIN'; // Adjust based on your role definition
        $sqlAdmin = "SELECT email FROM user WHERE role = ?";
        $stmtAdmin = $conn->prepare($sqlAdmin);
        $stmtAdmin->bind_param("s", $adminRole);
        $stmtAdmin->execute();
        $resultAdmin = $stmtAdmin->get_result();
        $admin = $resultAdmin->fetch_assoc();
        $adminEmail = $admin['email'];

        // Create and send email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bsuevent.scheduling@gmail.com';
            $mail->Password = 'dlko mvgy wiul fshr';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('bsuevent.scheduling@gmail.com', 'Registration System');
            $mail->addAddress($event['email']); // User's email address
            $mail->addReplyTo($adminEmail, 'ADMIN');
            //$mail->addReplyTo('frenzjonathan5958@gmail.com', 'FRENZ JONATHAN V. ALULOD');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Event Approval Notification';
            $mail->Body = 'Dear ' . $event['first_name'] . ' ' . $event['last_name'] . ',' . '<br><br>'; 
            $mail->Body .= 'Your event with event code ' . $event['event_code'] . ' has been ' . $status . '.' . '<br><br>';
            $mail->Body .= 'Event Details:' . '.<br>';
            $mail->Body .= 'Event Name: ' . $event['event_name'] . '<br>';
            $mail->Body .= 'Start Date: ' . $event['start_from'] . '<br>';
            $mail->Body .= 'End Date: ' . $event['end_to'] . '<br>';
            $mail->Body .= 'Event Purpose: ' . $event['event_purpose'] . '<br>';
            $mail->Body .= 'Event Participants: ' . $event['participants'] . '<br>';
            $mail->Body .= 'Facility: ' . $event['facility_name'] . '<br><br>';
            $mail->Body .= 'Thank you.' . '<br><br>';
            $mail->Body .= 'Best regards,' . '<br>';
            $mail->Body .= 'Event Management System';

            $mail->send();
            echo 'Decline email sent successfully';
        } catch (Exception $e) {
            echo "Decline email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>
