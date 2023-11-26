<?php
session_start();

require '../../includes/database.php';

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

$sql = "INSERT INTO users (name, email, contact_number, password, terms_agreement) VALUES ('$name', '$email', '$contact_number', '$hashed_password', '$terms_agreement')";

if (mysqli_query($conn, $sql)) {
    // User registration successful, redirect to login page
    $_SESSION["success_message"] = "Registration successful. Please login to continue.";
    header("Location: ../../login.php");
    exit;
} else {
    // Registration failed, set error message and redirect back to signup page
    $_SESSION["error_message"] = "Registration failed. Please try again.";
    header("Location: ../../signup.php");
    exit;
}

mysqli_close($conn);
