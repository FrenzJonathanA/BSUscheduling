<?php
    // Include database connection or any necessary files
    require_once 'database/con_db.php';

    // Function to fetch events from the database
    function fetchMonthEvents() {
        global $conn;

        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Prepare and execute the query to fetch events for the current month
        $query = "SELECT eb.event_code, eb.event_name, eb.event_purpose, eb.start_from, eb.end_to, eb.participants, eb.event_status, u.first_name, u.last_name, f.facility_name, f.building_loc 
                FROM event_booking AS eb
                INNER JOIN user AS u ON eb.user_ID = u.user_ID
                INNER JOIN facilities AS f ON eb.facility_ID = f.facility_ID
                WHERE MONTH(eb.start_from) = ? AND YEAR(eb.start_from) = ? AND eb.event_status != 'declined'
                ORDER BY eb.start_from";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $currentMonth, $currentYear);
        $stmt->execute();

        // Fetch events and store them in an array
        $events = array();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }

        return $events;
    }

    // Fetch events
    $events = fetchMonthEvents();

    // Check if there are events
    if (count($events) === 0) {
        // No events scheduled, redirect to cal-sample.php
        header('Location: cal-sample.php');
        exit();
    } else {
        // Events scheduled, send JSON response
        header('Content-Type: application/json');
        echo json_encode($events);
    }

    // Close the database connection
    $conn->close();
?>