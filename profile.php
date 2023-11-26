<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Include database connection
require 'includes/database.php';

// Fetch user data from the database
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle error
    $_SESSION["error_message"] = "Error: " . mysqli_error($conn);
    header("Location: profile.php");
    exit;
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <?php include("includes/nav.php"); ?>

    <div class="container mt-5">
        <h2>User Profile</h2>

        <?php
        // Display success message if set in the session
        if (isset($_SESSION["success_message"])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION["success_message"] . '</div>';
            unset($_SESSION["success_message"]);
        }
        ?>
        
        <!-- Display user data -->
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number:</label>
            <input type="tel" class="form-control" id="contact_number" name="contact_number" value="<?php echo $user['contact_number']; ?>" readonly>
        </div>

        <!-- Add other fields as needed -->

        <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
