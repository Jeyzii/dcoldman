<?php
session_start();

require '../../includes/database.php';

// Get the verification code from the URL
$verification_code = $_GET['code'];

// Update the user's verification status in the database
$sql = "UPDATE users SET verification_status = 1 WHERE verification_code = '$verification_code'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION["success_message"] = "Email verification successful. You can now login.";
    header("Location: ../../login.php");
    exit;
} else {
    $_SESSION["error_message"] = "Email verification failed. Please contact support.";
    header("Location: ../../login.php");
    exit;
}

mysqli_close($conn);
?>
