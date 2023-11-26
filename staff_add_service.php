<?php
session_start();
require 'includes/database.php';
require 'includes/staff_auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/staff_nav.php"); ?>

    <div class="container mt-5">
        <h2>Add Service</h2>

        <!-- Display error message if any -->
        <?php
        if (isset($_SESSION["error_message"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["error_message"] . '</div>';
            unset($_SESSION["error_message"]);
        }
        ?>

        <!-- Service Add Form -->
        <form action="backend/staff_add_service_process.php" method="post">
            <div class="mb-3">
                <label for="service_name" class="form-label">Service Name:</label>
                <input type="text" class="form-control" id="service_name" name="service_name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Service</button>
        </form>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
