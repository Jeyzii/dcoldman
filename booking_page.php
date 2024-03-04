<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Booking</title>
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
            <h1 class="display-4 text-white animated slideInDown mb-4">Booking</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Booking</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container position-relative wow fadeInUp" data-wow-delay="0.1s" style="margin-top: -6rem;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light text-center p-5">
                    <h1 class="mb-4">Book For A Service</h1>
                    <?php
                    // Check if the user is logged in and has otp_status = 1
                    if (isset($_SESSION["user_id"]) && isset($_SESSION["otp_status"]) && $_SESSION["otp_status"] == 1) {
                        // User is logged in and has otp_status = 1, show the "Book Now" button
                        echo '<a href="book_a_service.php" class="btn btn-primary w-100 py-3" type="submit">Book Now</a>';
                    } else {
                        // User is not logged in or otp_status is not 1, provide a message or redirect to the login page
                        echo '<p>Please <a href="login.php">login</a> to book a service.</p>';
                    }
                    ?>
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
