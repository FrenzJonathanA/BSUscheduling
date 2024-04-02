<?php
    // Include the database connection file
    require '../database/con_db.php';

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    try {
        // Prepare and execute the query to fetch departments
        $sql = "SELECT * FROM department";
        $result = $conn->query($sql);

        // Check if the query executed successfully
        if ($result) {
            // Fetch all departments as an associative array
            $departments = [];
            while ($row = $result->fetch_assoc()) {
                $departments[] = $row;
            }

            // If no departments are found, display a message
            if (empty($departments)) {
                echo "No departments found.";
            }

            // Free the result set
            $result->free();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    } catch (Exception $e) {
        // Handle exceptions
        die("Error: " . $e->getMessage());
    }

    // Close the connection
    // $conn->close();
?>

    <?php 

        $pageTitle = "Manage Departments";

        include('header_admin.php'); 

    ?>

    <div class="depart">
        <div class="container">
            <div class="depart-wrapper">
            <h2>Add New Department</h2>
            <div class="form-container">
            <form id="department-form" method="post" action="depart_action.php">
                <!-- Hidden input field to store the action -->
                <input type="hidden" id="action" name="action">

                <div class="form-group add row">
                    <div class="col-6">
                        <label for="department_code">Department Code:</label>
                        <input type="text" id="department_code" name="department_code" pattern="[A-Za-z\s]+" required placeholder="Enter Department Code">
                    </div>
                    <div class="col-6">
                        <label for="department_name">Department Name:</label>
                        <input type="text" id="department_name" name="department_name" pattern="[A-Za-z\s]+" required placeholder="Enter Department Name">
                    </div>
                </div>
                <input type="hidden" id="department_ID" name="department_ID">
                <!-- Add button -->
                <button type="button" onclick="setAction('add')" id="add-department-button"><i class="fa fa-save"></i>Add</button>

                <!-- Update button (initially hidden) -->
                <button type="button" onclick="setAction('update')" id="update-department-button" style="display:none;"><i class="fa fa-save"></i>Update</button>
            </form>

                <!-- Notification message container -->
                <?php
                    // Check if an error message is present in the URL
                    if(isset($_GET['error'])) {
                        $error_message = $_GET['error'];
                        echo "<div class='error-message'>$error_message</div>";
                    }
                ?>
            </div>
        </div>
    </div>

    <script>
        function setAction(action) {
            // Set the value of the hidden input to the chosen action
            document.getElementById('action').value = action;

            // Submit the form
            document.getElementById('department-form').submit();
        }
    </script>




    <div class="depart-list">
        <div class="container">
            <div class="list-wrapper">
                <div class="list-title">
                    <h2 style="text-align: center;">Department List</h2>
                    <div class="search-bar">
                        <form action="depart_categ.php" method="GET">
                            <input type="text" name="search_department_code" placeholder="Search by code..." value="<?php echo isset($_GET['search_department_code']) ? $_GET['search_department_code'] : ''; ?>">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                </div>


                <?php
                // Include the search.php file to display search results within the table
                include 'depart_search.php';
                ?>
       
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
            //edit button
        $(document).ready(function() {
            // Edit Button Click Event
            $('.edit-button').click(function() {
                var departmentID = $(this).data('id');
                var departmentCode = $(this).data('code');
                var departmentName = $(this).data('name');
                // Debug: Log retrieved department details
                console.log('Department ID:', departmentID);
                console.log('Department Code:', departmentCode);
                console.log('Department Name:', departmentName);
                // Populate the form fields with current department details
                $('#department_code').val(departmentCode);
                $('#department_name').val(departmentName);
                $('#department_ID').val(departmentID);
                // Show the update button and hide the add button
                $('#update-department-button').show();
                $('#add-department-button').hide();
            });
        });

        //remove button
        $(document).ready(function() {
            // Remove Button Click Event
            $('.remove-button').click(function() {
                // Confirm removal action
                if (confirm("Are you sure you want to remove this department?")) {
                    // Get department ID from data attribute
                    var departmentID = $(this).data('id');
                    // Send AJAX request to update department status
                    $.ajax({
                        url: 'depart_remove.php',
                        type: 'POST',
                        data: { department_id: departmentID },
                        success: function(response) {
                            // Reload page or update UI as needed
                            window.location.reload(); // Example: Reload the page after successful removal
                        },
                        error: function() {
                            console.log('Error occurred while updating department status.');
                        }
                    });
                }
            });
        });


    </script>
    
</body>
</html>