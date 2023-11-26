<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Include database connection
require 'includes/database.php';

// Check if the booking ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_bookings.php");
    exit;
}

// Get the booking ID from the URL
$booking_id = $_GET['id'];

// Query to check if the booking exists and belongs to the logged-in user
$user_id = $_SESSION["user_id"];
$editQuery = "SELECT * FROM bookings WHERE user_id = '$user_id' AND booking_id = $booking_id";
$editResult = mysqli_query($conn, $editQuery);

// Check if the booking exists
if (!$editResult || mysqli_num_rows($editResult) === 0) {
    header("Location: manage_bookings.php");
    exit;
}

// Fetch booking details for pre-filling the form
$bookingDetails = mysqli_fetch_assoc($editResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("includes/head.php"); ?>
    <title>Edit Booking</title>
</head>
<body>
    <?php include("includes/nav.php"); ?>

    <!-- Edit Booking Form Section -->
    <div class="container mt-5">
        <h1>Edit Booking</h1>

        <form action="backend/edit_booking_process.php" method="post">
            <!-- Include input fields for editing booking details -->
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">

            <div class="mb-3">
                <label for="booking_date" class="form-label">Booking Date</label>
                <input type="date" class="form-control" id="booking_date" name="booking_date" value="<?php echo $bookingDetails['booking_date']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="booking_time" class="form-label">Booking Time</label>
                <input type="time" class="form-control" id="booking_time" name="booking_time" value="<?php echo $bookingDetails['booking_time']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="service_type" class="form-label">Service Type</label>
                <input type="text" class="form-control" id="service_type" name="service_type" value="<?php echo $bookingDetails['service_type']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $bookingDetails['address']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="special_request" class="form-label">Special Request</label>
                <input type="text" class="form-control" id="special_request" name="special_request" value="<?php echo $bookingDetails['special_request']; ?>">
            </div>

            <!-- ... Add other fields as needed -->

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
