<?php
// Establish connection to MySQL database
include 'database/con_db.php';

// Function to calculate time remaining until event
function timeUntilEvent($eventTime) {
    $now = time();
    $eventTimestamp = strtotime($eventTime);
    $timeUntilEvent = $eventTimestamp - $now;
    return $timeUntilEvent;
}quoted_printable_decode

// Query database for upcoming events
$currentDateTime = date('Y-m-d H:i:s');
$sql = "SELECT * FROM event_booking WHERE start_from > '$currentDateTime'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through each event
    while($row = $result->fetch_assoc()) {
        // Calculate time remaining until event
        $timeRemaining = timeUntilEvent($row["start_from"]);
        
        // If event is scheduled to occur in 30 minutes
        if ($timeRemaining <= (30 * 60) && $timeRemaining > 0) { // 30 minutes * 60 seconds
            // Send signal to Arduino to turn LED on
            // You can use AJAX or other techniques to send this signal
            
            // Example using cURL
            $arduinoURL = "http://arduino_ip_address/turn_led_on"; // Replace with your Arduino IP address and endpoint
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $arduinoURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            
            // Log the event for debugging or tracking purposes
            $eventID = $row["event_id"];
            $logMessage = "Event ID: $eventID - LED turned on 30 minutes before event";
            error_log($logMessage);
        }
    }
} else {
    echo "No upcoming events";
}

$conn->close();
?>