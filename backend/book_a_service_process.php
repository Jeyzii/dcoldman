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
    $booking_date = $_POST["booking_date"];
    $booking_time = $_POST["booking_time"];
    $service_type = $_POST["service_type"];
    $address = $_POST["address"];
    $special_request = $_POST["special_request"];

    // Validate form fields (add your validation logic here)
    $errors = [];

    // Validate that the booking date is not in the past
    $currentDate = date("Y-m-d");
    if ($booking_date < $currentDate) {
        $errors[] = "Booking date cannot be in the past.";
    }

    // Validate that the booking time is not in the past for the current date
    if ($booking_date == $currentDate) {
        $currentTime = date("H:i");
        if ($booking_time < $currentTime) {
            $errors[] = "Booking time cannot be in the past for the current date.";
        }
    }

    if (empty($errors)) {
        // Sanitize user input to prevent SQL injection
        $booking_date = mysqli_real_escape_string($conn, $booking_date);
        $booking_time = mysqli_real_escape_string($conn, $booking_time);
        $service_type = mysqli_real_escape_string($conn, $service_type);
        $address = mysqli_real_escape_string($conn, $address);
        $special_request = mysqli_real_escape_string($conn, $special_request);

        // Calculate the start and end time for the 1-hour and 30-minute interval
        $intervalStartTime = date("H:i", strtotime("$booking_time -1 hour -30 minutes"));
        $intervalEndTime = date("H:i", strtotime("$booking_time +1 hour +30 minutes"));

        // Check if there is already a booking within the specified interval
        $existingBookingQuery = "SELECT * FROM bookings 
                                WHERE booking_date = '$booking_date' 
                                AND ('$booking_time' BETWEEN booking_time AND '$intervalEndTime'
                                    OR booking_time BETWEEN '$intervalStartTime' AND '$booking_time')
                                AND status != 'Cancelled'";

        $existingBookingResult = mysqli_query($conn, $existingBookingQuery);

        if (mysqli_num_rows($existingBookingResult) > 0) {
            // Booking already exists within the specified interval
            $_SESSION['error'] = "There is already a booking within the time frame.";
            header("Location: ../book_a_service.php");
            exit;
        } else {
            // Insert booking data into the database
            $query = "INSERT INTO bookings (user_id, booking_date, booking_time, service_type, address, special_request, status)
                        VALUES ('$user_id', '$booking_date', '$booking_time', '$service_type', '$address', '$special_request', 'Pending')";

            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if ($result) {
                // Booking successful
                $_SESSION['success'] = "Booking added successfully.";
                header("Location: ../user_dashboard.php"); // Redirect to the user's dashboard
                exit;
            } else {
                // Error in the query
                $_SESSION['error'] = "Error adding booking: " . mysqli_error($conn);
                header("Location: ../book_a_service.php");
                exit;
            }
        }
    } else {
        // Display validation errors
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: ../book_a_service.php");
        exit;
    }

    // Close the database connection
    mysqli_close($conn);
}
?>