<?php
    session_start();

    // Include database connection
    require 'includes/database.php';
    require 'includes/manpower_auth.php';

    // Define the number of records per page
    $recordsPerPage = 10;

    // Determine the current page number
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

    // Calculate the OFFSET for the SQL query
    $offset = ($page - 1) * $recordsPerPage;

    // Fetch manpower time entries for the logged-in user with pagination
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM manpower_time_entries WHERE user_id = '$user_id' ORDER BY time_now DESC LIMIT $recordsPerPage OFFSET $offset";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $entries = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $totalEntries = count($entries);
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manpower Time Entries</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/manpower_nav.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="padding-bottom: 20px;">
                <h2>Manpower Dashboard</h2>
                
                <!-- Display information from the database -->
                <div class="row">
                    <!-- Display the list of manpower time entries -->
                    <?php
                        if (isset($entries) && $totalEntries > 0) {
                            echo '<table class="table">';
                            echo '<thead><tr><th>No</th><th>User ID</th><th>Name</th><th>Status</th><th>Time Now</th></tr></thead>';
                            echo '<tbody>';

                            $startIndex = ($page - 1) * $recordsPerPage + 1;

                            foreach ($entries as $index => $entry) {
                                // Determine the background color based on the availability status
                                $bgColor = ($entry['status'] == 'available') ? 'bg-success' : 'bg-danger';

                                // Format time to 12-hour format
                                $formattedTime = date('g:i A', strtotime($entry['time_now']));

                                echo '<tr class="' . $bgColor . ' text-white">';
                                echo '<td>' . ($startIndex + $index) . '</td>';
                                echo '<td>' . $entry['user_id'] . '</td>';
                                echo '<td>' . $entry['name'] . '</td>';
                                echo '<td>' . $entry['status'] . '</td>';
                                echo '<td>' . $formattedTime . '</td>';
                                echo '</tr>';
                            }

                            echo '</tbody></table>';

                            // Display pagination links only if there are more entries
                            if ($totalEntries > $recordsPerPage) {
                                // Pagination links
                                $totalPages = ceil($totalEntries / $recordsPerPage);
                                echo '<nav aria-label="Page navigation example">
                                        <ul class="pagination">';

                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                                            <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                                        </li>';
                                }

                                echo '</ul></nav>';
                            }
                        } else {
                            // Display a message when no entries are found
                            echo '<div class="text-center" style="margin-top: 50px;">
                                    <p class="display-4">No entries found for the logged-in user.</p>
                                    </div>';
                        }
                    ?>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
