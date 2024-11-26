<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['u_id'];

  // Update user location
  if (isset($_POST['update_location'])) {
      $user_location = $_POST['user_location'];
      $u_id = $_SESSION['u_id'];
      
      $update_query = "UPDATE tms_user SET u_location = ? WHERE u_id = ?";
      $update_stmt = $mysqli->prepare($update_query);
      $update_stmt->bind_param('si', $user_location, $u_id);
      
      if ($update_stmt->execute()) {
          $succ = "Location Updated Successfully";
          $_SESSION['show_booking_popup'] = true;
      } else {
          $err = "Failed to update location";
      }
      $update_stmt->close();
  }

  // Get current user location
  $loc_query = "SELECT u_location FROM tms_user WHERE u_id = ?";
  $loc_stmt = $mysqli->prepare($loc_query);
  $loc_stmt->bind_param('i', $aid);
  $loc_stmt->execute();
  $loc_result = $loc_stmt->get_result();
  $current_user = $loc_result->fetch_object();
  $loc_stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<!--Head-->
<?php include ('vendor/inc/head.php');?>
<!--End Head-->

<body id="page-top">
    <!--Navbar-->
    <?php include ('vendor/inc/nav.php');?>
    <!--End Navbar-->

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('vendor/inc/sidebar.php');?>
        <!--End Sidebar-->

        <div id="content-wrapper">

            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="user-dashboard.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Overview</li>
                </ol>

                <!-- Icon Cards-->
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-primary o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa-user"></i>
                                </div>
                                <div class="mr-5">My Profile</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="user-view-profile.php">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-warning o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa-shopping-cart"></i>
                                </div>
                                <?php
                                    //count my bookings
                                    $result = "SELECT count(*) FROM tms_bookings WHERE u_id = ?";
                                    $stmt = $mysqli->prepare($result);
                                    $stmt->bind_param('i', $aid);
                                    $stmt->execute();
                                    $stmt->bind_result($bookings);
                                    $stmt->fetch();
                                    $stmt->close();
                                ?>
                                <div class="mr-5"><?php echo $bookings;?> Bookings</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="user-view-booking.php">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-success o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa-car"></i>
                                </div>
                                <?php
                                    //count available cars
                                    $result = "SELECT count(*) FROM tms_vehicle WHERE v_status = 'Available'";
                                    $stmt = $mysqli->prepare($result);
                                    $stmt->execute();
                                    $stmt->bind_result($vehicles);
                                    $stmt->fetch();
                                    $stmt->close();
                                ?>
                                <div class="mr-5"><?php echo $vehicles;?> Available Vehicles</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="usr-book-vehicle.php">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <!--Location Form-->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-map-marker-alt"></i>
                        Set Your Location
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label>Your Current Location</label>
                                <input type="text" class="form-control" id="user_location" name="user_location" required>
                            </div>
                            <button type="submit" name="update_location" class="btn btn-primary">Set Location</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

            <!-- Sticky Footer -->
            <?php include("vendor/inc/footer.php");?>
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include("vendor/inc/logout.php");?>

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

    <!-- Google Maps Places API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz6zabR9k2B9hba52HNoHciRVW4B3gGbk&libraries=places"></script>
    <script>
    <?php if (isset($_SESSION['show_booking_popup'])) { ?>
        $(document).ready(function() {
            $('#bookingModal').modal('show');
            <?php unset($_SESSION['show_booking_popup']); ?>
        });
    <?php } ?>

    // Initialize Google Places Autocomplete
    function initAutocomplete() {
        var locationInput = document.getElementById('user_location');
        new google.maps.places.Autocomplete(locationInput);
    }

    // Call initAutocomplete when the page loads
    google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Location Updated Successfully!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Your location has been updated. Would you like to book a vehicle now?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="usr-book-vehicle.php" class="btn btn-primary">Book Vehicle</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>