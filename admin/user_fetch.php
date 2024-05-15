<?php
// Include database connection or any necessary files
require __DIR__ . '/../database/con_db.php';

// Check if status is provided
if (isset($_GET['status'])) {
    // Retrieve status from GET data
    $status = $_GET['status'];

    // Fetch user details based on status
    $query = "SELECT * FROM user WHERE user_status = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();

    // Output table headers
    echo " <table id='userDetailsTable' style='width: 100%; border-collapse: collapse;'>";
    echo "<tr><th>User's Name</th><th>Email</th><th>Role</th><th>Contact Number</th><th>Employee ID</th><th>Status</th><th>Action</th></tr>";

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // Display user details in table format
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
                echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "<td>" . $row['contact_number'] . "</td>";
                echo "<td>" . $row['employee_ID'] . "</td>";
                echo "<td>" . $row['user_status'] . "</td>";
                echo "<td>";
                // Determine button display based on user status
                    if ($row['user_status'] == 'Pending') {
                        echo "<button class='approve-button' style='margin-bottom: 5px' data-id='" . $row['user_ID'] . "'>Approve</button>";
                        echo "<button class='remove-button' data-id='" . $row['user_ID'] . "'>Remove</button>";
                    } elseif ($row['user_status'] == 'Active') {
                        echo "<button class='remove-button' data-id='" . $row['user_ID'] . "'>Remove</button>";
                    } elseif ($row['user_status'] == 'Rejected') {
                        echo "<button class='approve-button' data-id='" . $row['user_ID'] . "'>Approve</button>";
                    }
                echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No users found with status: " . $status . "</td></tr>";
    }

    echo "</table>";

    // Close statement and connection
    $stmt->close();
 
} else {
    // Status not provided
    echo "<tr><td colspan='7'>Status not provided.</td></tr>";
}
?>

<script>
       $(document).ready(function() {
            // Remove Button Click Event
            $(document).on('click', '.remove-button', function(){
                // Confirm removal action
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to remove this user!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Get user ID from data attribute
                        var userID = $(this).data('id');
                        // Send AJAX request to update user status
                        $.ajax({
                            url: 'user_remove.php',
                            type: 'POST',
                            data: { user_id: userID },
                            success: function(response) {
                                console.log('Remove AJAX Success:', response);
                                // Show success alert and redirect to users page
                                showSuccessAlert('User Removed', 'The user has been removed successfully.');
                            },
                            error: function() {
                                console.log('Error occurred while updating user status.');
                                // Show error alert
                                showErrorAlert('Error', 'An error occurred while removing the user.');
                            }
                        });
                    }
                });
            });

            // Approve Button Click Event
            $(document).on('click', '.approve-button', function() {
                // Confirm approval action
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to approve this user!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Get user ID from data attribute
                        var userID = $(this).data('id');
                        // Send AJAX request to update user status
                        $.ajax({
                            url: 'user_approve.php',
                            type: 'POST',
                            data: { user_id: userID },
                            success: function(response) {
                                console.log('Approve AJAX Success:', response);
                                // Show success alert and redirect to users page
                                showSuccessAlert('User Approved', 'The user has been approved successfully.');
                            },
                            error: function() {
                                console.log('Error occurred while updating user status.');
                                // Show error alert
                                showErrorAlert('Error', 'An error occurred while approving the user.');
                            }
                        });
                    }
                });
            });
            // Update button visibility based on user status
            $('.approve-button, .remove-button').each(function() {
                var userStatus = $(this).closest('tr').find('.user-status').text();
                if (userStatus == 'Approved' || userStatus == 'Rejected') {
                    $(this).hide();
                }
            });
        });

    </script>
