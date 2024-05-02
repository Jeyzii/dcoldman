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

    // Get all users with role = 'manpower', availability = 2, and booking_reference_id of the booking
    $manpowerQuery = "SELECT * FROM users WHERE role = 'manpower' AND availability = 3 AND booking_reference_id = '$bookingId'";
    $manpowerQueryResult = mysqli_query($conn, $manpowerQuery);

    if ($manpowerQueryResult) {
        //Update the availability to 1 and booking_reference_id to null for these users
        while ($row = mysqli_fetch_assoc($manpowerQueryResult)) {
            $userIdManpower = $row['user_id'];
            $updateQueryManpower = "UPDATE users SET availability = 1, booking_reference_id = NULL WHERE user_id = $userIdManpower";
            $updateResultManpower = mysqli_query($conn, $updateQueryManpower);

            // Insert into manpower_time_entries
            $insertQuery = "INSERT INTO manpower_time_entries (user_id, name, status, time_now) VALUES ('$userIdManpower', '$userNameManpower', 'available', NOW())";
            mysqli_query($conn, $insertQuery);
            
            if (!$updateResultManpower) {
                $_SESSION['error'] = "Error updating user: " . mysqli_error($conn);
            }
        }
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }

    // Update the booking status to 'done'
    $updateQuery = "UPDATE bookings SET status = 'done' WHERE booking_id = $bookingId";
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
            $mail->Subject = 'Booking done';
            $mail->Body = 'Your booking is done. Click here to check your booking status: <a href="localhost/aircon/user_dashboard.php">Check Booking</a>
                            <br>
                            Your booking is done. Click here to give feedback: <a href="localhost/aircon/feedback_form.php?booking_id=' . $bookingId . '">Give Feedback</a>';

            // Send the email
            $mail->send();

            $_SESSION['success'] = "Booking done.";
        } else {
            $_SESSION['error'] = "User not found or invalid booking ID.";
        }
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }
} else {
    $_SESSION['error'] = "Invalid booking ID.";
}

header("Location: ../staff_approved_bookings_management.php");
exit;
?>
