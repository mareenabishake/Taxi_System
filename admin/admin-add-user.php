<?php
session_start();
include('vendor/inc/config.php'); 
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendWelcomeEmail($userEmail, $userName, $userPassword) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hndteamwattala@gmail.com';
        $mail->Password   = 'brax ysds ffrx ojer'; // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('hndteamwattala@gmail.com', 'City Taxi');
        $mail->addAddress($userEmail, $userName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Our Service';
        $mail->Body    = "Hello $userName,<br><br>
                          Thank you for registering with our service. Your account has been successfully created.<br><br>
                          Your login details:<br>
                          Email: $userEmail<br>
                          Password: $userPassword<br><br>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

function emailExists($mysqli, $email, $table) {
    $emailColumn = 'u_email'; // default for tms_user
    
    if ($table === 'tms_driver') {
        $emailColumn = 'd_email';
    } else if ($table === 'tms_operator') {
        $emailColumn = 'o_email';
    }
    
    $query = "SELECT COUNT(*) as count FROM $table WHERE $emailColumn = ?";
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'] > 0;
    }
    return false;
}

// Add User Code
if (isset($_POST['add_user'])) {
    $u_fname = $_POST['u_fname'];
    $u_lname = $_POST['u_lname'];
    $u_phone = $_POST['u_phone'];
    $u_license_or_ID = $_POST['u_license_or_ID'];
    $u_addr = $_POST['u_addr'];
    $u_email = $_POST['u_email'];
    $u_pwd = $_POST['u_pwd'];

    // Check if email already exists
    if (emailExists($mysqli, $u_email, 'tms_user')) {
        $err = "Error: Email address already registered. Please use a different email.";
    } else {
        // Hash the password using MD5
        $hashed_pwd = md5($u_pwd);

        // Prepare the SQL query
        $query = "INSERT INTO tms_user (u_fname, u_lname, u_phone, u_license_or_ID, u_addr, u_email, u_pwd) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            // Bind the parameters to the SQL query
            $stmt->bind_param('sssssss', $u_fname, $u_lname, $u_phone, $u_license_or_ID, $u_addr, $u_email, $hashed_pwd);

            if ($stmt->execute()) {
                if (sendWelcomeEmail($u_email, $u_fname . ' ' . $u_lname, $u_pwd)) {
                    $succ = "User Added and Welcome Email Sent";
                } else {
                    $succ = "User Added but Failed to Send Welcome Email";
                }
            } else {
                $err = "Error: Could not execute the query. Please try again.";
            }

            $stmt->close();
        } else {
            $err = "Error: Could not prepare the query. " . $mysqli->error;
        }
    }
}

// Close the database connection
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php'); ?>

<body id="page-top">

    <!--Navigation Bar-->
    <?php include("vendor/inc/nav.php"); ?>
    

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("vendor/inc/sidebar.php"); ?>
        
        <div id="content-wrapper">

            <div class="container-fluid">
                <?php if (isset($succ)) { ?>
                <!--Code for an alert-->
                <script>
                setTimeout(function() {
                        swal("Success!", "<?php echo $succ; ?>!", "success");
                    },
                    100);
                </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $err; ?>!", "error");
                    },
                    100);
                </script>
                <?php } ?>

                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Users</a>
                    </li>
                    <li class="breadcrumb-item active">Add User</li>
                </ol>
                <hr>

                <div class="card">
                    <div class="card-header">
                        Add User
                    </div>
                    <div class="card-body">
                        <!--User Form-->
                        <form method="POST">
                            <div class="form-group">
                                <label for="u_fname">First Name</label>
                                <input type="text" required class="form-control" id="u_fname" name="u_fname">
                            </div>
                            <div class="form-group">
                                <label for="u_lname">Last Name</label>
                                <input type="text" class="form-control" id="u_lname" name="u_lname">
                            </div>
                            <div class="form-group">
                                <label for="u_phone">Contact</label>
                                <input type="text" class="form-control" id="u_phone" name="u_phone">
                            </div>
                            <div class="form-group">
                                <label for="u_license_or_ID">NIC Number</label>
                                <input type="text" class="form-control" id="u_license_or_ID" name="u_license_or_ID">
                            </div>
                            <div class="form-group">
                                <label for="u_addr">Address</label>
                                <input type="text" class="form-control" id="u_addr" name="u_addr">
                            </div>

                            <div class="form-group">
                                <label for="u_email">Email address</label>
                                <input type="email" class="form-control" id="u_email" name="u_email">
                            </div>
                            <div class="form-group">
                                <label for="u_pwd">Password</label>
                                <input type="password" class="form-control" name="u_pwd" id="u_pwd">
                            </div>

                            <button type="submit" name="add_user" class="btn btn-success">Add User</button>
                        </form>
                        
                    </div>
                </div>

                <hr>

                <!--Footer -->
                <?php include("vendor/inc/footer.php"); ?>

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
        
        <!-- Inject Sweet alert js -->
        <script src="vendor/js/swal.js"></script>

</body>
</html>
