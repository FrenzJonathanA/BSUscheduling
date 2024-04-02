<?php
require __DIR__ . '/../database/con_db.php';

if (isset($_POST['user_id'])) {
    $userID = $_POST['user_id'];

    $sql = "UPDATE user SET user_status = 'Rejected' WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);

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
