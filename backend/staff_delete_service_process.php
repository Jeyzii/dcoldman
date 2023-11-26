<?php
session_start();

// Include database connection
require '../includes/database.php';

// Check if the service ID is provided in the URL
if (isset($_GET['id'])) {
    $serviceId = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete the service from the database
    $deleteQuery = "DELETE FROM air_condition_services WHERE service_id = '$serviceId'";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {
        $_SESSION["success_message"] = "Service deleted successfully.";
    } else {
        $_SESSION["error_message"] = "Error: " . mysqli_error($conn);
    }
} else {
    $_SESSION["error_message"] = "Service ID not provided.";
}

// Redirect to the services management page
header("Location: ../staff_services_management.php");
exit;
?>
