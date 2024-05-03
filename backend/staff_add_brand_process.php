<?php
session_start();
require '../includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    if (!empty($_POST['brand']) && !empty($_POST['price'])) {
        // Sanitize form data
        $brand = mysqli_real_escape_string($conn, $_POST['brand']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        
        // Insert data into the database
        $insertQuery = "INSERT INTO aircon_brands (brand, price) VALUES ('$brand', '$price')";
        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION['success_message'] = "Aircon brand added successfully!";
            header("Location: ../staff_add_brand.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Error adding aircon: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error_message'] = "All fields are required!";
    }
} else {
    // Redirect if accessed directly
    header("Location: ../staff_add_brand.php");
    exit;
}
?>
