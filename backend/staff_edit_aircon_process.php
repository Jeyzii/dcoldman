<?php
session_start();

// Include database connection
require '../includes/database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $info = mysqli_real_escape_string($conn, $_POST['info']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Validate form data (add your validation logic here)

    // Update the service in the database
    $updateQuery = "UPDATE aircon_types SET name = '$name', info = '$info', price = '$price' WHERE id = '$id'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        $_SESSION["success_message"] = "Aircon updated successfully.";
    } else {
        $_SESSION["error_message"] = "Error: " . mysqli_error($conn);
    }

    // Redirect to the aircon management page
    header("Location: ../staff_aircon_management.php");
    exit;
} else {
    // Redirect if the form is not submitted
    header("Location: ../staff_aircon_management.php");
    exit;
}
?>
