
<?php 
    $pageTitle = "Event Search";
    include('header.php'); 
?>
<link rel="stylesheet" href="scss/style.css"> 
<div class="search">
    <div class="container">
        <div class="search-wrapper">
            <div class="title">
                <h2>Event Details</h2>
            </div>

        <?php
            // Database connection file
            require_once 'database/con_db.php';

            // Check if the event_code parameter is set in the URL
            if (isset($_GET['event_code'])) {
                // Sanitize the input to prevent SQL injection
                $event_code = mysqli_real_escape_string($conn, $_GET['event_code']);

                // Prepare and execute the query to fetch event details by event_code
                $sql = "SELECT event_booking.*, facilities.facility_code,  facilities.facility_name, facilities.building_loc
                        FROM event_booking 
                        INNER JOIN facilities ON event_booking.Facility_ID = facilities.facility_ID 
                        WHERE event_booking.event_code = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $event_code);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if any matching event is found
                if ($result->num_rows > 0) {
                    // Output table headers
                    echo "<table id='eventDetailsTable' style='width: 100%; border-collapse: collapse;'>
                        <tr>
                            <th>Details</th>
                            <th>Values</th>
                        </tr>";
                    
                    // Display event details in table format
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>Event Code:</td>";
                        echo "<td>" . $row['event_code'] . "</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Event Name:</td>";
                        echo "<td class='event-name'>" . '"' . $row['event_name'] . '"' . "</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Event Purpose:</td>";
                        echo "<td class='event-purpose'>" . $row['event_purpose'] . "</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Event Duration:</td>";
                        echo "<td>" . $row['start_from'] . ' - ' . $row['end_to'] . "</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Participants:</td>";
                        echo "<td>" . $row['participants'] . "</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Status:</td>";
                        echo "<td class='status'>" . $row['event_status'] . "</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Event Facility:</td>";
                        echo "<td class='facility'>" . $row['facility_name'] .' - ' . $row['building_loc'] . " <button class='navigate-button' id='navigate-" . $row['event_ID'] . "' onclick='openMap(" . $row['event_ID'] . ")'>Navigate</button></td>";
                        echo "</tr>";
                        
                    }

                    echo "</table>"; // Close the table
                } else {
                    echo "<table id='eventDetailsTable' style='width: 100%; border-collapse: collapse;'>
                            <tr>
                                <td colspan='2' style='text-align:center;'>No event found with the provided event code.</td>
                            </tr>
                        </table>";
                }

                // Close prepared statement and database connection
                $stmt->close();
            } else {
                echo "Please provide an event code for searching.";
            }
        ?>

        <button class="return-button" onclick="goBack()">Return <i class="fa-solid fa-right-from-bracket"></i></button>
        
        <script>

            function openMap(id) {
                var mapUrl = 'http://192.168.18.39:5173/';
                if (id) {
                mapUrl += '?id=' + id;
                }
                window.open(mapUrl, '_blank');
            }

            function goBack() {
            window.history.back();
            }
            </script>
        </div>


    </div>
</div>


<?php 
include('footer.php'); 
?>


</body>
</html>