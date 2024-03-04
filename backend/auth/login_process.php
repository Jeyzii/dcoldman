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

$mail = new PHPMailer(true);

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Sanitize user input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the query was successful
    if ($result) {
        // Check if a user with the provided email exists
        if (mysqli_num_rows($result) == 1) {
            // Fetch user data
            $user = mysqli_fetch_assoc($result);

            // Use password_verify to check if the entered password matches the stored hash
            if (password_verify($password, $user['password'])) {
                // Generate a random OTP and store it in the database
                $otp = rand(100000, 999999);
                $query = "UPDATE users SET otp = ?, otp_status = 1 WHERE user_id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "si", $otp, $user['user_id']);
                mysqli_stmt_execute($stmt);

                // Send OTP to user's email
                try {
                    //gmail
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Port = 587 ;
                    $mail->Username = 'dcoldmandcdv@gmail.com';
                    $mail->Password = 'mffr qibt bkgb fdco';
                    $mail->SMTPSecure = 'tls'; // Use TLS


                    // Set sender and recipient
                    $mail->setFrom("dcoldmandcdv@gmail.com", "Dcoldman");
                    $mail->addAddress($user['email'], $user['name']); // User's email and name

                    $mail->isHTML(true);
                    $mail->Subject = 'Login Verification Code';
                    $mail->Body    = 'Your verification code is: ' . $otp;

                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    exit;
                }

                // Redirect to the OTP verification page
                $_SESSION["user_id"] = $user["user_id"];
                header("Location: ../../otp_page.php");
                exit;
            } else {
                // Invalid credentials
                $_SESSION["error_message"] = "Invalid email or password.";
                header("Location: ../../login.php");
                exit;
            }
        } else {
            // User not found
            $_SESSION["error_message"] = "Invalid email or password.";
            header("Location: ../../login.php");
            exit;
        }
    } else {
        // Error in the query
        $_SESSION["error_message"] = "Error: " . mysqli_error($conn);
        header("Location: ../../login.php");
        exit;
    }

    // Close the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
