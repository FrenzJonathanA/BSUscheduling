<?php
    session_start();

    $_SESSION = [];

    // Unset the user's session variables
    unset($_SESSION['user_ID']);
    unset($_SESSION['last_activity']);


    // Destroy the session
    session_destroy();

    header("Location: cal-sample.php");
    exit();
?>
