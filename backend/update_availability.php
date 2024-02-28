<?php
session_start();
require '../includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_availability'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    
    // Fetch the current availability from the database
    $currentAvailabilityQuery = "SELECT availability FROM users WHERE user_id = '$user_id'";
    $currentAvailabilityResult = mysqli_query($conn, $currentAvailabilityQuery);

    if ($currentAvailabilityResult) {
        $currentAvailability = mysqli_fetch_assoc($currentAvailabilityResult)['availability'];

        // Toggle the availability in the database
        $newAvailability = ($currentAvailability == 1) ? 2 : 1;

        $updateQuery = "UPDATE users SET availability = '$newAvailability' WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            header("Location: ../index.php");
            exit;
        } else {
            echo 'Error updating availability';
        }
    } else {
        echo 'Error fetching current availability';
    }
} else {
    echo 'Invalid request';
}
?>
