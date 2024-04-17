<?php
// Include database connection
include 'database/con_db.php';

// Check if the email is already taken
function isEmailTaken($conn, $email) {
    // Prepare and execute the query to check if email exists
    $sql = "SELECT COUNT(*) AS count FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            return true; // Email is already in use
        } else {
            return false; // Email is available
        }
    } else {
        return null; // Error in query execution
    }
}

// Get email from the POST request
$email = $_POST['email'];

// Check if the email is already taken
if (isEmailTaken($conn, $email)) {
    // Email is already taken
    echo 'taken';
} else {
    // Email is available
    echo 'available';
}

// Close database connection
$stmt->close();
$conn->close();
?>
