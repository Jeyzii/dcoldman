<?php
session_start();
require '../includes/database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

if (isset($_GET['booking_id']) && is_numeric($_GET['booking_id'])) {
    $bookingId = $_GET['booking_id'];

    // Update the booking status to 'approved'
    $update_query = "UPDATE bookings SET booking_date='$booking_date', booking_time='$booking_time', status='pending' WHERE booking_id='$booking_id'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Fetch user details
        $getUserQuery = "SELECT u.email, u.name FROM bookings b INNER JOIN users u ON b.user_id = u.user_id WHERE b.booking_id = $bookingId";
        $userResult = mysqli_query($conn, $getUserQuery);
        $userRow = mysqli_fetch_assoc($userResult);

        if ($userRow) {
            $userEmail = $userRow['email'];
            $userName = $userRow['name'];


            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Port = 587 ;
            $mail->Username = 'dcoldmandcdv@gmail.com';
            $mail->Password = 'mffr qibt bkgb fdco';

            // Set sender and recipient
            $mail->setFrom("dcoldmandcdv@gmail.com", "Dcoldman");
            $mail->addAddress($userEmail, $userName);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Booking Rescheduled';
            $mail->Body = 'Your booking has been Rescheduled. Click here to check your booking: <a href="localhost/aircon/user_dashboard.php">Check Booking</a>';


            // Send the email
            $mail->send();

            $_SESSION['success'] = "Booking Rescheduled'.";
        } else {
            $_SESSION['error'] = "User not found or invalid booking ID.";
        }
    } else {
        $_SESSION['error'] = "Error approving booking: " . mysqli_error($conn);
    }
} else {
    $_SESSION['error'] = "Invalid booking ID.";
}

header("Location: ../staff_pending_bookings_management.php");
exit;
?>
