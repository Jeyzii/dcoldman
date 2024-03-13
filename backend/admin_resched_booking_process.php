<?php
session_start();

// Include database connection
require '../includes/database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve booking input
    $booking_id = $_POST["booking_id"];
    $booking_date = $_POST["booking_date"];
    $booking_time = $_POST["booking_time"];

    // Sanitize booking input to prevent SQL injection
    $booking_id = mysqli_real_escape_string($conn, $booking_id);
    $booking_date = mysqli_real_escape_string($conn, $booking_date);
    $booking_time = mysqli_real_escape_string($conn, $booking_time);

    // Update booking in the database
    $update_query = "UPDATE bookings SET booking_date='$booking_date', booking_time='$booking_time', status='pending' WHERE booking_id='$booking_id'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587 ;
        $mail->Username = 'dcoldmandcdv@gmail.com';
        $mail->Password = 'mffr qibt bkgb fdco';

        // Set sender and recipient
        $mail->setFrom("dcoldmandcdv@gmail.com", "Dcoldman");
        $mail->addAddress($_SESSION['email'], $_SESSION['name'] );

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Booking Rescheduled';
        $mail->Body = 'Your booking has been rescheduled. Click here to check your booking: <a href="localhost/aircon/user_dashboard.php">Check Booking</a>';

        // Send the email
        $mail->send();
        $_SESSION["success_message"] = "Booking rescheduled successfully.";
    } else {
        $_SESSION["error_message"] = "Error rescheduling booking: " . mysqli_error($conn);
    }

    // Redirect back to pending bookings management page
    header("Location: ../admin_pending_bookings_management.php");
    exit;
}
?>