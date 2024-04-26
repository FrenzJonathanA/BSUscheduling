<?php
    // Include database connection
    include 'database/con_db.php';

    // Get email from POST request
    $email = $_POST['email'];

    // Check if email exists in the database
    $sql_check_email = "SELECT COUNT(*) AS count FROM user WHERE email = ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();
    $row_check_email = $result_check_email->fetch_assoc();

    if ($row_check_email['count'] > 0) {
        // Email exists
        echo 'exists';
        
    } else {
        // Email does not exist
        echo 'not_exists';
    }

    // Close database connection
    $stmt_check_email->close();
    $conn->close();
?>
