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
    $updateQuery = "UPDATE bookings SET status = 'pending', booking_date='$booking_date', booking_time='$booking_time' WHERE booking_id = $booking_id";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Fetch user details
        $getUserQuery = "SELECT u.email, u.name FROM bookings b INNER JOIN users u ON b.user_id = u.user_id WHERE b.booking_id = $booking_id";
        $userResult = mysqli_query($conn, $getUserQuery);
        $userRow = mysqli_fetch_assoc($userResult);

        if ($userRow) {
            $userEmail = $userRow['email'];
            $userName = $userRow['name'];

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Username = 'dcoldmandcdv@gmail.com';
            $mail->Password = 'mffr qibt bkgb fdco';

            // Set sender and recipient
            $mail->setFrom("dcoldmandcdv@gmail.com", "Dcoldman");
            $mail->addAddress($userEmail, $userName);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Booking Rescheduled';
            $mail->Body = 'Your booking has been rescheduled. Click here to check your booking: <a href="localhost/aircon/user_dashboard.php">Check Booking</a>';

            try {
                // Send the email
                $mail->send();
                $_SESSION['success'] = "Booking rescheduled. Email sent to $userEmail.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['error'] = "User not found or invalid booking ID.";
        }
    } else {
        $_SESSION['error'] = "Error approving booking: " . mysqli_error($conn);
    }
} else {
    $_SESSION['error'] = "Invalid booking ID.";
}

header("Location: ../admin_pending_bookings_management.php");
exit;
?>
