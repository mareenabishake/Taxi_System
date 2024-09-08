<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['u_id'];

// Add Booking
if (isset($_POST['book_vehicle'])) {
    $u_id = $_SESSION['u_id'];
    $u_car_type = $_POST['u_car_type'];
    $u_car_regno = $_POST['u_car_regno'];
    $u_car_driver = $_POST['u_car_driver'];
    $u_car_driver_contact = $_POST['u_car_driver_contact'];
    $u_car_bookdate = $_POST['u_car_bookdate'];
    $u_car_pickup = $_POST['u_car_pickup'];
    $u_car_drop = $_POST['u_car_drop'];
    $u_car_hire = $_POST['u_car_hire'];
    $u_car_book_status = $_POST['u_car_book_status'];
    $v_id = $_GET['v_id']; // Get vehicle ID from URL

    // Fetch vehicle details including cost
    $vehicle_query = "SELECT v_cost FROM tms_vehicle WHERE v_id = ?";
    $vehicle_stmt = $mysqli->prepare($vehicle_query);
    $vehicle_stmt->bind_param('i', $v_id);
    $vehicle_stmt->execute();
    $vehicle_result = $vehicle_stmt->get_result();
    $vehicle_data = $vehicle_result->fetch_assoc();
    $rate_per_km = $vehicle_data['v_cost'];
    $vehicle_stmt->close();

    // Use your Google Maps API key here
    $apiKey = 'AIzaSyCz6zabR9k2B9hba52HNoHciRVW4B3gGbk';
    
    $distance = calculateDistance($u_car_pickup, $u_car_drop, $apiKey);
    
    if ($distance !== null) {
        // Calculate hire cost based on distance and vehicle-specific rate
        $u_car_hire = $distance * $rate_per_km;
        $u_car_distance = $distance; // Store the total distance
    } else {
        // Handle error - couldn't calculate distance
        $err = "Unable to calculate distance. Please check the addresses and try again.";
    }

    // Update the booking in tms_user
    $query = "UPDATE tms_user SET u_car_type=?, u_car_bookdate=?, u_car_regno=?, u_car_driver=?, u_car_driver_contact=?, u_car_pickup=?, u_car_drop=?, u_car_distance=?, u_car_hire=?, u_car_book_status=? WHERE u_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssssssddsi', $u_car_type, $u_car_bookdate, $u_car_regno, $u_car_driver, $u_car_driver_contact, $u_car_pickup, $u_car_drop, $u_car_distance, $u_car_hire, $u_car_book_status, $u_id);
    $stmt->execute();

    // If booking is successful, update the vehicle status to 'Busy'
    if ($stmt) {
        $update_query = "UPDATE tms_vehicle SET v_status='Busy' WHERE v_id=?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param('i', $v_id);
        $update_stmt->execute();
        $update_stmt->close();

        $succ = "Booking Submitted and Vehicle Status Updated";
    } else {
        $err = "Please Try Again Later";
    }

    $stmt->close();
}

// Add this function after the existing PHP code
function calculateDistance($origin, $destination, $apiKey) {
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($origin) . "&destinations=" . urlencode($destination) . "&key=" . $apiKey;
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    
    if (isset($data['rows'][0]['elements'][0]['distance']['value'])) {
        // Convert meters to kilometers
        return $data['rows'][0]['elements'][0]['distance']['value'] / 1000;
    }
    return null;
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php'); ?>

<body id="page-top">
    <!-- Start Navigation Bar -->
    <?php include("vendor/inc/nav.php"); ?>
    <!-- Navigation Bar -->

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('vendor/inc/sidebar.php'); ?>
        <!-- End Sidebar -->

        <div id="content-wrapper">

            <div class="container-fluid">
                <?php if (isset($succ)) { ?>
                <!-- This code for injecting an alert -->
                <script>
                setTimeout(function() {
                        swal("Success!", "<?php echo $succ; ?>", "success");
                    },
                    100);
                </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                <!-- This code for injecting an alert -->
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $err; ?>", "error");
                    },
                    100);
                </script>
                <?php } ?>

                <!-- Breadcrumbs -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="user-dashboard.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Book Vehicle</li>
                    <li class="breadcrumb-item active">Confirm Booking</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Confirm Booking
                    </div>
                    <div class="card-body">
                        <!-- Add User Form -->
                        <?php
                        $aid = $_GET['v_id'];
                        $ret = "SELECT * FROM tms_vehicle WHERE v_id=?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $aid);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
                        ?>

                        <form method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Vehicle Category</label>
                                <input type="text" value="<?php echo $row->v_category; ?>" readonly class="form-control" name="u_car_type">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Vehicle Registration Number</label>
                                <input type="text" value="<?php echo $row->v_reg_no; ?>" readonly class="form-control" name="u_car_regno">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Driver Name</label>
                                <input type="text" value="<?php echo $row->v_driver; ?>" readonly class="form-control" name="u_car_driver">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Driver Contact No</label>
                                <input type="text" value="<?php echo $row->v_driver_contact; ?>" readonly class="form-control" name="u_car_driver_contact">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Booking Date</label>
                                <input type="date" class="form-control" id="exampleInputEmail1" name="u_car_bookdate">
                            </div>
                            <div class="form-group">
                                <label for="pickup">Pickup Point</label>
                                <input type="text" class="form-control" id="pickup" name="u_car_pickup" onchange="calculateHire()">
                            </div>
                            <div class="form-group">
                                <label for="drop">Drop Point</label>
                                <input type="text" class="form-control" id="drop" name="u_car_drop" onchange="calculateHire()">
                            </div>
                            <div class="form-group">
                                <label for="total_distance">Total Distance (km)</label>
                                <input type="text" class="form-control" id="total_distance" name="u_car_distance" readonly>
                            </div>
                            <div class="form-group">
                                <label for="hire">Total Hire</label>
                                <input type="text" class="form-control" id="hire" name="u_car_hire" readonly>
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="exampleInputEmail1">Book Status</label>
                                <input type="text" value="Pending" class="form-control" id="exampleInputEmail1" name="u_car_book_status">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Price per km</label>
                                <input type="text" value="<?php echo $row->v_cost; ?>" readonly class="form-control" name="u_car_cost">
                            </div>
                            <input type="hidden" id="vehicle_cost" value="<?php echo $row->v_cost; ?>">
                            <button type="submit" name="book_vehicle" class="btn btn-success">Confirm Booking</button>
                        </form>
                        <!-- End Form -->
                        <?php } ?>
                    </div>
                </div>

                <hr>

                <!-- Sticky Footer -->
                <?php include("vendor/inc/footer.php"); ?>

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="usr-logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Page level plugin JavaScript-->
        <script src="vendor/chart.js/Chart.min.js"></script>
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="vendor/js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="vendor/js/demo/datatables-demo.js"></script>
        <script src="vendor/js/demo/chart-area-demo.js"></script>
        <!--INject Sweet alert js-->
        <script src="vendor/js/swal.js"></script>

        <!-- Add this script in the head section or just before the closing </body> tag -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz6zabR9k2B9hba52HNoHciRVW4B3gGbk&libraries=places"></script>
        <script>
        function calculateHire() {
            var pickup = document.getElementById('pickup').value;
            var drop = document.getElementById('drop').value;
            var ratePerKm = parseFloat(document.getElementById('vehicle_cost').value);

            if (pickup && drop) {
                var service = new google.maps.DistanceMatrixService();
                service.getDistanceMatrix(
                    {
                        origins: [pickup],
                        destinations: [drop],
                        travelMode: 'DRIVING',
                        unitSystem: google.maps.UnitSystem.METRIC,
                    }, function(response, status) {
                        if (status == 'OK') {
                            var origins = response.originAddresses;
                            var destinations = response.destinationAddresses;

                            for (var i = 0; i < origins.length; i++) {
                                var results = response.rows[i].elements;
                                for (var j = 0; j < results.length; j++) {
                                    var element = results[j];
                                    var distance = element.distance.value / 1000; // Convert meters to kilometers
                                    var hire = distance * ratePerKm;
                                    document.getElementById('total_distance').value = distance.toFixed(2);
                                    document.getElementById('hire').value = hire.toFixed(2);
                                }
                            }
                        }
                    });
            }
        }

        // Initialize Google Places Autocomplete for pickup and drop inputs
        function initAutocomplete() {
            new google.maps.places.Autocomplete(document.getElementById('pickup'));
            new google.maps.places.Autocomplete(document.getElementById('drop'));
        }

        // Call initAutocomplete when the page loads
        google.maps.event.addDomListener(window, 'load', initAutocomplete);
        </script>

</body>
</html>
