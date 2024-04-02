<?php
require __DIR__ . '/../database/con_db.php';

// Initialize the variable to avoid undefined variable warning
$search_department_code = '';

// Check if the search parameter is provided in the URL
if(isset($_GET['search_department_code'])) {
    // Get the search parameter from the URL
    $search_department_code = $_GET['search_department_code'];

    // Modify your SQL query to filter by department code
    $sql = "SELECT * FROM department WHERE department_code LIKE ?";
    $stmt = $conn->prepare($sql);

    // Bind the search parameter to the SQL query
    $search_param = '%' . $search_department_code . '%';
    $stmt->bind_param("s", $search_param);

    // Execute the SQL query
    $stmt->execute();
    $result = $stmt->get_result();

    // Output table headers
    echo "<table>";
    echo "<tr><th>Department Code</th><th>Department Name</th><th colspan='2'>Action</th></tr>";

    // Output search results
    if ($result->num_rows > 0) {
        foreach ($result as $department) {
            echo "<tr>";
            echo "<td>" . $department['department_code'] . "</td>";
            echo "<td>" . $department['department_name'] . "</td>";
            echo "<td><button class='edit-button' data-code='" . $department['department_code'] . "' data-id='" . $department['department_ID'] . "' data-name='" . $department['department_name'] . "'>Edit</button></td>";
            echo "<td><button class='remove-button' data-id='" . $department['department_ID'] . "'>Remove</button></td>";
            echo "</tr>";
        }
    } else {
        // No departments found
        echo "<tr><td colspan='3'>No departments found.</td></tr>";
    }

    echo "</table>";

    $stmt->close();
} else {
    // If no search parameter is provided, display all departments
    // Execute the SQL query to fetch all departments
    $sql = "SELECT * FROM department WHERE department_status = 'Active'";

    $result = $conn->query($sql);

    // Output table headers
    echo "<table>";
    echo "<tr><th>Department Code</th><th>Department Name</th><th colspan='2'>Action</th></tr>";

    // Output all departments
    if ($result->num_rows > 0) {
        foreach ($result as $department) {
            if($department['department_status'] == 'Active') {
                echo "<tr>";
                echo "<td>" . $department['department_code'] . "</td>";
                echo "<td>" . $department['department_name'] . "</td>";
                echo "<td><button class='edit-button' data-code='" . $department['department_code'] . "' data-id='" . $department['department_ID'] . "' data-name='" . $department['department_name'] . "'>Edit</button></td>";
                echo "<td><button class='remove-button' data-id='" . $department['department_ID'] . "'>Remove</button></td>";
                echo "</tr>";
            }
        }
    } else {
        // No departments found
        echo "<tr><td colspan='3'>No departments found.</td></tr>";
    }

    echo "</table>";
}

?>
