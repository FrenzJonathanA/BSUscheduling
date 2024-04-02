<?php
    // Include the database connection file
    require '../database/con_db.php';

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    try {
        // Prepare and execute the query to fetch facilities
        $sql = "SELECT * FROM facilities";
        $result = $conn->query($sql);

        // Check if the query executed successfully
        if ($result) {
            // Fetch all facilities as an associative array
            $facilities = [];
            while ($row = $result->fetch_assoc()) {
                $facilities[] = $row;
            }

            // If no facilities are found, display a message
            if (empty($facilities)) {
                echo "No facilities found.";
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

        $pageTitle = "Manage facilities";

        include('header_admin.php'); 

    ?>
    
    <div class="facility">
        <div class="container">
            <div class="facility-wrapper">
            <h2>Add New Facility</h2>
            <div class="form-container">
                <form id="facility-form" method="post" action="facility_action.php">
                    <!-- Hidden input field to store the action -->
                    <input type="hidden" id="action" name="action">

                    <div class="form-group add row">
                        <div class="col-6">
                            <label for="facility_code">Code:</label>
                            <input type="text" id="facility_code" name="facility_code" pattern="[A-Za-z\s]+" required placeholder="Enter Facility Code">
                        </div>
                        <div class="col-6">
                            <label for="facility_name">Name:</label>
                            <input type="text" id="facility_name" name="facility_name" pattern="[A-Za-z\s]+" required placeholder="Enter Facility Name">
                        </div>
                        <div class="col-6">
                            <label for="building_loc">Location:</label>
                            <input type="text" id="building_loc" name="building_loc" pattern="[A-Za-z\s]+" required placeholder="Enter Facility Location">
                        </div>
                        <div class="col-6">
                            <label for="facility_capacity">Capacity:</label>
                            <input type="text" id="facility_capacity" name="facility_capacity" pattern="[A-Za-z\s]+" required placeholder="Enter Total Capacity">
                        </div>

                    </div>
                    <input type="hidden" id="facility_ID" name="facility_ID">
                    <!-- Add button -->
                    <button type="button" onclick="setAction('add')" id="add-facility-button"><i class="fa fa-save"></i>Add</button>

                    <!-- Update button (initially hidden) -->
                    <button type="button" onclick="setAction('update')" id="update-facility-button" style="display:none;"><i class="fa fa-save"></i>Update</button>
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
            document.getElementById('facility-form').submit();
        }
    </script>

    <div class="facility-list">
        <div class="container">
            <div class="list-wrapper">
                <div class="list-title">
                    <h2 style="text-align: center;">Facility List</h2>    
                    <div class="search-bar">
                        <form action="facility_categ.php" method="GET">
                            <input type="text" name="search_facility_code" placeholder="Search by code..." value="<?php echo isset($_GET['search_facility_code']) ? $_GET['search_facility_code'] : ''; ?>">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                </div>
                

                <?php
                // Include the search.php file to display search results within the table
                include 'facility_search.php';
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
                var facilityID = $(this).data('id');
                var facilityCode = $(this).data('code');
                var facilityName = $(this).data('name');
                var buildingLoc = $(this).data('loc');
                var facilityCapacity = $(this).data('capacity');
                // Debug: Log retrieved departmentfacility details
                console.log('Facility ID:', facilityID);
                console.log('Facility Code:', facilityCode);
                console.log('Facility Name:', facilityName);
                console.log('Building Location:', buildingLoc);
                console.log('Facility Capacity:', facilityCapacity);
                // Populate the form fields with current facility details
                $('#facility_code').val(facilityCode);
                $('#facility_name').val(facilityName);
                $('#facility_ID').val(facilityID);
                $('#building_loc').val(buildingLoc);
                $('#facility_capacity').val(facilityCapacity);
                // Show the update button and hide the add button
                $('#update-facility-button').show();
                $('#add-facility-button').hide();
            });
        });

        //remove button
        $(document).ready(function() {
            // Remove Button Click Event
            $('.remove-button').click(function() {
                // Confirm removal action
                if (confirm("Are you sure you want to remove this facility?")) {
                    // Get facility ID from data attribute
                    var facilityID = $(this).data('id');
                    // Send AJAX request to update facility status
                    $.ajax({
                        url: 'facility_remove.php',
                        type: 'POST',
                        data: { facility_id: facilityID },
                        success: function(response) {
                            // Reload page or update UI as needed
                            window.location.reload(); // Example: Reload the page after successful removal
                        },
                        error: function() {
                            console.log('Error occurred while updating facility status.');
                        }
                    });
                }
            });
        });


    </script>



</body>
</html>