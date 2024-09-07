<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid=$_SESSION['a_id'];

// Add Vehicle Code
if(isset($_POST['add_veh'])) {

    $v_name = $_POST['v_name'];
    $v_reg_no = $_POST['v_reg_no'];
    $v_category = $_POST['v_category'];
    $v_pass_no = $_POST['v_pass_no'];
    $v_status = $_POST['v_status'];
    $v_driver = $_POST['v_driver'];
    $v_driver_contact = $_POST['v_driver_contact'];
    $v_cost = $_POST['v_cost'];
    $v_dpic = $_FILES["v_dpic"]["name"];

    // Move uploaded file to the appropriate directory
    move_uploaded_file($_FILES["v_dpic"]["tmp_name"], "../vendor/img/".$_FILES["v_dpic"]["name"]);

    // Prepare the SQL query
    $query = "INSERT INTO tms_vehicle (v_name, v_pass_no, v_reg_no, v_driver, v_driver_contact, v_category, v_cost, v_dpic, v_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    // Bind the parameters to the SQL query
    $stmt->bind_param('sssssssss', $v_name, $v_pass_no, $v_reg_no, $v_driver, $v_driver_contact, $v_category, $v_cost, $v_dpic, $v_status);

    
    if($stmt->execute()) {
        $succ = "Vehicle Added";
    } else {
        $err = "Please Try Again Later";
    }
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
                <?php if(isset($succ)) {?>
                <!--code for an alert-->
                <script>
                setTimeout(function() {
                        swal("Success!", "<?php echo $succ;?>!", "success");
                    },
                    100);
                </script>

                <?php } ?>
                <?php if(isset($err)) {?>
                
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $err;?>!", "error");
                    },
                    100);
                </script>
                
                <?php } ?>
                
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Vehicles</a>
                    </li>
                    <li class="breadcrumb-item active">Add Vehicle</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Add Vehicle
                    </div>
                    
                    <div class="card-body">
                        <!--Vehicle Form-->
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="v_name">Vehicle Name</label>
                                <input type="text" required class="form-control" id="v_name" name="v_name">
                            </div>
                            <div class="form-group">
                                <label for="v_reg_no">Vehicle Registration Number</label>
                                <input type="text" required class="form-control" id="v_reg_no" name="v_reg_no">
                            </div>
                            <div class="form-group">
                                <label for="v_pass_no">Number Of Seats</label>
                                <input type="text" required class="form-control" id="v_pass_no" name="v_pass_no">
                            </div>
                            <div class="form-group">
                                <label for="v_driver">Driver Name</label>
                                <select class="form-control" name="v_driver" id="v_driver" required>
                                    <option value="" disabled selected>Select a Driver</option>
                                    <?php
                                    $ret = "SELECT * FROM tms_user WHERE u_category = 'Driver'";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while($row = $res->fetch_object()) {
                                    ?>
                                    <option value="<?php echo $row->u_fname . ' ' . $row->u_lname;?>" 
                                            data-contact="<?php echo $row->u_phone;?>">
                                        <?php echo $row->u_fname;?> <?php echo $row->u_lname;?>
                                    </option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="v_driver_contact">Driver Contact No</label>
                                <input type="text" required class="form-control" id="v_driver_contact" name="v_driver_contact">
                            </div>

                            <div class="form-group">
                                <label for="v_category">Vehicle Category</label>
                                <select class="form-control" name="v_category" id="v_category">
                                    <option>Bus</option>
                                    <option>Sedan</option>
                                    <option>SUV</option>
                                    <option>Van</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="v_cost">Vehicle Cost (Per 1 Km)</label>
                                <input type="text" required class="form-control" id="v_cost" name="v_cost">
                            </div>

                            <div class="form-group">
                                <label for="v_status">Vehicle Status</label>
                                <select class="form-control" name="v_status" id="v_status">
                                    <option>Available</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="v_dpic">Vehicle Picture</label>
                                <input type="file" class="btn btn-success" id="v_dpic" name="v_dpic" required>
                            </div>

                            <button type="submit" name="add_veh" class="btn btn-success">Add Vehicle</button>
                        </form>
                        
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

        <!-- Script for Auto-filling Driver Contact Number -->
        <script>
            document.getElementById('v_driver').addEventListener('change', function() {
                var selectedDriver = this.options[this.selectedIndex];
                var contactNumber = selectedDriver.getAttribute('data-contact');
                document.getElementById('v_driver_contact').value = contactNumber;
            });
        </script>
</body>
</html>
