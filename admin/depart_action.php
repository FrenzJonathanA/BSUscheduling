<?php
    require __DIR__ . '/../database/con_db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the action from the form data
        $action = $_POST['action'];

        // Perform different actions based on the value of $action
        if ($action == 'add') {

    if(isset($_POST['department_name'], $_POST['department_code'])) {
        $department_name = $_POST['department_name'];
        $department_code = $_POST['department_code'];

        // Log the department name and code
        error_log("Department Name: " . $department_name);
        error_log("Department Code: " . $department_code);

        // Check if the department code already exists
        $check_query = "SELECT department_code FROM department WHERE department_code = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $department_code);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Department code already exists, redirect back with error message
            header("location: ./depart_categ.php?error=Department code already exists.");
            exit();
        } else {
            // Department code is unique, proceed with insertion
            $sql = "INSERT INTO department (department_name, department_code) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $department_name, $department_code);

            if ($stmt->execute()) {
                // Insertion successful, redirect to department categories page
                header("location: ./depart_categ.php?error=Department added");
                exit();
            } else {
                // Error occurred during insertion
                header("location: ./depart_categ.php?error=Error: " . $stmt->error);
                exit();
            }

            $stmt->close();
        }

        $check_stmt->close();
    //  $conn->close();
    }
        } elseif ($action == 'update') {
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['department_ID'], $_POST['department_name'], $_POST['department_code'])) {
        // Retrieve form data
        $department_id = $_POST['department_ID'];
        $department_name = $_POST['department_name'];
        $department_code = $_POST['department_code'];

        // Prepare and execute the SQL UPDATE query
        $sql = "UPDATE department SET department_name = ?, department_code = ? WHERE department_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $department_name, $department_code, $department_id);

        if ($stmt->execute()) {
            // Update successful
            header("location: ./depart_categ.php?error=Department updated");
            exit();
        } else {
            // Update failed
            header("location: ./depart_categ.php?error=Update error");
            exit();
        }

        // Close the statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // If the form was not submitted via POST method, return an error response
        header("location: ./depart_categ.php?error=Form submission error");
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