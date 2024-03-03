<?php
session_start();

// Include PHPMailer
require "../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST["name"];
    $emailAdd = $_POST["emailAdd"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Validate form data
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($emailAdd) || !filter_var($emailAdd, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email address is required.";
    }

    if (empty($subject)) {
        $errors[] = "Subject is required.";
    }

    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If there are validation errors, redirect back with error messages
    if (!empty($errors)) {
        $_SESSION["contact_error"] = implode(" ", $errors);
        header("Location: ../contact.php");
        exit;
    }

    // Create a new PHPMailer instance
    $mail = new PHPMailer();

    try {
        // Configure PHPMailer for SMTP
        //mailtrap
        // $mail->isSMTP();
        // $mail->Host = 'sandbox.smtp.mailtrap.io';
        // $mail->SMTPAuth = true;
        // $mail->Port = 2525;
        // $mail->Username = '0d0f86699ebb20';
        // $mail->Password = '21f305b79f60a1';

        //gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587 ;
        $mail->Username = 'dcoldmandcdv@gmail.com';
        $mail->Password = 'mffr qibt bkgb fdco';
        $mail->isHTML(true);

        // Set sender and recipient
        $mail->setFrom($emailAdd, $name);
        $mail->addAddress("dcoldmandcdv@gmail.com", "Dcoldman");

        // Set email subject and body
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();

        // Email sent successfully
        $_SESSION["contact_success"] = "Your message has been sent successfully!";
        header("Location: ../contact.php");
        exit;
    } catch (Exception $e) {
        // Error sending email
        $_SESSION["contact_error"] = "Oops! Something went wrong. Please try again later.";
        header("Location: ../contact.php");
        exit;
    }
} else {
    // Redirect to contact page if accessed directly
    header("Location: ../contact.php");
    exit;
}
?>
