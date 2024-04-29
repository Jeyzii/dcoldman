<?php
session_start();
require 'includes/database.php';
require 'includes/admin_auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include("includes/head.php"); ?>
    <!-- Include font-awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-d3L9/ATCV5T1OlCpG4IwPmOK51Gh3Ze9YucnN7Iuov1D1evSwMk/sFgU5X6j9kfo" crossorigin="anonymous">
</head>
<body>
    <!-- Navigation -->
    <?php include("includes/admin_nav.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->    
            <?php include("includes/admin_sidebar.php"); ?>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="padding-bottom: 20px;">
                <h2>Admin Dashboard</h2>
                <!-- Display information from the database -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-users"></i> Total Users</h5>
                                <?php
                                $userCountQuery = "SELECT COUNT(*) AS user_count FROM users";
                                $userCountResult = mysqli_query($conn, $userCountQuery);

                                if ($userCountResult) {
                                    $userCount = mysqli_fetch_assoc($userCountResult)['user_count'];
                                    echo "<p class='card-text'>$userCount</p>";
                                } else {
                                    echo "Error fetching user information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-toolbox"></i> Total Services</h5>
                                <?php
                                $serviceCountQuery = "SELECT COUNT(*) AS service_count FROM air_condition_services";
                                $serviceCountResult = mysqli_query($conn, $serviceCountQuery);

                                if ($serviceCountResult) {
                                    $serviceCount = mysqli_fetch_assoc($serviceCountResult)['service_count'];
                                    echo "<p class='card-text'>$serviceCount</p>";
                                } else {
                                    echo "Error fetching service information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-toolbox"></i> Total Aircon installation done</h5>
                                <?php
                                $serviceCountQuery = "SELECT COUNT(*) AS service_count FROM bookings WHERE service_type = 'AC Installation' AND status = 'done'";
                                $serviceCountResult = mysqli_query($conn, $serviceCountQuery);

                                if ($serviceCountResult) {
                                    $serviceCount = mysqli_fetch_assoc($serviceCountResult)['service_count'];
                                    echo "<p class='card-text'>$serviceCount</p>";
                                } else {
                                    echo "Error fetching service information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-toolbox"></i> Total Cooling Service done</h5>
                                <?php
                                $serviceCountQuery = "SELECT COUNT(*) AS service_count FROM bookings WHERE service_type = 'Cooling Services' AND status = 'done'";
                                $serviceCountResult = mysqli_query($conn, $serviceCountQuery);

                                if ($serviceCountResult) {
                                    $serviceCount = mysqli_fetch_assoc($serviceCountResult)['service_count'];
                                    echo "<p class='card-text'>$serviceCount</p>";
                                } else {
                                    echo "Error fetching service information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-toolbox"></i> Total Heating Service done</h5>
                                <?php
                                $serviceCountQuery = "SELECT COUNT(*) AS service_count FROM bookings WHERE service_type = 'Heating Services' AND status = 'done'";
                                $serviceCountResult = mysqli_query($conn, $serviceCountQuery);

                                if ($serviceCountResult) {
                                    $serviceCount = mysqli_fetch_assoc($serviceCountResult)['service_count'];
                                    echo "<p class='card-text'>$serviceCount</p>";
                                } else {
                                    echo "Error fetching service information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-toolbox"></i> Total Maintenance & Repair done</h5>
                                <?php
                                $serviceCountQuery = "SELECT COUNT(*) AS service_count FROM bookings WHERE service_type = 'Maintenance & Repair' AND status = 'done'";
                                $serviceCountResult = mysqli_query($conn, $serviceCountQuery);

                                if ($serviceCountResult) {
                                    $serviceCount = mysqli_fetch_assoc($serviceCountResult)['service_count'];
                                    echo "<p class='card-text'>$serviceCount</p>";
                                } else {
                                    echo "Error fetching service information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-toolbox"></i> Total Indoor Air Quality done</h5>
                                <?php
                                $serviceCountQuery = "SELECT COUNT(*) AS service_count FROM bookings WHERE service_type = 'Indoor Air Quality' AND status = 'done'";
                                $serviceCountResult = mysqli_query($conn, $serviceCountQuery);

                                if ($serviceCountResult) {
                                    $serviceCount = mysqli_fetch_assoc($serviceCountResult)['service_count'];
                                    echo "<p class='card-text'>$serviceCount</p>";
                                } else {
                                    echo "Error fetching service information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-toolbox"></i> Total Annual Inspections done</h5>
                                <?php
                                $serviceCountQuery = "SELECT COUNT(*) AS service_count FROM bookings WHERE service_type = 'Annual Inspections' AND status = 'done'";
                                $serviceCountResult = mysqli_query($conn, $serviceCountQuery);

                                if ($serviceCountResult) {
                                    $serviceCount = mysqli_fetch_assoc($serviceCountResult)['service_count'];
                                    echo "<p class='card-text'>$serviceCount</p>";
                                } else {
                                    echo "Error fetching service information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-book"></i> Total Bookings</h5>
                                <?php
                                $bookingCountQuery = "SELECT COUNT(*) AS booking_count FROM bookings";
                                $bookingCountResult = mysqli_query($conn, $bookingCountQuery);

                                if ($bookingCountResult) {
                                    $bookingCount = mysqli_fetch_assoc($bookingCountResult)['booking_count'];
                                    echo "<p class='card-text'>$bookingCount</p>";
                                } else {
                                    echo "Error fetching booking information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-book"></i> Total Bookings Done</h5>
                                <?php
                                $bookingCountQuery = "SELECT COUNT(*) AS booking_count FROM bookings WHERE status = 'done'";
                                $bookingCountResult = mysqli_query($conn, $bookingCountQuery);

                                if ($bookingCountResult) {
                                    $bookingCount = mysqli_fetch_assoc($bookingCountResult)['booking_count'];
                                    echo "<p class='card-text'>$bookingCount</p>";
                                } else {
                                    echo "Error fetching booking information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-book"></i> Total pending bookings</h5>
                                <?php
                                $bookingCountQuery = "SELECT COUNT(*) AS booking_count FROM bookings WHERE status = 'pending'";
                                $bookingCountResult = mysqli_query($conn, $bookingCountQuery);

                                if ($bookingCountResult) {
                                    $bookingCount = mysqli_fetch_assoc($bookingCountResult)['booking_count'];
                                    echo "<p class='card-text'>$bookingCount</p>";
                                } else {
                                    echo "Error fetching booking information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-book"></i> Total Approved bookings</h5>
                                <?php
                                $bookingCountQuery = "SELECT COUNT(*) AS booking_count FROM bookings WHERE status = 'approved'";
                                $bookingCountResult = mysqli_query($conn, $bookingCountQuery);

                                if ($bookingCountResult) {
                                    $bookingCount = mysqli_fetch_assoc($bookingCountResult)['booking_count'];
                                    echo "<p class='card-text'>$bookingCount</p>";
                                } else {
                                    echo "Error fetching booking information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-book"></i> Total Rescheduled bookings</h5>
                                <?php
                                $bookingCountQuery = "SELECT COUNT(*) AS booking_count FROM bookings WHERE status = 'resched'";
                                $bookingCountResult = mysqli_query($conn, $bookingCountQuery);

                                if ($bookingCountResult) {
                                    $bookingCount = mysqli_fetch_assoc($bookingCountResult)['booking_count'];
                                    echo "<p class='card-text'>$bookingCount</p>";
                                } else {
                                    echo "Error fetching booking information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-book"></i> Total Cancelled bookings</h5>
                                <?php
                                $bookingCountQuery = "SELECT COUNT(*) AS booking_count FROM bookings WHERE status = 'cancel'";
                                $bookingCountResult = mysqli_query($conn, $bookingCountQuery);

                                if ($bookingCountResult) {
                                    $bookingCount = mysqli_fetch_assoc($bookingCountResult)['booking_count'];
                                    echo "<p class='card-text'>$bookingCount</p>";
                                } else {
                                    echo "Error fetching booking information.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-users"></i> Total Manpower Available</h5>
                                <?php
                                $availableManpowerCountQuery = "SELECT COUNT(*) AS available_manpower_count FROM users WHERE availability = 1 AND role = 'manpower'";
                                $availableManpowerCountResult = mysqli_query($conn, $availableManpowerCountQuery);

                                if ($availableManpowerCountResult) {
                                    $availableManpowerCount = mysqli_fetch_assoc($availableManpowerCountResult)['available_manpower_count'];
                                    echo "<p class='card-text'>$availableManpowerCount</p>";
                                } else {
                                    echo "Error fetching available manpower information.";
                                }
                                ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-users"></i> Total Manpower Not Available</h5>
                                <?php
                                $availableManpowerCountQuery = "SELECT COUNT(*) AS available_manpower_count FROM users WHERE availability = 2 AND role = 'manpower'";
                                $availableManpowerCountResult = mysqli_query($conn, $availableManpowerCountQuery);

                                if ($availableManpowerCountResult) {
                                    $availableManpowerCount = mysqli_fetch_assoc($availableManpowerCountResult)['available_manpower_count'];
                                    echo "<p class='card-text'>$availableManpowerCount</p>";
                                } else {
                                    echo "Error fetching available manpower information.";
                                }
                                ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-users"></i> Total Manpower Ongoing</h5>
                                <?php
                                $availableManpowerCountQuery = "SELECT COUNT(*) AS available_manpower_count FROM users WHERE availability = 3 AND role = 'manpower'";
                                $availableManpowerCountResult = mysqli_query($conn, $availableManpowerCountQuery);

                                if ($availableManpowerCountResult) {
                                    $availableManpowerCount = mysqli_fetch_assoc($availableManpowerCountResult)['available_manpower_count'];
                                    echo "<p class='card-text'>$availableManpowerCount</p>";
                                } else {
                                    echo "Error fetching available manpower information.";
                                }
                                ?>
                        </div>
                    </div>
                </div>
                </div>
                <br>
                <hr>
                    <!-- all bookings pie graph -->
                <div class = "row">
                    <div class="col-md-4">
                        <h5>Booking Status Distribution</h5>
                        <?php
                            $bookingCounts = array();
                            $statuses = array('done', 'pending', 'approved', 'resched', 'cancel');

                            foreach ($statuses as $status) {
                                $bookingCountQuery = "SELECT COUNT(*) AS booking_count FROM bookings WHERE status = '$status'";
                                $bookingCountResult = mysqli_query($conn, $bookingCountQuery);
                                if ($bookingCountResult) {
                                    $bookingCount = mysqli_fetch_assoc($bookingCountResult)['booking_count'];
                                    $bookingCounts[$status] = $bookingCount;
                                } else {
                                    // Handle error fetching booking information
                                    echo "Error fetching booking information.";
                                }
                            }

                            // Prepare data for Chart.js
                            $labels = array_keys($bookingCounts);
                            $data = array_values($bookingCounts);

                            // Generate Chart.js pie graph
                            echo "<canvas id='bookingPieChart' width='400' height='400'></canvas>";

                            // JavaScript to render the pie graph
                            echo "<script>";
                            echo "var ctx = document.getElementById('bookingPieChart').getContext('2d');";
                            echo "var bookingPieChart = new Chart(ctx, {";
                            echo "    type: 'pie',";
                            echo "    data: {";
                            echo "        labels: " . json_encode($labels) . ",";
                            echo "        datasets: [{";
                            echo "            data: " . json_encode($data) . ",";
                            echo "            backgroundColor: [";
                            echo "                '#FF6384',";
                            echo "                '#36A2EB',";
                            echo "                '#FFCE56',";
                            echo "                '#4BC0C0',";
                            echo "                '#9966FF'";
                            echo "            ]";
                            echo "        }]";
                            echo "    },";
                            echo "    options: {";
                            echo "        responsive: false,";
                            echo "        maintainAspectRatio: false";
                            echo "    }";
                            echo "});";
                            echo "</script>";
                        ?>
                    </div>
                    <!-- done vs cancelled bookings pie graph -->
                    <div class="col-md-4">
                        <h5>Booking Done vs Cancelled Distribution</h5>
                        <?php
                            // Fetch counts for 'done' and 'cancel' statuses only
                            $bookingCounts = array();
                            $statuses = array('done', 'cancel');

                            foreach ($statuses as $status) {
                                $bookingCountQuery = "SELECT COUNT(*) AS booking_count FROM bookings WHERE status = '$status'";
                                $bookingCountResult = mysqli_query($conn, $bookingCountQuery);
                                if ($bookingCountResult) {
                                    $bookingCount = mysqli_fetch_assoc($bookingCountResult)['booking_count'];
                                    $bookingCounts[$status] = $bookingCount;
                                } else {
                                    // Handle error fetching booking information
                                    echo "Error fetching booking information.";
                                }
                            }

                            // Prepare data for Chart.js
                            $labels = array_keys($bookingCounts);
                            $data = array_values($bookingCounts);

                            // Generate Chart.js pie graph
                            echo "<canvas id='bookingPieChart1' width='400' height='400'></canvas>";

                            // JavaScript to render the pie graph
                            echo "<script>";
                            echo "var ctx = document.getElementById('bookingPieChart1').getContext('2d');";
                            echo "var bookingPieChart1 = new Chart(ctx, {";
                            echo "    type: 'pie',";
                            echo "    data: {";
                            echo "        labels: " . json_encode($labels) . ",";
                            echo "        datasets: [{";
                            echo "            data: " . json_encode($data) . ",";
                            echo "            backgroundColor: [";
                            echo "                '#FF6384',"; // Color for 'done'
                            echo "                '#9966FF'"; // Color for 'cancel'
                            echo "            ]";
                            echo "        }]";
                            echo "    },";
                            echo "    options: {";
                            echo "        responsive: false,";
                            echo "        maintainAspectRatio: false";
                            echo "    }";
                            echo "});";
                            echo "</script>";
                        ?>
                    </div>
                    <!-- manpower pie graph -->
                    <div class="col-md-4">
                        <h5>Manpower Status Distribution</h5>
                        <?php
                            // Map status codes to labels
                            $statusLabels = array(
                                '1' => 'Available',
                                '2' => 'Not Available',
                                '3' => 'Ongoing'
                            );

                            // Fetch counts for each category
                            $manpowerCounts = array();

                            foreach ($statusLabels as $status => $label) {
                                $manpowerCountQuery = "SELECT COUNT(*) AS manpower_count FROM users WHERE availability = '$status' AND role = 'manpower'";
                                $manpowerCountResult = mysqli_query($conn, $manpowerCountQuery);
                                if ($manpowerCountResult) {
                                    $manpowerCount = mysqli_fetch_assoc($manpowerCountResult)['manpower_count'];
                                    $manpowerCounts[$label] = $manpowerCount;
                                } else {
                                    // Handle error fetching manpower information
                                    echo "Error fetching manpower information.";
                                }
                            }

                            // Prepare data for Chart.js
                            $labels = array_keys($manpowerCounts);
                            $data = array_values($manpowerCounts);

                            // Generate Chart.js pie graph
                            echo "<canvas id='manpowerPieChart2' width='400' height='400'></canvas>";

                            // JavaScript to render the pie graph
                            echo "<script>";
                            echo "var ctx = document.getElementById('manpowerPieChart2').getContext('2d');";
                            echo "var manpowerPieChart2 = new Chart(ctx, {";
                            echo "    type: 'pie',";
                            echo "    data: {";
                            echo "        labels: " . json_encode($labels) . ",";
                            echo "        datasets: [{";
                            echo "            data: " . json_encode($data) . ",";
                            echo "            backgroundColor: [";
                            echo "                '#FF6384',"; // Color for 'Available'
                            echo "                '#36A2EB',"; // Color for 'Not Available'
                            echo "                '#FFCE56'"; // Color for 'Ongoing'
                            echo "            ]";
                            echo "        }]";
                            echo "    },";
                            echo "    options: {";
                            echo "        responsive: false,";
                            echo "        maintainAspectRatio: false";
                            echo "    }";
                            echo "});";
                            echo "</script>";
                        ?>
                    </div>
                </div>
                
                <!-- bookings last 7 days line graph -->
                <?php
                    // Get the current date
                    $currentDate = date("Y-m-d");

                    // Calculate the date 7 days ago
                    $dateSevenDaysAgo = date("Y-m-d", strtotime('-7 days', strtotime($currentDate)));

                    // Fetch counts of bookings for each day over the last 7 days
                    $bookingCounts = array();

                    for ($i = 0; $i < 7; $i++) {
                        $date = date("Y-m-d", strtotime("-$i days", strtotime($currentDate)));
                        $bookingCountQuery = "SELECT COUNT(*) AS booking_count FROM bookings WHERE DATE(booking_date) = '$date'";
                        $bookingCountResult = mysqli_query($conn, $bookingCountQuery);
                        if ($bookingCountResult) {
                            $bookingCount = mysqli_fetch_assoc($bookingCountResult)['booking_count'];
                            // Store the count with the date as the key
                            $bookingCounts[$date] = $bookingCount;
                        } else {
                            // Handle error fetching booking information
                            echo "Error fetching booking information.";
                        }
                    }

                    // Prepare data for Chart.js
                    $labels = array_keys($bookingCounts);
                    $data = array_values($bookingCounts);

                    // Generate Chart.js line graph
                    echo "<canvas id='bookingLineGraph' style='width: 100%; height: 400px;'></canvas>";

                    // JavaScript to render the line graph
                    echo "<script>";
                    echo "var ctx = document.getElementById('bookingLineGraph').getContext('2d');";
                    echo "var bookingLineGraph = new Chart(ctx, {";
                    echo "    type: 'line',";
                    echo "    data: {";
                    echo "        labels: " . json_encode($labels) . ",";
                    echo "        datasets: [{";
                    echo "            label: 'Total Bookings last 7 days',";
                    echo "            data: " . json_encode($data) . ",";
                    echo "            borderColor: '#3e95cd',"; // Line color
                    echo "            fill: false";
                    echo "        }]";
                    echo "    },";
                    echo "    options: {";
                    echo "        responsive: false,";
                    echo "        maintainAspectRatio: false,";
                    echo "        scales: {";
                    echo "            yAxes: [{";
                    echo "                ticks: {";
                    echo "                    beginAtZero: true";
                    echo "                }";
                    echo "            }]";
                    echo "        }";
                    echo "    }";
                    echo "});";
                    echo "</script>";
                ?>
                <!-- services last 7 days line graph -->
                <?php
                    // Get the current date
                    $currentDate = date("Y-m-d");

                    // Calculate the date 7 days ago
                    $dateSevenDaysAgo = date("Y-m-d", strtotime('-7 days', strtotime($currentDate)));

                    // Array to hold the counts for each service type
                    $serviceCounts = array();

                    // Array of service types
                    $serviceTypes = array(
                        'Aircon installation',
                        'Cooling Services',
                        'Heating Services',
                        'Maintenance & Repair',
                        'Indoor Air Quality',
                        'Annual Inspections'
                    );

                    // Fetch counts for each service type over the last 7 days
                    foreach ($serviceTypes as $serviceType) {
                        $serviceCountQuery = "SELECT COUNT(*) AS service_count FROM bookings WHERE service_type = '$serviceType' AND DATE(booking_date) BETWEEN '$dateSevenDaysAgo' AND '$currentDate'";
                        $serviceCountResult = mysqli_query($conn, $serviceCountQuery);
                        if ($serviceCountResult) {
                            $serviceCount = mysqli_fetch_assoc($serviceCountResult)['service_count'];
                            // Store the count with the service type as the key
                            $serviceCounts[$serviceType] = $serviceCount;
                        } else {
                            // Handle error fetching service information
                            echo "Error fetching service information.";
                        }
                    }

                    // Prepare data for Chart.js
                    $labels = array_keys($serviceCounts);
                    $data = array_values($serviceCounts);

                    // Generate Chart.js bar graph
                    echo "<canvas id='serviceComparisonGraph' style='width: 100%; height: 400px;'></canvas>";

                    // JavaScript to render the bar graph
                    echo "<script>";
                    echo "var ctx = document.getElementById('serviceComparisonGraph').getContext('2d');";
                    echo "var serviceComparisonGraph = new Chart(ctx, {";
                    echo "    type: 'bar',";
                    echo "    data: {";
                    echo "        labels: " . json_encode($labels) . ",";
                    echo "        datasets: [{";
                    echo "            label: 'Services bookings last 7 days',";
                    echo "            data: " . json_encode($data) . ",";
                    echo "            backgroundColor: ['#3e95cd', '#8e5ea2', '#3cba9f', '#e8c3b9', '#c45850', '#3e8e7d']"; // Colors for each service type
                    echo "        }]";
                    echo "    },";
                    echo "    options: {";
                    echo "        responsive: false,";
                    echo "        maintainAspectRatio: false,";
                    echo "        legend: { display: false },";
                    echo "        scales: {";
                    echo "            yAxes: [{";
                    echo "                ticks: {";
                    echo "                    beginAtZero: true";
                    echo "                }";
                    echo "            }]";
                    echo "        }";
                    echo "    }";
                    echo "});";
                    echo "</script>";
                ?>

            </main>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/scripts.php"); ?>
</body>
</html>
