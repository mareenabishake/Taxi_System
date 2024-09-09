 <?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $d_id = $_SESSION['d_id'];

  // Accept Trip
  if(isset($_POST['accept_trip'])) {
      $b_id = $_GET['b_id'];
      $b_status = 'Ongoing';
      
      $query = "UPDATE tms_bookings SET b_status=? WHERE b_id=? AND d_id=?";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('sii', $b_status, $b_id, $d_id);
      $stmt->execute();
      
      if($stmt) {
          $_SESSION['success'] = "Trip Accepted Successfully";
          header("Location: driver-dashboard.php");
          exit();
      } else {
          $err = "Please Try Again Later";
      }
  }

  // Fetch booking details
  $b_id = $_GET['b_id'];
  $ret = "select b.*, u.u_fname, u.u_lname, u.u_phone, u.u_addr 
          from tms_bookings b 
          join tms_user u on b.u_id = u.u_id 
          where b.b_id=? and b.d_id=?";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('ii', $b_id, $d_id);
  $stmt->execute();
  $res = $stmt->get_result();
  $row = $res->fetch_object();
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
                 <?php if(isset($err)) {?>
                     <!--This code for injecting error alert-->
                     <div class="alert alert-danger">
                         <strong>Error!</strong> <?php echo $err; ?>
                     </div>
                 <?php } ?>
                 
                 <!-- Breadcrumbs-->
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item">
                         <a href="#">Bookings</a>
                     </li>
                     <li class="breadcrumb-item active">Trip Details</li>
                 </ol>
                 <hr>
                 <div class="card">
                     <div class="card-header">
                         Trip Details
                     </div>
                     <div class="card-body">
                         <form method="POST">
                             <div class="form-group">
                                 <label>Client Name</label>
                                 <input type="text" readonly value="<?php echo $row->u_fname . ' ' . $row->u_lname; ?>" class="form-control">
                             </div>
                             <div class="form-group">
                                 <label>Client Phone</label>
                                 <input type="text" readonly value="<?php echo $row->u_phone; ?>" class="form-control">
                             </div>
                             <div class="form-group">
                                 <label>Client Address</label>
                                 <input type="text" readonly value="<?php echo $row->u_addr; ?>" class="form-control">
                             </div>
                             <div class="form-group">
                                 <label>Pickup Location</label>
                                 <input type="text" readonly value="<?php echo $row->pickup_location; ?>" class="form-control">
                             </div>
                             <div class="form-group">
                                 <label>Dropoff Location</label>
                                 <input type="text" readonly value="<?php echo $row->return_location; ?>" class="form-control">
                             </div>
                             <div class="form-group">
                                 <label>Booking Date</label>
                                 <input type="text" readonly value="<?php echo $row->b_date; ?>" class="form-control">
                             </div>
                             <button type="submit" name="accept_trip" class="btn btn-success">Accept Trip</button>
                         </form>
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
         <?php include("vendor/inc/logout.php");?>
         
         <!-- Bootstrap core JavaScript-->
         <script src="vendor/jquery/jquery.min.js"></script>
         <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

         <!-- Core plugin JavaScript-->
         <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

         <!-- Custom scripts for all pages-->
         <script src="js/sb-admin.min.js"></script>
         
 </body>
 </html>