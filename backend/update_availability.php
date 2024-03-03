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

        // Update the user's availability
        $updateQuery = "UPDATE users SET availability = '$newAvailability' WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            // Update session variable instantly
            $_SESSION['availability'] = $newAvailability;

            // Insert a record into manpower_time_entries
            $status = ($newAvailability == 1) ? 'available' : 'not available';
            $insertQuery = "INSERT INTO manpower_time_entries (user_id, name, status, time_now) VALUES ('$user_id', '{$_SESSION['name']}', '$status', NOW())";

            mysqli_query($conn, $insertQuery);

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
