<?php
session_start();

// Include database connection
require '../includes/database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $serviceId = mysqli_real_escape_string($conn, $_POST['service_id']);
    $serviceName = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Validate form data (add your validation logic here)

    // Update the service in the database
    $updateQuery = "UPDATE air_condition_services SET service_name = '$serviceName', description = '$description', price = '$price' WHERE service_id = '$serviceId'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        $_SESSION["success_message"] = "Service updated successfully.";
    } else {
        $_SESSION["error_message"] = "Error: " . mysqli_error($conn);
    }

    // Redirect to the services management page
    header("Location: ../admin_services_management.php");
    exit;
} else {
    // Redirect if the form is not submitted
    header("Location: ../admin_services_management.php");
    exit;
}
?>
