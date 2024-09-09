<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $d_id = $_SESSION['d_id'];
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
                        <a href="#">Feedbacks</a>
                    </li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
                
                <!-- Feedbacks Table -->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-comments"></i>
                        Trip Feedbacks
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Trip ID</th>
                                        <th>User Name</th>
                                        <th>Rating</th>
                                        <th>Feedback</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT tf.*, u.u_fname, u.u_lname 
                                            FROM tms_trip_feedback tf
                                            JOIN tms_user u ON tf.u_id = u.u_id
                                            WHERE tf.d_id = ?
                                            ORDER BY tf.f_date DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->bind_param('i', $d_id);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $cnt = 1;
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo $row->b_id;?></td>
                                            <td><?php echo $row->u_fname . ' ' . $row->u_lname;?></td>
                                            <td><?php echo $row->f_rating;?></td>
                                            <td><?php echo $row->f_content;?></td>
                                            <td><?php echo $row->f_date;?></td>
                                        </tr>
                                    <?php
                                        $cnt++;
                                    }
                                    ?>
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
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="js/demo/datatables-demo.js"></script>

</body>
</html>