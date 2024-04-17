<?php
    require '../database/con_db.php';

    try {
        // Query to select all users
        $sql = "SELECT event_booking.*, facilities.facility_code
                FROM event_booking
                Inner Join facilities
                ON event_booking.facility_ID = facilities.facility_ID";
        
        // Execute the query
        $result = mysqli_query($conn, $sql);

        // Check if the query executed successfully
        if ($result) {
            // Fetch all rows as an associative array
            $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
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

    $pageTitle = "Manage Events Scheduling";

    include('header_staff.php'); 

?>

    <div class="event-badge">
        <div class="container">
            <div class="ebadge-wrapper">
                <div class="row1">
                    <!-- Active Events -->
                    <div class="small-box-1" data-status="approved">
                        <div class="badge">
                            <div class="icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="inner">
                                <h3 class="approved-events-count">0</h3>
                                <p>Active Events</p>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>

                    <!-- Pending Events -->
                    <div class="small-box-1" data-status="pending">
                        <div class="badge">
                            <div class="icon">
                                <i class="fa-solid fa-users-gear"></i>
                            </div>
                            <div class="inner">
                                <h3 class="pending-events-count">0</h3>
                                <p>Pending Event Requests</p>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>

                    <!-- declinced Events -->
                    <div class="small-box-1" data-status="declined">
                        <div class="badge">
                            <div class="icon">
                                <i class="fa-solid fa-users-slash"></i>
                            </div>
                            <div class="inner">
                                <h3 class="declined-events-count">0</h3>
                                <p>Rejected Requests</p>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="event-list">
        <div class="container">
            <div class="list-wrapper">
                <div class="list-title">
                    <h2 style="text-align: center;">EVENTS SCHEDULES</h2>
                    <div class="filtering">
                        <div class="filter-bar">
                            <form id="filter-form">
                                <input type="date" id="filter-date" name="filter-date">
                                <select id="filter-facility" name="facilitycode" style="height:21.5px">
                                    <option value="">Select Facility</option>
                                    <?php
                                        // Loop through the fetched facilities and generate options
                                        require_once '../database/con_db.php'; // Ensure this file path is correct
                                        $query = "SELECT * FROM facilities"; // Assuming your facilities table name is 'facilities'
                                        $result = $conn->query($query);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row['facility_code'] . "'>" . $row['facility_name'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No facilities found</option>";
                                        }
                                        $conn->close();
                                    ?>
                                </select>
                                <button type="submit">Apply Filters</button>
                            </form>
                        </div>

                        <div class="search-bar">
                            <form id="search-form">
                                <input type="text" id="event-code" name="event_code" placeholder="Search by Event Code...">
                                <button type="submit">Search</button>
                            </form>
                        </div>
                    </div>

                    <!-- <div class="filtering">
                        <button type="submit"><a href=""><i class="fa-solid fa-filter"></i>Filter</a></button>
                        <div class="search-bar">
                            <form action="event_categ.php" method="GET">
                                <input type="text" name="search_schedule_code" placeholder="Search by code..." value="<?php echo isset($_GET['search_schedule_code']) ? $_GET['search_schedule_code'] : ''; ?>">
                                <button type="submit">Search</button>
                            </form>
                        </div>
                    </div> -->
                </div>
                <table id="eventDetailsTable">
                    <tr>
                        <th>Event Code</th>
                        <th>Event Details</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($events as $event) : ?>
                        <tr>
                            <td>
                                <?php echo $event['event_code']; ?>
                            </td>
                            <td class="event-details">
                                <?php echo $event['event_name']; ?> <br>
                                <?php echo $event['start_from']; ?> - <?php echo $event['end_to']; ?> <br>
                                <?php echo $event['facility_code']; ?>
                                <div class="additional-details" style="display: none;">
                                    <?php echo $event['event_purpose']; ?> <br>
                                    <?php echo $event['participants']; ?>
                                </div>
                            </td>
                            <td><?php echo $event['event_status']; ?></td>
                            <td>
                                <?php if ($event['event_status'] == 'pending') : ?>
                                    <button class="approve-button" style="margin-bottom:5px" data-id="<?php echo $event['event_ID']; ?>">Approve</button>
                                    <button class="remove-button" data-id="<?php echo $event['event_ID']; ?>">Remove</button>
                                <?php elseif ($event['event_status'] == 'approved') : ?>
                                    <button class="remove-button" data-id="<?php echo $event['event_ID']; ?>">Remove</button>
                                <?php elseif ($event['event_status'] == 'declined') : ?>
                                    <button class="approve-button" data-id="<?php echo $event['event_ID']; ?>">Approve</button>
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

    include('footer_staff.php'); 

    ?>

    <script>
       $(document).ready(function() {
            // Remove Button Click Event
            $('.remove-button').click(function() {
                // Confirm removal action
                if (confirm("Are you sure you want to remove this event?")) {
                    // Get event ID from data attribute
                    var eventID = $(this).data('id');
                    console.log("Event ID:", eventID); // Check if event ID is retrieved correctly
                    // Send AJAX request to update event status
                    // Send AJAX request to update user status
                    $.ajax({
                        url: 'event_remove.php',
                        type: 'POST',
                        data: { event_id: eventID },
                        success: function(response) {
                            console.log('Remove AJAX Success:', response);
                            // Reload page or update UI as needed
                            window.location.reload(); // Example: Reload the page after successful removal
                        },
                        error: function() {
                            console.log('Error occurred while updating event status.');
                            console.log('Remove AJAX Error: Error occurred while updating event status.');
                        }
                    });
                }
            });

            // Approve Button Click Event
            $('.approve-button').click(function() {
                // Confirm approval action
                if (confirm("Are you sure you want to approve this event?")) {
                    // Get event ID from data attribute
                    var eventID = $(this).data('id');
                    console.log("Event ID:", eventID);
                    // Send AJAX request to update event status
                    $.ajax({
                        url: 'event_approve.php',
                        type: 'POST',
                        data: { event_id: eventID },
                        success: function(response) {
                            console.log('Approve AJAX Success:', response);
                            // Reload page or update UI as needed
                            window.location.reload(); // Example: Reload the page after successful approval
                        },
                        error: function() {
                            console.log('Error occurred while updating event status.');
                        }
                    });
                }
            });

            // Update button visibility based on user status
            $('.approve-button, .remove-button').each(function() {
                var eventStatus = $(this).closest('tr').find('.event-status').text();
                if (eventStatus == 'approved' || eventStatus == 'declined') {
                    $(this).hide();
                }
            });





             // Function to fetch and display event details based on status
             function fetchEventDetails(status) {
                $.ajax({
                    url: 'event_fetch.php',
                    type: 'GET',
                    data: { status: status },
                    success: function(response) {
                        $('#eventDetailsTable tbody').html(response);
                    },
                    error: function() {
                        console.log('Error occurred while fetching event details.');
                    }
                });
            }

            // Function to fetch and update user counts
            function fetchEventCounts() {
                $.ajax({
                    url: 'event_filtering.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('.approved-events-count').text(response.approved);
                        $('.pending-events-count').text(response.pending);
                        $('.declined-events-count').text(response.declined);
                    },
                    error: function() {
                        console.log('Error occurred while fetching event counts.');
                    }
                });
            }

            // Click event for "More Info" buttons
            $('.small-box-1').click(function() {
                var status = $(this).data('status');
                fetchEventDetails(status);
            });

            // Initial fetch for user counts
            fetchEventCounts();





            
            // Submit form using AJAX
            $('#search-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                var formData = $(this).serialize(); // Serialize form data
                fetchEventSearch(formData); // Call function to fetch event Search
            });

            // Function to fetch and display event Search based on search criteria
            function fetchEventSearch(formData) {
                $.ajax({
                    url: 'search.php', // PHP script handling the search
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        $('#eventDetailsTable tbody').html(response); // Display search results in table
                    },
                    error: function() {
                        console.log('Error occurred while fetching event details.');
                    }
                });
            }


            // Event listener for filter form submission
            $('#filter-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Get filter parameters
                var filterDate = $('#filter-date').val();
                var facilityCode = $('#filter-facility').val();

                // AJAX request to fetch filtered events
                $.ajax({
                    url: 'event_filter.php',
                    type: 'GET',
                    data: {
                        'filter-date': filterDate,
                        'facilitycode': facilityCode
                    },
                    success: function(response) {
                        // Update the table with filtered events
                        $('#eventDetailsTable tbody').html(response);
                    },
                    error: function() {
                        console.log('Error occurred while fetching filtered events.');
                    }
                });
            });



                // Click event for displaying additional details
            $('.event-details').click(function() {
                $(this).find('.additional-details').toggle(); // Toggle visibility of additional details
            });

        });



    </script>


</body>
</html>
