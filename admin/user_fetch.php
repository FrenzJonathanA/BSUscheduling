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
    echo " <table style='width: 100%; border-collapse: collapse;'>";
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
            $('.remove-button').click(function() {
                // Confirm removal action
                if (confirm("Are you sure you want to remove this user?")) {
                    // Get user ID from data attribute
                    var userID = $(this).data('id');
                    // Send AJAX request to update user status
                    $.ajax({
                        url: 'user_remove.php',
                        type: 'POST',
                        data: { user_id: userID },
                        success: function(response) {
                            // Reload page or update UI as needed
                            window.location.reload(); // Example: Reload the page after successful removal
                        },
                        error: function() {
                            console.log('Error occurred while updating user status.');
                        }
                    });
                }
            });

            // Approve Button Click Event
            $('.approve-button').click(function() {
                // Confirm approval action
                if (confirm("Are you sure you want to approve this user?")) {
                    // Get user ID from data attribute
                    var userID = $(this).data('id');
                    // Send AJAX request to update user status
                    $.ajax({
                        url: 'user_approve.php',
                        type: 'POST',
                        data: { user_id: userID },
                        success: function(response) {
                            // Reload page or update UI as needed
                            window.location.reload(); // Example: Reload the page after successful approval
                        },
                        error: function() {
                            console.log('Error occurred while updating user status.');
                        }
                    });
                }
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
