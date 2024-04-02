<?php
// Include database connection or any necessary files
require __DIR__ . '/../database/con_db.php';

// Check if device ID is provided
if (isset($_POST['device_id'])) {
    // Retrieve device ID from POST data
    $deviceID = $_POST['device_id'];

    // Update device status in the database
    $sql = "UPDATE device SET device_status = 'Not Active' WHERE device_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $deviceID);

    if ($stmt->execute()) {
        // Update successful
        echo 'success';
    } else {
        // Update failed
        echo 'error';
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Device ID not provided in POST data
    echo 'error';
}
?>
