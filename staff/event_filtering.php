<?php
    // Include database connection or any necessary files
    require __DIR__ . '/../database/con_db.php';

    // Fetch count of approved events
    $query_approved = "SELECT COUNT(*) AS numrows FROM event_booking WHERE event_status = 'approved'";
    $result_approved = mysqli_query($conn, $query_approved);
    $approved_count = mysqli_fetch_assoc($result_approved)['numrows'];

    // Fetch count of pending events
    $query_pending = "SELECT COUNT(*) AS numrows FROM event_booking WHERE event_status = 'pending'";
    $result_pending = mysqli_query($conn, $query_pending);
    $pending_count = mysqli_fetch_assoc($result_pending)['numrows'];

    // Fetch count of declined events
    $query_declined = "SELECT COUNT(*) AS numrows FROM event_booking WHERE event_status = 'declined'";
    $result_declined = mysqli_query($conn, $query_declined);
    $declined_count = mysqli_fetch_assoc($result_declined)['numrows'];

    // Output counts for approved, pending, and declined events
    echo json_encode(array(
        'approved' => $approved_count,
        'pending' => $pending_count,
        'declined' => $declined_count
    ));
?>
