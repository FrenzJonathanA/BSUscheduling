<?php
// Include database connection or any necessary files
require __DIR__ . '/../database/con_db.php';

// Query to fetch facility options from the database
$query = "SELECT facility_ID, facility_code FROM facilities";
$result = mysqli_query($conn, $query);

// Check if query was successful
if ($result) {
    // Initialize an empty string to store the HTML options
    $options = '';

    // Loop through the results and create HTML options
    while ($row = mysqli_fetch_assoc($result)) {
        $facilityID = $row['facility_ID'];
        $facilityCode = $row['facility_code'];
        $options .= "<option value='$facilityID'>$facilityCode</option>";
    }

    // Output the options
    echo $options;
} else {
    // Handle errors if the query fails
    echo "<option value=''>Error fetching facility options</option>";
}

// Close database connection
mysqli_close($conn);
?>
