<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['u_id'];

// Fetch user details
if (isset($_GET['u_id']) && isset($_GET['amount'])) {
    $u_id = $_GET['u_id'];
    $amount = urldecode($_GET['amount']);
} else {
    $error_message = "Missing required parameters.";
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['make_payment'])) {
        // Process payment (implement your payment gateway logic here)
        // Update payment status in the database
        
        // For demonstration, we'll just set a success message
        $_SESSION['success_msg'] = "Payment successful! Thank you for your payment.";
        
        // Redirect to the dashboard
        header("Location: user-dashboard.php");
        exit();
    } elseif (isset($_POST['cancel_payment'])) {
        // Redirect to the manage bookings page if payment is cancelled
        header("Location: user-manage-booking.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include("vendor/inc/head.php");?>

<body id="page-top">
    <?php include("vendor/inc/nav.php");?>

    <div id="wrapper">
        <?php include("vendor/inc/sidebar.php");?>
        <div id="content-wrapper">
            <div class="container-fluid">
                <h2 class="mb-4 text-center">Payment Gateway</h2>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php else: ?>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="post" action="">
                                <?php
                                $aid = $_SESSION['u_id'];
                                $ret = "SELECT * FROM tms_user WHERE u_id=?";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->bind_param('i', $aid);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($row = $res->fetch_object()) {
                                ?>
                                <div class="form-group">
                                    <label for="client_name">Client Name</label>
                                    <input type="text" class="form-control" id="client_name" name="client_name" value="<?php echo $row->u_fname . ' ' . $row->u_lname; ?>" readonly>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $amount; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="card_number">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="cvv">CVV</label>
                                        <input type="text" class="form-control" id="cvv" name="cvv" required>
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <button type="submit" name="make_payment" class="btn btn-primary mr-2">Make Payment</button>
                                    <button type="button" onclick="window.location.href='user-manage-booking.php';" class="btn btn-secondary">Cancel Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php include("vendor/inc/footer.php");?>
        </div>
    </div>

    <!-- Scroll to Top Button and Logout Modal -->
    <!-- ... (include the same scripts as in the previous file) ... -->
</body>
</html>
