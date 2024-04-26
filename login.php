<!--?php
    // Start session
    session_start();

    // Database connection file
    require_once 'database/con_db.php';

    // Function to display error alert using SweetAlert2
    function showErrorAlert($title, $text) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: '$title',
                text: '$text'
            });
        </script>";
    }

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
       // echo "console.log($email, $password)";

        // Check if there is a row returned
        if ($result->num_rows == 1) {
            // Fetch user data
            $row = $result->fetch_assoc();
            // Check user user_status
            if ($row['user_status'] == 'Active') {
                // Start session
                $_SESSION['user_ID'] = $row['user_ID'];
                // Check if the user is an admin
                if ($row['role'] == 'ADMIN') {
                    // Redirect admin to admin dashboard
                    header("Location: ./admin/admin_dash.php");
                } elseif ($row['role'] == 'STAFF') { // Add this condition for staff members
                    // Redirect staff to staff dashboard
                    header("Location: ./staff/staff_dash.php");
                } elseif ($row['role'] == 'USER'){
                    // Check if there's a redirect parameter
                    if(isset($_GET['redirect']) && !empty($_GET['redirect'])) {
                        // Redirect to the specified location
                        header("Location: ".$_GET['redirect']);
                    } else {
                        // Redirect other users to request form
                        header("Location: request_form.php");
                    }
                    // Redirect other users to request form
                    // header("Location: request_form.php");
                }else {
                    // Redirect other users to request form
                    header("Location: login_form.php");
                }
                exit();
            } elseif ($row['user_status'] == 'pending') {
                // Account is pending approval
                echo "Account Pending Approval";
                showErrorAlert('Error', 'Account Pending Approval. An error occurred while approving the event.');
               
            } else {
                // Account is not approved
                echo "Account Not Approved";
                showErrorAlert('Error', 'Account Not Approved. An error occurred while approving the event.');
                    
            }
        } else {
            // Email and password do not match
            echo "Invalid Credentials";
            showErrorAlert('Error', ' Invalid Credentials. An error occurred while approving the event.');
            
        }
        // Redirect back to login form
        //echo "<script>window.location.href = 'login_form.php';</script>";
    }

    // Close database connection
    $stmt->close();
?-->
<?php
    // Start session
    session_start();

    // Database connection file
    require_once 'database/con_db.php';

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
            } elseif ($row['user_status'] == 'pending') {
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
?>
