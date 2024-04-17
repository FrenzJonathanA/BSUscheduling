<?php
require_once 'db.php';

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$code = $_POST['code'];

// Update the user's password in the database
$query = "UPDATE user SET password =?, reset_code = NULL, reset_expiration = NULL WHERE reset_code =?";
$stmt = $db->prepare($query);
$stmt->bind_param("ss", $password, $code);
$stmt->execute();

// Redirect the user to the login page
header("Location: login.php");
exit;
?>