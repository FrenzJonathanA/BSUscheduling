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
} else {
    echo 'error';
}
?>

<?php
require_once '/../database/con_db.php';
require_once 'email_sender.php';

$id = $_GET['event_id'];
$status = 'declined';

$result = sendDeclineEmail($_GET['email'], $_GET['event_code'], $_GET['event_name'], $_GET['start_from'], $_GET['end_to'], $_GET['event_purpose'], $_GET['participants'], $_GET['facility_name']);

if($result === 'success') {
    $query = "UPDATE event_booking SET event_status = 'declined' WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $status, $id);
    $stmt->execute();
    header('Location: staff_dash.php');
} else {
    echo $result;
}
?>