<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Include database connection and functions
require 'includes/database.php';

// Fetch services from the database
$services_query = "SELECT * FROM air_condition_services";
$services_result = mysqli_query($conn, $services_query);

// Check if the query was successful
if (!$services_result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/admin_nav.php"); ?>

    <div class="container mt-5">
                    <h2 class="mb-4">Add Booking</h2>
                    <?php
                    // Display error message if it exists
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }

                    // Display success message if it exists
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']);
                    }
                    ?>
                    <form action="backend/admin_book_a_service_process.php" method="post">
                        <div class="mb-3">
                            <label for="booking_date" class="form-label">Booking Date:</label>
                            <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="booking_time" class="form-label">Booking Time:</label>
                            <input type="time" class="form-control" id="booking_time" name="booking_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="client_name" class="form-label">Client Name:</label>
                            <input type="text" class="form-control" id="client_name" name="client_name" required>
                        </div>
                        <div class="mb-3">
                        <label for="service_type" class="form-label">Service Type:</label>
                                <select class="form-select" id="service_type" name="service_type" required>
                                    <option selected>Select Service Type</option>
                                    <?php
                                    // Loop through the services and create options
                                    while ($service = mysqli_fetch_assoc($services_result)) {
                                        echo '<option value="' . $service['service_name'] . '">' . $service['service_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>
                        <div class="mb-3">
                        <label for="special_request" class="form-label">Special Request:</label>
                            <textarea class="form-control" id="special_request" name="special_request"></textarea>
                            </div>
                        <button type="submit" class="btn btn-primary">Add booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Back to top
    include("includes/back-to-top.php");
    // JavaScript Libraries
    include("includes/scripts.php");
    // footer
    include("includes/footer.php");
    ?>
</body>

</html>
