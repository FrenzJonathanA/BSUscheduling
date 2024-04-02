<?php
    // Include the database connection file
    require '../database/con_db.php';

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    try {
        // Prepare and execute the query to fetch departments
        $sql = "SELECT * FROM device";
        $result = $conn->query($sql);

        // Check if the query executed successfully
        if ($result) {
            // Fetch all departments as an associative array
            $devices = [];
            while ($row = $result->fetch_assoc()) {
                $devices[] = $row;
            }

            // If no devices are found, display a message
            if (empty($devices)) {
                echo "No devices found.";
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

        $pageTitle = "Manage Devices";

        include('header_admin.php'); 

    ?>

    <div class="device">
        <div class="container">
            <div class="device-wrapper">
                <h2>Add New Device</h2>
                <div class="form-container">
                <form id="device-form" method="post" action="device_action.php">
                    <!-- Hidden input field to store the action -->
                    <input type="hidden" id="action" name="action">

                    <div class="form-group add row">
                        <div class="col-6">
                            <label for="device_name">Device Name:</label>
                            <input type="text" id="device_name" name="device_name" pattern="[A-Za-z\s]+" required placeholder="Enter Device Name">
                        </div>
                        <div class="col-6">
                            <label for="facility_ID">Deployed Facility:</label><br>
                            <select id="facility_ID" name="facility_ID" required>
                            <option value="" selected>- Select -</option>
                            <?php
                                // Check if $facilityID is set before using it
                                if (isset($facilityID)) {
                                    // Prepare and execute the query
                                    $query = "SELECT facility_ID, facility_code FROM facilities";
                                    $result = $conn->query($query);
                                    
                                    // Check if query executed successfully
                                    if ($result) {
                                        // Fetch data and generate options
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['facility_ID'] . '"';
                                            // Check if the current facility ID matches the one from the button data
                                            if ($row['facility_ID'] == $facilityID) {
                                                echo ' selected';
                                            }
                                            echo '>' . $row['facility_code'] . '</option>';
                                        }
                                        // Free result set
                                        $result->free();
                                    } else {
                                        // Display error message
                                        echo "Error: " . $query . "<br>" . $conn->error;
                                    }
                                } else {
                                    // If $facilityID is not set, display all facility options
                                    $query = "SELECT facility_ID, facility_code FROM facilities";
                                    $result = $conn->query($query);
                                    
                                    // Check if query executed successfully
                                    if ($result) {
                                        // Fetch data and generate options
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['facility_ID'] . '">' . $row['facility_code'] . '</option>';
                                        }
                                        // Free result set
                                        $result->free();
                                    } else {
                                        // Display error message
                                        echo "Error: " . $query . "<br>" . $conn->error;
                                    }
                                }
                            ?>
                            </select><br>
                        </div>
                    </div>
                    <input type="hidden" id="device_ID" name="device_ID">
                    <!-- Add button -->
                    <button type="button" onclick="setAction('add')" id="add-device-button"><i class="fa fa-save"></i>Add</button>

                    <!-- Update button (initially hidden) -->
                    <button type="button" onclick="setAction('update')" id="update-device-button" style="display:none;"><i class="fa fa-save"></i>Update</button>
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
            document.getElementById('device-form').submit();
        }
    </script>

    <div class="device-list">
        <div class="container">
            <div class="list-wrapper">
                <div class="list-title">
                    <h2 style="text-align: center;">Device List</h2>
                    <div class="search-bar">
                        <form action="device_categ.php" method="GET">
                            <input type="text" name="search_device_name" placeholder="Search by name..." value="<?php echo isset($_GET['search_device_name']) ? $_GET['search_device_name'] : ''; ?>">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                </div>
                

                <?php
                // Include the search.php file to display search results within the table
                include 'device_search.php';
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
// Edit button click event
$(document).ready(function() {
    $('.edit-button').click(function() {
        var deviceID = $(this).data('id');
        var deviceName = $(this).data('name');
        var facilityID = $(this).data('fid'); // Corrected to 'fid'
        var facilityCode = $(this).data('fcode'); // Added facility code

        console.log('Device ID:', deviceID);
        console.log('Device Name:', deviceName);
        console.log('Facility ID:', facilityID);
        console.log('Facility Code:', facilityCode);

        // Populate form fields
        $('#device_name').val(deviceName);
        $('#device_ID').val(deviceID);
        
        // Set the selected option in the dropdown based on the facility ID
        $('#facility_ID').val(facilityID); 
        
        // Show update button, hide add button
        $('#update-device-button').show();
        $('#add-device-button').hide();
    });
});


        // Remove button click event
        $(document).ready(function() {
            $('.remove-button').click(function() {
                if (confirm("Are you sure you want to remove this device?")) {
                    var deviceID = $(this).data('id');
                    $.ajax({
                        url: 'device_remove.php',
                        type: 'POST',
                        data: { device_id: deviceID },
                        success: function(response) {
                            window.location.reload(); // Reload page after successful removal
                        },
                        error: function() {
                            console.log('Error occurred while updating device status.');
                        }
                    });
                }
            });
        });
    </script>




</body>
</html>
