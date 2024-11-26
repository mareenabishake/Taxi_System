<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['u_id'];

  // Get user's location
  $user_query = "SELECT u_location FROM tms_user WHERE u_id = ?";
  $user_stmt = $mysqli->prepare($user_query);
  $user_stmt->bind_param('i', $aid);
  $user_stmt->execute();
  $user_result = $user_stmt->get_result();
  $user = $user_result->fetch_object();
  $user_location = $user->u_location;
  $user_stmt->close();

  // Check if user has set their location
  $has_location = !empty($user_location);

  // Only get available vehicles if user has set location
  $vehicles = array();
  if ($has_location) {
    $ret = "SELECT v.*, COALESCE(v.v_location, 'Not Set') as v_location 
            FROM tms_vehicle v 
            WHERE v_status = 'Available'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    
    while ($row = $res->fetch_object()) {
        $vehicles[] = $row;
    }
    $stmt->close();
  }
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
                    <li class="breadcrumb-item">Vehicle</li>
                    <li class="breadcrumb-item active">Book Vehicle</li>
                </ol>

                <!--Bookings-->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-bus"></i>
                        Available Vehicles
                    </div>
                    <div class="card-body">
                        <?php if (!$has_location) { ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-circle"></i>
                                Please set your location in the <a href="user-dashboard.php">dashboard</a> first to view available vehicles.
                            </div>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Vehicle Name</th>
                                            <th>Reg No.</th>
                                            <th>Seats</th>
                                            <th>Distance (km)</th>
                                            <th>Price Per KM</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cnt=1;
                                        foreach ($vehicles as $vehicle) {
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo $vehicle->v_name;?></td>
                                            <td><?php echo $vehicle->v_reg_no;?></td>
                                            <td><?php echo $vehicle->v_pass_no;?> Passengers</td>
                                            <td><?php echo $vehicle->distance;?> km</td>
                                            <td>Rs.<?php echo $vehicle->v_cost;?></td>
                                            <td>
                                                <a href="user-confirm-booking.php?v_id=<?php echo $vehicle->v_id;?>&d_id=<?php echo $vehicle->d_id;?>" class="btn btn-outline-success"><i class="fa fa-clipboard"></i> Book Vehicle</a>
                                            </td>
                                        </tr>
                                        <?php $cnt = $cnt+1; } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
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
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="vendor/js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="vendor/js/demo/datatables-demo.js"></script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz6zabR9k2B9hba52HNoHciRVW4B3gGbk&libraries=places"></script>
    <script>
    function calculateDistances() {
        var userLocation = '<?php echo $user_location; ?>';
        
        if (!userLocation) {
            // Hide the table and show warning
            var tableDiv = document.querySelector('.table-responsive');
            if (tableDiv) {
                tableDiv.style.display = 'none';
            }
            return;
        }

        var vehicles = <?php echo json_encode($vehicles); ?>;
        if (!vehicles || vehicles.length === 0) {
            return;
        }

        var service = new google.maps.DistanceMatrixService();

        service.getDistanceMatrix({
            origins: [userLocation],
            destinations: vehicles.map(v => v.v_location),
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC,
        }, function(response, status) {
            if (status == 'OK') {
                var elements = response.rows[0].elements;
                var tbody = document.querySelector('#dataTable tbody');
                var rows = Array.from(tbody.getElementsByTagName('tr'));

                // Update distances in table
                rows.forEach((row, index) => {
                    var element = elements[index];
                    var distanceCell = row.cells[4]; // Distance column
                    
                    if (element && element.status === 'OK') {
                        var distance = (element.distance.value / 1000).toFixed(2);
                        distanceCell.textContent = distance + ' km';
                        vehicles[index].distance = parseFloat(distance);
                    } else {
                        distanceCell.textContent = 'N/A';
                        vehicles[index].distance = Infinity;
                    }
                });

                // Sort rows by distance
                rows.sort((a, b) => {
                    var distA = parseFloat(a.cells[4].textContent) || Infinity;
                    var distB = parseFloat(b.cells[4].textContent) || Infinity;
                    return distA - distB;
                });

                // Clear and repopulate tbody
                while (tbody.firstChild) {
                    tbody.removeChild(tbody.firstChild);
                }

                // Update row numbers and append sorted rows
                rows.forEach((row, index) => {
                    row.cells[0].textContent = index + 1;
                    tbody.appendChild(row);
                });
            } else {
                console.error('Distance Matrix failed:', status);
            }
        });
    }

    // Calculate distances when page loads
    window.onload = calculateDistances;
    </script>

</body>
</html>