<?php
session_start();

// Include database connection
require '../includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $user_id = $_POST["user_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"]; // Assuming you have a role field in your form

    // Sanitize user input to prevent SQL injection
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $role = mysqli_real_escape_string($conn, $role);

    // Update user in the database
    $update_query = "UPDATE users SET name='$name', email='$email', role='$role' WHERE user_id='$user_id'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        $_SESSION["success_message"] = "User updated successfully.";
    } else {
        $_SESSION["error_message"] = "Error updating user: " . mysqli_error($conn);
    }

    // Redirect back to user management page
    header("Location: ../staff_user_management.php");
    exit;
}
?>
