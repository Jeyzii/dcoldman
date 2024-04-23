<?php
session_start();
include("includes/database.php");

// Check if the user is logged in and has otp_status = 1
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["otp_status"]) || $_SESSION["otp_status"] != 1) {
    // Redirect to the login page if not logged in or otp_status is not 1
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Feedback</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <?php include("includes/head.php"); ?>
    <!-- Add your CSS styles here -->
    <style>
        /* Style for star rating */
        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            text-align: center;
            position: relative;
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
            color: #ccc;
        }

        .rating>input:checked~label,
        .rating>input:checked~label:hover,
        .rating>input:checked~label:hover~label {
            color: #fdd835;
        }

        /* Optional style for form container */
        .feedback-form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        /* Adjust submit button width */
        .btn-submit {
            width: 100%;
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

    <!-- Feedback Form -->
    <div class="container py-5">
        <div class="feedback-form">
            <h2 class="text-center mb-4">Feedback Form</h2>
            <form action="backend/submit_feedback_form.php" method="post">
                <input type="hidden" name="booking_id" value="<?php echo $_GET['booking_id']; ?>">
                <div class="form-group">
                    <label for="booking_feedback">Booking Feedback:</label>
                    <textarea class="form-control" id="booking_feedback" name="booking_feedback" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="booking_rating">Booking Rating:</label>
                    <div class="rating">
                        <input type="radio" id="star5" name="booking_rating" value="5">
                        <label for="star5">★</label>
                        <input type="radio" id="star4" name="booking_rating" value="4">
                        <label for="star4">★</label>
                        <input type="radio" id="star3" name="booking_rating" value="3">
                        <label for="star3">★</label>
                        <input type="radio" id="star2" name="booking_rating" value="2">
                        <label for="star2">★</label>
                        <input type="radio" id="star1" name="booking_rating" value="1">
                        <label for="star1">★</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="manpower_feedback">Manpower Feedback:</label>
                    <textarea class="form-control" id="manpower_feedback" name="manpower_feedback" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="manpower_rating">Manpower Rating:</label>
                    <div class="rating">
                        <input type="radio" id="mstar5" name="manpower_rating" value="5">
                        <label for="mstar5">★</label>
                        <input type="radio" id="mstar4" name="manpower_rating" value="4">
                        <label for="mstar4">★</label>
                        <input type="radio" id="mstar3" name="manpower_rating" value="3">
                        <label for="mstar3">★</label>
                        <input type="radio" id="mstar2" name="manpower_rating" value="2">
                        <label for="mstar2">★</label>
                        <input type="radio" id="mstar1" name="manpower_rating" value="1">
                        <label for="mstar1">★</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-submit">Submit Feedback</button>
            </form>
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
