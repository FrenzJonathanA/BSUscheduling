<?php
    require '/../PHPMailer/src/PHPMailer.php';
    require '/../PHPMailer/src/SMTP.php';
    require '/../PHPMailer/src/Exception.php';

function sendApprovalEmail($email, $event_code, $event_name, $start_from, $end_to, $event_purpose, $participants, $facility_name) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'frenzjonathan5958@gmail.com';
    $mail->Password = 'kdxr onib hnoc nldy';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('frenzjonathan5958@gmail.com', 'FRENZ JONATHAN ALULOD');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Event Request Approved';
    $mail->Body    = 'Your event request for ' . $event_name . ' on ' . $start_from . 'until' . $end_to . ' has been approved. Facility: ' . $facility_name;

    if($mail->send()) {
        return 'success';
    } else {
        return 'error: ' . $mail->ErrorInfo;
    }
}

// function sendDeclineEmail($email, $event_code, $event_name, $start_from, $end_to, $event_purpose, $participants, $facility_name) {
//     $mail = new PHPMailer\PHPMailer\PHPMailer();
//     $mail->isSMTP();
//     $mail->Host = 'smtp.gmail.com';
//     $mail->Port = 587;
//     $mail->SMTPAuth = true;
//     $mail->Username = 'frenzjonathan5958@gmail.com';
//     $mail->Password = 'kdxr onib hnoc nldy';
//     $mail->SMTPSecure = 'tls';

//     $mail->setFrom('frenzjonathan5958@gmail.com', 'Facility Management');
//     $mail->addAddress($email);

//     $mail->isHTML(true);
//     $mail->Subject = 'Your Event Request has been Declined';
//     $mail->Body    = 'Dear user, <br> <br>Your event request has been declined by the facility manager. <br> <br> Event Code: ' . $event_code . '<br> Event Name: ' . $event_name . '<br> Event Start: ' . $start_from . '<br> Event End: ' . $end_to . '<br> Event Purpose: ' . $event_purpose . '<br> Participants: ' . $participants . '<br> Facility: ' . $facility_name;
//     $mail->AltBody = 'Dear user, Your event request has been declined by the facility manager. Event Code: ' . $event_code . ' Event Name: ' . $event_name . ' Event Start: ' . $start_from . ' Event End: ' . $end_to . ' Event Purpose: ' . $event_purpose . ' Participants: ' . $participants . ' Facility: ' . $facility_name;

//     if (!$mail->send()) {
//         return $mail->ErrorInfo;
//     } else {
//         return 'success';
//     }
// }
function sendDeclineEmail($email, $event_code, $event_name, $start_from, $end_to, $event_purpose, $participants, $facility_name, $user_id) {
    global $conn;

    $sql = "SELECT u.email, u.name FROM user u INNER JOIN event_booking eb ON u.user_id = eb.user_id WHERE eb.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $to = $user['email'];
        $name = $user['name'];

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'frenzjonathan5958@gmail.com';
        $mail->Password = 'your_password';
        $mail->SMTPSecure = 'tls';

        $mail->setFrom('frenzjonathan5958@gmail.com', 'Facility Management');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = 'Your Event Request has been Declined';
        $mail->Body    = 'Dear ' . $name . ', <br> <br>Your event request has been declined by the facility manager. <br> <br> Event Code: ' . $event_code . '<br> Event Name: ' . $event_name . '<br> Event Start: ' . $start_from . '<br> Event End: ' . $end_to . '<br> Event Purpose: ' . $event_purpose . '<br> Participants: ' . $participants . '<br> Facility: ' . $facility_name;
        $mail->AltBody = 'Dear ' . $name . ', Your event request has been declined by the facility manager. Event Code: ' . $event_code . ' Event Name: ' . $event_name . ' Event Start: ' . $start_from . ' Event End: ' . $end_to . ' Event Purpose: ' . $event_purpose . ' Participants: ' . $participants . ' Facility: ' . $facility_name;

        if (!$mail->send()) {
            return $mail->ErrorInfo;
        } else {
            return 'success';
        }
    } else {
        return 'Error: Unable to fetch user information.';
    }
}
?>