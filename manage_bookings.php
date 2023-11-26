<?php
// manage_bookings.php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Include database connection and functions
require 'includes/database.php';

// Function to generate pagination links
function generatePaginationLinks($currentPage, $totalPages, $baseUrl) {
    $paginationLinks = '';

    // Previous page link
    if ($currentPage > 1) {
        $previousPage = $currentPage - 1;
        $previousLink = '<a href="' . $baseUrl . '=' . $previousPage . '">&laquo; Previous</a>';
        $paginationLinks .= $previousLink . '&nbsp;';
    }

    // Page number links
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            $paginationLinks .= '<strong>' . $i . '</strong>&nbsp;';
        } else {
            $pageLink = '<a href="' . $baseUrl . '=' . $i . '">' . $i . '</a>';
            $paginationLinks .= $pageLink . '&nbsp;';
        }
    }

    // Next page link
    if ($currentPage < $totalPages) {
        $nextPage = $currentPage + 1;
        $nextLink = '<a href="' . $baseUrl . '=' . $nextPage . '">Next &raquo;</a>';
        $paginationLinks .= $nextLink;
    }

    return $paginationLinks;
}

// Number of rows per page for managing bookings
$manageRowsPerPage = 10;

// Get the current page for managing bookings
$currentManagePage = isset($_GET['manage_page']) ? (int)$_GET['manage_page'] : 1;

// Calculate the offset for managing bookings SQL queries
$manageOffset = ($currentManagePage - 1) * $manageRowsPerPage;

// Query to retrieve all bookings for the user in descending order
$user_id = $_SESSION["user_id"];
$manageQuery = "SELECT * FROM bookings WHERE user_id = '$user_id' ORDER BY booking_date DESC LIMIT $manageRowsPerPage OFFSET $manageOffset";
$manageResult = mysqli_query($conn, $manageQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include("includes/head.php"); ?>
    <title>Manage Bookings</title>
</head>
<body>
    <?php include("includes/nav.php"); ?>

    <!-- Manage Bookings Section -->
    <div class="container mt-5">
        <h1>Manage Bookings</h1>

            <!-- message section -->
        <?php

        if (isset($_SESSION['edit_error'])) {
            echo '<div class="alert alert-danger" role="alert">';
            echo $_SESSION['edit_error'];
            echo '</div>';
            unset($_SESSION['edit_error']);
        }

        if (isset($_SESSION['edit_success'])) {
            echo '<div class="alert alert-success" role="alert">';
            echo $_SESSION['edit_success'];
            echo '</div>';
            unset($_SESSION['edit_success']);
        }

        if ($manageResult && mysqli_num_rows($manageResult) > 0) {
            echo '<table class="table">';
            echo '<thead><tr><th>Date</th><th>Time</th><th>Service</th><th>Address</th><th>Special Request</th><th>Status</th><th>Action</th></tr></thead>';
            echo '<tbody>';
            while ($booking = mysqli_fetch_assoc($manageResult)) {
                echo '<tr>';
                echo '<td>' . $booking['booking_date'] . '</td>';
                echo '<td>' . $booking['booking_time'] . '</td>';
                echo '<td>' . $booking['service_type'] . '</td>';
                echo '<td>' . $booking['address'] . '</td>';
                echo '<td>' . $booking['special_request'] . '</td>';
                echo '<td>' . $booking['status'] . '</td>';
                echo '<td>';
                echo '<a href="edit_booking.php?id=' . $booking['booking_id'] . '" class="btn btn-primary btn-sm">Edit</a>';
                echo '&nbsp;';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';

            // Display pagination links
            $manageTotalPages = ceil(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookings WHERE user_id = '$user_id'")) / $manageRowsPerPage);
            echo ($manageTotalPages > 1) ? generatePaginationLinks($currentManagePage, $manageTotalPages, 'manage_bookings.php?manage_page') : '';
        } else {
            echo '<p>No bookings found.</p>';
        }
        ?>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
