<?php
session_start();

// If the user is already logged in, redirect to the dashboard or home page
if (isset($_SESSION["user_id"])) {
    header("Location: index.php"); // Change this URL to the appropriate dashboard or home page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <?php include("includes/nav.php"); ?>

    <div class="container mt-5">
        <h2>Signup</h2>

        <!-- Display error message if set in the session -->
        <?php
        if (isset($_SESSION["error_message"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["error_message"] . '</div>';
            unset($_SESSION["error_message"]);
        }
        ?>

        <form action="backend/auth/signup_process.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="contact_number" class="form-label">Contact Number:</label>
                <input type="tel" class="form-control" id="contact_number" name="contact_number" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="terms_agreement" name="terms_agreement" required>
                <label class="form-check-label" for="terms_agreement">
                    I accept the <a href="terms_and_agreements.php" target="_blank">terms and agreements</a>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
