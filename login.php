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
    <title>Login</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <?php include("includes/nav.php"); ?>

    <div class="container mt-5">
        <h2>Login</h2>
        
        <?php
        // Display error message if set in the session
        if (isset($_SESSION["error_message"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["error_message"] . '</div>';
            unset($_SESSION["error_message"]);
        }

        // Display success message if set in the session
        if (isset($_SESSION["success_message"])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION["success_message"] . '</div>';
            unset($_SESSION["success_message"]);
        }
        ?>

        <form action="backend/auth/login_process.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <div class="mt-3">
            <p>Don't have an account yet? <a href="signup.php">Sign up here</a>.</p>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
