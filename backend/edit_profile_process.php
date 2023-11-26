<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Include database connection
require '../includes/database.php';

// Retrieve updated user input
$user_id = $_SESSION["user_id"];
$name = mysqli_real_escape_string($conn, $_POST["name"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$contact_number = mysqli_real_escape_string($conn, $_POST["contact_number"]);

// Update user data in the database
$query = "UPDATE users SET name = '$name', email = '$email', contact_number = '$contact_number' WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Update session variables with new data
    $_SESSION["name"] = $name;
    $_SESSION["email"] = $email;

    // Redirect to the profile page with a success message
    $_SESSION["success_message"] = "Profile updated successfully.";
    header("Location: ../profile.php");
    exit;
} else {
    // Handle error
    $_SESSION["error_message"] = "Error: " . mysqli_error($conn);
    header("Location: edit_profile.php");
    exit;
}

// Close the database connection
mysqli_close($conn);
?>
