<?php 

    $pageTitle = "Scheduling Form";
    
    include('header.php'); 
?>
<link rel="stylesheet" href="scss/style.css"> 
<div class="request">
    <div class="container">
        <div class="req-wrapper">
            <h2>Scheduling Form</h2>
            <form id="schedule-form" action="request_sched.php" method="post">
                <div class="form-group">
                    <label for="event-name">Event Name:</label>
                    <input type="text" id="event-name" name="event_name" required>
                </div>
                <div class="form-group">
                    <label for="event-purpose">Event Purpose:</label>
                    <textarea id="event-purpose" name="event_purpose" required></textarea>
                </div>                    
                <div class="form-group">
                    <label for="facility">Facility:</label>
                    <select id="facility" name="facility_ID" required>
                        <option value="" disabled selected>Select Facility</option>
                        <?php
                        // Database connection file
                        require_once 'database/con_db.php';

                        // Fetch facility names from database
                        $sql = "SELECT facility_ID, facility_code FROM facilities WHERE facility_status = 'available'";
                        $result = $conn->query($sql);

                        // Check if query was successful
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["facility_ID"] . "'>" . $row["facility_code"] . "</option>";
                            }
                        } else {
                            echo "0 results";
                        }

                        // Close database connection
                        $conn->close();
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="start-date">Start Date and Time:</label>
                    <input type="datetime-local" id="start-date" name="start_from" required>
                    <script>
                        const unavailableSlots = <?php echo json_encode($unavailableSlots);?>;

                        document.getElementById('start-date').addEventListener('input', function() {
                            const facilityID = document.getElementById('facility').value;
                            const startDate = this.value;
                            const isValid = validateSlot(facilityID, startDate, 'start');
                            if (!isValid) {
                                alert('This time slot is unavailable. Please choose a different time.');
                                this.value = '';
                            }
                        });
                    </script>
                </div>
                <div class="form-group">
                    <label for="end-date">End Date and Time:</label>
                    <input type="datetime-local" id="end-date" name="end_to" required>
                    <script>
                        document.getElementById('end-date').addEventListener('input', function() {
                            const facilityID = document.getElementById('facility').value;
                            const endDate = this.value;
                            const isValid = validateSlot(facilityID, endDate, 'end');
                            if (!isValid) {
                                alert('This time slot is unavailable. Please choose a different time.');
                                this.value = '';
                            }
                        });
                    </script>
                </div>
                <div class="form-group">
                    <label for="participants">Participants:</label>
                    <input type="text" id="participants" name="participants" required>
                </div>
                
            </form>
            <div class="req-button">
                <a href=""><button type="submit">Submit</button></a>
                <a href="cal-sample.php"><button type="submit">View Calendar</button></a>
            </div>
        </div>
    </div>
</div>


<?php 
include('./footer.php'); 
?>

<script>
    function validateSlot(facilityID, date, type) {
        const unavailableSlotsForFacility = unavailableSlots[facilityID];
        if (unavailableSlotsForFacility) {
            for (const slot of unavailableSlotsForFacility) {
                const startFrom = slot[0];
                const endTo = slot[1];
                if (type === 'start' && date >= startFrom && date < endTo) {
                    return false;
                } else if (type === 'end' && date > startFrom && date <= endTo) {
                    return false;
                }
            }
        }
        return true;
    }
    document.getElementById('schedule-form').addEventListener('submit', function(event) {
        event.preventDefault();

        // Retrieve form data
        const eventName = document.getElementById('event-name').value;
        const eventPurpose = document.getElementById('event-purpose').value;
        const facilityID = document.getElementById('facility').value;
        const startDateStr = document.getElementById('start-date').value;
        const endDateStr = document.getElementById('end-date').value;
        const participants = document.getElementById('participants').value;

        // Convert start_date and end_date strings to valid DateTime objects
        const startDate = DateTime::createFromFormat('Y-m-d\TH:i', startDateStr);
        const endDate = DateTime::createFromFormat('Y-m-d\TH:i', endDateStr);

        // Check if DateTime objects were successfully created
        if (startDate && endDate) {
            // Add 30 minutes to the end time
            endDate.add(new DateInterval('PT30M'));
            const endDateStr = endDate.format('Y-m-d\TH:i');

            // Format DateTime objects into MySQL datetime format
            const startDateMySQL = startDate.format('Y-m-d H:i:s');
            const endDateMySQL = endDate.format('Y-m-d H:i:s');

            // Check if the selected time slot is available
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'request_sched.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200 && xhr.responseText === 'Error: This time slot is unavailable. Please choose a different time.') {
                    alert(xhr.responseText);
                } else if (xhr.status === 200) {
                    alert(xhr.responseText);
                    document.getElementById('schedule-form').reset();
                } else {
                    console.log('Error: ' + xhr.statusText);
                }
            };
            xhr.send('event_name=' + eventName + '&event_purpose=' + eventPurpose + '&facility_ID=' + facilityID + '&start_from=' + startDateMySQL + '&end_to=' + endDateMySQL + '&participants=' + participants);
        } else {
            console.log('Error: Invalid date format');
        }
    });
</script>