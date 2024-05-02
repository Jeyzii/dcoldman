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

// Fetch brands with pagination
$query = "SELECT * FROM aircon_brands LIMIT $recordsPerPage OFFSET $offset";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    $brands = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error_message = "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air conditioner Brands Management</title>
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
                    <h2>Air conditioner Brands Management</h2>

                    <?php
        // Display error message if there is an error in the query
        if (isset($error_message)) {
            echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
        }

        // Display success message if it exists
        if (isset($_SESSION["success_message"])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION["success_message"] . '</div>';
            unset($_SESSION["success_message"]);
        }
        ?>

        <!-- Add aircon Button -->
        <a href="admin_add_brand.php" class="btn btn-primary mb-3">Add Aircon Brand</a>

        <?php
        // Display the list of brands
        if (isset($brands)) {
            echo '<table class="table">';
            echo '<thead><tr><th>ID</th><th>Brand</th><th>Price</th><th>Actions</th></tr></thead>';
            echo '<tbody>';
            
            foreach ($brands as $brand) {
                echo '<tr>';
                echo '<td>' . $brand['id'] . '</td>';
                echo '<td>' . $brand['brand'] . '</td>';
                echo '<td>' . $brand['price'] . '</td>';
                echo '<td>
                        <a href="admin_edit_brand.php?id=' . $brand['id'] . '" class="btn btn-warning btn-sm">Edit</a>
                        <a href="backend/admin_delete_brand_process.php?id=' . $brand['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this aircon?\')">Delete</a>
                    </td>';
                echo '</tr>';
            }

            echo '</tbody></table>';

            // Pagination links
            $totalPagesQuery = "SELECT CEIL(COUNT(*) / $recordsPerPage) AS totalPages FROM aircon_brands";
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
