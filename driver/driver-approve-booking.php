<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $d_id = $_SESSION['d_id'];

  // Update the path to your autoload.php
  require_once __DIR__ . '/../vendor/twilio/sdk/src/Twilio/autoload.php';
  use Twilio\Rest\Client;

  // Twilio credentials
  $sid = "AC5ffd837912b29c046a168da0e3d95869";
  $token = "fc71799a41c70659919e4ff0f5f2e315";
  $messagingServiceSid = "MG4bda8af2a2da8ce9070908cda97e9c35";

  // Accept Trip
  if(isset($_POST['accept_trip'])) {
      $b_id = $_GET['b_id'];
      $b_status = 'Ongoing';
      
      // Update booking status
      $query = "UPDATE tms_bookings SET b_status=? WHERE b_id=? AND d_id=?";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('sii', $b_status, $b_id, $d_id);
      $stmt->execute();
      
      // Update vehicle status to Busy
      $vehicle_query = "UPDATE tms_vehicle v 
                       JOIN tms_bookings b ON v.v_id = b.v_id 
                       SET v.v_status = 'Busy' 
                       WHERE b.b_id = ? AND b.d_id = ?";
      $vehicle_stmt = $mysqli->prepare($vehicle_query);
      $vehicle_stmt->bind_param('ii', $b_id, $d_id);
      $vehicle_stmt->execute();
      
      if($stmt && $vehicle_stmt) {
          $_SESSION['success'] = "Trip Accepted Successfully";

          // Fetch booking, user, driver, and vehicle details
          $booking_query = "SELECT b.*, 
                           CASE 
                               WHEN b.u_id IS NOT NULL THEN u.u_fname
                               ELSE JSON_UNQUOTE(JSON_EXTRACT(b.customer_details, '$.name'))
                           END as client_name,
                           CASE 
                               WHEN b.u_id IS NOT NULL THEN u.u_phone
                               ELSE JSON_UNQUOTE(JSON_EXTRACT(b.customer_details, '$.phone'))
                           END as client_phone,
                           d.d_fname, d.d_lname, d.d_phone, d.d_license,
                           v.v_reg_no
                           FROM tms_bookings b 
                           LEFT JOIN tms_user u ON b.u_id = u.u_id 
                           JOIN tms_driver d ON b.d_id = d.d_id
                           JOIN tms_vehicle v ON b.v_id = v.v_id
                           WHERE b.b_id = ?";
          $booking_stmt = $mysqli->prepare($booking_query);
          $booking_stmt->bind_param('i', $b_id);
          $booking_stmt->execute();
          $booking_result = $booking_stmt->get_result();
          $booking = $booking_result->fetch_assoc();

          // Prepare the message
          $message_body = "Your booking has been confirmed by the driver.\n\n";
          $message_body .= "Booking Details:\n";
          $message_body .= "Date: {$booking['b_date']}\n";
          $message_body .= "Pickup: {$booking['pickup_location']}\n";
          $message_body .= "Drop-off: {$booking['return_location']}\n";
          $message_body .= "Distance: {$booking['distance']} km\n";
          $message_body .= "Total Hire: {$booking['hire']}\n\n";
          $message_body .= "Driver Details:\n";
          $message_body .= "Name: {$booking['d_fname']} {$booking['d_lname']}\n";
          $message_body .= "Phone: {$booking['d_phone']}\n";
          $message_body .= "License: {$booking['d_license']}\n";
          $message_body .= "Vehicle Reg No: {$booking['v_reg_no']}\n";

          // Send SMS
          try {
              $twilio = new Client($sid, $token);
              $message = $twilio->messages->create(
                  $booking['client_phone'], // using the combined phone field
                  array(
                      "messagingServiceSid" => $messagingServiceSid,
                      "body" => $message_body
                  )
              );
              $_SESSION['success'] .= " and SMS confirmation sent to the customer.";
          } catch (Exception $e) {
              $_SESSION['error'] = "Trip accepted but failed to send SMS: " . $e->getMessage();
          }

          header("Location: driver-dashboard.php");
          exit();
      } else {
          $err = "Please Try Again Later";
      }
  }

  // Fetch booking details
  $b_id = $_GET['b_id'];
  $ret = "SELECT b.*, 
          CASE 
              WHEN b.u_id IS NOT NULL THEN u.u_fname
              ELSE JSON_UNQUOTE(JSON_EXTRACT(b.customer_details, '$.name'))
          END as client_name,
          CASE 
              WHEN b.u_id IS NOT NULL THEN u.u_phone
              ELSE JSON_UNQUOTE(JSON_EXTRACT(b.customer_details, '$.phone'))
          END as client_phone,
          u.u_addr
          FROM tms_bookings b 
          LEFT JOIN tms_user u ON b.u_id = u.u_id 
          WHERE b.b_id=? AND b.d_id=?";
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
                                 <input type="text" readonly value="<?php echo $row->client_name; ?>" class="form-control">
                             </div>
                             <div class="form-group">
                                 <label>Client Phone</label>
                                 <input type="text" readonly value="<?php echo $row->client_phone; ?>" class="form-control">
                             </div>
                             <div class="form-group">
                                 <label>Client Address</label>
                                 <input type="text" readonly value="<?php echo $row->u_addr ?? 'Not provided'; ?>" class="form-control">
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
