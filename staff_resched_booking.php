<?php
session_start();
require 'includes/database.php';
require 'includes/staff_auth.php';

// Check if booking_id is provided in the URL
if (isset($_GET['booking_id'])) {
    $booking_id = mysqli_real_escape_string($conn, $_GET['booking_id']);

    // Query to retrieve booking information
    $query = "SELECT * FROM bookings WHERE booking_id = '$booking_id' AND status = 'resched' OR status = 'pending'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);
    } else {
        $_SESSION["error_message"] = "Booking not found.";
        header("Location: staff_resched_bookings.php");
        exit;
    }
} else {
    $_SESSION["error_message"] = "Booking ID not provided.";
    header("Location: staff_resched_bookings.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/staff_nav.php"); ?>

    <div class="container mt-5">
        <h2>Reschedule Booking</h2>

        <!-- Display error message if any -->
        <?php
        if (isset($_SESSION["error_message"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["error_message"] . '</div>';
            unset($_SESSION["error_message"]);
        }
        ?>

        <!-- Booking Edit Form -->
        <form action="backend/staff_resched_booking_process.php" method="post">
            <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
            <div class="mb-3">
                <label for="client_name" class="form-label">Client Name:</label>
                <input type="text" class="form-control" id="client_name" name="client_name" value="<?php echo $booking['client_name']; ?>" required disabled>
            </div>
            <div class="mb-3">
                <label for="service_type" class="form-label">Service Type:</label>
                <input type="text" class="form-control" id="service_type" name="service_type" value="<?php echo $booking['service_type']; ?>" required disabled>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Location:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $booking['address']; ?>" required disabled>
            </div>
            <div class="mb-3">
                <label for="booking_date" class="form-label">Date:</label>
                <input type="date" class="form-control" id="booking_date" name="booking_date" value="<?php echo $booking['booking_date']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="booking_time" class="form-label">Time:</label>
                <input type="time" class="form-control" id="booking_time" name="booking_time" value="<?php echo $booking['booking_time']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
