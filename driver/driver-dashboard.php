<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$d_id = $_SESSION['d_id'];

if(isset($_POST['update_vehicle_status']) && isset($_POST['v_id'])) {
    $v_status = $_POST['v_status'];
    $v_id = $_POST['v_id'];
    
    // Verify that this vehicle belongs to the logged-in driver
    $query = "UPDATE tms_vehicle SET v_status = ? WHERE v_id = ? AND d_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sii', $v_status, $v_id, $d_id);
    
    if($stmt->execute()) {
        $_SESSION['success'] = "Vehicle status updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update vehicle status";
    }
    
    // Redirect to clear POST data
    header("Location: driver-dashboard.php");
    exit();
}

if(isset($_SESSION['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            ' . $_SESSION['success'] . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>';
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Vehicle Booking System Transport Saccos, Matatu Industry">
    <meta name="author" content="MartDevelopers">

    <title>City Taxi - Driver Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="vendor/css/sb-admin.css" rel="stylesheet">

    <style>
        .alert-dismissible {
            padding-right: 4rem;
        }
    </style>

</head>

<body id="page-top">
    <!--Start Navigation Bar-->
    <?php include("vendor/inc/nav.php");?>
    <!--Navigation Bar-->

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("vendor/inc/sidebar.php");?>
        <!--End Sidebar-->
        <div id="content-wrapper">

            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="driver-dashboard.php">Dashboard</a>
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
                                <div class="mr-5">Driver Profile</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="driver-profile.php">
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
                                    <i class="fas fa-fw fa-taxi"></i>
                                </div>
                                <?php
                                    //code for summing up number of assigned trips
                                    $result = "
                                    SELECT COUNT(*)
                                    FROM tms_bookings
                                    WHERE d_id = ? AND (b_status = 'Approved' OR b_status = 'Ongoing')
                                    ";
                                    $stmt = $mysqli->prepare($result);
                                    $stmt->bind_param('i', $d_id);
                                    $stmt->execute();
                                    $stmt->bind_result($assigned_trips);
                                    $stmt->fetch();
                                    $stmt->close();
                                ?>
                                <div class="mr-5"><span class="badge badge-danger"><?php echo $assigned_trips;?></span> Assigned Trips</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="driver-manage-booking.php">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Vehicle Status Update -->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-car"></i>
                        Update Vehicle Status
                    </div>
                    <div class="card-body">
                        <?php
                        // Get the vehicle assigned to this driver
                        $vehicle_query = "SELECT v_id, v_reg_no, v_status FROM tms_vehicle WHERE d_id = ? LIMIT 1";
                        $stmt = $mysqli->prepare($vehicle_query);
                        $stmt->bind_param('i', $d_id);
                        $stmt->execute();
                        $vehicle_result = $stmt->get_result();
                        $vehicle = $vehicle_result->fetch_object();
                        
                        if($vehicle) {
                        ?>
                            <form method="POST">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Vehicle Reg No:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control-plaintext" readonly value="<?php echo $vehicle->v_reg_no; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Current Status:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="v_status">
                                            <option value="Available" <?php echo ($vehicle->v_status == 'Available') ? 'selected' : ''; ?>>Available</option>
                                            <option value="Busy" <?php echo ($vehicle->v_status == 'Busy') ? 'selected' : ''; ?>>Busy</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="v_id" value="<?php echo $vehicle->v_id; ?>">
                                <input type="hidden" name="update_vehicle_status" value="1">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </div>
                            </form>
                        <?php } else { ?>
                            <div class="alert alert-info">No vehicle is currently assigned to you.</div>
                        <?php } ?>
                    </div>
                </div>
                
                <!--Bookings-->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Assigned Trips
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Booking Date</th>
                                        <th>Pickup Location</th>
                                        <th>Return Location</th>
                                        <th>Distance (km)</th>
                                        <th>Hire</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php
                                    // Fetch bookings related to the logged-in driver
                                    $ret = "SELECT b.b_id, b.b_date, b.pickup_location, b.return_location, b.distance, b.hire, b.b_status
                                            FROM tms_bookings b
                                            WHERE b.d_id = ?
                                            ORDER BY b.b_date DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->bind_param('i', $d_id);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $cnt = 1;
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo $row->b_date;?></td>
                                            <td><?php echo $row->pickup_location;?></td>
                                            <td><?php echo $row->return_location;?></td>
                                            <td><?php echo $row->distance;?></td>
                                            <td><?php echo $row->hire;?></td>
                                            <td>
                                                <?php 
                                                if($row->b_status == "Pending"){ 
                                                    echo '<span class="badge badge-warning">'.$row->b_status.'</span>'; 
                                                } else { 
                                                    echo '<span class="badge badge-success">'.$row->b_status.'</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php $cnt++; } ?>
                                </tbody>
                            </table>
                        </div>
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
                    <a class="btn btn-danger" href="driver-logout.php">Logout</a>
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

</body>
</html>
