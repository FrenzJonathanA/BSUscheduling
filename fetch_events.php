<?php
require __DIR__ . '/../database/con_db.php';

if(isset($_POST['selectedDate'])) {
    $date = htmlspecialchars($_POST['selectedDate']);

    // Prepare and execute the query to fetch events for the specified date
    $stmt = $conn->prepare("SELECT * FROM event_booking WHERE DATE(start_from) <= ? AND DATE(end_to) >= ?");
    $stmt->bind_param("ss", $date, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch events and store them in an array
    $events = array();
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    // Send JSON response containing the fetched events
    header('Content-Type: application/json');
    echo json_encode($events);

    // Close prepared statement and database connection
    $stmt->close();
} else {
    // If date parameter is not provided, send an error response
    echo json_encode(array('error' => 'Date is required.'));
}

// Close the database connection
$conn->close();
?>
