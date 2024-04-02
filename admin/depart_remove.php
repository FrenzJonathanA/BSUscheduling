<?php
// Include database connection or any necessary files
require __DIR__ . '/../database/con_db.php';

// Check if department ID is provided
if (isset($_POST['department_id'])) {
    // Retrieve department ID from POST data
    $departmentID = $_POST['department_id'];

    // Update department status in the database
    $sql = "UPDATE department SET department_status = 'Not Active' WHERE department_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $departmentID);

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
    // Department ID not provided in POST data
    echo 'error';
}
?>
