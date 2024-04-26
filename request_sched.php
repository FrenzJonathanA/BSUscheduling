<?php
// Start or resume the session
session_start();

// Check if the user is logged in and retrieve their user ID
if (isset($_SESSION['user_ID'])) {
    // Database connection file
    require_once 'database/con_db.php';

    // Generate a unique schedule code (e.g., prefix + timestamp)
    $event_code = 'BSUsch' . time(); // Prefix 'SCH' followed by current timestamp

    // Retrieve form data
    $event_name = $_POST['event_name'];
    $event_purpose = $_POST['event_purpose'];
    $facility_ID = $_POST['facility_ID'];
    $start_date_str = $_POST['start_from'];
    $end_date_str = $_POST['end_to'];
    $participants = $_POST['participants'];

    // Convert start_date and end_date strings to valid DateTime objects
    $start_date = DateTime::createFromFormat('Y-m-d\TH:i', $start_date_str);
    $end_date = DateTime::createFromFormat('Y-m-d\TH:i', $end_date_str);

    // Check if DateTime objects were successfully created
    if ($start_date && $end_date) {
        // Format DateTime objects into MySQL datetime format
        $start_date_mysql = $start_date->format('Y-m-d H:i:s');
        $end_date_mysql = $end_date->format('Y-m-d H:i:s');

        // Check if the selected time slot is available
        $sql = "SELECT COUNT(*) as count FROM event_booking
                WHERE facility_ID = ? AND (start_from <= ? AND end_to >= ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $facility_ID, $end_date_mysql, $start_date_mysql);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            echo "Error: This time slot is unavailable. Please choose a different time.";
            exit();
        }

        // Insert data into the database
        $sql = "INSERT INTO event_booking (event_code, event_name, event_purpose, facility_ID, start_from, end_to, participants, user_ID)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisssi", $event_code, $event_name, $event_purpose, $facility_ID, $start_date_mysql, $end_date_mysql, $participants, $_SESSION['user_ID']);

        if ($stmt->execute()) {
            echo "New record created successfully";

            header('Location: cal-sample.php');
            exit(); // Ensure no further output is sent
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Invalid date format";
    }
} else {
    echo "Error: User not logged in.";
}
?>