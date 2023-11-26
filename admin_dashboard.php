<?php
session_start();
require 'includes/database.php';
require 'includes/admin_auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include("includes/head.php"); ?>
    <!-- Include font-awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-d3L9/ATCV5T1OlCpG4IwPmOK51Gh3Ze9YucnN7Iuov1D1evSwMk/sFgU5X6j9kfo" crossorigin="anonymous">
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/admin_nav.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include("includes/admin_sidebar.php"); ?>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2>Admin Dashboard</h2>
                <!-- Display information from the database -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-users"></i> Total Users</h5>
                                <?php
                                $userCountQuery = "SELECT COUNT(*) AS user_count FROM users";
                                $userCountResult = mysqli_query($conn, $userCountQuery);

                                if ($userCountResult) {
                                    $userCount = mysqli_fetch_assoc($userCountResult)['user_count'];
                                    echo "<p class='card-text'>$userCount</p>";
                                } else {
                                    echo "Error fetching user information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-book"></i> Total Bookings</h5>
                                <?php
                                $bookingCountQuery = "SELECT COUNT(*) AS booking_count FROM bookings";
                                $bookingCountResult = mysqli_query($conn, $bookingCountQuery);

                                if ($bookingCountResult) {
                                    $bookingCount = mysqli_fetch_assoc($bookingCountResult)['booking_count'];
                                    echo "<p class='card-text'>$bookingCount</p>";
                                } else {
                                    echo "Error fetching booking information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-toolbox"></i> Total Services</h5>
                                <?php
                                $serviceCountQuery = "SELECT COUNT(*) AS service_count FROM air_condition_services";
                                $serviceCountResult = mysqli_query($conn, $serviceCountQuery);

                                if ($serviceCountResult) {
                                    $serviceCount = mysqli_fetch_assoc($serviceCountResult)['service_count'];
                                    echo "<p class='card-text'>$serviceCount</p>";
                                } else {
                                    echo "Error fetching service information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
