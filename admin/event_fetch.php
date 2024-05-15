
<?php
    // Include database connection or any necessary files
    require __DIR__ . '/../database/con_db.php';

    // Check if status is provided
    if (isset($_GET['status'])) {
        // Retrieve status from GET data
        $status = $_GET['status'];

        // Fetch event details based on status with facility_code
        $query = "SELECT e.*, f.facility_code, f.facility_name, u.first_name, u.last_name
                  FROM event_booking e
                  INNER JOIN user u ON e.user_ID = u.user_ID
                  INNER JOIN facilities f ON e.facility_ID = f.facility_ID
                  WHERE e.event_status = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();

        // Output table headers
        echo "<table id='eventDetailsTable' style='width: 100%' >";
        echo "<tr><th>Event Code</th><th>Event Details</th><th>Status</th><th>Action</th></tr>";

        // Check if any rows are returned
        if ($result->num_rows > 0) {
            // Display event details in table format
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                    echo "<td>";
                        echo $row['event_code'];
                    echo "</td>";
                    echo "<td class='event-details'>";
                        echo "<p><span>Event Name: </span>" . $row['event_name'] . "</p>";
                        echo "<p><span>Event Date: </span>" . $row['start_from'] . " - " . $row['end_to'] . "</p>";
                        echo "<p><span>Facility: </span>" . $row['facility_code'] . " - " . '"' . $row['facility_name'] . '"' . "</p>";
                        echo "<div class='additional-details' style='display: none;'>";
                            echo "<p><span>Event Purpose: <br></span>" . $row['event_purpose'] . "</p>";
                            echo "<p><span>Event Host: </span>" . $row['first_name'] . " " . $row['last_name'] . "</p>";
                            echo "<p><span>Participants: </span>" . $row['participants'] . "</p>";
                        echo "</div>";
                    echo "</td>";
                    echo "<td style='text-transform: uppercase;'>" . $row['event_status'] . "</td>";
                    echo "<td>";
                        // Determine button display based on event status
                        if ($row['event_status'] == 'pending') {
                            echo "<button class='approve-button' style='margin-bottom:5px' data-id='" . $row['event_ID'] . "'>Approve</button>";
                            echo "<button class='remove-button' data-id='" . $row['event_ID'] . "'>Remove</button>";
                        } elseif ($row['event_status'] == 'approved') {
                            echo "<button class='remove-button' data-id='" . $row['event_ID'] . "'>Remove</button>";
                        } elseif ($row['event_status'] == 'declined') {
                            echo "<button class='approve-button' data-id='" . $row['event_ID'] . "'>Approve</button>";
                        }
                    echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No events found with status: " . $status . "</td></tr>";
        }

        echo "</table>";

        // Close statement and connection
        $stmt->close();
    
    } else {
        // Status not provided
        // echo "<p style='width: 100%; border-collapse: collapse;'>Status not provided.</p>";
        echo "<tr><td colspan='3'>Status not PROVIDED.</td></tr>";

    }
?>

<script>
    $(document).ready(function() {
        $(document).on('click', '.remove-button', function() {
            // Confirm removal action
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to remove this event!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Get event ID from data attribute
                    var eventID = $(this).data('id');
                    console.log("Event ID:", eventID); // Check if event ID is retrieved correctly
                    // Send AJAX request to update event status
                    $.ajax({
                        url: 'event_remove.php',
                        type: 'POST',
                        data: { event_id: eventID },
                        success: function(response) {
                            console.log('Remove AJAX Success:', response);
                            // Show success alert and redirect to events page
                            showSuccessAlert('Event Removed', 'The event has been removed successfully.');
                        },
                        error: function() {
                            console.log('Error occurred while updating event status.');
                            // Show error alert
                            showErrorAlert('Error', 'An error occurred while removing the event.');
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
                text: 'You are about to approve this event!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
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
                            // Show success alert and redirect to events page
                            showSuccessAlert('Event Approved', 'The event has been approved successfully.');
                        },
                        error: function() {
                            console.log('Error occurred while updating event status.');
                            // Show error alert
                            showErrorAlert('Error', 'An error occurred while approving the event.');
                        }
                    });
                }
            });
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
            // Check if status is provided
            if (status) {
                $.ajax({
                    url: 'event_fetch.php',
                    type: 'GET',
                    data: { status: status },
                    success: function(response) {
                        $('#eventDetailsTable tbody').html(response);
                        console.log('current status.', status);
                    },
                    error: function() {
                        console.log('Error occurred while fetching event details.');
                    }
                });
            }
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
        // $(document).on('click', '.event-details', function() {
        //     $(this).find('.additional-details').toggle(); // Toggle visibility of additional details
        // });
        $('.event-details').click(function() {
            $(this).find('.additional-details').toggle(); // Toggle visibility of additional details
        });

    });

</script>

