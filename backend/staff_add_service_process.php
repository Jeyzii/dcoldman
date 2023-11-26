<?php
session_start();

// Include database connection
require '../includes/database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $serviceName = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Simple form validation
    if (empty($serviceName) || empty($price)) {
        $_SESSION["error_message"] = "Service name and price are required fields.";
        header("Location: ../staff_add_service.php");
        exit;
    }

    // Insert the new service into the database
    $insertQuery = "INSERT INTO air_condition_services (service_name, description, price) VALUES ('$serviceName', '$description', '$price')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        $_SESSION["success_message"] = "Service added successfully.";
    } else {
        $_SESSION["error_message"] = "Error: " . mysqli_error($conn);
    }

    // Redirect to the services management page
    header("Location: ../staff_services_management.php");
    exit;
} else {
    // Redirect if the form is not submitted
    header("Location: ../staff_services_management.php");
    exit;
}
?>
