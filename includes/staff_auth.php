<?php

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the user has staff privileges
if ($_SESSION['role'] !== 'staff') {
    // Redirect to a different page if not an admin
    header("Location: index.php");
    exit();
}
?>