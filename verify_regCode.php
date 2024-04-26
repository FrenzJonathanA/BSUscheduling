<?php

// Include database connection
include 'database/con_db.php';

// Include the registration notification function
include 'send_registration_notification.php';

// Get email and verification code from the form
$email = $_POST['email'];
$verification_code = $_POST['verification_code'];

// Retrieve the verification code from the database
$sql = "SELECT verification_code FROM user WHERE email =?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the data from the result set
    $row = $result->fetch_assoc();

    // Output the fetched data to the console
    // echo '<script>';
    // echo 'console.log("Fetched verification code:", '. json_encode($row['verification_code']). ');';
    // echo '</script>';

    // Check if the verification code matches the one in the database
    // echo 'Verification code from form: '. $verification_code. '<br>';
    // echo 'Verification code from database: '. $row['verification_code']. '<br>';
    if ($row['verification_code'] == $verification_code) {
        // Verification successful
        // Update the user's status in the database
        $sql = "UPDATE user SET verification_status = 'Verified' WHERE email =?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Send registration notification email to user and admin
        if (sendRegistrationNotification($email, $conn)) {
            // Registration successful
            echo "Registration successful.";

            // Redirect to calendar page
            header('Location: cal-sample.php');
            exit;
        } else {
            // Error in sending registration notification email
            // echo "Error in sending registration notification email.";
            $_SESSION['error_message'] = "Error in sending registration notification email.";
            // Redirect back to the verification page
            header('Location: verify_registration.php?email=' . $_GET['email']);
            exit;
        }
    } else {
        // Verification code is incorrect
        // echo "Verification code is incorrect.";
        $_SESSION['error_message'] = "Verification code is incorrect.";
        // Redirect back to the verification page
        header('Location: verify_registration.php?email=' . $_GET['email']);
        exit;
    }
} else {
    // Verification code not found in the database
    // echo "Verification code not found in the database.";
    $_SESSION['error_message'] = "Verification code not found in the database.";
    // Redirect back to the verification page
    header('Location: verify_registration.php?email=' . $_GET['email']);
    exit;
}

// Close database connection
$stmt->close();
//$conn->close();

?>