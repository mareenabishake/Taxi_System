<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$d_id = $_SESSION['d_id'];

// Update vehicle location
if (isset($_POST['update_location'])) {
    $v_location = $_POST['v_location'];
    
    // Get the vehicle assigned to this driver
    $query = "SELECT v.v_id FROM tms_vehicle v 
             INNER JOIN tms_driver d ON v.d_id = d.d_id 
             WHERE d.d_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $d_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vehicle = $result->fetch_object();
    
    if ($vehicle) {
        // Update vehicle location
        $update_query = "UPDATE tms_vehicle SET v_location = ? WHERE d_id = ?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param('si', $v_location, $d_id);
        
        if ($update_stmt->execute()) {
            $succ = "Location Updated Successfully";
        } else {
            $err = "Failed to update location";
        }
        $update_stmt->close();
    } else {
        $err = "No vehicle assigned to you";
    }
    $stmt->close();
}

// Get current vehicle location
$loc_query = "SELECT v.v_location, v.v_reg_no FROM tms_vehicle v 
             WHERE v.d_id = ?";
$loc_stmt = $mysqli->prepare($loc_query);
$loc_stmt->bind_param('i', $d_id);
$loc_stmt->execute();
$loc_result = $loc_stmt->get_result();
$current_vehicle = $loc_result->fetch_object();
$loc_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php');?>

<body id="page-top">
    <?php include("vendor/inc/nav.php");?>

    <div id="wrapper">
        <?php include("vendor/inc/sidebar.php");?>

        <div id="content-wrapper">
            <div class="container-fluid">
                <?php if(isset($succ)) { ?>
                    <script>
                        setTimeout(function() {
                            swal("Success!", "<?php echo $succ;?>", "success");
                        }, 100);
                    </script>
                <?php } ?>
                <?php if(isset($err)) { ?>
                    <script>
                        setTimeout(function() {
                            swal("Failed!", "<?php echo $err;?>", "error");
                        }, 100);
                    </script>
                <?php } ?>

                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="driver-dashboard.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Update Location</li>
                </ol>

                <div class="card">
                    <div class="card-header">
                        Update Vehicle Location
                    </div>
                    <div class="card-body">
                        <?php if($current_vehicle) { ?>
                            <form method="POST">
                                <div class="form-group">
                                    <label>Vehicle Registration Number</label>
                                    <input type="text" class="form-control" value="<?php echo $current_vehicle->v_reg_no; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Current Location</label>
                                    <input type="text" class="form-control" value="<?php echo $current_vehicle->v_location ?? 'Not set'; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>New Location</label>
                                    <input type="text" class="form-control" id="v_location" name="v_location" required>
                                </div>
                                <button type="submit" name="update_location" class="btn btn-success">Update Location</button>
                            </form>
                        <?php } else { ?>
                            <div class="alert alert-warning">
                                No vehicle is currently assigned to you.
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php include("vendor/inc/footer.php");?>
        </div>
    </div>

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
    <script src="vendor/js/sb-admin.min.js"></script>
    <script src="vendor/js/swal.js"></script>

    <!-- Google Maps Places API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz6zabR9k2B9hba52HNoHciRVW4B3gGbk&libraries=places"></script>
    <script>
    // Initialize Google Places Autocomplete
    function initAutocomplete() {
        var locationInput = document.getElementById('v_location');
        new google.maps.places.Autocomplete(locationInput);
    }

    // Call initAutocomplete when the page loads
    google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>

</body>
</html>
