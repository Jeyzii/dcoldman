<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Include database connection and functions
require '../includes/database.php';

// Process booking form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $user_id = $_SESSION["user_id"];
    $client_name = $_POST["client_name"];
    $booking_date = $_POST["booking_date"];
    $booking_time = $_POST["booking_time"];
    $service_type = $_POST["service_type"];
    $address = $_POST["address"];
    $special_request = $_POST["special_request"];

    // Validate that the booking date is not in the past
    $currentDate = date("Y-m-d");
    if ($booking_date < $currentDate) {
        $errors[] = "Booking date cannot be in the past.";
    }

    // Validate that the booking time is within the allowed time frame (8 AM to 10 PM)
    $allowedStartTime = strtotime("08:00");
    $allowedEndTime = strtotime("22:00");
    $selectedTime = strtotime($booking_time);

    if ($selectedTime < $allowedStartTime || $selectedTime > $allowedEndTime) {
        $errors[] = "Booking time must be between 8 AM and 10 PM.";
    }

    if (empty($errors)) {
        // Sanitize user input to prevent SQL injection
        $booking_date = mysqli_real_escape_string($conn, $booking_date);
        $booking_time = mysqli_real_escape_string($conn, $booking_time);
        $service_type = mysqli_real_escape_string($conn, $service_type);
        $address = mysqli_real_escape_string($conn, $address);
        $special_request = mysqli_real_escape_string($conn, $special_request);

        // Check if there is already a booking for the selected service at the same time and date
        $existingBookingQuery = "SELECT * FROM bookings 
                                WHERE booking_date = '$booking_date' 
                                AND booking_time = '$booking_time'
                                AND service_type = '$service_type'
                                AND status != 'Cancelled'
                                AND status != 'reject'";

        $existingBookingResult = mysqli_query($conn, $existingBookingQuery);

        if (mysqli_num_rows($existingBookingResult) > 0) {
            // Booking already exists for the selected service at the same time and date
            $_SESSION['error'] = "You have already booked the selected service at the same time and date.";
            header("Location: ../admin_book_a_service.php");
            exit;
        } else {
            // Insert booking data into the database
            $query = "INSERT INTO bookings (user_id, client_name, booking_date, booking_time, service_type, address, special_request, status)
                        VALUES ('$user_id', '$client_name', '$booking_date', '$booking_time', '$service_type', '$address', '$special_request', 'Pending')";

            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if ($result) {
                // Booking successful
                $_SESSION['success'] = "Booking added successfully.";
                header("Location: ../admin_pending_bookings_management.php"); // Redirect to the user's dashboard
                exit;
            } else {
                // Error in the query
                $_SESSION['error'] = "Error adding booking: " . mysqli_error($conn);
                header("Location: ../admin_book_a_service.php");
                exit;
            }
        }
    } else {
        // Display validation errors
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: ../admin_book_a_service.php");
        exit;
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
