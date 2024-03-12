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
    $updateQuery = "UPDATE bookings SET status = 'approved', management_approval = '1' WHERE booking_id = $bookingId";
    $updateResult = mysqli_query($conn, $updateQuery);



    if ($updateResult) {
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
        $mail->Subject = 'Booking Approved';
        $mail->Body = 'Your booking has been approved. Click here to check your booking: <a href="localhost/aircon/user_dashboard.php">Check Booking</a>';

        // Send the email
        $mail->send();

        $_SESSION['success'] = "Booking approved successfully.";
    } else {
        $_SESSION['error'] = "Error approving booking: " . mysqli_error($conn);
    }
} else {
    $_SESSION['error'] = "Invalid booking ID.";
}

header("Location: ../staff_pending_bookings_management.php");
exit;
?>
