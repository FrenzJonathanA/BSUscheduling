<?php


// Start the session
session_start();

// Include database connection
include 'database/con_db.php';

// Include the verification code function
include 'send_verification_code.php';


//set random name for the image, used time() for uniqueness
$filename =  time() . '.jpg';
$filepath = 'static/facial_image';
if(!is_dir($filepath))
    mkdir($filepath);
if(isset($_FILES['webcam'])){    
    move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath.$filename);
}


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
$facial_image = $_POST['facial_image'];

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

// Generate a random verification code
$verification_code = rand(100000, 999999);

// Insert user data into the database
$sql = "INSERT INTO user (first_name, last_name, email,password, role, contact_number, verification_code, employee_ID, department_ID, camera_upload) 
        VALUES (?,?,?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $first_name, $last_name, $email, $password, $role, $contact_number, $verification_code, $employee_ID, $department_ID, $filename);

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