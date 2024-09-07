 <?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['a_id'];
  //Add Booking Code
  if(isset($_POST['approve_booking']))
    {
            $u_id = $_GET['u_id'];
            $u_car_book_status  = $_POST['u_car_book_status'];
            $query="update tms_user set  u_car_book_status=? where u_id=?";
            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('si',  $u_car_book_status, $u_id);
            $stmt->execute();
                if($stmt)
                {
                    $succ = "Booking Approved";
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

     <!--Navigation Bar-->
     <?php include("vendor/inc/nav.php");?>
     

     <div id="wrapper">

         <!-- Sidebar -->
         <?php include("vendor/inc/sidebar.php");?>
        
         <div id="content-wrapper">
             
             <div class="container-fluid">
                 <?php if(isset($succ)) {?>
                 <!--Code for an alert-->
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
                         swal("Failed!", "<?php echo $err;?>!", "Failed");
                     },
                     100);
                 </script>

                 <?php } ?>
                 
                 
                 <!-- Breadcrumbs-->
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item">
                         <a href="#">Bookings</a>
                     </li>
                     <li class="breadcrumb-item active">Approve</li>
                 </ol>
                 <hr>
                 <div class="card">
                     <div class="card-header">
                         Approve Booking
                     </div>
                     <div class="card-body">
                         <!--User Form-->
                         <?php
            $aid=$_GET['u_id'];
            $ret="select * from tms_user where u_id=?";
            $stmt= $mysqli->prepare($ret) ;
            $stmt->bind_param('i',$aid);
            $stmt->execute() ;
            $res=$stmt->get_result();
            while($row=$res->fetch_object())
        {
        ?>
                         
                         <form method="POST">
                             <div class="form-group">
                                 <label for="First Name">First Name</label>
                                 <input type="text" readonly value="<?php echo $row->u_fname;?>" required class="form-control" id="First Name" name="u_fname">
                             </div>
                             <div class="form-group">
                                 <label for="Last Name">Last Name</label>
                                 <input type="text" readonly class="form-control" value="<?php echo $row->u_lname;?>" id="Last Name" name="u_lname">
                             </div>
                             <div class="form-group">
                                 <label for="Contact">Contact</label>
                                 <input type="text" readonly class="form-control" value="<?php echo $row->u_phone;?>" id="Contact" name="u_phone">
                             </div>
                             <div class="form-group">
                                 <label for="Address">Address</label>
                                 <input type="text" readonly class="form-control" value="<?php echo $row->u_addr;?>" id="Address" name="u_addr">
                             </div>

                             <div class="form-group" style="display:none">
                                 <label for="Category">Category</label>
                                 <input type="text" readonly class="form-control" id="Category" value="User" name="u_category">
                             </div>

                             <div class="form-group">
                                 <label for="Email address">Email address</label>
                                 <input type="email" readonly value="<?php echo $row->u_email;?>" class="form-control" name="u_email">
            </div>

            <div class=" form-group">
                                 <label for="Vehicle Category">Vehicle Category</label>
                                 <input type="text" readonly value="<?php echo $row->u_car_type;?>" class="form-control" name="u_car_type">
                             </div>
                             
                             <div class="form-group">
                                 <label for="Vehicle Registration NUmber">Vehicle Registration NUmber</label>
                                 <input type="text" readonly value="<?php echo $row->u_car_regno;?>" class="form-control" name="u_car_category">
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
                                 <input type="date" readonly value="<?php echo $row->u_car_bookdate;?>" class="form-control" id="Booking Date" name="u_car_bookdate">
                             </div>

                             <div class="form-group">
                                 <label for="Booking Status">Booking Status</label>
                                 <select class="form-control" name="u_car_book_status" id="Booking Status">
                                     <option>Approved</option>
                                     <option>Pending</option>
                                 </select>
                             </div>

                             <button type="submit" name="approve_booking" class="btn btn-success">Approve Booking</button>
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
         
 </body>
 </html>