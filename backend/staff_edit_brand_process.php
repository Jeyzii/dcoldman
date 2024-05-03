<?php
session_start();

// Include database connection
require '../includes/database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Update the brand in the database
    $updateQuery = "UPDATE aircon_brands SET brand = '$brand', price = '$price' WHERE id = '$id'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        $_SESSION["success_message"] = "Aircon Brand updated successfully.";
    } else {
        $_SESSION["error_message"] = "Error: " . mysqli_error($conn);
    }

    // Redirect to the aircon brands management page
    header("Location: ../staff_brand_management.php");
    exit;
} else {
    // Redirect if the form is not submitted
    header("Location: ../staff_brand_management.php");
    exit;
}
?>
