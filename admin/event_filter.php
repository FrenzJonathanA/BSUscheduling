<?php
// Database connection file
require_once '../database/con_db.php';

// Check if the filter parameters are set
if (isset($_GET['filter-date']) || isset($_GET['facilitycode'])) {
    // Sanitize input to prevent SQL injection
    $filter_date = mysqli_real_escape_string($conn, $_GET['filter-date']);
    $facility_code = mysqli_real_escape_string($conn, $_GET['facilitycode']);

    // Construct the SQL query based on filter parameters
    $sql = "SELECT event_booking.*, facilities.facility_code, facilities.facility_name
            FROM event_booking
            INNER JOIN facilities ON event_booking.Facility_ID = facilities.facility_ID
            WHERE 1"; // Start with a basic WHERE clause

    // Add conditions based on filter parameters
    if (!empty($filter_date)) {
        $sql .= " AND event_booking.start_from >= '$filter_date'"; // Assuming start_from is the column storing event dates
    }
    if (!empty($facility_code)) {
        $sql .= " AND facilities.facility_code = '$facility_code'";
    }

    // Execute the query
    $result = $conn->query($sql);

    // Output the table rows
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
    echo "<tr><td colspan='4'><button class='return-button' onclick='goBack()'>Return <i class='fa-solid fa-right-from-bracket'></i></button></td></tr>";

} else {
    echo "<tr><td colspan='4'>Please provide filter parameters.</td></tr>";
}


?>

<style>
    .return-button {
        background-color: #008CBA;
        border: none;
        color: white;
        padding: 12px 13px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        font-weight: bold;
        margin-top: 5px;
        margin-left: 86.5%;
        border-radius: 4px;
        &:hover {
          background-color: #0073aa;
        }
        i{
          margin-left: 5px;
        }
    }
</style>
      
<script>
    function goBack() {
        window.history.back();
    }
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


    // Click event for displaying additional details
    // $(document).on('click', '.event-details', function()  {
    //     $(this).find('.additional-details').toggle(); // Toggle visibility of additional details
    // });
    $('.event-details').click(function() {
        $(this).find('.additional-details').toggle(); // Toggle visibility of additional details
    });
</script>
