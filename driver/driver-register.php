<!--Server Side Scripting To inject Login-->
<?php
session_start();
include('vendor/inc/config.php');

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

// Add Driver
if (isset($_POST['add_driver'])) {
    $d_fname = $_POST['d_fname'];
    $d_lname = $_POST['d_lname'];
    $d_phone = $_POST['d_phone'];
    $d_license = $_POST['d_license'];
    $d_addr = $_POST['d_addr'];
    $d_email = $_POST['d_email'];
    $d_pwd = $_POST['d_pwd'];

    // Check if email already exists
    if (emailExists($mysqli, $d_email, 'tms_driver')) {
        $err = "Error: Email address already registered. Please use a different email.";
    } else {
        // Existing registration code continues here
        $hashed_pwd = md5($d_pwd);
        $query = "INSERT INTO tms_driver (d_fname, d_lname, d_phone, d_license, d_addr, d_email, d_pwd) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        
        if ($stmt) {
            // Bind the parameters to the SQL query
            $stmt->bind_param('sssssss', $d_fname, $d_lname, $d_phone, $d_license, $d_addr, $d_email, $hashed_pwd);

            // Execute the query
            if ($stmt->execute()) {
                if (sendWelcomeEmail($d_email, $d_fname . ' ' . $d_lname, $d_pwd)) {
                    $succ = "Driver Account Created and Welcome Email Sent. Proceed To Log In";
                } else {
                    $succ = "Driver Account Created but Failed to Send Welcome Email. Proceed To Log In";
                }
            } else {
                $err = "Error: Could not execute the query. " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            $err = "Error: Could not prepare the query. " . $mysqli->error;
        }
    }

    // Close the database connection
    $mysqli->close();
}
?>
<!--End Server Side Scripting-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Transport Management System, Saccos, Matwana Culture">
    <meta name="author" content="MartDevelopers ">

    <title>City Taxi Driver - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="vendor/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">
    <?php if (isset($succ)) { ?>
    <!--This code for injecting an alert-->
    <script>
    setTimeout(function() {
            swal("Success!", "<?php echo $succ; ?>", "success");
        },
        100);
    </script>
    <?php } ?>
    <?php if (isset($err)) { ?>
    <!--This code for injecting an alert-->
    <script>
    setTimeout(function() {
            swal("Failed!", "<?php echo $err; ?>", "error");
        },
        100);
    </script>
    <?php } ?>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
            <div class="card-header">Create An Account With Us</div>
            <div class="card-body">
                <!--Start Form-->
                <form method="post">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-label-group">
                                    <input type="text" required class="form-control" id="exampleInputEmail1" name="d_fname">
                                    <label for="firstName">First name</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-label-group">
                                    <input type="text" class="form-control" id="u_lname" name="d_lname">
                                    <label for="u_lname">Last name</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-label-group">
                                    <input type="text" class="form-control" id="u_phone" name="d_phone">
                                    <label for="u_phone">Contact</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-label-group">
                                    <input type="text" class="form-control" id="u_license" name="d_license">
                                    <label for="u_license">Licence No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" class="form-control" id="u_addr" name="d_addr">
                            <label for="u_addr">Address</label>
                        </div>
                    </div>
                    <div class="form-group" style="display:none">
                        <div class="form-label-group">
                            <input type="text" class="form-control" id="exampleInputEmail1" value="Driver" name="u_category">
                            <label for="inputEmail">User Category</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" class="form-control" name="d_email">
                            <label for=" inputEmail">Email address</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <input type="password" class="form-control" name="d_pwd" id="exampleInputPassword1">
                                    <label for="inputPassword">Password</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="add_driver" class="btn btn-success">Create Account</button>
                </form>
                <!--End Form-->
                <div class="text-center">
                    <a class="d-block small mt-3" href="index.php">Login Page</a>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!--Inject Sweet alert js-->
    <script src="vendor/js/swal.js"></script>

</body>
</html>
