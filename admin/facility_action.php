<?php
require __DIR__ . '/../database/con_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the action from the form data
    $action = $_POST['action'];

    // Perform different actions based on the value of $action
    if ($action == 'add') {
        // Check if the required form fields are set
        if(isset($_POST['facility_name'], $_POST['facility_code'], $_POST['building_loc'], $_POST['facility_capacity'])) {
            $facility_name = $_POST['facility_name'];
            $facility_code = $_POST['facility_code'];
            $building_loc = $_POST['building_loc'];
            $facility_capacity = $_POST['facility_capacity'];

            // Log the Facility name and code
            error_log("Facility Name: " . $facility_name);
            error_log("Facility Code: " . $facility_code);
            error_log("Facility Location: " . $building_loc);
            error_log("Facility Capacity: " . $facility_capacity);

            // Proceed with insertion without checking for uniqueness of facility code
            $sql = "INSERT INTO facilities (facility_name, facility_code, building_loc, facility_capacity) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $facility_name, $facility_code, $building_loc, $facility_capacity);

            if ($stmt->execute()) {
                // Insertion successful, redirect to Facility categories page
                header("location: ./facility_categ.php?error=Facility added");
                exit();
            } else {
                // Error occurred during insertion
                header("location: ./facility_categ.php?error=Error: " . $stmt->error);
                exit();
            }

            $stmt->close();
        } else {
            // Required form fields are not set
            header("location: ./facility_categ.php?error=Please fill in all required fields");
            exit();
        }
    } elseif ($action == 'update') {
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['facility_ID'], $_POST['facility_name'], $_POST['facility_code'], $_POST['building_loc'], $_POST['facility_capacity'])) {
        // Retrieve form data
        $facility_id = $_POST['facility_ID'];
        $facility_name = $_POST['facility_name'];
        $facility_code = $_POST['facility_code'];
        $building_loc = $_POST['building_loc'];
        $facility_capacity = $_POST['facility_capacity'];

        // Prepare and execute the SQL UPDATE query
        $sql = "UPDATE facilities SET facility_name = ?, facility_code = ?, building_loc = ?, facility_capacity = ? WHERE facility_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $facility_name, $facility_code, $building_loc, $facility_capacity, $facility_id);

        if ($stmt->execute()) {
            // Update successful
            header("location: ./facility_categ.php?error=Facility updated");
            exit();
        } else {
            // Update failed
            header("location: ./facility_categ.php?error=Update error");
            exit();
        }

    } else {
    // If the form was not submitted via POST method, return an error response
    echo 'Error: Form not submitted.';
    }
    }
}
?>
