<?php
session_start();

require '../../includes/database.php';

// Retrieve user data from the session
$user_id = $_SESSION["user_id"];

// Retrieve user input for OTP
$user_otp = $_POST['otp'];

// Query to check if the entered OTP is correct
$query = "SELECT * FROM users WHERE user_id = ? AND otp = ?";
$stmt = mysqli_prepare($conn, $query);

// Bind the parameters
mysqli_stmt_bind_param($stmt, "is", $user_id, $user_otp);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Check if the query was successful
if ($result && mysqli_num_rows($result) == 1) {
    // Fetch user data
    $user = mysqli_fetch_assoc($result);

    // Store user data in the session
    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["name"] = $user["name"];
    $_SESSION["role"] = $user["role"];
    $_SESSION["otp_status"] = $user["otp_status"];
    $_SESSION["availability"] = $user["availability"];

    // Clear the OTP in the database
    $update_query = "UPDATE users SET otp = NULL WHERE user_id = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "i", $user_id);
    mysqli_stmt_execute($update_stmt);

    // Redirect to the dashboard or home page
    $_SESSION["success_message"] = "Login successful.";
    header("Location: ../../index.php");
    exit;
} else {
    // Incorrect OTP, redirect to the login page
    $_SESSION["error_message"] = "Incorrect OTP. Please try again.";
    header("Location: ../../login.php");
    exit;
}
?>
