<?php
session_start();
require 'includes/database.php';
require 'includes/staff_auth.php';
// Define the number of records per page
$recordsPerPage = 10;

// Determine the current page number
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the OFFSET for the SQL query
$offset = ($page - 1) * $recordsPerPage;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <?php include("includes/head.php"); ?>
    <!-- Include font-awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-d3L9/ATCV5T1OlCpG4IwPmOK51Gh3Ze9YucnN7Iuov1D1evSwMk/sFgU5X6j9kfo" crossorigin="anonymous">
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/staff_nav.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include("includes/staff_sidebar.php"); ?>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- resched Bookings and Validation Controls -->
                <h3>Reschedule Bookings</h3>
                <!-- Book a Service Button -->
                <div class="mb-3">
                    <a href="staff_book_a_service.php" class="btn btn-primary">Book a Service</a>
                </div>
                <?php
                // Fetch resched bookings with user information
                $reschedBookingsQuery = "SELECT bookings.*, users.name AS booker_name FROM bookings 
                                        INNER JOIN users ON bookings.user_id = users.user_id
                                        WHERE status = 'resched'
                                        LIMIT $recordsPerPage OFFSET $offset";
                $reschedBookingsResult = mysqli_query($conn, $reschedBookingsQuery);

                if ($reschedBookingsResult && mysqli_num_rows($reschedBookingsResult) > 0) {
                    echo '<table class="table">';
                    echo '<thead><tr><th>ID</th><th>Booker Name</th><th>Client Name</th><th>Service Type</th><th>Location</th><th>Date</th><th>Time</th><th>Actions</th></tr></thead>';
                    echo '<tbody>';

                    while ($reschedBooking = mysqli_fetch_assoc($reschedBookingsResult)) {
                        echo '<tr>';
                        echo '<td>' . $reschedBooking['booking_id'] . '</td>';
                        echo '<td>' . $reschedBooking['booker_name'] . '</td>';
                        echo '<td>' . $reschedBooking['client_name'] . '</td>';
                        echo '<td>' . $reschedBooking['service_type'] . '</td>';
                        echo '<td>' . $reschedBooking['address'] . '</td>';
                        echo '<td>' . $reschedBooking['booking_date'] . '</td>';
                        echo '<td>' . $reschedBooking['booking_time'] . '</td>';
                        echo '<td>
                        <a href="backend/staff_approve_booking_process.php?booking_id=' . $reschedBooking['booking_id'] . '" class="btn btn-success btn-sm">Approve</a>
                        <a href="backend/staff_resched_booking.php?booking_id=' . $reschedBooking['booking_id'] . '" class="btn btn-info btn-sm text-white">Reschedule</a>
                        </td>';
                        // <a href="backend/staff_reject_booking_process.php?booking_id=' . $reschedBooking['booking_id'] . '" class="btn btn-danger btn-sm">Reject</a>

                        echo '</tr>';
                    }

                    echo '</tbody></table>';

                    // Pagination links
                    $totalPagesQuery = "SELECT COUNT(*) as total FROM bookings WHERE status = 'resched'";
                    $totalPagesResult = mysqli_query($conn, $totalPagesQuery);
                    $totalPages = ceil(mysqli_fetch_assoc($totalPagesResult)['total'] / $recordsPerPage);

                    echo '<nav aria-label="Page navigation example">
                            <ul class="pagination">';

                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                                <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                            </li>';
                    }

                    echo '</ul></nav>';
                } else {
                    echo '<p>No resched bookings found.</p>';
                }
                ?>
            </main>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
