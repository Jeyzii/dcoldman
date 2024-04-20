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
    $total_manpower = mysqli_real_escape_string($conn, $_POST['total_manpower']);

    // Simple form validation
    if (empty($serviceName) || empty($price) || empty($total_manpower)) {
        $_SESSION["error_message"] = "Please fil up the required fields.";
        header("Location: ../admin_add_service.php");
        exit;
    }

    // Insert the new service into the database
    $insertQuery = "INSERT INTO air_condition_services (service_name, description, price, total_manpower) VALUES ('$serviceName', '$description', '$price', '$total_manpower')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        $_SESSION["success_message"] = "Service added successfully.";
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
