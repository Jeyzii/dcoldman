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
    $client_name = isset($_SESSION["name"]) ? $_SESSION["name"] : ""; // Check if the "name" key is set
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
            header("Location: ../book_a_service.php");
            exit;
        } else {
            // Calculate ETA using Google Maps Distance Matrix API
            $destination = urlencode($address); // Encode the destination address for the API

            // Specify the origin
            $origin = urlencode("782 Quirino Avenue Tambo, Parañaque 1308 Metro Manila Philippines");

            // Prepare the Distance Matrix API request URL
            // $apiUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origin&destinations=$destination&key=AIzaSyA08yFiEOhnLJ_CkSrkYDgHHNAROxsKHjs";

            $apiUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origin}&destinations={$destination}&key=AIzaSyA08yFiEOhnLJ_CkSrkYDgHHNAROxsKHjs";

            // Make a request to the Google Maps Distance Matrix API
            $response = file_get_contents($apiUrl);
            $data = json_decode($response, true);

            // Check if the API request was successful
            if ($data['status'] == 'OK' && isset($data['rows'][0]['elements'][0]['duration']['value'])) {
                // Extract the duration (ETA) from the API response
                $durationInSeconds = $data['rows'][0]['elements'][0]['duration']['value'];
                
                // Ensure $durationInSeconds is a valid integer
                if (is_numeric($durationInSeconds)) {
                    $etaDateTime = new DateTime("now", new DateTimeZone('UTC'));
                    $etaDateTime->setTimestamp(time() + $durationInSeconds);
                    $etaDateTime->setTimezone(new DateTimeZone('Asia/Manila')); // Replace 'Your_Timezone' with the actual timezone
                    $eta = $etaDateTime->format('h:i A');
                    
                } else {
                    $_SESSION['error'] = "Invalid ETA duration from the API.";
                    header("Location: ../book_a_service.php");
                    exit;
                }
                // Insert booking data into the database, including the calculated ETA
                $query = "INSERT INTO bookings (user_id, client_name, booking_date, booking_time, service_type, address, special_request, status, eta)
                            VALUES ('$user_id', '$client_name', '$booking_date', '$booking_time', '$service_type', '$address', '$special_request', 'Pending', '$eta')";

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
            } else {
                // Unable to retrieve ETA from the API
                $_SESSION['error'] = "Unable to calculate ETA.";
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
}

// Close the database connection
mysqli_close($conn);
?>
