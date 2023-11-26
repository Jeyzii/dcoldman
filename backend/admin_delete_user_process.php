<?php
session_start();

// Include database connection
require '../includes/database.php';

// Check if the user_id is provided in the URL
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    // Sanitize user input
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

    // Query to delete the user
    $deleteQuery = "DELETE FROM users WHERE user_id = '$user_id'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        $_SESSION["success_message"] = "User deleted successfully.";
    } else {
        $_SESSION["error_message"] = "Error deleting user: " . mysqli_error($conn);
    }
} else {
    $_SESSION["error_message"] = "Invalid user ID.";
}

// Redirect back to the user management page
header("Location: ../admin_user_management.php");
exit;
?>
