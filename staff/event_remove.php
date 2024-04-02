<?php
require __DIR__ . '/../database/con_db.php';

if (isset($_POST['event_id'])) {
    $eventID = $_POST['event_id'];

    $sql = "UPDATE event_booking SET event_status = 'declined' WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventID);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
   // $conn->close();
} else {
    echo 'error';
}
?>
