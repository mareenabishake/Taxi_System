<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['u_id'];
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

                <!--Bookings-->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Available Vehicles
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vehicle Name</th>
                                        <th>Reg. No.</th>
                                        <th>Seats</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                <?php
                                    $ret="SELECT * FROM tms_vehicle WHERE v_status = 'Available'";
                                    $stmt= $mysqli->prepare($ret) ;
                                    $stmt->execute() ;
                                    $res=$stmt->get_result();
                                    $cnt=1;
                                    while($row=$res->fetch_object())
                                    {
                                ?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><?php echo $row->v_name;?></td>
                                        <td><?php echo $row->v_reg_no;?></td>
                                        <td><?php echo $row->v_pass_no;?></td>
                                        <td><?php echo $row->v_category;?></td>
                                        <td>
                                            <a href="usr-book-vehicle.php?v_id=<?php echo $row->v_id;?>" class="badge badge-success"><i class="fa fa-book"></i> Book</a>
                                        </td>
                                    </tr>
                                <?php  $cnt = $cnt +1; }?>
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

</body>
</html>