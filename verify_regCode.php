<?php

// Include database connection
include 'database/con_db.php';

// // Include the verification code function
// include 'send_verification_code.php';

// Include the registration notification function
include 'send_registration_notification.php';

// Get email and verification code from the form
$email = $_POST['email'];
$verification_code = $_POST['verification_code'];

// Retrieve the verification code from the database
$sql = "SELECT verification_code FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Check if the verification code matches the one in the database
    if ($row['verification_code'] === $verification_code) {
        // Verification successful
        // Update the user's status in the database
        $sql = "UPDATE user SET status = 'Pending' WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Send registration notification email to user and admin
        if (sendRegistrationNotification($email)) {
            // Registration successful
            echo "Registration successful.";

            // Redirect to calendar page
            header('Location: cal-sample.php');
            exit;
        } else {
            // Error in sending registration notification email
            echo "Error in sending registration notification email.";
        }
    } else {
        // Verification code is incorrect
        echo "Verification code is incorrect.";
    }
} else {
    // Verification code not found in the database
    echo "Verification code not found in the database.";
}

// Close database connection
$stmt->close();
$conn->close();

?>