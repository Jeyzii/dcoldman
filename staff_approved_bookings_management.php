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
    <title>staff Dashboard</title>
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
                <!-- Approved Bookings -->
                <h3>Approved Bookings</h3>
                <?php
                // Fetch approved bookings with user information
                $approvedBookingsQuery = "SELECT bookings.*, users.name AS booker_name 
                                            FROM bookings 
                                            INNER JOIN users ON bookings.user_id = users.user_id
                                            WHERE bookings.status = 'approved' 
                                            AND bookings.user_approval = '1' 
                                            AND bookings.management_approval = '1'
                                            LIMIT $recordsPerPage OFFSET $offset";

                $approvedBookingsResult = mysqli_query($conn, $approvedBookingsQuery);

                if ($approvedBookingsResult && mysqli_num_rows($approvedBookingsResult) > 0) {
                    echo '<table class="table">';
                    echo '<thead><tr><th>ID</th><th>Booker Name</th><th>Client Name</th><th>Service Type</th><th>Location</th><th>Date</th><th>Time</th><th>Actions</th></tr></thead>';
                    echo '<tbody>';

                    while ($approvedBooking = mysqli_fetch_assoc($approvedBookingsResult)) {
                        echo '<tr>';
                        echo '<td>' . $approvedBooking['booking_id'] . '</td>';
                        echo '<td>' . $approvedBooking['booker_name'] . '</td>';
                        echo '<td>' . $approvedBooking['client_name'] . '</td>';
                        echo '<td>' . $approvedBooking['service_type'] . '</td>';
                        echo '<td>' . $approvedBooking['address'] . '</td>';
                        echo '<td>' . $approvedBooking['booking_date'] . '</td>';
                        echo '<td>' . $approvedBooking['booking_time'] . '</td>';
                        echo '<td>
                        <a href="backend/staff_done_booking_process.php?booking_id=' . $approvedBooking['booking_id'] . '" class="btn btn-success btn-sm">Done</a>
                        <a href="backend/staff_cancel_booking_process.php?booking_id=' . $approvedBooking['booking_id'] . '" class="btn btn-danger btn-sm">Cancel</a>
                        </td>';
                        echo '</tr>';
                    }

                    echo '</tbody></table>';

                    // Pagination links
                    $totalPagesQuery = "SELECT COUNT(*) as total FROM bookings WHERE status = 'approved' AND user_approval = '1' AND management_approval = '1'";
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
                    echo '<p>No approved bookings found.</p>';
                }
                ?>
            </main>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
