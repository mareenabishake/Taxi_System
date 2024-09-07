<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['u_id'];
  $trip_id = $_GET['u_id']; // Get the trip ID from the URL

  // Fetch trip details
  $ret="SELECT * FROM tms_user WHERE u_id=?";
  $stmt= $mysqli->prepare($ret);
  $stmt->bind_param('i', $trip_id);
  $stmt->execute();
  $res=$stmt->get_result();
  $trip_details = $res->fetch_object();

  //Add Trip Feedback
  if(isset($_POST['give_trip_feedback']))
    {
            $tf_cname = $_POST['tf_cname']; // Customer name
            $tf_dname = $_POST['tf_dname']; // Driver name
            $tf_vname = $_POST['tf_vname']; // Vehicle name/type
            $tf_date = date('Y-m-d'); // Current date
            $tf_from = $_POST['tf_from']; // Pickup location
            $tf_to = $_POST['tf_to']; // Drop-off location
            $tf_feedback_text = $_POST['tf_feedback_text']; // User's feedback
            
            $query="INSERT INTO tms_trip_feedback (tf_cname, tf_dname, tf_vname, tf_date, tf_from, tf_to, tf_feedback_text) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('sssssss', $tf_cname, $tf_dname, $tf_vname, $tf_date, $tf_from, $tf_to, $tf_feedback_text);
            $stmt->execute();
                if($stmt)
                {
                    $succ = "Trip Feedback Submitted";
                }
                else 
                {
                    $err = "Please Try Again Later";
                }
            }
?>

<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php');?>

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
                <?php if(isset($succ)) {?>
                <!--This code for injecting an alert-->
                <script>
                setTimeout(function() {
                        swal("Success!", "<?php echo $succ;?>!", "success");
                    },
                    100);
                </script>

                <?php } ?>
                <?php if(isset($err)) {?>
                <!--This code for injecting an alert-->
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $err;?>!", "Failed");
                    },
                    100);
                </script>

                <?php } ?>
                
                
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="user-dashboard.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item ">Trip Feedback</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Give Trip Feedback
                    </div>
                    <div class="card-body">
                        <!--Add Trip Feedback Form-->
                        <form method="POST">
                            <div class="form-group">
                                <label for="tf_cname">Customer Name</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $trip_details->u_fname;?> <?php echo $trip_details->u_lname;?>" id="tf_cname" name="tf_cname">
                            </div>
                            <div class="form-group">
                                <label for="tf_dname">Driver Name</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $trip_details->u_car_driver;?>" id="tf_dname" name="tf_dname">
                            </div>
                            <div class="form-group">
                                <label for="tf_vname">Vehicle Type</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $trip_details->u_car_type;?>" id="tf_vname" name="tf_vname">
                            </div>
                            <div class="form-group">
                                <label for="tf_from">Pickup Location</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $trip_details->u_car_pickup;?>" id="tf_from" name="tf_from">
                            </div>
                            <div class="form-group">
                                <label for="tf_to">Drop-off Location</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $trip_details->u_car_drop;?>" id="tf_to" name="tf_to">
                            </div>
                            <div class="form-group">
                                <label for="tf_feedback_text">Your Feedback</label>
                                <textarea class="form-control" id="tf_feedback_text" name="tf_feedback_text" rows="5" maxlength="255" required></textarea>
                            </div>
                            <button type="submit" name="give_trip_feedback" class="btn btn-success">Submit Trip Feedback</button>
                        </form>
                        <!-- End Form-->
                    </div>
                </div>

                <hr>

                
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

        <!-- Custom scripts for all pages-->
        <script src="vendor/js/sb-admin.min.js"></script>

        <!--INject Sweet alert js-->
        <script src="vendor/js/swal.js"></script>
        
</body>
</html>
