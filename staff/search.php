
<?php
    // Database connection file
    require_once '../database/con_db.php';

    // Check if the event_code parameter is set in the URL
    if (isset($_GET['event_code'])) {
        // Sanitize the input to prevent SQL injection
        $event_code = mysqli_real_escape_string($conn, $_GET['event_code']);

        // Prepare and execute the query to fetch event details by event_code
        $sql = "SELECT event_booking.*, facilities.facility_code,  facilities.facility_name
                FROM event_booking 
                INNER JOIN facilities ON event_booking.Facility_ID = facilities.facility_ID 
                WHERE event_booking.event_code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $event_code);
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
                    echo "<td>";
                        echo $row['event_name'] . '<br>' . 
                            $row['start_from'] . ' - ' . $row['end_to'] . '<br>' . 
                            $row['facility_code'] . ' - ' . '"' . $row['facility_name'] . '"';
                    echo "</td>";
                    echo "<td>" . $row['event_status'] . "</td>";
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
            echo "<tr><td colspan='4'>No events found with CODE: " . $event_code . "</td></tr>";
        }

        echo "</table>";

        // echo "<button class='return-button'>Return to All Events</button>";

        echo "<button class='return-button' onclick='goBack()'>Return <i class='fa-solid fa-right-from-bracket'></i></button>";



        // Close prepared statement and database connection
        $stmt->close();
    } else {
        echo "Please provide an event code for searching.";
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
        margin-left: 87.5%;
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
</script>