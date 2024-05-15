<?php
    // Include database connection
    include 'database/con_db.php';

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    // Include PHPMailer classes
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Function to send request notification email
    function sendRequestNotification($conn, $eventID) {
        // Retrieve event details from the event_booking table
        $sql = "SELECT e.*, u.email, u.first_name, u.last_name
                FROM event_booking e
                INNER JOIN user u ON e.user_ID = u.user_ID
                WHERE e.event_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $eventID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Check if the query returned any rows
        if ($row) {
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
                $mail->addAddress($row['email'], $row['first_name'] . ' ' . $row['last_name']);

                // Set email subject and body
                $mail->Subject = 'Request Notification';
                $mail->Body = 'Dear ' . $row['first_name'] . ' ' . $row['last_name'] . ',' . "\n\n";
                $mail->Body .= 'Your event schedule request is successful and is PENDING for APPROVAL. Your event request details are as follows:' . "\n\n";
                $mail->Body .= 'Event Name: ' . $row['event_name'] . "\n";
                $mail->Body .= 'Event Purpose: ' . $row['event_purpose'] . "\n";
                $mail->Body .= 'Facility: ' . $row['facility_ID'] . "\n";
                $mail->Body .= 'Start Date: ' . $row['start_from'] . "\n";
                $mail->Body .= 'End Date: ' . $row['end_to'] . "\n";
                $mail->Body .= 'Participants: ' . $row['participants'] . "\n\n";
                $mail->Body .= 'Thank you for your request.' . "\n\n";
                $mail->Body .= 'Best regards,' . "\n";
                $mail->Body .= 'Registration System';

                // Send email
                if ($mail->send()) {
                    return true; // Email sent successfully
                    header('Location: cal-sample.php');
                } else {
                    //return false; // Error in sending email
                    throw new Exception($mail->ErrorInfo); // Throw exception with error message
                }
            } catch (Exception $e) {
                error_log("Error sending email: " . $e->getMessage());
                return false; // Exception occurred
            }
        } else {
            return false; // No event found with the given ID
        }
    }