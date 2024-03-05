<?php

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the user has admin privileges
if ($_SESSION['role'] !== 'manpower') {
    // Redirect to a different page if not an admin
    header("Location: index.php");
    exit();
}
?>