TODO: need to configure your mail server check mailtrap

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Validate form data (add more validation as needed)
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        // Handle validation errors
        $_SESSION["contact_error"] = "All fields are required.";
        header("Location: ../contact.php");
        exit;
    }

    $to = "your-email@example.com"; // Replace with your email address
    $headers = "From: $email";
    $message_body = "Name: $name\nEmail: $email\nSubject: $subject\n\n$message";

    if (mail($to, $subject, $message_body, $headers)) {
        // Email sent successfully
        $_SESSION["contact_success"] = "Your message has been sent successfully!";
        header("Location: ../contact.php");
        exit;
    } else {
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
