<?php
// Include database connection or any necessary files
require __DIR__ . '/../database/con_db.php';

// Check if facility ID is provided
if (isset($_POST['facility_id'])) {
    // Retrieve facility ID from POST data
    $facilityID = $_POST['facility_id'];

    // Update facility status in the database
    $sql = "UPDATE facilities SET facility_status = 'disable' WHERE facility_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $facilityID);

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
    // facility ID not provided in POST data
    echo 'error';
}
?>
