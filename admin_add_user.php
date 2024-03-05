<?php
session_start();
require 'includes/admin_auth.php';
require 'includes/admin_auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/admin_nav.php"); ?>

    <div class="container mt-5">
        <h2>Add User</h2>

        <!-- Display error message if any -->
        <?php
        if (isset($_SESSION["error_message"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["error_message"] . '</div>';
            unset($_SESSION["error_message"]);
        }
        ?>

        <!-- User Add Form -->
        <form action="backend/admin_add_user_process.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                    <option value="manpower">Manpower</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
