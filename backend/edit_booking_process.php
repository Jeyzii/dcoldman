<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

// Include database connection
require '../includes/database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $booking_id = $_POST['booking_id'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $service_type = $_POST['service_type'];
    $address = $_POST['address'];
    $special_request = $_POST['special_request'];

    // Update booking details in the database
    $updateQuery = "UPDATE bookings SET ";
    $updateQuery .= "booking_date = '$booking_date', ";
    $updateQuery .= "booking_time = '$booking_time', ";
    $updateQuery .= "service_type = '$service_type', ";
    $updateQuery .= "address = '$address', ";
    $updateQuery .= "special_request = '$special_request' ";
    $updateQuery .= "WHERE booking_id = $booking_id";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Set success message and redirect back to the manage bookings page after editing
        $_SESSION['edit_success'] = "Booking edited successfully.";
        header("Location: ../manage_bookings.php");
        exit;
    } else {
        // Set error message and redirect back to the edit booking page
        $_SESSION['edit_error'] = "Error editing booking. Please try again.";
        header("Location: ../edit_booking.php?id=$booking_id");
        exit;
    }
} else {
    // If the form is not submitted, redirect to the manage bookings page
    header("Location: ../manage_bookings.php");
    exit;
}
?>
