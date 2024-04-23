<?php
session_start();
require '../includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (!empty($_POST['booking_feedback']) && !empty($_POST['booking_rating']) && !empty($_POST['manpower_feedback']) && !empty($_POST['manpower_rating'])) {
        // Sanitize input data
        $bookingId = mysqli_real_escape_string($conn, $_POST['booking_id']);
        $bookingFeedback = mysqli_real_escape_string($conn, $_POST['booking_feedback']);
        $bookingRating = mysqli_real_escape_string($conn, $_POST['booking_rating']);
        $manpowerFeedback = mysqli_real_escape_string($conn, $_POST['manpower_feedback']);
        $manpowerRating = mysqli_real_escape_string($conn, $_POST['manpower_rating']);
        
        // Get user_id and booking_id from session or database, assuming they are available in session
        $userId = $_SESSION['user_id']; // Assuming user_id is stored in session
        $name = $_SESSION['name']; // Assuming user_id is stored in session
        
        // Insert feedback into database
        $insertQuery = "INSERT INTO feedbacks (user_id, name, booking_id, booking_feedback, manpower_feedback, booking_rating, manpower_rating, created_at) 
                        VALUES ('$userId', '$name', '$bookingId', '$bookingFeedback', '$manpowerFeedback', '$bookingRating', '$manpowerRating', NOW())";
        
        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION['success'] = "Feedback submitted successfully!";
            header("Location: ../feedbacks.php"); // Redirect to success page
            exit;
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "All fields are required!";
    }
} else {
    // Redirect to the feedback form page if accessed directly
    header("Location: ../feedback_form.php");
    exit;
}
?>