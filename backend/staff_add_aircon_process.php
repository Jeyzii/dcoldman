<?php
session_start();
require '../includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    if (!empty($_POST['name']) && !empty($_POST['info']) && !empty($_POST['price'])) {
        // Sanitize form data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $info = mysqli_real_escape_string($conn, $_POST['info']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        
        // Insert data into the database
        $insertQuery = "INSERT INTO aircon_types (name, info, price) VALUES ('$name', '$info', '$price')";
        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION['success_message'] = "Aircon type added successfully!";
            header("Location: ../staff_add_aircon.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Error adding aircon: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error_message'] = "All fields are required!";
    }
} else {
    // Redirect if accessed directly
    header("Location: ../staff_add_aircon.php");
    exit;
}
?>
