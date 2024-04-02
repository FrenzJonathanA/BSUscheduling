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
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['event_code'] . "</td>";
            echo "<td>" . $row['event_name'] . "<br>" . $row['start_from'] . " - " . $row['end_to'] . "<br>" . $row['facility_code'] . ' - "' . $row['facility_name'] . '"' . "</td>";
            echo "<td>" . $row['event_status'] . "</td>";
            echo "<td>";
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
        echo "<tr><td colspan='4'>No events found.</td></tr>";
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
</script>
