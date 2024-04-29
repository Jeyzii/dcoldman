<?php
session_start();

// Include database connection
require 'includes/database.php';
require 'includes/admin_auth.php';

// Define the number of records per page
$recordsPerPage = 10;

// Determine the current page number
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the OFFSET for the SQL query
$offset = ($page - 1) * $recordsPerPage;

// Fetch manpower time entries with pagination
$query = "SELECT * FROM manpower_time_entries ORDER BY time_now DESC LIMIT $recordsPerPage OFFSET $offset";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    $entries = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <?php include("includes/admin_nav.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Include Sidebar -->
            <?php include("includes/admin_sidebar.php"); ?>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container mt-5">
                    <h2>Manpower Time Entries</h2>

                    <?php
                    // Display error message if there is an error in the query
                    if (isset($error_message)) {
                        echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
                    }
                    ?>

                    <!-- Display the list of manpower time entries -->
                    <?php
                        if (isset($entries)) {
                            echo '<table class="table">';
                            echo '<thead><tr><th>No</th><th>User ID</th><th>Name</th><th>Status</th><th>Time</th></tr></thead>';
                            echo '<tbody>';

                            $startIndex = ($page - 1) * $recordsPerPage + 1;

                            foreach ($entries as $index => $entry) {
                                // Determine the background color based on the availability status
                                $status = $entry['status'];

                                if ($status == 'available') {
                                    $bgColor = 'bg-success';
                                } elseif ($status == 'not available') {
                                    $bgColor = 'bg-danger';
                                } elseif ($status == 'ongoing') {
                                    $bgColor = 'bg-info';
                                }

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

                            // Pagination links
                            $totalPagesQuery = "SELECT CEIL(COUNT(*) / $recordsPerPage) AS totalPages FROM manpower_time_entries";
                            $totalPagesResult = mysqli_query($conn, $totalPagesQuery);
                            $totalPages = mysqli_fetch_assoc($totalPagesResult)['totalPages'];

                            echo '<nav aria-label="Page navigation example">
                                    <ul class="pagination">';

                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                                        <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                                    </li>';
                            }

                            echo '</ul></nav>';
                        }
                    ?>
                </div>
            </main>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
