<?php
session_start();

// Include database connection
require 'includes/database.php';
require 'includes/admin_auth.php';
// Check if id is provided in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to retrieve aircon information
    $query = "SELECT * FROM aircon_types WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        $aircon = mysqli_fetch_assoc($result);
    } else {
        $_SESSION["error_message"] = "Aircon type not found.";
        header("Location: admin_aircon_management.php");
        exit;
    }
} else {
    $_SESSION["error_message"] = "ID not provided.";
    header("Location: admin_aircon_management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit aircon</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/admin_nav.php"); ?>

    <div class="container mt-5">
        <h2>Edit aircon</h2>

        <!-- Display error message if any -->
        <?php
        if (isset($_SESSION["error_message"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["error_message"] . '</div>';
            unset($_SESSION["error_message"]);
        }
        ?>

        <!-- Aircon Edit Form -->
        <form action="backend/admin_edit_aircon_process.php" method="post">
            <input type="hidden" name="id" value="<?php echo $aircon['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Aircon Type:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $aircon['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="info" class="form-label">Information:</label>
                <textarea class="form-control" id="info" name="info" required><?php echo $aircon['info']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $aircon['price']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Save Changes</button>
        </form>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
