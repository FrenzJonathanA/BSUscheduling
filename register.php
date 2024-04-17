<?php

// Include database connection
include 'database/con_db.php';

// Include the verification code function
include 'send_verification_code.php';

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

// Perform validation
if(empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_pass) || empty($role) || empty($contact_number) || empty($department_ID)) {
    echo "All fields are required.";
    exit();
}

if($password!== $confirm_pass) {
    echo "Passwords do not match.";
    header('Location: registration.php');
    exit();
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if email is already in use
$sql = "SELECT COUNT(*) AS count FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if($row['count'] > 0){
    echo "Email is already in use.";
    header('Location: registration.php');
    exit();
}

// Generate a random verification code
$verification_code = rand(100000, 999999);

// Insert user data into the database
$sql = "INSERT INTO user (first_name, last_name, email,password, role, contact_number, verification_code, employee_ID, department_ID) 
        VALUES (?,?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $first_name, $last_name, $email, $hashed_password, $role, $contact_number, $verification_code, $employee_ID, $department_ID);

if ($stmt->execute()) {
    // Registration successful
    // Send verification code to user's email
    if (sendVerificationCode($email, $verification_code)) {
        // Redirect to verification page
        header('Location: verify_registration.php?email=' . urlencode($email));
    } else {
        // Show error message if email sending failed
        echo 'Error: Email sending failed.';
    }
} else {
    // Registration failed
    echo "Error: " . $stmt->error;
}

// Close database connection
$stmt->close();
$conn->close();

?>