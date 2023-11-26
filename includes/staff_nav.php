<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5">
    <a href="staff_dashboard.php" class="navbar-brand d-flex align-items-center">
        <h1 class="m-0"><img class="img-fluid me-3" src="img/icon/icon-02-primary.png" alt="">D'ColdMan Aircon Services</h1>
    </a>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto"> <!-- Added ms-auto class to move the user name dropdown to the right -->
            <?php
            // Check if the user is logged in
            if (isset($_SESSION["user_id"])) {
                // If logged in, display dropdown with user options
                echo '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        ' . $_SESSION["name"] . '
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="index.php">Website</a></li>
                        <li><a class="dropdown-item" href="backend/auth/logout_process.php">Logout</a></li>
                    </ul>
                </div>';
            } else {
                // If not logged in, display login button
                echo '<a href="login.php" data-toggle="modal" data-target="#myModal" class="nav-item nav-link">Login <i class="fa fa-user" aria-hidden="true"></i></a>';
            }
            ?>
        </div>
    </div>
</nav>
