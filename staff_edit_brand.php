<?php
session_start();

// Include database connection
require 'includes/database.php';
require 'includes/staff_auth.php';
// Check if id is provided in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to retrieve aircon information
    $query = "SELECT * FROM aircon_brands WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        $brand = mysqli_fetch_assoc($result);
    } else {
        $_SESSION["error_message"] = "Aircon type not found.";
        header("Location: staff_brand_management.php");
        exit;
    }
} else {
    $_SESSION["error_message"] = "ID not provided.";
    header("Location: staff_brand_management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit aircon brand</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/staff_nav.php"); ?>

    <div class="container mt-5">
        <h2>Edit aircon brand</h2>

        <!-- Display error message if any -->
        <?php
        if (isset($_SESSION["error_message"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["error_message"] . '</div>';
            unset($_SESSION["error_message"]);
        }
        ?>

        <!-- Aircon Edit Form -->
        <form action="backend/staff_edit_brand_process.php" method="post">
            <input type="hidden" name="id" value="<?php echo $brand['id']; ?>">
            <div class="mb-3">
                <label for="brand" class="form-label">Aircon Brand:</label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $brand['brand']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $brand['price']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Save Changes</button>
        </form>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
