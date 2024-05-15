
<!--?php
    // Start session
    session_start();

    // Database connection file
    require_once 'database/con_db.php';

    // Check if the user's session timestamp is set
    if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 30)){
        // If the user has been inactive for more than 5 minutes, destroy the session and redirect to login page
        echo "Session expired due to inactivity.";
        session_unset();
        session_destroy();
        header("Location: logout.php");
        exit();
    }

    // Update the user's session timestamp
    $_SESSION['last_activity'] = time();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get email and password from the login form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Perform database query to check if email and password match
        $query = "SELECT user_ID, role, user_status FROM user WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there is a row returned
        if ($result->num_rows == 1) {
            // Fetch user data
            $row = $result->fetch_assoc();
            // Check user user_status
            if ($row['user_status'] == 'Active') {
                // Start session
                $_SESSION['user_ID'] = $row['user_ID'];
                // Check user role and redirect accordingly
                if ($row['role'] == 'ADMIN') {
                    header("Location: ./admin/admin_dash.php");
                } elseif ($row['role'] == 'STAFF') {
                    header("Location: ./staff/staff_dash.php");
                } elseif ($row['role'] == 'USER'){
                    // Redirect to request form or specified location
                    if(isset($_GET['redirect']) && !empty($_GET['redirect'])) {
                        header("Location: ".$_GET['redirect']);
                    } else {
                        header("Location: request_form.php");
                    }
                } else {
                    header("Location: login_form.php");
                }
                exit();
            } elseif ($row['user_status'] == 'Pending') {
                // Account is pending approval
                $_SESSION['error_message'] = 'Account Pending Approval. An error occurred while approving the event.';
            } else {
                // Account is not approved
                $_SESSION['error_message'] = 'Account Not Approved. An error occurred while approving the event.';
            }
        } else {
            // Email and password do not match
            $_SESSION['error_message'] = 'Invalid Credentials. An error occurred while approving the event.';
        }

        // Redirect back to login form
        header("Location: login_form.php");
    }

    // Close database connection
    $stmt->close();
?-->
<?php
    session_start();
    require_once 'database/con_db.php';

    // Check if the user's session timestamp is set
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 300)) {
        // If the user has been inactive for more than 5 minutes, destroy the session and redirect to login page
        echo "Session expired due to inactivity.";
        session_unset();
        session_destroy();
        header("Location: logout.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get email and password from the login form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Perform database query to check if email and password match
        $query = "SELECT user_ID, role, user_status FROM user WHERE email =? AND password =?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there is a row returned
        if ($result->num_rows == 1) {
            // Fetch user data
            $row = $result->fetch_assoc();
            // Check user user_status
            if ($row['user_status'] == 'Active') {
                // Start session
                $_SESSION['user_ID'] = $row['user_ID'];
                $_SESSION['last_activity'] = time(); // Update the user's session timestamp

                // Check user role and redirect accordingly
                if ($row['role'] == 'ADMIN') {
                    $_SESSION['error_message'] = 'ADMINACCOUNT';
                    header("Location:./admin/admin_dash.php");
                } elseif ($row['role'] == 'STAFF') {
                    header("Location:./staff/staff_dash.php");
                } elseif ($row['role'] == 'USER'){
                    // Redirect to request form or specified location
                    if(isset($_GET['redirect']) &&!empty($_GET['redirect'])) {
                        header("Location: ".$_GET['redirect']);
                    } else {
                        header("Location: request_form.php");
                    }
                } else {
                    header("Location: login_form.php");
                }
                exit();
            } elseif ($row['user_status'] == 'Pending') {
                // Account is pending approval
                $_SESSION['error_message'] = 'Account Pending Approval. An error occurred while approving the event.';
            } else {
                // Account is not approved
                $_SESSION['error_message'] = 'Account Not Approved. An error occurred while approving the event.';
            }
        } else {
            // Email and password do not match
            $_SESSION['error_message'] = 'Invalid Credentials. An error occurred while approving the event.';
        }
        $_SESSION['error_message'] = 'Account Not Approved. An error occurred while approving the event.';

        // Redirect back to login form
    header("Location: login_form.php");
    }

    // Close database connection
    $stmt->close();
?>