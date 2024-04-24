<?php

// Database connection file
require_once 'database/con_db.php';

// Check if the selectedDate parameter is set in the POST request
if (isset($_POST['selectedDate'])) {
    $date = new DateTime(htmlspecialchars($_POST['selectedDate']));
    $date_formatted = $date->format('Y-m-d'); // Format the date as 'Y-m-d'

    // Query to fetch events for the specified date
    $query = "SELECT eb.event_code, eb.event_name, eb.event_purpose, eb.start_from, eb.end_to, eb.participants, eb.event_status, u.first_name, u.last_name AS host_last_name, f.facility_name
              FROM event_booking AS eb
              INNER JOIN user AS u ON eb.user_ID = u.user_ID
              INNER JOIN facilities AS f ON eb.facility_ID = f.facility_ID
              WHERE DATE(eb.start_from) = ?
              ORDER BY eb.start_from";

    // Prepare and execute the query to fetch events for the specified date
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date_formatted);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch events and store them in an array
    $events = array();
    while ($row = $result->fetch_assoc()) {
        $events[] = array(
            'event_code' => $row['event_code'],
            'event_name' => $row['event_name'],
            'event_purpose' => $row['event_purpose'],
            'start_from' => $row['start_from'],
            'end_to' => $row['end_to'],
            'participants' => $row['participants'],
            'event_status' => $row['event_status'],
            'host_first_name' => $row['first_name'],
            'host_last_name' => $row['host_last_name'],
            'facility_name' => $row['facility_name']
        );
    }

    // Send JSON response containing the fetched events
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($events);

    // Close prepared statement and database connection
    $stmt->close();
} else {
    // If date parameter is not provided, send an error response
    echo json_encode(array('error' => 'Date is required.'));
}

// Close the database connection
//$conn->close();
?>