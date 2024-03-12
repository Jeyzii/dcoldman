<?php
session_start();

require '../../includes/database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

// Check if email already exists in database
$email = $_POST['email'];
$sql = "SELECT email FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Email already exists, set error message and redirect back to signup page
    $_SESSION["error_message"] = "Email already exists. Please use a different email address.";
    header("Location: signup.php");
    exit;
}

// Insert new user into database
$name = $_POST['name'];
$contact_number = $_POST['contact_number'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$terms_agreement = isset($_POST['terms_agreement']) ? 1 : 0;
$verification_code = md5(uniqid(rand(), true));

$sql = "INSERT INTO users (name, email, contact_number, password, terms_agreement, verification_code) VALUES ('$name', '$email', '$contact_number', '$hashed_password', '$terms_agreement', '$verification_code')";

if (mysqli_query($conn, $sql)) {
    // User registration successful, send verification email
    $mail = new PHPMailer(true);

    try {
        //gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587 ;
        $mail->Username = 'dcoldmandcdv@gmail.com';
        $mail->Password = 'mffr qibt bkgb fdco';

        // Set sender and recipient
        $mail->setFrom("dcoldmandcdv@gmail.com", "Dcoldman");
        $mail->addAddress($email, $name );

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body = 'Click the following link to verify your email: <a href="localhost/aircon/backend/auth/verify_process.php?code=' . $verification_code . '">Verify Email</a>';

        // Send the email
        $mail->send();

        $_SESSION["success_message"] = "Registration successful. Please check your email for verification.";
        header("Location: ../../login.php");
        exit;
    } catch (Exception $e) {
        $_SESSION["error_message"] = "Registration failed. Please try again.";
        header("Location: ../../signup.php");
        exit;
    }
} else {
    // Registration failed, set error message and redirect back to signup page
    $_SESSION["error_message"] = "Registration failed. Please try again.";
    header("Location: ../../signup.php");
    exit;
}

mysqli_close($conn);
?>
