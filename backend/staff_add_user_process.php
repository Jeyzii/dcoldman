<?php
session_start();

// Include database connection
require '../includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"]; // Assuming you have a role field in your form

    // Sanitize user input to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);

    // Hash the password (you should use a secure hashing algorithm)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $insert_query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
    $insert_result = mysqli_query($conn, $insert_query);

    if ($insert_result) {
        $_SESSION["success_message"] = "User added successfully.";
    } else {
        $_SESSION["error_message"] = "Error adding user: " . mysqli_error($conn);
    }

    // Redirect back to user management page
    header("Location: ../staff_user_management.php");
    exit;
}
?>
