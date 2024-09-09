<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $d_id = $_SESSION['d_id'];

  // Fetch driver's name based on the logged-in driver ID
  $driver_query = "SELECT d_fname, d_lname FROM tms_driver WHERE d_id = ?";
  $stmt = $mysqli->prepare($driver_query);
  $stmt->bind_param('i', $d_id);
  $stmt->execute();
  $stmt->bind_result($driver_fname, $driver_lname);
  $stmt->fetch();
  $stmt->close();
  
  $driver_name = $driver_fname . ' ' . $driver_lname;
?>
<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php');?>

<body id="page-top">

    <?php include("vendor/inc/nav.php");?>
    
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('vendor/inc/sidebar.php');?>

        <div id="content-wrapper">

            <div class="container-fluid">
                
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Bookings</a>
                    </li>
                    <li class="breadcrumb-item active">Manage</li>
                </ol>
                
                <!--Bookings-->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Manage Bookings
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Pickup Location</th>
                                        <th>Return Location</th>
                                        <th>Booking Date</th>
                                        <th>Vehicle Reg No</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php
                                    // Query to fetch bookings related to the logged-in driver
                                    $ret = "
                                    SELECT b.*, u.u_fname, u.u_lname, u.u_phone, v.v_reg_no
                                    FROM tms_bookings b
                                    INNER JOIN tms_user u ON b.u_id = u.u_id
                                    INNER JOIN tms_vehicle v ON b.v_id = v.v_id
                                    WHERE b.d_id = ? AND (b.b_status = 'Approved' OR b.b_status = 'Pending')
                                    ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->bind_param('i', $d_id);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $cnt = 1;
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><?php echo $row->u_fname;?> <?php echo $row->u_lname;?></td>
                                        <td><?php echo $row->u_phone;?></td>
                                        <td><?php echo $row->pickup_location;?></td>
                                        <td><?php echo $row->return_location;?></td>
                                        <td><?php echo $row->b_date;?></td>
                                        <td><?php echo $row->v_reg_no;?></td>
                                        <td><?php echo $row->hire;?></td>
                                        <td>
                                            <?php if($row->b_status == "Pending"){ 
                                                echo '<span class="badge badge-warning">'.$row->b_status.'</span>'; 
                                            } elseif($row->b_status == "Approved") {
                                                echo '<span class="badge badge-success">'.$row->b_status.'</span>';
                                            }?>
                                        </td>
                                        <td>
                                            <?php if($row->b_status == "Pending"){ ?>
                                                <a href="driver-approve-booking.php?b_id=<?php echo $row->b_id;?>" class="badge badge-success"><i class="fa fa-check"></i> Approve</a>
                                            <?php } elseif($row->b_status == "Approved") { ?>
                                                <a href="driver-end-trip.php?b_id=<?php echo $row->b_id;?>" class="badge badge-info"><i class="fa fa-stop"></i> End Trip</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $cnt++; } ?>

                                </tbody>
                            </table>
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
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="js/demo/datatables-demo.js"></script>

</body>
</html>
