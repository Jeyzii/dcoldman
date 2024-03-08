<?php
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

// Number of rows per page
$rowsPerPage = 5;

// Get the current page
$currentPendingPage = isset($_GET['pending_page']) ? (int)$_GET['pending_page'] : 1;
$currentApprovedPage = isset($_GET['approved_page']) ? (int)$_GET['approved_page'] : 1;

// Calculate the offset for SQL queries
$pendingOffset = ($currentPendingPage - 1) * $rowsPerPage;
$approvedOffset = ($currentApprovedPage - 1) * $rowsPerPage;

// Query to retrieve pending bookings for the user in descending order
$user_id = $_SESSION["user_id"];

$pendingQuery = "SELECT * FROM bookings WHERE user_id = '$user_id' AND status = 'Pending' ORDER BY booking_date DESC LIMIT $rowsPerPage OFFSET $pendingOffset";
$approvedQuery = "SELECT * FROM bookings WHERE user_id = '$user_id' AND status = 'Approved' ORDER BY booking_date DESC LIMIT $rowsPerPage OFFSET $approvedOffset";


$pendingResult = mysqli_query($conn, $pendingQuery);
$approvedResult = mysqli_query($conn, $approvedQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <?php include("includes/nav.php"); ?>

    <!-- Book a New Service Section -->
    <div class="container mt-5">
    <h1>User's Dashboard</h1>
<?php if ($_SESSION['role'] == 'user') { ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Total Manpower Available</h5>
                    <?php
                    $availableManpowerCountQuery = "SELECT COUNT(*) AS available_manpower_count FROM users WHERE availability = 1";
                    $availableManpowerCountResult = mysqli_query($conn, $availableManpowerCountQuery);

                    if ($availableManpowerCountResult) {
                        $availableManpowerCount = mysqli_fetch_assoc($availableManpowerCountResult)['available_manpower_count'];
                        echo "<p class='card-text'>$availableManpowerCount</p>";
                    } else {
                        echo "Error fetching available manpower information.";
                    }
                    ?>
            </div>
        </div>
    </div><br>
<?php               }?>
        <h3>Book a New Service</h3>
        <p>Click the button below to book a new service:</p>
        <a href="book_a_service.php" class="btn btn-primary mb-4">Book Now</a>

        <a href="manage_bookings.php" class="btn btn-success mb-4">Manage Bookings</a>
        
        <!-- Pending Bookings Section -->
        <div class="mt-4">
            <h3>Pending Bookings</h3>
            <?php
            if ($pendingResult && mysqli_num_rows($pendingResult) > 0) {
                echo '<table class="table">';
                echo '<thead><tr><th style="width: 150px;">Date</th><th style="width: 150px;">Time</th><th>Service</th><th>Address</th><th>Special Request</th><th>Estimated Wait Time (in minutes)</th><th>Status</th></tr></thead>';
                echo '<tbody>';
                while ($booking = mysqli_fetch_assoc($pendingResult)) {
                    echo '<tr>';
                    echo '<td>' . $booking['booking_date'] . '</td>';
                    echo '<td>' . date('h:i A', strtotime($booking['booking_time'])) . '</td>';
                    echo '<td>' . $booking['service_type'] . '</td>';
                    echo '<td>' . $booking['address'] . '</td>';
                    echo '<td>' . $booking['special_request'] . '</td>';
                    echo '<td>' . $booking['eta'] . ' Min.' . '</td>';
                    echo '<td>' . $booking['status'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';

                // Display pagination links
                $pendingTotalPages = ceil(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookings WHERE user_id = '$user_id' AND status = 'Pending'")) / $rowsPerPage);
                echo ($pendingTotalPages > 1) ? generatePaginationLinks($currentPendingPage, $pendingTotalPages, 'user_dashboard.php?pending_page') : '';
            } else {
                echo '<p>No pending bookings found.</p>';
            }
            ?>
        </div>

        <!-- Approved Bookings Section -->
        <div class="mt-4">
            <h3>Approved Bookings</h3>
            <?php
            if ($approvedResult && mysqli_num_rows($approvedResult) > 0) {
                echo '<table class="table">';
                echo '<thead><tr><th>Date</th><th>Time</th><th>Service</th><th>Address</th><th>Special Request</th><th>Estimated Time of Arrival</th><th>Status</th></tr></thead>';
                echo '<tbody>';
                while ($booking = mysqli_fetch_assoc($approvedResult)) {
                    echo '<tr>';
                    echo '<td>' . $booking['booking_date'] . '</td>';
                    echo '<td>' . $booking['booking_time'] . '</td>';
                    echo '<td>' . $booking['service_type'] . '</td>';
                    echo '<td>' . $booking['address'] . '</td>';
                    echo '<td>' . $booking['special_request'] . '</td>';
                    echo '<td>' . $booking['eta'] . '</td>';
                    echo '<td>' . $booking['status'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';

                // Display pagination links
                $approvedTotalPages = ceil(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookings WHERE user_id = '$user_id' AND status = 'Approved'")) / $rowsPerPage);
                echo ($approvedTotalPages > 1) ? generatePaginationLinks($currentApprovedPage, $approvedTotalPages, 'user_dashboard.php?approved_page') : '';
            } else {
                echo '<p>No approved bookings found.</p>';
            }
            ?>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>