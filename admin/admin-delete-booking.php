<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Delete Booking code
if (isset($_POST['delete_booking'])) {
    $u_id = $_GET['u_id'];
    $u_car_regno = $_POST['u_car_regno'];

    // Set the booking-related fields to NULL or empty string in tms_user
    $query = "UPDATE tms_user SET u_car_type=NULL, u_car_regno=NULL, u_car_driver=NULL, u_car_driver_contact=NULL, u_car_bookdate=NULL, u_car_pickup=NULL, u_car_drop=NULL, u_car_hire=NULL, u_car_book_status=NULL WHERE u_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $u_id);
    $stmt->execute();

    // If the booking is deleted successfully, update the vehicle status to 'Available'
    if ($stmt) {
        $update_query = "UPDATE tms_vehicle SET v_status='Available' WHERE v_reg_no=?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param('s', $u_car_regno);
        $update_stmt->execute();
        $update_stmt->close();

        $succ = "Booking Deleted and Vehicle Status Updated to Available";
    } else {
        $err = "Please Try Again Later";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('vendor/inc/head.php');?>

<body id="page-top">

    <!--Navigation Bar-->
    <?php include("vendor/inc/nav.php");?>
    

    <div id="wrapper">
        <!-- Sidebar -->
        <?php include("vendor/inc/sidebar.php");?>
        

        <div id="content-wrapper">
            <div class="container-fluid">
                <?php if (isset($succ)) { ?>
                <!--code for an alert-->
                <script>
                setTimeout(function() {
                        swal("Success!", "<?php echo $succ;?>", "success");
                    },
                    100);
                </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $err;?>", "error");
                    },
                    100);
                </script>
                <?php } ?>

                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Bookings</a>
                    </li>
                    <li class="breadcrumb-item active">Delete</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Delete Booking
                    </div>
                    <div class="card-body">
                        <!-- Form -->
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
                                <input type="text" readonly value="<?php echo $row->u_fname;?>" required class="form-control" name="u_fname">
                            </div>
                            <div class="form-group">
                                <label for="Last Name">Last Name</label>
                                <input type="text" readonly class="form-control" value="<?php echo $row->u_lname;?>" name="u_lname">
                            </div>
                            <div class="form-group">
                                <label for="Contact">Contact</label>
                                <input type="text" readonly class="form-control" value="<?php echo $row->u_phone;?>" name="u_phone">
                            </div>
                            <div class="form-group">
                                <label for="Address">Address</label>
                                <input type="text" readonly class="form-control" value="<?php echo $row->u_addr;?>" name="u_addr">
                            </div>
                            <div class="form-group">
                                <label for="Email address">Email address</label>
                                <input type="email" readonly value="<?php echo $row->u_email;?>" class="form-control" name="u_email">
                            </div>
                            <div class="form-group">
                                <label for="Vehicle Category">Vehicle Category</label>
                                <input type="text" readonly value="<?php echo $row->u_car_type;?>" class="form-control" name="u_car_type">
                            </div>
                            <div class="form-group">
                                <label for="Vehicle Registration Number">Vehicle Registration Number</label>
                                <input type="text" readonly value="<?php echo $row->u_car_regno;?>" class="form-control" name="u_car_regno">
                            </div>
                            <div class="form-group">
                                <label for="Driver Name">Driver Name</label>
                                <input type="text" readonly value="<?php echo $row->u_car_driver;?>" class="form-control" name="u_car_driver">
                            </div>
                            <div class="form-group">
                                <label for="Driver Contact No">Driver Contact No</label>
                                <input type="text" readonly value="<?php echo $row->u_car_driver_contact;?>" class="form-control" name="u_car_driver_contact">
                            </div>
                            <div class="form-group">
                                <label for="Booking Date">Booking Date</label>
                                <input type="date" readonly value="<?php echo $row->u_car_bookdate;?>" class="form-control" name="u_car_bookdate">
                            </div>
                            <div class="form-group">
                                <label for="Pickup">Pickup</label>
                                <input type="text" readonly value="<?php echo $row->u_car_pickup;?>" class="form-control" name="u_car_pickup">
                            </div>
                            <div class="form-group">
                                <label for="Drop">Drop</label>
                                <input type="text" readonly value="<?php echo $row->u_car_drop;?>" class="form-control" name="u_car_drop">
                            </div>
                            <div class="form-group">
                                <label for="Hire">Hire</label>
                                <input type="text" readonly value="<?php echo $row->u_car_hire;?>" class="form-control" name="u_car_hire">
                            </div>
                            <div class="form-group">
                                <label for="Booking Status">Booking Status</label>
                                <input type="text" readonly value="<?php echo $row->u_car_book_status;?>" class="form-control" name="u_car_book_status">
                            </div>
                            <button type="submit" name="delete_booking" class="btn btn-danger">Delete Booking</button>
                        </form>
                        
                        <?php }?>
                    </div>
                </div>

                <hr>

                <!-- Footer -->
                <?php include("vendor/inc/footer.php");?>
            </div>
            
        </div>
        

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        
        <!-- Logout code-->
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

        <!-- Page level plugin JavaScript code-->
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="js/demo/datatables-demo.js"></script>

    </div>
</body>
</html>
