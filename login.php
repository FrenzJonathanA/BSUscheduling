<?php
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
        echo "console.log($email, $password)";

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
                // echo "<script>
                //         Swal.fire({
                //             icon: 'info',
                //             title: 'Account Pending Approval',
                //             text: 'Your account is pending approval. Please wait for admin confirmation.'
                //         });
                //     </script>";
            } else {
                // Account is not approved
                echo "Account Not Approved";
                // echo "<script>
                //         Swal.fire({
                //             icon: 'error',
                //             title: 'Account Not Approved',
                //             text: 'Your account has not been approved.'
                //         });
                //     </script>";
            }
        } else {
            // Email and password do not match
            echo "Invalid Credentials";

            // echo "<script>
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Invalid Credentials',
            //             text: 'Invalid email or password'
            //         });
            //     </script>";
        }
        // Redirect back to login form
        // echo "<script>window.location.href = 'login_form.php';</script>";
    }

    // Close database connection
    $stmt->close();
?>
