<?php
    // Include database connection
    include 'database/con_db.php';

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    // Include PHPMailer classes
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


    // Function to send registration notification email
    function sendRegistrationNotification($email, $conn) {
        // Retrieve user's personal information from the database
        $sql = "SELECT user.*, department.department_name
                FROM user
                INNER JOIN department ON user.department_ID = department.department_ID
                WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Fetch admin email address based on role
        $adminRole = 'ADMIN'; // Adjust based on your role definition
        $sqlAdmin = "SELECT email FROM user WHERE role = ?";
        $stmtAdmin = $conn->prepare($sqlAdmin);
        $stmtAdmin->bind_param("s", $adminRole);
        $stmtAdmin->execute();
        $resultAdmin = $stmtAdmin->get_result();
        $admin = $resultAdmin->fetch_assoc();
        $adminEmail = $admin['email'];

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
            $mail->Username = 'bsuevent.scheduling@gmail.com'; // SMTP username
            $mail->Password = 'dlko mvgy wiul fshr'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable SSL encryption, 'tls' also accepted
            $mail->Port = 587; // TCP port to connect to

            // Set email sender and recipient
            $mail->setFrom('bsuevent.scheduling@gmail.com', 'Registration System');
            $mail->addAddress($email, $row['first_name'] . ' ' . $row['last_name']);
            $mail->addReplyTo($adminEmail, 'ADMIN');
            //$mail->addAddress('frenzjonathan5958@gmail.com');

            // Set email subject and body
            $mail->Subject = 'Registration Notification';
            $mail->Body = 'Dear ' . $row['first_name'] . ' ' . $row['last_name'] . ',' . "\n\n";
            $mail->Body .= 'Your registration is successful and is PENDING for APPROVAL. Your account details are as follows:' . "\n\n";
            $mail->Body .= 'NAME: ' . $row['first_name'] . ' ' . $row['last_name'] . "\n";
            $mail->Body .= 'EMAIL: ' . $email . "\n";
            $mail->Body .= 'CONTACT NUMBER: ' . $row['contact_number'] . "\n";
            $mail->Body .= 'EMPLOYEE ID: ' . $row['employee_ID'] . "\n";
            $mail->Body .= 'DEPARTMENT: ' . $row['department_name'] . "\n\n";
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