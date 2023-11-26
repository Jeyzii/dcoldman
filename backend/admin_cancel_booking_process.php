<?php
session_start();
require '../includes/database.php';

if (isset($_GET['booking_id']) && is_numeric($_GET['booking_id'])) {
    $bookingId = $_GET['booking_id'];

    // Update the booking status to 'approved'
    $updateQuery = "UPDATE bookings SET status = 'cancel' WHERE booking_id = $bookingId";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        $_SESSION['success'] = "Booking cancelled successfully";
    } else {
        $_SESSION['error'] = "Error approving booking: " . mysqli_error($conn);
    }
} else {
    $_SESSION['error'] = "Invalid booking ID.";
}

header("Location: ../admin_pending_bookings_management.php");
exit;
?>
