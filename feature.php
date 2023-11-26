<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<title>Features</title>
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
            <h1 class="display-4 text-white animated slideInDown mb-4">Features</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Features</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
    
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