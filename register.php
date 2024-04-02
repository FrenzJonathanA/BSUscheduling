<?php
// Include database connection
include 'database/con_db.php';

// Get form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_pass = $_POST['confirm_pass'];
$role = $_POST['role'];
$contact_number = $_POST['contact_number'];
$employee_ID = $_POST['employee_ID'];
$department_ID = $_POST['department_ID'];

// Perform validation and database insertion (not included in this basic example)

// Insert user data into the database
$sql = "INSERT INTO user (first_name, last_name, email, password, role, contact_number, employee_ID, department_ID) 
        VALUES ('$first_name', '$last_name', '$email', '$password', '$role', '$contact_number', '$employee_ID', '$department_ID')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// After successful registration
// header("Location: login.php?registered=true");
header("Location: login_form.php");
exit(); // Make sure to exit after redirecting

?>
