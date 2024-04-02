<?php
// Include database connection or any necessary files
require __DIR__ . '/../database/con_db.php';

// Fetch count of active users
$query_active = "SELECT COUNT(*) AS numrows FROM user WHERE user_status = 'Active'";
$result_active = mysqli_query($conn, $query_active);
$active_count = mysqli_fetch_assoc($result_active)['numrows'];

// Fetch count of pending users
$query_pending = "SELECT COUNT(*) AS numrows FROM user WHERE user_status = 'Pending'";
$result_pending = mysqli_query($conn, $query_pending);
$pending_count = mysqli_fetch_assoc($result_pending)['numrows'];

// Fetch count of rejected users
$query_rejected = "SELECT COUNT(*) AS numrows FROM user WHERE user_status = 'Rejected'";
$result_rejected = mysqli_query($conn, $query_rejected);
$rejected_count = mysqli_fetch_assoc($result_rejected)['numrows'];

// Output counts for active, pending, and rejected users
echo json_encode(array(
    'active' => $active_count,
    'pending' => $pending_count,
    'rejected' => $rejected_count
));
?>
