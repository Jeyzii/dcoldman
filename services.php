<?php
    session_start();
    require 'includes/database.php'; // Include your database connection

    // Fetch data from the air_condition_services table
    $query = "SELECT * FROM air_condition_services";
    $result = mysqli_query($conn, $query);

    // Check if there are any services available
    if (mysqli_num_rows($result) > 0) {
        $services = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $services = []; // Initialize an empty array if no services found
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<title>Services</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="" name="keywords">
<meta content="" name="description">
    <?php 
        include("includes/head.php");
    ?>
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
            <h1 class="display-4 text-white animated slideInDown mb-4">Services</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Services</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Service Start -->
    <!-- dynamic list - from table -->
    
    <div class="container-xxl py-5"> 
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-6 mb-5">We Provide professional Heating & Cooling Services</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <?php foreach ($services as $service): ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item">
                        <!-- <img class="img-fluid" src="img/service-6.jpg" alt="service image"> -->
                            <div class="d-flex align-items-center bg-light">
                                <div class="service-icon flex-shrink-0 bg-primary">
                                    <img class="img-fluid" src="img/icon/icon-06-light.png" alt="service icon">
                                </div>
                                <a class="h4 mx-4 mb-0" a href="book_a_service.php"><?php echo $service['service_name'] . ' - ₱' . $service['price']; ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Static -->
    <!-- <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-6 mb-5">We Provide professional Heating & Cooling Services</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <img class="img-fluid" src="img/service-1.jpg" alt="">
                        <div class="d-flex align-items-center bg-light">
                            <div class="service-icon flex-shrink-0 bg-primary">
                                <img class="img-fluid" src="img/icon/icon-01-light.png" alt="">
                            </div>
                            <a class="h4 mx-4 mb-0" a href="book_a_service.php">AC Installation</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <img class="img-fluid" src="img/service-2.jpg" alt="">
                        <div class="d-flex align-items-center bg-light">
                            <div class="service-icon flex-shrink-0 bg-primary">
                                <img class="img-fluid" src="img/icon/icon-02-light.png" alt="">
                            </div>
                            <a class="h4 mx-4 mb-0" a href="book_a_service.php">Cooling Services</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item">
                        <img class="img-fluid" src="img/service-3.jpg" alt="">
                        <div class="d-flex align-items-center bg-light">
                            <div class="service-icon flex-shrink-0 bg-primary">
                                <img class="img-fluid" src="img/icon/icon-03-light.png" alt="">
                            </div>
                            <a class="h4 mx-4 mb-0" a href="book_a_service.php">Heating Services</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <img class="img-fluid" src="img/service-4.jpg" alt="">
                        <div class="d-flex align-items-center bg-light">
                            <div class="service-icon flex-shrink-0 bg-primary">
                                <img class="img-fluid" src="img/icon/icon-04-light.png" alt="">
                            </div>
                            <a class="h4 mx-4 mb-0" a href="book_a_service.php">Maintenance & Repair</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <img class="img-fluid" src="img/service-5.jpg" alt="">
                        <div class="d-flex align-items-center bg-light">
                            <div class="service-icon flex-shrink-0 bg-primary">
                                <img class="img-fluid" src="img/icon/icon-05-light.png" alt="">
                            </div>
                            <a class="h4 mx-4 mb-0" a href="book_a_service.php">Indoor Air Quality</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item">
                        <img class="img-fluid" src="img/service-6.jpg" alt="">
                        <div class="d-flex align-items-center bg-light">
                            <div class="service-icon flex-shrink-0 bg-primary">
                                <img class="img-fluid" src="img/icon/icon-06-light.png" alt="">
                            </div>
                            <a class="h4 mx-4 mb-0" a href="book_a_service.php">Annual Inspections</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div> -->
    <!-- Service End -->
    
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