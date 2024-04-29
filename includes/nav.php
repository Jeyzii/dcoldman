<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5">
    <a href="index.php" class="navbar-brand d-flex align-items-center">
        <h1 class="m-0"><img class="img-fluid me-3" src="favicon.png" alt="">D'ColdMan Aircon Services</h1>
    </a>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav mx-auto bg-light pe-4 py-3 py-lg-0">
            <a href="index.php" class="nav-item nav-link">Home</a>
            <a href="about.php" class="nav-item nav-link">About Us</a>
            <a href="services.php" class="nav-item nav-link">Our Services</a>
            <a href="booking_page.php" class="nav-item nav-link">Booking</a>
            <a href="feedbacks.php" class="nav-item nav-link">Feedbacks</a>

            <a href="contact.php" class="nav-item nav-link">Contact Us</a>
        </div>

        <div class="h-100 d-lg-inline-flex align-items-center">
        <?php
            if (isset($_SESSION["user_id"])) {
                // Check if otp_status is 1, indicating that OTP is verified
                if (isset($_SESSION["otp_status"]) && $_SESSION["otp_status"] == 1) {
                    echo '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            ' . $_SESSION["name"] . '
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">';

                    // var_dump($_SESSION['availability']);

                    // Display dashboard link based on the user's role
                    if (isset($_SESSION["role"])) {
                        switch ($_SESSION["role"]) {
                            case 'admin':
                                echo '<li><a class="dropdown-item" href="admin_dashboard.php">Admin Dashboard</a></li>';
                                echo '<li><a class="dropdown-item" href="user_dashboard.php">User Dashboard</a></li>';
                                break;
                            case 'manpower':
                                echo '<li><a class="dropdown-item">Manpower Availability: </a></li>';
                                echo '<form action="backend/update_availability.php" method="post">';
                                echo '<input type="hidden" name="user_id" value="' . $_SESSION['user_id'] . '">';

                                if ($_SESSION['availability'] == 3) {
                                    echo '<button class="dropdown-item" style="pointer-events: none; background-color: #FF800F;">Ongoing</button>';
                                } else {
                                    echo '<button type="submit" name="toggle_availability" class="dropdown-item ' . ($_SESSION['availability'] == 1 ? 'btn-success' : 'btn-danger') . '">';
                                    echo ($_SESSION['availability'] == 1 ? 'Available' : 'Not Available');
                                    echo '</button>';
                                }
                                echo '</form><hr>';

                                echo '<li><a class="dropdown-item" href="manpower_dashboard.php">Manpower Dashboard</a></li>';
                                break;
                            case 'staff':
                                echo '<li><a class="dropdown-item" href="staff_dashboard.php">Staff Dashboard</a></li>';
                                echo '<li><a class="dropdown-item" href="user_dashboard.php">User Dashboard</a></li>';
                                break;
                            default:
                                echo '<li><a class="dropdown-item" href="user_dashboard.php">User Dashboard</a></li>';
                                break;
                        }
                    }

                    // Common links for all roles
                    echo '
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="backend/auth/logout_process.php">Logout</a></li>
                    </ul>
                    </div>';
                } else {
                    // If otp_status is not verified, redirect to the OTP page
                    header("Location: otp_page.php");
                    exit;
                }
            } else {
                // If not logged in, display login button
                echo '<a href="login.php" data-toggle="modal" data-target="#myModal" class="nav-item nav-link">Login <i class="fa fa-user" aria-hidden="true"></i></a>';
            }
        ?>

        </div>
    </div>
</nav>