<?php
    // Start or resume the session
    session_start();

    // Check if user is logged in
    if (isset($_SESSION['user_ID'])) {
        // If logged in, display logout button
        echo '<a href="logout.php">Logout</a>';
    } else {
        // If not logged in, display login button
        echo '<a href="login_form.php">Login</a>';
    }

    // Check if the user is logged in
    if(isset($_SESSION['user_ID'])) {
        // User is logged in, redirect to request_form.php
        $redirectURL = 'request_form.php';
    } else {
        // User is not logged in, redirect to login_form.php
        $redirectURL = 'login_form.php';
    }


?>