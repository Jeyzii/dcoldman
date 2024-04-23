<?php
session_start();
include("includes/database.php");

// Check if the user is logged in and has otp_status = 1
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["otp_status"]) || $_SESSION["otp_status"] != 1) {
    $loggedIn = false;
} else {
    $loggedIn = true;
    // Assuming you have a query to fetch user details from the database
    $user_id = $_SESSION["user_id"];
    $getUserQuery = "SELECT name FROM users WHERE user_id = '$user_id'";
    $userResult = mysqli_query($conn, $getUserQuery);
    
    // Check if the query was successful
    if ($userResult) {
        $user = mysqli_fetch_assoc($userResult);
        $name = $user['name'];
    } else {
        // Handle the error or provide a default name
        $name = "Unknown User";
    }
}

// Handle feedback form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && $loggedIn) {
    $user_id = $_SESSION["user_id"];
    $feedback = mysqli_real_escape_string($conn, $_POST["feedback"]);

    // Insert feedback into the database
    $insertQuery = "INSERT INTO feedbacks (user_id, name, feedback) VALUES ('$user_id', '$name', '$feedback')";
    mysqli_query($conn, $insertQuery);

    // Redirect to the same page to show the feedback immediately
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}

// Fetch feedbacks from the database
$feedbacksQuery = "SELECT users.name, feedbacks.feedback, feedbacks.feedback_id, feedbacks.user_id AS feedback_author_id,
                    feedbacks.booking_feedback, feedbacks.manpower_feedback, feedbacks.booking_rating, feedbacks.manpower_rating
                    FROM feedbacks 
                    INNER JOIN users ON feedbacks.user_id = users.user_id";
$feedbacksResult = mysqli_query($conn, $feedbacksQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Feedbacks</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <?php include("includes/head.php"); ?>
    <style>
        /* Style for star rating */
        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            text-align: center;
            position: relative;
            display: inline-block;
        }

        .rating>input {
            display: none;
        }

        .rating>label {
            display: inline-block;
            width: 1.1em;
            font-size: 2rem;
            margin: 0;
            padding: 0;
            cursor: pointer;
            color: #fdd835;
        }

        .rating>input:checked~label,
        .rating>input:checked~label:hover,
        .rating>input:checked~label:hover~label {
            color: #fdd835;
        }
    </style>
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
    </div>
    <!-- Page Header End -->

    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <!-- Display feedback form if the user is logged in -->
            <?php if ($loggedIn) : ?>
                <div class="row g-5">
                    <div class="col-lg-3 d-none d-lg-block"></div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="mb-3">
                                <label for="feedback" class="form-label">Your Feedback:</label>
                                <textarea class="form-control" id="feedback" name="feedback" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                        </form>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block"></div>
                </div>
            <?php endif; ?>

            <!-- Display feedbacks -->
            <div class="row g-5">
                <div class="col-lg-3 d-none d-lg-block"></div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="owl-carousel testimonial-carousel">
                        <?php foreach ($feedbacksResult as $feedback) : ?>
                            <div class="testimonial-item text-center">
                                <h5><?= $feedback['name'] ?></h5>
                                <hr>
                                <?php if (!empty($feedback['feedback'])) : ?>
                                    <div class="mb-3">
                                        <label class="form-label"><strong style="font-size: 1.5em;">Feedback:</strong></label>
                                        <p class="fs-5"><?= $feedback['feedback'] ?></p>
                                    </div>
                                <?php endif; ?>
                                <hr>
                                <?php if (!empty($feedback['booking_feedback'])) : ?>
                                    <div class="mb-3">
                                        <label class="form-label"><strong style="font-size: 1.5em;">Booking Feedback:</strong></label>
                                        <p class="fs-5"><?= $feedback['booking_feedback'] ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($feedback['booking_rating'])) : ?>
                                    <div class="mb-3">
                                        <label class="form-label"><strong style="font-size: 1.5em;">Booking Rating:</strong></label>
                                        <div class="rating">
                                            <?php
                                            $bookingRating = $feedback['booking_rating'];
                                            $i = 1;
                                            while ($i <= $bookingRating) {
                                                echo '<label>★</label>';
                                                $i++;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <hr>
                                <?php if (!empty($feedback['manpower_feedback'])) : ?>
                                    <div class="mb-3">
                                        <label class="form-label"><strong style="font-size: 1.5em;">Manpower Feedback:</strong></label>
                                        <p class="fs-5"><?= $feedback['manpower_feedback'] ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($feedback['manpower_rating'])) : ?>
                                    <div class="mb-3">
                                        <label class="form-label"><strong style="font-size: 1.5em;">Manpower Rating:</strong></label>
                                    <div class="rating">
                                            <?php
                                            $bookingRating = $feedback['manpower_rating'];
                                            $i = 1;
                                            while ($i <= $bookingRating) {
                                                echo '<label>★</label>';
                                                $i++;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
                <div class="col-lg-3 d-none d-lg-block"></div>
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
