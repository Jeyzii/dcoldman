<?php
session_start();

// Check if the user is logged in and has otp_status = 1
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["otp_status"]) || $_SESSION["otp_status"] != 1) {
    // Redirect to the login page if not logged in or otp_status is not 1
    header("Location: login.php");
    exit;
}

// Include database connection and functions
require 'includes/database.php';

// Fetch services from the database
$services_query = "SELECT * FROM air_condition_services";
$services_result = mysqli_query($conn, $services_query);

$aircons_query = "SELECT * FROM aircon_types";
$aircons_result = mysqli_query($conn, $aircons_query);

$brands_query = "SELECT * FROM aircon_brands";
$brands_result = mysqli_query($conn, $brands_query);

// Check if the query was successful
if (!$services_result) {
    die("Error: " . mysqli_error($conn));
}

if (!$aircons_result) {
    die("Error: " . mysqli_error($conn));
}

if (!$brands_result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Add Booking</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA08yFiEOhnLJ_CkSrkYDgHHNAROxsKHjs&libraries=places" async defer></script>
    <?php include("includes/head.php"); ?>

<style>
    #map-container {
        height: 300px; /* Adjust the height as needed */
    }

    /* Add some styles to make the search box look better */
    .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 5px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
    }

    #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
    }

    .pac-controls {
        display: inline-block;
        padding: 5px 11px;
    }

    .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }
</style>
</head>

<body>
    <?php
    // Spinner
    include("includes/spinner.php");

    // Navbar
    include("includes/nav.php");
    ?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-4 text-white animated slideInDown mb-4">Add Booking</h1>
            <nav aria-label="breadcrumb animated slideInDown">
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container position-relative wow fadeInUp" data-wow-delay="0.1s" style="margin-top: -6rem;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light text-center p-5">
                    <?php
                    // Display error message if it exists
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }

                    // Display success message if it exists
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']);
                    }
                    ?>
                    <h1 class="mb-4">Add Booking</h1>
                    <form action="backend/book_a_service_process.php" method="post">

                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label for="booking_date" class="form-label">Booking Date:</label>
                                <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="booking_time" class="form-label">Booking Time:</label>
                                <input type="time" class="form-control" id="booking_time" name="booking_time" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="service_type" class="form-label">Service Type:</label>
                                <select class="form-select" id="service_type" name="service_type" required>
                                    <option selected>Select Service Type</option>
                                    <?php
                                    // Loop through the services and create options
                                    while ($service = mysqli_fetch_assoc($services_result)) {
                                        echo '<option value="' . $service['service_name'] . '">' . $service['service_name'] . ' - ₱' . $service['price'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="aircon_type" class="form-label">Aircon Type:</label>
                                <select class="form-select" id="aircon_type" name="aircon_type" required>
                                    <option selected>Select Aircon Type</option>
                                    <?php
                                    // Loop through the aircon types and create options
                                    while ($aircon = mysqli_fetch_assoc($aircons_result)) {
                                        echo '<option value="' . $aircon['name'] . '">' . $aircon['name'] . ' - ₱' . $aircon['price'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="aircon_brand" class="form-label">Aircon Type:</label>
                                <select class="form-select" id="aircon_brand" name="aircon_brand" required>
                                    <option selected>Select Aircon Brand</option>
                                    <?php
                                    // Loop through the aircon brands and create options
                                    while ($brand = mysqli_fetch_assoc($brands_result)) {
                                        echo '<option value="' . $brand['brand'] . '">' . $brand['brand'] . ' - ₱' . $brand['price'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="special_request" class="form-label">Special Request:</label>
                                <textarea class="form-control" id="special_request" name="special_request" style="height: 17px;"></textarea>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address: </label>
                                <!-- Search input for address -->
                                <div id="pac-container">
                                    <input id="pac-input" name="address" type="text" placeholder="Enter a location">
                                </div>
                                <!-- Map Container -->
                                <div id="map-container"></div>
                                <!-- Hidden Input for Storing Selected Location -->
                                <input type="hidden" id="selected-location" name="selected_location" required>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary w-100 py-3" type="submit">Add Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- JavaScript to Initialize Google Maps Autocomplete and Search -->
<script>
function initMap() {
    // Coordinates for Manila, Philippines
    var manilaCoordinates = { lat: 14.6091, lng: 121.0223 };

    var map = new google.maps.Map(document.getElementById('map-container'), {
        center: manilaCoordinates,
        zoom: 10 // Adjust the zoom level as needed
    });

    // Autocomplete for the address input
    var input = document.getElementById('pac-input');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        var location = place.geometry.location;
        document.getElementById('selected-location').value = location.lat() + ',' + location.lng();

        // You can customize the map behavior when a location is selected, e.g., pan to the selected location
        map.setCenter(location);
        map.setZoom(15);
    });

    // Autocomplete for the search box
    var searchBox = new google.maps.places.SearchBox(document.getElementById('pac-input'));

    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];

    searchBox.addListener('places_changed', function () {
        var places = searchBox.getPlaces();

        if (places.length === 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name, and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }

            var location = place.geometry.location;
            document.getElementById('selected-location').value = location.lat() + ',' + location.lng();

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
                map: map,
                title: place.name,
                position: location
            }));

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });

    // Add click event listener to the map
    map.addListener('click', function (event) {
        // Get the clicked location
        var clickedLocation = event.latLng;
        
        // Set the search box value to the clicked location
        var geocoder = new google.maps.Geocoder;
        geocoder.geocode({ 'location': clickedLocation }, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    input.value = results[0].formatted_address;
                    document.getElementById('selected-location').value = clickedLocation.lat() + ',' + clickedLocation.lng();
                }
            }
        });
    });
}

// Initialize the map after the DOM has loaded
document.addEventListener('DOMContentLoaded', initMap);

</script>

    <?php
    // Back to top
    include("includes/back-to-top.php");
    // JavaScript Libraries
    include("includes/scripts.php");
    // footer
    include("includes/footer.php");
    ?>
</body>

</html>
