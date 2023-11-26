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
    <meta charset="utf-8">
    <title>Add Booking</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <?php include("includes/head.php"); ?>
</head>

<body>
    <?php
    // Spinner
    include("includes/spinner.php");

    // Navbar
    include("includes/nav.php");
    ?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-4 text-white animated slideInDown mb-4">Add Booking</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Booking</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container position-relative wow fadeInUp" data-wow-delay="0.1s" style="margin-top: -6rem;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light text-center p-5">
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
                    <h1 class="mb-4">Add Booking</h1>
                    <form action="backend/book_a_service_process.php" method="post">

                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label for="booking_date" class="form-label">Booking Date:</label>
                                <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="booking_time" class="form-label">Booking Time:</label>
                                <input type="time" class="form-control" id="booking_time" name="booking_time" required>
                            </div>
                            <div class="col-12 col-sm-6">
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
                            <div class="col-12">
                                <label for="address" class="form-label">Address:</label>
                                <textarea class="form-control" id="address" name="address" required></textarea>
                            </div>
                            <div class="col-12">
                                <label for="special_request" class="form-label">Special Request:</label>
                                <textarea class="form-control" id="special_request" name="special_request"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100 py-3" type="submit">Add Booking</button>
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
