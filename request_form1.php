
    <?php 

        $pageTitle = "Scheduling Form";
        
        include('header.php'); 
    
    ?>



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
                           // $sql = "SELECT facility_code FROM facilities";
                            $sql = "SELECT facility_ID, facility_code FROM facilities WHERE facility_status = 'available'";
                            $result = $conn->query($sql);

                            // Check if query was successful
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                   // echo "<option value='" . $row["facility_code"] . "'>" . $row["facility_code"] . "</option>";
                                    echo "<option value='" . $row["facility_ID"] . "'>" . $row["facility_code"] . "</option>";
                                }
                            } else {
                                echo "0 results";
                            }

                            // Close database connection
                            // $conn->close();
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="start-date">Start Date and Time:</label>
                        <input type="datetime-local" id="start-date" name="start_from" required>
                    </div>
                    <div class="form-group">
                        <label for="end-date">End Date and Time:</label>
                        <input type="datetime-local" id="end-date" name="end_to" required>
                    </div>
                    <div class="form-group">
                        <label for="participants">Participants:</label>
                        <input type="text" id="participants" name="participants" required>
                    </div>
                    <button type="submit">Submit</button>
                </form>
                <a href="cal-sample.php"><button type="submit">back to calendar</button></a>

            </div>
        </div>
    </div>
    <?php 
    include('./footer.php'); 
    ?>
</body>

</html>
