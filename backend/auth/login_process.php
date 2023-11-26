<?php
session_start();

require '../../includes/database.php';

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
        // Check if a user with the provided credentials exists
        if (mysqli_num_rows($result) == 1) {
            // Fetch user data
            $user = mysqli_fetch_assoc($result);

            // Use password_verify to check if the entered password matches the stored hash
            if (password_verify($password, $user['password'])) {
                // Password is correct, proceed with login
                // Store user data in the session
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["name"] = $user["name"];
                $_SESSION["role"] = $user["role"];

                // Redirect to a dashboard or home page
                header("Location: ../../index.php");
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
