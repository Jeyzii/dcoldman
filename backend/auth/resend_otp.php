<?php
session_start();
require '../../includes/database.php';
require '../../vendor/autoload.php'; // Include Composer autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes and set up the mailer
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    // Retrieve user data
    $user_id = $_SESSION["user_id"];
    $email = $_SESSION["email"];

    // Generate a new OTP
    $otp = generateOTP(); // Implement your OTP generation logic

    // Update the OTP in the database
    $updateQuery = "UPDATE users SET otp = '$otp', otp_status = 0 WHERE user_id = $user_id";
    mysqli_query($conn, $updateQuery);

    // Send the new OTP to the user's email
    try {
        $mail = new PHPMailer(true);

        //gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587 ;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = 'tls'; // Use TLS


        // Set sender and recipient
        $mail->setFrom("dcoldmandcdv@gmail.com", "Dcoldman");
        $mail->addAddress($user['email'], $user['name']); // User's email and name

        $mail->isHTML(true);
        $mail->Subject = 'Resend OTP';
        $mail->Body = 'Your new OTP is: ' . $otp;

        $mail->send();
        $_SESSION["success_message"] = "New OTP sent successfully.";
        header("Location: otp_page.php");
        exit;
    } catch (Exception $e) {
        $_SESSION["error_message"] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location: otp_page.php");
        exit;
    }
} else {
    // User is not logged in, redirect to login page
    header("Location: ../../login.php");
    exit;
}

function generateOTP()
{
    // Replace this with your OTP generation logic
    return rand(100000, 999999);
}
?>
