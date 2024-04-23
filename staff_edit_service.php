<?php
session_start();

// Include database connection
require 'includes/database.php';
require 'includes/staff_auth.php';
// Check if service_id is provided in the URL
if (isset($_GET['service_id'])) {
    $service_id = mysqli_real_escape_string($conn, $_GET['service_id']);

    // Query to retrieve service information
    $query = "SELECT * FROM air_condition_services WHERE service_id = '$service_id'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        $service = mysqli_fetch_assoc($result);
    } else {
        $_SESSION["error_message"] = "Service not found.";
        header("Location: staff_services_management.php");
        exit;
    }
} else {
    $_SESSION["error_message"] = "Service ID not provided.";
    header("Location: staff_services_management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/staff_nav.php"); ?>

    <div class="container mt-5">
        <h2>Edit Service</h2>

        <!-- Display error message if any -->
        <?php
        if (isset($_SESSION["error_message"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["error_message"] . '</div>';
            unset($_SESSION["error_message"]);
        }
        ?>

        <!-- Service Edit Form -->
        <form action="backend/staff_edit_service_process.php" method="post">
            <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
            <div class="mb-3">
                <label for="service_name" class="form-label">Service Name:</label>
                <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo $service['service_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" required><?php echo $service['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="total_manpower" class="form-label">Total Manpower:</label>
                <input type="number" class="form-control" id="total_manpower" name="total_manpower" value="<?php echo $service['total_manpower']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $service['price']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Save Changes</button>
        </form>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
