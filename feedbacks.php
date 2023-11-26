<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<title>Feedbacks</title>
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
            <h1 class="display-4 text-white animated slideInDown mb-4">Feedbacks</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Feedbacks</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-6 mb-5">What They Say About Our Services</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="testimonial-left h-100">
                        <img class="img-fluid animated pulse infinite" src="img/Feedbacks-1.jpg" alt="">
                        <img class="img-fluid animated pulse infinite" src="img/Feedbacks-2.jpg" alt="">
                        <img class="img-fluid animated pulse infinite" src="img/Feedbacks-3.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="owl-carousel testimonial-carousel">
                        <div class="testimonial-item text-center">
                            <img class="img-fluid mx-auto mb-4" src="img/Feedbacks-1.jpg" alt="">
                            <p class="fs-5">I recently used your air conditioning services, and I must say I was impressed with the prompt and professional service. The technicians arrived on time, assessed the issue efficiently, and had the problem fixed in no time. The level of professionalism demonstrated by your team was truly commendable. Thank you for providing reliable and top-notch service!</p>
                            <h5>Client Name</h5>
                            <span>Mary</span>
                        </div>
                        <div class="testimonial-item text-center">
                            <img class="img-fluid mx-auto mb-4" src="img/Feedbacks-2.jpg" alt="">
                            <p class="fs-5">I want to express my appreciation for the excellent air conditioning service your company provided. The technicians displayed a high level of expertise, carefully diagnosing the issue with my AC unit and explaining the solution in a way that was easy to understand. The attention to detail in their work was evident, and it's clear that your team takes pride in delivering quality service. I will definitely be recommending your services to friends and family.</p>
                            <h5>Client Name</h5>
                            <span>Jack</span>
                        </div>
                        <div class="testimonial-item text-center">
                            <img class="img-fluid mx-auto mb-4" src="img/Feedbacks-3.jpg" alt="">
                            <p class="fs-5">I want to commend your company for its outstanding customer service. From the initial inquiry to the completion of the service, every interaction with your team was friendly, informative, and customer-focused. The staff went above and beyond to ensure my satisfaction, and it was a refreshing experience to work with a company that prioritizes customer care. I'm extremely pleased with the air conditioning service I received and will be a loyal customer in the future. Keep up the great work</p>
                            <h5>Client Name</h5>
                            <span>Carl</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="testimonial-right h-100">
                        <img class="img-fluid animated pulse infinite" src="img/Feedbacks-1.jpg" alt="">
                        <img class="img-fluid animated pulse infinite" src="img/Feedbacks-2.jpg" alt="">
                        <img class="img-fluid animated pulse infinite" src="img/Feedbacks-3.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
        
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