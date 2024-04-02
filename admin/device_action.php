<?php
require __DIR__ . '/../database/con_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the action from the form data
    $action = $_POST['action'];

    // Perform different actions based on the value of $action
    if ($action == 'add') {
        
if(isset($_POST['device_name'], $_POST['facility_ID'])) {
    $device_name = $_POST['device_name'];
    $facility_ID = $_POST['facility_ID'];

    // Log the device name and code
    error_log("Device Name: " . $device_name);
    error_log("Deployed Facility: " . $facility_ID);

    // Check if the device name already exists
    $check_query = "SELECT device_name FROM device WHERE device_name = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $device_name);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Device Name already exists, redirect back with error message
        header("location: ./device_categ.php?error=Device name already exists.");
        exit();
    } else {
        // Device Name is unique, proceed with insertion
        $sql = "INSERT INTO device (device_name, facility_ID) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $device_name, $facility_ID);

        if ($stmt->execute()) {
            // Insertion successful, redirect to device categories page
            header("location: ./device_categ.php?error=Device added");
            exit();
        } else {
            // Error occurred during insertion
            header("location: ./device_categ.php?error=Error: " . $stmt->error);
            exit();
        }

        $stmt->close();
    }

    $check_stmt->close();
  //  $conn->close();
}
    } elseif ($action == 'update') {
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['device_ID'], $_POST['device_name'], $_POST['facility_ID'])) {
    // Retrieve form data
    $device_id = $_POST['device_ID'];
    $device_name = $_POST['device_name'];
    $facility_ID = $_POST['facility_ID'];

    // Prepare and execute the SQL UPDATE query
    $sql = "UPDATE device SET device_name = ?, facility_ID = ? WHERE device_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $device_name, $facility_ID, $device_id);

    if ($stmt->execute()) {
        // Update successful
        header("location: ./device_categ.php?error=Device updated");
        exit();
    } else {
        // Update failed
        header("location: ./device_categ.php?error=Update error");
        exit();
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
    } else {
    // If the form was not submitted via POST method, return an error response
    header("location: ./device_categ.php?error=Form submission error");
    exit();
    } } else {
        // Invalid action
        echo 'Invalid action.';
    }
    } else {
    // If the form was not submitted via POST method, return an error response
    echo 'Error: Form not submitted.';
    }
?>

