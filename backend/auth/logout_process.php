<?php
session_start();
require '../../includes/database.php';

// Retrieve user data from the session
$user_id = $_SESSION["user_id"];

// Update otp_status to 0 for the current user
$update_query = "UPDATE users SET otp_status = 0 WHERE user_id = $user_id";
mysqli_query($conn, $update_query);

// Clear all session variables
$_SESSION = [];
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ../../login.php");
exit;
?>
