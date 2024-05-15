<?php
require __DIR__ . '/../database/con_db.php';

// Initialize the variable to avoid undefined variable warning
$search_facility_code = '';

// Check if the search parameter is provided in the URL
if(isset($_GET['search_facility_code'])) {
    // Get the search parameter from the URL
    $search_facility_code = $_GET['search_facility_code'];

    // Modify your SQL query to filter by facility code
    $sql = "SELECT * FROM facilities WHERE facility_code LIKE ? AND facility_status = 'available'";
    $stmt = $conn->prepare($sql);

    // Bind the search parameter to the SQL query
    $search_param = '%' . $search_facility_code . '%';
    $stmt->bind_param("s", $search_param);

    // Execute the SQL query
    $stmt->execute();
    $result = $stmt->get_result();

    // Output table headers
    echo "<table>";
    echo "<tr><th>Code</th><th>Name</th><th>Location</th><th>Capacity</th><th>Status</th><th colspan='2'>Action</th></tr>";

    // Output search results
    if ($result->num_rows > 0) {
        foreach ($result as $facility) {
            echo "<tr>";
            echo "<td>" . $facility['facility_code'] . "</td>";
            echo "<td>" . $facility['facility_name'] . "</td>";
            echo "<td>" . $facility['building_loc'] . "</td>";
            echo "<td>" . $facility['facility_capacity'] . "</td>";
            echo "<td>" . $facility['facility_status'] . "</td>";
            echo "<td><button class='edit-button' data-code='" . $facility['facility_code'] . "' data-id='" . $facility['facility_ID'] . "' data-name='" . $facility['facility_name'] . "' data-loc='" . $facility['building_loc'] . "' data-capacity='" . $facility['facility_capacity']  . "' >Edit</button></td>";
            echo "<td><button class='remove-button' data-id='" . $facility['facility_ID'] . "'>Remove</button></td>";
            echo "</tr>";
        }
    } else {
        // No Facilities found
        echo "<tr><td colspan='6'>No Facility found.</td></tr>";
    }

    echo "</table>";

    $stmt->close();
} else {
    // If no search parameter is provided, display all Facilities
    // Execute the SQL query to fetch all Facilities
    $sql = "SELECT * FROM facilities WHERE facility_status = 'available'";

    $result = $conn->query($sql);

    // Output table headers
    echo "<table>";
    echo "<tr><th>Code</th><th>Name</th><th>Location</th><th>Capacity</th><th>Status</th><th colspan='2'>Action</th></tr>";

    // Output search results
    if ($result->num_rows > 0) {
        foreach ($result as $facility) {
            echo "<tr>";
            echo "<td>" . $facility['facility_code'] . "</td>";
            echo "<td>" . $facility['facility_name'] . "</td>";
            echo "<td>" . $facility['building_loc'] . "</td>";
            echo "<td>" . $facility['facility_capacity'] . "</td>";
            echo "<td>" . $facility['facility_status'] . "</td>";
            echo "<td><button class='edit-button' data-code='" . $facility['facility_code'] . "' data-id='" . $facility['facility_ID'] . "' data-name='" . $facility['facility_name'] . "' data-loc='" . $facility['building_loc'] . "' data-capacity='" . $facility['facility_capacity']  . "' >Edit</button></td>";
            echo "<td><button class='remove-button' data-id='" . $facility['facility_ID'] . "'>Remove</button></td>";
            echo "</tr>";
        }
    } else {
        // No facilities found
        echo "<tr><td colspan='6'>No Facility found.</td></tr>";
    }

    echo "</table>";
}

?>


<!--?php
require __DIR__ . '/../database/con_db.php';

// Function to update facility status based on event bookings
function updateFacilityStatus($conn) {
    // Get the current datetime
    $currentDateTime = date('Y-m-d H:i:s');

    // Calculate 30 minutes before the current datetime
    $thirtyMinutesBefore = date('Y-m-d H:i:s', strtotime('-30 minutes', strtotime($currentDateTime)));

    // Calculate 10 minutes after the current datetime
    $tenMinutesAfter = date('Y-m-d H:i:s', strtotime('+10 minutes', strtotime($currentDateTime)));

    // Update facility status to 'reserved' for events starting within the next 30 minutes
    $sqlReserved = "UPDATE facilities SET facility_status = 'reserved' 
                    WHERE facility_code IN (SELECT facility_ID FROM event_booking 
                                            WHERE start_from BETWEEN ? AND ?)";
    $stmtReserved = $conn->prepare($sqlReserved);
    $stmtReserved->bind_param("ss", $currentDateTime, $thirtyMinutesBefore);
    $stmtReserved->execute();

    // Update facility status to 'available' for events that have already ended
    $sqlAvailable = "UPDATE facilities SET facility_status = 'available' 
                     WHERE facility_code IN (SELECT facility_ID FROM event_booking 
                                             WHERE end_to <= ?)";
    $stmtAvailable = $conn->prepare($sqlAvailable);
    $stmtAvailable->bind_param("s", $currentDateTime);
    $stmtAvailable->execute();

    // Close statements
    $stmtReserved->close();
    $stmtAvailable->close();
}

// Call the function to update facility status
updateFacilityStatus($conn);

// Initialize the variable to avoid undefined variable warning
$search_facility_code = '';

// Check if the search parameter is provided in the URL
if(isset($_GET['search_facility_code'])) {
    // Get the search parameter from the URL
    $search_facility_code = $_GET['search_facility_code'];

    // Modify your SQL query to filter by facility code
    $sql = "SELECT * FROM facilities WHERE facility_code LIKE ?";
    $stmt = $conn->prepare($sql);

    // Bind the search parameter to the SQL query
    $search_param = '%' . $search_facility_code . '%';
    $stmt->bind_param("s", $search_param);

    // Execute the SQL query
    $stmt->execute();
    $result = $stmt->get_result();

    // Output table headers
    echo "<table>";
    echo "<tr><th>Code</th><th>Name</th><th>Location</th><th>Capacity</th><th>Status</th><th colspan='2'>Action</th></tr>";

    // Output search results
    if ($result->num_rows > 0) {
        foreach ($result as $facility) {
            echo "<tr>";
            echo "<td>" . $facility['facility_code'] . "</td>";
            echo "<td>" . $facility['facility_name'] . "</td>";
            echo "<td>" . $facility['building_loc'] . "</td>";
            echo "<td>" . $facility['facility_capacity'] . "</td>";
            echo "<td>" . $facility['facility_status'] . "</td>";
            echo "<td><button class='edit-button' data-code='" . $facility['facility_code'] . "' data-id='" . $facility['facility_ID'] . "' data-name='" . $facility['facility_name'] . "' data-loc='" . $facility['building_loc'] . "' data-capacity='" . $facility['facility_capacity']  . "' >Edit</button></td>";
            echo "<td><button class='remove-button' data-id='" . $facility['facility_ID'] . "'>Remove</button></td>";
            echo "</tr>";
        }
    } else {
        // No Facilities found
        echo "<tr><td colspan='6'>No Facility found.</td></tr>";
    }

    echo "</table>";

    $stmt->close();
} else {
    // If no search parameter is provided, display all Facilities
    // Execute the SQL query to fetch all Facilities
    $sql = "SELECT * FROM facilities";

    $result = $conn->query($sql);

    // Output table headers
    echo "<table>";
    echo "<tr><th>Code</th><th>Name</th><th>Location</th><th>Capacity</th><th>Status</th><th colspan='2'>Action</th></tr>";

    // Output search results
    if ($result->num_rows > 0) {
        foreach ($result as $facility) {
            echo "<tr>";
            echo "<td>" . $facility['facility_code'] . "</td>";
            echo "<td>" . $facility['facility_name'] . "</td>";
            echo "<td>" . $facility['building_loc'] . "</td>";
            echo "<td>" . $facility['facility_capacity'] . "</td>";
            echo "<td>" . $facility['facility_status'] . "</td>";
            echo "<td><button class='edit-button' data-code='" . $facility['facility_code'] . "' data-id='" . $facility['facility_ID'] . "' data-name='" . $facility['facility_name'] . "' data-loc='" . $facility['building_loc'] . "' data-capacity='" . $facility['facility_capacity']  . "' >Edit</button></td>";
            echo "<td><button class='remove-button' data-id='" . $facility['facility_ID'] . "'>Remove</button></td>";
            echo "</tr>";
        }
    } else {
        // No facilities found
        echo "<tr><td colspan='6'>No Facility found.</td></tr>";
    }

    echo "</table>";
}

?-->
