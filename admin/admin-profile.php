 <?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['a_id'];
  
  if(isset($_POST['change_pwd']))
    {

            $a_pwd=$_POST['a_pwd'];
            $query=" UPDATE tms_admin SET a_pwd = ? WHERE a_id = ?";
            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('si', $a_pwd, $aid);
            $stmt->execute();
                if($stmt)
                {
                    $succ = "Password Changed";
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
                         swal("Failed!", "<?php echo $err;?>!", "Failed");
                     },
                     100);
                 </script>
                 
                 <?php } ?>
                 
                 <!-- Breadcrumbs-->
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item">
                         <a href="#">Dashboard</a>
                     </li>
                     <li class="breadcrumb-item active">Admin Update Password</li>
                 </ol>
                 <hr>
                 
                 <div class="card col-md-12">
                     <div class="card-body">
                         <div class="card">
                             <h2> Change Password</h2>
                             <div class="card-body">

                                 <form method="post">
                                     <div class="form-group">
                                         <label for="Old Password">Old Password</label>
                                         <input type="password" name="" class="form-control">
                                     </div>
                                     <div class="form-group">
                                         <label for="New Password">New Password</label>
                                         <input type="password" name="a_pwd" class="form-control">
                                     </div>
                                     <div class="form-group">
                                         <label for="Confirm New Password">Confirm New Password</label>
                                         <input type="password" class="form-control" name="" required>
                                     </div>
                                     <button type="submit" name="change_pwd" class="btn btn-success">Submit</button>
                                 </form>
                             </div>
                         </div>
                     </div>
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