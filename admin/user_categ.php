<?php
require '../database/con_db.php';

try {
    // Query to select all users
    $sql = "SELECT * FROM user";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($result) {
        // Fetch all rows as an associative array
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Handle the case where the query failed
        die("Error executing query: " . mysqli_error($conn));
    }

    // Free the result set
    mysqli_free_result($result);

} catch (Exception $e) {
    // Handle any exceptions that may occur
    die("Error: " . $e->getMessage());
}
?>


<?php 

    $pageTitle = "Manage Users";

    include('header_admin.php'); 

?>
<link rel="stylesheet" href="../scss/style.css"> 

    <div class="user-badge">
        <div class="container">
            <div class="ubadge-wrapper">
                <div class="row1">
                    <!-- Active Users -->
                    <div class="small-box-1" data-status="Active">
                        <div class="badge">
                            <div class="icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="inner">
                                <h3 class="active-users-count">0</h3>
                                <p>Active Users</p>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>

                    <!-- Pending Users -->
                    <div class="small-box-1" data-status="Pending">
                        <div class="badge">
                            <div class="icon">
                                <i class="fa-solid fa-users-gear"></i>
                            </div>
                            <div class="inner">
                                <h3 class="pending-users-count">0</h3>
                                <p>Pending Requests</p>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>

                    <!-- Rejected Users -->
                    <div class="small-box-1" data-status="Rejected">
                        <div class="badge">
                            <div class="icon">
                                <i class="fa-solid fa-users-slash"></i>
                            </div>
                            <div class="inner">
                                <h3 class="rejected-users-count">0</h3>
                                <p>Rejected Requests</p>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="user-list">
        <div class="container">
            <div class="list-wrapper">
                <div class="list-title">
                    <h2 style="text-align: center;">USERS</h2>
                </div>
                <table id="userDetailsTable">
                    <tr>
                        <th>User's Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Contact Number</th>
                        <th>Employee ID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?php echo $user['first_name']; ?><span>   </span><?php echo $user['last_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['role']; ?></td>
                            <td><?php echo $user['contact_number']; ?></td>
                            <td><?php echo $user['employee_ID']; ?></td>
                            <td><?php echo $user['user_status']; ?></td>
                            <td>
                                <?php if ($user['user_status'] == 'Pending') : ?>
                                    <button class="approve-button" style="margin-bottom:5px" data-id="<?php echo $user['user_ID']; ?>">Approve</button>
                                    <button class="remove-button" data-id="<?php echo $user['user_ID']; ?>">Remove</button>
                                <?php elseif ($user['user_status'] == 'Active') : ?>
                                    <button class="remove-button" data-id="<?php echo $user['user_ID']; ?>">Remove</button>
                                <?php elseif ($user['user_status'] == 'Rejected') : ?>
                                    <button class="approve-button" data-id="<?php echo $user['user_ID']; ?>">Approve</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div class="col-md-12">
                    <!-- <div class="well well-sm">
                        <div class="paginate">
                            <?php for ($x = 1; $x <= $pages; $x++) : ?>
                                <ul class="pagination">
                                    <li>
                                        <a href="?page=<?php echo $x; ?>&per-page=<?php echo $perPage; ?>">
                                            <?php echo $x; ?>
                                        </a>
                                    </li>
                                </ul>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <?php 
    include('footer_admin.php'); 
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





            // Function to fetch and display user details based on status
            function fetchUserDetails(status) {
                $.ajax({
                    url: 'user_fetch.php',
                    type: 'GET',
                    data: { status: status },
                    success: function(response) {
                        $('#userDetailsTable tbody').html(response);
                        console.log('current status.', status);
                    },
                    error: function() {
                        console.log('Error occurred while fetching user details.');
                    }
                });
            }

            // Function to fetch and update user counts
            function fetchUserCounts() {
                $.ajax({
                    url: 'user_filtering.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('.active-users-count').text(response.active);
                        $('.pending-users-count').text(response.pending);
                        $('.rejected-users-count').text(response.rejected);
                    },
                    error: function() {
                        console.log('Error occurred while fetching user counts.');
                    }
                });
            }

            // Click event for "More Info" buttons
            $('.small-box-1').click(function() {
                var status = $(this).data('status');
                fetchUserDetails(status);
            });

            // Initial fetch for user counts
            fetchUserCounts();
        });

    </script>

</body> 

</html>
