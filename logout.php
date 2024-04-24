<?php
    session_start();

    $_SESSION = [];

    // Destroy the session
    session_destroy();

    header("Location: cal-sample.php");
    exit();
?>
