<?php
    session_start();

    // Include database connection
    require 'includes/database.php';
    require 'includes/manpower_auth.php';

    // Define the number of records per page
    $recordsPerPage = 10;

    // Determine the current page number
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

    // Calculate the OFFSET for the SQL query
    $offset = ($page - 1) * $recordsPerPage;

    // Fetch manpower time entries for the logged-in user with pagination
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM manpower_time_entries WHERE user_id = '$user_id' ORDER BY time_now DESC LIMIT $recordsPerPage OFFSET $offset";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $entries = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $totalEntries = count($entries);
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manpower Time Entries</title>
    <?php include("includes/head.php"); ?>
    <style>
    @media (max-width: 768px) {
        .booking-card {  /* Target the card with its unique class */
        width: 100%;  /* Make the card full width on smaller screens */
        }
    }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/manpower_nav.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="padding-bottom: 20px;">
                <h2>Manpower Dashboard</h2><hr>
                <div class="row">
                    <h3>Current Agenda</h3>
                    <!-- Display the bookings data -->
                    <?php
                        // Retrieve the user's ID from the session variable
                        $user_id = $_SESSION['user_id']; // Assuming you have stored the user's ID in a session variable

                        // Query to retrieve the booking reference ID for the user
                        $manpower_reference_booking_query = "SELECT booking_reference_id
                                                            FROM users 
                                                            WHERE user_id = '$user_id'";

                        // Execute the query to get the booking reference ID
                        $manpower_reference_booking_result = mysqli_query($conn, $manpower_reference_booking_query);

                        if ($manpower_reference_booking_result) {
                            // Fetch the booking reference ID
                            $row = mysqli_fetch_assoc($manpower_reference_booking_result);
                            $booking_reference_id = $row['booking_reference_id'];

                            // Query to retrieve booking information using the booking reference ID
                            $bookingQuery = "SELECT * 
                                                FROM bookings 
                                                WHERE booking_id = '$booking_reference_id'";

                            // Execute the query to get booking information
                            $bookingResult = mysqli_query($conn, $bookingQuery);

                            // Check if any booking is found for the user
                            if (mysqli_num_rows($bookingResult) > 0) {
                                // Loop through each booking and display its information
                                while ($bookingData = mysqli_fetch_assoc($bookingResult)) {
                        ?>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <div class="card border-0">
                                        <div class="card-body d-flex flex-wrap">
                                            <div class="col-lg-4 mb-4">
                                                <h6 style="font-size: 1.3rem; font-weight: bold;">Booking Details</h6>
                                                <ul style="font-size: 1.2rem;">
                                                    <li><b>Booking ID:</b> <?php echo $bookingData['booking_id']; ?></li>
                                                    <li><b>Booking Date:</b> <?php echo $bookingData['booking_date']; ?></li>
                                                    <li><b>Booking Time:</b> <?php echo $bookingData['booking_time']; ?></li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-4 mb-4">
                                                <h6 style="font-size: 1.3rem; font-weight: bold;">Service Details</h6>
                                                <ul style="font-size: 1.2rem;">
                                                    <li><b>Service Type:</b> <?php echo $bookingData['service_type']; ?></li>
                                                    <?php
                                                        // Query to get the price of the service type
                                                        $service_type = $bookingData['service_type'];
                                                        $service_type_price_query = "SELECT price FROM air_condition_services WHERE service_name = '$service_type'";
                                                        $service_type_price_result = mysqli_query($conn, $service_type_price_query);
                                                        if ($service_type_price_result && $service_type_price_row = mysqli_fetch_assoc($service_type_price_result)) {
                                                            $service_type_price = $service_type_price_row['price'];
                                                            echo '<li><b>Service Type Price:</b> ' . $service_type_price . '</li>';
                                                        }
                                                    ?>
                                                    <li><b>Aircon Type:</b> <?php echo $bookingData['aircon_type']; ?> <i class="fas fa-wind"></i></li>
                                                    <?php
                                                        // Query to get the price of the aircon type
                                                        $aircon_type = $bookingData['aircon_type'];
                                                        $aircon_type_price_query = "SELECT price FROM aircon_types WHERE name = '$aircon_type'";
                                                        $aircon_type_price_result = mysqli_query($conn, $aircon_type_price_query);
                                                        if ($aircon_type_price_result && $aircon_type_price_row = mysqli_fetch_assoc($aircon_type_price_result)) {
                                                            $aircon_type_price = $aircon_type_price_row['price'];
                                                            echo '<li><b>Aircon Type Price:</b> ' . $aircon_type_price . '</li>';
                                                        }
                                                    ?>
                                                    <li><b>Aircon Brand:</b> <?php echo $bookingData['aircon_brand']; ?> <i class="fas fa-wind"></i></li>
                                                    <?php
                                                        // Query to get the price of the aircon type
                                                        $aircon_brand = $bookingData['aircon_brand'];
                                                        $aircon_brand_price_query = "SELECT price FROM aircon_brands WHERE brand = '$aircon_brand'";
                                                        $aircon_brand_price_result = mysqli_query($conn, $aircon_brand_price_query);
                                                        if ($aircon_brand_price_result && $aircon_brand_price_row = mysqli_fetch_assoc($aircon_brand_price_result)) {
                                                            $aircon_brand_price = $aircon_brand_price_row['price'];
                                                            echo '<li><b>Aircon Type Price:</b> ' . $aircon_brand_price . '</li>';
                                                        }
                                                    ?>
                                                    <li><b>Total Amount:</b> <?php echo ($service_type_price ?? 0) + ($aircon_type_price ?? 0) + ($aircon_brand_price ?? 0); ?></li>
                                                    <?php
                                                        // Query to get the info of the aircon type
                                                        $aircon_type = $bookingData['aircon_type'];
                                                        $aircon_type_info_query = "SELECT info FROM aircon_types WHERE name = '$aircon_type'";
                                                        $aircon_type_info_result = mysqli_query($conn, $aircon_type_info_query);
                                                        if ($aircon_type_info_result && $aircon_type_info_row = mysqli_fetch_assoc($aircon_type_info_result)) {
                                                            $aircon_type_info = $aircon_type_info_row['info'];
                                                            echo '<li><b>Other Information:</b> ' . $aircon_type_info . '</li>';
                                                        }
                                                    ?>
                                                    <li><b>Special Request:</b> <?php echo $bookingData['special_request']; ?></li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-4 mb-4">
                                                <h6 style="font-size: 1.3rem; font-weight: bold;">Client Information</h6>
                                                <ul style="font-size: 1.2rem;">
                                                    <li><b>Client Name:</b> <?php echo $bookingData['client_name']; ?></li>
                                                    <li><b>Address:</b> <?php echo $bookingData['address']; ?></li>
                                                    <li><b>Estimated Time of Arrival (ETA):</b> <?php echo $bookingData['eta'].'min.'; ?></li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-4 mb-4">
                                                <h6 style="font-size: 1.3rem; font-weight: bold;">Manpower Involved</h6>
                                                <ul style="font-size: 1.2rem;">
                                                    <?php
                                                        // Retrieve the user's ID from the session variable
                                                        $user_id = $_SESSION['user_id'] ?? null;
                                                        if ($user_id !== null) {
                                                            // Query to retrieve the booking reference ID for the user
                                                            $booking_reference_query = "SELECT booking_reference_id FROM users WHERE user_id = '$user_id'";
                                                            $booking_reference_result = mysqli_query($conn, $booking_reference_query);
                                                            if ($booking_reference_result && $booking_reference_row = mysqli_fetch_assoc($booking_reference_result)) {
                                                                $booking_reference_id = $booking_reference_row['booking_reference_id'];
                                                                // Query to retrieve users with the same booking_reference_id
                                                                $users_query = "SELECT name FROM users WHERE booking_reference_id = '$booking_reference_id'";
                                                                $users_result = mysqli_query($conn, $users_query);
                                                                if ($users_result && mysqli_num_rows($users_result) > 0) {
                                                                    // Initialize a counter variable
                                                                    $loop_number = 1;
                                                                    // Loop through each user and display their name
                                                                    while ($user_row = mysqli_fetch_assoc($users_result)) {
                                                                        echo '<li><b>Manpower ' . $loop_number . ':</b> ' . $user_row['name'] . '</li>';
                                                                        // Increment the loop number
                                                                        $loop_number++;
                                                                    }
                                                                } else {
                                                                    echo '<li>No manpower involved for this booking reference.</li>';
                                                                }
                                                            } else {
                                                                echo '<li>No booking reference found for the user.</li>';
                                                            }
                                                        } else {
                                                            echo '<li>User ID not found.</li>';
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                                }
                            } else {
                                echo "No bookings found for this user.";
                            }
                        } else {
                            echo "Error retrieving booking reference ID: " . mysqli_error($conn);
                        }
                    ?>
                </div>
                <!-- Display information from the database -->
                <div class="row">
                    <h3>My availability status</h3>
                    <!-- Display the list of manpower time entries -->
                    <?php
                        if (isset($entries) && $totalEntries > 0) {
                            echo '<table class="table">';
                            echo '<thead><tr><th>No</th><th>Status</th><th>Time</th></tr></thead>';
                            echo '<tbody>';

                            $startIndex = ($page - 1) * $recordsPerPage + 1;

                            foreach ($entries as $index => $entry) {
                                // Determine the background color based on the availability status
                                $status = $entry['status'];

                                if ($status == 'available') {
                                    $bgColor = 'bg-success';
                                } elseif ($status == 'not available') {
                                    $bgColor = 'bg-danger';
                                } elseif ($status == 'ongoing') {
                                    $bgColor = 'bg-info';
                                }

                                // Format time to 12-hour format
                                $formattedTime = date('g:i A', strtotime($entry['time_now']));

                                $reversedIndex = $totalEntries - $startIndex - $index + 1;

                                echo '<tr class="' . $bgColor . ' text-white">';
                                echo '<td>' . $reversedIndex . '</td>';
                                // echo '<td>' . ($startIndex + $index) . '</td>';
                                // echo '<td>' . $entry['user_id'] . '</td>';
                                // echo '<td>' . $entry['name'] . '</td>';
                                echo '<td>' . $entry['status'] . '</td>';
                                echo '<td>' . $formattedTime . '</td>';
                                echo '</tr>';
                            }

                            echo '</tbody></table>';

                            // Display pagination links only if there are more entries
                            if ($totalEntries > $recordsPerPage) {
                                // Pagination links
                                $totalPages = ceil($totalEntries / $recordsPerPage);
                                echo '<nav aria-label="Page navigation example">
                                        <ul class="pagination">';

                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                                            <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                                        </li>';
                                }

                                echo '</ul></nav>';
                            }
                        } else {
                            // Display a message when no entries are found
                            echo '<div class="text-center" style="margin-top: 50px;">
                                    <p class="display-4">No entries found for the logged-in user.</p>
                                    </div>';
                        }
                    ?>
                </div>
            </main>
        </div>
    </div>
    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
