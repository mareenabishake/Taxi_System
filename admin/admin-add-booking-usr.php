<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Add Booking
if (isset($_POST['book_vehicle'])) {
    $u_id = $_GET['u_id'];
    $u_car_type = $_POST['u_car_type'];
    $u_car_regno = $_POST['u_car_regno'];
    $u_car_driver = $_POST['u_car_driver'];
    $u_car_driver_contact = $_POST['u_car_driver_contact'];
    $u_car_bookdate = $_POST['u_car_bookdate'];
    $u_car_pickup = $_POST['u_car_pickup'];
    $u_car_drop = $_POST['u_car_drop'];
    $u_car_hire = $_POST['u_car_hire'];
    $u_car_book_status = $_POST['u_car_book_status'];
    $u_car_distance = $_POST['u_car_distance'];

    // Prepare SQL query 
    $query = "UPDATE tms_user SET u_car_type=?, u_car_bookdate=?, u_car_regno=?, u_car_driver=?, u_car_driver_contact=?, u_car_pickup=?, u_car_drop=?, u_car_hire=?, u_car_book_status=?, u_car_distance=? WHERE u_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssssssssssi', $u_car_type, $u_car_bookdate, $u_car_regno, $u_car_driver, $u_car_driver_contact, $u_car_pickup, $u_car_drop, $u_car_hire, $u_car_book_status, $u_car_distance, $u_id);
    $stmt->execute();

    // If booking is successful, update the vehicle status to 'Busy'
    if ($stmt) {
        $update_query = "UPDATE tms_vehicle SET v_status='Busy' WHERE v_reg_no=?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param('s', $u_car_regno);
        $update_stmt->execute();
        $update_stmt->close();

        $succ = "User Booking Added and Vehicle Status Updated to Busy";
    } else {
        $err = "Please Try Again Later";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php'); ?>

<body id="page-top">
    <!-- Navigation Bar -->
    <?php include("vendor/inc/nav.php"); ?>
    

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('vendor/inc/sidebar.php'); ?>
        

        <div id="content-wrapper">

            <div class="container-fluid">
                
                <?php if (isset($succ)) { ?>
                <!-- code for a success alert -->
                <script>
                setTimeout(function() {
                        swal("Success!", "<?php echo $succ; ?>", "success");
                    },
                    100);
                </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                
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
                        <a href="#">Bookings</a>
                    </li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Add Booking
                    </div>
                    <div class="card-body">
                        <!--  User Form -->
                        <?php
                        $aid = $_GET['u_id'];
                        $ret = "SELECT * FROM tms_user WHERE u_id=?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $aid);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
                        ?>

                        <form method="POST">
                            <div class="form-group">
                                <label for="First Name">First Name</label>
                                <input type="text" value="<?php echo $row->u_fname; ?>" required class="form-control" id="First Name" name="u_fname">
                            </div>
                            <div class="form-group">
                                <label for="Last Name">Last Name</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_lname; ?>" id="Last Name" name="u_lname">
                            </div>
                            <div class="form-group">
                                <label for="Contact">Contact</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_phone; ?>" id="Contact" name="u_phone">
                            </div>
                            <div class="form-group">
                                <label for="Address">Address</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_addr; ?>" id="Address" name="u_addr">
                            </div>
                            <div class="form-group">
                                <label for="Vehicle Category">Vehicle Category</label>
                                <select class="form-control" name="u_car_type" id="u_car_type">
                                    <option value="">Select Vehicle Category</option>
                                    <option value="Bus">Bus</option>
                                    <option value="Sedan">Sedan</option>
                                    <option value="Van">Van</option>
                                    <option value="SUV">SUV</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Vehicle Registration Number">Vehicle Registration Number</label>
                                <select class="form-control" name="u_car_regno" id="u_car_regno" required>
                                    <option value="">Select Vehicle Registration Number</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Driver Name">Driver Name</label>
                                <input type="text" class="form-control" name="u_car_driver" id="u_car_driver" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Driver Contact No">Driver Contact No</label>
                                <input type="text" class="form-control" name="u_car_driver_contact" id="u_car_driver_contact" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Booking Date">Booking Date</label>
                                <input type="date" class="form-control" id="Booking Date" name="u_car_bookdate">
                            </div>
                            <div class="form-group">
                                <label for="Pickup Point">Pickup Point</label>
                                <input type="text" class="form-control" id="u_car_pickup" name="u_car_pickup">
                            </div>
                            <div class="form-group">
                                <label for="Drop Point">Drop Point</label>
                                <input type="text" class="form-control" id="u_car_drop" name="u_car_drop">
                            </div>
                            <div class="form-group">
                                <label for="Total Distance (km)">Total Distance (km)</label>
                                <input type="text" class="form-control" id="u_car_distance" name="u_car_distance" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Total Hire">Total Hire</label>
                                <input type="text" class="form-control" id="u_car_hire" name="u_car_hire" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Price per Km">Price per Km</label>
                                <input type="text" class="form-control" id="u_car_cost" name="u_car_cost" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Booking Status">Booking Status</label>
                                <select class="form-control" name="u_car_book_status" id="Booking Status">
                                    <option>Approved</option>
                                    <option>Pending</option>
                                </select>
                            </div>
                            <button type="submit" name="book_vehicle" class="btn btn-success">Confirm Booking</button>
                        </form>
                        <?php } ?>
                    </div>
                </div>

                <hr>

                <!-- Footer -->
                <?php include("vendor/inc/footer.php"); ?>

            </div>

        </div>
        

        
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModal">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="admin-logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript code-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

       
        <script src="vendor/js/sb-admin.min.js"></script>

        <!-- JavaScript to handle dynamic dropdown population -->
        <script>
        $(document).ready(function() {
            // Load vehicle registration numbers based on car type
            $('#u_car_type').change(function() {
                var car_type = $(this).val();
                $.ajax({
                    url: "get_vehicle_regno.php",
                    method: "POST",
                    data: { car_type: car_type },
                    success: function(data) {
                        $('#u_car_regno').html(data);
                    }
                });
            });

            // Load driver details and price per km based on vehicle registration number
            $('#u_car_regno').change(function() {
                var v_reg_no = $(this).val();
                $.ajax({
                    url: "get_driver_details.php",
                    method: "POST",
                    data: { v_reg_no: v_reg_no },
                    dataType: 'json',
                    success: function(data) {
                        if (!data.error) {
                            $('#u_car_driver').val(data.v_driver);
                            $('#u_car_driver_contact').val(data.v_driver_contact);
                            $('#u_car_cost').val(data.v_cost); // Price per km
                        } else {
                            alert(data.error);
                        }
                    }
                });
            });

            // Calculate total hire based on distance and price per km
            function calculateHire() {
                var pickup = $('#u_car_pickup').val();
                var drop = $('#u_car_drop').val();
                var ratePerKm = parseFloat($('#u_car_cost').val());

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
                                var results = response.rows[0].elements[0];
                                var distance = results.distance.value / 1000; // Convert to km
                                var hire = distance * ratePerKm;
                                $('#u_car_distance').val(distance.toFixed(2));
                                $('#u_car_hire').val(hire.toFixed(2)); // Total hire = distance * ratePerKm
                            }
                        });
                }
            }

            // Call calculateHire when the pickup or drop point changes
            $('#u_car_pickup, #u_car_drop').on('change', calculateHire);
        });
        </script>

        <!-- Inject SweetAlert and Google Maps API -->
        <script src="vendor/js/swal.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz6zabR9k2B9hba52HNoHciRVW4B3gGbk&libraries=places"></script>
        <script>
        // Initialize Google Places Autocomplete for pickup and drop inputs
        function initAutocomplete() {
            new google.maps.places.Autocomplete(document.getElementById('u_car_pickup'));
            new google.maps.places.Autocomplete(document.getElementById('u_car_drop'));
        }

        // Call initAutocomplete when the page loads
        google.maps.event.addDomListener(window, 'load', initAutocomplete);
        </script>

</body>

</html>
