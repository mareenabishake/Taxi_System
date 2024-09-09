<?php
include('vendor/inc/config.php');

$v_id = isset($_POST['v_id']) ? $_POST['v_id'] : '';
$v_category = isset($_POST['v_category']) ? $_POST['v_category'] : '';

// First, get the vehicle details from tms_vehicle table
$vehicle_query = "SELECT v_id, v_reg_no, v_category, d_id FROM tms_vehicle WHERE v_id = ? OR v_category = ?";
$vehicle_stmt = $mysqli->prepare($vehicle_query);
$vehicle_stmt->bind_param('is', $v_id, $v_category);
$vehicle_stmt->execute();
$vehicle_result = $vehicle_stmt->get_result();
$vehicle_row = $vehicle_result->fetch_assoc();

if ($vehicle_row) {
    $d_id = $vehicle_row['d_id'];
    $v_reg_no = $vehicle_row['v_reg_no'];
    $v_category = $vehicle_row['v_category'];

    // Now, get the driver details from tms_driver table
    $driver_query = "SELECT d_fname, d_lname, d_phone FROM tms_driver WHERE d_id = ?";
    $driver_stmt = $mysqli->prepare($driver_query);
    $driver_stmt->bind_param('i', $d_id);
    $driver_stmt->execute();
    $driver_result = $driver_stmt->get_result();
    $driver_row = $driver_result->fetch_assoc();

    if ($driver_row) {
        $driver_details = array(
            'driver_name' => $driver_row['d_fname'] . ' ' . $driver_row['d_lname'],
            'driver_contact' => $driver_row['d_phone'],
            'd_id' => $d_id,
            'v_reg_no' => $v_reg_no,
            'v_category' => $v_category
        );
        echo json_encode($driver_details);
    } else {
        echo json_encode(array('error' => 'No driver found for this vehicle.'));
    }
} else {
    echo json_encode(array('error' => 'No vehicle found with the given details.'));
}
?>
