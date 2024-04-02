<?php
require __DIR__ . '/../database/con_db.php';

// Initialize the variable to avoid undefined variable warning
$search_device_name = '';

// Check if the search parameter is provided in the URL
if (isset($_GET['search_device_name'])) {
    // Get the search parameter from the URL
    $search_device_name = $_GET['search_device_name'];

    // Modify your SQL query to filter by device name
    $sql = "SELECT device.device_ID, device.device_name, device.facility_ID, facilities.facility_code 
    FROM device 
    INNER JOIN facilities ON device.facility_ID = facilities.facility_ID 
    WHERE device.device_name LIKE ? AND device.device_status = 'Active'";

    $stmt = $conn->prepare($sql);

    // Bind the search parameter to the SQL query
    $search_param = '%' . $search_device_name . '%';
    $stmt->bind_param("s", $search_param);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Output table headers
    echo "<table>";
    echo "<tr><th>Device name</th><th>Facility Code</th><th colspan='2'>Action</th></tr>";

    // Output search results
    if ($result->num_rows > 0) {
        while ($device = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $device['device_name'] . "</td>";
            echo "<td>" . $device['facility_code'] . "</td>";
            echo "<td><button class='edit-button' data-name='" . $device['device_name'] . "' data-id='" . $device['device_ID'] . "' data-fID='" .  $device['facility_ID']  . "' data-fcode='" . $device['facility_code'] . "'>Edit</button></td>";
            echo "<td><button class='remove-button' data-id='" . $device['device_ID'] . "'>Remove</button></td>";
            echo "</tr>";
        }
    } else {
        // No devices found
        echo "<tr><td colspan='4'>No devices found.</td></tr>";
    }

    echo "</table>";

    // Close the prepared statement
    $stmt->close();
} else {
    // If no search parameter is provided, display all devices
    // Execute the SQL query to fetch all devices
    // Modify your SQL query to filter by device name
    $sql = "SELECT device.device_ID, device.device_name, device.facility_ID, facilities.facility_code 
    FROM device 
    INNER JOIN facilities ON device.facility_ID = facilities.facility_ID 
    WHERE device.device_name LIKE ? AND device.device_status = 'Active'";

    $stmt = $conn->prepare($sql);

    // Bind the search parameter to the SQL query
    $search_param = '%' . $search_device_name . '%';
    $stmt->bind_param("s", $search_param);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Output table headers
    echo "<table>";
    echo "<tr><th>Device Name</th><th>Facility Code</th><th colspan='2'>Action</th></tr>";

    // Output all devices
    if ($result->num_rows > 0) {
        while ($device = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $device['device_name'] . "</td>";
            echo "<td>" . $device['facility_code'] . "</td>";
            echo "<td><button class='edit-button' data-name='" . $device['device_name'] . "' data-id='" . $device['device_ID'] . "' data-fID='" .  $device['facility_ID']  . "' data-fcode='" . $device['facility_code'] . "'>Edit</button></td>";
            echo "<td><button class='remove-button' data-id='" . $device['device_ID'] . "'>Remove</button></td>";
            echo "</tr>";
        }
    } else {
        // No devices found
        echo "<tr><td colspan='4'>No devices found.</td></tr>";
    }

    echo "</table>";

    // Close the prepared statement
    $stmt->close();
}
?>
